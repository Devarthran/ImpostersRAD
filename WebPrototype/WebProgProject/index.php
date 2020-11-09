<?php
/**
 * SMT Movie Rental Database
 * PHP version 7.4
 * 
 * @category Website
 * @package  WebProgProject
 * @author   Daniel Ewen <Daniel.j.ewen@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT Lisence
 * @link     null
 */
?>

<!DOCTYPE html>
<html lang="en">

<!-- Javascript clear the current window state with the same page, 
    easy way to prevent form resubmission on refresh  -->
<script>
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}
</script>

<head>
    <!-- Includes header information -->
    <?php
    $imports = 'imports.php';
    require_once $imports;
    ?>
    <link href="style.css?v=1.1<?php echo time(); ?>" media="all" rel="stylesheet" type="text/css" />
</head>

<body>
    <!-- Includes Navigation bar-->
    <?php
    $nav = 'mainNavBar.php';
    require_once $nav;
    ?>

    <?php
    /**
     * TestInput
     * Formats the string to remove malicious code.
     * 
     * @param string $data Data to be processed
     * 
     * @return string $data
     */
    function testInput($data)
    {
        $data = trim($data);
        // Stripping, then adding the slashes back in removes any double backslashes 
        // whilst adding them back in to not escape strings
        $data = stripslashes($data);
        $data = addslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    // Sets the search variables if the page has been posted.
    if (isset($_POST['btnSubmitSearch'])) {
        $title = testInput($_POST['title']);
        $genre = testInput($_POST['genre']);
        $rating = testInput($_POST['rating']);
        $year = testInput($_POST['year']);
    }
    ?>

    <!-- Search Bar Form-->
    <div id="searchBar" class="container">
        <form id="SearchForm" class="form-inline" action="<?php echo basename($_SERVER['PHP_SELF']); ?>" method="POST">
            <div class="form-group">
                <label id="lbltitle" for="title">Title: </label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Title"
                    aria-labelledby="lbltitle" value="<?php   
                    if (!empty($title)) { 
                        $title = stripslashes($title);
                        echo $title; 
                    } 
                    ?>">

                <!-- Genre Select Box -->
                <label id="lblgenre" for="genre">Genre: </label>
                <Select name="genre" id="genre" class="form-control" aria-labelledby="lblgenre">
                    <?php require_once "genre_scr.php"; ?>
                </Select>

                <label id="lblrating" for="rating">Rating: </label>
                <Select name="rating" id="rating" class="form-control" aria-labelledby="lblgenre">
                    <?php require_once "rating_scr.php"; ?>
                </Select>

                <label id="lblyear" for="year">Year: </label>
                <input type="text" name="year" id="year" class="form-control" pattern="([0-9]{4})|^ +$"
                    placeholder="Year" aria-labelledby="lblyear" value="<?php 
                    if (!empty($year)) { 
                        echo $year; 
                    } 
                    ?>">

                <input name="btnSubmitSearch" class="form-control" type="submit" value="Search">
                <input name="btnShowAll" class="form-control" type="submit" value="Show All">
            </div>
        </form>
    </div>
    <!-- Movie Results Table from Database -->
    <table id="searchResults" class="table container">
        <thead id="resultsHead">
            <th>Title</th>
            <th>Studio</th>
            <th>Status</th>
            <th>Sound</th>
            <th>Versions</th>
            <th>Recommended Retail Price</th>
            <th>Rating</th>
            <th>Year</th>
            <th>Genre</th>
            <th>Aspect</th>
        </thead>
        <tbody>
            <?php

                $conn = new mysqli("localhost", "root", "", "smt_db");

            if ($conn->connect_error) {
                exit("Connection to the database failed.");
            }
                // Sets Base SQL query and variables
                $query ="SELECT * FROM movies WHERE 1 = 1";
                $title = $genre = $rating = $year = '';

                // If server has post request
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // If search has been pressed.
                if (isset($_POST['btnSubmitSearch'])) {
                    $title = testInput($_POST['title']);
                    $genre = testInput($_POST['genre']);
                    $rating = testInput($_POST['rating']);
                    $year = testInput($_POST['year']);
                        
                    // Adds onto the base SQL query if input is empty or filled.
                    if (!empty($title)) {
                        $query .= " AND Title Like '%". $title ."%'";
                    }
                    if (!empty($genre)) {
                        $query .= " AND Genre = '". $genre ."'";
                    }
                    if (!empty($rating)) {
                        $query .= " AND Rating = '". $rating ."'";
                    }
                    if (!empty($year)) {
                        $query .= " AND Year = '". $year ."'";
                    }
                // Resets search query and variables
                } else if (isset($_POST['btnShowAll'])) {
                    $title = '';
                    $genre = '';
                    $rating = '';
                    $year = '';

                    $query = "SELECT * FROM movies WHERE 1 = 1";
                }

                    
            }
                // Prepares and executes the 
                $stmt = $conn->prepare($query);
                $stmt->execute();
            // If there was a result from the server, save it to variable.
            if ($result = $stmt->get_result()) {
                // Whilst rows remain, print out details in table row.
                while ($row = $result->fetch_assoc()) {
                    $title = stripslashes($title);
                    // Checks if the title from this entry matches the search query,
                    // If true, increment that entries num_searched column
                    if ($row['Title'] == $title) {
                        $title = addslashes($title);
                        $popQuery = "   UPDATE movies
                                            SET `num_searched` = `num_searched` + 1
                                            WHERE Title = '" . $title . "'";
                        $stmt = $conn->prepare($popQuery);
                        $stmt->execute();
                        $title = testInput($title);
                    }
                    $col1 = $row['Title'];
                    $col2 = $row['Studio'];
                    $col3 = $row['Status'];
                    $col4 = $row['Sound'];
                    $col5 = $row['Versions'];
                    $col6 = $row['RecRetPrice'];
                    $col7 = $row['Rating'];
                    $col8 = $row['Year'];
                    $col9 = $row['Genre'];
                    $col10 = $row['Aspect'];

                    echo "  <tr>
                                    <td>" . $col1 . "</td>
                                    <td>" . $col2 . "</td>
                                    <td>" . $col3 . "</td>
                                    <td>" . $col4 . "</td>
                                    <td>" . $col5 . "</td>
                                    <td>" . $col6 . "</td>
                                    <td>" . $col7 . "</td>
                                    <td>" . $col8 . "</td>
                                    <td>" . $col9 . "</td>
                                    <td>" . $col10 . "</td>
                                </tr>";
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
    $footer = 'footer.php';
    require_once $footer;
    ?>
</body>

</html>