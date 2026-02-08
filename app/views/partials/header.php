<?php
$theme = $_SESSION['theme'] ?? 'light';
$dir = ($_SESSION['lang'] ?? config('default_lang')) === 'ar' ? 'rtl' : 'ltr';
?>
<!DOCTYPE html>
<html lang="<?= e($_SESSION['lang'] ?? config('default_lang')) ?>" dir="<?= e($dir) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e(config('app_name')) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
<body class="<?= $theme === 'dark' ? 'theme-dark' : 'theme-light' ?>">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Tracker SaaS</a>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-light btn-sm" href="?lang=en">EN</a>
            <a class="btn btn-outline-light btn-sm" href="?lang=ar">AR</a>
            <a class="btn btn-outline-light btn-sm" href="?theme=light">☀️</a>
            <a class="btn btn-outline-light btn-sm" href="?theme=dark">🌙</a>
            <?php if (Auth::check()) : ?>
                <a class="btn btn-outline-light btn-sm" href="/logout.php"><?= e(lang('logout')) ?></a>
            <?php endif; ?>
        </div>
    </div>
</nav>
<main class="container py-4">
