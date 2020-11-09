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
    <link href="style.css?v=1.1<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <!--Includes Navigation bar -->
    <?php
    $nav = 'mainNavBar.php';
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
            $query = "   SELECT * 
                            FROM movies 
                            WHERE num_searched > 0
                            ORDER BY num_searched DESC
                            LIMIT 10";

            // Prepares and executes the 
            $stmt = $conn->prepare($query);
            $stmt->execute();
            $a = 0;
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

                    $movies[$a] = $row['ID'];
                    $stats[$a] = $row['num_searched'];
                    $a += 1;

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
    <?php
    $max = 0;
    for ($i = 0; $i < 10; $i++) {
        if ($max < $stats[$i]) {
            $max = $stats[$i];
        }
    }

    // Round up the number to the next multiple of 5
    $max = round($max, -3);

    // Determine image dimensions
    $imageWidth = 850;
    $imageHeight = 450;

    // Determine the grid dimensions and placement within the image
    $gridTop = 40;
    $gridLeft = 70;
    $gridBottom = 400;
    $gridRight = 800;
    $gridHeight = $gridBottom - $gridTop;
    $gridWidth = $gridRight - $gridLeft;

    // Determine the line and bar width
    $lineWidth = 1;
    $barWidth = 40;

    // Determine the font and font size
    $font = getcwd() . '\Solway-Regular.ttf';
    $fontSize = 18;

    // Determine margin between label and axis
    $labelMargin = 10;

    // Determine maximum value on the y-axis which is the maximum occurrence from before
    $yMaxValue = $max;

    // Determine the distance between grid lines on the y-axis
    $yLabelSpan = 1000;

    // Init image
    $chart = imagecreate($imageWidth, $imageHeight);

    // Determine the colors
    $backgroundColor = imagecolorallocate($chart, 255, 255, 255);
    $axisColor = imagecolorallocate($chart, 26, 29, 58);
    $labelColor = $axisColor;
    $gridColor = imagecolorallocate($chart, 212, 212, 212);
    // $barColor = imagecolorallocate($chart, 174, 98, 95);
    $barColor = imagecolorallocate($chart, 121, 68, 66);

    imagefill($chart, 0, 0, $backgroundColor);

    imagesetthickness($chart, $lineWidth);

    // Print the grid lines
    for ($i = 0; $i <= $yMaxValue; $i += $yLabelSpan) {
        $y = $gridBottom - $i * $gridHeight / $yMaxValue;

        // Draw the line
        imageline($chart, $gridLeft, $y, $gridRight, $y, $gridColor);

        // Draw right aligned label
        $labelBox = imagettfbbox($fontSize, 0, $font, strval($i));
        $labelWidth = $labelBox[4] - $labelBox[0];

        $labelX = $gridLeft - $labelWidth - $labelMargin;
        $labelY = $y + $fontSize / 2;

        imagettftext($chart, $fontSize, 0, $labelX, $labelY, $labelColor, $font, strval($i));
    }

    // Draw x-axis and y-axis
    imageline($chart, $gridLeft, $gridTop, $gridLeft, $gridBottom, $axisColor);
    imageline($chart, $gridLeft, $gridBottom, $gridRight, $gridBottom, $axisColor);

    // Draw bars with labels
    $barSpacing = $gridWidth / count($stats);
    $itemX = $gridLeft + $barSpacing / 2;

    foreach ($stats as $key => $value) {
        // Draw bars
        $x1 = $itemX - $barWidth / 2;
        $y1 = $gridBottom - $value / $yMaxValue * $gridHeight;
        $x2 = $itemX + $barWidth / 2;
        $y2 = $gridBottom - 1;

        imagefilledrectangle($chart, $x1, $y1, $x2, $y2, $barColor);

        // Draw labels
        $labelBox = imagettfbbox($fontSize, 0, $font, $key);
        $labelWidth = $labelBox[4] - $labelBox[0];

        $labelX = $itemX - $labelWidth / 2;
        $labelY = $gridBottom + $labelMargin + $fontSize;

        imagettftext($chart, $fontSize, 0, $labelX, $labelY, $labelColor, $font, ($movies[$key]));

        $itemX += $barSpacing;
    }

    // Print image
    imagepng($chart, "statistic.png", 9);
    imagedestroy($chart);
    echo "<img id='chart' src='statistic.png'>";
    echo '<br><br>';

    ?>

    <!-- Includes footer -->
    <?php
    $footer = 'footer.php';
    require_once $footer;
    ?>
</body>

</html>