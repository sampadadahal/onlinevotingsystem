<?php
session_start();
include('db.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Query to get the total number of votes for each candidate
$query = "SELECT candidates.name, candidates.id, COUNT(votes.id) AS vote_count
          FROM candidates
          LEFT JOIN votes ON candidates.id = votes.candidate_id
          GROUP BY candidates.id";

$result = $conn->query($query);

if (!$result) {
    die("Error fetching results: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Voting Results</h1>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['vote_count']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No votes yet.</p>
    <?php endif; ?>

</body>
</html>
