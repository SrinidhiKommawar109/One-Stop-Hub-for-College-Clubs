<?php
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

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO nss (first_name, middle_name, last_name, gender, year_level, section, email, contact, address, reason) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssss", $first_name, $middle_name, $last_name, $gender, $year_level, $section, $email, $contact, $address, $reason);

// Set parameters and execute
$first_name = $_POST['first-name'];
$middle_name = $_POST['middle-name'];
$last_name = $_POST['last-name'];
$gender = $_POST['gender'];
$year_level = $_POST['year-level'];
$section = $_POST['section'];
$email = $_POST['email'];
$contact = $_POST['contact'];
$address = $_POST['address'];
$reason = $_POST['reason'];

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
