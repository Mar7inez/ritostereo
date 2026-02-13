@echo off
echo ========================================
echo CONFIGURANDO ENTORNO LOCAL
echo ========================================
echo.

echo 1. Copiando archivo .env para local...
copy "env-local" ".env" >nul

echo 2. Instalando dependencias de Composer...
composer install

echo 3. Iniciando servidor local...
echo.
echo El servidor se iniciará en: http://localhost:8000
echo.
echo Presiona Ctrl+C para detener el servidor
echo.
php -S localhost:8000 -t public
