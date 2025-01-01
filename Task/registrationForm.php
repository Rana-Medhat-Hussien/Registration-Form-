<?php
// Start session to access error messages and form data
session_start();

// Get error messages from session (if any)
$errors = $_SESSION['errors'] ?? [];
$form_data = $_SESSION['form_data'] ?? [];

$name = $form_data['name'] ?? '';
$email = $form_data['email'] ?? '';
$gender = $form_data['gender'] ?? '';
$terms = isset($form_data['terms']) ? true : false;

// Clear session data after use
unset($_SESSION['errors']);
unset($_SESSION['form_data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }
        .form-container {
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-header h2 {
            margin: 0;
            font-weight: bold;
            color: #2575fc;
        }
        .error {
            color: #FF0000;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .btn-primary {
            background-color: #2575fc;
            border-color: #2575fc;
        }
        .btn-primary:hover {
            background-color: #6a11cb;
            border-color: #6a11cb;
        }
        .btn-secondary:hover {
            background-color: #d9534f;
            border-color: #d43f3a;
        }
    </style>
</head>
<body>

<div class="form-container">
    <div class="form-header">
        <h2>User Registration Form</h2>
        <p>Please fill this form and submit to add user record to the database</p>
    </div>

    <!-- Form submission action -->
    <form id="registrationForm" action="process_form.php" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" value="<?php echo htmlspecialchars($name); ?>">
            <?php if (isset($errors['name'])): ?>
                <div class="error"><?php echo $errors['name']; ?></div>
            <?php endif; ?>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>">
            <?php if (isset($errors['email'])): ?>
                <div class="error"><?php echo $errors['email']; ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <div class="form-check">
                <input type="radio" id="male" name="gender" value="Male" class="form-check-input" <?php if ($gender == "Male") echo "checked"; ?>>
                <label for="male" class="form-check-label">Male</label>
            </div>
            <div class="form-check">
                <input type="radio" id="female" name="gender" value="Female" class="form-check-input" <?php if ($gender == "Female") echo "checked"; ?>>
                <label for="female" class="form-check-label">Female</label>
            </div>
            <?php if (isset($errors['gender'])): ?>
                <div class="error"><?php echo $errors['gender']; ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" id="terms" name="terms" class="form-check-input" <?php if ($terms) echo "checked"; ?>>
            <label for="terms" class="form-check-label">I agree to receive emails from us (optional)</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary flex-grow-1">Submit</button>
            <button type="button" class="btn btn-secondary flex-grow-1" onclick="clearForm()">Cancel</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function clearForm() {
        document.getElementById('registrationForm').reset();
        const radios = document.querySelectorAll('input[type="radio"]');
        radios.forEach(radio => radio.checked = false);
    }
</script>
</body>
</html>
