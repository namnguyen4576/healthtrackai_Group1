<?php
session_start();
require 'configs/database.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$userError = $adminError = ""; // Biến để lưu lỗi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['user-email'])) {
        // Xử lý đăng nhập của người dùng
        $email = $_POST['user-email'];
        $password = $_POST['user-password'];

        // Kiểm tra người dùng trong cơ sở dữ liệu
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // Đăng nhập thành công cho người dùng
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                header("Location: home.php"); // Chuyển đến trang người dùng
                exit();
            } else {
                $userError = "Incorrect password. Please try again.";
            }
        } else {
            $userError = "No user found with this email.";
        }
        $stmt->close();
    } else if (isset($_POST['admin_id'])) {
        // Xử lý đăng nhập cho Admin với tài khoản cố định
        $admin_id = $_POST['admin_id'];
        $admin_password = $_POST['admin-password'];

        // Kiểm tra thông tin admin với tài khoản cố định
        if ($admin_id === 'admin' && $admin_password === '123') {
            // Đăng nhập thành công cho Admin
            $_SESSION['admin_id'] = 'admin';
            $_SESSION['admin_username'] = $admin_id;
            header("Location: admin.php"); // Chuyển đến trang Admin
            exit();
        } else {
            $adminError = "Incorrect admin credentials. Please try again.";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthTrackAI</title>
    <link rel="stylesheet" href="assets/css/index.css">
    <script src="assets/js/index.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    * {
  box-sizing: border-box;
}

html {
  scroll-behavior: smooth;
}

body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f5f5f5;
}

/* Header */
h1 {
  text-align: left;
  margin-left: 20px;
}

header {
  background-color: #007bff;
  color: white;
  padding: 2px;
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: fixed;
}

header nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  justify-content: center;
}

header nav ul li {
  margin: 0 3px;
  border: 2px solid transparent;
  /* Default border is transparent */
  border-radius: 4px;
  transition: border 0.3s ease, background-color 0.3s ease;
}

header nav ul li.home {
  background-color: transparent;
  /* Default background is transparent */
  border: none;
  /* No border for the home link */
}

header nav ul li.home:hover {
  border: 2px solid white;
  /* Change border color when hovered */
  background-color: rgba(255, 255, 255, 0.2);
  /* Change background color when hovered */
}

header nav ul li:hover:not(.home) {
  border: 2px solid white;
  /* Keep hover effect for other links */
  background-color: rgba(255, 255, 255, 0.2);
  /* Background change for other links */
}

header nav ul li a {
  color: white;
  text-decoration: none;
  padding: 10px 15px;
  display: block;
}

/* Các phần chính */
.chat {
  width: 100%;
  height: auto;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.full-image {
  width: 100%;
  height: 80vh;
}

.intro,
.contact,
.chat {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.intro h2,
.login-admin h2 {
  color: #007bff;
  font-size: 30px;
}

.contact h2,
.login-user h2 {
  color: white;
  font-size: 30px;
}

.intro {
  margin-top: 40px;
}

.contact {
  color: white;
  margin-top: 80px;
  padding: 60px;
  background-color: rgb(110, 157, 184);
}

/* Admin Login */
.login-admin {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  background-color: #f5f5f5;
  border: 1px solid #ddd;
  padding: 40px;
  width: 100%;
  max-width: 400px;
  margin: 100px auto;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.login-admin h2 {
  color: #007bff;
  margin-bottom: 20px;
}

.login-admin label {
  font-size: 14px;
  color: #555;
  margin-bottom: 5px;
}

.login-admin input {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
}

.login-admin button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.login-admin button:hover {
  background-color: #0056b3;
}

/* User Login */
.login-user {
  background-color: rgb(110, 157, 184);
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 40px;
  flex-direction: column;
  padding: 100px;
  border: 1px solid #ffffff;
  border-radius: 8px;
  box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.login-user h2 {
  color: white;
  margin-bottom: 20px;
}

.login-user label {
  font-size: 14px;
  color: white;
  margin-bottom: 5px;
}

.login-user input {
  width: 100%;
  padding: 10px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
}

.login-user button {
  width: 100%;
  padding: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.login-user button:hover {
  background-color: #0056b3;
}

.login-user p {
  margin-top: 15px;
  color: white;
}

.login-user a {
  color: #fff;
  text-decoration: underline;
}

.success-message {
  position: absolute; /* Đặt vị trí tuyệt đối */
  top: 80px; /* Đặt khoảng cách từ trên xuống */
  left: 50%; /* Căn giữa theo chiều ngang */
  transform: translateX(-50%); /* Căn giữa hoàn toàn */
  background-color: rgba(212, 237, 218, 0.9); /* Màu nền với độ trong suốt */
  color: #155724; /* Màu chữ */
  border: 1px solid #c3e6cb; /* Đường viền */
  padding: 10px; /* Khoảng cách bên trong */
  margin: 15px 0; /* Khoảng cách bên ngoài */
  border-radius: 5px; /* Bo góc */
  z-index: 10; /* Đảm bảo thông báo nằm trên các phần khác */
}

</style>

<body>
    <header>
        <h1><a href="landing.php" style="color: white; text-decoration: none;">HealthTrackAI</a></h1>
        <nav>
            <ul>
                <li><a href="landing.php"><i class="fas fa-home"></i> HOME</a></li>
                <li><a href="#admin-login"><i class="fas fa-user-shield"></i> ADMIN LOGIN</a></li>
                <li><a href="#user-login"><i class="fas fa-user"></i> USER LOGIN</a></li>
                <li><a href="#about"><i class="fas fa-info-circle"></i> ABOUT US</a></li>
                <li><a href="#contact"><i class="fas fa-envelope"></i> CONTACT</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="chat" id="chat">
            <img src="assets/images/chat-image.jpg" alt="Chat Interface" class="full-image" />
        </section>

        <section class="login-admin" id="admin-login">
            <h2>Admin Login</h2>
            <form action="" method="POST">
                <div>
                    <label for="admin-id">Admin ID:</label>
                    <input type="text" id="admin-id" name="admin_id" required>
                </div>
                <div>
                    <label for="admin-password">Password:</label>
                    <input type="password" id="admin-password" name="admin-password" required>
                </div>
                <button type="submit">LOGIN</button>
                <?php if ($adminError): ?>
                    <p class="error-message"><?php echo $adminError; ?></p>
                <?php endif; ?>
            </form>
        </section>

        <section class="login-user" id="user-login">
            <h2>User Login</h2>
            <form action="" method="POST">
                <div>
                    <label for="user-email">Email:</label>
                    <input type="email" id="user-email" name="user-email" required>
                </div>
                <div>
                    <label for="user-password">Password:</label>
                    <input type="password" id="user-password" name="user-password" required>
                </div>
                <button type="submit">LOGIN</button>
                <?php if ($userError): ?>
                    <p class="error-message"><?php echo $userError; ?></p>
                <?php endif; ?>
                <p>Not registered? <a href="register.php">Create an account</a></p>
            </form>
        </section>

        <section class="intro" id="about">
            <h2>About Us</h2>
            <p>Passionate about medicine. Caring for people.</p>
        </section>

        <section class="contact" id="contact">
            <h2>Contact Us</h2>
            <p>Address: HealthTrackAI, DHA Phase III Medical Center.</p>
        </section>
    </main>

    <script>
        // Cuộn lên đầu trang khi tải lại trang
        window.onload = function() {
            window.scrollTo(0, 0);
        };
    </script>
</body>

</html>
