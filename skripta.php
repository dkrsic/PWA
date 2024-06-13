<?php
include 'connect.php'; 
header('Content-Type: text/html; charset=utf-8');

$servername = "localhost";
$username = "root";
$password = "root";
$basename = "pwa";
$port = 3307; 
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $dbc = new mysqli($servername, $username, $password, $basename, $port);
    mysqli_set_charset($dbc, "utf8");
} catch (mysqli_sql_exception $e) {
    echo "Error connecting to MySQL server: " . $e->getMessage();
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['naslov']);
    $about = htmlspecialchars($_POST['sazetak']);
    $content = htmlspecialchars($_POST['tekst']);
    $category = htmlspecialchars($_POST['kategorija']);
    $archive = isset($_POST['arhiva']) ? 1 : 0;

    $upload_dir = 'uploads/';
    $uploaded_file = $upload_dir . basename($_FILES['slika']['name']);

    if (move_uploaded_file($_FILES['slika']['tmp_name'], $uploaded_file)) {
        $pphoto = $uploaded_file;
    } else {
        $pphoto = null;
    }

    $query = "INSERT INTO Vijesti (title, about, content, photo, category, archive) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dbc->prepare($query);
    $stmt->bind_param("sssssi", $title, $about, $content, $pphoto, $category, $archive);
    $stmt->execute();

    echo "<h3>Naslov: $title</h3>";
    echo "<p><strong>Kratki sadržaj:</strong> $about</p>";
    echo "<p><strong>Sadržaj:</strong> $content</p>";
    echo "<p><strong>Kategorija:</strong> $category</p>";
    echo "<p><strong>Spremiti u arhivu:</strong> " . ($archive ? 'Da' : 'Ne') . "</p>";
    if ($pphoto) {
        echo "<p><strong>Slika:</strong><br><img src='$pphoto' alt='Slika vijesti' width='300'></p>";
    }
}

$dbc->close();
?>


