<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'RITO STEREO - Homenaje a Soda Stereo' ?></title>
    <meta name="description" content="<?= $description ?? 'RITO STEREO es un Homenaje no oficial que honra la obra de Soda Stereo y Gustavo Cerati con fidelidad sonora y puesta visual contemporánea.' ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= $title ?? 'RITO STEREO - Homenaje a Soda Stereo' ?>">
    <meta property="og:description" content="<?= $description ?? 'Homenaje respetuoso y potente a Soda Stereo & Gustavo Cerati.' ?>">
    <meta property="og:image" content="<?= url('assets/img/og-image.jpg') ?>">
    <meta property="og:url" content="<?= url() ?>">
    <meta property="og:type" content="website">
    
    <!-- Twitter Cards -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $title ?? 'RITO STEREO - Homenaje a Soda Stereo' ?>">
    <meta name="twitter:description" content="<?= $description ?? 'Homenaje respetuoso y potente a Soda Stereo & Gustavo Cerati.' ?>">
    <meta name="twitter:image" content="<?= url('assets/img/og-image.jpg') ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="<?= asset('assets/img/favicon.svg') ?>">
    <link rel="icon" type="image/png" href="<?= asset('assets/img/favicon.svg') ?>">
    <link rel="apple-touch-icon" href="<?= asset('assets/img/favicon.svg') ?>">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'rito-black': '#0B0B0B',
                        'rito-red': '#D72638',
                        'rito-red-dark': '#BF213E',
                    },
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Custom CSS -->
    <style>
        html { scroll-behavior: smooth; }
        .hero-bg { 
            background: linear-gradient(135deg, #0B0B0B 0%, #1a1a1a 100%);
        }
        .neon-glow {
            box-shadow: 0 0 20px rgba(215, 38, 56, 0.3);
        }
    </style>
</head>
<body class="bg-rito-black text-white font-sans">
    <?= $content ?? '' ?>
    
    <!-- Alpine.js ya está cargado arriba -->
    
    <!-- Schema.org JSON-LD -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MusicGroup",
        "name": "RITO STEREO",
        "description": "Homenaje no oficial a Soda Stereo y Gustavo Cerati",
        "url": "<?= url() ?>",
        "sameAs": [
            "<?= $presskit['social']['instagram'] ?? '' ?>",
            "<?= $presskit['social']['youtube'] ?? '' ?>",
            "<?= $presskit['social']['spotify'] ?? '' ?>"
        ]
    }
    </script>
</body>
</html>
