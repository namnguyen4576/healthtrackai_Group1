<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthTrackAI - Hospitals</title>
  <link rel="stylesheet" href="assets/css/hospitals.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
  <header>
    <h1>HealthTrackAI</h1>
    <nav>
      <ul>
        <li><a href="home.php"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="hospitals.php" class="<?= basename($_SERVER['PHP_SELF']) == 'hospitals.php' ? 'active' : '' ?>"><i class="fas fa-hospital"></i> HOSPITALS</a></li>
        <li><a href="doctors.php"><i class="fas fa-user-md"></i> DOCTORS</a></li>
        <li><a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>"><i class="fas fa-user"></i> PROFILE</a></li>
        <li><a href="landing.php"><i class="fas fa-lock"></i> LOGOUT</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="appointment-form">
      <h2>Book an Appointment</h2>
      <form action="book_appointment.php" method="POST">
        <div class="form-group">
          <label for="patient-name">Your Name:</label>
          <input type="text" id="patient-name" name="patient_name" required placeholder="Enter your full name">
        </div>
        <div class="form-group">
          <label for="phone-number">Phone Number:</label>
          <input type="tel" id="phone-number" name="phone_number" required placeholder="Enter your phone number">
        </div>
        <div class="form-group">
          <label for="note">Note (Optional):</label>
          <textarea id="note" name="note" placeholder="Enter any special requests or notes"></textarea>
        </div>
        <button type="submit">Confirm Appointment</button>
      </form>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <p>Contact us: 123-456-7890 | Email: info@healthtrackai.com</p>
    <p>Address: 123 Health St, Wellness City, Healthy Country</p>
  </footer>

</body>

</html>
