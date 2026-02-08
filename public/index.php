<?php
require __DIR__ . '/../app/core/bootstrap.php';

if (!Auth::check()) {
    redirect('/login.php');
}

$user = Auth::user();
if ($user['role'] === 'admin') {
    redirect('/admin.php');
}

redirect('/dashboard.php');
