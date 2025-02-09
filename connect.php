<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$userType = filter_input(INPUT_POST, 'userType', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if (!empty($username) && !empty($password) && !empty($userType)) {
    // Database connection details
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "clubs_db";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
    } else {
        if ($userType === 'admin') {
            // Admin authentication code
            $defaultUsername = 'admin';
            $defaultPassword = 'admin123';

            // Check if the admin table is empty
            $result = $conn->query("SELECT COUNT(*) as count FROM admin");
            $row = $result->fetch_assoc();
            if ($row['count'] == 0) {
                // Insert default admin credentials if table is empty
                $stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES (?, ?)");
                if ($stmt) {
                    $stmt->bind_param("ss", $defaultUsername, $defaultPassword);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    die("Error preparing statement: " . $conn->error);
                }
            }

            // Verify admin credentials
            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
            if ($stmt) {
                $stmt->bind_param("ss", $username, $password);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $_SESSION['username'] = $username;
                    $_SESSION['userType'] = $userType;
                    header("Location: index.php");
                    exit();
                } else {
                    header("Location: login.php?error=invalid_credentials");
                    exit();
                }

                $stmt->close();
            } else {
                die("Error preparing statement: " . $conn->error);
            }
        } elseif ($userType === 'student') {
            // Verify student credentials
            $stmt = $conn->prepare("SELECT password FROM form WHERE username = ?");
            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    // Username exists, now verify password
                    $stmt->bind_result($storedPassword);
                    $stmt->fetch();

                    if (password_verify($password, $storedPassword)) {
                        // Password is correct
                        $_SESSION['username'] = $username;
                        $_SESSION['userType'] = $userType;
                        header("Location: index.php");
                        exit();
                    } else {
                        // Password is incorrect
                        header("Location: login.php?error=invalid_credentials");
                        exit();
                    }
                } else {
                    // Username doesn't exist, insert a new student
                    $stmt->close();
                    $stmt = $conn->prepare("INSERT INTO form (username, password) VALUES (?, ?)");
                    if ($stmt) {
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security
                        $stmt->bind_param("ss", $username, $hashedPassword);
                        $stmt->execute();
                        $stmt->close();

                        // After successful insertion, log the student in
                        $_SESSION['username'] = $username;
                        $_SESSION['userType'] = $userType;
                        header("Location: index.php");
                        exit();
                    } else {
                        header("Location: login.php?error=insert_error");
                        exit();
                    }
                }

                $stmt->close();
            } else {
                die("Error preparing statement: " . $conn->error);
            }
        }

        // Close the connection
        $conn->close();
    }
} else {
    if (empty($username)) {
        header("Location: login.php?error=empty_username");
        exit();
    }
    if (empty($password)) {
        header("Location: login.php?error=empty_password");
        exit();
    }
    if (empty($userType)) {
        header("Location: login.php?error=empty_usertype");
        exit();
    }
    die();
}
?>
