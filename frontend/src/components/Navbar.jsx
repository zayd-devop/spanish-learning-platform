import React from 'react';
import { useAuth } from '../context/AuthContext';
import { Link, useNavigate } from 'react-router-dom';

const SpanishFlagLogo = () => (
    <svg width="40" height="40" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" style={{ filter: 'drop-shadow(0px 4px 6px rgba(0,0,0,0.1))' }}>
        <clipPath id="shield">
            <path d="M15 10 L85 10 L85 40 C85 75, 50 90, 50 90 C50 90, 15 75, 15 40 Z" />
        </clipPath>
        <g clipPath="url(#shield)">
            <rect width="100" height="100" fill="#facc15" /> {/* Yellow */}
            <rect y="0" width="100" height="25" fill="#ef4444" /> {/* Red */}
            <rect y="75" width="100" height="25" fill="#ef4444" /> {/* Red */}
        </g>
        <text x="50" y="56" dominantBaseline="middle" textAnchor="middle" fill="#1e293b" fontWeight="900" fontSize="36" fontFamily="Outfit, sans-serif" letterSpacing="-2">SP</text>
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
        <nav className="navbar glass-panel" style={{ borderRadius: '0', borderLeft: 'none', borderRight: 'none', borderTop: 'none', display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '1rem 2rem' }}>
            <div className="navbar-brand">
                <Link to="/" style={{ textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '12px' }}>
                    <SpanishFlagLogo />
                    <span className="gradient-text" style={{ fontSize: '1.5rem', fontWeight: '800', margin: 0 }}>Spanish Platform</span>
                </Link>
            </div>

            <div className="navbar-menu" style={{ display: 'flex', alignItems: 'center', gap: '1.25rem' }}>
                {user ? (
                    <>
                        <span style={{ color: '#475569', fontWeight: '500', marginLeft: '1rem' }}>Hola, {user.name}</span>
                        <button onClick={handleLogout} className="nav-btn nav-btn-danger">
                            Logout
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
