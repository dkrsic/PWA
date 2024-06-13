<?php
include 'connect.php';
define('UPLPATH', 'uploads/');

$category = $_GET['category'];
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
    <title><?php echo ucfirst($category); ?> Vijesti</title>
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
        <h2 class="center"><?php echo ucfirst($category); ?></h2>
        <?php
        $query = "SELECT * FROM Vijesti WHERE arhiva=0 AND kategorija='$category'";
        $result = mysqli_query($dbc, $query);

        while ($row = mysqli_fetch_array($result)) {
            echo '<article>';
            echo '<p><a href="clanak.php?id=' . $row['id'] . '"><img src="' . UPLPATH . $row['slika'] . '" alt="' . $row['naslov'] . '" class="small-image"></a></p>';
            echo '<p>' . $row['sazetak'] . '</p>';
            echo '<h3>' . $row['naslov'] . '</h3>';
            echo '</article>';
        }

        mysqli_close($dbc);
        ?>
    </main>
    <footer>
        <h1>Frankfurter Allgemeine</h1>
    </footer>
</body>
</html>
