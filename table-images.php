<?php
$host = 'localhost';
$db = 'user_auth'; 
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$conn->query("
CREATE TABLE IF NOT EXISTS table_image (
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(1000) NOT NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

if ( isset($_FILES['image'])) {
    $uploadDir = 'assets/img/menu/';
    $imagePath = null;
    $error = null;

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = basename($_FILES['image']['name']);
        $uniqueName = uniqid() . '-' . $originalName;
        $targetPath = $uploadDir . $uniqueName;

        // Optional: Ensure it's actually an image
        if (strpos(mime_content_type($tmpName), 'image/') !== 0) {
            $error = "Only image files are allowed.";
        } else {
            if (move_uploaded_file($tmpName, $targetPath)) {
                $imagePath = $targetPath;

                // Insert into DB
                $stmt = $conn->prepare("INSERT INTO table_image (image) VALUES (?)");
                $stmt->bind_param("s", $imagePath);
                $stmt->execute();
                $stmt->close();

               header("Location: " . $_SERVER['PHP_SELF']);
            } else {
                $error = "Failed to move uploaded image.";
            }
        }
    } else {
        $error = "Image upload failed. Please try again.";
    }
}

// === Fetch Images from Database ===
$images = $conn->query("SELECT * FROM table_image ORDER BY uploaded_at DESC");
?>
<style>
    .image-preview {
      width: 100%;
      height: 200px;
      object-fit: cover;
      margin-bottom: 15px;
    }
  </style>
<body>
  <div class="container py-5">
    <h3 class="mb-3">Table Image List</h3>

    <!-- Upload Form -->
    <form action="" method="post" enctype="multipart/form-data" class="mb-4">
      <div class="mb-3">
        <input type="file" name="image" class="form-control" required>
      </div>
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <button type="submit" class="btn btn-primary">Upload Image</button>
    </form>

    <!-- Image Display Section -->
    <div class="row g-3 mb-4 border rounded p-3 bg-light">
      <!-- Dynamic Images -->
      <?php while ($row = $images->fetch_assoc()): ?>
        <div class="col-md-3">
          <img src="<?= htmlspecialchars($row['image']) ?>" class="image-preview rounded shadow-sm" alt="Uploaded Image">
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</body>
</html>
