import React, { useState, useRef, useEffect } from 'react';
import { useAuth } from '../context/AuthContext';

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const PracticeChat = () => {
    const { user } = useAuth();
    const [messages, setMessages] = useState([
        { role: 'assistant', content: '¡Hola! Soy Maestro. Estoy aquí para ayudarte a practicar tu español. ¿De qué te gustaría hablar hoy?' }
    ]);
    const [input, setInput] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [isRecording, setIsRecording] = useState(false);
    const messagesEndRef = useRef(null);
    const mediaRecorderRef = useRef(null);
    const audioChunksRef = useRef([]);

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    };

    useEffect(() => {
        scrollToBottom();
    }, [messages, isLoading]);

    const handleSend = async () => {
        if (!input.trim()) return;

        const userMessage = { role: 'user', content: input };
        const updatedMessages = [...messages, userMessage];
        setMessages(updatedMessages);
        setInput('');
        setIsLoading(true);

        try {
            const response = await fetch(`${API_BASE}/ai/chat-practice`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: userMessage.content,
                    history: messages.slice(-6) // Send last 6 messages as context
                })
            });

            const data = await response.json();

            if (response.ok && data.reply) {
                setMessages([...updatedMessages, { role: 'assistant', content: data.reply }]);
            } else {
                setMessages([...updatedMessages, { role: 'assistant', content: 'Lo siento, tuve un problema de conexión. ¿Podemos intentarlo de nuevo?' }]);
            }
        } catch (error) {
            console.error('Chat error:', error);
            setMessages([...updatedMessages, { role: 'assistant', content: 'Error de red. Intenta de nuevo.' }]);
        } finally {
            setIsLoading(false);
        }
    };

    const sendAudioMessage = async (base64Audio, mimeType) => {
        const userMessage = { role: 'user', content: '🎤 Mensaje de audio enviado' };
        const updatedMessages = [...messages, userMessage];
        setMessages(updatedMessages);
        setIsLoading(true);

        try {
            const response = await fetch(`${API_BASE}/ai/chat-practice`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: null,
                    audio_data: base64Audio,
                    mime_type: mimeType,
                    history: messages.slice(-6)
                })
            });

            const data = await response.json();

            if (response.ok && data.reply) {
                setMessages([...updatedMessages, { role: 'assistant', content: data.reply }]);
            } else {
                setMessages([...updatedMessages, { role: 'assistant', content: 'Lo siento, tuve un problema de conexión.' }]);
            }
        } catch (error) {
            console.error('Audio Chat error:', error);
            setMessages([...updatedMessages, { role: 'assistant', content: 'Error de red.' }]);
        } finally {
            setIsLoading(false);
        }
    };

    const handleRecordToggle = async () => {
        if (isRecording) {
            mediaRecorderRef.current.stop();
            setIsRecording(false);
        } else {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                mediaRecorderRef.current = new MediaRecorder(stream);
                audioChunksRef.current = [];

                mediaRecorderRef.current.ondataavailable = (e) => {
                    if (e.data.size > 0) audioChunksRef.current.push(e.data);
                };

                mediaRecorderRef.current.onstop = async () => {
                    const audioBlob = new Blob(audioChunksRef.current, { type: 'audio/webm' });
                    const reader = new FileReader();
                    reader.readAsDataURL(audioBlob);
                    reader.onloadend = () => {
                        sendAudioMessage(reader.result, 'audio/webm');
                    };
                    stream.getTracks().forEach(track => track.stop());
                };

                mediaRecorderRef.current.start();
                setIsRecording(true);
            } catch (err) {
                console.error("Error accessing mic:", err);
                alert("Please allow microphone access to use this feature.");
            }
        }
    };

    const handleKeyDown = (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleSend();
        }
    };

    return (
        <div style={{ display: 'flex', flexDirection: 'column', height: '100%', padding: '2rem', animation: 'fadeIn 0.5s ease-out' }}>
            <div style={{ marginBottom: '1.5rem' }}>
                <h1 className="gradient-text" style={{ fontSize: '2.5rem', marginBottom: '0.5rem', fontWeight: '800' }}>AI Tutor</h1>
                <p style={{ color: 'var(--text-secondary)' }}>Practice your Spanish conversation skills with real-time grammar corrections.</p>
            </div>

            <div className="glass-panel" style={{ flex: 1, display: 'flex', flexDirection: 'column', overflow: 'hidden', borderRadius: '20px', padding: 0 }}>
                {/* Chat Header */}
                <div style={{ padding: '1.5rem', borderBottom: '1px solid rgba(0,0,0,0.05)', display: 'flex', alignItems: 'center', gap: '1rem', background: 'linear-gradient(180deg, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.4) 100%)' }}>
                    <div style={{ width: '45px', height: '45px', borderRadius: '50%', background: 'var(--accent-gradient)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '1.5rem', boxShadow: '0 4px 10px rgba(59, 130, 246, 0.3)' }}>
                        🎓
                    </div>
                    <div>
                        <h3 style={{ margin: 0, fontSize: '1.2rem', color: 'var(--text-primary)' }}>Maestro</h3>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '0.5rem', marginTop: '4px' }}>
                            <div style={{ width: '8px', height: '8px', borderRadius: '50%', background: 'var(--success)' }}></div>
                            <span style={{ fontSize: '0.85rem', color: 'var(--text-secondary)' }}>Online - B1/B2 Level</span>
                        </div>
                    </div>
                </div>

                {/* Chat Messages */}
                <div style={{ flex: 1, overflowY: 'auto', padding: '2rem', display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                    {messages.map((msg, idx) => {
                        const isUser = msg.role === 'user';
                        return (
                            <div key={idx} style={{ display: 'flex', justifyContent: isUser ? 'flex-end' : 'flex-start', alignItems: 'flex-end', gap: '0.5rem' }}>
                                {!isUser && (
                                    <div style={{ width: '30px', height: '30px', borderRadius: '50%', background: 'var(--accent-gradient)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '0.9rem', flexShrink: 0 }}>
                                        🎓
                                    </div>
                                )}
                                <div style={{ 
                                    maxWidth: '75%', 
                                    padding: '1rem 1.5rem', 
                                    borderRadius: '20px', 
                                    borderBottomRightRadius: isUser ? '4px' : '20px',
                                    borderBottomLeftRadius: !isUser ? '4px' : '20px',
                                    background: isUser ? 'var(--accent-primary)' : 'rgba(255,255,255,0.9)', 
                                    color: isUser ? 'white' : 'var(--text-primary)',
                                    boxShadow: isUser ? '0 4px 15px rgba(59, 130, 246, 0.2)' : '0 4px 15px rgba(0,0,0,0.05)',
                                    lineHeight: '1.5',
                                    fontSize: '1rem',
                                    border: isUser ? 'none' : '1px solid rgba(0,0,0,0.05)'
                                }}>
                                    {msg.content}
                                </div>
                            </div>
                        );
                    })}
                    {isLoading && (
                        <div style={{ display: 'flex', justifyContent: 'flex-start', alignItems: 'flex-end', gap: '0.5rem' }}>
                            <div style={{ width: '30px', height: '30px', borderRadius: '50%', background: 'var(--accent-gradient)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '0.9rem', flexShrink: 0 }}>
                                🎓
                            </div>
                            <div style={{ 
                                padding: '1rem 1.5rem', 
                                borderRadius: '20px', 
                                borderBottomLeftRadius: '4px',
                                background: 'rgba(255,255,255,0.9)', 
                                boxShadow: '0 4px 15px rgba(0,0,0,0.05)',
                                border: '1px solid rgba(0,0,0,0.05)',
                                display: 'flex',
                                gap: '0.5rem'
                            }}>
                                <span className="typing-dot" style={{ animationDelay: '0s' }}></span>
                                <span className="typing-dot" style={{ animationDelay: '0.2s' }}></span>
                                <span className="typing-dot" style={{ animationDelay: '0.4s' }}></span>
                            </div>
                        </div>
                    )}
                    <div ref={messagesEndRef} />
                </div>

                {/* Chat Input */}
                <div style={{ padding: '1.5rem', borderTop: '1px solid rgba(0,0,0,0.05)', background: 'rgba(255,255,255,0.5)' }}>
                    <div style={{ display: 'flex', gap: '1rem', background: 'white', padding: '0.5rem', borderRadius: '16px', boxShadow: 'inset 0 2px 4px rgba(0,0,0,0.02), 0 4px 10px rgba(0,0,0,0.05)' }}>
                        <input 
                            type="text" 
                            value={input}
                            onChange={(e) => setInput(e.target.value)}
                            onKeyDown={handleKeyDown}
                            placeholder={isRecording ? "Grabando audio..." : "Escribe un mensaje aquí..."}
                            disabled={isLoading || isRecording}
                            style={{ flex: 1, border: 'none', background: 'transparent', padding: '0.5rem 1rem', fontSize: '1rem', color: isRecording ? 'var(--danger)' : 'var(--text-primary)', outline: 'none', fontStyle: isRecording ? 'italic' : 'normal' }}
                        />
                        
                        <button 
                            onClick={handleRecordToggle}
                            disabled={isLoading}
                            className={isRecording ? "recording-pulse" : ""}
                            style={{ 
                                background: isRecording ? 'var(--danger)' : 'rgba(0,0,0,0.05)', 
                                color: isRecording ? 'white' : 'var(--text-secondary)', 
                                border: 'none', 
                                width: '45px', 
                                height: '45px', 
                                borderRadius: '12px', 
                                display: 'flex', 
                                alignItems: 'center', 
                                justifyContent: 'center', 
                                cursor: isLoading ? 'not-allowed' : 'pointer',
                                transition: 'all 0.3s'
                            }}
                            title="Enviar audio"
                        >
                            {isRecording ? (
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <rect x="6" y="6" width="12" height="12" rx="2" ry="2"></rect>
                                </svg>
                            ) : (
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                    <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z"></path>
                                    <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                                    <line x1="12" y1="19" x2="12" y2="22"></line>
                                </svg>
                            )}
                        </button>

                        <button 
                            onClick={handleSend}
                            disabled={isLoading || (!input.trim() && !isRecording)}
                            style={{ 
                                background: input.trim() && !isLoading ? 'var(--accent-primary)' : '#cbd5e1', 
                                color: 'white', 
                                border: 'none', 
                                width: '45px', 
                                height: '45px', 
                                borderRadius: '12px', 
                                display: 'flex', 
                                alignItems: 'center', 
                                justifyContent: 'center', 
                                cursor: input.trim() && !isLoading ? 'pointer' : 'not-allowed',
                                transition: 'all 0.3s'
                            }}
                        >
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                <line x1="22" y1="2" x2="11" y2="13"></line>
                                <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            {/* Inject typing animation CSS locally for the chat */}
            <style>{`
                .typing-dot {
                    width: 8px;
                    height: 8px;
                    background-color: var(--accent-secondary);
                    border-radius: 50%;
                    display: inline-block;
                    animation: typing 1.4s infinite ease-in-out both;
                }
                @keyframes typing {
                    0%, 80%, 100% { transform: scale(0); }
                    40% { transform: scale(1); }
                }
                .recording-pulse {
                    animation: pulse-red 1.5s infinite;
                }
                @keyframes pulse-red {
                    0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
                    70% { box-shadow: 0 0 0 10px rgba(239, 68, 68, 0); }
                    100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
                }
            `}</style>
        </div>
    );
};

export default PracticeChat;
