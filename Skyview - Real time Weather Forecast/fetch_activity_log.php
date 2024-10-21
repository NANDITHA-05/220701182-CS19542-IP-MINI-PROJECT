<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM alert_activity_log WHERE user_id = '$user_id' ORDER BY activity_time DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <title>User Alert Activity Log</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color:whitesmoke;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: lightblue;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
          
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .activity-item {
            background: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 10px;
            transition: background-color 0.3s;
        }
        .activity-item:hover {
            background-color: #e9e9e9;
        }
        .activity-item p {
            margin: 5px 0;
            color: #555;
        }
        .button-container {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            
        }
        .button {
            background-color: darkslategrey;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>User Alert Activity Log</h1>
    
    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='activity-item'>";
            echo "<p><strong>Activity:</strong> " . htmlspecialchars($row['activity']) . "</p>";
            echo "<p><strong>Time:</strong> " . htmlspecialchars($row['activity_time']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No activities found.</p>";
    }
    ?>

    <div class="button-container">
        <a href="dashboard.php" class="button">Dashboard</a>
        <a href="cancel_alert.php" class="button">Cancel Alert</a>
        <a href="set_alert.php" class="button">Set Alert</a>
    </div>
</div>

</body>
</html>

