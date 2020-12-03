<?php 

function deleteUser($conn, $id) {
    $sql = "DELETE FROM users WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:../../admin.php?");
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return true;
}

function getUsers($conn) {
    $sql = "SELECT * FROM users;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:../../admin.php?error=stmtfailure");
        exit();
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function fetchStaff($conn) {
    $sql = "SELECT * FROM staff;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Statement Failure!';
        exit();
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_stmt_close($stmt);
    return $result;
}

function destroyStaff($conn, $id) {
    $sql = "DELETE FROM staff WHERE staffId = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Statement Failure!';
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $id);

    if (mysqli_stmt_execute($stmt)) {
        echo 'Deletion executed.';
        mysqli_stmt_close($stmt);
    }
    
    return true;


}

function createStaff($conn, $name, $email, $password, $accessLevel) {
    $sql = "INSERT INTO staff (staffName, staffEmail, staffPassword, access_level) 
            VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    $al = (int)$accessLevel;
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Statement Failure!';
        exit();
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, 'sssi', $name, $email, $hashedPass, $al);
    if (mysqli_stmt_execute($stmt)) {
        echo 'Staff account created.';
        mysqli_stmt_close($stmt);
        exit();
    } else {
        echo 'Account creation failed.';
        mysqli_stmt_close($stmt);
        exit();
    }
}