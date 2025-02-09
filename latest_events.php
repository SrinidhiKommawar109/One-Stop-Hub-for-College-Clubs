<?php
// Start the session
session_start();

// Database connection details
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "clubs_db";

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all events from the database
$sql = "SELECT event_name, event_description, event_image, application_form FROM events ORDER BY id DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylescopy.css">
    <title>Latest Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background: linear-gradient(45deg,blueviolet,lightgreen);
        }

        .event-container {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .event-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 15px;
            border-radius: 4px;
            cursor: pointer;
        }

        .event-container h3 {
            margin-top: 0;
            font-size: 1.5em;
            color: #333;
        }

        .event-container p {
            margin-bottom: 10px;
            color: #666;
            line-height: 1.6;
        }

        .event-container a {
            color: #007bff;
            text-decoration: none;
        }

        .event-container a:hover {
            text-decoration: underline;
        }

        .event-container:hover {
            transform: scale(1.03);
        }

        /* Lightbox styles */
        .lightbox {
            display: none;
            position: fixed;
            z-index: 999;
            padding-top: 60px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .lightbox-content {
            position: relative;
            margin: auto;
            max-width: 90%;
            max-height: 80%;
        }

        .lightbox-content img {
            width: 100%;
            height: auto;
        }

        .close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
        }
        .dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown-content li {
    padding: 8px 16px;
}

.dropdown-content li a {
    color: #333;
    text-decoration: none;
}

.dropdown-content li a:hover {
    background-color: #ddd;
}
    </style>
</head>
<body>
<section class="sub-header">
        <nav>
            <a href="index.html"><img src="logo.png"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="index.php"><b>HOME</b></a></li>
                    <li><a href="course.php"><b>COURSE</b></a></li>
                    <li><a href="Blog.php"><b>BLOG</b></a></li>
                    <li><a href="clubs.php"><b>CLUBS</b></a></li>
                    <li><a href="contact.php"><b>CONTACT US</b></a></li>
                    
                    <?php if (isset($_SESSION['userType'])): ?>
                        <?php if ($_SESSION['userType'] === 'admin'): ?>
                            <li><a href="clubsadmin.php"><b>MANAGE CLUBS & EVENTS</b></a></li>
                            <li><a href="logout.php"><b>LOGOUT</b></a></li>
                        <?php else: ?>
                            <li class="dropdown"><a href="#"><b>LATEST EVENTS</b></a>
                            <ul class = "dropdown-content">
                                <li><a href="my_events.php"><b>My Events<b></a></li>
                           </ul>
                            </li>
                            <li><a href="logout.php"><b>LOGOUT</b></a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="login.php"><b>LOGIN</b></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <i class="fa fa-bars" onClick="showMenu()"></i>
        </nav>
    </section>
    <div class="events-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="event-container">
                    <img src="<?php echo htmlspecialchars($row['event_image']); ?>" alt="Event Image" onclick="openLightbox('<?php echo htmlspecialchars($row['event_image']); ?>')">
                    <h3><?php echo htmlspecialchars($row['event_name']); ?></h3>
                    <p><?php echo nl2br(htmlspecialchars($row['event_description'])); ?></p>
                    <p><a href="<?php echo htmlspecialchars($row['application_form']); ?>" target="_blank">Apply Now</a></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <h1>No Events Found</h1>
        <?php endif; ?>
    </div>

    <!-- Lightbox container -->
    <div id="lightbox" class="lightbox">
        <span class="close">&times;</span>
        <div class="lightbox-content">
            <img id="lightbox-img" src="" alt="Event Image">
        </div>
    </div>

    <script>
        // Get the modal
        var lightbox = document.getElementById('lightbox');
        var lightboxImg = document.getElementById('lightbox-img');
        var close = document.getElementsByClassName('close')[0];

        // Function to open the lightbox and display the clicked image
        function openLightbox(src) {
            lightbox.style.display = 'block';
            lightboxImg.src = src;
        }

        // Function to close the lightbox
        close.onclick = function() {
            lightbox.style.display = 'none';
        }

        // Close the lightbox when clicking outside the image
        lightbox.onclick = function(event) {
            if (event.target === lightbox) {
                lightbox.style.display = 'none';
            }
        }
    </script>

</body>
</html>
