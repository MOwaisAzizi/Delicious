<?php
session_start();

// DB connection
$host = 'localhost';
$db = 'user_auth';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = '';

if (isset($_POST['login-btn'])) {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $error = "Please fill in both fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, start session
                $_SESSION['isLogin'] = true;
                $_SESSION['user_role'] = $user['role'];

                // Redirect to a protected page or dashboard
                header("Location: main.php");
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        } else {
            $error = "Invalid email or password.";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<?php require_once "./component/head.php"; ?>

<div>
        <a href="main.php"><button class='btn btn-light text-dark d-flex justify-content-start ms-2'>← Back</button></a>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <form action="login.php" method="POST" class="p-4 rounded shadow-sm bg-white" style="max-width: 400px; width: 100%;">
        <h2 class="mb-4 text-center">Login</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" name="email" id="email" class="form-control" required autofocus />
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required />
        </div>

        <button type="submit" name = 'login-btn' class="btn btn-success w-100">Login</button>
        <div class="mt-3 text-center ">
            <a href="signup.php">Don't have an account? Sign up</a>
        </div>
    </form>
</div>
        </div>
