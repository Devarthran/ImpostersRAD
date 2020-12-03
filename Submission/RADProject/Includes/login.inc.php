<?php

if (isset($_POST['loginbtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($email, $password) !== false) {
        header("location:../login.php?error=emptyinput");
        exit();
    }

    login($conn, $email, $password);
} else {
    echo 'Failed to log in.';
    exit();
}
