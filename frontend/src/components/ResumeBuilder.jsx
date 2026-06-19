import React, { useState } from 'react';
import Swal from 'sweetalert2';
import { useAuth } from '../context/AuthContext';

const API_BASE = 'http://127.0.0.1:8000/api';

const ResumeBuilder = () => {
    const { token } = useAuth();
    const [title, setTitle] = useState('My Developer Resume');
    const [content, setContent] = useState({
        personalInfo: { name: '', email: '', phone: '', summary: '' },
        experience: [{ company: '', role: '', description: '' }],
        education: [{ institution: '', degree: '', year: '' }],
        skills: ''
    });
    const [isGenerating, setIsGenerating] = useState(false);
    const [isParsingPdf, setIsParsingPdf] = useState(false);

    const handlePdfUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        setIsParsingPdf(true);
        const formData = new FormData();
        formData.append('cv_pdf', file);

        try {
            const res = await fetch(`${API_BASE}/ai/parse-resume-pdf`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${token}`
                },
                body: formData
            });
            const data = await res.json();
            
            if (data.error) throw new Error(data.error);
            
            if (data.resume) {
                setContent({
                    personalInfo: data.resume.personalInfo || { name: '', email: '', phone: '', summary: '' },
                    experience: data.resume.experience && data.resume.experience.length ? data.resume.experience : [{ company: '', role: '', description: '' }],
                    education: data.resume.education && data.resume.education.length ? data.resume.education : [{ institution: '', degree: '', year: '' }],
                    skills: data.resume.skills || ''
                });
                Swal.fire('Parsed!', 'AI has successfully extracted and populated your CV.', 'success');
            }
        } catch (error) {
            Swal.fire('Error', error.message, 'error');
        }
        setIsParsingPdf(false);
        e.target.value = ''; // Reset input
    };

    const handleEnhance = async (fieldPath, text, contextStr) => {
        if (!text) return;
        setIsGenerating(true);
        try {
            const res = await fetch(`${API_BASE}/ai/enhance`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ text, context: contextStr })
            });
            const data = await res.json();
            if (data.enhanced_text) {
                setContent({
                    ...content,
                    personalInfo: {
                        ...content.personalInfo,
                        summary: data.enhanced_text
                    }
                });
                Swal.fire('Enhanced!', 'Your summary has been upgraded by AI.', 'success');
            } else {
                throw new Error(data.error || 'Failed to enhance');
            }
        } catch (error) {
            Swal.fire('Error', error.message, 'error');
        }
        setIsGenerating(false);
    };

    const handleExportPdf = () => {
        window.print();
    };

    const handlePersonalInfoChange = (field, value) => {
        setContent(prev => ({
            ...prev,
            personalInfo: { ...prev.personalInfo, [field]: value }
        }));
    };

    const handleArrayChange = (type, index, field, value) => {
        setContent(prev => {
            const newArr = [...prev[type]];
            newArr[index] = { ...newArr[index], [field]: value };
            return { ...prev, [type]: newArr };
        });
    };

    const addArrayItem = (type) => {
        setContent(prev => {
            const emptyItem = type === 'experience' 
                ? { company: '', role: '', description: '' } 
                : { institution: '', degree: '', year: '' };
            return { ...prev, [type]: [...prev[type], emptyItem] };
        });
    };

    const removeArrayItem = (type, index) => {
        setContent(prev => {
            const newArr = prev[type].filter((_, i) => i !== index);
            return { ...prev, [type]: newArr.length ? newArr : [ (type === 'experience' ? { company: '', role: '', description: '' } : { institution: '', degree: '', year: '' }) ] };
        });
    };

    return (
        <div className="app-container" style={{ display: 'block' }}>
            
            {/* NO PRINT SECTION: Form Controls */}
            <div className="glass-panel no-print" style={{ padding: '2rem', marginBottom: '2rem' }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '2rem' }}>
                    <h1 className="gradient-text">AI Resume Builder</h1>
                    <div style={{ display: 'flex', gap: '1rem', alignItems: 'center' }}>
                        {isParsingPdf && <span style={{ fontSize: '0.9rem', color: 'var(--accent-primary)' }}>🤖 AI Reading PDF...</span>}
                        <label className="nav-btn nav-btn-outline" style={{ cursor: 'pointer', margin: 0 }}>
                            📥 Import PDF
                            <input type="file" accept=".pdf" onChange={handlePdfUpload} style={{ display: 'none' }} disabled={isParsingPdf} />
                        </label>
                        <button className="nav-btn nav-btn-solid" onClick={handleExportPdf}>
                            📄 Export PDF
                        </button>
                    </div>
                </div>

                <div className="form-group">
                    <label>Resume Title (Not printed)</label>
                    <input type="text" className="form-control" value={title} onChange={(e) => setTitle(e.target.value)} />
                </div>

                <h3>Personal Details</h3>
                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '1rem', marginBottom: '1rem' }}>
                    <div className="form-group">
                        <label>Full Name</label>
                        <input type="text" className="form-control" value={content.personalInfo.name} onChange={(e) => handlePersonalInfoChange('name', e.target.value)} />
                    </div>
                    <div className="form-group">
                        <label>Email</label>
                        <input type="email" className="form-control" value={content.personalInfo.email} onChange={(e) => handlePersonalInfoChange('email', e.target.value)} />
                    </div>
                    <div className="form-group">
                        <label>Phone</label>
                        <input type="text" className="form-control" value={content.personalInfo.phone} onChange={(e) => handlePersonalInfoChange('phone', e.target.value)} />
                    </div>
                </div>

                <h3>Professional Summary</h3>
                <div className="form-group" style={{ position: 'relative', marginBottom: '2rem' }}>
                    <textarea 
                        className="form-control"
                        rows="4" 
                        value={content.personalInfo.summary}
                        onChange={(e) => handlePersonalInfoChange('summary', e.target.value)}
                        placeholder="Write a brief summary about yourself..."
                        style={{ width: '100%', padding: '1rem', borderRadius: '8px', border: '1px solid var(--glass-border)' }}
                    />
                    <button 
                        onClick={() => handleEnhance('summary', content.personalInfo.summary, 'Professional Summary for IT CV')}
                        disabled={isGenerating || !content.personalInfo.summary}
                        style={{ position: 'absolute', right: '10px', bottom: '15px', background: 'var(--accent-gradient)', color: 'white', border: 'none', padding: '5px 10px', borderRadius: '6px', cursor: 'pointer', fontSize: '0.8rem' }}
                    >
                        {isGenerating ? '✨ Enhancing...' : '✨ AI Enhance'}
                    </button>
                </div>

                <h3>Experience</h3>
                {content.experience.map((exp, index) => (
                    <div key={index} style={{ border: '1px solid var(--glass-border)', padding: '1.5rem', borderRadius: '12px', marginBottom: '1.5rem', position: 'relative', background: 'rgba(255,255,255,0.5)' }}>
                        <button onClick={() => removeArrayItem('experience', index)} style={{ position: 'absolute', top: '15px', right: '15px', width: '28px', height: '28px', display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#ef4444', color: 'white', border: 'none', borderRadius: '6px', cursor: 'pointer', fontWeight: 'bold' }}>✕</button>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1.5rem' }}>
                            <div className="form-group">
                                <label>Company</label>
                                <input type="text" className="form-control" value={exp.company} onChange={(e) => handleArrayChange('experience', index, 'company', e.target.value)} />
                            </div>
                            <div className="form-group">
                                <label>Role / Title</label>
                                <input type="text" className="form-control" value={exp.role} onChange={(e) => handleArrayChange('experience', index, 'role', e.target.value)} />
                            </div>
                        </div>
                        <div className="form-group" style={{ marginBottom: 0 }}>
                            <label>Description</label>
                            <textarea className="form-control" rows="3" value={exp.description} onChange={(e) => handleArrayChange('experience', index, 'description', e.target.value)}></textarea>
                        </div>
                    </div>
                ))}
                <button className="nav-btn nav-btn-outline" onClick={() => addArrayItem('experience')} style={{ marginBottom: '2.5rem' }}>+ Add Experience</button>

                <h3>Education</h3>
                {content.education.map((edu, index) => (
                    <div key={index} style={{ border: '1px solid var(--glass-border)', padding: '1.5rem', borderRadius: '12px', marginBottom: '1.5rem', position: 'relative', background: 'rgba(255,255,255,0.5)' }}>
                        <button onClick={() => removeArrayItem('education', index)} style={{ position: 'absolute', top: '15px', right: '15px', width: '28px', height: '28px', display: 'flex', alignItems: 'center', justifyContent: 'center', background: '#ef4444', color: 'white', border: 'none', borderRadius: '6px', cursor: 'pointer', fontWeight: 'bold' }}>✕</button>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '1.5rem' }}>
                            <div className="form-group" style={{ marginBottom: 0 }}>
                                <label>Institution</label>
                                <input type="text" className="form-control" value={edu.institution} onChange={(e) => handleArrayChange('education', index, 'institution', e.target.value)} />
                            </div>
                            <div className="form-group" style={{ marginBottom: 0 }}>
                                <label>Degree / Grado</label>
                                <input type="text" className="form-control" value={edu.degree} onChange={(e) => handleArrayChange('education', index, 'degree', e.target.value)} />
                            </div>
                            <div className="form-group" style={{ marginBottom: 0 }}>
                                <label>Year</label>
                                <input type="text" className="form-control" value={edu.year} onChange={(e) => handleArrayChange('education', index, 'year', e.target.value)} />
                            </div>
                        </div>
                    </div>
                ))}
                <button className="nav-btn nav-btn-outline" onClick={() => addArrayItem('education')} style={{ marginBottom: '2.5rem' }}>+ Add Education</button>

                <h3>Skills</h3>
                <div className="form-group">
                    <label>Comma Separated Skills</label>
                    <textarea className="form-control" rows="2" value={content.skills} onChange={(e) => setContent({ ...content, skills: e.target.value })}></textarea>
                </div>
            </div>
            
            {/* PRINT ONLY SECTION: Actual CV Canvas */}
            <div className="cv-print-canvas">
                <div className="cv-header">
                    <h1>{content.personalInfo.name || 'Your Name'}</h1>
                    <div className="cv-contact">
                        {content.personalInfo.email && <span>{content.personalInfo.email}</span>}
                        {content.personalInfo.email && content.personalInfo.phone && <span> • </span>}
                        {content.personalInfo.phone && <span>{content.personalInfo.phone}</span>}
                    </div>
                </div>

                {content.personalInfo.summary && (
                    <div className="cv-section">
                        <h2>Professional Summary</h2>
                        <p>{content.personalInfo.summary}</p>
                    </div>
                )}

                {content.experience.some(e => e.company || e.role) && (
                    <div className="cv-section">
                        <h2>Experience</h2>
                        {content.experience.map((exp, index) => (exp.company || exp.role) && (
                            <div className="cv-item" key={index}>
                                <div className="cv-item-header">
                                    <span className="cv-item-title">{exp.role}</span>
                                    <span className="cv-item-company">{exp.company}</span>
                                </div>
                                {exp.description && <p className="cv-item-desc">{exp.description}</p>}
                            </div>
                        ))}
                    </div>
                )}

                {content.education.some(e => e.institution || e.degree) && (
                    <div className="cv-section">
                        <h2>Education</h2>
                        {content.education.map((edu, index) => (edu.institution || edu.degree) && (
                            <div className="cv-item" key={index}>
                                <div className="cv-item-header">
                                    <span className="cv-item-title">{edu.degree}</span>
                                    <span className="cv-item-date">{edu.year}</span>
                                </div>
                                <div className="cv-item-company">{edu.institution}</div>
                            </div>
                        ))}
                    </div>
                )}

                {content.skills && (
                    <div className="cv-section">
                        <h2>Skills</h2>
                        <p className="cv-skills">
                            {content.skills.split(',').map(s => s.trim()).filter(s => s).join(' • ')}
                        </p>
                    </div>
                )}
            </div>
        </div>
    );
};

export default ResumeBuilder;
