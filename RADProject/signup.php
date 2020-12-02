<?php
include_once 'includes/header.inc.php';
?>

<h1>Newsletter & Notifications</h1>

<!-- Signup Modal -->
<input class="form-news-inputs" type="button" id='btnShowSignup' value="Sign-Up"></input>
<section id="modalSignup" class="modal">
    <div class="modal-content">
        <button id="closeSignup" class="close" aria-label="Close">&times;</button>
        <form id="formSignup" onsubmit="return validateSignup(this)">
            <h2>Sign-Up Form</h2>
            <p>Please enter your details.</p>
            <div><input class="form-news-inputs" type="text" name="fullName" placeholder="Full name..." required aria-label="Enter your full name here."></div>
            <div><input class="form-news-inputs" type="email" name="email" placeholder="Email..." required aria-label="Enter email address here."></div>
            <div>
                <label id="lblNews" for="newsletter">Sign Up for Monthly Newsletter?</label>
                <input type="checkbox" id="newsletter" name="newsletter" value='0' onchange="if(this.checked) this.value='1'; else this.value='0';" aria-labelledby="lblNews">
            </div>
            <div>
                <label id="lblNotifs" for="notifications">Sign Up for Notifications?</label>
                <input type="checkbox" id="notifications" name="notifications" value='0' onchange="if(this.checked) this.value='1'; else this.value='0';" aria-labelledby="lblNotifs">
            </div>
            <div><input class="form-news-inputs" type="submit" name="btnSignup"></div>
            <p id="messageSignup"></p>
        </form>
    </div>
</section>

<!-- Update Details Modal -->
<input class="form-news-inputs" type="button" id='btnShowUpdate' value="Update Details"></input>
<section id="modalUpdate" class="modal">
    <div class="modal-content">
        <button id="closeUpdate" class="close" aria-label="Close">&times;</button>
        <form id="formUpdate" onsubmit="return validateUpdate(this)">
            <h2>Update Details Form</h2>
            <p>Please enter your details and new preferences.</p>
            <div><input class="form-news-inputs" type="text" name="fullName" placeholder="Full name..." required aria-label="Enter your full name here."></div>
            <div><input class="form-news-inputs" type="email" name="email" placeholder="Email..." required aria-label="Enter email address here."></div>
            <div>
                <label id="lblNews" for="newsletter">Keep monthly newsletter?</label>
                <input type="checkbox" id="newsletter" name="newsletter" value="0" onchange="if(this.checked) this.value='1'; else this.value='0';" aria-labelledby="lblNews">
            </div>
            <div>
                <label id="lblNotifs" for="notifications">Keep notifications?</label>
                <input type="checkbox" id="notifications" name="notifications" value="0" onchange="if(this.checked) this.value='1'; else this.value='0';" aria-labelledby="lblNotifs">
            </div>
            <div><input type="submit" name="btnUpdateDetails"></div>
            <p id="messageUpdate"></p>
        </form>
    </div>
</section>

<!-- Unsubscribe Modal -->
<input class="form-news-inputs" type="button" id='btnShowUnsub' value="Unsubscribe"></input>
<section id="modalUnsub" class="modal">
    <div class="modal-content">
        <!-- Unsub Section -->
        <button id="closeUnsub" class="close" aria-label="Close">&times;</button>
        <form id="formUnsub" onsubmit="return validateUnsub(this)">
            <h1>Unsubscribe Form</h1>
            <p>Please enter your details to unsubscribe.</p>
            <div>
                <input class="form-news-inputs" type="email" name="email" placeholder="Email..." required aria-label="Enter email address here.">
            </div>
            <div>
                <input class="form-news-inputs" type="submit" name="btnUnsub" value="Unsubscribe">
            </div>
            <p id="messageUnsub"></p>
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
<script type="text/javascript" src="js/signup.php.js"></script>

<?php
include_once 'includes/footer.inc.php';
?>