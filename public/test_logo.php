<?php
// Test logo path
$host = $_SERVER['HTTP_HOST'] ?? '';
$isProduction = strpos($host, 'railway.app') !== false || strpos($host, 'kesug.com') !== false || strpos($host, 'epizy.com') !== false;
$basePath = $isProduction ? '' : '/PHP-BCTH/public';

echo "<h2>Test Logo Path</h2>";
echo "<p>Host: " . htmlspecialchars($host) . "</p>";
echo "<p>Is Production: " . ($isProduction ? 'Yes' : 'No') . "</p>";
echo "<p>Base Path: " . htmlspecialchars($basePath) . "</p>";

// Test different paths
$paths = [
    $basePath . '/images/logoTVU.png',
    '/images/logoTVU.png',
    'images/logoTVU.png',
    '../images/logoTVU.png',
    './images/logoTVU.png',
];

echo "<h3>Testing different paths:</h3>";
foreach ($paths as $path) {
    echo "<div style='margin: 20px; padding: 10px; border: 1px solid #ccc;'>";
    echo "<p><strong>Path:</strong> " . htmlspecialchars($path) . "</p>";
    echo "<img src='" . htmlspecialchars($path) . "' alt='Logo TVU' style='max-width: 100px; max-height: 100px;'>";
    echo "</div>";
}

// Check if file exists on server
echo "<h3>File existence check:</h3>";
$serverPaths = [
    __DIR__ . '/images/logoTVU.png',
    __DIR__ . '/../public/images/logoTVU.png',
    $_SERVER['DOCUMENT_ROOT'] . '/images/logoTVU.png',
];

foreach ($serverPaths as $sp) {
    echo "<p>" . htmlspecialchars($sp) . " - " . (file_exists($sp) ? '<span style="color:green">EXISTS</span>' : '<span style="color:red">NOT FOUND</span>') . "</p>";
}

echo "<p>Document Root: " . htmlspecialchars($_SERVER['DOCUMENT_ROOT']) . "</p>";
echo "<p>Current Dir: " . htmlspecialchars(__DIR__) . "</p>";
?>
