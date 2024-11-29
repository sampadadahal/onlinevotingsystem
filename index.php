<?php
session_start();
include('db.php');

// Redirect if user is not logged in or age not verified
if (!isset($_SESSION['user_id']) || $_SESSION['age'] < 18) {
    header("Location: login.php");
    exit();
}

// Fetch candidates from the database
$query = "SELECT * FROM candidates";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Vote for your Favorite Candidate</h1>
    <form method="POST" action="vote.php">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <div>
                <input type="radio" name="candidate" value="<?php echo $row['id']; ?>" required>
                <label><?php echo $row['name']; ?></label>
            </div>
        <?php } ?>
        <button type="submit">Submit Vote</button>
    </form>
</body>
</html>
