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
  <title>HealthTrackAI</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

    /* Slideshow Section */
    .slideshow {
      position: relative;
      width: 100%;
      height: 400px;
      overflow: hidden;
      border-radius: 15px;
      margin-top: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .slide {
      display: none;
      width: 100%;
      height: 100%;
    }

    .slide.active {
      display: block;
    }

    .slideshow img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 15px;
    }

    /* Section styles */
    section {
      padding: 60px 30px;
      margin: 40px 20px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    section h2 {
      font-size: 2.5rem;
      margin-bottom: 2rem;
      text-align: center;
      color: #333;
    }

    section p {
      font-size: 1.2rem;
      line-height: 1.8;
      color: #555;
      text-align: center;
    }

    /* Tổng thể */
    .about-hospital {
      background-color: #f4f7fa;
      padding: 40px 20px;
      font-family: Arial, sans-serif;
      color: #333;
    }

    /* Tiêu đề chính */
    .about-hospital h2 {
      text-align: center;
      color: #4CAF50;
      font-size: 28px;
      margin-bottom: 30px;
      font-weight: 600;
    }

    /* Các phần (section) */
    .section {
      margin-bottom: 30px;
    }

    /* Tiêu đề các phần */
    .section h3 {
      color: #333;
      font-size: 22px;
      margin-bottom: 10px;
      font-weight: 500;
      border-bottom: 2px solid #4CAF50;
      padding-bottom: 5px;
    }

    /* Đoạn văn */
    .section p {
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 15px;
      text-align: justify;
    }

    /* Danh sách */
    .section ul {
      padding-left: 20px;
      list-style-type: disc;
    }

    .section ul li {
      font-size: 16px;
      line-height: 1.6;
      margin-bottom: 10px;
    }

    /* Định dạng cho các liên kết trong nội dung */
    .section a {
      color: #4CAF50;
      text-decoration: none;
    }

    .section a:hover {
      text-decoration: underline;
    }

    /* Cải thiện không gian cho các phần */
    .section:last-child {
      margin-bottom: 0;
    }

    /* Thêm khoảng cách cho các đoạn văn dài */
    .section p:last-child {
      margin-bottom: 0;
    }

    /* Doctor Section */
    .doctor-list {
      display: flex;
      flex-wrap: wrap;
      justify-content: flex-start;
      /* Cho phép các thẻ bác sĩ căn chỉnh từ bên trái */
      gap: 65px;
      /* Khoảng cách giữa các thẻ bác sĩ */
    }

    .doctor-card {
      background-color: white;
      border: 1px solid #ddd;
      border-radius: 15px;
      padding: 25px;
      text-align: center;
      width: 30%;
      /* Điều chỉnh kích thước thẻ bác sĩ */
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      margin-bottom: 30px;
    }

    .doctor-card img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      margin-bottom: 15px;
    }

    .doctor-card:hover {
      transform: scale(1.05);
    }

    .doctor-card h3 {
      font-size: 1.5rem;
      margin: 15px 0;
      color: #007bff;
    }

    .doctor-card p {
      font-size: 1.1rem;
      color: #777;
    }


    /* News Section */
    .news {
      display: flex;
      justify-content: space-between;
      gap: 20px;
    }

    .news-card {
      background-color: white;
      padding: 25px;
      text-align: center;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 32%;
    }

    .news-card h3 {
      font-size: 1.6rem;
      margin-bottom: 1.2rem;
      color: #007bff;
    }

    .news-card p {
      font-size: 1.1rem;
      color: #555;
    }

    /* Footer Section */
    footer {
      background-color: #007bff;
      color: white;
      text-align: center;
      padding: 20px 0;
      margin-top: 60px;
    }

    footer p {
      font-size: 1.1rem;
    }

    footer .partner-logo {
      width: 120px;
      height: auto;
      margin: 10px;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
      header h1 {
        font-size: 2rem;
      }

      header nav ul {
        flex-direction: column;
      }

      .doctor-card,
      .news-card {
        width: 100%;
      }

      .slideshow img {
        object-position: center center;
      }

      /* News Section */
      .news {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        /* Responsive grid layout */
        gap: 20px;
        margin-top: 20px;
      }

      .news-card {
        background-color: #fff;
        padding: 20px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }

      .news-card h3 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: #007bff;
        font-weight: bold;
      }

      .news-card p {
        font-size: 1.1rem;
        color: #555;
        line-height: 1.6;
      }

      .news-card:hover {
        transform: translateY(-5px);
        /* Slight lift effect */
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
        /* Increase shadow on hover */
      }
    }


    @media (max-width: 768px) {
      .news-card h3 {
        font-size: 1.3rem;
      }

      .news-card p {
        font-size: 1rem;
      }
    }

    /* Partners Section */
    .partners {
      display: flex;
      justify-content: space-around;
      align-items: center;
      gap: 30px;
      margin-top: 40px;
    }

    .partner-logo {
      width: 150px;
      height: auto;
      object-fit: contain;
      transition: transform 0.3s ease;
    }

    .partner-logo:hover {
      transform: scale(1.1);
      /* Slight zoom effect on hover */
    }

    /* Special Services Section */
    .services {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      gap: 30px;
      margin-top: 40px;
    }

    .service {
      background-color: #fff;
      padding: 20px;
      text-align: center;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 30%;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .service h3 {
      font-size: 1.5rem;
      margin-bottom: 1rem;
      color: #007bff;
      font-weight: bold;
    }

    .service p {
      font-size: 1.1rem;
      color: #555;
      line-height: 1.6;
    }

    .service:hover {
      transform: translateY(-5px);
      /* Slight lift effect */
      box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
      /* Increase shadow on hover */
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .partners {
        flex-direction: column;
        align-items: center;
      }

      .partner-logo {
        width: 120px;
      }

      .service {
        width: 100%;
        margin-bottom: 20px;
      }
    }

    .row {
      margin-right: 50px;
      margin-left: 50px;
    }
  </style>
</head>

<body>
  <header>
    <img src="assets\images\logo.jpg" alt="HealthTrackAI Logo" class="logo">
    <nav>
      <ul>
        <li><a href="home.php" class="active"><i class="fas fa-home"></i> HOME</a></li>
        <li><a href="hospitals.php"><i class="fas fa-hospital"></i> HOSPITALS</a></li>
        <li><a href="doctors.php"><i class="fas fa-user-md"></i> DOCTORS</a></li>
        <li><a href="profile.php"><i class="fas fa-user"></i> PROFILE</a></li>
        <li><a href="landing.php"><i class="fas fa-lock"></i> LOGOUT</a></li>
      </ul>
    </nav>
  </header>

  <div class="row">
    <div class="slideshow">
      <img src="assets/images/banner1.jpg" alt="Welcome Banner 1" class="slide active">
      <img src="assets/images/banner2.jpg" alt="Welcome Banner 2" class="slide">
      <img src="assets/images/banner3.jpg" alt="Welcome Banner 3" class="slide">
    </div>
    <section>
      <section class="about-hospital">
        <h2>About Our Hospital</h2>

        <div class="section">
          <h3>Mission & Vision</h3>
          <p>
            Based on the traditional foundation and the great values of the Vietnamese medical industry from the past to the present, Tam Anh General Hospital aims to bring high-quality medical services to the community. We provide access to modern methods, techniques, and protocols, ensuring that patients experience top-tier services similar to those in foreign countries.
          </p>
          <p>
            From the start of its operation, Tam Anh Hospital has focused on building a team of highly qualified and experienced doctors, with leading experts in various fields including urology, obstetrics and gynecology, pediatrics, respiratory medicine, musculoskeletal systems, reproductive support, otolaryngology, neurology, and more.
          </p>
        </div>

        <div class="section">
          <h3>Our Expert Team</h3>
          <p>
            We have gathered a team of leading experts from many medical fields to provide comprehensive, scientific, and effective services. Our medical professionals work together to ensure the highest standard of care for our patients.
          </p>
        </div>

        <div class="section">
          <h3>5-Star Hotel Hospital</h3>
          <p>
            Built according to the hotel hospital model, our hospital is designed to meet professional medical standards while offering high-class services. From inpatient rooms to restaurants and landscapes, we ensure a comfortable and welcoming environment for all our patients.
          </p>
        </div>
      </section>

      <section>
        <h2>Meet Our Doctors</h2>
        <div class="doctor-list">
          <?php
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              echo "<div class='doctor-card'>";
              echo "<img src='" . $row['image'] . "' alt='Doctor Image'>";
              echo "<h3>" . $row['name'] . "</h3>";
              echo "<p>Specialty: " . $row['specialty'] . "</p>";
              echo "<p>Qualification: " . $row['qualification'] . "</p>";
              echo "<p>Age: " . $row['age'] . "</p>";
              echo "</div>";
            }
          } else {
            echo "<p>No doctors found</p>";
          }
          ?>
        </div>
      </section>
      <!-- News Section -->
      <section>
        <h2>Tin tức</h2>
        <div class="news">
          <div class="news-card">
            <h3>Ứng dụng AI trong y tế</h3>
            <p>Khám phá những xu hướng mới nhất trong ứng dụng AI vào quản lý sức khỏe.</p>
          </div>
          <div class="news-card">
            <h3>Cập nhật công nghệ</h3>
            <p>HealthTrackAI ra mắt tính năng mới, giúp người dùng theo dõi sức khỏe dễ dàng hơn.</p>
          </div>
          <div class="news-card">
            <h3>Hội thảo y tế 2024</h3>
            <p>Tham gia hội thảo y tế với sự góp mặt của các chuyên gia đầu ngành.</p>
          </div>
        </div>
      </section>

      <!-- Partners Section -->
      <section>
        <h2>Đối tác hợp tác</h2>
        <div class="partners">
          <img src="assets/images/partner1.png" alt="Partner 1" class="partner-logo">
          <img src="assets/images/partner2.png" alt="Partner 2" class="partner-logo">
          <img src="assets/images/partner3.png" alt="Partner 3" class="partner-logo">
        </div>
      </section>

      <!-- Special Services Section -->
      <section>
        <h2>Dịch vụ đặc biệt</h2>
        <div class="services">
          <div class="service">
            <h3>Khám từ xa</h3>
            <p>Liên lạc với bác sĩ mọi lúc mọi nơi qua ứng dụng.</p>
          </div>
          <div class="service">
            <h3>Phân tích sức khỏe AI</h3>
            <p>Nhận báo cáo sức khỏe chi tiết dựa trên dữ liệu của bạn.</p>
          </div>
          <div class="service">
            <h3>Theo dõi sức khỏe 24/7</h3>
            <p>Hệ thống giám sát sức khỏe liên tục giúp bạn an tâm hơn.</p>
          </div>
        </div>
      </section>
  </div>

  <footer>
    <p>Contact us: 123-456-7890 | Email: info@healthtrackai.com</p>
    <p>Address: 123 Health St, Wellness City, Healthy Country</p>
  </footer>
  <script>
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

  <script src="https://app.tudongchat.com/js/chatbox.js"></script>
  <script>
    const tudong_chatbox = new TuDongChat('CyClSG4NxJEVI2oYs5AQF')
    tudong_chatbox.initial()
  </script>
</body>

</html>