<?php

if (isset($_POST)) {
    $movieID = $_POST['id'];
    $rating = $_POST['rating'];
    
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if ($movie = getMovie($conn, $movieID)) {
        $ones = $movie['oneStars'];
        $twos = $movie['twoStars'];
        $threes = $movie['threeStars'];
        $fours = $movie['fourStars'];
        $fives = $movie['fiveStars'];

        $currentRating = $movie['movieAverage'];

        
        switch ($rating) {
            case '1':
                $ones+=1;
                break;
            case '2':
                $twos+=1;
                break;
            case '3':
                $threes+=1;
                break;
            case '4':
                $fours+=1;
                break;
            case '5':
                $fives+=1;
                break;
            default:
                break;
        }

        $totalVotes = ($ones + $twos + $threes + $fours + $fives);
        $weighted = (($ones*1) + ($twos*2) + ($threes*3) + ($fours*4) + $fives*5);

        $newAverage = (double)$weighted / (double)$totalVotes;

        updateRecord($conn, $ones, $twos, $threes, $fours, $fives, $movieID, $newAverage);
    }

} else {
    echo 'failed';
}

function getMovie($conn, $id) {
    $sql = 'SELECT ID, oneStars, twoStars, threeStars, fourStars, fiveStars, movieAverage 
            FROM movies 
            WHERE ID = ?';
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Statement Error!';
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    if ($result = mysqli_stmt_get_result($stmt)) {
        if ($row = mysqli_fetch_assoc($result)) {
            return $row;
        } else {
            return false;
        }
    } else {
        echo 'Movie Not found';
        mysqli_stmt_close($stmt);
        return false;
    }
}

function allMovieAverage($conn) {
    $sql = 'SELECT ID, oneStars, twoStars, threeStars, fourStars, fiveStars, movieAverage 
            FROM movies';
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Statement Error!';
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
}

function updateRecord($conn,$ones, $twos, $threes, $fours, $fives, $movieID, $rating) {
    $sql = 'UPDATE movies 
            SET oneStars = ?, twoStars = ?, threeStars = ?, fourStars = ?, fiveStars = ?, movieAverage = ?
            WHERE ID = ?';
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo 'Statement Error!';
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'iiiiidi', $ones, $twos, $threes, $fours, $fives, $rating, $movieID);
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return;
    }
    mysqli_stmt_close($stmt);
}
?>