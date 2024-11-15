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

// Get doctor ID from URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $doctor_id = $_GET['id'];

    // SQL to delete doctor from the database
    $sql = "DELETE FROM doctor WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind the doctor ID
    $stmt->bind_param("i", $doctor_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect back to the doctor list page
        header("Location: admin_doctor.php");
        exit();
    } else {
        echo "<p>Error deleting record: " . $conn->error . "</p>";
    }

    // Close statement and connection
    $stmt->close();
} else {
    echo "<p>Invalid doctor ID.</p>";
}

// Close the connection
$conn->close();
?>
