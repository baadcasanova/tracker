<?php
session_start();

$config = require __DIR__ . '/../../config/config.php';
date_default_timezone_set($config['timezone']);

require __DIR__ . '/helpers.php';
require __DIR__ . '/Database.php';
require __DIR__ . '/Auth.php';
require __DIR__ . '/Csrf.php';
require __DIR__ . '/Crypto.php';

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = in_array($_GET['lang'], ['en', 'ar'], true) ? $_GET['lang'] : $config['default_lang'];
}

if (isset($_GET['theme'])) {
    $_SESSION['theme'] = in_array($_GET['theme'], ['light', 'dark'], true) ? $_GET['theme'] : 'light';
}
