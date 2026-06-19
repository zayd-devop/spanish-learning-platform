import React, { useState, useEffect } from 'react';
import Swal from 'sweetalert2';

const TaskStopwatch = ({ onLogTime }) => {
  const [isRunning, setIsRunning] = useState(false);
  const [seconds, setSeconds] = useState(0);

  useEffect(() => {
    let interval = null;
    if (isRunning) {
      interval = setInterval(() => {
        setSeconds(s => s + 1);
      }, 1000);
    } else if (!isRunning && seconds !== 0) {
      clearInterval(interval);
    }
    return () => clearInterval(interval);
  }, [isRunning, seconds]);

  const handleStart = () => setIsRunning(true);
  
  const handlePause = () => setIsRunning(false);
  
  const handleStopAndLog = () => {
    setIsRunning(false);
    const minutes = Math.floor(seconds / 60);
    const extraSeconds = seconds % 60;
    
    let minutesToLog = minutes;
    // Round up if they studied for more than 30 seconds of the final minute
    if (extraSeconds > 30) {
        minutesToLog += 1;
    }

    if (minutesToLog > 0) {
      onLogTime(minutesToLog);
    } else {
      Swal.fire({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000,
        icon: 'info',
        title: 'Too short to log!',
        text: 'Study for at least 30 seconds.'
      });
    }
    setSeconds(0);
  };

  const handleCancel = () => {
    setIsRunning(false);
    setSeconds(0);
  };

  const formatTime = (totalSeconds) => {
    const h = Math.floor(totalSeconds / 3600);
    const m = Math.floor((totalSeconds % 3600) / 60).toString().padStart(2, '0');
    const s = (totalSeconds % 60).toString().padStart(2, '0');
    if (h > 0) return `${h}:${m}:${s}`;
    return `${m}:${s}`;
  };

  if (!isRunning && seconds === 0) {
    return (
      <button 
        onClick={handleStart} 
        style={{ 
          background: 'var(--accent-primary)', 
          border: 'none', 
          color: 'white', 
          padding: '4px 10px', 
          borderRadius: '4px', 
          fontSize: '0.8rem', 
          cursor: 'pointer', 
          display: 'flex', 
          alignItems: 'center', 
          gap: '4px' 
        }}
        title="Start Live Stopwatch"
      >
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
          <circle cx="12" cy="12" r="10"></circle>
          <polyline points="12 6 12 12 16 14"></polyline>
        </svg>
        Start
      </button>
    );
  }

  return (
    <div style={{ display: 'flex', alignItems: 'center', gap: '8px', background: 'rgba(59, 130, 246, 0.15)', padding: '4px 8px', borderRadius: '6px', border: '1px solid rgba(59, 130, 246, 0.3)' }}>
      <span style={{ fontFamily: 'monospace', fontWeight: 'bold', fontSize: '0.9rem', color: 'var(--accent-primary)', minWidth: '45px', textAlign: 'center' }}>
        {formatTime(seconds)}
      </span>
      
      {isRunning ? (
        <button onClick={handlePause} style={{ background: 'transparent', border: 'none', color: 'var(--text-secondary)', cursor: 'pointer', fontSize: '0.9rem', padding: '0 4px' }} title="Pause">
          ⏸
        </button>
      ) : (
        <button onClick={handleStart} style={{ background: 'transparent', border: 'none', color: 'var(--success)', cursor: 'pointer', fontSize: '0.9rem', padding: '0 4px' }} title="Resume">
          ▶
        </button>
      )}
      
      <button onClick={handleStopAndLog} style={{ background: 'var(--success)', border: 'none', color: 'white', padding: '2px 8px', borderRadius: '4px', fontSize: '0.75rem', cursor: 'pointer', fontWeight: 'bold' }}>
        Log Time
      </button>

      <button onClick={handleCancel} style={{ background: 'transparent', border: 'none', color: 'var(--danger)', cursor: 'pointer', fontSize: '0.85rem', padding: '0 4px' }} title="Cancel Timer">
        ✖
      </button>
    </div>
  );
};

export default TaskStopwatch;
