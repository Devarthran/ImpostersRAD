<?php
// includes header and php functions file.
include_once 'includes/header.inc.php';
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
        <!-- Movie Title Input Box -->
        <label id="lbltitle" for="title">Title: </label>
        <input type="text" name="title" id="title" class="form-control" placeholder="Title" aria-labelledby="lbltitle" value="<?php
                                                                                                                                if (!empty($title)) {
                                                                                                                                    $title = stripslashes($title);
                                                                                                                                    echo $title;
                                                                                                                                }
                                                                                                                                ?>"> <!-- sets the value of the input if the $title variable !empty -->
        <!-- Genre Select Box -->
        <label id="lblgenre" for="genre">Genre: </label>
        <Select name="genre" id="genre" aria-labelledby="lblgenre">
            <!-- Populates Genre box with column from database -->
            <?php require_once "genre_scr.php"; ?>
        </Select>
        <!-- Rating Select Box -->
        <label id="lblrating" for="rating">Rating: </label>
        <Select name="rating" id="rating" aria-labelledby="lblgenre">
            <!-- Populates Rating box with column from database -->
            <?php require_once "rating_scr.php"; ?>
        </Select>
        <!-- Year Input Box -->
        <label id="lblyear" for="year">Year: </label>
        <input type="text" name="year" id="year" pattern="([0-9]{4})|^ +$" placeholder="Year" aria-labelledby="lblyear" value="<?php
                                                                                                                                if (!empty($year)) {
                                                                                                                                    echo $year;
                                                                                                                                }
                                                                                                                                ?>"> <!-- sets the value of the input if the $year variable !empty -->
        <input name="btnSubmitSearch" type="submit" value="Search">
        <input name="btnShowAll" type="submit" value="Show All">
    </form>
</div>
<!-- Movie Results Table from Database -->
<table id="searchResults" class="rtable">
    <thead id="resultsHead">
        <th>Title</th>
        <th>Studio</th>
        <th>Status</th>
        <th>Sound</th>
        <th>versions</th>
        <th>Recommended Retail Price</th>
        <th>Rating</th>
        <th>Year</th>
        <th>Genre</th>
        <th>Aspect</th>
    </thead>
    <tbody>
        <?php
        // This PHP script fetches the movies from database based on search criteria,
        // and populates the table by echoing out rows with each movies data
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

                $query = "SELECT * FROM movies WHERE 1 = 1 LIMIT 10";
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
                $studio = $row['Studio'];
                $status = $row['Status'];
                $sound = $row['Sound'];
                $versions = $row['Versions'];
                $recPrice = $row['RecRetPrice'];
                $classification = $row['Rating'];
                $year = $row['Year'];
                $movieGenre = $row['Genre'];
                $aspect = $row['Aspect'];

                $rating = $row['movieAverage'];


                // Bulk HTML echo to create more readable code.
                echo <<< HTML
                        <tr>
                            <td class='rtable-title'>$title</td>
                            <td>$studio</td>
                            <td>$status</td>
                            <td>$sound</td>
                            <td>$versions</td>
                            <td>$recPrice</td>
                            <td>$classification</td>
                            <td>$year</td>
                            <td>$movieGenre</td>
                            <td>$aspect</td>
                        </tr>
                    HTML;
            }
            // Alert user if database returned no results from query.
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
include_once 'includes/footer.inc.php';
?>
<!-- script to include search form page refresh JS -->
<script type="text/javascript" src="js/misc.js"></script>