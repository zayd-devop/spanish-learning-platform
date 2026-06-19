import React, { useState, useEffect } from 'react';

const TestViewer = ({ weekId, testType = 'weekly' }) => {
    const [test, setTest] = useState(null);
    const [loading, setLoading] = useState(true);
    const [answers, setAnswers] = useState({});
    const [result, setResult] = useState(null);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [error, setError] = useState(null);

    const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

    useEffect(() => {
        const fetchTest = async () => {
            try {
                setLoading(true);
                const endpoint = testType === 'weekly' ? `/weeks/${weekId}/tests` : `/tests/final`;
                const response = await fetch(`${API_BASE}${endpoint}`);
                
                if (response.status === 404) {
                    setTest(null);
                    return;
                }

                if (!response.ok) throw new Error("Failed to load test");

                const data = await response.json();
                setTest(data);
                setAnswers({});
                setResult(null);
            } catch (err) {
                console.error("Error fetching test:", err);
                setError(err.message);
            } finally {
                setLoading(false);
            }
        };

        if (weekId || testType === 'final') {
            fetchTest();
        }
    }, [weekId, testType]);

    const handleOptionSelect = (questionId, option) => {
        if (result) return; // Prevent changing after submission
        setAnswers(prev => ({
            ...prev,
            [questionId]: option
        }));
    };

    const handleSubmit = async () => {
        if (!test) return;

        setIsSubmitting(true);
        setError(null);

        try {
            const response = await fetch(`${API_BASE}/tests/${test.id}/submit`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ answers })
            });

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to submit test');
            }

            setResult(data);
        } catch (err) {
            setError(err.message);
        } finally {
            setIsSubmitting(false);
        }
    };

    if (loading) return <div style={{ marginTop: '2rem', color: 'var(--text-secondary)' }}>Loading Test...</div>;
    if (!test) return null; // No test for this week

    const sectionStyle = {
        marginTop: '2rem',
        background: 'var(--bg-primary)',
        borderRadius: '16px',
        padding: '1.5rem',
        border: '1px solid var(--glass-border)'
    };

    return (
        <div style={sectionStyle}>
            <h3 style={{ fontSize: '1.25rem', fontWeight: 'bold', color: 'var(--text-primary)', marginBottom: '1.5rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="var(--success)">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
                {test.title}
            </h3>

            <div style={{ display: 'flex', flexDirection: 'column', gap: '2rem' }}>
                {test.questions.map((q, idx) => (
                    <div key={q.id} style={{ background: 'rgba(255,255,255,0.02)', padding: '1.25rem', borderRadius: '12px', border: '1px solid var(--glass-border)' }}>
                        <p style={{ color: 'var(--text-primary)', fontWeight: '500', marginBottom: '1rem' }}>
                            <span style={{ color: 'var(--success)', marginRight: '0.5rem' }}>{idx + 1}.</span> 
                            {q.question}
                        </p>
                        
                        <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(250px, 1fr))', gap: '0.75rem' }}>
                            {q.options.map((option, oIdx) => {
                                const isSelected = answers[q.id] === option;
                                
                                let btnStyle = {
                                    padding: '1rem', textAlign: 'left', borderRadius: '8px', cursor: result ? 'default' : 'pointer',
                                    transition: 'all 0.2s', border: '1px solid var(--glass-border)', display: 'flex', alignItems: 'center'
                                };

                                if (isSelected) {
                                    btnStyle.background = 'rgba(16, 185, 129, 0.2)';
                                    btnStyle.borderColor = 'rgba(16, 185, 129, 0.5)';
                                    btnStyle.color = '#6ee7b7';
                                } else {
                                    btnStyle.background = 'var(--bg-secondary)';
                                    btnStyle.color = 'var(--text-secondary)';
                                }

                                return (
                                    <button
                                        key={oIdx}
                                        onClick={() => handleOptionSelect(q.id, option)}
                                        disabled={!!result}
                                        style={btnStyle}
                                    >
                                        <span style={{ 
                                            display: 'inline-block', width: '24px', height: '24px', borderRadius: '50%', 
                                            border: '1px solid currentColor', textAlign: 'center', lineHeight: '22px', 
                                            marginRight: '0.75rem', fontSize: '0.85rem' 
                                        }}>
                                            {String.fromCharCode(65 + oIdx)}
                                        </span>
                                        {option}
                                    </button>
                                );
                            })}
                        </div>
                    </div>
                ))}
            </div>

            {error && (
                <div style={{ marginTop: '1.5rem', padding: '1rem', background: 'rgba(239, 68, 68, 0.2)', border: '1px solid rgba(239, 68, 68, 0.5)', borderRadius: '8px', color: '#fca5a5', fontSize: '0.9rem' }}>
                    {error}
                </div>
            )}

            {!result ? (
                <button
                    onClick={handleSubmit}
                    disabled={isSubmitting || Object.keys(answers).length !== test.questions.length}
                    className="btn btn-success"
                    style={{ marginTop: '2rem', opacity: (isSubmitting || Object.keys(answers).length !== test.questions.length) ? 0.5 : 1 }}
                >
                    {isSubmitting ? 'Submitting...' : 'Submit Answers'}
                </button>
            ) : (
                <div style={{ marginTop: '2rem', background: 'rgba(16, 185, 129, 0.1)', border: '1px solid rgba(16, 185, 129, 0.3)', borderRadius: '12px', padding: '1.5rem', textAlign: 'center' }}>
                    <h4 style={{ fontSize: '1.5rem', fontWeight: 'bold', color: 'var(--text-primary)', marginBottom: '0.5rem' }}>Test Completed!</h4>
                    <p style={{ color: 'var(--text-secondary)' }}>
                        You scored <strong style={{ color: 'var(--success)', fontSize: '1.25rem' }}>{result.score}%</strong>
                    </p>
                    <p style={{ fontSize: '0.9rem', color: 'var(--text-secondary)', marginTop: '0.25rem' }}>
                        ({result.correct_count} correct out of {result.total_questions} questions)
                    </p>
                </div>
            )}
        </div>
    );
};

export default TestViewer;
