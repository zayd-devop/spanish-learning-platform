import React, { useState, useEffect } from 'react';
import { useAuth } from '../context/AuthContext';

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const BudgetPlanner = () => {
    const { user, token } = useAuth();
    const storageKey = `cf_budget_${user?.id || 'default'}`;

    const [budget, setBudget] = useState({
        loyer: 350,
        nourriture: 200,
        transport: 30,
        telephone: 20,
        loisirs: 50,
        frais_inscription: 170,
        billet_avion: 150,
        caution: 400,
        frais_cf: 1900, // en MAD
        requis_mensuel: 615 // AVI required per month
    });

    const [isLoaded, setIsLoaded] = useState(false);

    useEffect(() => {
        const fetchUserData = async () => {
            if (!token) return;
            try {
                const response = await fetch(`${API_BASE}/user/data`, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                const data = await response.json();
                if (data && data.budget_data) {
                    setBudget(data.budget_data);
                }
            } catch (err) {
                console.error('Failed to load budget data', err);
            } finally {
                setIsLoaded(true);
            }
        };
        fetchUserData();
    }, [token]);

    const saveToDB = async (newBudget) => {
        if (!token) return;
        try {
            await fetch(`${API_BASE}/user/data`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ budget_data: newBudget })
            });
        } catch (err) {
            console.error('Failed to save budget data', err);
        }
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setBudget(prev => {
            const newBudget = {
                ...prev,
                [name]: value === '' ? '' : Number(value)
            };
            saveToDB(newBudget);
            return newBudget;
        });
    };

    const monthlyTotal = (Number(budget.loyer) || 0) + (Number(budget.nourriture) || 0) + (Number(budget.transport) || 0) + (Number(budget.telephone) || 0) + (Number(budget.loisirs) || 0);
    const initialCosts = (Number(budget.frais_inscription) || 0) + (Number(budget.billet_avion) || 0) + (Number(budget.caution) || 0);
    
    // Campus France requires 615 EUR / month minimum for AVI (but can be modified)
    const requiredMonthly = Number(budget.requis_mensuel) || 0;
    const requiredAnnual = requiredMonthly * 12;
    const diffMonthly = monthlyTotal - requiredMonthly;

    return (
        <div className="animate-fade-in" style={{ padding: '1rem', paddingBottom: '4rem' }}>
            <div style={{ marginBottom: '2rem' }}>
                <h1 className="gradient-text" style={{ fontSize: '2.5rem', marginBottom: '0.5rem', fontWeight: '800' }}>Simulateur de Budget</h1>
                <p style={{ color: 'var(--text-secondary)', fontSize: '1.1rem' }}>Estimez vos dépenses en France et vérifiez si vous respectez les critères de l'AVI (Attestation de Virement Irrévocable).</p>
            </div>

            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(250px, 1fr))', gap: '1.5rem', marginBottom: '2rem' }}>
                {/* Résumé des frais */}
                <div className="glass-panel animate-slide-up stagger-1" style={{ padding: '2rem' }}>
                    <h2 style={{ fontSize: '1.2rem', marginBottom: '1.5rem', color: 'var(--text-primary)', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                        <span>📊</span> Résumé Financier
                    </h2>
                    
                    <div style={{ marginBottom: '1.5rem', padding: '1rem', background: 'rgba(0,0,0,0.02)', borderRadius: '12px', border: '1px solid var(--glass-border)' }}>
                        <div style={{ fontSize: '0.9rem', color: 'var(--text-secondary)' }}>Budget Mensuel Estimé</div>
                        <div style={{ fontSize: '2.5rem', fontWeight: '800', color: monthlyTotal <= requiredMonthly ? 'var(--success)' : '#ef4444' }}>
                            {monthlyTotal} € <span style={{ fontSize: '1rem', fontWeight: '500', color: 'var(--text-secondary)' }}>/ mois</span>
                        </div>
                        <div style={{ fontSize: '0.85rem', color: monthlyTotal <= requiredMonthly ? 'var(--success)' : '#ef4444', marginTop: '0.5rem' }}>
                            {monthlyTotal <= requiredMonthly ? "✅ Vous êtes en dessous du budget Campus France." : "⚠️ Attention : Vos dépenses dépassent les 615€ minimum requis."}
                        </div>
                    </div>

                    <div style={{ marginBottom: '1rem', background: 'rgba(59, 130, 246, 0.05)', padding: '1rem', borderRadius: '8px', border: '1px solid rgba(59, 130, 246, 0.1)' }}>
                        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '0.5rem', justifyContent: 'space-between', alignItems: 'center', marginBottom: '0.5rem', color: 'var(--text-secondary)' }}>
                            <span style={{ fontSize: '0.9rem', flex: '1 1 auto', minWidth: '150px' }}>Requis par Campus France (AVI)</span>
                            <div style={{ display: 'flex', alignItems: 'center', background: 'white', padding: '0.4rem 0.8rem', borderRadius: '6px', border: '1px dashed var(--glass-border)', width: '120px' }}>
                                <input 
                                    type="number" 
                                    name="requis_mensuel" 
                                    value={budget.requis_mensuel || ''} 
                                    onChange={handleInputChange}
                                    style={{ border: 'none', background: 'transparent', outline: 'none', width: '100%', minWidth: 0, fontSize: '1rem', color: 'var(--text-primary)', textAlign: 'right', fontWeight: '600' }}
                                    placeholder="615"
                                />
                                <span style={{ color: 'var(--text-secondary)', marginLeft: '6px', fontSize: '1rem' }}>€</span>
                            </div>
                        </div>
                        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '0.5rem', justifyContent: 'space-between', color: 'var(--text-secondary)', fontSize: '0.9rem' }}>
                            <span style={{ flex: '1 1 auto', minWidth: '150px' }}>Total Annuel Exigé (AVI)</span>
                            <span style={{ fontWeight: '600' }}>{requiredAnnual} €</span>
                        </div>
                    </div>

                    <div style={{ borderTop: '1px solid var(--glass-border)', paddingTop: '1rem', marginTop: '1rem' }}>
                        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '0.5rem', justifyContent: 'space-between', marginBottom: '0.5rem', color: 'var(--text-primary)', fontWeight: '600' }}>
                            <span style={{ flex: '1 1 auto', minWidth: '150px' }}>Frais d'installation (1er mois)</span>
                            <span>{initialCosts + monthlyTotal} €</span>
                        </div>
                        <p style={{ fontSize: '0.8rem', color: 'var(--text-secondary)' }}>Inclut le premier loyer, la caution, l'avion et l'inscription.</p>
                    </div>
                </div>

                {/* Formulaire de dépenses */}
                <div className="glass-panel animate-slide-up stagger-2" style={{ padding: '2rem' }}>
                    <h2 style={{ fontSize: '1.2rem', marginBottom: '1.5rem', color: 'var(--text-primary)', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                        <span>🛒</span> Dépenses Mensuelles (€)
                    </h2>
                    
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                        {[
                            { id: 'loyer', label: 'Loyer (CROUS ou Privé)', icon: '🏠' },
                            { id: 'nourriture', label: 'Nourriture / Courses', icon: '🛒' },
                            { id: 'transport', label: 'Transport', icon: '🚇' },
                            { id: 'telephone', label: 'Forfait Téléphone / Internet', icon: '📱' },
                            { id: 'loisirs', label: 'Loisirs & Imprévus', icon: '🎬' }
                        ].map(item => (
                            <div key={item.id} style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
                                <div style={{ width: '40px', height: '40px', borderRadius: '10px', background: 'rgba(0,0,0,0.05)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>{item.icon}</div>
                                <div style={{ flex: 1 }}>
                                    <label style={{ display: 'block', fontSize: '0.85rem', color: 'var(--text-secondary)', marginBottom: '0.2rem' }}>{item.label}</label>
                                    <div style={{ display: 'flex', alignItems: 'center', background: 'white', border: '1px solid var(--glass-border)', borderRadius: '8px', padding: '0.5rem', boxShadow: 'inset 0 2px 4px rgba(0,0,0,0.02)' }}>
                                        <input 
                                            type="number" 
                                            name={item.id} 
                                            value={budget[item.id] || ''} 
                                            onChange={handleInputChange}
                                            style={{ border: 'none', background: 'transparent', outline: 'none', flex: 1, fontSize: '1rem', color: 'var(--text-primary)' }}
                                            placeholder="0"
                                        />
                                        <span style={{ color: 'var(--text-secondary)', fontWeight: '600' }}>€</span>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                {/* Frais Uniques */}
                <div className="glass-panel animate-slide-up stagger-3" style={{ padding: '2rem' }}>
                    <h2 style={{ fontSize: '1.2rem', marginBottom: '1.5rem', color: 'var(--text-primary)', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                        <span>✈️</span> Frais Uniques (Installation)
                    </h2>
                    
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                        {[
                            { id: 'frais_inscription', label: "Frais d'inscription Université", icon: '🎓', unit: '€' },
                            { id: 'billet_avion', label: "Billet d'avion", icon: '✈️', unit: '€' },
                            { id: 'caution', label: 'Caution (Logement)', icon: '🔑', unit: '€' },
                            { id: 'frais_cf', label: 'Frais de dossier Campus France', icon: '📝', unit: 'MAD' }
                        ].map(item => (
                            <div key={item.id} style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
                                <div style={{ width: '40px', height: '40px', borderRadius: '10px', background: 'rgba(59, 130, 246, 0.1)', color: 'var(--accent-primary)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>{item.icon}</div>
                                <div style={{ flex: 1 }}>
                                    <label style={{ display: 'block', fontSize: '0.85rem', color: 'var(--text-secondary)', marginBottom: '0.2rem' }}>{item.label}</label>
                                    <div style={{ display: 'flex', alignItems: 'center', background: 'white', border: '1px solid var(--glass-border)', borderRadius: '8px', padding: '0.5rem', boxShadow: 'inset 0 2px 4px rgba(0,0,0,0.02)' }}>
                                        <input 
                                            type="number" 
                                            name={item.id} 
                                            value={budget[item.id] || ''} 
                                            onChange={handleInputChange}
                                            style={{ border: 'none', background: 'transparent', outline: 'none', flex: 1, fontSize: '1rem', color: 'var(--text-primary)' }}
                                            placeholder="0"
                                        />
                                        <span style={{ color: 'var(--text-secondary)', fontWeight: '600' }}>{item.unit}</span>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default BudgetPlanner;
