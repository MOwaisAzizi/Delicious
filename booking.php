<?php
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = '';

$error = '';
$success = '';
echo 'starting..';
// Connect to MySQL (without selecting DB to create DB first)
$conn = new mysqli($host, $user, $pass);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create DB if not exists
$conn->query("CREATE DATABASE IF NOT EXISTS $db");

// Select DB
$conn->select_db($db);

// Create table if not exists
$conn->query("
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date DATE NOT NULL,
    time TIME NOT NULL,
    members INT NOT NULL DEFAULT 1,
    message VARCHAR(1000),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if (isset($_POST['btn-register'])) {
    echo'is post';
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = $_POST["phone"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $people = $_POST["people"];
    $message = $_POST["message"];

    if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time) || empty($people)) {
        $error = "Please fill in all fields.";
        echo 'error1';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
        echo 'error2';
    } else {
        $stmt = $conn->prepare("INSERT INTO bookings (name, email, phone, date, time, members, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssis", $name, $email, $phone, $date, $time, $people, $message);
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
