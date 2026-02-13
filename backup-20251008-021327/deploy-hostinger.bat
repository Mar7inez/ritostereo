@echo off
echo 🚀 RITO STEREO - Deploy a Hostinger
echo =====================================

echo.
echo 📋 Preparando archivos para deploy...

REM Limpiar archivos innecesarios
echo 🧹 Limpiando archivos innecesarios...
if exist "storage\cache\*" del /q "storage\cache\*"
if exist "storage\logs\*" del /q "storage\logs\*"
if exist "temp_logo.png" del "temp_logo.png"

REM Optimizar para producción
echo ⚡ Optimizando para producción...
php optimize-for-production.php

REM Crear archivo .htaccess optimizado
echo 📝 Creando .htaccess optimizado...
copy ".htaccess" "public\.htaccess"

REM Copiar archivos de configuración
echo ⚙️ Configurando archivos de entorno...
copy "env.optimized" "public\.env"

REM Crear estructura de directorios en public
echo 📁 Creando estructura de directorios...
if not exist "public\storage" mkdir "public\storage"
if not exist "public\storage\cache" mkdir "public\storage\cache"
if not exist "public\storage\logs" mkdir "public\storage\logs"
if not exist "public\storage\database" mkdir "public\storage\database"

REM Copiar archivos necesarios a public
echo 📦 Copiando archivos necesarios...
xcopy "storage\*" "public\storage\" /E /I /Y
xcopy "app" "public\app\" /E /I /Y
xcopy "vendor" "public\vendor\" /E /I /Y
copy "composer.json" "public\"
copy "composer.lock" "public\"

REM Crear archivo de configuración de Hostinger
echo 🌐 Creando configuración de Hostinger...
echo # Configuración de Hostinger > "public\hostinger-config.txt"
echo APP_URL=https://olive-jellyfish-784892.hostingersite.com >> "public\hostinger-config.txt"
echo SMTP_HOST=mail.hostingersite.com >> "public\hostinger-config.txt"
echo SMTP_USER=noreply@olive-jellyfish-784892.hostingersite.com >> "public\hostinger-config.txt"

echo.
echo ✅ Deploy preparado exitosamente!
echo.
echo 📋 Instrucciones para Hostinger:
echo 1. Subir todo el contenido de la carpeta 'public' a tu dominio
echo 2. Configurar el .env con tus credenciales reales
echo 3. Verificar que los permisos de 'storage' sean 755
echo 4. Ejecutar 'php optimize-for-production.php' en el servidor
echo.
echo 🎉 ¡Listo para subir a Hostinger!
pause
