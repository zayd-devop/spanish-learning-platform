import React from 'react';
import './index.css';
import { AuthProvider, useAuth } from './context/AuthContext';
import { BrowserRouter as Router, Routes, Route, Navigate } from 'react-router-dom';
import Navbar from './components/Navbar';
import Sidebar from './components/Sidebar';
import Login from './components/Login';
import Register from './components/Register';
import LicencesList from './components/LicencesList';
import LearningPath from './components/LearningPath';
import Dashboard from './components/Dashboard';
import PracticeChat from './components/PracticeChat';
import CampusFranceGuide from './components/CampusFranceGuide';
import InterviewSimulator from './components/InterviewSimulator';
import DocumentManager from './components/DocumentManager';
import BudgetPlanner from './components/BudgetPlanner';
import CoverLetterGenerator from './components/CoverLetterGenerator';

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
          <Route path="/licences" element={
            <ProtectedRoute>
              <MainLayout>
                <LicencesList />
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
          <Route path="/guide-france" element={
            <ProtectedRoute>
              <MainLayout>
                <CampusFranceGuide />
              </MainLayout>
            </ProtectedRoute>
          } />
          <Route path="/interview-simulator" element={
            <ProtectedRoute>
              <MainLayout>
                <InterviewSimulator />
              </MainLayout>
            </ProtectedRoute>
          } />
          <Route path="/documents" element={
            <ProtectedRoute>
              <MainLayout>
                <DocumentManager />
              </MainLayout>
            </ProtectedRoute>
          } />
          <Route path="/budget" element={
            <ProtectedRoute>
              <MainLayout>
                <BudgetPlanner />
              </MainLayout>
            </ProtectedRoute>
          } />
          <Route path="/cover-letter" element={
            <ProtectedRoute>
              <MainLayout>
                <CoverLetterGenerator />
              </MainLayout>
            </ProtectedRoute>
          } />
        </Routes>
      </Router>
    </AuthProvider>
  );
}

export default App;
