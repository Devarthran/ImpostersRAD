<?php 
    include_once '../header.inc.php';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<!-- Movie Chart-->
<?php

$conn = new mysqli("localhost", "root", "", "smt_db");

if ($conn->connect_error) {
    exit("Connection to the database failed.");
}
// Sets Base SQL query
$query = "   SELECT * 
                        FROM movies 
                        WHERE movieAverage > 0
                        ORDER BY movieAverage DESC
                        LIMIT 10";

// Prepares and executes the 
$stmt = $conn->prepare($query);
$stmt->execute();

// If there was a result from the server, save it to variable.    
if ($result = $stmt->get_result()) {

    $movies = $stats = "";
    // Whilst rows remain, print out details in table row.
    while ($row = $result->fetch_assoc()) {
        $movies .= $row['Title'] . ",";
        $stats .= $row['movieAverage'] . ",";
    }

    $movies = rtrim($movies, ",");
    $stats = rtrim($stats, ",");

    echo '<div class="container">
        
        <div class="chart">
        <canvas id="top10Chart"></canvas>
        </div>
        </div>';

}

?>


<!-- Includes footer -->
<?php 
    include_once '../footer.inc.php';
?>