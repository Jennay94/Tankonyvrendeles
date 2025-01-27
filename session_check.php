<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Adatbázis kapcsolat betöltése
include('db.php');
// Ellenőrizzük, hogy van-e bejelentkezve felhasználó
$user_rang = isset($_SESSION['user_rang']) ? $_SESSION['user_rang'] : null;
// Az aktuális oldal neve 
$current_page = basename($_SERVER['PHP_SELF']);
// Lekérdezzük az adatbázisból, hogy az oldalhoz milyen rang szükséges
$query = "SELECT rang FROM pages WHERE url = :url";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':url', $current_page);
$stmt->execute();

// Ha nem találunk ilyen oldalt
if ($stmt->rowCount() == 0) {
    // Ha az oldal nem létezik az adatbázisban
    header("Location: index.php");  // Átirányítás a főoldalra
    exit();
}

$page = $stmt->fetch(PDO::FETCH_ASSOC);

// Az oldal rangja
$page_rang = $page['rang'];

// Ha nincs bejelentkezve a felhasználó, vagy a felhasználó rangja kisebb, mint az oldal rangja
if ($user_rang === null || $user_rang < $page_rang) {
    // Ha a felhasználó nem jogosult az oldal elérésére, irányítsd át a főoldalra
    header("Location: index.php");
    exit();
}
?>