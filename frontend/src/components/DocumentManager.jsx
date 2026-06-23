import React, { useState, useEffect } from 'react';
import { useAuth } from '../context/AuthContext';

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const DocumentManager = () => {
    const { user, token } = useAuth();
    const storageKey = `cf_documents_${user?.id || 'default'}`;

    const defaultDocs = [
        { id: 1, title: "Passeport / CNI", desc: "Copie scannée lisible", status: "pending" },
        { id: 2, title: "Photo d'identité", desc: "Format 35x45 mm, fond clair", status: "pending" },
        { id: 3, title: "Relevés de notes OFPPT", desc: "Traduits en français si nécessaire", status: "pending" },
        { id: 4, title: "Diplômes obtenus (Bac, Technicien)", desc: "Légalisés et traduits", status: "pending" },
        { id: 5, title: "Test de Français (TCF/DELF)", desc: "Attestation officielle", status: "pending" },
        { id: 6, title: "Justificatifs d'expérience pro.", desc: "Attestations de stage ou de travail", status: "pending" },
        { id: 7, title: "Attestation de Virement Irrévocable (AVI)", desc: "Preuve de ressources (615€/mois minimum)", status: "pending" }
    ];

    const [documents, setDocuments] = useState(defaultDocs);
    const [isLoaded, setIsLoaded] = useState(false);

    useEffect(() => {
        const fetchUserData = async () => {
            if (!token) return;
            try {
                const response = await fetch(`${API_BASE}/user/data`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await response.json();
                if (data && data.documents_data) {
                    setDocuments(data.documents_data);
                }
            } catch (err) {
                console.error('Failed to load document data', err);
            } finally {
                setIsLoaded(true);
            }
        };
        fetchUserData();
    }, [token]);

    const saveToDB = async (newDocs) => {
        if (!token) return;
        try {
            await fetch(`${API_BASE}/user/data`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ documents_data: newDocs })
            });
        } catch (err) {
            console.error('Failed to save document data', err);
        }
    };

    const toggleStatus = (id) => {
        setDocuments(docs => {
            const newDocs = docs.map(doc => {
                if (doc.id === id) {
                    const nextStatus = doc.status === 'pending' ? 'in_progress' : doc.status === 'in_progress' ? 'completed' : 'pending';
                    return { ...doc, status: nextStatus };
                }
                return doc;
            });
            saveToDB(newDocs);
            return newDocs;
        });
    };

    const progress = Math.round((documents.filter(d => d.status === 'completed').length / documents.length) * 100);

    return (
        <div className="animate-fade-in" style={{ padding: '1rem' }}>
            <div style={{ marginBottom: '2rem' }}>
                <h1 className="gradient-text" style={{ fontSize: '2.5rem', marginBottom: '0.5rem', fontWeight: '800' }}>Coffre-fort Documents</h1>
                <p style={{ color: 'var(--text-secondary)', fontSize: '1.1rem' }}>Suivez l'état de préparation de votre dossier consulaire.</p>
            </div>

            <div className="glass-panel" style={{ padding: '2rem', marginBottom: '2rem' }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1rem' }}>
                    <h3 style={{ fontSize: '1.2rem', color: 'var(--text-primary)' }}>Progression du Dossier</h3>
                    <span style={{ fontSize: '1.5rem', fontWeight: '800', color: progress === 100 ? 'var(--success)' : 'var(--accent-primary)' }}>{progress}%</span>
                </div>
                <div style={{ width: '100%', height: '12px', background: 'rgba(0,0,0,0.05)', borderRadius: '10px', overflow: 'hidden' }}>
                    <div style={{ width: `${progress}%`, height: '100%', background: progress === 100 ? 'var(--success)' : 'var(--accent-gradient)', transition: 'width 0.5s ease' }}></div>
                </div>
            </div>

            <div style={{ display: 'grid', gap: '1rem' }}>
                {documents.map((doc, idx) => (
                    <div 
                        key={doc.id} 
                        className={`glass-panel hover-lift animate-slide-up stagger-${(idx % 5) + 1}`}
                        style={{ 
                            padding: '1.5rem', 
                            display: 'flex', 
                            alignItems: 'center', 
                            gap: '1.5rem',
                            cursor: 'pointer',
                            borderLeft: `4px solid ${doc.status === 'completed' ? 'var(--success)' : doc.status === 'in_progress' ? '#f59e0b' : 'var(--glass-border)'}`
                        }}
                        onClick={() => toggleStatus(doc.id)}
                    >
                        <div style={{ 
                            width: '40px', height: '40px', borderRadius: '50%', flexShrink: 0,
                            display: 'flex', alignItems: 'center', justifyContent: 'center',
                            background: doc.status === 'completed' ? 'var(--success)' : doc.status === 'in_progress' ? '#fef3c7' : 'rgba(0,0,0,0.05)',
                            color: doc.status === 'completed' ? 'white' : doc.status === 'in_progress' ? '#d97706' : 'var(--text-secondary)'
                        }}>
                            {doc.status === 'completed' && <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>}
                            {doc.status === 'in_progress' && <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>}
                            {doc.status === 'pending' && <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>}
                        </div>
                        <div style={{ flex: 1 }}>
                            <h3 style={{ fontSize: '1.1rem', color: doc.status === 'completed' ? 'var(--text-secondary)' : 'var(--text-primary)', textDecoration: doc.status === 'completed' ? 'line-through' : 'none' }}>{doc.title}</h3>
                            <p style={{ color: 'var(--text-secondary)', fontSize: '0.9rem', marginTop: '0.2rem' }}>{doc.desc}</p>
                        </div>
                        <div style={{
                            padding: '0.4rem 0.8rem',
                            borderRadius: '20px',
                            fontSize: '0.8rem',
                            fontWeight: '600',
                            background: doc.status === 'completed' ? 'var(--success-glow)' : doc.status === 'in_progress' ? '#fef3c7' : 'rgba(0,0,0,0.05)',
                            color: doc.status === 'completed' ? 'var(--success)' : doc.status === 'in_progress' ? '#d97706' : 'var(--text-secondary)'
                        }}>
                            {doc.status === 'completed' ? 'Prêt' : doc.status === 'in_progress' ? 'En cours' : 'À préparer'}
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default DocumentManager;
