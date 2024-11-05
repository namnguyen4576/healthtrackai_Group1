<?php
// Bắt đầu phiên làm việc
session_start();

// Kết nối đến cơ sở dữ liệu
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "healthtrackai";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Kiểm tra xem id có được gửi qua URL hay không
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Xóa khách hàng khỏi cơ sở dữ liệu
    $sql = "DELETE FROM users WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Xóa thành công!";
    } else {
        echo "Lỗi: " . $conn->error;
    }

    // Chuyển hướng lại trang danh sách khách hàng
    header("Location: admin.php");
    exit();
}

$conn->close();
?>
