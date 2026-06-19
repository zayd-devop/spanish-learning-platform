import React, { useState } from 'react';
import { useAuth } from '../context/AuthContext';
import { useNavigate, Link } from 'react-router-dom';
import Swal from 'sweetalert2';

const Register = () => {
    const { register } = useAuth();
    const navigate = useNavigate();
    const [name, setName] = useState('');
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirm, setPasswordConfirm] = useState('');
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (e) => {
        e.preventDefault();
        
        if (password !== passwordConfirm) {
            Swal.fire({ icon: 'error', title: 'Passwords do not match', confirmButtonColor: '#3b82f6' });
            return;
        }

        setLoading(true);
        const result = await register(name, email, password, passwordConfirm);
        setLoading(false);

        if (result.success) {
            navigate('/');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: result.error,
                confirmButtonColor: '#3b82f6'
            });
        }
    };

    return (
        <div className="auth-container">
            <div className="auth-card glass-panel">
                <div style={{ textAlign: 'center', marginBottom: '2rem' }}>
                    <h2 className="gradient-text" style={{ fontSize: '2rem' }}>Create Account</h2>
                    <p style={{ color: '#64748b', marginTop: '0.5rem' }}>Join the 12-week challenge.</p>
                </div>
                
                <form onSubmit={handleSubmit} className="auth-form">
                    <div className="form-group">
                        <label>Full Name</label>
                        <input 
                            type="text" 
                            value={name} 
                            onChange={(e) => setName(e.target.value)} 
                            placeholder="Maria Garcia"
                            required 
                        />
                    </div>
                    <div className="form-group">
                        <label>Email Address</label>
                        <input 
                            type="email" 
                            value={email} 
                            onChange={(e) => setEmail(e.target.value)} 
                            placeholder="hola@example.com"
                            required 
                        />
                    </div>
                    <div className="form-group">
                        <label>Password</label>
                        <input 
                            type="password" 
                            value={password} 
                            onChange={(e) => setPassword(e.target.value)} 
                            placeholder="••••••••"
                            required 
                            minLength="8"
                        />
                    </div>
                    <div className="form-group">
                        <label>Confirm Password</label>
                        <input 
                            type="password" 
                            value={passwordConfirm} 
                            onChange={(e) => setPasswordConfirm(e.target.value)} 
                            placeholder="••••••••"
                            required 
                            minLength="8"
                        />
                    </div>
                    <button type="submit" className="action-btn log-btn" disabled={loading} style={{ width: '100%', marginTop: '1rem', padding: '0.75rem' }}>
                        {loading ? 'Creating...' : 'Sign Up'}
                    </button>
                </form>

                <p style={{ textAlign: 'center', marginTop: '1.5rem', color: '#64748b' }}>
                    Already have an account? <Link to="/login" style={{ color: '#3b82f6', fontWeight: '600', textDecoration: 'none' }}>Log in</Link>
                </p>
            </div>
        </div>
    );
};

export default Register;
