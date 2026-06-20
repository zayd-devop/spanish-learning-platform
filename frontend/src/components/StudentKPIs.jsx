import React from 'react';

const StudentKPIs = ({ data }) => {
  if (!data) return null;

  const formatHours = (totalMinutes) => {
    const h = Math.floor(totalMinutes / 60);
    const m = totalMinutes % 60;
    return `${h}h ${m}m`;
  };

  const kpiCards = [
    {
      title: 'Total Time',
      value: formatHours(data.totalMinutes),
      subtitle: 'Logged',
      icon: (
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
      ),
      color: '#3b82f6',
      bgGradient: 'linear-gradient(135deg, rgba(59, 130, 246, 0.12) 0%, rgba(59, 130, 246, 0.03) 100%)'
    },
    {
      title: 'Completion',
      value: `${data.completionRate}%`,
      subtitle: 'Curriculum',
      icon: (
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline></svg>
      ),
      color: '#10b981',
      bgGradient: 'linear-gradient(135deg, rgba(16, 185, 129, 0.12) 0%, rgba(16, 185, 129, 0.03) 100%)'
    },
    {
      title: 'Velocity',
      value: data.weeklyVelocity,
      subtitle: `Tasks / W${data.currentWeek}`,
      icon: (
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
      ),
      color: '#f59e0b',
      bgGradient: 'linear-gradient(135deg, rgba(245, 158, 11, 0.12) 0%, rgba(245, 158, 11, 0.03) 100%)'
    },
    {
      title: 'Milestone',
      value: data.milestone,
      subtitle: 'Target',
      icon: (
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5" strokeLinecap="round" strokeLinejoin="round"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"></path><path d="M18 9h1.5a2.5 2.5 0 0 0 0-5H18"></path><path d="M4 22h16"></path><path d="M10 14.66V17c0 .55-.47.98-.97 1.21C7.85 18.75 7 20.24 7 22"></path><path d="M14 14.66V17c0 .55.47.98.97 1.21C16.15 18.75 17 20.24 17 22"></path><path d="M18 2H6v7a6 6 0 0 0 12 0V2Z"></path></svg>
      ),
      color: '#8b5cf6',
      bgGradient: 'linear-gradient(135deg, rgba(139, 92, 246, 0.12) 0%, rgba(139, 92, 246, 0.03) 100%)'
    }
  ];

  return (
    <div style={{ marginBottom: '2.5rem' }}>
      <div style={{ 
        display: 'grid', 
        gridTemplateColumns: 'repeat(auto-fit, minmax(140px, 1fr))', 
        gap: '1rem' 
      }}>
        {kpiCards.map((kpi, idx) => (
          <div key={idx} style={{
            background: kpi.bgGradient,
            border: `1px solid ${kpi.color}30`,
            borderRadius: '16px',
            padding: '1.25rem',
            position: 'relative',
            overflow: 'hidden',
            display: 'flex',
            flexDirection: 'column',
            justifyContent: 'space-between',
            boxShadow: `0 4px 15px -3px ${kpi.color}15`,
            backdropFilter: 'blur(10px)',
            minHeight: '130px'
          }}>
            {/* Abstract Background Icon */}
            <div style={{
              position: 'absolute',
              right: '-15px',
              top: '10px',
              opacity: '0.07',
              transform: 'scale(3.5)',
              color: kpi.color,
              pointerEvents: 'none'
            }}>
              {kpi.icon}
            </div>

            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start' }}>
                <span style={{ fontSize: '0.85rem', color: 'var(--text-secondary)', fontWeight: '700', textTransform: 'uppercase', letterSpacing: '0.5px', zIndex: 1 }}>
                    {kpi.title}
                </span>
                <div style={{ color: kpi.color, zIndex: 1, padding: '6px', background: `${kpi.color}15`, borderRadius: '10px', display: 'flex' }}>
                    {kpi.icon}
                </div>
            </div>

            <div style={{ zIndex: 1, marginTop: '1rem' }}>
              <h3 style={{ margin: '0', fontSize: '1.6rem', color: 'var(--text-primary)', fontWeight: '900', letterSpacing: '-0.5px', whiteSpace: 'nowrap' }}>
                {kpi.value}
              </h3>
              <p style={{ margin: '0.25rem 0 0 0', fontSize: '0.8rem', color: kpi.color, fontWeight: '700' }}>
                {kpi.subtitle}
              </p>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default StudentKPIs;
