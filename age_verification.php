<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if age is verified
if ($_SESSION['age'] < 18) {
    echo "<p>You must be 18 or older to vote.</p>";
    exit();
}

header("Location: index.php"); // Redirect to voting page
?>
