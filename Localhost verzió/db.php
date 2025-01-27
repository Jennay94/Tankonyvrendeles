<?php
// Adatbázis konfiguráció
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tankonyvrendeles";

try {
    // PDO kapcsolat létrehozása
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);

    // Hiba kezelési mód beállítása
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Adatbázis-kapcsolódási hiba: " . $e->getMessage());
}
?>