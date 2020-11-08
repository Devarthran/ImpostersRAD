<link href="myStyles.css?v=1.1<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<?php
require "connect.php";

// Query
$string = "SELECT MovieID, Title, Studio, Status, Sound, Versions, Price, Rating, Year, Genre, Aspect
            FROM movies_table
            WHERE ";
// Display user's filters
$response = "Displaying movies ";
$data = "";

if (empty($title) && empty($genre) && empty($rating) && empty($year)) {
    echo "<h3>Error: <span>Please select/input at least one filter</span></h3>";
    echo "<h3>Please click <a href='search.php'>here</a> to try again</h3>";
} else {
    // Concatenate SQL statements and filters
    if (!empty($title)) {
        $string = $string . "(Title LIKE '%" . $title . "%')";
        $data = $data . "Title ";
        $response = $response . " with Title: " . $title;

        // Update Statistics
        $stmt2 = $conn->prepare(
            "UPDATE movies_table
            SET Statistic = Statistic + 1
            WHERE Title LIKE '%" . $title . "%'"
        );
        $stmt2->execute();
    }

    if (!empty($genre)) {
        if (!empty($data)) {
            $string = $string . " AND ";
            $response = $response . ", ";
        } else {
            $response = $response . " with ";
        }

        if (sizeof($genre) == 1) {
            $string = $string . "(Genre = '" . $genre[0] . "')";
            $response = $response . "Genre: " . $genre[0];
        } else {
            for ($i = 0; $i < sizeof($genre); $i++) {
                if ($i == 0) {
                    $string = $string . "(Genre = '" . $genre[$i] . "'";
                    $response = $response . "Genre: " . $genre[$i];
                } else if ($i == sizeof($genre) - 1) {
                    $string = $string . " OR Genre = '" . $genre[$i] . "')";
                    $response = $response . ", " . $genre[$i];
                } else {
                    $string = $string . " OR Genre = '" . $genre[$i] . "'";
                    $response = $response . ", " . $genre[$i];
                }
            }
        }
        $data = $data . "Genre ";
    }

    if (!empty($rating)) {
        if (!empty($data)) {
            $string = $string . " AND ";
            $response = $response . ", ";
        } else {
            $response = $response . " with ";
        }

        if (sizeof($rating) == 1) {
            $string = $string . "(Rating = '" . $rating[0] . "')";
            $response = $response . "Rating: " . $rating[0];
        } else {
            for ($i = 0; $i < sizeof($rating); $i++) {
                if ($i == 0) {
                    $string = $string . "(Rating = '" . $rating[$i] . "'";
                    $response = $response . "Rating: " . $rating[$i];
                } else if ($i == sizeof($rating) - 1) {
                    $string = $string . " OR Rating = '" . $rating[$i] . "')";
                    $response = $response . ", " . $rating[$i];
                } else {
                    $string = $string . " OR Rating = '" . $rating[$i] . "'";
                    $response = $response . ", " . $rating[$i];
                }
            }
        }
        $data = $data . "Rating";
    }

    if (!empty($year)) {
        if (!empty($data)) {
            $string = $string . " AND ";
            $response = $response . ", produced between ";
        } else {
            $response = $response . " produced between ";
        }

        if (sizeof($year) == 1) {
            $high = $year[0] + 9;
            $string = $string . "(Year BETWEEN " . $year[0] . " AND " . $high . ")";
            $response = $response . "years " . $year[0] . " and " . $high;
        } else {
            for ($i = 0; $i < sizeof($year); $i++) {
                $high = $year[$i] + 9;
                if ($i == 0) {
                    $string = $string . "(Year BETWEEN " . $year[$i] . " AND " . $high;
                    $response = $response . "years " . $year[$i] . " and " . $high;
                } else if ($i == sizeof($year) - 1) {
                    $string = $string . " OR Year BETWEEN " . $year[$i] . " AND " . $high . ")";
                    $response = $response . ", " . $year[$i] . " and " . $high;
                } else {
                    $string = $string . " OR Year BETWEEN " . $year[$i] . " AND " . $high;
                    $response = $response . ", " . $year[$i] . " and " . $high;
                }
            }
        }
    }

    // Display the user's filters
    echo "<h4>$response</h4>";
    echo "<br>";

    $stmt = $conn->prepare($string);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result != null) {

        // Open table
        echo '<table class ="table table-striped" id="outTableMovies">';
        // Table header
        echo "	<tr>
                <th>MovieID</th>
                <th>Title</th>
                <th>Studio</th>
                <th>Status</th>
                <th>Sound</th>
                <th>Versions</th>
                <th>Price</th>
                <th>Rating</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Aspect</th>
            </tr>";

        foreach ($result as $row) {
            $movieID    = $row['MovieID'];
            $title      = $row['Title'];
            $studio     = $row['Studio'];
            $status     = $row['Status'];
            $sound      = $row['Sound'];
            $versions   = $row['Versions'];
            $price      = $row['Price'];
            $rating     = $row['Rating'];
            $year       = $row['Year'];
            $genre      = $row['Genre'];
            $aspect     = $row['Aspect'];

            echo "	<tr>
				    <td>$movieID</td>
                    <td>$title</td>
                    <td>$studio</td>
                    <td>$status</td>
                    <td>$sound</td>
                    <td>$versions</td>
                    <td>$price</td>
                    <td>$rating</td>
                    <td>$year</td>
                    <td>$genre</td>
                    <td>$aspect</td>
                </tr>";
        }

        echo '</table>';
    } else {
        echo "<br>";
        echo "<img id='empty' src='empty.png' alt='No Result' />";
        echo "<h4>Please click <a href='search.php'>here</a> to try again</h4>";
    }
}
?>