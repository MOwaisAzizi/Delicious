

<?php include_once './bootstrap/init.php'; ?>
<?php require_once "./component/head.php"; ?>

<style>
  .sidebar {
    height: 100vh;
    background-color: #ff3e3e;
    color: white;
    padding: 1rem;
    width: 250px;
    position: fixed;
  }
  .sidebar a {
    color: white;
    text-decoration: none;
    display: block;
    margin: 0.5rem 0;
  }
  .sidebar a:hover {
    color: #ffd6d6;
  }
  .sidebar .nav-link.active {
    background-color: white;
    color: #ff3e3e !important;
    border-radius: 8px;
  }
  .sidebar .submenu a {
    padding-left: 1.5rem;
    font-size: 0.9rem;
  }
  .main-content {
    margin-left: 260px;
    padding: 2rem;
  }
</style>

<?php
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all bookings
$result = $conn->query("SELECT * FROM bookings ORDER BY created_at DESC");
$bookings = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bookings[] = $row;
    }
}
?>

<div class="container py-5">
    <h2 class="text-center mb-4">Admin Dashboard</h2>

    <div class="table-responsive">
      <table class="table table-bordered table-striped text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Time</th>
            <th>People</th>
            <th>Date</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $booking): ?>
              <tr>
                <td><?= htmlspecialchars($booking['name']) ?></td>
                <td><?= htmlspecialchars($booking['email']) ?></td>
                <td><?= htmlspecialchars($booking['phone']) ?></td>
                <td><?= htmlspecialchars($booking['time']) ?></td>
                <td><?= htmlspecialchars($booking['members']) ?></td>
                <td><?= htmlspecialchars($booking['date']) ?></td>
                <td><?= htmlspecialchars($booking['message']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7">No bookings found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>