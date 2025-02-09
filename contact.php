<?php
session_start();
if (isset($_GET['logout']) && $_GET['logout'] == 'success') {
    echo "<script>alert('Logout Successful');</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VNR Vignana Jyothi Institute Of Engineering and Technology</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- FontAwesome via CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <section class=" sub-header">
        <nav>
            <a href="index.html"><img src="logo.png"></a>
            <div class="nav-links" id="navLinks">
                <!-- You can use the "fas" prefix for solid icons -->
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="index.php"><b>HOME</b></a></li>
                    <li><a href="course.php"><b>COURSE</b></a></li>
                    <li><a href="Blog.php"><b>BLOG</b></a></li>
                    <li><a href="clubs.php"><b>CLUBS</b></a></li>
                    <li><a href="contact.php"><b>CONTACT US</b></a></li>
                    <li>
                <?php if (isset($_SESSION['username'])): ?>
                    <!-- If user is logged in, replace login with admin or student -->
                    <?php if ($_SESSION['userType'] === 'admin'): ?>
                        <a href="index.php"><b>ADMIN</b></a>
                    <?php else: ?>
                        <a href="index.php"><b>STUDENT</b></a>
                    <?php endif; ?>
                    <!-- Add logout option after admin or student link -->
                    <a href="logout.php"><b>LOGOUT</b></a>
                <?php else: ?>
                    <!-- If user is not logged in, display login link -->
                    <a href="login.php"><b>LOGIN</b></a>
                <?php endif; ?>
            </li>
                    
                </ul>
            </div>
            <i class="fa fa-bars" onClick="showMenu()"></i> 
        </nav>
        <h1>Contact Us</h1>
    </section>

<!------------contact us ------>

<section class = "location">
    <iframe src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3804.3423037890925!2d78.38371817501377!3d17.53888208337436!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bcb8e0ab28e0975%3A0x7b048b2858fdee94!2sVallurupalli%20Nageswara%20Rao%20Vignana%20Jyothi%20Institute%20of%20Engineering%20%26Technology!5e0!3m2!1sen!2sin!4v1715753013410!5m2!1sen!2sin" 
    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>"
</section>
<section class = "contact-us">
    <div class = "row">
        <div class="contact-col">
            <div >
                <i class = "fa fa-home"></i>
                <span>
                    <h5>Hanuman Marg, Nizampet</h5>
                    <p>Hyderabad,Telangana</p>
                </span>
            </div>
            <div >
                <i class = "fa fa-phone"></i>
                <span>
                    <h5>+1 0123456789</h5 >
                    <p>Monday to Saturday 10Am to 6Pm</p>
                </span>
            </div>
            <div >
                <i class = "fa fa-envelope"></i>
                <span>
                    <h5>srinidhikommawar109@gmail.com</h5 >
                    <p>Email us for any query</p>
                </span>
            </div>
        </div>
        <div class="contact-col">
            <form action = "form-handler.php" method="post">
                <input type = "text" name = "name" placeholder = "Enter your name" required>
                <input type = "email" name = "email" placeholder = "Enter your email address" required>
                <input type = "text" name = "subject" placeholder = "Enter your subject" required>
                <textarea rows = "8" name = "message" placeholder = "Message" required></textarea>
                <button type = "submit" class = "hero-btn red-btn">Send Message</button>
            </form>
        </div>
    </div>

</section>



 <section class = "footer">
    <h4>About Us</h4>
    <p>Discover VNR's legacy of excellence, where innovation meets tradition. 
    With a commitment to <br>fostering brilliance and shaping futures, we empower minds to thrive in a dynamic world of knowledge and opportunity</p>
    <div class="icons">
        <i class="fab fa-facebook"></i>
        <i class="fab fa-twitter"></i>
        <i class="fab fa-instagram"></i>
        <i class="fab fa-linkedin"></i>
    </div>
 </section>



    <script>
        var navLinks = document.getElementById("navLinks");
        function showMenu(){
            navLinks.style.right = "0";
        }
        function hideMenu(){
            navLinks.style.right = "-200px";
        }
    </script>
</body>
</html>
