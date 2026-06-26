import React, { useState, useEffect } from 'react';
import StudentKPIs from './StudentKPIs';
import { BarChart, Bar, XAxis, YAxis, Tooltip, ResponsiveContainer, CartesianGrid, LineChart, Line, PieChart, Pie, Cell, AreaChart, Area } from 'recharts';

import WordOfTheDay from './WordOfTheDay';
import { useAuth } from '../context/AuthContext';

const API_BASE = import.meta.env.VITE_API_BASE_URL || 'http://127.0.0.1:8000/api';

const Dashboard = () => {
    const { token } = useAuth();
    const [kpiData, setKpiData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [currentPath, setCurrentPath] = useState('zero_to_hero');

    const [weeklyTimeData, setWeeklyTimeData] = useState([]);
    const [weeklyTasksData, setWeeklyTasksData] = useState([]);
    const [completionData, setCompletionData] = useState([
        { name: 'Completed', value: 0 },
        { name: 'Remaining', value: 1 }
    ]);

    const COLORS = ['#10b981', '#334155'];

    useEffect(() => {
        const fetchKPIs = async () => {
            if (!token) return;
            try {
                const res = await fetch(`${API_BASE}/weeks?path=${currentPath}`, {
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });
                const data = await res.json();
                
                setKpiData(data.kpi);

                // Build dynamic Weekly Time Data & Tasks Data
                const dynamicWeeklyTimeData = [];
                const dynamicWeeklyTasksData = [];
                
                data.weeks.forEach(week => {
                    let totalMins = 0;
                    let tasksCompleted = 0;
                    
                    const checklist = week.checklist || [];
                    const progress = week.task_progress || {};

                    checklist.forEach((item, i) => {
                        const goal = item.weekly_goal_minutes || 0;
                        const logged = progress[i] ? Number(progress[i]) : 0;
                        if (goal > 0 && logged >= goal) {
                            tasksCompleted++;
                        }
                    });

                    if (week.task_progress) {
                        totalMins = Object.values(week.task_progress).reduce((a, b) => a + Number(b), 0);
                    }

                    dynamicWeeklyTimeData.push({
                        name: 'W' + week.week_number,
                        minutes: totalMins
                    });
                    dynamicWeeklyTasksData.push({
                        name: 'W' + week.week_number,
                        completed: tasksCompleted
                    });
                });
                setWeeklyTimeData(dynamicWeeklyTimeData);
                setWeeklyTasksData(dynamicWeeklyTasksData);

                // Build dynamic Curriculum Progress Data
                let completedTasks = 0;
                let remainingTasks = 0;
                
                data.weeks.forEach(week => {
                    const checklist = week.checklist || [];
                    const progress = week.task_progress || {};
                    
                    checklist.forEach((item, i) => {
                        const goal = item.weekly_goal_minutes || 0;
                        const logged = progress[i] ? Number(progress[i]) : 0;
                        
                        if (goal > 0 && logged >= goal) {
                            completedTasks++;
                        } else {
                            remainingTasks++;
                        }
                    });
                });

                const newCompletionData = [];
                if (completedTasks > 0) {
                    newCompletionData.push({ name: 'Completed', value: completedTasks });
                }
                if (remainingTasks > 0) {
                    newCompletionData.push({ name: 'Remaining', value: remainingTasks });
                }

                // Avoid empty chart if there are no tasks
                if (newCompletionData.length === 0) {
                    newCompletionData.push({ name: 'Remaining', value: 1 });
                }

                setCompletionData(newCompletionData);

                setLoading(false);
            } catch (err) {
                console.error("Failed to load dashboard data", err);
                setLoading(false);
            }
        };
        fetchKPIs();
    }, [token, currentPath]);

    if (loading) return <div className="loader"></div>;

    return (
        <div className="dashboard-container" style={{ animation: 'fadeIn 0.5s ease-out' }}>
            <div className="dashboard-header-flex" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end', marginBottom: '2.5rem' }}>
                <div>
                    <h1 className="gradient-text dashboard-title" style={{ marginBottom: '0.5rem', fontWeight: '800' }}>Analytics Dashboard</h1>
                    <p style={{ color: 'var(--text-secondary)', fontSize: '1.1rem' }}>Track your fluency journey and learning metrics in real-time.</p>
                </div>
                <div className="dashboard-filters" style={{ display: 'flex', gap: '0.5rem', background: 'rgba(255,255,255,0.05)', padding: '0.5rem', borderRadius: '12px', border: '1px solid var(--glass-border)', alignItems: 'center' }}>
                    <label style={{ color: 'var(--text-secondary)', fontSize: '0.9rem', fontWeight: '600', marginLeft: '0.5rem' }}>Track:</label>
                    <select 
                        value={currentPath}
                        onChange={(e) => setCurrentPath(e.target.value)}
                        style={{ background: 'white', color: 'var(--text-primary)', border: '1px solid var(--glass-border)', padding: '0.4rem 0.8rem', borderRadius: '8px', fontWeight: '500', outline: 'none', cursor: 'pointer' }}
                    >
                        <option value="zero_to_hero">Zero to Hero Sprint</option>
                        <option value="standard">Standard Path</option>
                    </select>
                    
                    <label style={{ color: 'var(--text-secondary)', fontSize: '0.9rem', fontWeight: '600', marginLeft: '0.5rem' }}>Filter by Date:</label>
                    <input type="date" defaultValue={new Date().toLocaleDateString('en-CA')} style={{ background: 'white', color: 'var(--text-primary)', border: '1px solid var(--glass-border)', padding: '0.4rem 0.8rem', borderRadius: '8px', fontWeight: '500', outline: 'none', cursor: 'pointer' }} />
                </div>
            </div>

            {/* Smart Alerts */}
            <div className="glass-panel smart-alert-flex" style={{ background: 'linear-gradient(90deg, rgba(239,68,68,0.15) 0%, rgba(239,68,68,0.05) 100%)', borderColor: 'rgba(239, 68, 68, 0.3)', marginBottom: '2.5rem', padding: '1.5rem 2rem', display: 'flex', alignItems: 'center', gap: '1.5rem', borderRadius: '16px', boxShadow: '0 10px 30px -10px rgba(239,68,68,0.2)' }}>
                <div style={{ background: 'linear-gradient(135deg, #ef4444 0%, #b91c1c 100%)', color: 'white', width: '48px', height: '48px', borderRadius: '12px', display: 'flex', alignItems: 'center', justifyContent: 'center', fontSize: '1.8rem', fontWeight: '900', boxShadow: '0 4px 12px rgba(239,68,68,0.4)', flexShrink: 0 }}>
                    !
                </div>
                <div>
                    <h3 style={{ color: 'var(--danger)', margin: '0 0 0.25rem 0', fontSize: '1.2rem', fontWeight: 'bold' }}>Action Required</h3>
                    <p style={{ margin: 0, color: '#991b1b', fontSize: '1rem', fontWeight: '500' }}>You haven't logged any study time in the last 3 days. Consistency is key to language acquisition!</p>
                </div>
            </div>

            <StudentKPIs data={kpiData} />

            <div className="responsive-grid-2-1" style={{ marginTop: '2.5rem' }}>
                {/* Left Column */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '2.5rem' }}>
                    {/* Time Logged Chart */}
                    <div className="glass-panel hover-glow" style={{ padding: '1.5rem', borderRadius: '20px', background: 'linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(0,0,0,0) 100%)' }}>
                        <h3 style={{ marginBottom: '1.5rem', fontSize: '1.2rem', color: 'var(--text-primary)', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="var(--accent-primary)" strokeWidth="2">
                                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                            </svg>
                            Study Time per Week (Minutes)
                        </h3>
                        <div style={{ height: '240px' }}>
                            <ResponsiveContainer width="100%" height="100%">
                                <AreaChart data={weeklyTimeData} margin={{ top: 10, right: 10, left: -20, bottom: 0 }}>
                                    <defs>
                                        <linearGradient id="colorMinutesFlow" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="5%" stopColor="#3b82f6" stopOpacity={0.5}/>
                                            <stop offset="95%" stopColor="#3b82f6" stopOpacity={0.0}/>
                                        </linearGradient>
                                    </defs>
                                    <CartesianGrid strokeDasharray="3 3" stroke="rgba(0,0,0,0.05)" vertical={false} />
                                    <XAxis dataKey="name" stroke="#64748b" tickLine={false} axisLine={false} tickMargin={10} />
                                    <YAxis stroke="#64748b" tickLine={false} axisLine={false} tickMargin={10} />
                                    <Tooltip cursor={{ stroke: '#3b82f6', strokeWidth: 1.5, strokeDasharray: '4 4' }} contentStyle={{ backgroundColor: 'rgba(255,255,255,0.95)', border: '1px solid rgba(59,130,246,0.2)', borderRadius: '12px', boxShadow: '0 4px 20px -2px rgba(0,0,0,0.1)' }} />
                                    <Area type="monotone" dataKey="minutes" stroke="#3b82f6" strokeWidth={4} fillOpacity={1} fill="url(#colorMinutesFlow)" activeDot={{ r: 6, fill: '#3b82f6', stroke: '#fff', strokeWidth: 2, style: { filter: 'drop-shadow(0px 4px 6px rgba(59,130,246,0.4))' } }} />
                                </AreaChart>
                            </ResponsiveContainer>
                        </div>
                    </div>

                    {/* Tasks Completed Bar Chart */}
                    <div className="glass-panel hover-glow" style={{ padding: '1.5rem', borderRadius: '20px', background: 'linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(0,0,0,0) 100%)' }}>
                        <h3 style={{ marginBottom: '1.5rem', fontSize: '1.2rem', color: 'var(--text-primary)', display: 'flex', alignItems: 'center', gap: '0.5rem' }}>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8b5cf6" strokeWidth="2">
                                <path d="M22 11.08V12a10 10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            Tasks Completed per Week
                        </h3>
                        <div style={{ height: '240px' }}>
                            <ResponsiveContainer width="100%" height="100%">
                                <AreaChart data={weeklyTasksData} margin={{ top: 10, right: 10, left: -20, bottom: 0 }}>
                                    <defs>
                                        <linearGradient id="colorTasksFlow" x1="0" y1="0" x2="0" y2="1">
                                            <stop offset="5%" stopColor="#8b5cf6" stopOpacity={0.5}/>
                                            <stop offset="95%" stopColor="#8b5cf6" stopOpacity={0.0}/>
                                        </linearGradient>
                                    </defs>
                                    <CartesianGrid strokeDasharray="3 3" stroke="rgba(0,0,0,0.05)" vertical={false} />
                                    <XAxis dataKey="name" stroke="#64748b" tickLine={false} axisLine={false} tickMargin={10} />
                                    <YAxis stroke="#64748b" tickLine={false} axisLine={false} tickMargin={10} allowDecimals={false} />
                                    <Tooltip cursor={{ stroke: '#8b5cf6', strokeWidth: 1.5, strokeDasharray: '4 4' }} contentStyle={{ backgroundColor: 'rgba(255,255,255,0.95)', border: '1px solid rgba(139,92,246,0.2)', borderRadius: '12px', boxShadow: '0 4px 20px -2px rgba(0,0,0,0.1)' }} />
                                    <Area type="monotone" dataKey="completed" stroke="#8b5cf6" strokeWidth={4} fillOpacity={1} fill="url(#colorTasksFlow)" activeDot={{ r: 6, fill: '#8b5cf6', stroke: '#fff', strokeWidth: 2, style: { filter: 'drop-shadow(0px 4px 6px rgba(139,92,246,0.4))' } }} />
                                </AreaChart>
                            </ResponsiveContainer>
                        </div>
                    </div>
                </div>

                {/* Right Column */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '2.5rem' }}>
                    {/* Completion Donut Chart */}
                    <div className="glass-panel hover-glow" style={{ padding: '1.5rem', borderRadius: '20px', display: 'flex', flexDirection: 'column', background: 'linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(0,0,0,0) 100%)' }}>
                        <h3 style={{ marginBottom: '1rem', fontSize: '1.2rem', color: 'var(--text-primary)', textAlign: 'center' }}>Curriculum Progress</h3>
                        <div style={{ height: '240px', display: 'flex', alignItems: 'center', justifyContent: 'center', position: 'relative' }}>
                            <div style={{ position: 'absolute', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', pointerEvents: 'none', zIndex: 10 }}>
                                <span style={{ fontSize: '1.75rem', fontWeight: '800', color: 'var(--text-primary)', lineHeight: '1', marginBottom: '4px' }}>
                                    {Math.round(((completionData.find(d => d.name === 'Completed')?.value || 0) / ((completionData.find(d => d.name === 'Completed')?.value || 0) + (completionData.find(d => d.name === 'Remaining')?.value || 0))) * 100) || 0}%
                                </span>
                                <span style={{ fontSize: '0.75rem', color: 'var(--text-secondary)', fontWeight: '600', textTransform: 'uppercase', letterSpacing: '1px' }}>
                                    Done
                                </span>
                            </div>
                            <ResponsiveContainer width="100%" height="100%">
                                <PieChart>
                                    <Pie
                                        data={completionData}
                                        cx="50%"
                                        cy="50%"
                                        startAngle={90}
                                        endAngle={-270}
                                        innerRadius={80}
                                        outerRadius={100}
                                        paddingAngle={completionData.length > 1 ? 8 : 0}
                                        dataKey="value"
                                        stroke="none"
                                        cornerRadius={5}
                                    >
                                        {completionData.map((entry, index) => {
                                            const color = entry.name === 'Completed' ? '#10b981' : '#334155';
                                            return <Cell key={`cell-${index}`} fill={color} style={{ filter: `drop-shadow(0px 4px 8px ${color}40)` }} />;
                                        })}
                                    </Pie>
                                    <Tooltip contentStyle={{ backgroundColor: 'rgba(255,255,255,0.95)', border: '1px solid rgba(0,0,0,0.1)', borderRadius: '12px', color: 'var(--text-primary)', boxShadow: '0 4px 6px -1px rgba(0,0,0,0.1)' }} itemStyle={{ color: 'var(--text-primary)' }} />
                                </PieChart>
                            </ResponsiveContainer>
                        </div>
                        <div style={{ display: 'flex', justifyContent: 'center', gap: '2rem', marginTop: '1.5rem', background: 'rgba(0,0,0,0.04)', padding: '1rem', borderRadius: '12px', border: '1px solid rgba(0,0,0,0.05)' }}>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '0.75rem' }}>
                                <div style={{ width: '14px', height: '14px', background: COLORS[0], borderRadius: '4px' }}></div>
                                <span style={{ fontSize: '1rem', fontWeight: '500', color: 'var(--text-primary)' }}>Completed</span>
                            </div>
                            <div style={{ display: 'flex', alignItems: 'center', gap: '0.75rem' }}>
                                <div style={{ width: '14px', height: '14px', background: COLORS[1], borderRadius: '4px' }}></div>
                                <span style={{ fontSize: '1rem', fontWeight: '500', color: 'var(--text-secondary)' }}>Remaining</span>
                            </div>
                        </div>
                    </div>

                    {/* Word of the Day Widget */}
                    <WordOfTheDay />
                </div>
            </div>
        </div>
    );
};

export default Dashboard;
