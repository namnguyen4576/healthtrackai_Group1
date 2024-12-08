<?php
// Start the session
session_start();

// Database connection
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "healthtrackai";
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get doctor ID from URL
if (!isset($_GET['id'])) {
    die("Doctor ID is required.");
}
$doctor_id = $_GET['id'];

// Retrieve existing doctor data
$sql = "SELECT * FROM doctor WHERE id = $doctor_id";
$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Doctor not found.");
}
$doctor = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $qualification = $_POST['qualification'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $nickname = $_POST['nickname'];
    $image = $doctor['image']; // Giữ ảnh cũ nếu không có ảnh mới được tải lên

    // Kiểm tra nếu có ảnh mới được tải lên
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file; // Cập nhật đường dẫn ảnh mới
        } else {
            echo "Error uploading the image.";
        }
    }

    // Cập nhật dữ liệu vào cơ sở dữ liệu
    $sql = "UPDATE doctors SET name=?, specialty=?, qualification=?, gender=?, age=?, nickname=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssissi", $name, $specialty, $qualification, $gender, $age, $nickname, $image, $doctor_id);
    $stmt->execute();
    header("Location: success_page.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f4f6f9;
            color: #333;
            padding: 20px;
            min-height: 100vh;
        }

        header {
            background-color: #007bff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: #fff;
            margin-bottom: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 28px;
            font-weight: 600;
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 6px;
            background: #0056b3;
            transition: background 0.3s ease;
        }

        nav ul li a:hover {
            background: #004085;
        }

        .form-container {
            background: #fff;
            border-radius: 12px;
            padding: 30px 40px;
            width: 100%;
            max-width: 600px;
            margin: 40px auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-in-out;
        }

        .form-container h2 {
            text-align: center;
            color: #007bff;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .form-container label {
            display: block;
            font-weight: 500;
            color: #333;
            margin-bottom: 10px;
        }

        .form-container input,
        .form-container select,
        .form-container textarea {
            width: 100%;
            padding: 10px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 6px;
            background: #f9f9f9;
            font-size: 16px;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container input:focus,
        .form-container select:focus,
        .form-container textarea:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
            background: #fff;
            outline: none;
        }

        .form-container button {
            width: 100%;
            padding: 12px;
            background: #007bff;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .form-container button:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .form-container button:active {
            transform: translateY(0);
        }

        .current-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .current-image img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-top: 10px;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }


        }
    </style>
</head>

<body>
    <header>
        <h1>HealthTrackAI - Edit Doctor</h1>
        <nav>
            <ul>
                <li><a href="admin.php">User List</a></li>
                <li><a href="admin_doctor.php">Doctor List</a></li>
                <li><a href="schedule_appointment.php">Appointments</a></li>
                <li><a href="add_doctor.php">Add Doctor</a></li>
                <li><a href="add_schedule_appointment.php" class="section-btn">Add Schedule Appointment</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="form-container">
        <h2>Edit Doctor</h2>
        <form action="edit_doctor.php?id=<?= $doctor_id ?>" method="post" enctype="multipart/form-data">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= $doctor['name'] ?>" required>

            <label for="specialty">Specialty</label>
            <input type="text" id="specialty" name="specialty" value="<?= $doctor['specialty'] ?>" required>

            <label for="qualification">Qualification</label>
            <input type="text" id="qualification" name="qualification" value="<?= $doctor['qualification'] ?>" required>

            <label for="gender">Gender</label>
            <select id="gender" name="gender">
                <option value="Male" <?= $doctor['gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
                <option value="Female" <?= $doctor['gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
            </select>

            <label for="age">Age</label>
            <input type="number" id="age" name="age" value="<?= $doctor['age'] ?>" required>

            <label for="nickname">Nickname</label>
            <input type="text" id="nickname" name="nickname" value="<?= $doctor['nickname'] ?>" required>

            <label for="current-image">Current Image</label>
            <div class="current-image">
                <img src="<?= $doctor['image'] ?>" alt="Doctor Image">
            </div>

            <label for="image">Change Image</label>
            <input type="file" id="image" name="image" accept="image/*">

            <button type="submit">Update Doctor</button>
        </form>
    </div>

</body>

</html>