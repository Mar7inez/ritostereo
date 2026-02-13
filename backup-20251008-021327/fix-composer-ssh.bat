@echo off
echo ========================================
echo ARREGLANDO COMPOSER EN EL SERVIDOR
echo ========================================
echo.

echo Ejecutando comandos en el servidor...
echo.

echo 1. Verificando estructura actual...
ssh -p 65002 u818340067@82.112.247.242 "cd /home/u818340067/domains/olive-jellyfish-784892.hostingersite.com/public_html && ls -la"

echo.
echo 2. Verificando si existe composer.json...
ssh -p 65002 u818340067@82.112.247.242 "cd /home/u818340067/domains/olive-jellyfish-784892.hostingersite.com/public_html && ls -la composer.json"

echo.
echo 3. Instalando dependencias de Composer...
ssh -p 65002 u818340067@82.112.247.242 "cd /home/u818340067/domains/olive-jellyfish-784892.hostingersite.com/public_html && composer install --no-dev --optimize-autoloader"

echo.
echo 4. Verificando que las dependencias estén instaladas...
ssh -p 65002 u818340067@82.112.247.242 "cd /home/u818340067/domains/olive-jellyfish-784892.hostingersite.com/public_html && ls -la vendor/vlucas/phpdotenv/"

echo.
echo 5. Probando la página...
echo https://olive-jellyfish-784892.hostingersite.com/
echo.
echo ========================================
echo COMANDOS EJECUTADOS
echo ========================================
pause
