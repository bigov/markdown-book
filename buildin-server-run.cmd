@ECHO OFF
SETLOCAL

chcp 65001
SET "RUNDIR=%~dp0"
SET "PATH=%windir%;%windir%\system32;%RUNDIR%.sys\php;"
ECHO.
ECHO Starting development php-server
ECHO For end process press "Ctrl+C"
ECHO.
START http://localhost:8888/
.sys\php\php.exe -S localhost:8888 -c "%RUNDIR%.sys\php\" -t "%RUNDIR%" .sys\router.php

ENDLOCAL

