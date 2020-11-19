<?php 
    include_once 'includes/header.inc.php';
?>

    <section>
        <h2 class="login-form-title">Login</h2>
        <div class="login-form">
            <form  action="includes/login.inc.php" method="post">
                <div>
                <input type="email" name="email" placeholder="Email...">
                </div>

                <div>
                <input type="password" name="password" placeholder="Password...">
                </div>
                
                <div>
                <input type="submit" name="loginbtn" value="Login">
                </div>
            </form>
        </div>
    </section>

<?php 
    include_once 'includes/footer.inc.php';
?>