<?php
include 'connect.php';

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors = array();

    $title = isset($_POST['naslov']) ? test_input($_POST['naslov']) : '';
    $about = isset($_POST['sazetak']) ? test_input($_POST['sazetak']) : '';
    $content = isset($_POST['tekst']) ? test_input($_POST['tekst']) : '';
    $category = isset($_POST['kategorija']) ? test_input($_POST['kategorija']) : '';
    $date = date('d.m.Y.');
    $archive = isset($_POST['arhiva']) ? 1 : 0;
    

    if (empty($title) || strlen($title) < 5 || strlen($title) > 30) {
        $errors[] = 'Naslov vijesti mora imati između 5 i 30 znakova!';
    }
    if (empty($about) || strlen($about) < 10 || strlen($about) > 50) {
        $errors[] = 'Kratki sadržaj mora imati između 10 i 50 znakova!';
    }
    if (empty($content)) {
        $errors[] = 'Sadržaj mora biti unesen!';
    }
    if (empty($category)) {
        $errors[] = 'Kategorija mora biti odabrana!';
    }
    if (empty($_FILES['pphoto']['name'])) {
        $errors[] = 'Slika mora biti unesena!';
    } else {
        $picture = uniqid() . '_' . $_FILES['pphoto']['name'];
        $target_dir = 'uploads/' . $picture;
        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_dir);
    }

    if (empty($errors)) {
        $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva) VALUES ('$date', '$title', '$about', '$content', '$picture', '$category', '$archive')";
        $result = mysqli_query($dbc, $query) or die('Error querying databese.');
        mysqli_close($dbc);
        header('Location: unos.php'); 
        exit();
    } else {
      
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
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
    <title>Unos vijesti</title>
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
        <form action="unos.php" method="POST" enctype="multipart/form-data" id="newsForm">
            <div class="form-item">
                <label for="naslov">Naslov vijesti:</label>
                <input type="text" name="naslov" id="naslov">
                <span id="porukaNaslov" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                <label for="sazetak">Kratki sadržaj vijesti (do 50 znakova):</label>
                <textarea name="sazetak" id="sazetak" cols="30" rows="10"></textarea>
                <span id="porukaSazetak" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                <label for="tekst">Sadržaj vijesti:</label>
                <textarea name="tekst" id="tekst" cols="30" rows="10"></textarea>
                <span id="porukaTekst" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                <label for="pphoto">Slika:</label>
                <input type="file" name="pphoto" id="pphoto">
                <span id="porukaSlika" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                <label for="kategorija">Kategorija vijesti:</label>
                <select name="kategorija" id="kategorija">
                    <option value="">Odaberi kategoriju</option>
                    <option value="politika">Politika</option>
                    <option value="sport">Sport</option>
                </select>
                <span id="porukaKategorija" class="bojaPoruke"></span>
            </div>
            <div class="form-item">
                <label for="arhiva">Spremiti u arhivu:</label>
                <input type="checkbox" name="arhiva" id="arhiva">
            </div>
            <div class="form-item">
                <button type="submit" id="slanje">Pošalji</button>
            </div>
        </form>
    </main>
    <footer>
        <h1>Frankfurter Allgemeine</h1>
    </footer>

    <script type="text/javascript">
        document.getElementById("slanje").onclick = function(event) {
            var slanjeForme = true;

            
            var poljeNaslov = document.getElementById("naslov");
            var naslov = poljeNaslov.value;
            if (naslov.length < 5 || naslov.length > 30) {
                slanjeForme = false;
                poljeNaslov.style.border = "1px dashed red";
                document.getElementById("porukaNaslov").innerHTML = "Naslov vijesti mora imati između 5 i 30 znakova!<br>";
            } else {
                poljeNaslov.style.border = "1px solid green";
                document.getElementById("porukaNaslov").innerHTML = "";
            }

            var poljeSazetak = document.getElementById("sazetak");
            var sazetak = poljeSazetak.value;
            if (sazetak.length < 10 || sazetak.length > 50) {
                slanjeForme = false;
                poljeSazetak.style.border = "1px dashed red";
                document.getElementById("porukaSazetak").innerHTML = "Kratki sadržaj mora imati između 10 i 50 znakova!<br>";
            } else {
                poljeSazetak.style.border = "1px solid green";
                document.getElementById("porukaSazetak").innerHTML = "";
            }

            var poljeTekst = document.getElementById("tekst");
            var tekst = poljeTekst.value;
            if (tekst.length == 0) {
                slanjeForme = false;
                poljeTekst.style.border = "1px dashed red";
                document.getElementById("porukaTekst").innerHTML = "Sadržaj mora biti unesen!<br>";
            } else {
                poljeTekst.style.border = "1px solid green";
                document.getElementById("porukaTekst").innerHTML = "";
            }

      
            var poljeSlika = document.getElementById("pphoto");
            var pphoto = poljeSlika.value;
            if (pphoto.length == 0) {
                slanjeForme = false;
                poljeSlika.style.border = "1px dashed red";
                document.getElementById("porukaSlika").innerHTML = "Slika mora biti unesena!<br>";
            } else {
                poljeSlika.style.border = "1px solid green";
                document.getElementById("porukaSlika").innerHTML = "";
            }

       
            var poljeCategory = document.getElementById("kategorija");
            if (poljeCategory.selectedIndex == 0) {
                slanjeForme = false;
                poljeCategory.style.border = "1px dashed red";
                document.getElementById("porukaKategorija").innerHTML = "Kategorija mora biti odabrana!<br>";
            } else {
                poljeCategory.style.border = "1px solid green";
                document.getElementById("porukaKategorija").innerHTML = "";
            }

            if (slanjeForme != true) {
                event.preventDefault();
            }
        };
    </script>
</body>
</html>


