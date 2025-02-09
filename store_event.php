<?php
// Display errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventName = $_POST['eventName'];
    $eventDescription = $_POST['eventDescription'];
    $applicationForm = $_POST['applicationForm'];

    // Handle image upload
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    $targetFile = $targetDir . basename($_FILES["eventImage"]["name"]);
    if (move_uploaded_file($_FILES["eventImage"]["tmp_name"], $targetFile)) {
        // Database connection
        include 'db.php';

        $sql = "INSERT INTO events (event_name, event_description, event_image, application_form)
                VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $eventName, $eventDescription, $targetFile, $applicationForm);
            $stmt->execute();
            $stmt->close();
            echo "Event stored successfully!";
        } else {
            echo "Error: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Failed to upload image.";
    }
} else {
    echo "Invalid request.";
}
?>
