<?php
include('session_check.php');
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


<?php include 'head.php'; ?>

<body style="margin-top: 8rem;">

    <div class="container mt-5">
        <h1 class="text-center mb-4">Restful API Kliens</h1>

        <!-- GET ALL -->
        <form method="POST" class="mb-3">
            <h3>GET - Összes diák lekérése</h3>
            <input type="hidden" name="action" value="GET_ALL">
            <button type="submit" class="btn btn-primary w-30">Lekérés</button>
        </form>

        <!-- GET ONE -->
        <form method="POST" class="mb-3">
            <h3>GET - Egy diák lekérése</h3>
            <div class="mb-3">
                <label for="id" class="form-label">Diák ID</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <input type="hidden" name="action" value="GET_ONE">
            <button type="submit" class="btn btn-primary w-30">Lekérés</button>
        </form>

        <!-- POST -->
        <form method="POST" class="mb-3">
            <h3>POST - Új diák hozzáadása</h3>
            <div class="mb-3">
                <label for="nev" class="form-label">Név</label>
                <input type="text" class="form-control" id="nev" name="nev" required>
            </div>
            <div class="mb-3">
                <label for="osztaly" class="form-label">Osztály</label>
                <input type="text" class="form-control" id="osztaly" name="osztaly" required>
            </div>
            <input type="hidden" name="action" value="POST">
            <button type="submit" class="btn btn-primary w-30">Hozzáadás</button>
        </form>

        <!-- PUT -->
        <form method="POST" class="mb-3">
            <h3>PUT - Diák frissítése</h3>
            <div class="mb-3">
                <label for="id" class="form-label">Diák ID</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <div class="mb-3">
                <label for="nev" class="form-label">Név</label>
                <input type="text" class="form-control" id="nev" name="nev" required>
            </div>
            <div class="mb-3">
                <label for="osztaly" class="form-label">Osztály</label>
                <input type="text" class="form-control" id="osztaly" name="osztaly" required>
            </div>
            <input type="hidden" name="action" value="PUT">
            <button type="submit" class="btn btn-primary w-30">Frissítés</button>
        </form>

        <!-- DELETE -->
        <form method="POST" class="mb-3">
            <h3>DELETE - Diák törlése</h3>
            <div class="mb-3">
                <label for="id" class="form-label">Diák ID</label>
                <input type="text" class="form-control" id="id" name="id" required>
            </div>
            <input type="hidden" name="action" value="DELETE">
            <button type="submit" class="btn btn-primary w-30">Törlés</button>
        </form>

        <!-- Eredmény -->
        <h2 class="mt-4">Válasz</h2>
        <div class="alert alert-light">
            <pre><?php echo htmlspecialchars($response); ?></pre>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
</body>

</html>