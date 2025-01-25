<?php

// Függvény REST kérésekhez
function sendRequest($method, $url, $data = null)
{
    $ch = curl_init();

    // URL beállítása
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

    // Ha van adat (POST, PUT esetén)
    if ($data) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($data))
        ]);
    }

    // Válasz fogadása
    $response = curl_exec($ch);

    // Hibaellenőrzés
    if (curl_errno($ch)) {
        echo 'Hiba: ' . curl_error($ch);
    }

    curl_close($ch);
    return $response;
}

// Alap URL
$baseUrl = "http://localhost/tankonyvrendeles/restful_server.php/diak";

// Kérés feldolgozása
$response = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        switch ($action) {
            case 'GET_ALL':
                $response = sendRequest('GET', $baseUrl);
                break;

            case 'GET_ONE':
                $id = $_POST['id'] ?? '';
                $response = sendRequest('GET', "$baseUrl/$id");
                break;

            case 'POST':
                $data = [
                    'nev' => $_POST['nev'],
                    'osztaly' => $_POST['osztaly']
                ];
                $response = sendRequest('POST', $baseUrl, $data);
                break;

            case 'PUT':
                $id = $_POST['id'] ?? '';
                $data = [
                    'nev' => $_POST['nev'],
                    'osztaly' => $_POST['osztaly']
                ];
                $response = sendRequest('PUT', "$baseUrl/$id", $data);
                break;

            case 'DELETE':
                $id = $_POST['id'] ?? '';
                $response = sendRequest('DELETE', "$baseUrl/$id");
                break;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restful Kliens</title>
</head>

<body>
    <h1>Restful Kliens</h1>

    <!-- GET ALL -->
    <form method="POST">
        <h3>GET - Összes diák lekérése</h3>
        <input type="hidden" name="action" value="GET_ALL">
        <button type="submit">Lekérés</button>
    </form>

    <!-- GET ONE -->
    <form method="POST">
        <h3>GET - Egy diák lekérése</h3>
        <label>Diák ID: <input type="text" name="id" required></label>
        <input type="hidden" name="action" value="GET_ONE">
        <button type="submit">Lekérés</button>
    </form>

    <!-- POST -->
    <form method="POST">
        <h3>POST - Új diák hozzáadása</h3>
        <label>Név: <input type="text" name="nev" required></label><br>
        <label>Osztály: <input type="text" name="osztaly" required></label><br>
        <input type="hidden" name="action" value="POST">
        <button type="submit">Hozzáadás</button>
    </form>

    <!-- PUT -->
    <form method="POST">
        <h3>PUT - Diák frissítése</h3>
        <label>Diák ID: <input type="text" name="id" required></label><br>
        <label>Név: <input type="text" name="nev" required></label><br>
        <label>Osztály: <input type="text" name="osztaly" required></label><br>
        <input type="hidden" name="action" value="PUT">
        <button type="submit">Frissítés</button>
    </form>

    <!-- DELETE -->
    <form method="POST">
        <h3>DELETE - Diák törlése</h3>
        <label>Diák ID: <input type="text" name="id" required></label>
        <input type="hidden" name="action" value="DELETE">
        <button type="submit">Törlés</button>
    </form>

    <h2>Eredmény</h2>
    <pre><?php echo htmlspecialchars($response); ?></pre>
</body>

</html>