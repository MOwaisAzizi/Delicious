<?php
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = '';

$error = '';
$success = '';
// Connect to MySQL (without selecting DB to create DB first)
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create DB if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $db");

// Select DB
$conn->select_db($db);
// $conn->query("DROP TABLE IF EXISTS bookings");
echo 'drop';

// Create table if not exists
$conn->query("
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    members INT NOT NULL DEFAULT 1,
    table_number INT NOT NULL,
    message VARCHAR(1000),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
if (isset($_POST['btn-register'])) {
    $name = trim($_POST["name"]);
    $phone = $_POST["phone"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $table = $_POST["table_number"];
    echo $table;
    $people = $_POST["people"];
    $message = $_POST["message"];
    $now = date('Y-m-d');
      
      if (empty($name) || empty($phone) || empty($date) || empty($time) || empty($people) || empty($table)) {
        echo 'error1';
    }
         else if($date < $now) {
            $error = "date error.";
        }
    
    else {
        $stmt = $conn->prepare("INSERT INTO bookings (name, phone, date, time, table_number, members, message) VALUES (?, ?, ?, ?,?, ?, ?)");
        $stmt->bind_param("ssssiis", $name, $phone, $date, $time, $table, $people, $message);
        echo 'success';
        if ($stmt->execute()) {
            echo 'Success';
            $success = "Booking submitted successfully.";
            header('location:main.php');
        } else {
            $error = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
