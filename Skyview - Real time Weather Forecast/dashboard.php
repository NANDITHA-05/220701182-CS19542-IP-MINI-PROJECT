<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Dashboard</title>
    <link rel="stylesheet" href="dashboardstyle.css">
</head>
        <nav class="navbar">
            <form id="search-form" class="search-bar">
                <input type="text" id="search-input" placeholder="Search location..." required />
                <button type="submit">Search</button>
            </form>
            <h2 id="location">Loading location...</h2>
            <div class="weather-display">
             <img id="weather-icon" src="" alt="Weather Icon" />
             <h3 id="weather-status">Loading weather...</h3>
            </div>
            <h1 id="temperature">--°C</h1>
            <div id="datetime"></div>
            <ul>
             <li><a href="#section1">24 hrs forecast</a></li>
             <li><a href="#section2">5 days forecast</a></li>
             <li><a href="#section3">Recommendations</a></li>
            </ul>
        </nav>
        <nav class="navbar1">
        <div class="navbar-title">
            <span class="hello">Hello <?php echo $_SESSION['username']?>!&nbsp;Welcome to Skyview:)</span>
        </div>
        <div class="navbar-links">
          
            <a href="dashboard.php" class="nav-link" onclick="setActiveLink(event)">Dashboard</a>
            <a href="alert.php" class="nav-link" onclick="setActiveLink(event)">Set Alert</a>
            <a href="logout.php" class="nav-link" onclick="setActiveLink(event)">Logout</a>
        </div>
    </nav>
        <section id="section1">
        <div class="hourly-weather">
         <h2 style="color: white;">24 Hours</h2><br>
         <div class="hourly-forecast"></div> <!-- This is where hourly data will be displayed -->
        </div>
        </section>
        <section id="section2">
        <div class="daily-weather">
         <h2 style="color: white;">5 days</h2><br>
         <div class="five-day-forecast"></div> <!-- This is where hourly data will be displayed -->
        </div>
        </section>
        <div id="recommendation-container" class="recommendation-container"></div>


       

       

     
    <script src="dashboardscript.js"></script>  
</body>

</html>
