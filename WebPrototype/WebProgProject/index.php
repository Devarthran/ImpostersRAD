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
            </div>
            <div class="form-group">
                <!-- Genre Select Box -->
                <label id="lblgenre" for="genre">Genre: </label>
                <Select name="genre" id="genre" class="form-control" aria-labelledby="lblgenre">
                    <?php require_once "genre_scr.php"; ?>
                </Select>
            </div>
            <div class="form-group">
                <label id="lblrating" for="rating">Rating: </label>
                <Select name="rating" id="rating" class="form-control" aria-labelledby="lblgenre">
                    <?php require_once "rating_scr.php"; ?>
                </Select>
            </div>
            <div class="form-group">
                <label id="lblyear" for="year">Year: </label>
                <input type="text" name="year" id="year" class="form-control" pattern="([0-9]{4})|^ +$"
                    placeholder="Year" aria-labelledby="lblyear" value="<?php 
                    if (!empty($year)) { 
                        echo $year; 
                    } 
                    ?>">
            </div>
            <div class="form-group">
                <input name="btnSubmitSearch" class="form-control" type="submit" value="Search">
            </div>
            <div class="form-group">
                <input name="btnShowAll" class="form-control" type="submit" value="Show All">
            </div>
        </form>
    </div>
    <!-- Movie Results Table from Database -->

    <!-- Includes footer -->
    <?php
    $footer = 'footer.php';
    require_once $footer;
    ?>
</body>

</html>