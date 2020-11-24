<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Acme Entertainment</title>
        <meta name="description" content="">
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <link rel="stylesheet" href="css/reset.css?v=1.1<?php echo time(); ?>">
        <link rel="stylesheet" href="css/style.css?v=1.1<?php echo time(); ?>">
    </head>
    <body>
        <div class="master-nav-wrapper">
            <nav class="master-nav">
                <a class="brand" href="index.php">AE</a>
                
                <ul class="nav-links">
                    <li><a class="nav-link" href="Search.php">Search Movies</a></li>
                    <li><a class="nav-link" href="top10.php">Top 10 Movies</a></li>
                    <li><a class="nav-link" href="signup.php">Newsletter</a></li>
                    <?php 
                    if (isset($_SESSION['adminName'])) {
                        // 
                        echo "  <li><a class='nav-link' href='admin.php'>Admin</a></li>";
                        echo "  <li><a class='nav-link' href='includes/logout.inc.php'>Logout</a></li>";
                    }
                    else {
                        echo "  <li><a class='nav-link' href='login.php'>Login</a></li>";
                    }
                    ?>
                </ul>
            </nav>
        </div>

        <div class="content-wrapper">

