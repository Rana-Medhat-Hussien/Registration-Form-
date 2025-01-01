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

// Get the user ID from the query string
$user_id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch user data based on the user ID
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("User not found.");
}

// Close the connection
$stmt->close();
$conn;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Details</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-5">
        <h2>User Details</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($user['user_name']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['user_email']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['user_gender']); ?></p>
                <p><strong>Mail Status:</strong> <?php echo htmlspecialchars($user['user_mail_status']); ?></p>
                <a href="userDetails.php" class="btn btn-secondary">Back to User List</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
