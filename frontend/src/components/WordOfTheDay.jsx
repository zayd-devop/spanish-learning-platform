import React, { useState, useEffect } from 'react';

// A predefined list of high-frequency Spanish words and phrases (B1/B2 level focus)
const vocabularyList = [
    { word: 'Desarrollador', type: 'Noun (m)', translation: 'Developer', example: 'Trabajo como desarrollador de software en Madrid.', exampleTranslation: 'I work as a software developer in Madrid.' },
    { word: 'Aprender', type: 'Verb', translation: 'To learn', example: 'Quiero aprender español para mi máster.', exampleTranslation: 'I want to learn Spanish for my Master\'s.' },
    { word: 'Éxito', type: 'Noun (m)', translation: 'Success', example: 'El esfuerzo constante es la clave del éxito.', exampleTranslation: 'Constant effort is the key to success.' },
    { word: 'Lograr', type: 'Verb', translation: 'To achieve', example: 'Espero lograr un nivel B2 pronto.', exampleTranslation: 'I hope to achieve a B2 level soon.' },
    { word: 'Sin embargo', type: 'Conjunction', translation: 'However', example: 'El examen fue difícil; sin embargo, aprobé.', exampleTranslation: 'The exam was difficult; however, I passed.' },
    { word: 'Desafío', type: 'Noun (m)', translation: 'Challenge', example: 'Aprender la gramática es un buen desafío.', exampleTranslation: 'Learning the grammar is a good challenge.' },
    { word: 'Fluidez', type: 'Noun (f)', translation: 'Fluency', example: 'Practicar todos los días mejora la fluidez.', exampleTranslation: 'Practicing every day improves fluency.' }
];

const WordOfTheDay = () => {
    const [dailyWord, setDailyWord] = useState(null);

    useEffect(() => {
        // Simple logic to rotate the word based on the day of the year
        const getDayOfYear = () => {
            const now = new Date();
            const start = new Date(now.getFullYear(), 0, 0);
            const diff = (now - start) + ((start.getTimezoneOffset() - now.getTimezoneOffset()) * 60 * 1000);
            return Math.floor(diff / (1000 * 60 * 60 * 24));
        };

        const wordIndex = getDayOfYear() % vocabularyList.length;
        setDailyWord(vocabularyList[wordIndex]);
    }, []);

    if (!dailyWord) return null;

    return (
        <div className="glass-panel hover-glow" style={{ padding: '2rem', borderRadius: '20px', background: 'linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(0,0,0,0) 100%)', display: 'flex', flexDirection: 'column', height: '100%' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1.5rem' }}>
                <h3 style={{ fontSize: '1.1rem', color: 'var(--text-secondary)', display: 'flex', alignItems: 'center', gap: '0.5rem', textTransform: 'uppercase', letterSpacing: '1px', fontWeight: '600' }}>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                    </svg>
                    Word of the Day
                </h3>
            </div>

            <div style={{ flex: 1, display: 'flex', flexDirection: 'column', justifyContent: 'center' }}>
                <div style={{ marginBottom: '1.5rem' }}>
                    <h2 className="gradient-text" style={{ fontSize: '2.8rem', fontWeight: '800', margin: '0 0 0.5rem 0', lineHeight: '1.1' }}>
                        {dailyWord.word}
                    </h2>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', flexWrap: 'wrap' }}>
                        <span style={{ display: 'inline-block', background: 'rgba(59, 130, 246, 0.1)', color: 'var(--accent-primary)', padding: '4px 12px', borderRadius: '20px', fontSize: '0.85rem', fontWeight: '600' }}>
                            {dailyWord.type}
                        </span>
                        <span style={{ fontSize: '1.2rem', color: 'var(--text-secondary)', fontWeight: '500', whiteSpace: 'nowrap' }}>
                            "{dailyWord.translation}"
                        </span>
                    </div>
                </div>

                <div style={{ background: 'rgba(0,0,0,0.03)', padding: '1.25rem', borderRadius: '12px', borderLeft: '4px solid var(--accent-secondary)' }}>
                    <p style={{ margin: '0 0 0.5rem 0', fontSize: '1rem', color: 'var(--text-primary)', fontStyle: 'italic' }}>
                        {dailyWord.example}
                    </p>
                    <p style={{ margin: 0, fontSize: '0.9rem', color: 'var(--text-secondary)' }}>
                        {dailyWord.exampleTranslation}
                    </p>
                </div>
            </div>
        </div>
    );
};

export default WordOfTheDay;
