<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require 'configs/database.php';
$user_id = $_SESSION['user_id'];

// Lấy thông tin người dùng từ cơ sở dữ liệu
$sql = "SELECT name, email, contact, gender, avatar FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found.');</script>";
    header("Location: index.php");
    exit();
}

$stmt->close();
$conn->close();

// Đường dẫn ảnh mặc định
$default_avatar = 'assets/images/avatar.jpg';

// Nếu người dùng đã tải lên ảnh, sử dụng ảnh đó
$avatar_path = empty($user['avatar']) || !file_exists($user['avatar']) ? $default_avatar : $user['avatar'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - HealthTrackAI</title>
    <link rel="stylesheet" href="">
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
            background-color: #eef2f9;
            /* Màu nền tổng thể */
        }

        /* Header */
        header {
            background-color: #007bff;
            color: #fff;
            padding: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img.logo {
            max-height: 80px;
            width: auto;
        }

        header nav {
            flex-grow: 1;
            display: flex;
            justify-content: flex-end;
        }

        header nav ul {
            list-style: none;
            display: flex;
            gap: 2rem;
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

        /* Main Content */
        main {
            padding: 60px 30px;
            background-color: #f9fafc;
            /* Màu nền sáng nhẹ */
            min-height: calc(100vh - 150px);
            /* Đảm bảo chiều cao tối thiểu */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Căn giữa nội dung */
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            /* Bóng đổ mềm mại */
            max-width: 960px;
            width: 100%;
            margin: 0 auto;
            border: 1px solid #e6e8eb;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile:hover {
            transform: translateY(-10px);
            /* Di chuyển nhẹ lên khi hover */
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
            /* Bóng đổ đậm hơn khi hover */
        }

        .profile h2 {
            color: #0056b3;
            font-size: 36px;
            margin-bottom: 20px;
            text-align: center;
            /* Căn giữa tiêu đề */
            width: 100%;
            border-bottom: 2px solid #ddd;
            /* Gạch dưới nhẹ */
            padding-bottom: 10px;
            font-family: 'Arial', sans-serif;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 100%;
        }

        .profile-details p {
            font-size: 18px;
            font-weight: 500;
            color: #333;
            background-color: #f5f7fa;
            /* Màu nền sáng nhẹ */
            padding: 15px 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
            /* Viền mỏng */
            transition: background-color 0.3s ease;
        }

        .profile-details p:hover {
            background-color: #e0e7ff;
            /* Màu nền khi hover */
        }

        .profile-details p strong {
            flex: 1;
            color: #555;
            font-size: 16px;
        }

        .profile-details p span {
            flex: 2;
            color: #222;
            text-align: right;
            /* Căn phải phần giá trị */
        }

        .profile-buttons {
            display: flex;
            justify-content: center;
            /* Căn giữa nút */
            gap: 20px;
            /* Khoảng cách giữa các nút */
            margin-top: 30px;
        }

        .profile-buttons .btn {
            padding: 14px 40px;
            background-color: #007bff;
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            font-size: 16px;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .profile-buttons .btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
            /* Tăng kích thước nhẹ khi hover */
        }

        .profile-buttons .btn:active {
            transform: scale(0.98);
            /* Thu nhỏ khi nhấn */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile {
                padding: 30px;
            }

            .profile h2 {
                font-size: 28px;
            }

            .profile-details p {
                font-size: 16px;
                flex-direction: column;
                /* Cột dọc trên màn hình nhỏ */
                text-align: left;
            }

            .profile-details p strong {
                margin-bottom: 5px;
            }

            .profile-buttons .btn {
                width: 100%;
                /* Nút chiếm toàn bộ chiều rộng */
            }
        }

        /* Avatar Styling */
        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, filter 0.3s ease;
        }

        /* Hiệu ứng Hover cho Avatar */
        .profile img:hover {
            transform: scale(1.1);
            /* Phóng to ảnh khi hover */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            /* Thêm bóng đổ khi hover */
            filter: brightness(1.1);
            /* Tăng độ sáng khi hover */
        }

        /* Hiệu ứng cho ảnh khi đã tải xong (đảm bảo không bị giật khi tải) */
        .profile img:loading {
            opacity: 0.6;
            /* Giảm độ sáng khi ảnh đang tải */
        }

        /* Footer */
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
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <img src="assets\images\logo.jpg" alt="HealthTrackAI Logo" class="logo">
        <nav>
            <ul>
                <li><a href="home.php" class="<?= basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>"><i class="fas fa-home"></i> HOME</a></li>
                <li><a href="hospitals.php" class="<?= basename($_SERVER['PHP_SELF']) == 'hospitals.php' ? 'active' : '' ?>"><i class="fas fa-hospital"></i> HOSPITALS</a></li>
                <li><a href="doctors.php" class="<?= basename($_SERVER['PHP_SELF']) == 'doctors.php' ? 'active' : '' ?>"><i class="fas fa-user-md"></i> DOCTORS</a></li>
                <li><a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : '' ?>"><i class="fas fa-user"></i> PROFILE</a></li>
                <li><a href="landing.php"><i class="fas fa-lock"></i> LOGOUT</a></li>
            </ul>
        </nav>
    </header>

    <!-- Main content -->
    <main>
        <section class="profile">
            <h2>Welcome your profile</h2>
            <img src="<?php echo $avatar_path; ?>" alt="Avatar" style="width: 150px; height: 150px; border-radius: 50%; margin-bottom: 20px;">
            <div class="profile-details">
                <p><strong>Name:</strong> <span><?php echo htmlspecialchars($user['name']); ?></span></p>
                <p><strong>Email:</strong> <span><?php echo htmlspecialchars($user['email']); ?></span></p>
                <p><strong>Contact:</strong> <span><?php echo htmlspecialchars($user['contact']); ?></span></p>
                <p><strong>Gender:</strong> <span><?php echo htmlspecialchars($user['gender']); ?></span></p>
            </div>

            <!-- Buttons -->
            <div class="profile-buttons">
                <a href="edit_profile.php" class="btn">Edit Profile</a>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <p>Contact us: 123-456-7890 | Email: info@healthtrackai.com</p>
        <p>Address: 123 Health St, Wellness City, Healthy Country</p>
    </footer>

</body>

</html>