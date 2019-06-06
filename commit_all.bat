@echo off

::ask for the commit name 
set /p commitmsg="Commit message :"

::stash everything (including deleted files)
git add -A
git commit -m "%commitmsg%"
::echo cmsg: %commitmsg%

pause