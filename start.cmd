@ECHO OFF
ECHO.

IF "%PHPEXE%"=="" GOTO _ERR_PHP
IF "%1" == "" GOTO _ERR_CALL
IF NOT EXIST "%1" GOTO _ERR_PATH

SETLOCAL
chcp 65001
SET "RUNDIR=%~dp0"

:: For PHP process variables: WMDB, GIT
SET "WMDB=%1"
FOR /F "tokens=* USEBACKQ" %%F IN (`where git`) DO (SET GIT=%%F)

git pull
SET "G=git -C %1"
%G% pull

ECHO.
ECHO Starting development php-server
ECHO For end process press "Ctrl+C"
ECHO.
START http://localhost:8888/
%PHPEXE% -S localhost:8888 -c %RUNDIR%sys\php.ini -d include_path=%RUNDIR% -t "%1" sys\router.php

%G% add .
%G% commit -am "modify"
%G% push
ENDLOCAL
GOTO _EXIT

:_ERR_PATH
echo Not exist path: %1
GOTO _EXIT

:_ERR_CALL
echo ERROR: data folder path not specified. Call format:
echo.
echo %0 X:\path_for\_MD_Wiki_data_folder
GOTO _EXIT

:_ERR_PHP
echo ERROR: not found environment variable PHPEXE.

:_EXIT
ECHO.
pause
ECHO.
