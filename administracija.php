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
                <li><a href="logout.php">Odlogiraj se</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="logout.php">Odlogiraj se</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <hr class="linija">
        <h1>Frankfurter Allgemeine</h1>
    </header>
    <main>
        <?php
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: registracija.php");
            exit;
        }
        
        if ($_SESSION['razina'] != 1) {
            echo "<p>Nemate ovlasti za pristup ovoj stranici.</p>";
            exit;
        }
        include 'connect.php';

        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $query = "DELETE FROM Vijesti WHERE id=$id";
            mysqli_query($dbc, $query) or die('Error querying database.');
        }

        if (isset($_POST['update'])) {
            $id = $_POST['id'];
            $title = $_POST['naslov'];
            $about = $_POST['sazetak'];
            $content = $_POST['tekst'];
            $category = $_POST['kategorija'];
            
            $query = "UPDATE Vijesti SET naslov='$title', sazetak='$about', tekst='$content', kategorija='$category' WHERE id=$id";
            mysqli_query($dbc, $query) or die('Error querying database.');
        }
        ?>

        <form method="post" action="">
            <h2>Brisanje vijesti</h2>
            <label for="delete-id">ID za brisanje:</label>
            <input type="text" id="delete-id" name="id"><br>
            <input type="submit" name="delete" value="Obriši">
        </form>

        <form method="post" action="">
            <h2>Uređivanje vijesti</h2>
            <label for="update-id">ID za uređivanje:</label>
            <input type="text" id="update-id" name="id"><br>
            <label for="naslov">Naslov:</label>
            <input type="text" id="naslov" name="naslov"><br>
            <label for="sazetak">Sažetak:</label>
            <input type="text" id="sazetak" name="sazetak"><br>
            <label for="tekst">Tekst:</label>
            <textarea id="tekst" name="tekst"></textarea><br>
            <label for="kategorija">Kategorija:</label>
            <input type="text" id="kategorija" name="kategorija"><br>
            <input type="submit" name="update" value="Ažuriraj">
        </form>
    </main>
    <footer>
        <h1>Frankfurter Allgemeine</h1>
    </footer>
</body>
</html>

<?php
mysqli_close($dbc);
?>



