# RITO STEREO - Homenaje a Soda Stereo

Sitio web oficial de la banda tributo RITO STEREO.

🌐 **Sitio en vivo:** [https://peachpuff-butterfly-172564.hostingersite.com/](https://peachpuff-butterfly-172564.hostingersite.com/)

## 🚀 Instalación en Hostinger

### 1. Subir archivos
- Subir todo el contenido de esta carpeta al directorio `public_html` de tu hosting
- Asegúrate de que la estructura de carpetas se mantenga intacta

### 2. Configurar permisos
```bash
chmod 755 storage/
chmod 755 storage/data/
chmod 755 storage/logs/
chmod 644 storage/data/*.json
```

### 3. Configurar email
Editar el archivo `.env` y configurar:
- `MAIL_PASS`: Contraseña de aplicación de Gmail
- `APP_URL`: URL de tu sitio web

### 4. Verificar funcionamiento
- Visitar la URL de tu sitio
- Probar el formulario de contacto
- Verificar que las imágenes se cargan correctamente

## 📁 Estructura del proyecto

```
rito-stereo-hostinger-clean/
├── app/                    # Código de la aplicación
│   ├── views/             # Vistas PHP
│   ├── bootstrap.php      # Inicialización
│   ├── helpers.php        # Funciones auxiliares
│   ├── Security.php       # Seguridad y validación
│   └── Mailer.php         # Envío de emails
├── public/                # Archivos públicos
│   ├── assets/           # CSS, JS, imágenes
│   ├── index.php         # Página principal
│   └── contact-working.php # Formulario de contacto
├── storage/              # Datos y logs
│   ├── data/            # Archivos JSON de datos
│   └── logs/            # Logs de la aplicación
├── vendor/              # Dependencias de Composer
├── .env                 # Configuración
├── .htaccess           # Configuración de Apache
└── composer.json       # Dependencias
```

## ⚙️ Configuración

### Variables de entorno (.env)
```env
APP_NAME=RITO_STEREO
APP_URL=https://tu-dominio.com
APP_ENV=production
APP_DEBUG=false

# Email (Gmail SMTP)
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USER=ritostereo@gmail.com
MAIL_PASS=tu_app_password_gmail
MAIL_FROM=ritostereo@gmail.com
MAIL_FROM_NAME=RITO STEREO
MAIL_TO=ritostereo@gmail.com
```

## 🎵 Funcionalidades

- **Shows**: Lista de conciertos con fechas y entradas
- **Música**: Enlaces a plataformas de streaming
- **Galería**: Fotos de la banda
- **Biografía**: Información sobre la banda
- **Contacto**: Formulario con captcha matemático

## 🔧 Mantenimiento

### Actualizar shows
Editar `storage/data/shows.json`:
```json
{
  "shows": [
    {
      "id": "show_id",
      "fecha": "2024-12-15",
      "lugar": "Teatro",
      "ciudad": "Ciudad",
      "hora": "20:00",
      "precio": "$25.000",
      "entradas": "https://ticketek.com",
      "descripcion": "Descripción del show"
    }
  ]
}
```

### Actualizar imágenes de tickets
Editar `storage/data/tickets.json`:
```json
{
  "tickets": [
    {
      "id": "show_id",
      "imagen": "nombre_imagen.jpg"
    }
  ]
}
```

## 📧 Soporte

Para soporte técnico, contactar a: ritostereo@gmail.com
