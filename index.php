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
    <section class="header">
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
            <i class="fa fa-bars" onclick="showMenu()"></i>
        </nav>
        <div class="text-box">
            <h1><b>Enter Our Community, Let Your Creativity Inspire</b></h1>
            <p><b>VNRVJIET is a World Class University in India that offers Value-based Education<br> Research and Training in Engineering and Management.
            </b></p>
            <a href="course.php" class="hero-btn"><b>Visit Us To Know More</b></a>
        </div>
    </section>
    <!----course---->
    <section class="course">
        <h1>Courses We Offer</h1>
        <p>Unlock your potential with our diverse range of courses tailored to elevate your skills and expand your horizons.
            From cutting-edge technology to timeless classics, embark on a transformative learning journey with us.</p>
        <div class="row">
            <div class="course-col">
                <h3>Batchelor Of Technology</h3>
                <p>
                    Fuel your passion for innovation with our comprehensive BTech program, blending theory with hands-on experience to shape tomorrow's technological leaders. 
                    Gain expertise in engineering principles and practical skills to engineer solutions for the challenges of today and tomorrow.
                </p>
            </div>
            <div class="course-col">
                <h3>Master Of Technology</h3>
                <p>
                    "Accelerate your career in technology with our M.Tech program, designed to deepen your expertise and enhance your professional prospects. 
                    Explore advanced concepts, engage in research, and develop innovative solutions under the guidance of industry experts."
                </p>
            </div>
            <div class="course-col">
                <h3>Master Of Business Administration</h3>
                <p>
                    An MBA is a postgraduate degree focusing on business management, offering training in finance, marketing, 
                    operations, and leadership to prepare graduates for managerial positions in various industries.
                </p>
            </div>
        </div>
    </section>
    <section class="campus">
        <h1>Our Campus</h1>
        <p>Where knowledge blossoms, connections thrive, and futures unfold</p>
        <div class="row">
            <div class="campus-col">
                <img src="2.png">
                <div class="layer">
                    <h3>Hyderabad</h3>
                </div>
            </div>
        </div>
    </section>

    <section class="facilities">
        <h1>Our Facilities</h1>
        <p>Elevating Experiences, Empowering Futures</p>
        <div class="row">
            <div class="facilities-col">
                <img src="lib.png">
                <h3>Library</h3>
                <p>Books Libraries: Portals to Knowledge, Exploration, and Enlightenment</p>
            </div>
            <div class="facilities-col">
                <img src="ground.png">
                <h3>Play-Ground</h3>
                <p>Unleash Your Potential: Where Victory Meets the Ground</p>
            </div>
            <div class="facilities-col">
                <img src="cafe.png">
                <h3>Tasty and Healthy Food</h3>
                <p>Savor Every Moment: Where Flavor and Friendship Flourish</p>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <h1>What Our Students Say</h1>
        <p>Voices of Trust: Stories that Speak of Excellence</p>
        <div class="row">
            <div class="testimonial-col">
                <img src="user1.png">
                <div>
                    <p>An enriching journey where every corner holds opportunities for growth. 
                    This college is more than just a campus; it's a second home where dreams take flight.</p>
                    <h3>David</h3>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star-half-alt"></i>
                </div>
            </div>
            <div class="testimonial-col">
                <img src="user2.png">
                <div>
                    <p>A vibrant tapestry of experiences awaits at this college,
                        where learning is not just a destination, but a transformative adventure.</p>
                    <h3>Christine</h3>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
            </div>
        </div>
    </section>

    <section class="cta">
        <h1>Enroll For Our Various Online Courses<br> Anywhere From The World</h1>
        <a href="contact.php" class="heros-btn">CONTACT US</a>
    </section>

    <section class="footer">
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
        function showMenu() {
            navLinks.style.right = "0";
        }
        function hideMenu() {
            navLinks.style.right = "-200px";
        }
    </script>
</body>
</html>
