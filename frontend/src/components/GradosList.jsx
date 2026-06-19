import React, { useState, useEffect } from 'react';
import Swal from 'sweetalert2';
import { MapContainer, TileLayer, Marker, Popup } from 'react-leaflet';
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';

// Fix for default marker icon in react-leaflet
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-2x.png',
    iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
});

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const GradosList = () => {
    const [grados, setGrados] = useState([]);
    const [loading, setLoading] = useState(true);
    const [cvText, setCvText] = useState('');
    const [analyzing, setAnalyzing] = useState(false);
    const [isExtracting, setIsExtracting] = useState(false);
    const [scores, setScores] = useState({}); // { grado_id: { score: 95, reason: "..." } }

    useEffect(() => {
        const fetchGrados = async () => {
            try {
                const res = await fetch(`${API_BASE}/grados`);
                const data = await res.json();
                setGrados(data);
            } catch (err) {
                console.error("Failed to load Grados", err);
            }
            setLoading(false);
        };
        fetchGrados();
    }, []);

    const handleFileUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setIsExtracting(true);
        const formData = new FormData();
        formData.append('cv_pdf', file);

        try {
            const res = await fetch(`${API_BASE}/ai/extract-pdf`, {
                method: 'POST',
                body: formData
            });
            const data = await res.json();
            if (data.error) throw new Error(data.error);
            if (typeof data.text === 'string') {
                console.log("Extracted PDF Text Length:", data.text.length);
                console.log("Extracted PDF Text Snippet:", data.text.substring(0, 200));
                
                if (data.text.trim().length < 50) {
                    Swal.fire('Cannot Read PDF', 'Your PDF contains no readable text. This usually means it is an image/scan or export error. Please use a text-based PDF.', 'error');
                    setIsExtracting(false);
                    return;
                }
                
                setCvText(data.text);
                // Automatically trigger analysis
                handleAnalyze(data.text);
            } else {
                throw new Error("No text found in PDF.");
            }
        } catch (error) {
            Swal.fire('Error', error.message, 'error');
            setIsExtracting(false);
        }
        e.target.value = ''; // Reset
    };

    const handleAnalyze = async (textToAnalyze = cvText) => {
        if (!textToAnalyze) return;
        setAnalyzing(true);
        try {
            const res = await fetch(`${API_BASE}/ai/analyze-cv`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cv_text: textToAnalyze })
            });
            const data = await res.json();
            
            if (data.error) throw new Error(data.error);
            
            let scoresArray = data.scores || [];
            if (!Array.isArray(scoresArray)) {
                if (scoresArray.scores && Array.isArray(scoresArray.scores)) {
                    scoresArray = scoresArray.scores;
                } else {
                    throw new Error("AI returned invalid score format.");
                }
            }
            
            const scoreMap = {};
            scoresArray.forEach(item => {
                const id = item.grado_id || item.gradoId || item.id;
                if (id) {
                    scoreMap[id] = item;
                }
            });
            console.log("Extracted Score Map:", scoreMap);
            setScores(scoreMap);
            Swal.fire('Analyzed!', 'AI has matched your PDF profile against the degrees.', 'success');
        } catch (err) {
            Swal.fire('Error', err.message, 'error');
        }
        setAnalyzing(false);
        setIsExtracting(false);
    };

    if (loading) return <div className="loader"></div>;

    return (
        <div className="app-container" style={{ display: 'block' }}>
            <div className="glass-panel" style={{ padding: '2rem', marginBottom: '2rem' }}>
                <h1 className="gradient-text" style={{ marginBottom: '1rem' }}>Grados Superiores Directory</h1>
                <p style={{ color: 'var(--text-secondary)' }}>Find the perfect IT Vocational Training (FP) degree in Spain.</p>
                
                <div style={{ marginTop: '2rem', background: 'rgba(0,0,0,0.02)', padding: '1.5rem', borderRadius: '12px', border: '1px solid var(--glass-border)' }}>
                    <h3 style={{ marginBottom: '1rem', color: 'var(--accent-primary)' }}>🤖 AI CV Matcher</h3>
                    <p style={{ fontSize: '0.9rem', marginBottom: '1rem' }}>Upload your CV as a PDF. Our AI will extract the text, analyze your skills, and recommend the best Grado for you.</p>
                    
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem', alignItems: 'center' }}>
                        <label className="nav-btn nav-btn-solid" style={{ width: '100%', cursor: 'pointer', textAlign: 'center', margin: 0, padding: '1rem', fontSize: '1.1rem' }}>
                            {isExtracting || analyzing ? '🤖 AI is processing your PDF...' : '📄 Upload PDF CV to Analyze'}
                            <input type="file" accept=".pdf" onChange={handleFileUpload} style={{ display: 'none' }} disabled={isExtracting || analyzing} />
                        </label>
                        {cvText && <span style={{ fontSize: '0.8rem', color: 'var(--success)' }}>PDF text extracted successfully. Analysis complete.</span>}
                    </div>
                </div>
            </div>

            <div className="glass-panel" style={{ padding: '1rem', marginBottom: '2rem', height: '450px', zIndex: 1 }}>
                <MapContainer center={[40.4168, -3.7038]} zoom={6} scrollWheelZoom={false} style={{ height: '100%', width: '100%', borderRadius: '12px' }}>
                    <TileLayer
                        attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    />
                    {grados.map(grado => {
                        const match = scores[grado.id];
                        return grado.latitude && grado.longitude && (
                            <Marker key={grado.id} position={[grado.latitude, grado.longitude]}>
                                <Popup>
                                    <strong style={{ fontSize: '1rem' }}>{grado.name}</strong>
                                    {match && (
                                        <span style={{ marginLeft: '5px', color: match.score > 80 ? 'green' : 'orange', fontWeight: 'bold' }}>
                                            ({match.score}% Match)
                                        </span>
                                    )}
                                    <br />
                                    <em>{grado.institute}</em><br />
                                    {grado.location}<br />
                                    {match && (
                                        <div style={{ marginTop: '5px', fontSize: '0.8rem', fontStyle: 'italic', color: '#555' }}>
                                            "{match.reason}"
                                        </div>
                                    )}
                                    {grado.website && <a href={grado.website} target="_blank" rel="noopener noreferrer" style={{ display: 'inline-block', marginTop: '5px' }}>Visit Website</a>}
                                </Popup>
                            </Marker>
                        )
                    })}
                </MapContainer>
            </div>

            <h2 style={{ marginBottom: '1.5rem', color: 'var(--text-primary)' }}>
                {Object.keys(scores).length > 0 ? "Recommended For You (Ranked)" : "All Programs"}
            </h2>

            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '1.5rem' }}>
                {[...grados]
                    .sort((a, b) => {
                        const scoreA = scores[a.id] ? scores[a.id].score : 0;
                        const scoreB = scores[b.id] ? scores[b.id].score : 0;
                        return scoreB - scoreA;
                    })
                    .map(grado => {
                        const match = scores[grado.id];
                        return (
                            <div key={grado.id} className="glass-panel" style={{ padding: '1.5rem', display: 'flex', flexDirection: 'column', border: match && match.score > 80 ? '2px solid var(--success)' : '1px solid var(--glass-border)' }}>
                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start' }}>
                                    <h3 style={{ fontSize: '1.2rem', marginBottom: '0.5rem' }}>{grado.name}</h3>
                                    {match && (
                                        <div style={{ background: match.score > 80 ? 'var(--success)' : 'var(--accent-secondary)', color: 'white', padding: '4px 10px', borderRadius: '20px', fontWeight: 'bold', fontSize: '0.9rem' }}>
                                            {match.score}% Match
                                        </div>
                                    )}
                                </div>
                                <h4 style={{ color: 'var(--accent-primary)', fontSize: '0.95rem', marginBottom: '1rem' }}>🏫 {grado.institute}</h4>
                                <p style={{ color: 'var(--text-secondary)', fontSize: '0.9rem', marginBottom: '1rem', flexGrow: 1 }}>{grado.description}</p>
                                
                                {match && (
                                    <div style={{ background: 'rgba(0,0,0,0.03)', padding: '1rem', borderRadius: '8px', marginBottom: '1rem', borderLeft: '3px solid var(--accent-primary)' }}>
                                        <p style={{ fontSize: '0.85rem', margin: 0 }}><strong>AI Insight:</strong> {match.reason}</p>
                                    </div>
                                )}

                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginTop: 'auto', paddingTop: '1rem', borderTop: '1px solid var(--glass-border)' }}>
                                    <span style={{ fontSize: '0.8rem', color: '#64748b' }}>📍 {grado.location}</span>
                                    {grado.website && (
                                        <a href={grado.website} target="_blank" rel="noopener noreferrer" className="nav-btn nav-btn-outline" style={{ padding: '0.4rem 0.8rem', fontSize: '0.8rem' }}>Visit Site</a>
                                    )}
                                </div>
                            </div>
                        );
                    })}
            </div>
        </div>
    );
};

export default GradosList;
