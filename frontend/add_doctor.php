<?php
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $qualification = $_POST['qualification'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $nickname = $_POST['nickname'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = "uploads/" . $image;

    // Ensure uploads directory exists and is writable
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Check if the image is uploaded successfully
    if (move_uploaded_file($image_tmp, $image_folder)) {
        // Insert into the database
        $sql = "INSERT INTO doctor (name, specialty, qualification, gender, age, nickname, image) 
                VALUES ('$name', '$specialty', '$qualification', '$gender', '$age', '$nickname', '$image_folder')";
        if ($conn->query($sql) === TRUE) {
            // Redirect to admin_doctor.php after successful insert
            header("Location: admin_doctor.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Error uploading the image. Check the folder permissions and file path.</p>";
        echo "<p>Temporary file: " . $image_tmp . "</p>";
        echo "<p>Target file: " . $image_folder . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Doctor</title>
    <link rel="stylesheet" href="assets/css/home.css">
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
            background-color: #ffffff;
            padding: 30px;
            margin: auto;
            border-radius: 15px;
            box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 650px;
        }

        .form-container h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 600;
        }

        .form-container table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .form-container th,
        .form-container td {
            padding: 10px;
        }

        .form-container th {
            text-align: left;
            font-weight: 500;
            color: #444;
            font-size: 15px;
        }

        .form-container td {
            text-align: right;
        }

        .form-container input,
        .form-container select {
            padding: 12px;
            font-size: 14px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #007bff;
            box-shadow: 0px 4px 6px rgba(0, 123, 255, 0.1);
            outline: none;
        }

        .form-container input[type="file"] {
            border: none;
            padding: 0;
        }

        .form-container button {
            padding: 15px;
            font-size: 16px;
            font-weight: 600;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 20px;
        }

        .form-container button:hover {
            background-color: #218838;
        }

        .form-container button:active {
            transform: scale(0.98);
        }

        /* Thêm hiệu ứng khi di chuột trên các ô */
        .form-container tr:hover {
            background-color: rgba(0, 123, 255, 0.1);
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <header>
        <h1>HealthTrackAI - Add Doctor</h1>
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
        <h2>Add New Doctor</h2>

        <form method="POST" action="add_doctor.php" enctype="multipart/form-data">
            <table>
                <tr>
                    <th><label for="name">Doctor's Name</label></th>
                    <td><input type="text" id="name" name="name" required placeholder="Enter the doctor's name"></td>
                </tr>
                <tr>
                    <th><label for="specialty">Specialty</label></th>
                    <td><input type="text" id="specialty" name="specialty" required placeholder="Enter the doctor's specialty"></td>
                </tr>
                <tr>
                    <th><label for="qualification">Qualification</label></th>
                    <td><input type="text" id="qualification" name="qualification" required placeholder="Enter the doctor's qualification"></td>
                </tr>
                <tr>
                    <th><label for="gender">Gender</label></th>
                    <td>
                        <select id="gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label for="age">Age</label></th>
                    <td><input type="number" id="age" name="age" required placeholder="Enter the doctor's age" min="18"></td>
                </tr>
                <tr>
                    <th><label for="nickname">Nickname in Specialty</label></th>
                    <td><input type="text" id="nickname" name="nickname" required placeholder="Enter a nickname or alias in specialty"></td>
                </tr>
                <tr>
                    <th><label for="image">Doctor's Image</label></th>
                    <td><input type="file" id="image" name="image" required></td>
                </tr>
            </table>

            <button type="submit">Add Doctor</button>
        </form>
    </div>

</body>

</html>