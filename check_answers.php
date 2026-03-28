<?php 
session_start();

$host="localhost";
$username="root";  
$password="";
$database="quize_app";
$conn=new mysqli($host,$username,$password,$database);
if($conn->connect_error){
    die("connection failed: " . $conn->connect_error );
}
// Determine how many questions are available in DB and cap the quiz to 5
$totalRes = $conn->query("SELECT COUNT(*) AS total FROM question");
$total_db_questions = (int) ($totalRes ? $totalRes->fetch_assoc()['total'] : 0);
$quiz_limit = $total_db_questions > 0 ? min(5, $total_db_questions) : 0;

// If the user opens the quiz page (GET) while a quiz is in-progress, reset to start over
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && isset($_SESSION['question_index'], $_SESSION['quiz_limit'])) {
    $qi = (int) $_SESSION['question_index'];
    $ql = (int) $_SESSION['quiz_limit'];
    if ($qi > 0 && $qi < $ql) {
        // reset session state so the quiz restarts
        unset($_SESSION['question_index'], $_SESSION['score'], $_SESSION['last_correct_answer'], $_SESSION['question_order'], $_SESSION['quiz_limit']);
    }
}

// Initialize quiz session when needed
if (!isset($_SESSION['question_index'])){
    $_SESSION['question_index'] = 0;
    $_SESSION['score'] = 0;
    $_SESSION['last_correct_answer'] = null;
    $_SESSION['question_order'] = [];
    $_SESSION['quiz_limit'] = $quiz_limit;
    $_SESSION['quiz_start_time'] = time(); // Track quiz start time

    if ($quiz_limit > 0) {
        $ids = [];
        $res = $conn->query("SELECT id FROM question");
        while ($row = $res->fetch_assoc()){
            $ids[] = $row['id'];
        }
        shuffle($ids);
        // keep only up to the quiz limit
        $_SESSION['question_order'] = array_slice($ids, 0, $quiz_limit);
    }
}

