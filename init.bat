@echo off
echo ========================================================
echo Initializing Spanish Learning Platform Projects
echo ========================================================

echo.
echo [1/3] Creating Laravel Backend (this may take a minute)...
call composer create-project laravel/laravel backend

echo.
echo [2/3] Creating ReactJS Frontend...
call npx -y create-vite@latest frontend --template react

echo.
echo [3/3] Setting up Database...
echo Please ensure you have created a MySQL database named 'spanish_learning'.
echo You can do this by running: mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS spanish_learning;"

echo.
echo ========================================================
echo Done! Please let Antigravity know when you have finished running this script.
echo ========================================================
pause
