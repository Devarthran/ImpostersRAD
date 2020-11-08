<link href="myStyles.css?v=1.1<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

<?php
require "connect.php";
// Query
$stmt = $conn->prepare(
    "SELECT MovieID, Title, Studio, Status, Sound, Versions, Price, Rating, Year, Genre, Aspect 
        FROM movies_table"
);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($result != null) {

    // Open table
    echo '<table width="100%" class="table table-striped" id="outTableMovies">';
    // Table header
    echo "	<tr>
                <th width=4.2%>ID</th>
                <th width=18.4%>Title</th>
                <th width=15%>Studio</th>
                <th width=9%>Status</th>
                <th width=7%>Sound</th>
                <th width=10%>Versions</th>
                <th width=6.3%>Price</th>
                <th width=7.3%>Rating</th>
                <th width=5.3%>Year</th>
                <th width=10%>Genre</th>
                <th width=7.5%>Aspect</th>
            </tr>";

    foreach ($result as $row) {
        $movieID        = $row['MovieID'];
        $title          = $row['Title'];
        $studio         = $row['Studio'];
        $status         = $row['Status'];
        $sound          = $row['Sound'];
        $versions       = $row['Versions'];
        $price          = $row['Price'];
        $rating         = $row['Rating'];
        $year           = $row['Year'];
        $genre          = $row['Genre'];
        $aspect         = $row['Aspect'];

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
    echo "<img src = 'empty.png' alt='No Result' />";
}
?>