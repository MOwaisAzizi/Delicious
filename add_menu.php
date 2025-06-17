<?php include_once './bootstrap/init.php';?>

<?php require_once "./component/head.php" ?>

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
$conn->query("DROP TABLE IF EXISTS menu");

$conn->query("
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    price VARCHAR(10) NOT NULL,
    description VARCHAR(100) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if (isset($_POST['btn-add-menu'])) {
  $title = trim($_POST["title"]);
  $price = trim($_POST["price"]);
  $description = trim($_POST["description"]); // note spelling fix
  $image = trim($_POST["image"]);
  var_dump($image);
    
    // if (empty($title) || empty($price) || empty($description)) {
    //     $error = "Please fill in all fields.";
    //     echo 'error1';
    // } else {
    //     $stmt = $conn->prepare("INSERT INTO menu (title, price, description) VALUES (?, ?, ?)");
    //     // If price is string:
    //     $stmt->bind_param("sds", $title, $price, $description);
        
    //     echo 'success';
    //     if ($stmt->execute()) {
    //         echo 'Success';
    //         $success = "Menu submitted successfully.";
    //         header('location:main.php');
    //         exit();
    //     } else {
    //         $error = "Error: " . $stmt->error;
    //     }
    //     $stmt->close();
    // }
}
?>

<body class="bg-light">

  <a href="main.php" class="text-dark pt-4 px-3 d-block">← Back</a>

  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="card shadow-lg border-0">
          <div class="card-header bg-success text-white text-center">
            <h4 class="mb-0">Add New Product</h4>
          </div>
          <div class="card-body">
            <form action="add_menu.php" method="POST" enctype="multipart/form-data">
              
              <!-- Title -->
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
              </div>
              
              <!-- Price -->
              <div class="mb-3">
                <label for="price" class="form-label">Price ($)</label>
                <input type="number" name="price" id="price" step="0.01" class="form-control" required>
              </div>
              
                            <!-- Description -->
                            <div class="mb-3">
                              <label for="description" class="form-label">Description</label>
                              <textarea name="description" id="description" rows="4" class="form-control" required></textarea>
                            </div>

              <!-- Image -->
              <div class="mb-4">
                <label for="image" class="form-label">Upload Image</label>
                <input type="file" name="image" id="image" accept="image/*" class="form-control" required>
              </div>

              <!-- Submit Button -->
              <div class="d-grid">
                <button type="submit" name='btn-add-menu' class="btn btn-success">Submit</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
