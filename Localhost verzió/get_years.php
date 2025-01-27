<?php
// Adatbázis kapcsolat
require_once('db.php');

$diakaz = $_GET['diakaz'] ?? '';

// Év lekérdezése adott diákhoz
$ev_query = "
    SELECT DISTINCT ev
    FROM rendeles
    WHERE diakaz = :diakaz
    ORDER BY ev
";
$ev_stmt = $pdo->prepare($ev_query);
$ev_stmt->bindParam(':diakaz', $diakaz, PDO::PARAM_INT);
$ev_stmt->execute();
$ev_list = $ev_stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($ev_list); // JSON válasz vissza
?>