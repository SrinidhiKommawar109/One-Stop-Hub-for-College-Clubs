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
        <h1>Our Certificate & Online Programs</h1>
    </section>

    <!----Blog page content---->
    <section class = "blog-content">
        <div class = "row">
            <div class="blog-left">
                <img src = "certificate.png">
                <h2>Our Certificate & Online Programs</h2>
                 <p>At VNR VJIET, we're passionate about learning and growth. Our diverse programs and certificates are designed to ignite your curiosity 
                    and empower you to excel in your chosen field. From engaging workshops to insightful seminars and interactive webinars, there's something
                    for everyone to explore and master.</p><br>
                <p>Elevate your skills and showcase your achievements with our certificates, meticulously crafted to reflect your dedication
                and hard work. Join the ranks of proud participants who have leveraged our programs to stand out in their careers and studies.</p><br>
                <p>Ready to embark on a transformative learning journey? Sign up for our programs today and discover endless possibilities
                for personal and professional development. We're here to support you every step of the way. Unlock your potential with VNR VJIET.</p>
                    
            <div class = "comment-box">
                <h3>Leave a comment</h3>
                <form class = "comment-form">
                    <input type = "text" placeholder = "Enter Name">
                    <input type = "email" placeholder = "Enter Email">
                    <textarea rows = "5" placeholder = "Your comment"></textarea>
                    <button type = "submit" class = "hero-btn">POST COMMENT</button>
                </form>
            </div>


            </div>
            <div class="blog-right">
                <h3>Post Categories</h3>
                <div>
                    <span>Computer-Science</span>
                    <span>21</span>
                </div>
                <div>
                    <span>Artificial Intelligence</span>
                    <span>28</span>
                </div>
                <div>
                    <span>Machine Learning</span>
                    <span>25</span>
                </div>
                <div>
                    <span>Data-Science</span>
                    <span>21</span>
                </div>
                <div>
                    <span>Buisness Analytics</span>
                    <span>30</span>
                </div>
                <div>
                    <span>Internet Of Things</span>
                    <span>27</span>
                </div>
                </div>
            </div>
        </div>
    </section>
    






    <!------Footer------>
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
