@echo off
echo Creating storage link for Laravel project...
cd /d "%~dp0public"

REM Remove existing storage directory/link if exists
if exist storage (
    rmdir storage /s /q 2>nul
    del storage 2>nul
)

REM Create junction link
mklink /J storage ..\storage\app\public

if %errorlevel% == 0 (
    echo SUCCESS: Storage link created successfully!
    echo You can now access images at: http://localhost:8000/storage/
) else (
    echo ERROR: Failed to create storage link
    echo Please run this file as Administrator
)

echo.
echo Press any key to exit...
pause >nul
