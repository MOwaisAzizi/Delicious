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

<body class="bg-light">
  <!-- <a href="main.php" class="text-dark pt-4 px-3 d-block">← Back</a> -->

  <div class="sidebar">
    <div class="mb-4">
      <i class="bi bi-person"></i> <strong>Azizi</strong>
    </div>
    
    <a href="?page=dashboard" class="nav-link active">
      <i class="bi bi-grid"></i> Dashboard
    </a>
    
    <div class="mt-3">
      <a href="?page=add_menu">
        <i class="bi bi-egg-fried"></i> Add Menu
      </a>
    </div>


    <div class="mt-3">
      <a href="#"><i class="bi bi-image"></i> Images</a>
      <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Log out</a>
    </div>
  </div>

<div class="main-content">
  <?php
    $page = $_GET['page'] ?? 'dashboard';

    switch ($page) {
      case 'add_menu':
        require_once './add_menu.php';
        break;

      case 'dashboard':
      default:
        require_once './dashboard.php';
        break;
    }
  ?>
</div>

  </div>
</body>
