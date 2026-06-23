import React, { useState, useRef, useEffect } from 'react';
import { useAuth } from '../context/AuthContext';
import Swal from 'sweetalert2';

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const InterviewSimulator = () => {
    const { user, token } = useAuth();
    const storageKey = `cf_interview_${user?.id || 'default'}`;

    const initialMessage = [
        { role: 'assistant', content: 'Bonjour. Prenez place. Je suis conseiller pédagogique pour Campus France. Pour commencer cet entretien de 20 minutes, veuillez vous présenter brièvement et m\'expliquer pourquoi vous souhaitez poursuivre vos études en France.' }
    ];

    const [messages, setMessages] = useState(initialMessage);
    const [input, setInput] = useState('');
    const [isLoading, setIsLoading] = useState(false);
    const [isLoaded, setIsLoaded] = useState(false);
    const messagesEndRef = useRef(null);

    useEffect(() => {
        const fetchUserData = async () => {
            if (!token) return;
            try {
                const response = await fetch(`${API_BASE}/user/data`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await response.json();
                if (data && data.interview_history && data.interview_history.length > 0) {
                    setMessages(data.interview_history);
                }
            } catch (err) {
                console.error('Failed to load interview history', err);
            } finally {
                setIsLoaded(true);
            }
        };
        fetchUserData();
    }, [token]);

    const saveToDB = async (newHistory) => {
        if (!token) return;
        try {
            await fetch(`${API_BASE}/user/data`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ interview_history: newHistory })
            });
        } catch (err) {
            console.error('Failed to save interview history', err);
        }
    };

    const scrollToBottom = () => {
        messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
    };

    useEffect(() => {
        scrollToBottom();
    }, [messages, isLoading]);

    const clearChat = async () => {
        const result = await Swal.fire({
            title: 'Recommencer l\'entretien ?',
            text: "Vous allez perdre l'historique de cette simulation.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#4b5563',
            confirmButtonText: 'Oui, recommencer',
            cancelButtonText: 'Annuler',
            background: 'var(--bg-secondary)',
            color: 'var(--text-primary)'
        });

        if (result.isConfirmed) {
            setMessages(initialMessage);
            saveToDB(initialMessage);
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
            const response = await fetch(`${API_BASE}/ai/mock-interview`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    message: userMessage.content,
                    history: messages.slice(-10) // Keep more context for interview
                })
            });

            const data = await response.json();

            if (response.ok && data.reply) {
                const newMessages = [...updatedMessages, { role: 'assistant', content: data.reply }];
                setMessages(newMessages);
                saveToDB(newMessages);
            } else {
                const newMessages = [...updatedMessages, { role: 'assistant', content: 'Désolé, problème technique. Pouvez-vous répéter ?' }];
                setMessages(newMessages);
                saveToDB(newMessages);
            }
        } catch (error) {
            console.error('Interview error:', error);
            const newMessages = [...updatedMessages, { role: 'assistant', content: 'Erreur réseau.' }];
            setMessages(newMessages);
            saveToDB(newMessages);
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
        <div className="animate-fade-in" style={{ padding: '1rem', height: 'calc(100vh - 100px)', display: 'flex', flexDirection: 'column' }}>
            <div style={{ marginBottom: '1.5rem', flexShrink: 0 }}>
                <h1 className="gradient-text" style={{ fontSize: '2.5rem', marginBottom: '0.5rem', fontWeight: '800' }}>Simulation d'Entretien</h1>
                <p style={{ color: 'var(--text-secondary)' }}>Préparez-vous à l'entretien pédagogique Campus France face à notre IA (niveau exigeant).</p>
            </div>

            <div className="glass-panel animate-slide-up stagger-1" style={{ flex: 1, display: 'flex', flexDirection: 'column', overflow: 'hidden', padding: 0 }}>
                {/* Chat Header */}
                <div style={{ padding: '1rem 1.5rem', borderBottom: '1px solid var(--glass-border)', display: 'flex', alignItems: 'center', gap: '1rem', background: 'rgba(255,255,255,0.5)' }}>
                    <div style={{ width: '45px', height: '45px', borderRadius: '50%', background: '#1e293b', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '1.2rem', boxShadow: '0 4px 10px rgba(0,0,0,0.1)' }}>
                        👔
                    </div>
                    <div style={{ flex: 1 }}>
                        <h3 style={{ margin: 0, fontSize: '1.1rem', color: 'var(--text-primary)' }}>Conseiller Campus France</h3>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '0.35rem', marginTop: '2px' }}>
                            <div style={{ width: '6px', height: '6px', borderRadius: '50%', background: '#ef4444' }}></div>
                            <span style={{ fontSize: '0.8rem', color: 'var(--text-secondary)' }}>En direct - Entretien Formel</span>
                        </div>
                    </div>
                    <button 
                        onClick={clearChat}
                        className="hover-lift"
                        title="Recommencer l'entretien"
                        style={{ background: 'white', border: '1px solid rgba(0,0,0,0.1)', color: 'var(--text-primary)', padding: '0.5rem 1rem', borderRadius: '8px', fontSize: '0.85rem', fontWeight: '600', cursor: 'pointer', display: 'flex', alignItems: 'center', gap: '0.5rem' }}
                    >
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"/></svg>
                        Recommencer
                    </button>
                </div>

                {/* Chat Messages */}
                <div style={{ flex: 1, overflowY: 'auto', padding: '1.5rem', display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                    {messages.map((msg, idx) => {
                        const isUser = msg.role === 'user';
                        return (
                            <div key={idx} className="animate-slide-up" style={{ display: 'flex', justifyContent: isUser ? 'flex-end' : 'flex-start', alignItems: 'flex-end', gap: '0.75rem' }}>
                                {!isUser && (
                                    <div style={{ width: '35px', height: '35px', borderRadius: '50%', background: '#1e293b', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '0.9rem', flexShrink: 0 }}>
                                        👔
                                    </div>
                                )}
                                <div style={{ 
                                    maxWidth: '75%',
                                    padding: '1rem 1.25rem',
                                    borderBottomRightRadius: isUser ? '4px' : '20px',
                                    borderBottomLeftRadius: !isUser ? '4px' : '20px',
                                    borderTopLeftRadius: '20px',
                                    borderTopRightRadius: '20px',
                                    background: isUser ? 'var(--accent-gradient)' : 'white', 
                                    color: isUser ? 'white' : 'var(--text-primary)',
                                    boxShadow: '0 4px 15px rgba(0,0,0,0.03)',
                                    border: isUser ? 'none' : '1px solid var(--glass-border)',
                                    fontSize: '0.95rem',
                                    lineHeight: '1.6'
                                }}>
                                    {msg.content}
                                </div>
                            </div>
                        );
                    })}
                    {isLoading && (
                        <div style={{ display: 'flex', justifyContent: 'flex-start', alignItems: 'flex-end', gap: '0.75rem' }}>
                            <div style={{ width: '35px', height: '35px', borderRadius: '50%', background: '#1e293b', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontSize: '0.9rem', flexShrink: 0 }}>
                                👔
                            </div>
                            <div style={{ 
                                padding: '1rem 1.25rem',
                                borderBottomLeftRadius: '4px',
                                borderRadius: '20px',
                                background: 'white', 
                                border: '1px solid var(--glass-border)',
                                display: 'flex',
                                gap: '0.5rem'
                            }}>
                                <span className="typing-dot" style={{ animationDelay: '0s', background: '#94a3b8' }}></span>
                                <span className="typing-dot" style={{ animationDelay: '0.2s', background: '#94a3b8' }}></span>
                                <span className="typing-dot" style={{ animationDelay: '0.4s', background: '#94a3b8' }}></span>
                            </div>
                        </div>
                    )}
                    <div ref={messagesEndRef} />
                </div>

                {/* Chat Input */}
                <div style={{ padding: '1rem 1.5rem', borderTop: '1px solid var(--glass-border)', background: 'rgba(255,255,255,0.5)' }}>
                    <div style={{ display: 'flex', gap: '0.75rem', background: 'white', padding: '0.5rem', borderRadius: '16px', boxShadow: 'inset 0 2px 4px rgba(0,0,0,0.02), 0 4px 10px rgba(0,0,0,0.05)', border: '1px solid var(--glass-border)' }}>
                        <textarea 
                            value={input}
                            onChange={(e) => setInput(e.target.value)}
                            onKeyDown={handleKeyDown}
                            placeholder="Écrivez votre réponse professionnelle ici... (Entrée pour envoyer)"
                            disabled={isLoading}
                            rows="2"
                            style={{ flex: 1, minWidth: 0, border: 'none', background: 'transparent', padding: '0.5rem', fontSize: '0.95rem', color: 'var(--text-primary)', outline: 'none', resize: 'none', fontFamily: 'inherit' }}
                        />
                        <button 
                            onClick={handleSend}
                            disabled={isLoading || !input.trim()}
                            className="hover-lift"
                            style={{ 
                                background: input.trim() && !isLoading ? '#1e293b' : '#cbd5e1', 
                                color: 'white', 
                                border: 'none', 
                                width: '50px', 
                                height: '50px', 
                                borderRadius: '12px', 
                                display: 'flex', 
                                alignItems: 'center', 
                                justifyContent: 'center', 
                                cursor: input.trim() && !isLoading ? 'pointer' : 'not-allowed',
                                alignSelf: 'flex-end'
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
            
            <style>{`
                .typing-dot {
                    width: 8px; height: 8px; border-radius: 50%;
                    display: inline-block; animation: typing 1.4s infinite ease-in-out both;
                }
                @keyframes typing {
                    0%, 80%, 100% { transform: scale(0); }
                    40% { transform: scale(1); }
                }
            `}</style>
        </div>
    );
};

export default InterviewSimulator;
