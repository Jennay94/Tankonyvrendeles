<?php

include('session_check.php');
// Kapcsolat létrehozása az adatbázissal
$servername = "localhost";
$username = "root";
$password = ""; // XAMPP alapértelmezett jelszó
$dbname = "tankonyvrendeles";

$conn = new mysqli($servername, $username, $password, $dbname);

// Hibakezelés
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Oldalszám kezelés a lapozáshoz
$diakPage = isset($_GET['diakPage']) ? (int) $_GET['diakPage'] : 1;
$tkPage = isset($_GET['tkPage']) ? (int) $_GET['tkPage'] : 1;
$rendelesPage = isset($_GET['rendelesPage']) ? (int) $_GET['rendelesPage'] : 1;

// Lapozás mérete (rekordok száma oldalanként)
$diakRecordsPerPage = 20;
$tkRecordsPerPage = 20;
$rendelesRecordsPerPage = 20;

// Offsetek kiszámítása
$diakOffset = ($diakPage - 1) * $diakRecordsPerPage;
$tkOffset = ($tkPage - 1) * $tkRecordsPerPage;
$rendelesOffset = ($rendelesPage - 1) * $rendelesRecordsPerPage;

// Diákok lekérdezése
$sqlDiak = "SELECT * FROM diak LIMIT $diakOffset, $diakRecordsPerPage";
$resultDiak = $conn->query($sqlDiak);

// Tankönyvek lekérdezése
$sqlTk = "SELECT * FROM tk LIMIT $tkOffset, $tkRecordsPerPage";
$resultTk = $conn->query($sqlTk);

// Tankönyvek lekérdezése a dropdown listához
$sqlTkDropdown = "SELECT tkaz, cim, ertek FROM tkar";
$resultTkDropdown = $conn->query($sqlTkDropdown);

// Rendelések lekérdezése
$sqlRendeles = "SELECT r.ev, r.diakaz, r.tkaz, r.ingyenes, d.nev AS diak_nev, d.osztaly, t.cim, t.targy 
                FROM rendeles r
                JOIN diak d ON r.diakaz = d.az
                JOIN tk t ON r.tkaz = t.az
                LIMIT $rendelesOffset, $rendelesRecordsPerPage";
$resultRendeles = $conn->query($sqlRendeles);

// Összes rekord számok lekérdezése
$totalDiak = $conn->query("SELECT COUNT(*) AS total FROM diak")->fetch_assoc()['total'];
$totalDiakPages = ceil($totalDiak / $diakRecordsPerPage);

$totalTk = $conn->query("SELECT COUNT(*) AS total FROM tk")->fetch_assoc()['total'];
$totalTkPages = ceil($totalTk / $tkRecordsPerPage);

$totalRendeles = $conn->query("SELECT COUNT(*) AS total FROM rendeles")->fetch_assoc()['total'];
$totalRendelesPages = ceil($totalRendeles / $rendelesRecordsPerPage);

// Következő rendelési azonosító lekérdezése
$sqlLastRendelesId = "SELECT MAX(az) AS last_id FROM rendeles";
$lastRendelesId = $conn->query($sqlLastRendelesId)->fetch_assoc()['last_id'];
$newRendelesId = $lastRendelesId + 1;

// Rendelés hozzáadása
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diakAz = $_POST['diakaz'];
    $tkAz = $_POST['tkaz'];
    $ev = $_POST['ev'];
    $ingyenes = isset($_POST['ingyenes']) ? 1 : 0;

    $sql = "INSERT INTO rendeles (az, diakaz, tkaz, ev, ingyenes) VALUES ('$newRendelesId', '$diakAz', '$tkAz', '$ev', '$ingyenes')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Sikeres rendelés!</div>";
    } else {
        echo "<div class='alert alert-danger'>Hiba: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tankönyvrendelés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h1 class="text-center">Tankönyvrendelés</h1>

        <!-- Rendelés hozzáadása -->
        <div class="card my-4">
            <div class="card-header">Új rendelés</div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="rendelesAz" class="form-label">Rendelés azonosító:</label>
                        <input type="text" id="rendelesAz" name="rendelesAz" class="form-control"
                            value="<?= htmlspecialchars($newRendelesId) ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="diakaz" class="form-label">Diák azonosító:</label>
                        <input type="text" id="diakaz" name="diakaz" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="tkaz" class="form-label">Tankönyv:</label>
                        <select id="tkaz" name="tkaz" class="form-select" required>
                            <option value="">Válassz egy tankönyvet</option>
                            <?php if ($resultTkDropdown->num_rows > 0): ?>
                                <?php while ($row = $resultTkDropdown->fetch_assoc()): ?>
                                    <option value="<?= htmlspecialchars($row['tkaz']) ?>">
                                        <?= htmlspecialchars($row['cim']) ?> - <?= htmlspecialchars($row['ertek']) ?> Ft
                                    </option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="">Nincsenek elérhető tankönyvek</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ev" class="form-label">Év:</label>
                        <input type="number" id="ev" name="ev" class="form-control" required>
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" id="ingyenes" name="ingyenes" class="form-check-input">
                        <label for="ingyenes" class="form-check-label">Ingyenes</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Rendelés hozzáadása</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>