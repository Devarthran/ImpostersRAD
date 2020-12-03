<?php 

require_once '../dbh.inc.php';
require_once 'adminFunctions.inc.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    if (deleteUser($conn, $id)) {
        echo 'Success';
    } else {
        echo 'Failed to delete user.';
    }
}
