<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthTrackAI</title>
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

    .slideshow {
      position: relative;
      width: 100%;
      height: 400px; /* Increased height to avoid overlap */
      overflow: hidden;
      margin-top: 20px; /* Added space between header and slideshow */
    }

    .slideshow img {
      width: 100%;
      height: 100%; /* Ensure image covers full height of the slideshow */
      object-fit: cover; /* Ensure the image scales correctly */
      position: absolute;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .slideshow .active {
      opacity: 1;
    }

    .about-hospital {
      padding: 20px;
      text-align: center;
    }

    .doctor-section {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
      padding: 20px;
    }

    .doctor-card {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 5px;
      width: 200px;
      padding: 15px;
      text-align: center;
    }

    .doctor-card img {
      width: 100px;
      border-radius: 50%;
    }

    footer {
      background-color: #007bff;
      color: white;
      text-align: center;
      padding: 15px 0;
    }
  </style>
</head>

<body>
  <header>
    <h1>HealthTrackAI</h1>
    <nav>
      <ul>
        <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="hospitals.php"><i class="fas fa-hospital"></i> HOSPITALS</a></li>
        <li><a href="doctors.php"><i class="fas fa-user-md"></i> DOCTORS</a></li>
        <li><a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>"><i class="fas fa-user"></i> PROFILE</a></li>
        <li><a href="landing.php"><i class="fas fa-lock"></i> LOGOUT</a></li>
      </ul>
    </nav>
  </header>

  <!-- Slideshow Section -->
  <div class="slideshow">
    <img src="assets/images/banner1.jpg" alt="Welcome Banner 1" class="slide active">
    <img src="assets/images/banner2.jpg" alt="Welcome Banner 2" class="slide">
    <img src="assets/images/banner3.jpg" alt="Welcome Banner 3" class="slide">
  </div>

  <!-- About Hospital Section -->
  <section class="about-hospital">
    <h2>About Our Hospital</h2>
    <p>Our hospital provides top-notch healthcare services with state-of-the-art technology and experienced doctors.</p>
  </section>

  <!-- Doctors Section -->
  <section class="doctor-section">
    <div class="doctor-card">
      <img src="assets/images/doctor1.jpg" alt="Doctor 1">
      <h3>Dr. John Doe</h3>
      <p>Specialist in Cardiology</p>
    </div>
    <div class="doctor-card">
      <img src="assets/images/doctor2.jpg" alt="Doctor 2">
      <h3>Dr. Jane Smith</h3>
      <p>Specialist in Neurology</p>
    </div>
    <!-- Add more doctor cards as needed -->
  </section>

  <!-- Footer -->
  <footer>
    <p>Contact us: 123-456-7890 | Email: info@healthtrackai.com</p>
    <p>Address: 123 Health St, Wellness City, Healthy Country</p>
  </footer>

  <script src="https://app.tudongchat.com/js/chatbox.js"></script>
  <script>
    const tudong_chatbox = new TuDongChat('CyClSG4NxJEVI2oYs5AQF');
    tudong_chatbox.initial();

    function resetChat() {
      tudong_chatbox.reset();
      tudong_chatbox.initial();
    }

    // Slideshow functionality
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slideshow .slide');

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === index) {
          slide.classList.add('active');
        }
      });
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % slides.length;
      showSlide(currentSlide);
    }

    setInterval(nextSlide, 3000); // Change slide every 3 seconds
  </script>

</body>

</html>
