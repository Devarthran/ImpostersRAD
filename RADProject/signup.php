<?php 
    include_once 'includes/header.inc.php';
?>

<section>
    <h2 class="signup-form-title">Sign Up</h2>
    <div class="signup-form">
        <form  action="includes/signup.inc.php" method="post">
            <div>
            <input type="text" name="fullName" placeholder="Full name...">
            </div>
            <div>
            <input type="email" name="email" placeholder="Email...">
            </div>
            
            <div>
            <label for="newsletter">Sign Up for Monthly Newsletter?</label>
            <input type="checkbox" name="newsletter" value='newsletter'>
            </div>

            <div>
            <label for="notifications">Sign Up for Notifications?</label>
            <input type="checkbox" name="notifications" value="notifications">
            </div>

            <div>
            <input type="submit" name="signupbtn" value="Sign Up">
            </div>

        </form>
    </div>
    <?php 
    // Shows errors if an error is set in the global $_GET['error']
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "emptyinput") {
            echo "<p>Please fill in both your full name and email.</p>";
        }

        if ($_GET['error'] == "invalidemail") {
            echo "<p>Please enter a valid email.</p>";
        }

        if ($_GET['error'] == "invalidselection") {
            echo "<p>Please select newsletter and / or notifications.</p>";
        }

        if ($_GET['error'] == "emailtaken") {
            echo "<p>That email is taken. Please enter another or contact admin.</p>";
        }
    }

    ?>
</section>
<section>
    <br><br><br>
    <h2 class="signup-form-title">Unsubscribe</h2>
    <div class="signup-form">
        <form  action="includes/sendUnsub.inc.php" method="POST">
            <div>
            <input type="email" name="unsubEmail" placeholder="Email...">
            </div>
            
            <div>
            <input type="submit" name="btnUnsub" value="Unsubscribe">
            </div>

        </form>
    </div>
</section>
<?php
if (isset($_GET['error'])) {
    if ($_GET['error'] == "unsubfailed") {
        echo "<p>Unsubscribing failed, please contact administration at support@AE.admin.com</p>";
    }
    if ($_GET['error'] == "usernullexists") {
        echo "<p>That email is not in our system.<br>If this is in error please contact administration at support@AE.admin.com</p>";
    }
}
if (isset($_GET['message'])) {
        if ($_GET['message'] == "unsubpass") {
            echo "<p>You have been unsubscribed.</p>";
        }
}
?>
<?php 
    include_once 'includes/footer.inc.php';
?>