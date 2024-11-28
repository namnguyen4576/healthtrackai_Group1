<?php
session_start();

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['user_name'])) {
  header("Location: index.php");
  exit();
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "healthtrackai";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Truy vấn danh sách bác sĩ
$sql = "SELECT name, specialty, qualification, gender, age, image, nickname FROM doctor";
$result = $conn->query($sql);

// Tạo mảng chứa danh sách bác sĩ
$doctors = [];
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $row['name'] = htmlspecialchars($row['name']);
    $row['specialty'] = htmlspecialchars($row['specialty']);
    $doctors[] = $row;
  }
} else {
  $error_message = "Không có bác sĩ nào trong danh sách.";
}

$conn->close();

// Xử lý form khi người dùng gửi yêu cầu đặt lịch
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $user_name = $_POST['user_name'];
  $phone_number = $_POST['phone_number'];
  $doctor_name = $_POST['doctor_name'];
  $appointment_datetime = $_POST['appointment_datetime']; // Nhận giá trị ngày & giờ
  $note = $_POST['note'];

  // Xử lý lưu thông tin đặt lịch vào cơ sở dữ liệu
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $stmt = $conn->prepare("INSERT INTO appointments (user_name, phone_number, doctor_name, appointment_date, note) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $user_name, $phone_number, $doctor_name, $appointment_datetime, $note);


  if ($stmt->execute()) {
    $success_message = "Appointment scheduled successfully!";
  } else {
    $error_message = "Error scheduling appointment: " . $stmt->error;
  }

  $stmt->close();
  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>HealthTrackAI - Book Appointment</title>
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
  justify-content: space-between; /* Căn trái logo, phải menu */
  align-items: center; /* Căn giữa theo chiều dọc */
}

header img.logo {
  max-height: 80px; /* Thay đổi chiều cao tối đa của logo */
  width: auto;      /* Giữ tỉ lệ kích thước hình ảnh */
}

header nav {
  flex-grow: 1; /* Để menu chiếm hết không gian còn lại */
  display: flex;
  justify-content: flex-end; /* Căn menu về bên phải */
}

header nav ul {
  list-style: none;
  display: flex;
  justify-content: flex-end; /* Đảm bảo menu nằm bên phải */
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


    main {
      background-color: #f4f7fa;
      padding: 40px 0;
      font-family: Arial, sans-serif;
    }

    .appointment-form {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: 0 auto;
      padding: 30px;
    }

    .appointment-form h2 {
      text-align: center;
      color: #4CAF50;
      margin-bottom: 20px;
      font-size: 24px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 16px;
      margin-bottom: 8px;
      color: #333;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 14px;
      color: #333;
      box-sizing: border-box;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      border-color: #4CAF50;
      outline: none;
    }

    textarea {
      resize: vertical;
      min-height: 100px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #4CAF50;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #45a049;
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

      .alert {
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 8px;
  font-size: 16px;
  font-weight: 600;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  opacity: 0;
  animation: fadeIn 0.5s forwards;
}

/* Animation cho sự xuất hiện của thông báo */
@keyframes fadeIn {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

/* Phong cách cho thông báo thành công */
.alert.success {
  background-color: #4CAF50;
  color: white;
  border: 1px solid #45a049;
}

/* Phong cách cho thông báo lỗi */
.alert.error {
  background-color: #f44336;
  color: white;
  border: 1px solid #e53935;
}

/* Nếu có lỗi, thông báo sẽ hiển thị trong 5 giây và tự động biến mất */
.alert.success, .alert.error {
  animation: fadeOut 0.5s 4.5s forwards;
}

@keyframes fadeOut {
  from {
    opacity: 1;
  }
  to {
    opacity: 0;
  }
}

    }
  </style>
</head>

<body>
  <header>
  <img src="assets\images\logo.jpg" alt="HealthTrackAI Logo" class="logo">
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

      <?php if (isset($success_message)): ?>
        <div class="alert success"><?= $success_message ?></div>
      <?php elseif (isset($error_message)): ?>
        <div class="alert error"><?= $error_message ?></div>
      <?php endif; ?>

      <form action="" method="POST">
        <div class="form-group">
          <label for="user_name">Your Name:</label>
          <input type="text" id="user_name" name="user_name" required placeholder="Enter your full name">
        </div>
        <div class="form-group">
          <label for="phone-number">Phone Number:</label>
          <input type="tel" id="phone-number" name="phone_number" required placeholder="Enter your phone number">
        </div>
        <div class="form-group">
          <label for="doctor_name">Doctor:</label>
          <select id="doctor_name" name="doctor_name" required>
            <option value="" disabled selected>Select a doctor</option>
            <?php foreach ($doctors as $doctor) : ?>
              <option value="<?= $doctor['name'] ?>"><?= $doctor['name'] ?> (<?= $doctor['specialty'] ?>)</option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label for="appointment-datetime">Appointment Date & Time:</label>
          <input type="datetime-local" id="appointment-datetime" name="appointment_datetime" required>
        </div>

        <div class="form-group">
          <label for="note">Enter the health problem you need to examine:</label>
          <textarea id="note" name="note" placeholder="Enter any special requests or notes" required></textarea>
        </div>

        <button type="submit">Confirm Appointment</button>
      </form>
    </section>
  </main>

  <footer>
    <p>Contact us: 123-456-7890 | Email: info@healthtrackai.com</p>
    <p>Address: 123 Health St, Wellness City, Healthy Country</p>
  </footer>
</body>

<script>
  // Hàm để ẩn thông báo sau 5 giây
  setTimeout(function() {
    var alert = document.querySelector('.alert');
    if (alert) {
      alert.style.display = 'none';
    }
  }, 5000); // 5000ms = 5 giây
</script>


</html>