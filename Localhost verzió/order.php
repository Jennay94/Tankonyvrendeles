<?php
// Az adatbázis kapcsolat betöltése
require 'db.php';  // Győződj meg róla, hogy a fájl elérési útja helyes
include 'session_check.php';
include 'head.php';
// Tankönyvek lekérdezése a dropdownhoz
$tkQuery = "SELECT az, cim FROM tk";
$tkResult = $pdo->query($tkQuery);

// Ha a formot elküldik
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form adatok begyűjtése
    $diakaz = $_POST['diakaz'];
    $ev = $_POST['ev'];
    $tkaz = $_POST['tkaz'];
    $ingyenes = $_POST['ingyenes'];

    try {
        // Új rendelés beszúrása a `rendeles` táblába
        $insertQuery = "INSERT INTO rendeles (EV, TKAZ, diakaz, ingyenes) 
                        VALUES (:ev, :tkaz, :diakaz, :ingyenes)";
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([
            ':ev' => $ev,
            ':tkaz' => $tkaz,
            ':diakaz' => $diakaz,
            ':ingyenes' => $ingyenes
        ]);

        echo '<div class="alert alert-success text-center mt-3" role="alert">';
        echo 'A rendelés sikeresen rögzítve!';
        echo '</div>';
    } catch (PDOException $e) {
        echo "Hiba a rendelés rögzítésekor: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rendelés</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="margin-top: 8rem">

    <div class="container mt-5">
        <h2>Rendelés Form</h2>

        <!-- Rendelés form -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="diakaz">Diák azonosító</label>
                <input type="text" class="form-control" id="diakaz" name="diakaz" required>
            </div>

            <div class="form-group">
                <label for="tkaz">Tankönyv</label>
                <select class="form-control" id="tkaz" name="tkaz" required>
                    <?php
                    // Tankönyvek kiírása a legördülő listába
                    while ($row = $tkResult->fetch()) {
                        echo "<option value='{$row['az']}'>{$row['cim']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ev">Év</label>
                <input type="text" class="form-control" id="ev" name="ev" required>
            </div>

            <div class="form-group">
                <label for="ingyenes">Ingyenes</label><br>
                <input type="radio" id="ingyenes1" name="ingyenes" value="1">
                <label for="ingyenes1">Igen</label><br>
                <input type="radio" id="ingyenes0" name="ingyenes" value="0" checked>
                <label for="ingyenes0">Nem</label>
            </div>

            <button type="submit" class="btn btn-primary">Rendelés Felvétele</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>