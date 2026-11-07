<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= \Tracelabs\Core\View::escape($pageTitle ?? 'Official Investigation Report — TraceLab') ?></title>
    
    <!-- Favicon & Brand Marks -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" href="/favicon.svg">
    <link rel="apple-touch-icon" href="/favicon.svg">

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
