
<?php include_once __DIR__ . "/head.php"; ?>

<?php
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = '';

$number = 0;

$error = '';
$success = '';

// Correct mysqli connection order: host, user, pass, database
$connect = new mysqli($host, $user, $pass, $db);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

// Adjust query to select all from the 'menu' table; order by 'id' DESC (assuming no created_at)
$result = $connect->query("SELECT * FROM table_image ORDER BY id DESC");

$imageCollection = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $imageCollection[] = $row;
    }
}
?>
    <style>
    .image-preview {
      width: 100%;
      height: 200px;
      object-fit: cover;
      margin-bottom: 15px;
    }
  </style>
    <section id="book-a-table" class="book-a-table section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <div><span>Book a</span> <span class="description-title">Table</span></div>
      </div><!-- End Section Title -->
<?php if (!empty($imageCollection)): ?>
<div class="row g-3 mb-4 border rounded p-3 bg-light">
      <?php foreach ($imageCollection as $image): ?>
        <?php $number+=1 ?>
        <div class="col-md-3">
          <img src="<?= htmlspecialchars($image['image']) ?>" class="image-preview rounded shadow-sm" alt="table Image">
         <div class='text-center'><h5><?php echo $number; ?></h5></div>
        </div>
        <?php endforeach; ?>
    </div>
   <?php endif; ?>


      <div class="container">

        <div class="row g-0" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-4 reservation-img" style="background-image: url(assets/img/reservation.jpg);"></div>

          <div class="col-lg-8 d-flex align-items-center reservation-form-bg" data-aos="fade-up" data-aos-delay="200">
            <form action="booking.php" method="post" role="form" class="">
              <div class="row gy-4">
                <div class="col-lg-4 col-md-6">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="text" class="form-control" name="phone" id="phone" placeholder="Your Phone" required="">
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="date" name="date" class="form-control" id="date" placeholder="Date" required="">
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="time" class="form-control" name="time" id="time" placeholder="Time" required="">
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="number" class="form-control" name="table_number" id="table_number" placeholder="Table Number" required="">
                </div>
                <div class="col-lg-4 col-md-6">
                  <input type="number" class="form-control" name="people" id="people" placeholder="# of people" required="">
                </div>
              </div>

              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message"></textarea>
              </div>

              <div class="text-center mt-3">
                <!-- <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your booking request was sent. We will call back or send an Email to confirm your reservation. Thank you!</div> -->
                <button type="submit" name='btn-register' class='btn btn-warning text-light'>Book a Table</button>
              </div>
            </form>
          </div><!-- End Reservation Form -->

        </div>

      </div>

    </section><!-- /Book A Table Section -->