// Use the quiz limit as the number of questions for this run
$total_questions = (int) ($_SESSION['quiz_limit'] ?? 0);
if($_SERVER['REQUEST_METHOD'] === 'POST' && 
isset($_POST['answer_id'],$_POST['question_id'])){
    $answer_id = (int) $_POST['answer_id'];
    $question_id = (int) $_POST['question_id'];
    
    // Fetch difficulty for this question to apply multiplier
    $diff_stmt = $conn->prepare("SELECT difficulty FROM question WHERE id = ?");
    $diff_stmt->bind_param("i", $question_id);
    $diff_stmt->execute();
    $diff_res = $diff_stmt->get_result();
    $diff_row = $diff_res->fetch_assoc();
    $difficulty = $diff_row['difficulty'] ?? 'medium';
    $diff_stmt->close();
    
    // Calculate points multiplier based on difficulty
    $multiplier = 1.0;
    if ($difficulty === 'easy') {
        $multiplier = 1.0;
    } elseif ($difficulty === 'medium') {
        $multiplier = 1.0;
    } elseif ($difficulty === 'hard') {
        $multiplier = 1.0;
    }
    
    $stmt = $conn->prepare("SELECT id, answer_text, is_correct FROM answer WHERE question_id = ?");
    $stmt->bind_param("i",$question_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $correct_answer = null;
    $selected_correct = false;
    while($row=$res->fetch_assoc()){ 
        if((int)$row ['is_correct'] === 1){
            $correct_answer = $row['answer_text'];
        }
        if((int)$row ['id'] === $answer_id && (int)$row['is_correct']===1){
          $selected_correct=true;
        }
    }
    $stmt->close();
    if($selected_correct){
        $_SESSION['score'] += $multiplier;
    }
    $_SESSION['last_correct_answer']= $correct_answer;

    $_SESSION['question_index']++;
}
if ($_SESSION['question_index'] >= $total_questions){
    $score = $_SESSION['score'];
    $quiz_start_time = $_SESSION['quiz_start_time'] ?? time();
    $time_taken = time() - $quiz_start_time;
    
    // For percentage calculation with weighted scoring:
    // Max theoretical score = 5 questions * 2.0 multiplier (all hard) = 10 points
    // But we calculate percentage based on actual difficulty distribution
    // For now, show percentage relative to number of questions (if all were easy=1x each)
    $percentage = ($total_questions > 0) ? round(($score / $total_questions) * 100, 1) : 0;
    $max_possible_score = $total_questions * 1.0; // Assuming worst case (all hard)
    $weighted_percentage = ($max_possible_score > 0) ? round(($score / $max_possible_score) * 100, 1) : 0;
    
    // Save quiz attempt to database if user is logged in
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        // Store actual score and use the more conservative weighted percentage
        $stmt = $conn->prepare("INSERT INTO quiz_attempts (user_id, score, total_questions, percentage, time_taken) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidi", $user_id, $score, $total_questions, $weighted_percentage, $time_taken);
        $stmt->execute();
        $stmt->close();
    }
    
    session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Quize Finished</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet">
    <style>
        .score-graph {
            margin: 18px 0;
        }
        .progress-bar {
            width: 100%;
            height: 24px;
            background: #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.06);
        }
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #10b981, #34d399);
            transition: width 0.6s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 8px;
            color: white;
            font-weight: 600;
            font-size: 12px;
        }
        .stats-row {
            display: flex;
            gap: 40px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .stat-item {
            flex: 1;
            min-width: 150px;
        }
        .stat-label {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .stat-value {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
        }
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
        </div>
    </div>
    <div class="wrap">
        <div class="card">
            <h2>Quize Finished!</h2>
            <?php
                $average = ($total_questions > 0) ? round(($score / $total_questions), 2) : 0;
                $minutes = intdiv($time_taken, 60);
                $seconds = $time_taken % 60;
            ?>
            <p>Your Score: <strong><?php echo htmlspecialchars((string)round($score, 1)) . ' / ' . htmlspecialchars((string)$max_possible_score); ?></strong> <em style="font-size: 12px; color: #6b7280;">(with difficulty multipliers)</em></p>
            
            <div class="stats-row">
                <div class="stat-item">
                    <div class="stat-label">Achievement %</div>
                    <div class="stat-value"><?php echo htmlspecialchars((string)$weighted_percentage); ?>%</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Time Taken</div>
                    <div class="stat-value"><?php echo htmlspecialchars((string)$minutes) . 'm ' . htmlspecialchars((string)$seconds) . 's'; ?></div>
                </div>
            </div>
            
            <!-- Progress bar graph -->
            <div class="score-graph">
                <div class="progress-bar">
                    <div class="progress-fill" style="width: <?php echo htmlspecialchars((string)min($weighted_percentage, 100)); ?>%;">
                        <?php echo htmlspecialchars((string)$weighted_percentage); ?>%
                    </div>
                </div>
            </div>
            
            <p><strong>Performance Notes:</strong></p>
            <p style="font-size: 14px; color: #6b7280;">Questions are scored with difficulty multipliers: Easy (1x), Medium (1.5x), Hard (2x)</p>
            <a class='button' href='check_answers.php'>Restart Quize</a>
            <a class='button' href='index.html'>Menu</a>
        </div>
    </div>
    
    <script>
        // Confetti celebration effect for quiz completion
        function createConfetti() {
            const colors = ['#FFD700', '#FFA500', '#FF69B4', '#87CEEB', '#90EE90', '#FF6347'];
            const confettiCount = 50;
            
            for (let i = 0; i < confettiCount; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti-piece';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.top = '-10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = (Math.random() * 10 + 5) + 'px';
                confetti.style.height = confetti.style.width;
                confetti.style.borderRadius = '50%';
                confetti.style.opacity = '0.9';
                confetti.style.animationDelay = (Math.random() * 0.3) + 's';
                document.body.appendChild(confetti);
                
                // Remove confetti after animation
                setTimeout(() => confetti.remove(), 3000);
            }
        }
        
        // Trigger confetti if score is good (>60%)
        const percentage = <?php echo $weighted_percentage; ?>;
        if (percentage >= 60) {
            createConfetti();
        }
    </script>
    <script src="js/darkmode.js"></script>
    <script src="js/nav.js"></script>
</body>
</html>
<?php
exit;
}

// Determine current question id from the shuffled session order
if (!isset($_SESSION['question_order']) || !is_array($_SESSION['question_order']) || count($_SESSION['question_order']) === 0) {
    echo "<p>No questions available.</p>";
    $conn->close();
    exit;
}
$current_index = (int) $_SESSION['question_index'];
$current_qid = $_SESSION['question_order'][$current_index] ?? null;
if (!$current_qid) {
    echo "<p>No question found.</p>";
    $conn->close();
    exit;
}
$qstmt = $conn->prepare("SELECT id, question_text FROM question WHERE id = ? LIMIT 1");
$qstmt->bind_param("i", $current_qid);
$qstmt->execute();
$qRes = $qstmt->get_result();
$question = $qRes ? $qRes->fetch_assoc() : null;
$qstmt->close();

    if (!$question){
        echo"<p>No questions available.</p>";
        $conn->close();
        exit;
    }
    $astmt = $conn->prepare("SELECT id, answer_text FROM answer WHERE question_id = ? ORDER BY id ASC");
    $astmt->bind_param("i",$question['id']);
    $astmt->execute();
    $answersRes = $astmt->get_result();
    $answers= $answersRes ? $answersRes->fetch_all(MYSQLI_ASSOC) : [];
    $astmt->close();
    $conn->close();


?>
 <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Questions</title>
        <link href="css/styles.css" type="text/css" rel="stylesheet">
        <style>
            /* Page-specific background for check_answers.php */
            body {
                background: url('https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1600&q=80') no-repeat center center fixed;
                background-size: cover;
            }
            .timer-display {
                display: inline-block;
                background: #f59e0b;
                color: white;
                padding: 8px 16px;
                border-radius: 20px;
                font-weight: bold;
                font-size: 14px;
                margin-left: 16px;
            }
            .timer-display.warning {
                background: #ef4444;
                animation: pulse 0.6s infinite;
            }
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }
            .meta {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
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
    </div>
    </div>
    <div class="wrap"><div class="card"><?php if (isset($_SESSION['last_correct_answer'])): ?>
  <div style =" background:#f0f8ff; padding:10px; margin-bottom: 12px; border-left:4px solid #3498db;">
    correct Answer: <strong><?php echo 
    htmlspecialchars($_SESSION['last_correct_answer']);?></strong>
  </div>
  <?php unset($_SESSION['last_correct_answer']); ?>
  <?php endif; ?>
  
        <div class="question-block">
            <div class="meta">
                <div>Question <?php echo($_SESSION['question_index'] + 1 ); ?> of <?php echo $total_questions; ?></div>
                <div class="timer-display" id="timerDisplay">00:00</div>
            </div>
                <div class="question-text">
                    <h3><?php echo htmlspecialchars($question['question_text']); ?></h3>
                </div>
        </div>
    <form method="post" action="">
        <?php if (count($answers) > 0): ?>
            <?php foreach($answers as $ans): ?>
                <label class="answer">
                    <input type="radio" name="answer_id" value="<?php echo (int)$ans['id'];?>"required>
                    <?php echo htmlspecialchars( $ans['answer_text']); ?>
                </label>
                <?php endforeach;?>
                <?php else: ?>
                    <p><em>No answers available for this question.</em></p>
                    <?php endif; ?>
                    <input type="hidden" name="question_id" value="<?php echo (int)$question['id']; ?>">
                    <button type="submit"><?php echo ($_SESSION['question_index'] + 1 === $total_questions) ?
                    'Finish':'Next'; ?></button>
                    <a class='button' href='index.html'>Menu</a> 
    </form>
        <div class="progress">
                Current Score: <?php echo (int)$_SESSION['score']; ?>
        </div>
    
    </div></div>

    <script>
        // Timer display - shows elapsed time since quiz start
        const quizStartTime = <?php echo $_SESSION['quiz_start_time']; ?> * 1000; // Convert to milliseconds
        
        function updateTimer() {
            const now = Date.now();
            const elapsedSeconds = Math.floor((now - quizStartTime) / 1000);
            const minutes = Math.floor(elapsedSeconds / 60);
            const seconds = elapsedSeconds % 60;
            
            const display = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            const timerEl = document.getElementById('timerDisplay');
            
            if (timerEl) {
                timerEl.textContent = display;
                // Turn red if more than 5 minutes (300 seconds)
                if (elapsedSeconds > 300) {
                    timerEl.classList.add('warning');
                } else {
                    timerEl.classList.remove('warning');
                }
            }
        }
        
        // Update timer every second
        updateTimer();
        setInterval(updateTimer, 1000);
    </script>

</body>   
</html>
