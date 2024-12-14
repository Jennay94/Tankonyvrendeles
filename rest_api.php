<?php
header('Content-Type: application/json; charset=utf-8');
// Adatbázis kapcsolat
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tankonyvrendeles";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf8");

// Ellenőrizd a kapcsolatot
if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// Módszer meghatározása (GET, POST, PUT, DELETE)
$method = $_SERVER['REQUEST_METHOD'];

// GET: Adatok lekérdezése
if ($method === 'GET') {
    $id = $_GET['id'] ?? null;

    if ($id) {
        // Egy adott rekord lekérése
        $sql = "SELECT * FROM diak WHERE az = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
    } else {
        // Összes rekord lekérése
        $sql = "SELECT * FROM diak";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    header('Content-Type: application/json');
    echo json_encode($data);
}

// POST: Új rekord hozzáadása
if ($method === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $sql = "INSERT INTO diak (nev, osztaly) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $input['nev'], $input['osztaly']);
    $stmt->execute();
    echo json_encode(['message' => 'Sikeresen hozzáadva', 'id' => $conn->insert_id]);
}

// PUT: Egy rekord frissítése
if ($method === 'PUT') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $input = json_decode(file_get_contents('php://input'), true);
        $sql = "UPDATE diak SET nev = ?, osztaly = ? WHERE az = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $input['nev'], $input['osztaly'], $id);
        $stmt->execute();
        echo json_encode(['message' => 'Sikeresen frissítve']);
    } else {
        echo json_encode(['error' => 'ID megadása kötelező']);
    }
}

// DELETE: Egy rekord törlése
if ($method === 'DELETE') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $sql = "DELETE FROM diak WHERE az = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo json_encode(['message' => 'Sikeresen törölve']);
    } else {
        echo json_encode(['error' => 'ID megadása kötelező']);
    }
}

// Kapcsolat bezárása
$conn->close();
?>
