<?php 

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST['btnUnsub'])) {
    
    $email = $_POST['unsubEmail'];

    if (empty($email) !== false) {
        header("location:../signup.php");
        exit();
    }
    
    if (invalidEmail($email)) {
        header("location:../signup.php");
        exit();
    }

    

    if ($user = userExists($conn, $email)) {
        $name = $user['usersName'];
        $verifyKey = $user['verify_code'];
        header('location:templateEmail.inc.php?name='.$name.'&email='.$email.'&verifyKey='.$verifyKey);
        exit();
    }
    else {
        header("location:../signup.php?error=usernullexists");
        exit();
    }
}
else {
    header("location:../signup.php");
    exit();
}

?>