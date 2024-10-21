<?php
include 'db.php'; // Include database connection
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password (make sure password is hashed in your database)
        if (password_verify($password, $row['password'])) {
            // Store user ID and username in session
            $_SESSION['user_id'] = $row['id'];      // Store user ID in session
            $_SESSION['username'] = $username;      // Store username in session

            // Redirect to dashboard or desired page
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Skyview-Login</title>
  <link rel="stylesheet" href="loginstyle.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body id="background">
  <div class="wrapper">
    <form action="login.php" method="POST">
      <h1>Login</h1>
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <div class="remember-forgot">
        <label><input type="checkbox">Remember Me</label>
        <a href="#">Forgot Password</a>
      </div>
      <button type="submit" class="btn">Login</button>
      <div class="register-link">
        <p>Dont have an account?  <a href="signup.php">Sign Up</a></p>
      </div>
    </form>
  </div>
</body>
</html>
