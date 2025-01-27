<?php
// Adatbázis kapcsolat
require_once('db.php');


$ev = $_GET['ev'] ?? 2024;
$tkaz = $_GET['tkaz'] ?? 1;

// Diákok lekérdezése az adott év és tárgy szerint
$diak_query = "
    SELECT Diak.az, Diak.nev
    FROM Diak
    JOIN rendeles ON Diak.az = rendeles.diakaz
    WHERE rendeles.ev = :ev AND rendeles.tkaz = :tkaz
";
$diak_stmt = $pdo->prepare($diak_query);
$diak_stmt->bindParam(':ev', $ev, PDO::PARAM_INT);
$diak_stmt->bindParam(':tkaz', $tkaz, PDO::PARAM_INT);
$diak_stmt->execute();
$diakok = $diak_stmt->fetchAll();

// Ellenőrizzük, hogy van-e eredmény
if (empty($diakok)) {
    echo "Nincs diák a megadott év és tárgy kombinációval.";
} else {
    // Diákok select listájának generálása
    $options = '';
    foreach ($diakok as $diak) {
        $options .= "<option value='{$diak['az']}'>{$diak['nev']}</option>";
    }
    echo $options; // Visszaadjuk a diákok listáját
}
?>