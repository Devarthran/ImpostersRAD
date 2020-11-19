<?php 
    include_once 'includes/header.inc.php';
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>

<!-- Movie Chart-->
<?php

$conn = new mysqli("localhost", "root", "", "smt_db");

if ($conn->connect_error) {
    exit("Connection to the database failed.");
}
// Sets Base SQL query
$query = "   SELECT * 
                        FROM movies 
                        WHERE num_searched > 0
                        ORDER BY num_searched DESC
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
        $stats .= $row['num_searched'] . ",";
    }

    $movies = rtrim($movies, ",");
    $stats = rtrim($stats, ",");

    echo '<div class="container">
        
        <div class="chart">
        <canvas id="top10Chart"></canvas>
        </div>
        </div>';

    include('top10Chart.php');
}

?>


<!-- Includes footer -->
<?php 
    include_once 'includes/footer.inc.php';
?>