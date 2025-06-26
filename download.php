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
$tables = ['users', 'bookings', 'menu'];

// File name
$filename = 'backup_all_tables_' . date('Y-m-d_H-i-s') . '.csv';

// Send headers for download
header('Content-Type: text/csv');
header("Content-Disposition: attachment; filename=\"$filename\"");

$output = fopen('php://output', 'w');

foreach ($tables as $table) {
    // Write table name as section title
    fputcsv($output, []); // empty row for spacing
    fputcsv($output, ["--- Table: $table ---"]);

    // Write column headers
    $colRes = $conn->query("SHOW COLUMNS FROM `$table`");
    $columns = [];
    while ($row = $colRes->fetch_assoc()) {
        $columns[] = $row['Field'];
    }
    fputcsv($output, $columns);

    // Write rows
    $dataRes = $conn->query("SELECT * FROM `$table`");
    while ($row = $dataRes->fetch_assoc()) {
        fputcsv($output, $row);
    }
}

fclose($output);
$conn->close();
exit;
