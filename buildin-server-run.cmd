@ECHO OFF

SETLOCAL
chcp 65001
SET RUNDIR=%~dp0
SET PATH=%windir%;%windir%\system32;%RUNDIR%;%RUNDIR%sys\php
ECHO.
ECHO Starting development php-server
ECHO For end process press "Ctrl+C"
ECHO.
START http://localhost:8888/
::sys\php\php.exe -S localhost:8888 -c %RUNDIR%sys\php\php.ini -t %RUNDIR% sys\router.php
sys\php\php.exe -S localhost:8888 -c %RUNDIR%sys\php\php.ini -d include_path=%RUNDIR% -t "%1" sys\router.php
ENDLOCAL

ECHO Don't forget to commit...
pause
