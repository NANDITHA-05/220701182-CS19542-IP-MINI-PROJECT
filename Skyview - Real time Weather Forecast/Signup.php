<?php
include 'db.php'; // Include database connection
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Prepare an SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Sign up successful! You can now <a href='login.php'>log in</a>.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close(); // Close the statement
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skyview - Sign Up</title>
    <link rel="stylesheet" href="signupstyle.css"> <!-- Link to the existing CSS file -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body id="background">
  <div class="wrapper">
    <form action="" method="POST">
      <h1>Sign Up</h1>
      <div class="input-box">
        <input type="text" name="username" placeholder="Username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="password" name="password" placeholder="Password" required>
        <i class='bx bxs-lock-alt' ></i>
      </div>
      <button type="submit" class="btn">Sign Up</button>
      <div class="register-link">
        <p>Already have an account? <a href="login.php">Login</a></p>
      </div>
    </form>
  </div>

  <script>
    const gifs = [
      'snow.gif',
      'rain.gif',
      'sunny.gif',
      'autumn.gif'
    ];

    let currentGifIndex = 0;

    function changeBackground() {
        document.getElementById('background').style.backgroundImage = `url(${gifs[currentGifIndex]})`;
        currentGifIndex = (currentGifIndex + 1) % gifs.length; // Loop through the GIFs
    }

    // Change background every 3 seconds (3000 milliseconds)
    setInterval(changeBackground, 2000);

    // Initial call to set the first background GIF immediately
    changeBackground();
  </script>
</body>
</html>
