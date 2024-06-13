<?php
session_start();
include 'connect.php';
define('UPLPATH', 'uploads/');
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frankfurter Allgemeine</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lugrasimo&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Početna</a></li>
                <li><a href="kategorija.php?category=politika">Politika</a></li>
                <li><a href="kategorija.php?category=sport">Sport</a></li>
                <li><a href="administracija.php">Administracija</a></li>
                <li><a href="unos.php">Unos</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Odlogiraj se</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <hr class="linija">
        <h1>Frankfurter Allgemeine</h1>
    </header>
    <main>
        <section class="grid">
            <div class="title-politik"><hr class="linija">Politika</div>
            <?php
        
            $query_politika = "SELECT * FROM Vijesti WHERE arhiva=0 AND kategorija='politika' ORDER BY datum DESC, id DESC LIMIT 1";
            $result_politika = mysqli_query($dbc, $query_politika);
            $row_politika = mysqli_fetch_array($result_politika);
        
            if ($row_politika) {
                echo '<article>';
                echo '<p><a href="clanak.php?id=' . $row_politika['id'] . '"><img src="' . UPLPATH . $row_politika['slika'] . '" alt="' . $row_politika['naslov'] . '" class="small-image"></a></p>';
                echo '<p>' . $row_politika['sazetak'] . '</p>';
                echo '<h3>' . $row_politika['naslov'] . '</h3>';
                $pos = strpos($row_politika['tekst'], '.', 200);
                if ($pos === false) {
                $limited_text = substr($row_politika['tekst'], 0, 200);
                } else {
                $limited_text = substr($row_politika['tekst'], 0, $pos + 1);
                }
                echo '<p>' . $limited_text . '</p>';
                echo '</article>';
            }

        
            $query_politika_ostalo = "SELECT * FROM Vijesti WHERE arhiva=0 AND kategorija='politika' AND id != {$row_politika['id']} ORDER BY datum DESC, id DESC LIMIT 2";
            $result_politika_ostalo = mysqli_query($dbc, $query_politika_ostalo);
            while ($row_politika_ostalo = mysqli_fetch_array($result_politika_ostalo)) {
                echo '<article>';
                echo '<p><a href="clanak.php?id=' . $row_politika_ostalo['id'] . '"><img src="' . UPLPATH . $row_politika_ostalo['slika'] . '" alt="' . $row_politika_ostalo['naslov'] . '" class="small-image"></a></p>';
                echo '<p>' . $row_politika_ostalo['sazetak'] . '</p>';
                echo '<h3>' . $row_politika_ostalo['naslov'] . '</h3>';
                $pos = strpos($row_politika['tekst'], '.', 200);
                if ($pos === false) {
                $limited_text = substr($row_politika_ostalo['tekst'], 0, 200);
                } else {
                $limited_text = substr($row_politika_ostalo['tekst'], 0, $pos + 1);
                }
                echo '<p>' . $limited_text . '</p>';
                echo '</article>';
            }
            ?>

            <div class="title-sport"><hr class="linija">Sport</div>
            <?php
      
            $query_sport = "SELECT * FROM Vijesti WHERE arhiva=0 AND kategorija='sport' ORDER BY datum DESC, id DESC LIMIT 1";
            $result_sport = mysqli_query($dbc, $query_sport);
            $row_sport = mysqli_fetch_array($result_sport);
           
            if ($row_sport) {
                echo '<article>';
                echo '<p><a href="clanak.php?id=' . $row_sport['id'] . '"><img src="' . UPLPATH . $row_sport['slika'] . '" alt="' . $row_sport['naslov'] . '" class="small-image"></a></p>';
                echo '<p>' . $row_sport['sazetak'] . '</p>';
                echo '<h3>' . $row_sport['naslov'] . '</h3>';
                $pos = strpos($row_sport['tekst'], '.', 200);
                if ($pos === false) {
                $limited_text = substr($row_sport['tekst'], 0, 200);
                } else {
                $limited_text = substr($row_sport['tekst'], 0, $pos + 1);
                }
                echo '<p>' . $limited_text . '</p>';
                echo '</article>';
            }

           
            $query_sport_ostalo = "SELECT * FROM Vijesti WHERE arhiva=0 AND kategorija='sport' AND id != {$row_sport['id']} ORDER BY datum DESC, id DESC LIMIT 2";
            $result_sport_ostalo = mysqli_query($dbc, $query_sport_ostalo);
            while ($row_sport_ostalo = mysqli_fetch_array($result_sport_ostalo)) {
                echo '<article>';
                echo '<p><a href="clanak.php?id=' . $row_sport_ostalo['id'] . '"><img src="' . UPLPATH . $row_sport_ostalo['slika'] . '" alt="' . $row_sport_ostalo['naslov'] . '" class="small-image"></a></p>';
                echo '<p>' . $row_sport_ostalo['sazetak'] . '</p>';
                echo '<h3>'. $row_sport_ostalo['naslov'] . '</h3>';
                $pos = strpos($row_sport_ostalo['tekst'], '.', 200);
                if ($pos === false) {
                $limited_text = substr($row_sport_ostalo['tekst'], 0, 200);
                } else {
                $limited_text = substr($row_sport_ostalo['tekst'], 0, $pos + 1);
                }
                echo '<p>' . $limited_text . '</p>';
                echo '</article>';
            }
            ?>
        </section>
    </main>
    <footer>
        <h1>Frankfurter Allgemeine</h1>
    </footer>
</body>
</html>



