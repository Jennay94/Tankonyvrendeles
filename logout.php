<?php
session_start(); // Munkamenet indítása

// Minden munkamenet változó törlése
$_SESSION = [];

// Munkamenet sütik törlése (ha használatban vannak)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Munkamenet teljes megsemmisítése
session_destroy();

// Átirányítás a bejelentkezési oldalra vagy a kezdőlapra
header("Location: index.php");
exit;
