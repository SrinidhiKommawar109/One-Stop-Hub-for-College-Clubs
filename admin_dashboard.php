<?php
session_start();
if (!isset($_SESSION['userType']) || $_SESSION['userType'] !== 'admin') {
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="stylescopy.css">
    <style>
      body {
    
    background-color: #f0f0f0;
    margin: 0;
    font-family: Arial, sans-serif;
}
        .flashcards-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        padding: 20px;
        justify-content: center;
        background: linear-gradient(45deg,blueviolet,lightgreen);
        margin-left: 20px;
        margin-right: 20px;
        }

        .flashcard {
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #ffffff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.2s;
            
        }
        .flashcard h3 {
            margin-top: 0;
            font-size: 1.2em;
            color: #333;
        }
        .flashcard p {
            margin: 10px 0 0;
            font-size: 1.5em;
            color: #28a745;
        }
        .flashcard:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
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
                <?php else: ?>
                    <li><a href="latest_events.php"><b>LATEST EVENTS</b></a></li>
                <?php endif; ?>
                <li><a href="logout.php"><b>LOGOUT</b></a></li>
            <?php else: ?>
                <li><a href="login.php"><b>LOGIN</b></a></li>
            <?php endif; ?>
        </ul>
    </div>
    <i class="fa fa-bars" onclick="showMenu()"></i>
</nav>

        <h2 style="text-align: center;">Admin Dashboard</h2>
     
    <div class="flashcards-container">
        <div class="flashcard">
            <h3>Total Clubs</h3>
            <p id="total-clubs">Loading...</p>
        </div>
        <div class="flashcard">
            <h3>Total Events</h3>
            <p id="total-events">Loading...</p>
        </div>
        <div class="flashcard">
            <h3>Total forms</h3>
            <p id="total-form">Loading...</p>
        </div>
        <div class="flashcard">
            <h3>Total Admin</h3>
            <p id="total-admin">Loading...</p>
        </div>
        <div class="flashcard">
            <h3>Total NSS Applications</h3>
            <p id="total-nss">Loading...</p>
        </div>
        <div class="flashcard">
            <h3>Total LiveWire Applications</h3>
            <p id="total-livewire">Loading...</p>
        </div>
    </div>

    <script>
        // Integrated JavaScript
        fetch('fetch_stats.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('total-clubs').textContent = data.total_clubs;
                document.getElementById('total-events').textContent = data.total_events;
                document.getElementById('total-form').textContent = data.total_form;
                document.getElementById('total-admin').textContent = data.total_admin;
                document.getElementById('total-nss').textContent = data.total_nss;
                document.getElementById('total-livewire').textContent = data.total_livewire;
            })
            .catch(error => console.error('Error fetching stats:', error));
    </script>
</body>
</html>
