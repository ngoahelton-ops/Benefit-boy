<?php
session_start();

// If already logged in, redirect to home
if (isset($_SESSION['user_id'])) {
    header('Location: index.html');
    exit;
}

$host = "localhost";
$username = "root";
$password = "";
$database = "quize_app";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $role = trim($_POST['role'] ?? 'user');

    if (!empty($email) && !empty($pass)) {
        // Get user from database
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($user = $res->fetch_assoc()) {
            // Verify password
            if (password_verify($pass, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $role;
                header('Location: index.html');
                exit;
            } else {
                $error = 'Invalid email or password.';
            }
        } else {
            $error = 'Invalid email or password.';
        }
        $stmt->close();
    } else {
        $error = 'Please enter email and password.';
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Quize App</title>
    <link href="css/styles.css" type="text/css" rel="stylesheet">
    <style>
        .auth-page { display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .auth-card { background: white; padding: 40px; border-radius: 12px; box-shadow: 0 12px 36px rgba(0,0,0,0.12); width: 100%; max-width: 400px; }
        .auth-card h2 { text-align: center; color: #111827; margin-bottom: 24px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; margin-bottom: 6px; color: #374151; font-weight: 600; }
        .form-group input { width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box; }
        .form-group input:focus { outline: none; border-color: #0b74d1; }
        .error { color: #dc2626; background: #fee2e2; padding: 10px; border-radius: 8px; margin-bottom: 16px; }
        .success { color: #065f46; background: #ecfdf5; padding: 10px; border-radius: 8px; margin-bottom: 16px; }
        .submit-btn { width: 100%; padding: 10px; background: #0b74d1; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .submit-btn:hover { background: #095ea8; }
        .link-text { text-align: center; margin-top: 16px; }
        .link-text a { color: #0b74d1; text-decoration: none; }
        .link-text a:hover { text-decoration: underline; }
        
        body.dark-mode { background: #1a1a2e; }
        body.dark-mode .auth-card { background: #2a2a3e; box-shadow: 0 12px 36px rgba(0,0,0,0.5); }
        body.dark-mode .auth-card h2 { color: #e0e0e0; }
        body.dark-mode .form-group label { color: #a0a0a0; }
        body.dark-mode .form-group input { background-color: #3a3a4e; color: #e0e0e0; border: 1px solid #4a4a5e; }
        body.dark-mode .form-group input:focus { border-color: #3b82f6; }
        body.dark-mode .error { background: rgba(220, 38, 38, 0.15); color: #ff6b6b; }
        body.dark-mode .success { background: rgba(52, 211, 153, 0.15); color: #34d399; }
        body.dark-mode .submit-btn { background: #3b82f6; }
        body.dark-mode .submit-btn:hover { background: #2563eb; }
        body.dark-mode .link-text a { color: #3b82f6; }
    </style>
</head>
<body style="background: #f3f4f6;">
    <div class="auth-page">
        <div class="auth-card">
            <h2>Login to Quize App</h2>
            <?php if ($error): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="post" action="">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; box-sizing: border-box;">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            
            <div class="link-text">
                Don't have an account? <a href="signup.php">Sign up here</a>
            </div>
            <div class="link-text" style="margin-top: 10px;">
                <a href="index.html">Back to Home</a>
            </div>
        </div>
    </div>
    <script src="js/darkmode.js"></script>
</body>
</html>
