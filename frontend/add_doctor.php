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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Body Style */
        body {
            background-color: #e9ecef;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            padding-top: 70px;
            color: #333;
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 15px;
            background-color: #2ca4ed;
            color: #ffffff;
            text-align: center;
            z-index: 1000;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.15);
        }

        header h1 {
            font-size: 24px;
        }

        /* Navigation */
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            padding: 8px 12px;
            background-color: #1c80b8;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        nav ul li a:hover {
            background-color: #14699d;
        }

        /* Table Form Container */
        .form-container {
            background-color: #ffffff;
            padding: 25px;
            margin-top: 80px;
            border-radius: 10px;
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }

        .form-container h2 {
            text-align: center;
            color: #2ca4ed;
            margin-bottom: 20px;
        }

        /* Table Form */
        .form-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .form-container th,
        .form-container td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .form-container th {
            background-color: #2ca4ed;
            color: #ffffff;
        }

        .form-container tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        /* Input Fields */
        .form-container input,
        .form-container select {
            padding: 10px;
            font-size: 16px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .form-container input:focus,
        .form-container select:focus {
            border-color: #2ca4ed;
        }

        /* Button */
        .form-container button {
            padding: 12px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .form-container button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<header>
    <h1>HealthTrackAI</h1>
    <nav>
        <ul>
            <li><a href="admin.php"><i class="fas fa-key"></i>Account User List</a></li>
            <li><a href="admin_doctor.php" class="section-btn">Doctor List</a></li>
            <li><a href="schedule_appointment.php" class="section-btn">Schedule Appointment List</a></li>
            <li><a href="add_doctor.php" class="section-btn">Add Doctor</a></li>
            <li><a href="add_schedule_appointment.php" class="section-btn">Add Schedule Appointment</a></li>
            <li><a href="index.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
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
