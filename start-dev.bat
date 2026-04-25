@echo off
echo Starting Laravel server and NPM watch...

:: Run php artisan serve in a new window
start cmd /k "php artisan serve"

:: Run npm run watch in another new window
start cmd /k "npm run watch"

echo Both processes started!
pause
