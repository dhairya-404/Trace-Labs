<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'Official Investigation Report — TraceLab') ?></title>
    
    <!-- Favicon & Brand Marks (Data URI Instant Tab Render + SVG + PNG + ICO) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64' fill='none'%3E%3Crect width='64' height='64' rx='14' fill='%23070c18'/%3E%3Ccircle cx='32' cy='32' r='22' stroke='%23334155' stroke-width='2' stroke-dasharray='8 6'/%3E%3Cpath d='M 32 16 A 16 16 0 1 1 16 32' stroke='%2338bdf8' stroke-width='4' stroke-linecap='round'/%3E%3Cpath d='M 22 32 A 10 10 0 0 1 32 22' stroke='%2300f0ff' stroke-width='3' stroke-linecap='round'/%3E%3Ccircle cx='32' cy='32' r='5' fill='%2338bdf8'/%3E%3Ccircle cx='32' cy='32' r='2.5' fill='%23ffffff'/%3E%3Cline x1='32' y1='32' x2='48' y2='16' stroke='%2338bdf8' stroke-width='3' stroke-linecap='round'/%3E%3C/svg%3E">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f8fafc;
            color: #0f172a;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        .report-page {
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            border-radius: 8px;
            padding: 48px;
            margin-top: 24px;
            margin-bottom: 48px;
        }
        @media print {
            body { background: #ffffff !important; }
            .no-print { display: none !important; }
            .report-page { box-shadow: none !important; padding: 0 !important; margin: 0 !important; }
        }
        .hash-code {
            font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-size: 0.85rem;
            word-break: break-all;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3 no-print">
            <a href="/investigations/<?= $investigation['id'] ?? '' ?>" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Workspace
            </a>
            <div class="d-flex gap-2">
                <a href="/investigations/<?= $investigation['id'] ?? '' ?>/report/json" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-filetype-json"></i> Export JSON
                </a>
                <button onclick="window.print()" class="btn btn-primary btn-sm">
                    <i class="bi bi-printer"></i> Print / Save as PDF
                </button>
            </div>
        </div>

        <div class="report-page">
            <?= $content ?>
        </div>
    </div>
</body>
</html>
