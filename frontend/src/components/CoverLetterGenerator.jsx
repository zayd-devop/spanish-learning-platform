import React, { useState } from 'react';
import { useAuth } from '../context/AuthContext';
import Swal from 'sweetalert2';

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const CoverLetterGenerator = () => {
    const { user } = useAuth();
    const [formData, setFormData] = useState({
        parcours: "Diplôme de Technicien Spécialisé en Développement Digital à l'OFPPT",
        formation: "Licence 3 Informatique (Parcours Développement Web)",
        universite: "Université Paris 8",
        projet_pro: "Devenir Ingénieur Logiciel Full-Stack"
    });
    const [generatedLetter, setGeneratedLetter] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleGenerate = async () => {
        if (!formData.formation || !formData.universite || !formData.parcours || !formData.projet_pro) {
            Swal.fire({ title: 'Erreur', text: 'Veuillez remplir tous les champs.', icon: 'error' });
            return;
        }

        setIsLoading(true);
        setGeneratedLetter('');

        try {
            const response = await fetch(`${API_BASE}/ai/generate-cover-letter`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (response.ok && data.letter) {
                setGeneratedLetter(data.letter);
            } else {
                Swal.fire({ title: 'Erreur', text: data.error || 'Erreur lors de la génération.', icon: 'error' });
            }
        } catch (error) {
            console.error('Letter Generation error:', error);
            Swal.fire({ title: 'Erreur réseau', text: 'Impossible de joindre le serveur.', icon: 'error' });
        } finally {
            setIsLoading(false);
        }
    };

    const copyToClipboard = () => {
        navigator.clipboard.writeText(generatedLetter);
        Swal.fire({ title: 'Copié !', text: 'La lettre a été copiée dans le presse-papiers.', icon: 'success', timer: 2000, showConfirmButton: false });
    };

    return (
        <div className="animate-fade-in" style={{ padding: '1rem', paddingBottom: '4rem' }}>
            <div style={{ marginBottom: '2rem' }}>
                <h1 className="gradient-text" style={{ fontSize: '2.5rem', marginBottom: '0.5rem', fontWeight: '800' }}>Projet d'Études (Lettre de Motivation)</h1>
                <p style={{ color: 'var(--text-secondary)', fontSize: '1.1rem' }}>L'IA rédige pour vous une lettre de motivation professionnelle et convaincante pour votre dossier Campus France.</p>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(350px, 1fr))', gap: '2rem' }}>
                {/* Formulaire */}
                <div className="glass-panel animate-slide-up stagger-1" style={{ padding: '2rem' }}>
                    <h2 style={{ fontSize: '1.2rem', marginBottom: '1.5rem', color: 'var(--text-primary)', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                        <span>✍️</span> Vos Informations
                    </h2>
                    
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '1.2rem' }}>
                        <div>
                            <label style={{ display: 'block', fontSize: '0.9rem', color: 'var(--text-secondary)', marginBottom: '0.4rem', fontWeight: '500' }}>Votre parcours actuel (Ex: Diplôme OFPPT)</label>
                            <input 
                                type="text" 
                                name="parcours" 
                                value={formData.parcours} 
                                onChange={handleInputChange}
                                style={{ width: '100%', padding: '0.8rem', border: '1px solid var(--glass-border)', borderRadius: '8px', fontSize: '0.95rem', background: 'rgba(255,255,255,0.8)', outline: 'none', color: 'var(--text-primary)' }}
                            />
                        </div>
                        <div>
                            <label style={{ display: 'block', fontSize: '0.9rem', color: 'var(--text-secondary)', marginBottom: '0.4rem', fontWeight: '500' }}>Formation visée en France</label>
                            <input 
                                type="text" 
                                name="formation" 
                                value={formData.formation} 
                                onChange={handleInputChange}
                                style={{ width: '100%', padding: '0.8rem', border: '1px solid var(--glass-border)', borderRadius: '8px', fontSize: '0.95rem', background: 'rgba(255,255,255,0.8)', outline: 'none', color: 'var(--text-primary)' }}
                            />
                        </div>
                        <div>
                            <label style={{ display: 'block', fontSize: '0.9rem', color: 'var(--text-secondary)', marginBottom: '0.4rem', fontWeight: '500' }}>Université ciblée</label>
                            <input 
                                type="text" 
                                name="universite" 
                                value={formData.universite} 
                                onChange={handleInputChange}
                                style={{ width: '100%', padding: '0.8rem', border: '1px solid var(--glass-border)', borderRadius: '8px', fontSize: '0.95rem', background: 'rgba(255,255,255,0.8)', outline: 'none', color: 'var(--text-primary)' }}
                            />
                        </div>
                        <div>
                            <label style={{ display: 'block', fontSize: '0.9rem', color: 'var(--text-secondary)', marginBottom: '0.4rem', fontWeight: '500' }}>Votre projet professionnel (Qu'allez-vous devenir ?)</label>
                            <textarea 
                                name="projet_pro" 
                                value={formData.projet_pro} 
                                onChange={handleInputChange}
                                rows="3"
                                style={{ width: '100%', padding: '0.8rem', border: '1px solid var(--glass-border)', borderRadius: '8px', fontSize: '0.95rem', background: 'rgba(255,255,255,0.8)', outline: 'none', color: 'var(--text-primary)', resize: 'vertical' }}
                            ></textarea>
                        </div>

                        <button 
                            onClick={handleGenerate}
                            disabled={isLoading}
                            className="hover-lift"
                            style={{ 
                                width: '100%', padding: '1rem', marginTop: '0.5rem', background: 'var(--accent-gradient)', 
                                color: 'white', border: 'none', borderRadius: '10px', fontSize: '1.05rem', 
                                fontWeight: '600', cursor: isLoading ? 'not-allowed' : 'pointer',
                                display: 'flex', justifyContent: 'center', alignItems: 'center', gap: '0.5rem',
                                opacity: isLoading ? 0.7 : 1
                            }}
                        >
                            {isLoading ? 'Génération en cours...' : '✨ Générer la Lettre Merveilleuse'}
                        </button>
                    </div>
                </div>

                {/* Résultat */}
                <div className="glass-panel animate-slide-up stagger-2" style={{ padding: '2rem', display: 'flex', flexDirection: 'column' }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1.5rem' }}>
                        <h2 style={{ fontSize: '1.2rem', color: 'var(--text-primary)', display: 'flex', alignItems: 'center', gap: '0.5rem', margin: 0 }}>
                            <span>📄</span> Résultat
                        </h2>
                        {generatedLetter && (
                            <button 
                                onClick={copyToClipboard}
                                className="hover-lift"
                                style={{ background: 'rgba(59, 130, 246, 0.1)', color: 'var(--accent-primary)', border: 'none', padding: '0.5rem 1rem', borderRadius: '8px', fontSize: '0.85rem', fontWeight: '600', cursor: 'pointer', display: 'flex', alignItems: 'center', gap: '0.4rem' }}
                            >
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                Copier
                            </button>
                        )}
                    </div>
                    
                    <div style={{ flex: 1, background: 'rgba(255,255,255,0.7)', border: '1px solid var(--glass-border)', borderRadius: '12px', padding: '1.5rem', minHeight: '300px', whiteSpace: 'pre-wrap', color: 'var(--text-primary)', fontSize: '0.95rem', lineHeight: '1.7', overflowY: 'auto' }}>
                        {isLoading ? (
                            <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', height: '100%', color: 'var(--text-secondary)' }}>
                                <div className="loader" style={{ width: '40px', height: '40px', border: '3px solid rgba(59,130,246,0.3)', borderTopColor: 'var(--accent-primary)', borderRadius: '50%', animation: 'spin 1s linear infinite', marginBottom: '1rem' }}></div>
                                <style>{`@keyframes spin { 100% { transform: rotate(360deg); } }`}</style>
                                <span>L'IA rédige votre lettre...</span>
                            </div>
                        ) : generatedLetter ? (
                            generatedLetter
                        ) : (
                            <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', height: '100%', color: '#94a3b8', textAlign: 'center' }}>
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round" style={{ marginBottom: '1rem' }}><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                Remplissez le formulaire et cliquez sur "Générer" pour voir le résultat ici.
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default CoverLetterGenerator;
