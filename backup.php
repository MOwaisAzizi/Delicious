<?php
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = '';

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tables to back up
$tables = ['bookings', 'menu', 'users'];

// Backup folder
$backupDir = __DIR__ . '/assets/backup';

// Create folder if it doesn't exist
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0755, true);
}

foreach ($tables as $tableName) {
    $filename = 'backup_' . $tableName . '_' . date('Y-m-d_H-i-s') . '.csv';
    $filepath = $backupDir . '/' . $filename;

    $output = fopen($filepath, 'w');
    if (!$output) {
        echo "❌ Failed to write to $filepath\n";
        continue;
    }

    // Get columns
    $colResult = $conn->query("SHOW COLUMNS FROM `$tableName`");
    if (!$colResult) {
        echo "❌ Failed to get columns from $tableName\n";
        fclose($output);
        continue;
    }

    $columns = [];
    while ($row = $colResult->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
    fputcsv($output, $columns);

    // Get rows
    $dataResult = $conn->query("SELECT * FROM `$tableName`");
    if ($dataResult) {
        while ($row = $dataResult->fetch_assoc()) {
            fputcsv($output, $row);
        }
    } else {
        echo "❌ Failed to get data from $tableName\n";
    }

    fclose($output);
    echo "✅ Backup saved: assets/backup/$filename\n";
}

$conn->close();
?>
