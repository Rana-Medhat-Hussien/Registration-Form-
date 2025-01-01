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

    // Fetch all user records from the users table
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Table with Icons</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
        }
        .icon-btn {
            border: none;
            background: none;
            color: #007bff;
            font-size: 1.2rem;
            margin: 0 5px;
            cursor: pointer;
        }
        .icon-btn:hover {
            color: #0056b3;
        }
        .icon-btn.delete {
            color: #dc3545;
        }
        .icon-btn.delete:hover {
            color: #b02a37;
        }
    </style>
</head>
<body>
    <div class="table-container container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>User Details</h2>
            <a href="registrationForm.php" class="btn btn-primary">Add New User</a>
        </div>

        <table class="table table-hover table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Mail Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                // Check if there are records and display them
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>" . htmlspecialchars($row['user_name']) . "</td>
                                <td>" . htmlspecialchars($row['user_email']) . "</td>
                                <td>" . htmlspecialchars($row['user_gender']) . "</td>
                                <td>" . htmlspecialchars($row['user_mail_status']) . "</td>
                                <td>
                                    <a href='viewUser.php?id={$row['id']}' class='icon-btn'>
                                        <i class='bi bi-eye'></i>
                                    </a>
                                    <a href='editUser.php?id={$row['id']}' class='icon-btn'>
                                        <i class='bi bi-pencil'></i>
                                    </a>
                                    <a href='deleteUser.php?id={$row['id']}' class='icon-btn delete'>
                                        <i class='bi bi-trash'></i>
                                    </a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }

                // Close the connection
                mysqli_close($conn);
                ?>
            </tbody>


        </table>
    </div>

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
