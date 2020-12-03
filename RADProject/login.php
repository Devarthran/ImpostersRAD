<?php
include_once 'includes/header.inc.php';
?>

<section>
    <h1 class="login-form-title">Login</h1>
    <div class="login-form">
        <form action="includes/login.inc.php" method="post">
            <div>
                <input class="login-form-input" type="email" name="email" placeholder="Email..." requiried aria-label="">
            </div>

            <div>
                <input class="login-form-input" type="password" name="password" placeholder="Password..." requiried aria-label="">
            </div>

            <div>
                <input class="login-form-input" type="submit" name="loginbtn" value="Login">
            </div>
        </form>
    </div>
</section>

<?php
include_once 'includes/footer.inc.php';
?>