<?php 

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (true) {
    
    $email = $_POST['email'];
    
    if (empty($email) !== false) {
        echo 'Email is empty.';
        exit();
    }
    
    if (invalidEmail($email)) {
        echo 'Invalid Email.';
        exit();
    }

    if ($user = userExists($conn, $email)) {
        $name = $user['usersName'];
        $verifyKey = $user['verify_code'];
        echo '<a href="includes/templateEmail.inc.php?name='.$name.'&email='.$email.'&verifyKey='.$verifyKey.'">Test Unsub Mail</a>';
        exit();
    }
    else {
        echo 'User doesn\'t exist.';
        exit();
    }
}
else {
    echo 'failed';
    exit();
}

?>