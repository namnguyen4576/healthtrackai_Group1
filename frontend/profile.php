<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Tải thông tin người dùng từ cơ sở dữ liệu
require 'configs/database.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, email, contact, gender FROM users WHERE id = ?";
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
      background-color: #f4f7fc;
    }

    header {
      background-color: #007bff;
      color: #fff;
      padding: 1.5rem;
      text-align: center;
    }

    header h1 {
      margin-bottom: 1rem;
      font-size: 3rem;
      font-weight: bold;
      text-transform: uppercase;
    }

    header nav ul {
      list-style: none;
      display: flex;
      justify-content: center;
      gap: 2.5rem;
    }

    header nav ul li a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      padding: 0.7rem 1.5rem;
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
        padding: 80px 20px 20px 20px; /* Thêm padding để tránh bị che khuất bởi header */
    }

    .profile {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        background-color: #fff;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .profile h2 {
        color: #007bff;
        font-size: 28px;
        margin-bottom: 30px;
        text-align: left;
        width: 100%;
    }

    .profile-details {
        display: flex;
        flex-direction: column;
        gap: 15px;
        width: 100%;
        margin-bottom: 30px;
    }

    .profile-details p {
        font-size: 18px;
        display: flex;
        justify-content: flex-start;
        font-weight: 500;
        background-color: #f9f9f9;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        width: 100%;
    }

    .profile-details p strong {
        width: 25%; /* Giảm chiều rộng của tên thông tin */
        padding-right: 15px; /* Thêm khoảng cách phải */
    }

    .profile-details p span {
        width: 70%; /* Đảm bảo phần giá trị thông tin chiếm phần còn lại */
    }

    .profile-buttons {
        width: 100%;
        display: flex;
        justify-content: flex-start;
    }

    .profile-buttons .btn {
        padding: 12px 25px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        font-size: 18px;
        margin: 10px 0;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .profile-buttons .btn:hover {
        background-color: #0056b3;
    }

    /* Footer */
    footer {
        background-color: #007bff;
        color: white;
        text-align: center;
        padding: 15px 0;
        width: 100%;
        margin-top: auto; /* Đảm bảo footer luôn ở dưới */
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

        .profile {
            padding: 20px;
        }

        .profile-details p {
            font-size: 16px;
        }

        .profile h2 {
            font-size: 24px;
        }
    }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <h1>HealthTrackAI</h1>
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
            <h2>Welcome to your profile</h2>
            <div class="profile-details">
                <p><strong>Name:</strong> <span><?php echo htmlspecialchars($user['name']); ?></span></p>
                <p><strong>Email:</strong> <span><?php echo htmlspecialchars($user['email']); ?></span></p>
                <p><strong>Contact:</strong> <span><?php echo htmlspecialchars($user['contact']); ?></span></p>
                <p><strong>Gender:</strong> <span><?php echo htmlspecialchars(ucfirst($user['gender'])); ?></span></p>
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