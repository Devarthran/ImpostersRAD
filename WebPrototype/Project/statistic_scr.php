<link href="myStyles.css?v=1.1<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<?php
require "connect.php";
// Query
$stmt = $conn->prepare(
    "SELECT MovieID, Title, Rating, Genre, Year, Statistic
    FROM movies_table
    ORDER BY Statistic DESC
    LIMIT 10"
);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
$number = 1;
$a = 0;

if ($result != null) {

    // Open table
    echo '<table class="table table-striped" id="outTableMovies">';
    // Table header
    echo "	<tr>
                <th>Number</th>
                <th>MovieID</th>
                <th>Title</th>
                <th>Rating</th>
                <th>Year</th>
                <th>Genre</th>
                <th>Statistic</th>
            </tr>";

    foreach ($result as $row) {
        $movieID        = $row['MovieID'];
        $title          = $row['Title'];
        $rating         = $row['Rating'];
        $year           = $row['Year'];
        $genre          = $row['Genre'];
        $statistic      = $row['Statistic'];

        echo "	<tr>
                    <td>$number</td>
				    <td>$movieID</td>
                    <td>$title</td>
                    <td>$rating</td>
                    <td>$year</td>
                    <td>$genre</td>
                    <td>$statistic</td>
                </tr>";

        $number += 1;
        $movies[$a] = $row['MovieID'];
        $stats[$a] = $row['Statistic'];
        $a += 1;
    }

    echo '</table>';

    // Check the maximum occurrence of a number
    $max = 0;
    for ($i = 0; $i < 10; $i++) {
        if ($max < $stats[$i]) {
            $max = $stats[$i];
        }
    }

    // Round up the number to the next multiple of 5
    $max = round($max,-3);

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
    $barColor = imagecolorallocate($chart, 47, 133, 217);

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
    echo "<img src = 'statistic.png'>";
}
?>