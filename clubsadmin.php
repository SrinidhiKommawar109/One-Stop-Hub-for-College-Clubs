<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'admin') {
    header('Location: login.php');
    exit();
}

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

// Handle form submission to add a new club
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_club'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $image = $_POST['image'];
    $president = $_POST['president'];

    $sql = "INSERT INTO clubs (name, description, image, president) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $description, $image, $president);

    if ($stmt->execute()) {
        echo "New club added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Handle event registration form submission via AJAX
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['eventName'])) {
    $eventName = $_POST['eventName'];
    $eventDescription = $_POST['eventDescription'];
    $applicationForm = $_POST['applicationForm'];

    // Handle the file upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["eventImage"]["name"]);

    if (move_uploaded_file($_FILES["eventImage"]["tmp_name"], $targetFile)) {
        $sql = "INSERT INTO events (event_name, event_description, event_image, application_form) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $eventName, $eventDescription, $targetFile, $applicationForm);

        if ($stmt->execute()) {
            echo "New event registered successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error uploading image.";
    }

    exit(); // Ensure no additional output is sent
}

// Handle event deletion
// Handle event deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_event'])) {
    $eventId = $_POST['event_id'];

    // Fetch the event image path from the database
    $sql = "SELECT event_image FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();
    $stmt->bind_result($eventImage);
    $stmt->fetch();
    $stmt->close();

    // Delete the event image from the server
    if ($eventImage && file_exists($eventImage)) {
        unlink($eventImage);
    }

    // Delete the event record from the database
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);

    if ($stmt->execute()) {
        echo "<script>
                alert('Event removed successfully!');
                window.location.href = 'clubsadmin.php';
              </script>";
    } else {
        echo "<script>
                alert('Error: Could not remove event.');
                window.location.href = 'clubsadmin.php';
              </script>";
    }
    
    exit(); // Ensure no additional output is sent
}


// Fetch all events from the database
$sql = "SELECT id, event_name, event_description, event_image, application_form FROM events ORDER BY id DESC";
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
    <title>Admin - Manage Clubs and Events</title>
    <style>
        /* Add styles for both sections */
        body {
            background-color: #f0f0f0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f9f9f9;
        }
        h2 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .event-container {
            position: relative;
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
        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        .remove-btn:hover {
            background-color: #c82333;
        }
        /* Styles for the full-screen image */
        .full-screen-img {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .full-screen-img img {
            max-width: 90%;
            max-height: 90%;
            border: 2px solid #fff;
        }
        .full-screen-img.show {
            display: flex;
        }
        /* Add dropdown styling */
/* Dropdown styling */
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
                    <li class="dropdown">
                        <a href="#"><b>MANAGE CLUBS & EVENTS</b></a>
                        <ul class="dropdown-content">
                            <li><a href="admin_dashboard.php"><b>Reports</b></a></li><br>
                            <li><a href = "booking.php"><b>Bookings</b></a></li>
                        </ul>
                    </li>
                    <li><a href="logout.php"><b>LOGOUT</b></a></li>
                <?php else: ?>
                    <li><a href="clubs.php"><b>HEY STUDENTS</b></a></li>
                    <li><a href="logout.php"><b>LOGOUT</b></a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="login.php"><b>LOGIN</b></a></li>
            <?php endif; ?>
        </ul>
    </div>
    <i class="fa fa-bars" onclick="showMenu()"></i>
</nav>


    </section>

    <div class="container">
        <h2>Add New Club</h2>
        <form id="add-club-form" action="clubsadmin.php" method="POST">
            <input type="hidden" name="add_club" value="1">
            <label for="name">Club Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="image">Main Image Filename:</label>
            <input type="text" id="image" name="image" required>
            <label for="president">President:</label>
            <input type="text" id="president" name="president" required>
            <button type="submit" class="btn">Add Club</button>
        </form>
    </div>

    <div class="container">
        <h2>Event Registration</h2>
        <form id="eventForm" enctype="multipart/form-data">
            <label for="eventName">Event Name</label>
            <input type="text" id="eventName" name="eventName" required>
            <label for="eventDescription">Event Description</label>
            <textarea id="eventDescription" name="eventDescription" rows="4" required></textarea>
            <label for="eventImage">Event Image</label>
            <input type="file" id="eventImage" name="eventImage" accept="image/*" required>
            <label for="applicationForm">Application Form URL</label>
            <input type="url" id="applicationForm" name="applicationForm" required>
            
            <button type="button" class="btn" onclick="submitEventForm()">Submit</button>
        </form>
    </div>

    <div class="container">
        <h2>Current Events</h2>
        <div class="events-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="event-container">
                        <img src="<?php echo htmlspecialchars($row['event_image']); ?>" alt="Event Image" onclick="showFullScreenImage('<?php echo htmlspecialchars($row['event_image']); ?>')">
                        <h3><?php echo htmlspecialchars($row['event_name']); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($row['event_description'])); ?></p>
                        <p><a href="<?php echo htmlspecialchars($row['application_form']); ?>" target="_blank">Apply Now</a></p>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="remove_event" value="1">
                            <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit" class="remove-btn">Remove Event</button>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No events found</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Full screen image overlay -->
    <div class="full-screen-img" id="fullScreenImg">
        <img id="fullScreenImgElement" src="" alt="Full Screen Image">
    </div>

    <script>
        function submitEventForm() {
            const form = document.getElementById('eventForm');
            const formData = new FormData(form);

            fetch('clubsadmin.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                form.reset();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to store event.');
            });
        }

        function showFullScreenImage(src) {
            const fullScreenImg = document.getElementById('fullScreenImg');
            const fullScreenImgElement = document.getElementById('fullScreenImgElement');
            fullScreenImgElement.src = src;
            fullScreenImg.classList.add('show');
        }

        document.getElementById('fullScreenImg').addEventListener('click', function() {
            this.classList.remove('show');
        });
    </script>
</body>
</html>
