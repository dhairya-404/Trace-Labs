<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'Sign In — TraceLab') ?></title>
    
    <!-- Favicon & Brand Marks (Data URI Instant Tab Render + SVG + PNG + ICO) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64' fill='none'%3E%3Crect width='64' height='64' rx='14' fill='%23070c18'/%3E%3Ccircle cx='32' cy='32' r='22' stroke='%23334155' stroke-width='2' stroke-dasharray='8 6'/%3E%3Cpath d='M 32 16 A 16 16 0 1 1 16 32' stroke='%2338bdf8' stroke-width='4' stroke-linecap='round'/%3E%3Cpath d='M 22 32 A 10 10 0 0 1 32 22' stroke='%2300f0ff' stroke-width='3' stroke-linecap='round'/%3E%3Ccircle cx='32' cy='32' r='5' fill='%2338bdf8'/%3E%3Ccircle cx='32' cy='32' r='2.5' fill='%23ffffff'/%3E%3Cline x1='32' y1='32' x2='48' y2='16' stroke='%2338bdf8' stroke-width='3' stroke-linecap='round'/%3E%3C/svg%3E">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- TraceLab Core Design System -->
    <link rel="stylesheet" href="/assets/css/style.css?v=<?= time() ?>">
    
    <style>
        body {
            background-color: #030712;
            background-image: 
                radial-gradient(circle at 50% 10%, rgba(56, 189, 248, 0.12) 0%, transparent 50%),
                radial-gradient(rgba(56, 189, 248, 0.08) 1px, transparent 1px);
            background-size: 100% 100%, 28px 28px;
            font-family: var(--font-sans);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 24px;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
        }

        .auth-card {
            background: linear-gradient(180deg, #0d1527 0%, #070b16 100%);
            border: 1px solid rgba(56, 189, 248, 0.22);
            border-radius: 16px;
            padding: 36px 32px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.95), 0 0 35px rgba(56, 189, 248, 0.08), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            position: relative;
        }

        .brand-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.5) 0%, rgba(2, 132, 199, 0.2) 50%, transparent 75%);
            filter: blur(14px);
            z-index: 0;
            pointer-events: none;
        }

        .form-control-cyber {
            background-color: #060a14 !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #f8fafc !important;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.5);
            transition: all 0.15s ease;
        }

        .form-control-cyber:focus {
            background-color: #0a1122 !important;
            border-color: #38bdf8 !important;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.25), inset 0 2px 4px rgba(0, 0, 0, 0.5) !important;
            outline: none;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <?= $content ?>
    </div>
</body>
</html>
