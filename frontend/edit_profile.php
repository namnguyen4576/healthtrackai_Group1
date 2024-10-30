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
$sql = "SELECT name, email, contact, gender FROM users WHERE id = ?";
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

    // Cập nhật thông tin người dùng trong cơ sở dữ liệu
    $sql = "UPDATE users SET name = ?, email = ?, contact = ?, gender = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $name, $email, $contact, $gender, $user_id);

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
    <link rel="stylesheet" href="assets/css/profile.css">
</head>
<body>
    <header>
        <h1>Edit Profile</h1>
        <nav>
            <ul>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="profile">
            <h2>Edit Your Profile</h2>
            <form action="" method="POST">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div>
                    <label for="contact">Contact:</label>
                    <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($user['contact']); ?>" required>
                </div>

                <div>
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>Male</option>
                        <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>

                <button type="submit">Update Profile</button>
            </form>
        </section>
    </main>
</body>
</html>
