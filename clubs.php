<?php
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

// Fetch existing clubs
$clubs = [];
$sql = "SELECT name, description, image FROM clubs";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $clubs[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylescopy.css">
    <title>Clubs</title>
</head>
<body>
    <section class="sub-header">
        <nav>
            <a href="index.html"><img src="logo.png" alt="Logo"></a>
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
                            <li><a href="latest_events.php"><b>LATEST EVENTS</b></a></li>
                            <li><a href="logout.php"><b>LOGOUT</b></a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="login.php"><b>LOGIN</b></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
        <div class="container">
            <h1 class="heading">Clubs</h1>
            <div class="box-container">
                <?php foreach ($clubs as $club): ?>
                    <div class="box">
                        <img src="<?= htmlspecialchars($club['image']) ?>" alt="<?= htmlspecialchars($club['name']) ?>">
                        <h3><?= htmlspecialchars($club['name']) ?></h3>
                        <p><?= htmlspecialchars($club['description']) ?></p>
                        <button class="btn" onclick="redirectToClubPage('<?= htmlspecialchars($club['name']) ?>')">Read More</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <script>
        function hideMenu() {
            document.getElementById('navLinks').style.right = "-200px";
        }

        function showMenu() {
            document.getElementById('navLinks').style.right = "0";
        }

        function redirectToClubPage(clubName) {
            const clubPages = {
                'NSS': 'nss.html',
                'VjTheatro': 'vjtheatro.html',
                'Art Of Living': 'AOL.html',
                'Liveware': 'Liveware.html',
                'Cresendo': 'Cresendo.html',
                'Sintillate': 'Sinti.html',
                'Student-Force': 'SF.html',
                'Nityataranga': 'Nitya.html'
            };

            if (clubPages[clubName]) {
                window.location.href = clubPages[clubName];
            } else {
                alert('Page for ' + clubName + ' not found.');
            }
        }
    </script>
</body>
</html>
