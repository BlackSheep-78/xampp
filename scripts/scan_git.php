<?php
/*
    Project name: Xampp server dashboard
    File name: "/scripts/scan_git.php"
*/

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Path to the Bash script
$bashScript = __DIR__ . '/scan_git.sh';

// Root directory of XAMPP projects
$rootDir = realpath(__DIR__ . '/../../') . '/';

// Ensure the script file exists
if (!file_exists($bashScript)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Git scan script not found!'
    ]);
    exit;
}

// Windows Git Bash path
$gitBashPath = '"C:\Program Files\Git\bin\bash.exe"';
$command = $gitBashPath . " " . escapeshellarg($bashScript) . " " . escapeshellarg($rootDir);

// Log command for debugging
file_put_contents(__DIR__ . '/debug_log.txt', "Command: " . $command . PHP_EOL, FILE_APPEND);

// Execute the Bash script
exec($command, $output, $returnCode);

// Log the output for debugging
file_put_contents(__DIR__ . '/debug_log.txt', "Output: " . print_r($output, true) . PHP_EOL, FILE_APPEND);
file_put_contents(__DIR__ . '/debug_log.txt', "Return Code: " . $returnCode . PHP_EOL, FILE_APPEND);

// If execution failed, return error
if ($returnCode !== 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to execute Git scan script.'
    ]);
    exit;
}

// Process output into structured JSON
$gitStatuses = [];
foreach ($output as $line) {
    $parts = explode('|', $line);
    if (count($parts) >= 2) {
        $folderName = trim($parts[0]);
        $repoStatus = trim($parts[1]);
        $gitActions = count($parts) == 3 ? explode(',', trim($parts[2])) : [];

        $gitStatuses[$folderName] = [
            'isRepo' => ($repoStatus === 'GIT_REPO'),
            'status' => $repoStatus,
            'actions' => $gitActions
        ];
    }
}

// Return JSON response
echo json_encode([
    'status' => 'success',
    'gitRepos' => $gitStatuses
]);
?>
