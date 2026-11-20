<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Siapkan direktori writable di /tmp karena filesystem utama Vercel bersifat read-only.
$tmpStorageDirs = [
    '/tmp/storage/app/private/livewire-tmp',
    '/tmp/storage/app/private/institution/logos',
    '/tmp/storage/app/private/institution/signatures',
    '/tmp/storage/app/public',
    '/tmp/storage/app/livewire-tmp',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/testing',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($tmpStorageDirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Salin database demo SQLite ke /tmp saat cold start dan pastikan izinnya writable (0666).
$sourceDb = __DIR__.'/../database/demo.sqlite';
$runtimeDb = '/tmp/database.sqlite';

if (file_exists($sourceDb) && ! file_exists($runtimeDb)) {
    copy($sourceDb, $runtimeDb);
    chmod($runtimeDb, 0666);
} elseif (file_exists($runtimeDb) && ! is_writable($runtimeDb)) {
    chmod($runtimeDb, 0666);
}

require __DIR__.'/../vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';
$app->useStoragePath('/tmp/storage');

$app->handleRequest(Request::capture());
