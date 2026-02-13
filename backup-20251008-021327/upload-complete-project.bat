@echo off
echo ========================================
echo SUBIENDO PROYECTO COMPLETO A HOSTINGER
echo ========================================
echo.

echo 1. Creando archivo .env correcto...
copy "rito-stereo-hostinger-clean\env-correct" "rito-stereo-hostinger-clean\.env" >nul

echo 2. Creando ZIP del proyecto completo...
powershell -command "Compress-Archive -Path 'rito-stereo-hostinger-clean\*' -DestinationPath 'rito-stereo-hostinger-complete.zip' -Force"

echo 3. Subiendo proyecto completo al servidor...
echo.
echo COMANDOS PARA EJECUTAR EN SSH:
echo.
echo 1. Conectar por SSH:
echo    ssh -p 65002 u818340067@82.112.247.242
echo.
echo 2. Una vez conectado, ejecutar:
echo    rm -rf *
echo    exit
echo.
echo 3. Subir el ZIP:
echo    scp -P 65002 rito-stereo-hostinger-complete.zip u818340067@82.112.247.242:~/
echo.
echo 4. Conectar de nuevo por SSH y extraer:
echo    ssh -p 65002 u818340067@82.112.247.242
echo    unzip rito-stereo-hostinger-complete.zip
echo    rm rito-stereo-hostinger-complete.zip
echo    ls -la
echo.
echo 5. Probar la página:
echo    https://olive-jellyfish-784892.hostingersite.com/
echo.
echo ========================================
echo PROYECTO LISTO PARA SUBIR
echo ========================================
pause
