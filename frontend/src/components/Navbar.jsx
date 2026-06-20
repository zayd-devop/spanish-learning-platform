import React from 'react';
import { useAuth } from '../context/AuthContext';
import { Link, useNavigate } from 'react-router-dom';

const ESpanishLogo = () => (
    <svg width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" style={{ filter: 'drop-shadow(0px 4px 6px rgba(0,0,0,0.1))' }}>
        <path d="M50,85 c-15,0 -25,-10 -25,-25 c0,-15 10,-25 25,-25 c15,0 25,10 25,25 v2 h-38 c2,10 9,13 18,13 c7,0 12,-3 15,-8 l8,5 c-5,8 -13,13 -23,13 z m0,-40 c-7,0 -13,5 -15,13 h28 c-2,-8 -8,-13 -13,-13 z" fill="#0ea5e9" />
        <polygon points="50,15 85,25 50,35 15,25" fill="#0f172a" />
        <path d="M38,31 v8 c0,5 24,5 24,0 v-8 z" fill="#0f172a" />
        <rect x="22" y="27" width="2" height="15" fill="#0f172a" />
        <polygon points="23,42 20,50 26,50" fill="#0f172a" />
    </svg>
);

const Navbar = () => {
    const { user, logout } = useAuth();
    const navigate = useNavigate();

    const handleLogout = async () => {
        await logout();
        navigate('/login');
    };

    return (
        <nav className="navbar glass-panel" style={{ borderRadius: '0', borderLeft: 'none', borderRight: 'none', borderTop: 'none', display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '1rem', flexWrap: 'nowrap', gap: '0.5rem' }}>
            <div className="navbar-brand">
                <Link to="/" style={{ textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <ESpanishLogo />
                    <span className="gradient-text" style={{ fontSize: '1.5rem', fontWeight: '800', margin: 0, whiteSpace: 'nowrap' }}>e-Spanish</span>
                </Link>
            </div>

            <div className="navbar-menu" style={{ display: 'flex', alignItems: 'center', gap: '0.75rem', flexWrap: 'nowrap' }}>
                {user ? (
                    <>
                        <span style={{ color: '#475569', fontWeight: '500', whiteSpace: 'nowrap', fontSize: '0.95rem' }}>Hola, {user.name.split(' ')[0]}</span>
                        <button onClick={handleLogout} className="nav-btn nav-btn-danger" style={{ padding: '0.4rem', display: 'flex', alignItems: 'center', justifyContent: 'center', borderRadius: '8px' }} title="Logout">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                        </button>
                    </>
                ) : (
                    <>
                        <Link to="/login" className="nav-btn nav-btn-outline">
                            Login
                        </Link>
                        <Link to="/register" className="nav-btn nav-btn-solid">
                            Register
                        </Link>
                    </>
                )}
            </div>
        </nav>
    );
};

export default Navbar;
