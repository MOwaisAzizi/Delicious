<?php
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = '';

$error = '';
$success = '';

// Correct mysqli connection order: host, user, pass, database
$connect = new mysqli($host, $user, $pass, $db);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Adjust query to select all from the 'menu' table; order by 'id' DESC (assuming no created_at)
$result = $connect->query("SELECT * FROM menu ORDER BY id DESC");

$menuCollection = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $menuCollection[] = $row;
    }
}
?>

<section id="menu" class="menu section">

  <!-- Section Title -->
  <div class="container section-title" data-aos="fade-up">
    <h2>Menu</h2>
    <div><span>Check Our Tasty</span> <span class="description-title">Menu</span></div>
  </div><!-- End Section Title -->

  <div class="container isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-lg-12 d-flex justify-content-center">
        <ul class="menu-filters isotope-filters">
          <li data-filter="*" class="filter-active">All</li>
          <li data-filter=".filter-starters">Starters</li>
          <li data-filter=".filter-salads">Salads</li>
          <li data-filter=".filter-specialty">Specialty</li>
        </ul>
      </div>
    </div><!-- Menu Filters -->

    <div class="row isotope-container" data-aos="fade-up" data-aos-delay="200">

      <?php if (!empty($menuCollection)): ?>
        <?php foreach ($menuCollection as $menuItem): ?>
          <div class="col-lg-6 menu-item isotope-item filter-starters">
          <img src="<?= htmlspecialchars($menuItem['image']); ?>" class="menu-img" alt="">
          <div class="menu-content">
              <a href="#"><?= htmlspecialchars($menuItem['title']); ?></a>
              <span><?= htmlspecialchars($menuItem['price']); ?></span>
            </div>
            <div class="menu-ingredients">
              <?= htmlspecialchars($menuItem['description']); ?>
            </div>
          </div><!-- Menu Item -->
        <?php endforeach; ?>
      <?php else: ?>
        <h2>No Menu Item</h2>
      <?php endif; ?>

    </div><!-- Menu Container -->

  </div>

</section><!-- /Menu Section -->
