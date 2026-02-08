<?php
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function config(string $key, $default = null)
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../../config/config.php';
    }

    return $config[$key] ?? $default;
}

function lang(string $key): string
{
    static $translations = null;
    if ($translations === null) {
        $locale = $_SESSION['lang'] ?? config('default_lang');
        $file = __DIR__ . '/../lang/' . $locale . '.php';
        $translations = file_exists($file) ? require $file : [];
    }

    return $translations[$key] ?? $key;
}

function redirect(string $path): void
{
    header('Location: ' . $path);
    exit;
}
