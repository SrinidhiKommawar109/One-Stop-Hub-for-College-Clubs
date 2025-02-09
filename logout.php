<?php
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the home page with a logout message in the URL
header("Location: index.php?logout=success");
exit();
?>
