import React, { useState, useEffect } from 'react';
import Swal from 'sweetalert2';
import ResourcesList from './ResourcesList';
import TaskStopwatch from './TaskStopwatch';

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const LearningPath = () => {
  const [weeks, setWeeks] = useState([]);
  const [kpiData, setKpiData] = useState(null);
  const [selectedWeekId, setSelectedWeekId] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const [startDate] = useState(() => {
    const saved = localStorage.getItem('spanish_journey_start_date');
    if (saved) return new Date(saved);
    const now = new Date();
    localStorage.setItem('spanish_journey_start_date', now.toISOString());
    return now;
  });

  const getDeadline = (weekNumber) => {
    return "Aujourd'hui"; // It's a daily action plan
  };

  useEffect(() => {
    const fetchWeeksAndKPIs = async () => {
      try {
        const res = await fetch(`${API_BASE}/weeks`);
        if (!res.ok) throw new Error(`API failed: ${res.status}`);
        
        const data = await res.json();
        const weeksData = data.weeks || [];
        const kpiJson = data.kpi || null;

        setWeeks(weeksData);
        setKpiData(kpiJson);
        if (weeksData.length > 0 && !selectedWeekId) {
          setSelectedWeekId(weeksData[0].id);
        }
        setLoading(false);
      } catch (err) {
        setError(err.message);
        setLoading(false);
      }
    };

    fetchWeeksAndKPIs();
  }, [selectedWeekId]);

  const handleToggleCompletion = async (id) => {
    const week = weeks.find(w => w.id === id);
    if (!week) return;

    if (!week.is_completed && week.checklist && week.checklist.length > 0) {
      let allTasksCompleted = true;
      for (let idx = 0; idx < week.checklist.length; idx++) {
        const item = week.checklist[idx];
        const loggedMinutes = week.task_progress?.[idx] || 0;
        const goalMinutes = item.weekly_goal_minutes || 0;
        if (loggedMinutes < goalMinutes) {
          allTasksCompleted = false;
          break;
        }
      }

      if (!allTasksCompleted) {
        Swal.fire({
          title: 'Incomplete Tasks',
          text: 'You must reach the target time for all weekly tasks before marking this milestone as completed.',
          icon: 'warning',
          background: '#1e293b',
          color: '#fff',
          confirmButtonColor: '#3b82f6'
        });
        return;
      }
    }

    try {
      const response = await fetch(`${API_BASE}/weeks/${id}/toggle-complete`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
      });
      if (response.ok) {
        setWeeks(weeks.map(w => 
          w.id === id ? { ...w, is_completed: !w.is_completed } : w
        ));
      }
    } catch (err) {
      console.error('Error toggling completion:', err);
    }
  };

  const handleLogTime = async (weekId, checklistIdx, minutesToAdd) => {
    const week = weeks.find(w => w.id === weekId);
    if (!week) return;

    let updatedProgress = { ...(week.task_progress || {}) };
    const currentLogged = updatedProgress[checklistIdx] || 0;
    updatedProgress[checklistIdx] = currentLogged + minutesToAdd;

    setWeeks(weeks.map(w => 
      w.id === weekId ? { ...w, task_progress: updatedProgress } : w
    ));

    try {
      await fetch(`${API_BASE}/weeks/${weekId}/log-time`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ taskIndex: checklistIdx, minutes: minutesToAdd })
      });
      
      const res = await fetch(`${API_BASE}/weeks`);
      const data = await res.json();
      setKpiData(data.kpi);

      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
      });
      Toast.fire({
        icon: 'success',
        title: `Logged ${minutesToAdd}m`
      });

    } catch (err) {
      console.error('Error logging time:', err);
    }
  };

  const handleResetProgress = async (weekId) => {
    const result = await Swal.fire({
      title: 'Reset Daily Tracker?',
      text: "You will lose all time logged for this block. This cannot be undone!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#4b5563',
      confirmButtonText: 'Yes, reset it',
      background: '#1e293b',
      color: '#fff'
    });

    if (!result.isConfirmed) return;
    
    setWeeks(weeks.map(w => 
      w.id === weekId ? { ...w, task_progress: null } : w
    ));

    try {
      await fetch(`${API_BASE}/weeks/${weekId}/reset-progress`, {
        method: 'PUT',
      });
      
      const res = await fetch(`${API_BASE}/weeks`);
      const data = await res.json();
      setKpiData(data.kpi);

      Swal.fire({
        title: 'Reset!',
        text: 'Your progress for this block has been cleared.',
        icon: 'success',
        background: '#1e293b',
        color: '#fff',
        confirmButtonColor: '#3b82f6'
      });
    } catch (err) {
      console.error('Error resetting progress:', err);
    }
  };

  const handleResetTaskProgress = async (weekId, checklistIdx) => {
    const result = await Swal.fire({
      title: 'Reset Task?',
      text: "This will clear the time logged for this specific task.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ef4444',
      cancelButtonColor: '#4b5563',
      confirmButtonText: 'Yes, clear it',
      background: '#1e293b',
      color: '#fff'
    });

    if (!result.isConfirmed) return;

    const week = weeks.find(w => w.id === weekId);
    if (!week) return;

    let updatedProgress = { ...(week.task_progress || {}) };
    updatedProgress[checklistIdx] = 0;

    setWeeks(weeks.map(w => 
      w.id === weekId ? { ...w, task_progress: updatedProgress } : w
    ));

    try {
      await fetch(`${API_BASE}/weeks/${weekId}/tasks/${checklistIdx}/reset`, {
        method: 'PUT',
      });
      
      const res = await fetch(`${API_BASE}/weeks`);
      const data = await res.json();
      setKpiData(data.kpi);

    } catch (err) {
      console.error('Error resetting task progress:', err);
    }
  };

  if (loading) return <div className="loader"></div>;

  if (error) return (
    <div style={{ padding: '2rem', textAlign: 'center' }}>
      <h2 style={{color: '#ef4444'}}>Backend Connection Error</h2>
      <p style={{marginTop: '1rem', color: '#fbbf24', fontSize: '1.2rem'}}>{error}</p>
      <p style={{marginTop: '2rem'}}>Could not connect to the Laravel API at {API_BASE}.</p>
    </div>
  );

  const selectedWeek = weeks.find(w => w.id === selectedWeekId);
  const completedCount = weeks.filter(w => w.is_completed).length;
  const progressPercentage = Math.round((completedCount / weeks.length) * 100) || 0;

  return (
    <div className="responsive-flex-layout">
      <aside className="glass-panel responsive-sidebar" style={{ padding: '1.5rem' }}>
        <h2 className="gradient-text" style={{ marginBottom: '2rem', fontSize: '1.5rem' }}>
          Le Chemin vers la Fluidité
        </h2>
        
        <div className="week-list" style={{ flexGrow: 1 }}>
          {weeks.map((week) => (
            <div 
              key={week.id} 
              className={`week-item ${selectedWeekId === week.id ? 'active' : ''} ${week.is_completed ? 'completed' : ''}`}
              onClick={() => setSelectedWeekId(week.id)}
            >
              <div>
                <div className="week-number">{week.title.split(' : ')[0]}</div>
                <div className="week-title">{week.title.split(' : ')[1]}</div>
              </div>
              <div className="status-indicator">
                {week.is_completed && (
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                  </svg>
                )}
              </div>
            </div>
          ))}
        </div>
      </aside>

      <main style={{ flex: 1 }}>
        <section className="glass-panel progress-container dashboard-header" style={{ marginBottom: '2rem' }}>
          <div className="progress-stats">
            <h3>Votre Parcours Quotidien</h3>
            <span style={{ fontSize: '1.2rem', fontWeight: 'bold', color: 'var(--accent-primary)' }}>
              {progressPercentage}% Completed
            </span>
          </div>
          <div className="progress-bar-bg">
            <div className="progress-bar-fill" style={{ width: `${progressPercentage}%` }}></div>
          </div>
        </section>

        <section className="glass-panel" style={{ padding: '1.5rem 2rem', marginBottom: '2rem', background: 'linear-gradient(145deg, rgba(59, 130, 246, 0.05) 0%, rgba(0,0,0,0) 100%)', borderLeft: '4px solid var(--accent-primary)' }}>
          <h3 style={{ color: 'var(--accent-primary)', marginBottom: '1rem', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
            </svg>
            Les Règles d'Or pour Bâtir la Confiance
          </h3>
          <ul style={{ listStyle: 'none', padding: 0, display: 'flex', flexDirection: 'column', gap: '1rem' }}>
            <li>
              <strong>Acceptez l'erreur :</strong> En entretien ou à l'oral, la fluidité prime sur la perfection grammaticale. Un recruteur préférera quelqu'un qui parle avec aisance en faisant quelques fautes de conjugaison, plutôt que quelqu'un de parfait mais qui hésite à chaque mot.
            </li>
            <li>
              <strong>Pensez en blocs, pas en mots :</strong> N'apprenez pas des mots isolés. Apprenez des structures prêtes à l'emploi ("Ce qui me passionne dans ce domaine, c'est...", "Pourriez-vous m'en dire plus sur...").
            </li>
          </ul>
        </section>

        {selectedWeek && (
          <section className="glass-panel week-detail">
            <div className="detail-header">
              <span className="week-number" style={{ fontSize: '1rem', color: 'var(--accent-secondary)' }}>
                {selectedWeek.title.split(' : ')[0]}
              </span>
              <h1 style={{ fontSize: '2.5rem', marginTop: '0.5rem' }}>{selectedWeek.title.split(' : ')[1]}</h1>
            </div>

            <div className="detail-section">
              <h3>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{marginRight: '8px', verticalAlign: 'middle'}}>
                  <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                  <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                </svg>
                Focus & Strategy
              </h3>
              <p>{selectedWeek.focus}</p>
              
              <ResourcesList week={selectedWeek} />
            </div>

            <div className="detail-section" style={{ background: 'rgba(59, 130, 246, 0.05)', borderColor: 'rgba(59, 130, 246, 0.1)' }}>
              <h3 style={{ color: 'var(--accent-secondary)' }}>
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{marginRight: '8px', verticalAlign: 'middle'}}>
                  <circle cx="12" cy="8" r="7"></circle>
                  <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline>
                </svg>
                Milestone Target
              </h3>
              <p>{selectedWeek.milestone}</p>
              
              {selectedWeek.checklist && selectedWeek.checklist.length > 0 && (
                <div style={{ marginTop: '2rem' }}>
                  <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1rem' }}>
                    <div style={{ display: 'flex', alignItems: 'center', gap: '1rem' }}>
                      <h4 style={{ fontSize: '1rem', color: 'var(--text-primary)', margin: 0 }}>Daily Tracker</h4>
                      <button 
                        onClick={() => handleResetProgress(selectedWeek.id)}
                        style={{ background: 'transparent', border: '1px solid var(--danger)', color: 'var(--danger)', padding: '2px 8px', borderRadius: '4px', fontSize: '0.75rem', cursor: 'pointer' }}
                      >
                        Reset Progress
                      </button>
                    </div>
                    <span style={{ fontSize: '0.85rem', color: 'var(--accent-secondary)', background: 'rgba(59, 130, 246, 0.1)', padding: '4px 10px', borderRadius: '6px', fontWeight: '500' }}>
                        📅 Due: {getDeadline(selectedWeek.week_number)}
                    </span>
                  </div>
                  <ul style={{ listStyle: 'none', padding: 0 }}>
                    {selectedWeek.checklist.map((item, idx) => {
                      const loggedMinutes = selectedWeek.task_progress?.[idx] || 0;
                      const goalMinutes = item.weekly_goal_minutes || 0;
                      const percentage = goalMinutes > 0 ? Math.min(Math.round((loggedMinutes / goalMinutes) * 100), 100) : 0;
                      const isCompleted = loggedMinutes >= goalMinutes;
                      const remainingMinutes = Math.max(goalMinutes - loggedMinutes, 0);

                      return (
                        <li key={idx} style={{ background: 'rgba(0,0,0,0.02)', padding: '1rem', borderRadius: '8px', marginBottom: '1rem', border: '1px solid var(--glass-border)' }}>
                          <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '0.5rem' }}>
                            <div style={{ display: 'flex', flexDirection: 'column', gap: '0.25rem' }}>
                              <span style={{ color: isCompleted ? 'var(--success)' : 'var(--text-primary)', fontSize: '0.95rem', fontWeight: '500', textDecoration: isCompleted ? 'line-through' : 'none' }}>
                                {item.task}
                              </span>
                              {item.resource && (
                                <a href={item.resource.url} target="_blank" rel="noopener noreferrer" style={{ fontSize: '0.8rem', color: 'var(--accent-primary)', textDecoration: 'none', display: 'flex', alignItems: 'center', gap: '4px' }}>
                                  <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                                    <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path>
                                    <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path>
                                  </svg>
                                  {item.resource.title}
                                </a>
                              )}
                            </div>
                            <span style={{ fontSize: '0.8rem', color: isCompleted ? 'var(--success)' : 'var(--accent-secondary)', whiteSpace: 'nowrap', marginLeft: '1rem' }}>
                              {isCompleted ? 'Goal Reached!' : `${remainingMinutes}m remaining`}
                            </span>
                          </div>

                          <div style={{ background: 'rgba(0,0,0,0.08)', height: '6px', borderRadius: '3px', marginBottom: '0.75rem', overflow: 'hidden' }}>
                            <div style={{ width: `${percentage}%`, height: '100%', background: isCompleted ? 'var(--success)' : 'var(--accent-primary)', transition: 'width 0.3s' }}></div>
                          </div>

                          <div style={{ display: 'flex', gap: '0.5rem', alignItems: 'center', flexWrap: 'wrap' }}>
                            <span style={{ fontSize: '0.8rem', color: 'var(--text-secondary)', marginRight: 'auto' }}>
                              Logged: {Math.floor(loggedMinutes / 60)}h {loggedMinutes % 60}m / {Math.floor(goalMinutes / 60)}h {goalMinutes % 60}m
                            </span>
                            {!isCompleted && (
                              <>
                                <TaskStopwatch onLogTime={(mins) => handleLogTime(selectedWeek.id, idx, mins)} />
                                <div style={{ borderLeft: '1px solid var(--glass-border)', height: '16px', margin: '0 4px' }}></div>
                                <button onClick={() => handleLogTime(selectedWeek.id, idx, 15)} style={{ background: 'var(--bg-secondary)', border: '1px solid var(--glass-border)', color: 'var(--text-primary)', padding: '2px 8px', borderRadius: '4px', fontSize: '0.8rem', cursor: 'pointer' }}>+15m</button>
                                <button onClick={() => handleLogTime(selectedWeek.id, idx, 30)} style={{ background: 'var(--bg-secondary)', border: '1px solid var(--glass-border)', color: 'var(--text-primary)', padding: '2px 8px', borderRadius: '4px', fontSize: '0.8rem', cursor: 'pointer' }}>+30m</button>
                                <button onClick={() => handleLogTime(selectedWeek.id, idx, 60)} style={{ background: 'var(--bg-secondary)', border: '1px solid var(--glass-border)', color: 'var(--text-primary)', padding: '2px 8px', borderRadius: '4px', fontSize: '0.8rem', cursor: 'pointer' }}>+60m</button>
                              </>
                            )}
                            {loggedMinutes > 0 && (
                              <button 
                                onClick={() => handleResetTaskProgress(selectedWeek.id, idx)} 
                                style={{ background: 'transparent', border: '1px solid var(--danger)', color: 'var(--danger)', padding: '2px 6px', borderRadius: '4px', fontSize: '0.8rem', cursor: 'pointer', marginLeft: '0.5rem' }}
                                title="Reset this task's time to 0"
                              >
                                ↺
                              </button>
                            )}
                          </div>
                        </li>
                      );
                    })}
                  </ul>
                </div>
              )}
            </div>

            {selectedWeek.exam_links && selectedWeek.exam_links.length > 0 && (
              <div className="detail-section" style={{ background: 'rgba(16, 185, 129, 0.05)', borderColor: 'rgba(16, 185, 129, 0.1)' }}>
                 <h3 style={{ color: 'var(--success)' }}>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" style={{marginRight: '8px', verticalAlign: 'middle'}}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Official Practice Exams
                </h3>
                <p style={{ color: 'var(--text-secondary)', marginBottom: '1rem' }}>Test your knowledge with these real exams from official sources matching your current milestone.</p>
                <div style={{ display: 'flex', flexDirection: 'column', gap: '1rem' }}>
                  {selectedWeek.exam_links.map((exam, idx) => (
                    <a key={idx} href={exam.url} target="_blank" rel="noopener noreferrer" style={{ display: 'flex', alignItems: 'center', gap: '0.75rem', padding: '1rem', background: 'rgba(0,0,0,0.02)', borderRadius: '8px', color: 'var(--text-primary)', textDecoration: 'none', border: '1px solid var(--glass-border)', transition: 'background 0.2s' }}>
                      <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="var(--success)">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                      </svg>
                      {exam.title}
                    </a>
                  ))}
                </div>
              </div>
            )}

            <button 
              className={`btn ${selectedWeek.is_completed ? 'btn-success' : 'btn-primary'}`}
              onClick={() => handleToggleCompletion(selectedWeek.id)}
              style={{ marginTop: '2rem' }}
            >
              {selectedWeek.is_completed ? (
                <>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                  </svg>
                  Milestone Completed! Click to Undo
                </>
              ) : (
                <>
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polygon points="10 8 16 12 10 16 10 8"></polygon>
                  </svg>
                  Mark Milestone as Complete
                </>
              )}
            </button>
          </section>
        )}
      </main>
    </div>
  );
};

export default LearningPath;
