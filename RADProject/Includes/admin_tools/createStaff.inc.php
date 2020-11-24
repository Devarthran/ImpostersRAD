<?php

if (isset($_POST)) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST['password'];
    $al = $_POST["al"];

    require_once '../dbh.inc.php';
    require_once '../functions.inc.php';
    require_once 'adminFunctions.inc.php';

    if (emptyInputSignup($name, $email) !== false) {
        echo 'Name or Email is Empty';
        exit();
    }

    if ((invalidEmail($email) !== false) ) {
        echo 'Invalid Email';
        exit();
    }

    if ((userExists($conn, $email) !== false) ) {
        echo 'Account exists';
        exit();
    }

    $pattern = '/^([a-z+A-z+\d+]+){8,20}$/';
    if (!preg_match($pattern, $password)) {
        echo 'Password must follow rules.';
        exit();
    }
    
    createStaff($conn, $name, $email, $password, $al);

} else {
    echo 'Account creation failed';
    exit();
}



?>