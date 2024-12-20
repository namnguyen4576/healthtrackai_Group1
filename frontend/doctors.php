<?php
// Kết nối cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "healthtrackai";
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy dữ liệu bác sĩ
$sql = "SELECT id, name, specialty, qualification, gender, age, nickname, image FROM doctor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Doctors - HealthTrackAI</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
  /* Reset and general styles */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Arial', sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f4f7fc;
  }

  header {
    background-color: #007bff;
    color: #fff;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    /* Căn trái logo, phải menu */
    align-items: center;
    /* Căn giữa theo chiều dọc */
  }

  header img.logo {
    max-height: 80px;
    /* Thay đổi chiều cao tối đa của logo */
    width: auto;
    /* Giữ tỉ lệ kích thước hình ảnh */
  }

  header nav {
    flex-grow: 1;
    /* Để menu chiếm hết không gian còn lại */
    display: flex;
    justify-content: flex-end;
    /* Căn menu về bên phải */
  }

  header nav ul {
    list-style: none;
    display: flex;
    justify-content: flex-end;
    /* Đảm bảo menu nằm bên phải */
    gap: 2.5rem;
  }

  header nav ul li a {
    color: #fff;
    text-decoration: none;
    font-weight: bold;
    padding: 0.7rem 1.5rem;
    font-size: 1.1rem;
    border-radius: 5px;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  header nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.3);
    color: #fff;
  }

  header nav ul li a.active {
    text-decoration: underline;
    font-style: italic;
  }

  /* Main content */
  main {
    padding: 2rem;
    max-width: 1200px;
    margin: auto;
  }

  h2 {
    margin-bottom: 1.5rem;
    color: #007bff;
    text-align: center;
    font-size: 1.6rem;
  }

  /* Highlighted Doctors Section */
  .highlighted-doctors {
    margin-bottom: 3rem;
  }

  .doctor-cards {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
  }

  .doctor-card {
    background-color: #fff;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 220px;
    transition: transform 0.3s ease;
    margin: 0 10px;
  }

  .doctor-card img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 1rem;
    border: 3px solid #007bff;
  }

  .doctor-card h3 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 0.5rem;
  }

  .doctor-card p {
    font-size: 1rem;
    color: #777;
  }

  .doctor-card:hover {
    transform: translateY(-5px);
  }

  /* Departments Section */
  .departments {
    margin-bottom: 3rem;
  }

  .department-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
  }

  .department-card {
    background-color: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    text-align: center;
    transition: transform 0.3s ease;
  }

  .department-card h3 {
    font-size: 1.3rem;
    color: #007bff;
    margin-bottom: 1rem;
  }

  .department-card p {
    font-size: 1rem;
    color: #777;
  }

  .department-card:hover {
    transform: translateY(-5px);
  }

  footer {
    background-color: #007bff;
    color: white;
    text-align: center;
    padding: 15px 0;
    width: 100%;
    margin-top: auto;
  }

  footer p {
    margin: 0;
    font-size: 14px;
  }

  /* Responsive styling */
  @media (max-width: 768px) {
    header nav ul {
      flex-direction: column;
    }

    .doctor-cards {
      flex-direction: column;
      align-items: center;
    }

    .doctor-card {
      width: 90%;
      margin-bottom: 2rem;
    }

    .department-grid {
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    }
  }
</style>

<body>
  <header>
    <img src="assets\images\logo.jpg" alt="HealthTrackAI Logo" class="logo">
    <nav>
      <ul>
        <li><a href="home.php"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="hospitals.php"><i class="fas fa-hospital"></i> HOSPITALS</a></li>
        <li><a href="doctors.php" class="active"><i class="fas fa-user-md"></i> DOCTORS</a></li>
        <li><a href="profile.php"><i class="fas fa-user"></i> PROFILE</a></li>
        <li><a href="landing.php"><i class="fas fa-lock"></i> LOGOUT</a></li>
      </ul>
    </nav>
  </header>

  <main>
    <section class="highlighted-doctors">
      <h2>Featured Doctors</h2>
      <div class="doctor-cards">
        <?php
        // Display doctors from the database
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<div class="doctor-card">';
          echo "<img src='" . $row['image'] . "' alt='Doctor Image'>";
          echo "<h3>" . $row['name'] . "</h3>";
          echo "<p>Specialty: " . $row['specialty'] . "</p>";
          echo "<p>Qualification: " . $row['qualification'] . "</p>";
          echo "<p>Age: " . $row['age'] . "</p>";
          echo '</div>';
        }
        ?>
      </div>
    </section>

    <section class="departments">
      <h2>Introduction to Departments</h2>
      <div class="department-grid">
        <div class="department-card">
          <h3>Cardiology</h3>
          <p>The Cardiology Department specializes in diagnosing and treating cardiovascular diseases.</p>
        </div>
        <div class="department-card">
          <h3>Endocrinology</h3>
          <p>The Endocrinology Department focuses on hormonal disorders and endocrine diseases.</p>
        </div>
        <div class="department-card">
          <h3>Neurology</h3>
          <p>The Neurology Department provides care and treatment for nervous system disorders.</p>
        </div>
        <div class="department-card">
          <h3>Orthopedics</h3>
          <p>The Orthopedics Department offers treatments for bone, joint, and muscular issues.</p>
        </div>
      </div>
    </section>
  </main>


  <footer>
    <p>Contact us: 123-456-7890 | Email: info@healthtrackai.com</p>
    <p>Address: 123 Health St, Wellness City, Healthy Country</p>
  </footer>

  <script src="https://app.tudongchat.com/js/chatbox.js"></script>
  <script>
    const tudong_chatbox = new TuDongChat('CyClSG4NxJEVI2oYs5AQF')
    tudong_chatbox.initial()
  </script>
</body>
        
</html>