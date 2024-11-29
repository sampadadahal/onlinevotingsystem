<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the user's details
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($query);
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $candidate_id = $_POST['candidate'];

    // Check if the candidate is valid
    if (empty($candidate_id)) {
        $error = "Please select a candidate.";
    } else {
        // Insert vote into database
        $insertQuery = "INSERT INTO votes (user_id, candidate_id) VALUES ($user_id, $candidate_id)";
        
        // Check if the query executed successfully
        if ($conn->query($insertQuery) === TRUE) {
            $success = "Your vote has been cast!";
        } else {
            // Log the specific error message for debugging
            $error = "Error casting your vote: " . $conn->error;
        }
    }
}

// Fetch candidates
$candidateQuery = "SELECT * FROM candidates";
$candidates = $conn->query($candidateQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js" defer></script>
</head>
<body>
    <h1>Cast Your Vote</h1>
    <form method="POST" action="vote.php">
        <h3>Select a Candidate:</h3>
        <?php while ($candidate = $candidates->fetch_assoc()): ?>
            <label>
                <input type="radio" name="candidate" value="<?php echo $candidate['id']; ?>" required>
                <?php echo $candidate['name']; ?>
            </label><br>
        <?php endwhile; ?>
        <button type="submit">Vote</button>

        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
    </form>
</body>
</html>
