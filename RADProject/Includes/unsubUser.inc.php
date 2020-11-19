<?php 

require_once 'dbh.inc.php';
require_once 'functions.inc.php';

if (isset($_GET['verifyKey'])) {
    $verifyKey = $_GET['verifyKey'];

    $sql = "DELETE FROM users WHERE verify_code = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:../signup.php?error=stmtfailure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $verifyKey);
    mysqli_stmt_execute($stmt);
    header('location:../signup.php?message=unsubpass');
    exit();
}
else {
    header('location:../signup.php?error=unsubfailed');
    exit();
}
?>