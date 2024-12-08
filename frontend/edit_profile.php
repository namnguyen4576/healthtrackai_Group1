<?php
session_start();
require 'configs/database.php';

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Lấy thông tin hiện tại của người dùng
$sql = "SELECT name, email, contact, gender, avatar FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>alert('User not found.');</script>";
    header("Location: profile.php");
    exit();
}

$stmt->close();

// Xử lý cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];

    // Xử lý avatar
    $avatar_path = $user['avatar']; // Giữ lại avatar cũ nếu không thay đổi
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
        $avatar_directory = 'frontend/uploads/avatars/';
        
        // Kiểm tra thư mục và tạo thư mục nếu chưa có
        if (!is_dir($avatar_directory)) {
            mkdir($avatar_directory, 0777, true);  // Tạo thư mục nếu chưa tồn tại
        }

        $avatar_filename = basename($_FILES['avatar']['name']);
        $avatar_path = $avatar_directory . $avatar_filename;

        // Di chuyển file upload
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_path)) {
            // Di chuyển thành công
        } else {
            echo "<script>alert('Error uploading avatar. Please try again.');</script>";
        }
    }

    // Cập nhật thông tin người dùng
    if ($avatar_path) {
        // Nếu có avatar mới
        $sql = "UPDATE users SET name = ?, email = ?, contact = ?, gender = ?, avatar = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $email, $contact, $gender, $avatar_path, $user_id);
    } else {
        // Nếu không có avatar mới
        $sql = "UPDATE users SET name = ?, email = ?, contact = ?, gender = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii", $name, $email, $contact, $gender, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully');</script>";
        header("Location: profile.php");
        exit();
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - HealthTrackAI</title>
    <link rel="stylesheet" href="assets/css/edit_profile.css">
</head>

<body>
    <header>
        <div class="container">
            <h1>Edit Profile</h1>
            <nav>
                <ul>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <section class="profile">
                <h2>Edit Your Profile</h2>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact:</label>
                        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" required>
                            <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
                            <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="avatar">Avatar:</label>
                        <input type="file" id="avatar" name="avatar">
                        <!-- Hiển thị ảnh hiện tại nếu có -->
                        <div class="avatar-preview">
                            <?php if (!empty($user['avatar'])): ?>
                                <img src="<?php echo $user['avatar']; ?>" alt="Current Avatar" class="avatar-img">
                            <?php else: ?>
                                <img src="assets/images/avatar.jpg" alt="Default Avatar" class="avatar-img">
                            <?php endif; ?>
                        </div>
                    </div>

                    <button type="submit" class="btn">Update Profile</button>
                </form>
            </section>
        </div>
    </main>
</body>

</html>
