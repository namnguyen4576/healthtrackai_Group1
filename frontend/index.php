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
    } elseif (isset($_POST['admin_id'])) {
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
