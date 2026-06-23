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
      title: 'Total Immersion Time',
      value: formatHours(data.totalMinutes),
      subtitle: 'Total logged hours',
      icon: '⏱️',
      color: 'var(--accent-primary)'
    },
    {
      title: 'Global Completion',
      value: `${data.completionRate}%`,
      subtitle: 'Curriculum progress',
      icon: '📈',
      color: 'var(--success)'
    },
    {
      title: 'Weekly Velocity',
      value: `${data.weeklyVelocity} Tasks`,
      subtitle: `Completed in Week ${data.currentWeek}`,
      icon: '🚀',
      color: '#f59e0b'
    },
    {
      title: 'Current Milestone',
      value: data.milestone,
      subtitle: 'Fluency level target',
      icon: '🏆',
      color: '#8b5cf6'
    }
  ];

  return (
    <div style={{ marginBottom: '2.5rem' }}>
      <h2 style={{ fontSize: '1.5rem', fontWeight: 'bold', color: 'var(--text-primary)', marginBottom: '1rem' }}>
        Performance Metrics
      </h2>
      <div style={{ 
        display: 'grid', 
        gridTemplateColumns: 'repeat(auto-fit, minmax(220px, 1fr))', 
        gap: '1rem' 
      }}>
        {kpiCards.map((kpi, idx) => (
          <div key={idx} className={`hover-lift animate-slide-up stagger-${idx + 1}`} style={{
            background: 'var(--bg-secondary)',
            border: '1px solid var(--glass-border)',
            borderRadius: '12px',
            padding: '1.25rem',
            display: 'flex',
            alignItems: 'center',
            gap: '1rem',
            boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)'
          }}>
            <div style={{
              width: '48px',
              height: '48px',
              borderRadius: '12px',
              background: `color-mix(in srgb, ${kpi.color} 20%, transparent)`,
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              fontSize: '1.5rem'
            }}>
              {kpi.icon}
            </div>
            <div>
              <p style={{ margin: 0, fontSize: '0.85rem', color: 'var(--text-secondary)', fontWeight: '500' }}>
                {kpi.title}
              </p>
              <h3 style={{ margin: '0.25rem 0', fontSize: '1.25rem', color: 'var(--text-primary)', fontWeight: 'bold' }}>
                {kpi.value}
              </h3>
              <p style={{ margin: 0, fontSize: '0.75rem', color: kpi.color, fontWeight: '600' }}>
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
