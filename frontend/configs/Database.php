    <?php
    // configs/database.php

    $servername = "localhost"; // Địa chỉ máy chủ MySQL, thường là localhost
    $username = "root";        // Tên người dùng MySQL, thường là root
    $password = "";            // Mật khẩu MySQL, để trống nếu bạn không đặt mật khẩu
    $dbname = "healthtrackai"; // Tên cơ sở dữ liệu mà bạn đã tạo

    // Tạo kết nối
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    // Đặt chế độ lỗi cho mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Thực hiện truy vấn
    function executeQuery($query) {
        global $conn;
        return $conn->query($query);
    }

    // Đóng kết nối khi không còn sử dụng
    function closeConnection() {
        global $conn;
        if ($conn) {
            $conn->close();
        }
    }
    ?>
