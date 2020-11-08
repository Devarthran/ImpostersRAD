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
    <title>Movies</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSS -->
    <link href="myStyles.css?v=1.1<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</head>

<!-- Body -->

<body>
    <div class="header">
        <a href=".\index.php" id="logo">Movies</a>

        <!-- Navigation Bar -->
        <ul id="navbar">
            <li class="active"><a href=".\index.php"><span>Movies</span></a></li>
            <li><a href=".\search.php"><span>Search</span></a></li>
            <li><a href=".\statistic.php"><span>Statistic</span></a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="main">
        <h2><span>Movies</span></h2>
        <br>
        <?php
        // Movies table
        require 'showAllMovies_scr.php';
        ?>
    </div>
</body>

</html>