<!--
Student Name:   Ke Swen Lee
Student ID:     30010827
Date:           17/09/2020
Task:           - Develop the application with PHP and MySQL
                - Generate SQL scripts to store the movie records in an appropriate database table
                - Have a search form, searchable by the title, genre, rating and year.
                - Display the full details of each movie found. If no movie is found, the application will display a
                  user-friendly message.
-->
<!DOCTYPE html>
<html lang="en">

<!-- Head -->

<head>
    <title>Movies - Statistic</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link href="myStyles.css?v=1.1<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<!-- Body -->

<body>
    <div class="header">
        <a href=".\index.php" id="logo">Movies</a>

        <!-- Navigation Bar -->
        <hr>
        <ul id="navbar">
            <li><a href=".\index.php"><span>Movies</span></a></li>
            <li><a href=".\search.php"><span>Search</span></a></li>
            <li class="active"><a href=".\statistic.php"><span>Statistic</span></a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="main">
        <h2><span>Top 10 Movies</span></h2>
        <br>
        <?php
        // Movies table
        require 'statistic_scr.php';
        ?>
    </div>
</body>

</html>