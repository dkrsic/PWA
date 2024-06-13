<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registracija - Frankfurter Allgemeine</title>
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
        <?php
        session_start();
        include 'connect.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registracija'])) {
            $ime = $_POST['ime'];
            $prezime = $_POST['prezime'];
            $korisnicko_ime = $_POST['korisnicko_ime'];
            $lozinka = $_POST['lozinka'];
            $razina = $_POST['razina'];

            if (!empty($ime) && !empty($prezime) && !empty($korisnicko_ime) && !empty($lozinka) && isset($razina)) {
                $hashed_password = password_hash($lozinka, PASSWORD_DEFAULT);

                $query = $dbc->prepare("INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina) VALUES (?, ?, ?, ?, ?)");
                $query->bind_param('ssssi', $ime, $prezime, $korisnicko_ime, $hashed_password, $razina);
                if ($query->execute()) {
                    echo "<p>Registracija uspješna!</p>";
                } else {
                    echo "<p>Greška: " . $dbc->error . "</p>";
                }
            } else {
                echo "<p>Sva polja su obavezna!</p>";
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prijava'])) {
            $korisnicko_ime = $_POST['login_korisnicko_ime'];
            $lozinka = $_POST['login_lozinka'];

            if (!empty($korisnicko_ime) && !empty($lozinka)) {
                $query = $dbc->prepare("SELECT id, ime, prezime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?");
                $query->bind_param('s', $korisnicko_ime);
                $query->execute();
                $query->store_result();
                $query->bind_result($id, $ime, $prezime, $hashed_password, $razina);

                if ($query->num_rows > 0) {
                    $query->fetch();
                    if (password_verify($lozinka, $hashed_password)) {
                        $_SESSION['user_id'] = $id;
                        $_SESSION['ime'] = $ime;
                        $_SESSION['razina'] = $razina;

                        if ($razina == 1) {
                            header("Location: administracija.php");
                            exit;
                        } else {
                            echo "<p>Dobrodošli, $ime! Nemate ovlasti za pristup administracijskoj stranici.</p>";
                        }
                    } else {
                        echo "<p>Neispravna lozinka. Molimo registrirajte se.</p>";
                        echo "<a href='registracija.php'>Registracija</a>";
                    }
                } else {
                    echo "<p>Korisničko ime ne postoji. Molimo registrirajte se.</p>";
                    echo "<a href='registracija.php'>Registracija</a>";
                }
            } else {
                echo "<p>Sva polja su obavezna!</p>";
            }
        }

        $dbc->close();
        ?>

        <h2>Registracija</h2>
        <form method="post" action="registracija.php">
            <label for="ime">Ime:</label>
            <input type="text" id="ime" name="ime"><br>
            <label for="prezime">Prezime:</label>
            <input type="text" id="prezime" name="prezime"><br>
            <label for="korisnicko_ime">Korisničko ime:</label>
            <input type="text" id="korisnicko_ime" name="korisnicko_ime"><br>
            <label for="lozinka">Lozinka:</label>
            <input type="password" id="lozinka" name="lozinka"><br>
            <label for="razina">Razina:</label>
            <select id="razina" name="razina">
                <option value="1">Admin</option>
                <option value="0">Obični korisnik</option>
            </select><br>
            <input type="submit" name="registracija" value="Registriraj se">
        </form>

        <h2>Prijava</h2>
        <form method="post" action="registracija.php">
            <label for="login_korisnicko_ime">Korisničko ime:</label>
            <input type="text" id="login_korisnicko_ime" name="login_korisnicko_ime"><br>
            <label for="login_lozinka">Lozinka:</label>
            <input type="password" id="login_lozinka" name="login_lozinka"><br>
            <input type="submit" name="prijava" value="Prijavi se">
        </form>
    </main>
    <footer>
        <h1>Frankfurter Allgemeine</h1>
    </footer>
</body>
</html>



