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

// Rendelés hozzáadása
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diakAz = $_POST['diakaz'];
    $tkAz = $_POST['tkaz'];
    $ev = $_POST['ev'];
    $ingyenes = isset($_POST['ingyenes']) ? 1 : 0;

    $sql = "INSERT INTO rendeles (diakaz, tkaz, ev, ingyenes) VALUES ('$diakAz', '$tkAz', '$ev', '$ingyenes')";

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
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lekérjük az aktuális legnagyobb rendelés azonosítót
            $sqlLastOrder = "SELECT MAX(az) AS max_azonosito FROM rendeles";
            $resultLastOrder = $conn->query($sqlLastOrder);
            $nextOrderId = 1; // Ha nincs még rendelés, akkor kezdőérték 1
            if ($resultLastOrder->num_rows > 0) {
                $row = $resultLastOrder->fetch_assoc();
                $nextOrderId = $row['max_azonosito'] + 1;
            }

            // Az űrlap adatok beolvasása
            $diakaz = intval($_POST['diakaz']);
            $tkaz = intval($_POST['tkaz']);
            $ev = intval($_POST['ev']);
            $ingyenes = isset($_POST['ingyenes']) ? 1 : 0;

            // Rendelés mentése az adatbázisba
            $sqlInsert = "INSERT INTO rendeles (az, diakaz, tkaz, ev, ingyenes) 
                  VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sqlInsert);
            $stmt->bind_param("iiiii", $nextOrderId, $diakaz, $tkaz, $ev, $ingyenes);
            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>A rendelés sikeresen mentve! Azonosító: $nextOrderId</div>";
            } else {
                echo "<div class='alert alert-danger'>Hiba történt a rendelés mentésekor: " . $conn->error . "</div>";
            }
        }
        ?>

        <!-- Rendelés hozzáadása űrlap -->
        <div class="card my-4">
            <div class="card-header">Új rendelés</div>
            <div class="card-body">
                <form method="POST" action="">
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
                                        <?= htmlspecialchars($row['cim']) ?> -
                                        <?= isset($row['ertek']) ? htmlspecialchars($row['ertek']) . ' Ft' : 'Nincs ár' ?>
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



        <!-- Diákok listája -->
        <div class="card my-4">
            <div class="card-header">Diákok listája</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Azonosító</th>
                            <th>Név</th>
                            <th>Osztály</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultDiak->num_rows > 0): ?>
                            <?php while ($row = $resultDiak->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['az']) ?></td>
                                    <td><?= htmlspecialchars($row['nev']) ?></td>
                                    <td><?= htmlspecialchars($row['osztaly']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">Nincsenek diákok.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <?php
                        $range = 2; // Ennyi oldalt mutassunk az aktuális oldal körül
                        $start = max(1, $rendelesPage - $range);
                        $end = min($totalDiakPages, $rendelesPage + $range);

                        if ($start > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=<?= $tkPage ?>&rendelesPage=1">1</a>
                            </li>
                            <?php if ($start > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= ($i == $rendelesPage) ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=<?= $tkPage ?>&rendelesPage=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end < $totalDiakPages): ?>
                            <?php if ($end < $totalDiakPages - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=<?= $tkPage ?>&rendelesPage=<?= $totalDiakPages ?>"><?= $totalDiakPages ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            </div>
        </div>

        <!-- Tankönyvek listája -->
        <div class="card my-4">
            <div class="card-header">Tankönyvek listája</div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                    <?php if ($resultTk->num_rows > 0): ?>
                        <?php $bookIndex = 1; // A könyv indexének számozása ?>
                        <?php while ($row = $resultTk->fetch_assoc()): ?>
                            <div class="col">
                                <div class="card h-100">
                                    <img src="assets/img/books/book<?= $bookIndex ?>.jpg" class="card-img-top"
                                        alt="<?= htmlspecialchars($row['cim']) ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($row['cim']) ?></h5>
                                        <p class="card-text"><strong>Tantárgy:</strong> <?= htmlspecialchars($row['targy']) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php $bookIndex++; ?>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center">Nincsenek tankönyvek.</p>
                    <?php endif; ?>
                </div>
                <nav>
                    <ul class="pagination justify-content-center mt-4">
                        <?php
                        $range = 2; // Ennyi oldalt mutassunk az aktuális oldal körül
                        $start = max(1, $rendelesPage - $range);
                        $end = min($totalTkPages, $rendelesPage + $range);

                        if ($start > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=1&rendelesPage=<?= $rendelesPage ?>">1</a>
                            </li>
                            <?php if ($start > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= ($i == $tkPage) ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=<?= $i ?>&rendelesPage=<?= $rendelesPage ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end < $totalTkPages): ?>
                            <?php if ($end < $totalTkPages - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=<?= $totalTkPages ?>&rendelesPage=<?= $rendelesPage ?>"><?= $totalTkPages ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Rendelések listája -->
        <div class="card my-4">
            <div class="card-header">Rendelések</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Év</th>
                            <th>Diák neve</th>
                            <th>Osztály</th>
                            <th>Tankönyv címe</th>
                            <th>Tantárgy</th>
                            <th>Ingyenes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($resultRendeles->num_rows > 0): ?>
                            <?php while ($row = $resultRendeles->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['ev']) ?></td>
                                    <td><?= htmlspecialchars($row['diak_nev']) ?></td>
                                    <td><?= htmlspecialchars($row['osztaly']) ?></td>
                                    <td><?= htmlspecialchars($row['cim']) ?></td>
                                    <td><?= htmlspecialchars($row['targy']) ?></td>
                                    <td><?= $row['ingyenes'] ? 'Igen' : 'Nem' ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Nincsenek rendelési adatok.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <nav>
                    <ul class="pagination">
                        <?php
                        $range = 2; // Ennyi oldalt mutassunk az aktuális oldal körül
                        $start = max(1, $rendelesPage - $range);
                        $end = min($totalRendelesPages, $rendelesPage + $range);

                        if ($start > 1): ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=<?= $tkPage ?>&rendelesPage=1">1</a>
                            </li>
                            <?php if ($start > 2): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php for ($i = $start; $i <= $end; $i++): ?>
                            <li class="page-item <?= ($i == $rendelesPage) ? 'active' : '' ?>">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=<?= $tkPage ?>&rendelesPage=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <?php if ($end < $totalRendelesPages): ?>
                            <?php if ($end < $totalRendelesPages - 1): ?>
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a class="page-link"
                                    href="?diakPage=<?= $diakPage ?>&tkPage=<?= $tkPage ?>&rendelesPage=<?= $totalRendelesPages ?>"><?= $totalRendelesPages ?></a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>