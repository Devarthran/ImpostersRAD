<?php

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_POST)) {
    $email = $_POST['email'];
    $news = $_POST['news'] == '1' ? 1 : 0;
    $notifs = $_POST['notifs'] == '1' ? 1 : 0;

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    
    if ($userExists = userExists($conn, $email)) {
        updateSub($conn, $email, $news, $notifs);
        echo 'Preferences Successfully Updated';
    } else {
        echo 'Account does not exist.';
    }
    exit();
} else {
    echo 'debug';
    exit();
}
echo 'debug';
exit();
