<!-- Begins a session. -->
<?php
session_start();
?>
<!-- Boilerplate HTML code. -->
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Acme Entertainment</title>
    <meta name="description" content="The Acme Entertainment movie database">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font awesome library for star icons. -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS reset sheet to prevent default formatting followe by website stylesheet. -->
    <link rel="stylesheet" href="css/reset.css?v=1.1<?php echo time(); ?>">
    <link rel="stylesheet" href="css/style.css?v=1.1<?php echo time(); ?>">
</head> 

<body>
    <!-- Main Navigation bar -->
    <div class="master-nav-wrapper">
        <nav class="master-nav">
            <a class="brand" href="index.php" aria-label="Acme Entertainment">AE</a>
            <!-- Nav links to site pages. -->
            <ul class="nav-links">
                <li><a class="nav-link" href="Search.php">Search Movies</a></li>
                <li><a class="nav-link" href="adv_search.php">Adv. Search</a></li>
                <li><a class="nav-link" href="top10.php">Top 10 Movies</a></li>
                <li><a class="nav-link" href="signup.php">Newsletter</a></li>
                <?php
                if (isset($_SESSION['adminName'])) {
                    // Creates links to admin.php and creates the logout button when logged in.
                    echo "  <li><a class='nav-link' href='admin.php'>Admin</a></li>";
                    echo "  <li><a class='nav-link' href='includes/logout.inc.php'>Logout</a></li>";
                } else {
                    // Else creates the login button
                    echo "  <li><a class='nav-link' href='login.php'>Login</a></li>";
                }
                ?>
            </ul>
        </nav>
    </div>

    <main class="content-wrapper">