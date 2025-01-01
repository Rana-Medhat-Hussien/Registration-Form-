<?php
// Database connection parameters
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'iti_db';

// Create connection
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$conn) {
    die('Could not connect: ' . mysqli_connect_error());
}

// Initialize error messages
$errorMessages = [];

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$gender = $_POST['gender'] ?? '';
$mail_status = isset($_POST['terms']) ? 'Active' : 'Inactive';

// Validate input
if (empty($name)) {
    $errorMessages['name'] = 'Name is required.';
}

if (empty($email)) {
    $errorMessages['email'] = 'Email is required.';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMessages['email'] = 'Invalid email format.';
}

if (empty($gender)) {
    $errorMessages['gender'] = 'Gender is required.';
}

// If there are errors, display them in the form (return to form page)
if (count($errorMessages) > 0) {
    // Store error messages in session to use in the form page
    session_start();
    $_SESSION['errors'] = $errorMessages;
    $_SESSION['form_data'] = $_POST;  // Store form data for repopulation
    header('Location: registrationForm.php');  // Redirect back to form page
    exit();
}

// Prepare and bind the SQL statement
$stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_gender, user_mail_status) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $gender, $mail_status);

// Execute the query
if ($stmt->execute()) {
    header('Location: userDetails.php');
    exit();
} else {
    echo 'Error: ' . $stmt->error;
}

// Closing statement and connection
$stmt->close();
$conn->close();
?>
