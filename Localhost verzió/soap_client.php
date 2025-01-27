<?php
// SOAP Kliens
include('session_check.php');
class Client
{
    private $instance = NULL;

    public function __construct()
    {
        $params = array(
            'location' => 'http://localhost/tankonyvrendeles/soap_server.php?wsdl',
            'uri' => 'urn://localhost/tankonyvrendeles/soap_server.php?wsdl',
            'trace' => 1,
            'cache_wsdl' => WSDL_CACHE_NONE
        );
        $this->instance = new SoapClient(NULL, $params);
    }

    // Diákok lekérése
    public function getDiakok()
    {
        return $this->instance->__soapCall('getDiakok', []);
    }

    // Oldalak lekérése
    public function getPages()
    {
        return $this->instance->__soapCall('getPages', []);
    }

    // Rendelések lekérése
    public function getRendelesek()
    {
        return $this->instance->__soapCall('getRendelesek', []);
    }

    // Tankönyvek lekérése
    public function getTk()
    {
        return $this->instance->__soapCall('getTk', []);
    }

    // Tankönyv kategóriák lekérése
    public function getTkar()
    {
        return $this->instance->__soapCall('getTkar', []);
    }

    // Felhasználók lekérése
    public function getUsers()
    {
        return $this->instance->__soapCall('getUsers', []);
    }
}

// Kérés kezelés, ha POST érkezik a 'type' változóval
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['type'])) {
    $type = $_POST['type'];
    $client = new Client();

    switch ($type) {
        case 'diakok':
            echo json_encode($client->getDiakok());
            break;
        case 'pages':
            echo json_encode($client->getPages());
            break;
        case 'rendelesek':
            echo json_encode($client->getRendelesek());
            break;
        case 'tk':
            echo json_encode($client->getTk());
            break;
        case 'tkar':
            echo json_encode($client->getTkar());
            break;
        case 'users':
            echo json_encode($client->getUsers());
            break;
        default:
            echo "Érvénytelen típus";
    }
    exit; // Kilépés, hogy ne renderelje újra a HTML-t
}

?>

<!DOCTYPE html>
<html lang="en">

<?php include 'head.php' ?>

<body class="container mt-4">

    <div style="margin-top: 8rem">
        <h2>SOAP Kliens: Adatok lekérése</h2>

        <!-- Gombok a lekéréshez -->
        <button class="btn btn-primary mt-2" onclick="fetchData('diakok')">Diákok</button>
        <button class="btn btn-primary mt-2" onclick="fetchData('pages')">Oldalak</button>
        <button class="btn btn-primary mt-2" onclick="fetchData('rendelesek')">Rendelések</button>
        <button class="btn btn-primary mt-2" onclick="fetchData('tk')">Tankönyvek</button>
        <button class="btn btn-primary mt-2" onclick="fetchData('tkar')">Tankönyv Kategóriák</button>
        <button class="btn btn-primary mt-2" onclick="fetchData('users')">Felhasználók</button>

        <!-- Eredmények megjelenítése -->
        <div id="results" class="mt-4"></div>
    </div>

    <script>
        // Az AJAX kéréseket indító funkció
        function fetchData(type) {
            // Törlés a gombnyomás előtt
            document.getElementById('results').innerHTML = "Töltés...";

            // HTTP kérés létrehozása
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true); // A POST kérés a jelenlegi oldalt célozza
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Amikor a válasz megérkezik
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // Ha sikeres, a választ megjelenítjük
                    try {
                        var response = JSON.parse(xhr.responseText);
                        document.getElementById('results').innerHTML = "<pre>" + JSON.stringify(response, null, 2) + "</pre>";
                    } catch (e) {
                        document.getElementById('results').innerHTML = "Hiba történt az adatfeldolgozáskor.";
                    }
                } else {
                    // Hibakezelés
                    document.getElementById('results').innerHTML = "Hiba történt az adatok lekérésekor.";
                }
            };

            // A kérés adatainak elküldése
            xhr.send("type=" + type);
        }
    </script>

</body>

</html>