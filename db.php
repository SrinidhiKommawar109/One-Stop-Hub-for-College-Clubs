
<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "clubs_db";
// The name of the database you want to connect to

// Create connection
$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
