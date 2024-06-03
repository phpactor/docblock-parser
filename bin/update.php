<?php

use Symfony\Component\Filesystem\Filesystem;

require __DIR__ . '/../vendor/autoload.php';

$fs = new Filesystem();
$fs->remove('src');
$fs->remove('tests');
$fs->mirror('../phpactor/lib/DocblockParser', 'src');
$fs->mirror('src/Tests', 'tests');
