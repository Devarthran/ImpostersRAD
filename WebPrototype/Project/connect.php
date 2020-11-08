<link href="myStyles.css?v=1.1<?php echo time(); ?>" rel="stylesheet" type="text/css" />
<?php
$username = 'root';
$password = '';
try {
    $conn = new PDO('mysql:host=localhost;dbname=movies', $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
?>
