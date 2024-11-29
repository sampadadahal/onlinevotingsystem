<?php
error_reporting(E_ALL); // Enable error reporting
ini_set('display_errors', 1); // Display errors
session_start();
include('db.php');

// Handle registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Use bcrypt hashing for password
    $age = $_POST['age'];

    // Check if username already exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $error = "Username already exists. Please choose a different one.";
    } else {
        // Insert new user into the database
        $insertQuery = "INSERT INTO users (username, password, age) VALUES ('$username', '$password', $age)";
        if ($conn->query($insertQuery) === TRUE) {
            $success = "Registration successful! You can now log in.";
        } else {
            $error = "Error registering user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <h1>Create an Account</h1>
    <form id="registerForm" method="POST" action="register.php">
        <input type="text" id="username" name="username" placeholder="Username" required><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <input type="number" id="age" name="age" placeholder="Age" required><br>
        <button type="submit" id="registerSubmit">Register</button>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
