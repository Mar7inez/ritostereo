@echo off
echo Arreglando archivo .env en el servidor...

echo Creando archivo .env corregido...
echo APP_NAME=RITO_STEREO > env-fixed
echo APP_URL=https://olive-jellyfish-784892.hostingersite.com >> env-fixed
echo APP_ENV=production >> env-fixed
echo APP_DEBUG=false >> env-fixed
echo. >> env-fixed
echo # Database >> env-fixed
echo DB_CONNECTION=sqlite >> env-fixed
echo DB_DATABASE=storage/database/database.sqlite >> env-fixed
echo. >> env-fixed
echo # Mail >> env-fixed
echo MAIL_MAILER=smtp >> env-fixed
echo MAIL_HOST=smtp.gmail.com >> env-fixed
echo MAIL_PORT=587 >> env-fixed
echo MAIL_USERNAME=ritostereo@gmail.com >> env-fixed
echo MAIL_PASSWORD=your_app_password >> env-fixed
echo MAIL_ENCRYPTION=tls >> env-fixed
echo MAIL_FROM_ADDRESS=ritostereo@gmail.com >> env-fixed
echo MAIL_FROM_NAME="RITO STEREO" >> env-fixed
echo MAIL_TO=ritostereo@gmail.com >> env-fixed
echo. >> env-fixed
echo # Security >> env-fixed
echo CSRF_TOKEN_LIFETIME=3600 >> env-fixed
echo RATE_LIMIT_MAX_ATTEMPTS=5 >> env-fixed
echo RATE_LIMIT_TIME_WINDOW=300 >> env-fixed
echo. >> env-fixed
echo # Cache >> env-fixed
echo CACHE_DRIVER=file >> env-fixed
echo CACHE_LIFETIME=3600 >> env-fixed
echo. >> env-fixed
echo # Logs >> env-fixed
echo LOG_LEVEL=error >> env-fixed
echo LOG_FILE=storage/logs/app.log >> env-fixed

echo Archivo .env corregido creado como env-fixed
echo.
echo Ahora necesitas:
echo 1. Subir env-fixed al servidor
echo 2. Renombrarlo a .env en el servidor
echo 3. Eliminar archivos de test
echo.
echo Comandos para SSH:
echo scp -P 65002 env-fixed u818340067@82.112.247.242:~/env-fixed
echo.
echo Luego en SSH:
echo mv env-fixed .env
echo find . -name "*test*" -type f -delete
echo rm -f test-*.php
echo.
pause
