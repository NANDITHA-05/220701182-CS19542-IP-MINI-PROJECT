<?php
session_start();
include 'db.php';
if (!isset($_SESSION['user_id'])) {
    // If user_id is not set, redirect them to login or show an error
    echo "User not logged in.";
    exit;
}

$user_id = $_SESSION['user_id']; // Assuming user is logged in
$sql = "SELECT * FROM user_alerts WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Alerts</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: linear-gradient(135deg, #abbbdd, #dddbe5);
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        .alert-item {
            background: #f0f8ff; /* Light blue background */
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative; /* To position the delete link */
            display: flex; /* Use flexbox for alignment */
            justify-content: space-between; /* Space between content */
            align-items: center; /* Center items vertically */
        }
        .alert-details {
            flex-grow: 1; /* Allow details to take remaining space */
            padding-right: 20px; /* Space between text and button */
        }
        .delete-alert {
            background-color: #dc3545; /* Bootstrap danger color */
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .delete-alert:hover {
            background-color: #c82333; /* Darker shade on hover */
        }
        .no-alerts {
            text-align: center;
            color: #888; /* Gray color */
            font-size: 18px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Cancel Alerts</h2>
    <div id="activityLog">
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="alert-item">
                    <div class="alert-details">
                        <strong>Condition:</strong> <?php echo htmlspecialchars($row['alert_condition']); ?><br>
                        <strong>Threshold Value:</strong> <?php echo htmlspecialchars($row['threshold_value']); ?><br> <!-- Added threshold value -->
                        <strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?>
                    </div>
                    <a href='delete_alert.php?id=<?php echo $row['id']; ?>' class='delete-alert'>Cancel Alert</a>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="no-alerts">No alerts set.</div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
