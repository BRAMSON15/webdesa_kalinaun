<?php

$dirs = [__DIR__ . '/resources/views/admin', __DIR__ . '/resources/views/Kades'];

foreach ($dirs as $d) {
    $dir = new RecursiveDirectoryIterator($d);
    $ite = new RecursiveIteratorIterator($dir);
    $files = new RegexIterator($ite, '/\.blade\.php$/', RegexIterator::MATCH);

    foreach ($files as $file) {
        $content = file_get_contents($file->getPathname());
        $original = $content;

        // 1. Remove manual Bootstrap scripts
        $content = str_replace('<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>', '', $content);
        $content = str_replace('<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">', '', $content);
        
        // Remove empty lines left behind by the removal
        $content = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $content);

        // 2. Fix structure
        $badStructure = '<div class="wrapper">' . "\n" . '    <aside class="dashboard-sidebar">' . "\n" . '        @include(\'admin.partials.sidebar\')' . "\n" . '    </aside>' . "\n\n" . '    <div class="dashboard-main">' . "\n" . '        @include(\'admin.partials.header\')';
        
        $goodStructure = '<div class="wrapper" style="height: auto; min-height: 100%;">' . "\n" . '    @include(\'admin.partials.header\')' . "\n\n" . '    <aside class="dashboard-sidebar">' . "\n" . '        @include(\'admin.partials.sidebar\')' . "\n" . '    </aside>' . "\n\n" . '    <div class="dashboard-main">';
        
        // For windows line endings
        $badStructureWin = "<div class=\"wrapper\">\r\n    <aside class=\"dashboard-sidebar\">\r\n        @include('admin.partials.sidebar')\r\n    </aside>\r\n\r\n    <div class=\"dashboard-main\">\r\n        @include('admin.partials.header')";
        $goodStructureWin = "<div class=\"wrapper\" style=\"height: auto; min-height: 100%;\">\r\n    @include('admin.partials.header')\r\n\r\n    <aside class=\"dashboard-sidebar\">\r\n        @include('admin.partials.sidebar')\r\n    </aside>\r\n\r\n    <div class=\"dashboard-main\">";
        
        $content = str_replace($badStructure, $goodStructure, $content);
        $content = str_replace($badStructureWin, $goodStructureWin, $content);

        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            echo "Fixed: " . $file->getFilename() . "\n";
        }
    }
}
echo "Done.\n";
