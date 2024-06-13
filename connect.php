<?php
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "root";
$basename = "pwa";
$port = 3307; 

// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Create connection
    $dbc = new mysqli($servername, $username, $password, $basename, $port);
    mysqli_set_charset($dbc, "utf8");
} catch (mysqli_sql_exception $e) {
    echo "Error connecting to MySQL server: " . $e->getMessage();
    exit();
}
?>
