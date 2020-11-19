<?php 

require_once 'includes/dbh.inc.php';
require_once 'adminFunctions.inc.php';

$users = getUsers($conn);

while ($row = mysqli_fetch_assoc($users)) {

    $newsletter = ($row['usersNewsletter'] === 1) ? 'true' : 'false';
    $notifications = ($row['usersNotifications'] === 1) ? 'true' : 'false';
    $verified = ($row['is_verified'] === 1) ? 'true' : 'false';

    echo "<tr>";
    echo "<td>".$row['usersId']."</td>";
    echo "<td>".$row['usersName']."</td>";
    echo "<td>".$row['usersEmail']."</td>";
    echo "<td>".$newsletter."</td>";
    echo "<td>".$notifications."</td>";
    echo "<td>".$verified."</td>";
    echo "  <td><button class='btnDelUser' type='submit' id='".$row['usersId']."'>Delete?</button></td>";
    echo "</tr>";
}