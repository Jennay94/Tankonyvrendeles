<?php
header('Content-Type: application/json; charset=utf-8');

// Az adatbázis kapcsolat betöltése
require_once 'db.php';

// HTTP metódus meghatározása
$method = $_SERVER['REQUEST_METHOD'];

// API útvonal kezelése
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$resource = $request[0] ?? null;
$id = $request[1] ?? null;

// Csak a "diak" erőforrásra vonatkozó kéréseket kezeljük
if ($resource !== 'diak') {
    http_response_code(404);
    echo json_encode(["error" => "Resource not found"], JSON_UNESCAPED_UNICODE);
    exit;
}

// Get kérések
if ($method === 'GET') {
    if ($id) {
        // Egyetlen diák lekérése
        $stmt = $pdo->prepare("SELECT * FROM diak WHERE az = :id");
        $stmt->execute(['id' => $id]);
        $diak = $stmt->fetch();

        if ($diak) {
            echo json_encode($diak, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Diák nem található"], JSON_UNESCAPED_UNICODE);
        }
    } else {
        // Összes diák lekérése
        $stmt = $pdo->query("SELECT * FROM diak");
        $diakok = $stmt->fetchAll();
        echo json_encode($diakok, JSON_UNESCAPED_UNICODE);
    }
} elseif ($method === 'POST') {
    // Új diák létrehozása
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['nev'], $data['osztaly'])) {
        $stmt = $pdo->prepare("INSERT INTO diak (nev, osztaly) VALUES (:nev, :osztaly)");
        $stmt->execute([
            'nev' => $data['nev'],
            'osztaly' => $data['osztaly']
        ]);

        http_response_code(201);
        echo json_encode(["message" => "Diák sikeresen létrehozva"], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Hiányzó adatok"], JSON_UNESCAPED_UNICODE);
    }
} elseif ($method === 'PUT') {
    // Létező diák frissítése
    if (!$id) {
        http_response_code(400);
        echo json_encode(["error" => "Hiányzó ID"], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['nev'], $data['osztaly'])) {
        $stmt = $pdo->prepare("UPDATE diak SET nev = :nev, osztaly = :osztaly WHERE az = :id");
        $stmt->execute([
            'id' => $id,
            'nev' => $data['nev'],
            'osztaly' => $data['osztaly']
        ]);

        echo json_encode(["message" => "Diák sikeresen frissítve"], JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(400);
        echo json_encode(["error" => "Hiányzó adatok"], JSON_UNESCAPED_UNICODE);
    }
} elseif ($method === 'DELETE') {
    // Diák törlése
    if (!$id) {
        http_response_code(400);
        echo json_encode(["error" => "Hiányzó ID"], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM diak WHERE az = :id");
    $stmt->execute(['id' => $id]);

    echo json_encode(["message" => "Diák sikeresen törölve"], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Metódus nem engedélyezett"], JSON_UNESCAPED_UNICODE);
}
