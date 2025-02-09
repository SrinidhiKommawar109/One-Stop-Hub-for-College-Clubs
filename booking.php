<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "clubs_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clubName = $_POST['clubName'];
    $bookingDate = $_POST['bookingDate'];
    $bookingTime = $_POST['bookingTime'];
    $facultyName = $_POST['facultyName'];
    $venue = $_POST['venue']; 

    // File upload
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["approvalLetter"]["name"]);
    move_uploaded_file($_FILES["approvalLetter"]["tmp_name"], $targetFile);

    // Insert data into the database
    $sql = "INSERT INTO bookings (club_name, booking_date, booking_time, faculty_name, venue, approval_letter) 
            VALUES ('$clubName', '$bookingDate', '$bookingTime', '$facultyName', '$venue', '$targetFile')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Booking submitted successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . addslashes($conn->error) . "');</script>";
    }
    }

// Retrieve all bookings
$sql = "SELECT * FROM bookings ORDER BY booking_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venue Booking Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-position: center, bottom;
            background-size: cover, contain;
            background-repeat: no-repeat, no-repeat;
            background-attachment: fixed, fixed;
            transition: background-image 1s ease-in-out; /* Smooth transition for changing background */
        }

        .container {
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent white to keep the form readable */
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h2, h3 {
            text-align: center;
            color: #333;
        }
        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 20px auto;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            color: #333;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], input[type="time"], select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="file"] {
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        td a {
            color: #4CAF50;
            text-decoration: none;
        }
        td a:hover {
            text-decoration: underline;
        }
       

    </style>
</head>
<body>
<div class="container">
    <h2>Venue Booking Form</h2>
    <form id="bookingForm" action="booking.php" method="POST" enctype="multipart/form-data">
        <label for="clubName">Club Name:</label>
        <input type="text" id="clubName" name="clubName" required>

        <label for="bookingDate">Booking Date:</label>
        <input type="date" id="bookingDate" name="bookingDate" required>

        <label for="bookingTime">Booking Time:</label>
        <input type="time" id="bookingTime" name="bookingTime" required>

        <label for="facultyName">Under the Guidance of Faculty:</label>
        <input type="text" id="facultyName" name="facultyName" required>

        <label for="venue">Select Venue:</label>
        <select id="venue" name="venue" required>
            <option value="" disabled selected>Select a venue</option>
            <option value="A">B-block Seminar Hall A</option>
            <option value="B">KS Auditorium</option>
            <option value="C">APJ Abdul Kalam Auditorium</option>
            <option value="E">PEB Block</option>
            <option value="F">JSK Greens</option>
            <option value="G">C-block</option>
            <option value="H">PG-Seminar Hall</option>
        </select>

        <label for="approvalLetter">Upload Approval Letter:</label>
        <input type="file" id="approvalLetter" name="approvalLetter" accept="image/*" required>

        <input type="submit" value="Submit Booking">
    </form>

    <h3>All Venue Bookings</h3>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Club Name</th>
                <th>Booking Date</th>
                <th>Booking Time</th>
                <th>Faculty</th>
                <th>Venue</th>
                <th>Approval Letter</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['club_name']; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['booking_time']; ?></td>
                <td><?php echo $row['faculty_name']; ?></td>
                <td><?php echo $row['venue']; ?></td>
                <td><a href="<?php echo $row['approval_letter']; ?>" target="_blank">View Letter</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
    <p style="text-align: center;">No bookings found.</p>
<?php endif; ?>
</div>
<div style="text-align: center; margin-top: 20px;">
    <button onclick="goBack()" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
        &#8592; Go Back
    </button>
</div>

<script>
    function goBack() {
        window.history.back();
    }
    const images = ['audi1.png', 'audi2.png', 'audi3.png', 'audi4.png']; // Add more image paths as needed
        let currentIndex = 0;

        function changeBackgroundImage() {
            document.body.style.backgroundImage = `url(${images[currentIndex]})`;
            currentIndex = (currentIndex + 1) % images.length; // Cycle through the images
        }

        setInterval(changeBackgroundImage, 2000); // Change every 1 second
        changeBackgroundImage();
</script>

</body>
</html>

<?php $conn->close(); ?>
