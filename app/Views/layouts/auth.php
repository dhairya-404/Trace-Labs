<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'Sign In // TraceLab') ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --bg-midnight: #080d1a;
            --surface-glass: rgba(15, 23, 42, 0.85);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --accent-cyan: #38bdf8;
            --font-sans: 'IBM Plex Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        body {
            background-color: var(--bg-midnight);
            font-family: var(--font-sans);
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            margin: 0;
            padding: 24px;
        }

        /* Subtle ambient glow & grid backdrop */
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(circle at 50% 15%, rgba(56, 189, 248, 0.09) 0%, transparent 45%),
                radial-gradient(circle at 85% 80%, rgba(99, 102, 241, 0.07) 0%, transparent 40%),
                radial-gradient(circle at 15% 85%, rgba(14, 165, 233, 0.05) 0%, transparent 35%);
            pointer-events: none;
            z-index: 0;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 1;
        }

        .auth-card {
            background: var(--surface-glass);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid var(--border-subtle);
            border-radius: 18px;
            padding: 40px;
            box-shadow: 
                0 0 0 1px rgba(255, 255, 255, 0.04),
                0 25px 60px -15px rgba(0, 0, 0, 0.7);
            position: relative;
            overflow: hidden;
        }

        /* Top accent hairline */
        .auth-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 20%;
            right: 20%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(56, 189, 248, 0.6), transparent);
        }

        .font-mono {
            font-family: var(--font-mono) !important;
        }

        .form-control-cyber {
            background-color: rgba(2, 6, 23, 0.65) !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #f8fafc !important;
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .form-control-cyber:focus {
            background-color: rgba(2, 6, 23, 0.9) !important;
            border-color: var(--accent-cyan) !important;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.15) !important;
            outline: none;
        }

        .btn-cyber-primary {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border: 1px solid rgba(56, 189, 248, 0.4);
            color: #ffffff;
            font-weight: 600;
            border-radius: 10px;
            padding: 12px;
            font-size: 0.95rem;
            letter-spacing: 0.02em;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.25);
        }

        .btn-cyber-primary:hover {
            background: linear-gradient(135deg, #0369a1 0%, #075985 100%);
            border-color: var(--accent-cyan);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(56, 189, 248, 0.35);
        }

        .btn-cyber-primary:active {
            transform: translateY(0);
        }

        .user-pill {
            background: rgba(2, 6, 23, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <?= $content ?>
    </div>
</body>
</html>
