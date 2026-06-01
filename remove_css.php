<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/\.blade\.php$/', RegexIterator::MATCH);

foreach ($files as $file) {
    $content = file_get_contents($file->getPathname());
    $newContent = preg_replace('/<style>.*?<\/style>\s*/s', '', $content);
    if ($newContent !== $content) {
        file_put_contents($file->getPathname(), $newContent);
        echo "Removed <style> from: " . $file->getFilename() . "\n";
    }
}
echo "Done.\n";
