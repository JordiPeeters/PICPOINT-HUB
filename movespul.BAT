@echo off
:loop
xcopy /y /f /d "Z:\*.*" "C:\xampp\htdocs\picpoint\copyhere\"
xcopy /y /f /d "X:\*.*" "C:\xampp\htdocs\picpoint\copyhere\"


timeout /t 60
goto loop
