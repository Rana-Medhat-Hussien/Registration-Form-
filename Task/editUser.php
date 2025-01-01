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

// Fetch the user record by ID
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  // 'i' indicates an integer parameter
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle form submission for updating the user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $mail_status = isset($_POST['terms']) ? 'Active' : 'Inactive';  // Set mail status based on checkbox

    // Update the user data in the database
    $update_sql = "UPDATE users SET user_name = ?, user_email = ?, user_gender = ?, user_mail_status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssssi", $name, $email, $gender, $mail_status, $user_id);

    if ($update_stmt->execute()) {
        header('Location: userDetails.php');  // Redirect to user list after successful update
        exit();
    } else {
        echo 'Error: ' . $update_stmt->error;
    }

    $update_stmt->close();
}

$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit User</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="male" name="gender" value="Male" <?php if ($user['user_gender'] == 'Male') echo 'checked'; ?> required>
                    <label for="male" class="form-check-label">Male</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="female" name="gender" value="Female" <?php if ($user['user_gender'] == 'Female') echo 'checked'; ?> required>
                    <label for="female" class="form-check-label">Female</label>
                </div>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="terms" name="terms" <?php if ($user['user_mail_status'] == 'Active') echo 'checked'; ?>>
                <label for="terms" class="form-check-label">I agree to receive emails from us</label>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="userDetails.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
