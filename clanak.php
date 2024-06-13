<?php
include 'connect.php';
define('UPLPATH', 'uploads/');

$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lugrasimo&display=swap" rel="stylesheet">
    <title>Članak</title>
</head>
<body>
    <header>
        <nav>
            <ul class="container">
                <li><a href="index.php">Home</a></li>
                <li><a href="kategorija.php?category=politika">Politika</a></li>
                <li><a href="kategorija.php?category=sport">Sport</a></li>
                <li><a href="administracija.php">Administracija</a></li>
                <li><a href="unos.php">Unos</a></li>
            </ul>
        </nav>
        <hr class="linija">
        <h1>Frankfurter Allgemeine</h1>
    </header>
    <main>
        <?php
       function pickerDateToMysql($pickerDate) {
        $pickerDate = trim($pickerDate, '.');
        
        $date = DateTime::createFromFormat('d.m.Y', $pickerDate);
        
        if ($date === false) {
            return 'Invalid date format';
        }
        
        return $date->format('d-m-Y');
    }
    
        $query = "SELECT * FROM Vijesti WHERE id=$id";
        $result = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($result);
        print '<div class="news">';
        print '<h2>' . htmlspecialchars($row['naslov']) . '</h2>';
        print '<time datetime="' . $row['datum'] . '">' . pickerDateToMysql($row['datum']) . '</time>';
        print '<p><img src="' . htmlspecialchars(UPLPATH . $row['slika']) . '" alt="' . htmlspecialchars($row['naslov']) . '" class="small-image"></p>';
        print '<p>' . htmlspecialchars($row['tekst']) . '</p>';
        print '</div>';
        mysqli_close($dbc);
        ?>
    </main>
    <footer>
        <h1>Frankfurter Allgemeine</h1>
    </footer>
</body>
</html>