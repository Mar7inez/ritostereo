# Checklist de Deploy para Hosting

## ✅ Archivos que VAN al hosting
```
public_html/ (o carpeta raíz del hosting)
├── index.php
├── shows.php
├── music.php
├── contact.php
├── 404.php
├── .htaccess
├── robots.txt
├── sitemap.xml
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
│       ├── favicon.svg
│       ├── logo-main.svg
│       └── shows/
└── app/ (carpeta completa)
    ├── bootstrap.php
    ├── helpers.php
    ├── Security.php
    ├── Mailer.php
    ├── View.php
    └── views/
```

## ❌ Archivos que NO van al hosting
- .env (crear uno nuevo en el servidor)
- storage/logs/ (se crea automáticamente)
- storage/data/ (se crea automáticamente)
- node_modules/
- .git/
- README.md
- install.php
- test-sheets.php
- run-clean.bat

## 🔧 Configuración del servidor
1. PHP 7.4+ (recomendado 8.1+)
2. Extensiones: curl, json, mbstring
3. Mod_rewrite habilitado
4. Permisos de escritura en storage/
