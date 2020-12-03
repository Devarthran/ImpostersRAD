<?php
// includes header and php functions file.
require_once 'includes/header.inc.php';
require_once 'includes/functions.inc.php';
// Sets the search variables if the page has been posted.
if (isset($_POST['btnSubmitSearch'])) {
    $title = testInput($_POST['title']);
    $genre = testInput($_POST['genre']);
    $rating = testInput($_POST['rating']);
    $year = testInput($_POST['year']);
}
?>

<!-- Search Bar Form-->
<div>
    <form id="searchForm" class="search-form" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST">
        <label id="lbltitle" for="title">Title: </label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Title" aria-labelledby="lbltitle" value="<?php
                                                                                                                                if (!empty($title)) {
                                                                                                                                    $title = stripslashes($title);
                                                                                                                                    echo $title;
                                                                                                                                }
                                                                                                                                ?>">
        <!-- Genre Select Box -->
        <label id="lblgenre" for="genre">Genre: </label>
        <Select name="genre" id="genre" aria-labelledby="lblgenre">
            <?php require_once "genre_scr.php"; ?>
        </Select>
        <label id="lblrating" for="rating">Rating: </label>
        <Select name="rating" id="rating" aria-labelledby="lblrating">
            <?php require_once "rating_scr.php"; ?>
        </Select>
        <label id="lblyear" for="year">Year: </label>
        <input type="text" name="year" id="year" pattern="([0-9]{4})|^ +$" placeholder="Year" aria-labelledby="lblyear" value="<?php
                                                                                                                                if (!empty($year)) {
                                                                                                                                    echo $year;
                                                                                                                                }
                                                                                                                                ?>">
        <input name="btnSubmitSearch" type="submit" value="Search">
        <input name="btnShowAll" type="submit" value="Show All">
    </form>
</div>
<!-- Movie Results Table from Database -->
<table id="searchResults" class="rtable" tabindex='1'>
    <thead id="resultsHead">
        <th scope='col'>Title</th>
        <th scope='col'>Status</th>
        <th scope='col'>Rating</th>
        <th scope='col'>Year</th>
        <th scope='col'>Genre</th>
        <th scope='col'>Rating</th>
    </thead>
    <tbody>
        <?php

        $conn = new mysqli("localhost", "root", "", "smt_db");

        if ($conn->connect_error) {
            exit("Connection to the database failed.");
        }
        // Sets Base SQL query and variables
        $query = "   SELECT * 
                        FROM movies 
                        WHERE 1 = 1
                        ORDER BY movieAverage DESC
                        LIMIT 50";
        $title = $genre = $rating = $year = '';

        // If server has post request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // If search has been pressed.
            if (isset($_POST['btnSubmitSearch'])) {
                $query = "SELECT * 
                            FROM movies 
                            WHERE 1 = 1";

                $title = testInput($_POST['title']);
                $genre = testInput($_POST['genre']);
                $rating = testInput($_POST['rating']);
                $year = testInput($_POST['year']);

                // Adds onto the base SQL query if input is empty or filled.
                if (!empty($title)) {
                    $query .= " AND Title Like '%" . $title . "%'";
                }
                if (!empty($genre)) {
                    $query .= " AND Genre = '" . $genre . "'";
                }
                if (!empty($rating)) {
                    $query .= " AND Rating = '" . $rating . "'";
                }
                if (!empty($year)) {
                    $query .= " AND Year = '" . $year . "'";
                }
                // Resets search query and variables
            } else if (isset($_POST['btnShowAll'])) {
                $title = '';
                $genre = '';
                $rating = '';
                $year = '';

                $query = "SELECT * FROM movies WHERE 1 = 1";
            } else {
                $title = '';
                $genre = '';
                $rating = '';
                $year = '';

                $query = "SELECT * FROM movies WHERE 1 = 1 LIMIT 50";
            }
        }
        $stmt = $conn->prepare($query);
        $stmt->execute();
        // If there was a result from the server, save it to variable.
        if ($result = $stmt->get_result()) {
            // Whilst rows remain, print out details in table row.
            while ($row = $result->fetch_assoc()) {
                $id = $row['ID'];

                $title = $row['Title'];
                $status = $row['Status'];
                $classification = $row['Rating'];
                $year = $row['Year'];
                $movieGenre = $row['Genre'];

                $rating = $row['movieAverage'];

                $ratingDisplay = number_format($row['movieAverage'], 2, '.', ''); // get current average float.


                echo <<< HTML
                        <tr scope='row'>
                            <td class='rtable-title'>$title</td>
                            <td>$status</td>
                            <td>$classification</td>
                            <td>$year</td>
                            <td>$movieGenre</td>
                            <td>
                                <div class='star-rating' data-id = $id data-rating='$rating'>
                                    <span style='display: inline-block' class='fa fa-star' role='img' data-index='1'></span>
                                    <span style='display: inline-block' class='fa fa-star' role='img' data-index='2'></span>
                                    <span style='display: inline-block' class='fa fa-star' role='img' data-index='3'></span>
                                    <span style='display: inline-block' class='fa fa-star' role='img' data-index='4'></span>
                                    <span style='display: inline-block' class='fa fa-star' role='img' data-index='5'></span>
                                    <span id='rating'>$ratingDisplay</span>
                                </div>
                            </td>
                        </tr>
                    HTML;
            }
            // Alert if database returned no results from query.
            if (mysqli_num_rows($result) == 0) {
                echo "<script type='text/javascript'>";
                echo "alert('Sorry, that movie doesn\'t appear in our catalogue.')";
                echo "</script>";
            }
        }
        ?>
    </tbody>
</table>

<!-- Includes footer -->
<?php
// include_once 'js/misc.js';
include_once 'includes/footer.inc.php';
?>
<script type="text/javascript" src="js/misc.js"></script>
<script type="text/javascript" src="js/search.php.js"></script>