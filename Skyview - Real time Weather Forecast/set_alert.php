<?php
session_start();
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $alert_condition = $_POST['alert_condition'];
    $threshold_value = $_POST['threshold_value'];
    $location = $_POST['location'];
    $email = $_POST['email']; // Get email from the form

    // Insert alert into the database
    $sql = "INSERT INTO user_alerts (user_id, alert_condition, threshold_value, location, email)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $alert_condition, $threshold_value, $location, $email);

    if ($stmt->execute()) {
        echo '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Alert Set Successfully</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: black;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .success-container {
                    text-align: center;
                    background: white;
                    padding: 40px;
                    border-radius: 10px;
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                    max-width: 500px;
                    width: 100%;
                    display: none; /* Initially hidden */
                }
                .success-container h1 {
                    color: #28a745;
                    margin-top: -130px;
                }
                .success-container p {
                    font-size: 18px;
                    color: #333;
                    margin-bottom: 20px;
                }
                .success-gif {
                    max-width: 50%;
                    height: 50%;
                    margin-bottom: 100px;
                    margin-left: 20px;
                    margin-top: -2rem;
                }
                .button-group {
                    display: flex;
                    justify-content: space-between;
                    gap: 10px;
                }
                .button-group a {
                    text-decoration: none;
                    color: white;
                    background-color: #28a745;
                    padding: 10px 20px;
                    border-radius: 5px;
                    transition: background-color 0.3s ease;
                }
                .button-group a:hover {
                    background-color: #218838;
                }
                .button-group a.back {
                    background-color: #007bff;
                }
                .button-group a.back:hover {
                    background-color: #0056b3;
                }
                .loading-container {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                }
                .loading-gif {
                    width: 300px;
                    height: 300px;
                }
            </style>
        </head>
        <body>

            <div class="loading-container">
                <img src="msg.gif" alt="Loading..." class="loading-gif">
            </div>

            <div class="success-container" id="success-message">
                <img src="msgsent.gif" alt="Success" class="success-gif"> <!-- Add a success GIF -->
                <h1>Success!</h1>
                <p>Your alert has been set successfully!</p>

                <div class="button-group">
                    <a href="dashboard.php" class="back">Back to Dashboard</a>
                    <a href="set_alert.php" class="set-another">Set Another Alert</a>
                </div><br>
                <a style="color:black;" href="fetch_alerts.php">Cancel alerts</a>
            </div>
            <script>
                // Wait for 2 seconds, then show the success message
                setTimeout(function() {
                    document.querySelector(".loading-container").style.display = "none"; // Hide the loading screen
                    document.querySelector(".success-container").style.display = "block"; // Show the success message
                }, 2000); // 2000 milliseconds = 2 seconds
            </script>

        </body>
        </html>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

