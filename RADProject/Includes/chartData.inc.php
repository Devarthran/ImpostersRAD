<?php 

    require_once 'dbh.inc.php';

    $sql = 'SELECT `Title`,`movieAverage` 
            FROM movies
            ORDER BY `movieAverage` DESC
            LIMIT 10';
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, $sql);
    mysqli_stmt_execute($stmt);

    if (!$result = mysqli_stmt_get_result($stmt)) {
        echo 'statement fail';
    }

    $data = array();
    $data["titles"] = array();
    $data["ratings"] = array();
    

    while ($row = mysqli_fetch_array($result)) {
        array_push($data["titles"], $row["Title"]);
        array_push($data["ratings"], $row["movieAverage"]);
    }

    echo json_encode($data);
    exit();
    ?>