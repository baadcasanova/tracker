<?php
require __DIR__ . '/../app/core/bootstrap.php';
Auth::logout();
redirect('/login.php');
