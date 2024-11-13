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
  <link rel="stylesheet" href="">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
  /* Reset some default styles */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f4f7fc;
  }

  /* Header */
  header {
    background-color: #007bff;
    color: #fff;
    padding: 1rem;
    text-align: center;
  }

  header h1 {
    margin-bottom: 0.5rem;
    font-size: 1.8rem;
  }

  header nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    gap: 1.5rem;
  }

  header nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    padding: 0.5rem 1rem;
  }

  header nav ul li a.active {
    text-decoration: underline;
  }

  /* Main Content */
  main {
    padding: 100px 20px 20px 20px; /* Added padding to avoid overlap with the header */
  }

  .appointment-form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .appointment-form h2 {
    color: #007bff;
    font-size: 28px;
    text-align: center;
    margin-bottom: 20px;
  }

  .appointment-form .form-group {
    margin-bottom: 15px;
  }

  .appointment-form label {
    display: block;
    font-size: 16px;
    color: #333;
    margin-bottom: 5px;
  }

  .appointment-form input[type="text"],
  .appointment-form input[type="tel"],
  .appointment-form input[type="date"],
  .appointment-form input[type="time"],
  .appointment-form textarea {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
    transition: border 0.3s ease;
  }

  .appointment-form input[type="text"]:focus,
  .appointment-form input[type="tel"]:focus,
  .appointment-form input[type="date"]:focus,
  .appointment-form input[type="time"]:focus,
  .appointment-form textarea:focus {
    border-color: #007bff;
    outline: none;
  }

  .appointment-form button {
    padding: 12px 25px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s ease;
  }

  .appointment-form button:hover {
    background-color: #0056b3;
  }

  /* Footer */
  footer {
    background-color: #007bff;
    color: white;
    text-align: center;
    padding: 15px 0;
    width: 100%;
    margin-top: auto; /* Ensures the footer stays at the bottom */
  }

  footer p {
    margin: 0;
    font-size: 14px;
  }

  /* Responsive Design */
  @media (max-width: 768px) {
    header h1 {
      font-size: 24px;
    }

    header nav ul li {
      margin: 0 10px;
    }

    .appointment-form {
      padding: 15px;
    }
  }
  </style>
</head>

<body>
  <header>
    <h1>HealthTrackAI</h1>
    <nav>
      <ul>
        <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>"><i class="fas fa-home"></i> HOME</a></li>
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
          <label for="appointment-date">Appointment Date:</label>
          <input type="date" id="appointment-date" name="appointment_date" required>
        </div>
        <div class="form-group">
          <label for="appointment-time">Appointment Time:</label>
          <input type="time" id="appointment-time" name="appointment_time" required>
        </div>
        <div class="form-group">
          <label for="note">Enter the health problem you need to examine:</label>
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