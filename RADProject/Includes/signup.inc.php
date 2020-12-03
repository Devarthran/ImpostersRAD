<?php 

if (isset($_POST)) {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $news = $_POST['news'] == '1' ? 1 : 0;
    $notifs = $_POST['notifs'] == '1' ? 1 : 0;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if (emptyInputSignup($name, $email) !== false) {
        echo 'Name or Email is Empty';
        exit();
    }

    if ((invalidEmail($email) !== false) ) {
        echo 'Invalid Email';
        exit();
    }
    
    if (selectionCheck($news, $notifs) !== false) {
        echo 'Please tick at least one checkbox';
        exit();
    }

    if ((userExists($conn, $email) !== false) ) {
        echo 'Account exists';
        exit();
    }

    createUser($conn, $name, $email, $news, $notifs);
    echo 'Account Created Successfully';
}
else {
    header("location:../signup.php");
    exit();
}
