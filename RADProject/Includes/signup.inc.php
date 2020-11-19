<?php 

if (isset($_POST["signupbtn"])) {

    $name = $_POST["fullName"];
    $email = $_POST["email"];
    $newsletter = (isset($_POST['newsletter'])) ? 1 : 0;
    $notifications = (isset($_POST['notifications'])) ? 1 : 0;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if (emptyInputSignup($name, $email) !== false) {
        header("location:../signup.php?error=emptyinput");
        exit();
    }

    if ((invalidEmail($email) !== false) ) {
        header("location:../signup.php?error=invalidemail");
        exit();
    }
    
    if (selectionCheck($newsletter, $notifications) !== false) {
        header("location:../signup.php?error=invalidselection");
        exit();
    }

    if ((userExists($conn, $email) !== false) ) {
        header("location:../signup.php?error=emailtaken");
        exit();
    }

    createUser($conn, $name, $email, $newsletter, $notifications);

}
else {
    header("location:../signup.php");
    exit();
}