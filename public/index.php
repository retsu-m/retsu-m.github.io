<?php

// Define the project root directory
define('ROOT_PATH', dirname(__DIR__));

// Get the requested URI
$requestUri = $_SERVER['REQUEST_URI'];

// Remove query string from URI
$requestPath = strtok($requestUri, '?');

// Default route for the root
if ($requestPath === '/') {
    $templatePath = ROOT_PATH . '/templates/index.html';
} else {
    // Construct the path to the template file
    // e.g., /admin/login -> /path/to/project/templates/admin/login
    $templatePath = ROOT_PATH . '/templates' . $requestPath;
}

// If the constructed path is a directory, assume we want the index.html inside it.
// e.g., /admin/ -> /path/to/project/templates/admin/index.html
if (is_dir($templatePath)) {
    $templatePath = rtrim($templatePath, '/') . '/index.html';
}

// Allow accessing pages without the extension. Prefer .php over .html.
$phpPath = $templatePath . '.php';
$htmlPath = $templatePath . '.html';

if (file_exists($phpPath)) {
    $templatePath = $phpPath;
} elseif (file_exists($htmlPath)) {
    $templatePath = $htmlPath;
}

// Check if the template file exists and serve it
if (file_exists($templatePath)) {
    // For now, we directly include the HTML/PHP file.
    // This will allow us to add PHP logic to these files later.
    require $templatePath;
} else {
    // If the file doesn't exist, send a 404 response
    http_response_code(404);
    // A simple 404 page
    $errorTemplate = ROOT_PATH . '/templates/404.html';
    if (file_exists($errorTemplate)) {
        require $errorTemplate;
    } else {
        echo "<h1>404 Not Found</h1>";
        echo "<p>The page you requested at '{$requestPath}' could not be found.</p>";
    }
}
