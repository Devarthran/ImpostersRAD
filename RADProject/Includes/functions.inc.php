<?php 

function testInput($data){
    $data = trim($data);
    // Stripping, then adding the slashes back in removes any double backslashes 
    // whilst adding them back in to not escape strings
    $data = stripslashes($data);
    $data = addslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Signup Page Functions
function selectionCheck($newsletter, $notifications) {
    if ($newsletter == 0 && $notifications == 0) {
        return true;
    }
    else { return false; }
}

function emptyInputSignup($name, $email) {
    if (empty($name) || empty($email)) {
        return true;
    }
    else { return false; }
}

function emptyEmail($email) {
    if (empty($email)) {
        return true;
    }
    else { return false; }
}

function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    }
    else { return false; }
}

function userExists($conn, $email) {
    $sql = "SELECT * FROM users WHERE usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:../signup.php?error=stmtfailure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $email, $newsletter, $notifications) {
    $sql = "INSERT INTO users (usersName, usersEmail, usersNewsletter, usersNotifications, verify_code) 
            VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:../signup.php?error=stmtfailure");
        exit();
    }

    $validationKey = password_hash($name.$email, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, 'ssiis', $name, $email, $newsletter, $notifications, $validationKey);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location:../signup-success.php");
    exit();
}

function createAdmin($conn, $name, $email, $password) {
    $sql = "INSERT INTO admins (adminName, adminEmail, adminPassword) 
            VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:../login.php?error=loginfailure");
        exit();
    }

    $hashedPass = password_hash($password, PASSWORD_DEFAULT);


    mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $password);
    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
    header("location:../login.php?message=admincreated");
    exit();
}

// Login Page Functions
function emptyInputLogin($email, $password) {
    if (empty($email) || empty($password)) {
        return true;
    }
    else { return false; }
}

function adminExists($conn, $email) {
    $sql = "SELECT * FROM admins WHERE adminEmail = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location:../signup.php?error=stmtfailure");
        exit();
    }

    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
    else {
        return false;
    }

    mysqli_stmt_close($stmt);
}

function loginAdmin($conn, $email, $password) {
    $adminExists = adminExists($conn, $email);

    if ($adminExists === false) {
        header("location:../login.php?error=loginfailure");
        exit();
    }

    $passHashed = $adminExists['adminPassword'];
    $checkPass = password_verify($password, $passHashed);

    if ($checkPass === false) {
        header("location:../login.php?error=passfailure");
        exit();
    }
    else if ($checkPass === true) {
        session_start();
        $_SESSION['adminName'] = $adminExists['adminName'];
        header("location:../admin.php?message=loggedin");
        exit();
    }
}

// Email
function sendNewsletter() {
    $subject = 'AE Monthly Newsletter';
    $message = '';
    
}