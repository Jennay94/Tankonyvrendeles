<?php
// Adatbázis kapcsolat
require_once('db.php');

$diakaz = $_GET['diakaz'] ?? '';
$ev = $_GET['ev'] ?? '';

// Tárgyak lekérdezése adott diákhoz és évhez
$tk_query = "
    SELECT tk.az, tk.cim
    FROM tk
    JOIN rendeles ON tk.az = rendeles.tkaz
    WHERE rendeles.diakaz = :diakaz AND rendeles.ev = :ev
    GROUP BY tk.az, tk.cim
";
$tk_stmt = $pdo->prepare($tk_query);
$tk_stmt->bindParam(':diakaz', $diakaz, PDO::PARAM_INT);
$tk_stmt->bindParam(':ev', $ev, PDO::PARAM_INT);
$tk_stmt->execute();
$targyak = $tk_stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($targyak); // JSON válasz vissza
?>