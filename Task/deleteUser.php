<?php
// Create database connection
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'iti_db';

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Get the ID of the user from the URL
$user_id = isset($_GET['id']) ? $_GET['id'] : '';

// Delete the user record from the database
$sql = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // 'i' indicates an integer parameter

if ($stmt->execute()) {
    header('Location: userDetails.php');  // Redirect to user list after successful deletion
    exit();
} else {
    echo 'Error: ' . $stmt->error;
}

$stmt->close();
mysqli_close($conn);
?>
