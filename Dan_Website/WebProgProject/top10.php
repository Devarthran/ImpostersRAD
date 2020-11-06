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
    $imports = $_SERVER['DOCUMENT_ROOT'];
    $imports .= '/WebProgProject/common/imports.php';
    require_once $imports;
    ?>
    <link rel="stylesheet" href="/WebProgProject/style.css" media="all" rel="stylesheet" type="text/css">
</head>

<body>
    <!--Includes Navigation bar -->
    <?php
    $nav = $_SERVER['DOCUMENT_ROOT'];
    $nav .= '/WebProgProject/common/mainNavBar.php';
    require_once $nav;
    ?>
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
            <th>Times Searched</th>
        </thead>
        <tbody>
            <?php

                $conn = new mysqli("localhost", "root", "", "smt_db");

            if ($conn->connect_error) {
                exit("Connection to the database failed.");
            }
                // Sets Base SQL query
                $query ="   SELECT * 
                            FROM movies 
                            WHERE num_searched > 0
                            ORDER BY num_searched DESC
                            LIMIT 10";

                // Prepares and executes the 
                $stmt = $conn->prepare($query);
                $stmt->execute();
            // If there was a result from the server, save it to variable.    
            if ($result = $stmt->get_result()) {
                // Whilst rows remain, print out details in table row.
                while ($row = $result->fetch_assoc()) {
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
                    $col11 = $row['num_searched'];

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
                                    <td>" . $col11 . "</td>
                                </tr>";
                }
            }
            ?>
        </tbody>
    </table>
    <!-- Includes footer -->
    <?php
    $footer = $_SERVER['DOCUMENT_ROOT'];
    $footer .= '/WebProgProject/common/footer.php';
    require_once $footer;
    ?>
</body>

</html>
