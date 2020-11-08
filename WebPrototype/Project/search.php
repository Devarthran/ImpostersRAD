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
    <title>Movies - Search</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
        <ul id="navbar">
            <li><a href=".\index.php"><span>Movies</span></a></li>
            <li class="active"><a href=".\search.php"><span>Search</span></a></li>
            <li><a href=".\statistic.php"><span>Statistic</span></a></li>
        </ul>
    </div>

    <!-- Page Content -->
    <div class="main">
        <h2><span>Search</span></h2>
        <?php
        // Search filter
        if (!isset($_POST['search']) && !isset($_POST['submit'])) {
            ?>
            <br>
            <form id="first" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="form-group">
                    <label>Search Method:</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name='title' value='title'>
                    <label for="title">&nbsp; Title</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name='genre' value='genre'>
                    <label for="genre">&nbsp; Genre</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name='rating' value='rating'>
                    <label for="rating">&nbsp; Rating</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name='year' value='year'>
                    <label for="year">&nbsp; Year</label>
                </div>
                <div class="form-group">
                    <button type="submit" name="search" class="btn btn-default">&nbsp;Search&nbsp;</button>
                </div>
            </form>
            <img id='design1' src='design.png' alt='Design' />
            <?php
        } else {
            // If empty form is submitted, display error message
            if (empty($_POST['title']) && empty($_POST['genre']) && empty($_POST['rating']) && empty($_POST['year']) && !isset($_POST['submit'])) {
                echo '<h4>Please select at least one fiilter!</h4>';
                echo '<h4>Click <a href="search.php">here</a> to try again</h4>';
            } else {
                // Form to input title, select genre, rating and year
                // Display only the form for the filters selected by the user
                if (!isset($_POST['submit'])) {
                    ?>
                    <br>
                    <form id="second" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <?php
                        if (!empty($_POST['title'])) {
                            ?>
                            <div class="form-group2">
                                <label id="lbl2" for="title2">Title:</label>
                                <input type="text" class="form-control" id="title2" name="title2" required>
                            </div>
                            <?php
                            echo "<br>";
                        }
                        if (!empty($_POST['genre'])) {
                            include "connect.php";
                            // Get options from table
                            $stmt = $conn->prepare(
                                "SELECT DISTINCT Genre
                                        FROM movies_table
                                        ORDER BY Genre ASC"
                            );
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if ($result != null) {
                                ?>
                                <div class="form-group2">
                                    <label id="lbl2">Genre: &nbsp;</label>
                                    <br>
                                    <?php
                                    $num = 0;
                                    foreach ($result as $row) {
                                        $num = $num + 1;
                                        $genre = $row['Genre'];
                                        echo "<input type='checkbox' name='genre2[]' value='$genre'>";
                                        echo "<label for=$genre>&nbsp; $genre &nbsp; &nbsp;</label>";
                                        if ($num == 6) {
                                            echo '<br>';
                                            $num = 0;
                                        }
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            echo "<br>";
                        }
                        if (!empty($_POST['rating'])) {
                            include "connect.php";
                            $stmt = $conn->prepare(
                                "SELECT DISTINCT Rating
                                        FROM movies_table
                                        ORDER BY Rating ASC"
                            );
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if ($result != null) {
                                ?>
                                <div class="form-group2">
                                    <label id="lbl2">Rating: &nbsp;</label>
                                    <br>
                                    <?php
                                    $num = 0;
                                    foreach ($result as $row) {
                                        $num = $num + 1;
                                        $rating = $row['Rating'];
                                        echo "<input type='checkbox' name='rating2[]' value='$rating'>";
                                        echo "<label for=$rating>&nbsp; $rating &nbsp; &nbsp;</label>";
                                        if ($num == 6) {
                                            echo '<br>';
                                            $num = 0;
                                        }
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            echo "<br>";
                        }
                        if (!empty($_POST['year'])) {
                            include "connect.php";
                            $stmt = $conn->prepare(
                                "SELECT DISTINCT Year
                                                    FROM movies_table"
                            );
                            $stmt->execute();
                            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($result != null) {
                                ?>
                                <div class="form-group2">
                                    <label id="lbl2">Year: &nbsp;</label>
                                    <br>
                                    <?php

                                    $yearArray = [];
                                    $index = 0;
                                    $max = 0;

                                    foreach ($result as $row) {
                                        // Round up the number to the previous 10
                                        $year = (ceil($row['Year'] / 10) * 10) - 10;
                                        // Get maximum year (not rounded)
                                        if ($row['Year'] > $max) {
                                            $max = $row['Year'];
                                        }
                                        $dup = true;
                                        if ($index == 0) {
                                            array_push($yearArray, $year);
                                        } else {
                                            for ($i = 0; $i < sizeof($yearArray); $i++) {
                                                // Remove duplicates
                                                if ($year == $yearArray[$i]) {
                                                    $dup = true;
                                                    break;
                                                } else {
                                                    $dup = false;
                                                }
                                            }
                                            if ($dup == false) {
                                                array_push($yearArray, $year);
                                            }
                                        }
                                        $index = $index + 1;
                                    }

                                    sort($yearArray);
                                    $num = 0;
                                    for ($i = 1; $i <= sizeof($yearArray); $i++) {
                                        $min = $i - 1;
                                        $low = $yearArray[$min] + 1;
                                        // Display range of years as options
                                        if ($i == sizeof($yearArray)) {
                                            echo "<input type='checkbox' name='year2[]' value='$low'>";
                                            echo "<label for=$low>&nbsp; $low - $max &nbsp; &nbsp;</label>";
                                        } else {
                                            echo "<input type='checkbox' name='year2[]' value='$low'>";
                                            echo "<label for=$low>&nbsp; $low - $yearArray[$i] &nbsp; &nbsp;</label>";
                                        }
                                        $num = $num + 1;
                                        if ($num == 5) {
                                            echo "<br>";
                                            $num = 0;
                                        }
                                    }

                                    ?>
                                </div>
                                <?php
                            }
                            echo "<br>";
                        }
                        ?>
                        <div class="form-group2">
                            <button type="submit" name="submit" class="btn btn-default">&nbsp;Submit&nbsp;</button>
                        </div>
                    </form>
                    <img id='design2' src='design.png' alt='Design' />
                    <?php
                } else {
                    if (!empty($_POST['title2'])) {
                        if (preg_match('/[^\'"]/', $_POST['title2'])) {
                            // Replace ' with \' and " with \" to prevent errors
                            $title = str_replace(array('\'', '"'), array('\\\'', '\\"'), $_POST['title2']);
                        } else {
                            $title = filter_var($_POST['title2'], FILTER_SANITIZE_STRING);
                        }
                    } else {
                        $title = "";
                    }

                    if (!empty($_POST['genre2'])) {
                        $genre = [];
                        foreach ($_POST['genre2'] as $g) {
                            array_push($genre, $g);
                        }
                    } else {
                        $genre = "";
                    }

                    if (!empty($_POST['rating2'])) {
                        $rating = [];
                        foreach ($_POST['rating2'] as $r) {
                            array_push($rating, $r);
                        }
                    } else {
                        $rating = "";
                    }

                    if (!empty($_POST['year2'])) {
                        $year = [];
                        foreach ($_POST['year2'] as $y) {
                            array_push($year, $y);
                        }
                    } else {
                        $year = "";
                    }

                    include 'search_scr.php';
                }
            }
        }
        ?>
    </div>
</body>

</html>
