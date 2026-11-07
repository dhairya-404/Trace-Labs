<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'Sign In — TraceLab') ?></title>
    
    <!-- Favicon & Brand Marks -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">
    
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
            background-image: 
                radial-gradient(circle at 50% 15%, rgba(14, 165, 233, 0.08) 0%, transparent 60%),
                radial-gradient(circle at 80% 80%, rgba(37, 99, 235, 0.05) 0%, transparent 50%);
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
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 14px;
            padding: 32px;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.8), 0 0 0 1px rgba(255, 255, 255, 0.04);
            position: relative;
        }

        .brand-glow {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 70px;
            height: 70px;
            background: radial-gradient(circle, rgba(56, 189, 248, 0.45) 0%, rgba(2, 132, 199, 0.15) 55%, transparent 75%);
            filter: blur(12px);
            z-index: 0;
            pointer-events: none;
        }

        .font-mono {
            font-family: var(--font-mono) !important;
        }

        .form-control-cyber {
            background-color: #080d1a !important;
            border: 1px solid #1e293b !important;
            color: #f8fafc !important;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.15s ease;
        }

        .form-control-cyber:focus {
            background-color: #0c1424 !important;
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
            outline: none;
        }

        .btn-cyber-primary {
            background: #2563eb;
            border: 1px solid #2563eb;
            color: #ffffff;
            font-weight: 500;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: background-color 0.15s ease;
        }

        .btn-cyber-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            color: #ffffff;
        }

        .user-pill {
            background: #080d1a;
            border: 1px solid #1e293b;
            border-radius: 10px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 9999px;
            font-size: 0.72rem;
            font-family: var(--font-mono);
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.25);
            color: #4ade80;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .demo-key-card {
            background: #080d1a;
            border: 1px dashed #334155;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .demo-key-card:hover {
            background: #0f172a;
            border-color: #38bdf8;
        }

        .btn-xs-fill {
            font-size: 0.72rem;
            font-family: var(--font-mono);
            color: #38bdf8;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.2);
            padding: 3px 8px;
            border-radius: 6px;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <?= $content ?>
    </div>
</body>
</html>
