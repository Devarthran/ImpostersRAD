<?php

$conn = new mysqli("localhost", "root", "", "smt_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $optionQuery = "SELECT DISTINCT `Rating` FROM `movies`";

    echo "<option value=''>Any</option>";
if ($result = $conn->query($optionQuery)) {
    while ($row = $result->fetch_assoc()) {
        $option = $row['Rating'];
        $selected = "";
        if ($option == $rating) {
            $selected = "selected=''";
        }
        echo "<option value='". $option ."'".$selected.">". $option ."</option>";
    }
}
?>
