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
  <title>Doctors - HealthTrackAI</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

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
    <h1>HealthTrackAI</h1>
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
      <h2>Bác sĩ Nổi Bật</h2>
      <div class="doctor-cards">
        <div class="doctor-card">
          <img src="assets/images/doctor1.jpg" alt="Doctor Image">
          <h3>Dr. Nguyễn Văn A</h3>
          <p>Chuyên khoa Tim mạch</p>
        </div>
        <div class="doctor-card">
          <img src="assets/images/doctor2.jpg" alt="Doctor Image">
          <h3>Dr. Trần Thị B</h3>
          <p>Chuyên khoa Nội tiết</p>
        </div>
      </div>
    </section>

    <section class="departments">
      <h2>Giới thiệu về các Khoa</h2>
      <div class="department-grid">
        <div class="department-card">
          <h3>Tim mạch</h3>
          <p>Khoa Tim mạch chuyên về chẩn đoán và điều trị các bệnh liên quan đến tim mạch.</p>
        </div>
        <div class="department-card">
          <h3>Nội tiết</h3>
          <p>Khoa Nội tiết tập trung vào các bệnh về hormone và các rối loạn nội tiết.</p>
        </div>
        <div class="department-card">
          <h3>Thần kinh</h3>
          <p>Khoa Thần kinh chuyên chăm sóc và điều trị các bệnh về hệ thần kinh.</p>
        </div>
        <div class="department-card">
          <h3>Chấn thương chỉnh hình</h3>
          <p>Khoa Chấn thương chỉnh hình cung cấp các phương pháp điều trị xương khớp và cơ bắp.</p>
        </div>
      </div>
    </section>
  </main>
</body>

</html>