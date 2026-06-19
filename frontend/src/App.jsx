import React from 'react';
import './index.css';
import { AuthProvider, useAuth } from './context/AuthContext';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import Navbar from './components/Navbar';
import Sidebar from './components/Sidebar';
import Login from './components/Login';
import Register from './components/Register';
import GradosList from './components/GradosList';
import LearningPath from './components/LearningPath';
import Dashboard from './components/Dashboard';
import PracticeChat from './components/PracticeChat';

const ProtectedRoute = ({ children }) => {
  const { user, loading } = useAuth();
  if (loading) return <div className="loader"></div>;
  if (!user) return <Navigate to="/login" />;
  return children;
};

const MainLayout = ({ children }) => {
  return (
    <div className="main-layout">
      <Sidebar />
      <div className="content-area">
        <Navbar />
        <div className="scrollable-content">
          {children}
        </div>
      </div>
    </div>
  );
};

function App() {
  return (
    <AuthProvider>
      <Router>
        <Routes>
          {/* Public Routes (No Sidebar) */}
          <Route path="/login" element={<><Navbar /><Login /></>} />
          <Route path="/register" element={<><Navbar /><Register /></>} />
          
          {/* Protected Routes with Sidebar Layout */}
          <Route path="/" element={
            <ProtectedRoute>
              <MainLayout>
                <Dashboard />
              </MainLayout>
            </ProtectedRoute>
          } />
          <Route path="/learning-path" element={
            <ProtectedRoute>
              <MainLayout>
                <LearningPath />
              </MainLayout>
            </ProtectedRoute>
          } />
          <Route path="/grados" element={
            <ProtectedRoute>
              <MainLayout>
                <GradosList />
              </MainLayout>
            </ProtectedRoute>
          } />
          <Route path="/practice" element={
            <ProtectedRoute>
              <MainLayout>
                <PracticeChat />
              </MainLayout>
            </ProtectedRoute>
          } />
        </Routes>
      </Router>
    </AuthProvider>
  );
}

export default App;
