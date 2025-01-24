<?php
// SOAP szerver URL-je

include('session_check.php');


// SOAP hiba kezelés
function callSoapFunction($function, $params)
{
    try {
        $client = new SoapClient(null, [
            'location' => 'http://localhost/tankonyvrendeles/soap_server.php',
            'uri' => 'http://localhost/tankonyvrendeles/'
        ]);
        $result = $client->__soapCall($function, [$params]);
        return $result;
    } catch (Exception $e) {
        return "SOAP Hiba: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $function = $_POST['function'];
    $params = [];

    // Különböző funkciókhoz eltérő paraméterek
    if ($function == 'getAllRendelesek') {
        $params = [intval($_POST['limit'])];
    } elseif ($function == 'getRendelesById') {
        $params = [intval($_POST['rendelesId'])];
    } elseif ($function == 'addRendeles') {
        $params = [
            intval($_POST['diakaz']),
            intval($_POST['tkaz']),
            intval($_POST['ev']),
            $_POST['ingyenes'] === 'true' ? true : false
        ];
    }

    // A funkció meghívása és válasz kiírása
    $response = callSoapFunction($function, $params);
}
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP Webszolgáltatás</title>
</head>

<body>
    <h1>SOAP Webszolgáltatás</h1>

    <h2>Elérhető funkciók:</h2>
    <ul>
        <li><strong>getAllRendelesek($limit)</strong>: A rendelések listája, korlátozott számú eredménnyel.</li>
        <li><strong>getRendelesById($rendelesId)</strong>: Egy rendelés részletei azonosító alapján.</li>
        <li><strong>addRendeles($diakaz, $tkaz, $ev, $ingyenes)</strong>: Új rendelés hozzáadása.</li>
    </ul>

    <h2>Funkciók kipróbálása</h2>
    <form method="POST">
        <label for="function">Válassz funkciót:</label>
        <select name="function" id="function">
            <option value="getAllRendelesek">getAllRendelesek</option>
            <option value="getRendelesById">getRendelesById</option>
            <option value="addRendeles">addRendeles</option>
        </select>

        <div id="getAllRendelesekParams" style="display:none;">
            <label for="limit">Limit:</label>
            <input type="number" name="limit" id="limit" value="5">
        </div>

        <div id="getRendelesByIdParams" style="display:none;">
            <label for="rendelesId">Rendelés ID:</label>
            <input type="number" name="rendelesId" id="rendelesId">
        </div>

        <div id="addRendelesParams" style="display:none;">
            <label for="diakaz">Diák azonosító:</label>
            <input type="number" name="diakaz" id="diakaz">
            <label for="tkaz">Tankönyv azonosító:</label>
            <input type="number" name="tkaz" id="tkaz">
            <label for="ev">Év:</label>
            <input type="number" name="ev" id="ev">
            <label for="ingyenes">Ingyenes (true/false):</label>
            <input type="text" name="ingyenes" id="ingyenes" value="false">
        </div>

        <button type="submit">Küldés</button>
    </form>

    <?php if (isset($response)): ?>
        <h2>Válasz:</h2>
        <?php if (is_array($response)): ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>Rendelés Azonosító</th>
                        <th>Év</th>
                        <th>Tankönyv Azonosító</th>
                        <th>Diák Azonosító</th>
                        <th>Ingyenes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($response as $rendeles): ?>
                        <tr>
                            <td><?php echo $rendeles['az']; ?></td>
                            <td><?php echo $rendeles['ev']; ?></td>
                            <td><?php echo $rendeles['tkaz']; ?></td>
                            <td><?php echo $rendeles['diakaz']; ?></td>
                            <td><?php echo $rendeles['ingyenes'] == 1 ? 'Igen' : 'Nem'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <pre><?php print_r($response); ?></pre>
        <?php endif; ?>
    <?php endif; ?>

    <script>
        // Változtatás a funkció választása alapján, hogy csak a megfelelő mezők jelenjenek meg
        document.getElementById('function').addEventListener('change', function () {
            document.getElementById('getAllRendelesekParams').style.display = 'none';
            document.getElementById('getRendelesByIdParams').style.display = 'none';
            document.getElementById('addRendelesParams').style.display = 'none';

            const selectedFunction = this.value;

            if (selectedFunction === 'getAllRendelesek') {
                document.getElementById('getAllRendelesekParams').style.display = 'block';
            } else if (selectedFunction === 'getRendelesById') {
                document.getElementById('getRendelesByIdParams').style.display = 'block';
            } else if (selectedFunction === 'addRendeles') {
                document.getElementById('addRendelesParams').style.display = 'block';
            }
        });

        // Inicializálás
        document.getElementById('function').dispatchEvent(new Event('change'));
    </script>
</body>

</html>