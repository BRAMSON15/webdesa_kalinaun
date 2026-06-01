$ErrorActionPreference = "Stop"
$viewsDir = "c:\backup\laragon\www\webdesa2\resources\views"
$cssFile = "c:\backup\laragon\www\webdesa2\public\css\views-custom.css"
$allCss = ""

$files = Get-ChildItem -Path $viewsDir -Recurse -Filter *.blade.php

foreach ($file in $files) {
    $content = Get-Content -Path $file.FullName -Raw
    
    # Regex to match <style> ... </style> tags (multiline)
    $regex = '(?is)<style>(.*?)</style>'
    
    $matches = [regex]::Matches($content, $regex)
    if ($matches.Count -gt 0) {
        Write-Host "Found style tags in $($file.FullName)"
        foreach ($match in $matches) {
            $allCss += "/* Extracted from $($file.Name) */`r`n"
            $allCss += $match.Groups[1].Value.Trim() + "`r`n`r`n"
        }
        
        # Replace the matched tags with empty string
        $newContent = $content -replace '(?is)<style>.*?</style>', ''
        
        Set-Content -Path $file.FullName -Value $newContent -NoNewline
    }
}

if ($allCss -ne "") {
    Set-Content -Path $cssFile -Value $allCss
    Write-Host "Extracted CSS written to $cssFile"
} else {
    Write-Host "No CSS found."
}
