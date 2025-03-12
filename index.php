<?php
// Project name: Xampp server index page
// File name: index.php
// File location: "/xampp/htdocs/xampp/"

// Check if xampp/index.php exists
$xamppIndexPath = __DIR__ . '/../index.php';
$templatePath = __DIR__ . '/templates/index.php';

if (!file_exists($xamppIndexPath)) {
    if (file_exists($templatePath) && copy($templatePath, $xamppIndexPath)) {
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/");
        exit;
    } else {
        exit("Failed to create XAMPP index.php. Please check file permissions or template existence.");
    }
}

// Load HTML header component
include __DIR__ . '/html/header.html';

// Load dashboard HTML layout
echo file_get_contents(__DIR__ . '/html/dashboard.html');

// PHP Logic: Scan and dynamically populate projects
$rootDir = __DIR__ . '/../';

// Helper functions
function isGitRepo($dir) {
    return is_dir($dir . '/.git');
}

function hasIndexFile($dir) {
    return file_exists($dir . '/index.php') || file_exists($dir . '/index.html');
}

function getProjectInfo($dir) {
    $jsonFile = $dir . '/project.json';
    if (file_exists($jsonFile)) {
        $projectInfo = json_decode(file_get_contents($jsonFile), true);
        return (json_last_error() === JSON_ERROR_NONE) ? $projectInfo : null;
    }
    return null;
}

// Start dynamic output for projects
echo "<div class='container'>";
echo "<div class='row'>";

$subDirs = array_filter(glob($rootDir . '/*'), 'is_dir');

foreach ($subDirs as $subDir) {
    $folderName = basename($subDir);
    $isGitRepo = isGitRepo($subDir) ? 'Yes' : 'No';
    $hasIndex = hasIndexFile($subDir) ? 'Yes' : 'No';

    $projectInfo = getProjectInfo($subDir);
    $projectName = $projectInfo['name'] ?? $folderName;
    $projectDescription = $projectInfo['description'] ?? 'No description available';

    $link = file_exists($subDir . '/index.php') ? "$folderName/index.php" : "$folderName/index.html";

    echo "
        <div class='col-md-4 mb-4'>
            <div class='card'>
                <div class='card-body'>
                    <h5 class='card-title'>{$projectName}</h5>
                    <p class='card-text'>{$projectDescription}</p>
                    <p class='card-text'><strong>Git Repo:</strong> {$isGitRepo}</p>
                    <p class='card-text'><strong>Index File:</strong> {$hasIndex}</p>
                    <a href='/{$link}' class='btn btn-primary'>Go to Project</a>
                </div>
            </div>
        </div>
    ";
}

echo "</div>";
echo "</div>";

// Load HTML footer component
include __DIR__ . '/html/footer.html';
