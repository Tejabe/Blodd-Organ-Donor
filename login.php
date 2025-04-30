<?php
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'tej';
$db_username = 'root';
$db_password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $db_username, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$login_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    
    if (empty($username) || empty($password)) {
        $login_error = 'Please enter both username and password';
    } else {
        try {
            // Modified query to ensure case-sensitive comparison if needed
            $stmt = $pdo->prepare("SELECT id, username, password FROM user WHERE BINARY username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->rowCount() === 1) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Enhanced password verification with error logging
                if (password_verify($password, $user['password'])) {
                    // Password is correct - set session variables
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['loggedin'] = true;
                    
                    // Regenerate session ID for security
                    session_regenerate_id(true);
                    
                    header('Location: home.php');
                    exit();
                } else {
                    // Log failed attempts (for debugging)
                    error_log("Failed login attempt for username: $username");
                    $login_error = 'Invalid username or password';
                }
            } else {
                $login_error = 'Invalid username or password';
            }
        } catch (PDOException $e) {
            error_log("Database error during login: " . $e->getMessage());
            $login_error = 'Login failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BLOOD&ORGAN-DONAR</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="shortcut icon" href="photos/LOGO.webp" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input:focus {
            border-color: #ed1b24;
            outline: none;
            box-shadow: 0 0 5px rgba(237, 27, 36, 0.3);
        }
        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #ed1b24;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .login-button:hover {
            background-color: #c4121a;
        }
        .error-message {
            color: #ed1b24;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #fde8e8;
            border-radius: 4px;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .register-link a {
            color: #ed1b24;
            text-decoration: none;
            font-weight: bold;
        }
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php if (file_exists('includes/nav.php')) include 'includes/nav.php'; ?>

    <div class="login-container">
        <h2>Login</h2>
        
        <?php if (!empty($login_error)): ?>
            <div class="error-message"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>
        
        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required 
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="login-button">Login</button>
        </form>
        
        <div class="register-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>

    <?php if (file_exists('includes/footer.php')) include 'includes/footer.php'; ?>
</body>
</html>