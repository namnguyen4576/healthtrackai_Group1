<?php
// Start the session
session_start();

// Connect to the database
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "healthtrackai";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Convert 'id' to an integer to prevent SQL injection

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirect to admin.php with success message
        header("Location: admin.php?message=User deleted successfully");
    } else {
        // Redirect with error message
        header("Location: admin.php?message=Error deleting user: " . $conn->error);
    }

    $stmt->close();
} else {
    // Redirect if no 'id' is provided
    header("Location: admin.php?message=Invalid user ID");
}

// Close the connection
$conn->close();
?>
