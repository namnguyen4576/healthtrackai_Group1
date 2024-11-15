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

// Handle doctor form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $specialty = $_POST['specialty'];
    $qualification = $_POST['qualification'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $nickname = $_POST['nickname'];
    $image = $_POST['image'];

    // Insert new doctor into the database
    $sql = "INSERT INTO doctor (name, specialty, qualification, gender, age, nickname, image) 
            VALUES ('$name', '$specialty', '$qualification', '$gender', '$age', '$nickname', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "New doctor added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve doctor data
$sql = "SELECT id, name, specialty, qualification, gender, age, nickname, image FROM doctor";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors</title>
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

/* Form Container */
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

.form-container label {
    margin: 10px 0 5px;
    font-size: 16px;
    color: #555;
    font-weight: 500;
}

.form-container input,
.form-container select {
    padding: 12px;
    font-size: 16px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 6px;
    transition: border-color 0.3s;
}

.form-container input:focus,
.form-container select:focus {
    border-color: #2ca4ed;
}

.form-container button {
    padding: 12px;
    font-size: 16px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.form-container button:hover {
    background-color: #218838;
}

/* Table Container */
.table-container {
    margin: 40px 0;
    width: 90%;
    max-width: 800px;
    background-color: #ffffff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.table-container h2 {
    color: #2ca4ed;
    text-align: center;
    margin-bottom: 20px;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px; /* Added margin for spacing */
}

table th,
table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: center;
}

table th {
    background-color: #2ca4ed;
    color: #ffffff;
}

table tr:nth-child(even) {
    background-color: #f8f9fa;
}

/* Button Styles */
td a {
    padding: 8px 12px;
    font-size: 14px;
    color: #ffffff;
    text-decoration: none;
    border-radius: 4px;
    margin: 0 5px; /* Added margin between buttons */
    display: inline-block; /* Ensure buttons appear inline */
    transition: background-color 0.3s;
}

/* Edit Button */
.edit-btn {
    background-color: #ffc107;
}

.edit-btn:hover {
    background-color: #e0a800;
}

/* Delete Button */
.delete-btn {
    background-color: #dc3545;
}

.delete-btn:hover {
    background-color: #c82333;
}

/* Add spacing between the buttons */
.edit-btn, .delete-btn {
    margin-right: 10px; /* Extra margin to prevent buttons from clumping together */
}

/* Add Button */
.add-btn {
    background-color: #28a745;
    float: right;
    margin-top: 20px; /* Added margin to separate it from the table */
}

.add-btn:hover {
    background-color: #218838;
}

/* Section Button */
.section-btn {
    background-color: #2ca4ed;
}

.section-btn:hover {
    background-color: #1c80b8;
}
    </style>
</head>
<body>
<header>
    <h1>HealthTrackAI</h1>
    <nav>
        <ul>
            <li><a href="admin.php"><i class="fas fa-key"></i>Acount User List</a></li>
            <li><a href="admin_doctor.php" class="section-btn">Doctor list</a></li>
            <li><a href="schedule_appointment.php" class="section-btn">Schedule Appointment list</a></li>
            <li><a href="add_doctor.php" class="section-btn">Add Doctor</a></li>
            <li><a href="add_schedule_appointment.php" class="section-btn">Add Schedule Appointment</a></li>
            <li><a href="index.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </nav>
</header>

<!-- Doctor Table -->
<div class="table-container">
    <h2>Doctor List</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Specialty</th>
                <th>Qualification</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Nickname</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['specialty']}</td>
                            <td>{$row['qualification']}</td>
                            <td>{$row['gender']}</td>
                            <td>{$row['age']}</td>
                            <td>{$row['nickname']}</td>
                            <td><img src='{$row['image']}' alt='Doctor Image' width='50' height='50'></td>
                            <td>
                                <a href='admin_doctor_edit.php?id={$row['id']}' class='edit-btn'>Edit</a>
                                <a href='delete_doctor.php?id={$row['id']}' class='delete-btn'>Delete</a>
                            </td>
                          </tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
