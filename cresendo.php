<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cresendo - Club Page</title>
    <link rel="stylesheet" href="clubs.css">
</head>
<body>
    <section>
        <div class="container">
            <h2><b>Cresendo</b></h2>
            <p>kjhasidwqjk</p>
            <div class="scroll-container">
                <img src="Cresendo.png" alt="Cresendo" width="400" height="300">
            </div>
        </div>
    </section>

    <section>
        <div class="container2">
            <p><b>Interested in joining Cresendo?</b></p>
            <p>President: dr.c.d.naidu</p>
            <button class="open-form-button" onclick="openForm()">Apply Now</button>
        </div>
    </section>

    <section class="form-section" id="application-form" style="display: none;">
        <form action="cresendo_application.php" method="post">
            <div class="form-row">
                <div class="form-group">
                    <label for="first-name">First Name *</label>
                    <input type="text" id="first-name" name="first-name" required>
                </div>
                <div class="form-group">
                    <label for="last-name">Last Name *</label>
                    <input type="text" id="last-name" name="last-name" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-group">
                <label for="reason">Why do you want to join Cresendo? *</label>
                <textarea id="reason" name="reason" rows="4" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="submit-btn">SUBMIT APPLICATION</button>
                <button type="reset" class="cancel-btn">CANCEL</button>
                <button class="exit-btn" onclick="goClubs()">BACK</button>
            </div>
        </form>
    </section>

    <script>
        function openForm() {
            document.getElementById('application-form').style.display = 'block';
        }

        function goClubs(){
            window.location.href = "clubs.php";
        }
    </script>
</body>
</html>