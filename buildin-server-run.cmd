@ECHO OFF

SETLOCAL
chcp 65001
SET RUNDIR=%~dp0
SET "WMDB=%1"
ECHO.
ECHO Starting development php-server
ECHO For end process press "Ctrl+C"
ECHO.
START http://localhost:8888/
%PHPEXE% -S localhost:8888 -c %RUNDIR%sys\php.ini -d include_path=%RUNDIR% -t "%1" sys\router.php
ENDLOCAL

ECHO Don't forget to commit...
pause
