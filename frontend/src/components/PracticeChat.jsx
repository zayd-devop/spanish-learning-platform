import React, { useState, useRef, useEffect } from 'react';
import { useAuth } from '../context/AuthContext';
import Swal from 'sweetalert2';

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const PracticeChat = () => {
    const { user } = useAuth();
    const storageKey = `ai_tutor_messages_${user?.id || 'default'}`;

    const [messages, setMessages] = useState(() => {
        const saved = localStorage.getItem(storageKey);
        if (saved) {
            try {
                return JSON.parse(saved);
            } catch (e) {
                console.error("Failed to parse saved chat", e);
            }
        }
        return [
            { role: 'assistant', content: 'Bonjour ! Je suis Maestro. Je suis là pour t\'aider à pratiquer ton français. De quoi aimerais-tu parler aujourd\'hui ?' }
        ];
    });
    const [input, setInput] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const messagesEndRef = useRef(null);

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    };

    useEffect(() => {
        scrollToBottom();
    }, [messages, isLoading]);

    useEffect(() => {
        localStorage.setItem(storageKey, JSON.stringify(messages));
    }, [messages, storageKey]);

    const clearChat = async () => {
        const result = await Swal.fire({
            title: 'Delete Conversation?',
            text: "Are you sure you want to delete the entire conversation with Maestro? This cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#4b5563',
            confirmButtonText: 'Yes, clear it',
            background: '#1e293b',
            color: '#fff'
        });

        if (result.isConfirmed) {
            const initialMessage = [
                { role: 'assistant', content: 'Bonjour ! Je suis Maestro. Je suis là pour t\'aider à pratiquer ton français. De quoi aimerais-tu parler aujourd\'hui ?' }
            ];
            setMessages(initialMessage);
            localStorage.setItem(storageKey, JSON.stringify(initialMessage));
        }
    };

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
                setMessages([...updatedMessages, { role: 'assistant', content: 'Désolé, j\'ai eu un problème de connexion. Pouvons-nous réessayer ?' }]);
            }
        } catch (error) {
            console.error('Chat error:', error);
            setMessages([...updatedMessages, { role: 'assistant', content: 'Erreur réseau. Veuillez réessayer.' }]);
        } finally {
            setIsLoading(false);
        }
    };



    const handleKeyDown = (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            handleSend();
        }
    };

    return (
        <div className="chat-container">
            <div style={{ marginBottom: '1.5rem' }}>
                <h1 className="gradient-text" style={{ fontSize: '2.5rem', marginBottom: '0.5rem', fontWeight: '800' }}>AI Tutor</h1>
                <p style={{ color: 'var(--text-secondary)' }}>Practice your French conversation skills with real-time grammar corrections.</p>
            </div>

            <div className="glass-panel" style={{ flex: 1, display: 'flex', flexDirection: 'column', overflow: 'hidden', borderRadius: '20px', padding: 0 }}>
                {/* Chat Header */}
                <div style={{ padding: '1rem', borderBottom: '1px solid rgba(0,0,0,0.05)', display: 'flex', alignItems: 'center', gap: '0.75rem', background: 'linear-gradient(180deg, rgba(255,255,255,0.8) 0%, rgba(255,255,255,0.4) 100%)' }}>
                    <div style={{ width: '38px', height: '38px', borderRadius: '50%', background: 'var(--accent-gradient)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '1.2rem', boxShadow: '0 4px 10px rgba(59, 130, 246, 0.3)' }}>
                        🎓
                    </div>
                    <div style={{ flex: 1 }}>
                        <h3 style={{ margin: 0, fontSize: '1.05rem', color: 'var(--text-primary)' }}>Maestro</h3>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '0.35rem', marginTop: '2px' }}>
                            <div style={{ width: '6px', height: '6px', borderRadius: '50%', background: 'var(--success)' }}></div>
                            <span style={{ fontSize: '0.8rem', color: 'var(--text-secondary)' }}>Online - B1/B2 Level</span>
                        </div>
                    </div>
                    <button 
                        onClick={clearChat}
                        title="Effacer la conversation"
                        style={{ background: 'transparent', border: '1px solid rgba(239, 68, 68, 0.3)', color: 'var(--danger)', padding: '0.4rem 0.8rem', borderRadius: '8px', fontSize: '0.8rem', cursor: 'pointer', display: 'flex', alignItems: 'center', gap: '0.4rem' }}
                    >
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        Clear
                    </button>
                </div>

                {/* Chat Messages */}
                <div className="chat-messages">
                    {messages.map((msg, idx) => {
                        const isUser = msg.role === 'user';
                        return (
                            <div key={idx} style={{ display: 'flex', justifyContent: isUser ? 'flex-end' : 'flex-start', alignItems: 'flex-end', gap: '0.5rem' }}>
                                {!isUser && (
                                    <div style={{ width: '30px', height: '30px', borderRadius: '50%', background: 'var(--accent-gradient)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '0.9rem', flexShrink: 0 }}>
                                        🎓
                                    </div>
                                )}
                                <div className="chat-bubble" style={{ 
                                    borderBottomRightRadius: isUser ? '4px' : '20px',
                                    borderBottomLeftRadius: !isUser ? '4px' : '20px',
                                    background: isUser ? 'var(--accent-primary)' : 'rgba(255,255,255,0.9)', 
                                    color: isUser ? 'white' : 'var(--text-primary)',
                                    boxShadow: isUser ? '0 4px 15px rgba(59, 130, 246, 0.2)' : '0 4px 15px rgba(0,0,0,0.05)',
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
                            <div className="chat-bubble" style={{ 
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
                <div className="chat-input-area">
                    <div style={{ display: 'flex', gap: '0.5rem', background: 'white', padding: '0.5rem', borderRadius: '16px', boxShadow: 'inset 0 2px 4px rgba(0,0,0,0.02), 0 4px 10px rgba(0,0,0,0.05)' }}>
                        <input 
                            type="text" 
                            value={input}
                            onChange={(e) => setInput(e.target.value)}
                            onKeyDown={handleKeyDown}
                            placeholder="Écrivez un message ici..."
                            disabled={isLoading}
                            style={{ flex: 1, minWidth: 0, border: 'none', background: 'transparent', padding: '0.5rem 0.5rem', fontSize: '1rem', color: 'var(--text-primary)', outline: 'none' }}
                        />

                        <button 
                            onClick={handleSend}
                            disabled={isLoading || !input.trim()}
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
                                transition: 'all 0.3s',
                                flexShrink: 0
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
