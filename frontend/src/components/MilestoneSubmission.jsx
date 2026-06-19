import React, { useState, useRef } from 'react';

const MilestoneSubmission = ({ weekId }) => {
    const [textAnswer, setTextAnswer] = useState('');
    const [isRecording, setIsRecording] = useState(false);
    const [audioBlob, setAudioBlob] = useState(null);
    const [audioUrl, setAudioUrl] = useState(null);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [result, setResult] = useState(null);
    const [error, setError] = useState(null);

    const mediaRecorderRef = useRef(null);
    const audioChunksRef = useRef([]);

    const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

    const startRecording = async () => {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            const mediaRecorder = new MediaRecorder(stream);
            mediaRecorderRef.current = mediaRecorder;
            audioChunksRef.current = [];

            mediaRecorder.ondataavailable = (event) => {
                if (event.data.size > 0) {
                    audioChunksRef.current.push(event.data);
                }
            };

            mediaRecorder.onstop = () => {
                const audioBlob = new Blob(audioChunksRef.current, { type: 'audio/webm' });
                setAudioBlob(audioBlob);
                setAudioUrl(URL.createObjectURL(audioBlob));
            };

            mediaRecorder.start();
            setIsRecording(true);
        } catch (err) {
            console.error("Error accessing microphone:", err);
            setError("Could not access microphone. Please check permissions.");
        }
    };

    const stopRecording = () => {
        if (mediaRecorderRef.current && isRecording) {
            mediaRecorderRef.current.stop();
            mediaRecorderRef.current.stream.getTracks().forEach(track => track.stop());
            setIsRecording(false);
        }
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        if (!textAnswer.trim() && !audioBlob) {
            setError("Please provide either a written answer or an audio recording.");
            return;
        }

        setIsSubmitting(true);
        setError(null);

        const formData = new FormData();
        if (textAnswer.trim()) formData.append('text_answer', textAnswer);
        if (audioBlob) formData.append('audio', audioBlob, 'recording.webm');

        try {
            const response = await fetch(`${API_BASE}/weeks/${weekId}/submissions`, {
                method: 'POST',
                body: formData,
            });

            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Failed to submit milestone.');
            }

            setResult(data.submission);
            setTextAnswer('');
            setAudioBlob(null);
            setAudioUrl(null);
        } catch (err) {
            setError(err.message);
        } finally {
            setIsSubmitting(false);
        }
    };

    const sectionStyle = {
        marginTop: '2rem',
        background: 'var(--bg-primary)',
        borderRadius: '16px',
        padding: '1.5rem',
        border: '1px solid var(--glass-border)'
    };

    return (
        <div style={sectionStyle}>
            <h3 style={{ fontSize: '1.25rem', fontWeight: 'bold', color: 'var(--text-primary)', marginBottom: '0.5rem' }}>
                Milestone Submission
            </h3>
            <p style={{ color: 'var(--text-secondary)', fontSize: '0.9rem', marginBottom: '1.5rem' }}>
                Complete your milestone by writing your answer and/or recording your voice. Our AI will evaluate your submission.
            </p>

            <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '1.5rem' }}>
                <div>
                    <label style={{ display: 'block', fontSize: '0.9rem', fontWeight: '500', color: 'var(--text-secondary)', marginBottom: '0.5rem' }}>
                        Written Response
                    </label>
                    <textarea
                        value={textAnswer}
                        onChange={(e) => setTextAnswer(e.target.value)}
                        rows="4"
                        style={{ 
                            width: '100%', background: 'rgba(255,255,255,0.03)', border: '1px solid var(--glass-border)', 
                            borderRadius: '8px', padding: '1rem', color: 'var(--text-primary)', 
                            outline: 'none', resize: 'vertical', fontFamily: 'inherit'
                        }}
                        placeholder="Escribe tu respuesta aquí..."
                    ></textarea>
                </div>

                <div>
                    <label style={{ display: 'block', fontSize: '0.9rem', fontWeight: '500', color: 'var(--text-secondary)', marginBottom: '0.5rem' }}>
                        Audio Recording
                    </label>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '1rem', background: 'rgba(255,255,255,0.03)', padding: '1rem', borderRadius: '8px', border: '1px solid var(--glass-border)' }}>
                        {!isRecording ? (
                            <button
                                type="button"
                                onClick={startRecording}
                                style={{
                                    display: 'flex', alignItems: 'center', gap: '0.5rem', padding: '0.75rem 1.25rem',
                                    background: 'rgba(218, 41, 28, 0.2)', color: 'var(--accent-primary)', borderRadius: '8px',
                                    border: '1px solid rgba(218, 41, 28, 0.3)', cursor: 'pointer', fontWeight: 'bold'
                                }}
                            >
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                                Start Recording
                            </button>
                        ) : (
                            <button
                                type="button"
                                onClick={stopRecording}
                                style={{
                                    display: 'flex', alignItems: 'center', gap: '0.5rem', padding: '0.75rem 1.25rem',
                                    background: '#ef4444', color: 'white', borderRadius: '8px',
                                    border: 'none', cursor: 'pointer', fontWeight: 'bold'
                                }}
                            >
                                Stop Recording
                            </button>
                        )}

                        {audioUrl && (
                            <audio src={audioUrl} controls style={{ height: '40px', marginLeft: 'auto', maxWidth: '300px' }} />
                        )}
                    </div>
                </div>

                {error && (
                    <div style={{ padding: '1rem', background: 'rgba(239, 68, 68, 0.2)', border: '1px solid rgba(239, 68, 68, 0.5)', borderRadius: '8px', color: '#fca5a5', fontSize: '0.9rem' }}>
                        {error}
                    </div>
                )}

                <button
                    type="submit"
                    disabled={isSubmitting || (!textAnswer.trim() && !audioBlob)}
                    className="btn btn-primary"
                    style={{ opacity: (isSubmitting || (!textAnswer.trim() && !audioBlob)) ? 0.5 : 1 }}
                >
                    {isSubmitting ? 'Evaluating...' : 'Submit Milestone'}
                </button>
            </form>

            {/* Evaluation Result */}
            {result && (
                <div style={{ marginTop: '2rem', background: 'rgba(241, 191, 0, 0.1)', border: '1px solid rgba(241, 191, 0, 0.3)', borderRadius: '12px', padding: '1.5rem', position: 'relative' }}>
                    <h4 style={{ fontSize: '1.1rem', fontWeight: 'bold', color: 'var(--text-primary)', marginBottom: '0.5rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                        <span style={{ color: 'var(--accent-secondary)' }}>AI Evaluation</span> 
                        <span style={{ padding: '0.2rem 0.8rem', background: 'rgba(241, 191, 0, 0.2)', color: 'var(--accent-secondary)', borderRadius: '20px', fontSize: '0.85rem' }}>
                            Score: {result.evaluation_score}/10
                        </span>
                    </h4>
                    
                    <p style={{ color: 'var(--text-secondary)', marginTop: '1rem', lineHeight: '1.6' }}>
                        {result.evaluation_feedback}
                    </p>
                </div>
            )}
        </div>
    );
};

export default MilestoneSubmission;
