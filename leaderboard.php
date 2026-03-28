<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$database = "quize_app";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get top 20 scores
$query = "SELECT u.username, qa.score, qa.total_questions, qa.percentage, qa.created_at 
          FROM quiz_attempts qa 
          JOIN users u ON qa.user_id = u.id 
          ORDER BY qa.percentage DESC, qa.created_at DESC 
          LIMIT 20";
$result = $conn->query($query);
$leaderboard = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Leaderboard - Quize App</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet">
    <style>
        .leaderboard-container { max-width: 900px; margin: 0 auto; }
        .leaderboard-table { width: 100%; border-collapse: collapse; }
        .leaderboard-table thead { background: #0b74d1; color: white; }
        .leaderboard-table th { padding: 14px; text-align: left; font-weight: 600; }
        .leaderboard-table td { padding: 12px 14px; border-bottom: 1px solid #e5e7eb; }
        .leaderboard-table tr:hover { background: #f9fafb; }
        .rank-badge { display: inline-block; width: 32px; height: 32px; background: #fbbf24; color: #111827; border-radius: 50%; text-align: center; line-height: 32px; font-weight: 700; }
        .rank-1 { background: #fbbf24; }
        .rank-2 { background: #d1d5db; }
        .rank-3 { background: #f59e0b; }
        .percentage { font-weight: 600; color: #10b981; }
        
        body.dark-mode .leaderboard-table thead { background: #3b82f6; }
        body.dark-mode .leaderboard-table td { border-bottom-color: #3a3a4e; }
        body.dark-mode .leaderboard-table tr:hover { background: #3a3a4e; }
        body.dark-mode .rank-1 { background: #fbbf24; color: #111; }
        body.dark-mode .rank-2 { background: #9ca3af; color: #111; }
        body.dark-mode .rank-3 { background: #f59e0b; color: #111; }
        body.dark-mode .percentage { color: #34d399; }
    </style>
</head>
<body>
    <div class="navbar"><h1>Quize App</h1>
        <button id="navToggle" class="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">☰</button>
        <div class="nav-links">
            <a href="index.html">Home</a>
            <a href="about.php">About</a>
            <a href="services.php">Services</a>
            <a href="contact.php">Contact</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
            <?php else: ?>
                <a href="login.php">Login</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="wrap" style="margin-top: 80px;">
        <div class="card leaderboard-container">
            <h2 style="text-align: center; margin-bottom: 24px;">🏆 Top Scorers</h2>
            
            <?php if (!empty($leaderboard)): ?>
                <table class="leaderboard-table">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>User</th>
                            <th>Score</th>
                            <th>Percentage</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leaderboard as $index => $entry): ?>
                            <tr>
                                <td>
                                    <span class="rank-badge rank-<?php echo min($index + 1, 3); ?>">
                                        <?php echo $index + 1; ?>
                                    </span>
                                </td>
                                <td><?php echo htmlspecialchars($entry['username']); ?></td>
                                <td><?php echo htmlspecialchars($entry['score']) . ' / ' . htmlspecialchars($entry['total_questions']); ?></td>
                                <td class="percentage"><?php echo htmlspecialchars($entry['percentage']); ?>%</td>
                                <td><?php echo date('M d, Y', strtotime($entry['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p style="text-align: center; color: #6b7280;">No quiz attempts yet. Be the first to take a quiz!</p>
            <?php endif; ?>
            
            <div style="text-align: center; margin-top: 24px;">
                <a class="button" href="check_answers.php">Take a Quiz</a>
                <a class="button" href="index.html">Back to Home</a>
            </div>
        </div>
    </div>
    <script src="js/darkmode.js"></script>
    <script src="js/nav.js"></script>
</body>
</html>
