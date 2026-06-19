@echo off
echo ========================================================
echo Starting Spanish Learning Platform
echo ========================================================

echo.
echo [1/3] Running Database Migrations and Seeding Data...
cd backend
call php artisan migrate:fresh --seed
cd ..

echo.
echo [2/3] Starting Laravel Backend API on http://localhost:8000 ...
start cmd /k "cd backend && title Laravel Backend && php artisan serve"

echo.
echo [3/3] Starting React Frontend on http://localhost:5173 ...
start cmd /k "cd frontend && title React Frontend && npm run dev"

echo.
echo ========================================================
echo Both servers are starting in new windows!
echo Please open http://localhost:5173 in your browser.
echo ========================================================
pause
