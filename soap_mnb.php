<?php
// WSDL URL a Magyar Nemzeti Bank SOAP szolgáltatásához
$wsdl = 'https://www.mnb.hu/arfolyamok.asmx?singleWsdl';

// SOAP kliens létrehozása
try {
    $client = new SoapClient($wsdl);
} catch (SoapFault $e) {
    echo "SOAP hiba: " . $e->getMessage();
    exit;
}

// Ha az űrlap beküldése megtörtént
if (isset($_POST['submit'])) {
    $deviza = $_POST['deviza']; // Devizapár
    $datum = $_POST['datum'];   // Dátum (egy adott nap)
    $honap = $_POST['honap'];   // Hónap (hónapra vonatkozó kereséshez)
    $ev = $_POST['ev'];         // Év (a hónaphoz)

    // Ha adott nap árfolyamát kérjük
    if ($datum) {
        $params = [
            'Deviza' => $deviza,
            'Datum' => $datum
        ];

        try {
            // Lekérjük az árfolyamot a megadott dátumra
            $response = $client->GetExchangeRates($params);
        } catch (SoapFault $e) {
            echo "SOAP hiba: " . $e->getMessage();
        }

        if (isset($response->rates)) {
            echo "<h3>$deviza árfolyama $datum dátumra:</h3>";
            echo "<table border='1'>
                    <tr><th>Dátum</th><th>Árfolyam</th></tr>";
            foreach ($response->rates as $rate) {
                echo "<tr><td>" . $rate->date . "</td><td>" . $rate->rate . "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "Nincs adat a megadott napra!";
        }
    }

    // Ha adott hónap árfolyamait kérjük
    if ($honap) {
        $first_date = date("Y-m-d", strtotime("first day of $ev-$honap"));
        $last_date = date("Y-m-d", strtotime("last day of $ev-$honap"));
        
        $params = [
            'Deviza' => $deviza,
            'FirstDate' => $first_date,
            'LastDate' => $last_date
        ];

        try {
            // Lekérjük az árfolyamokat a megadott hónapra
            $response = $client->GetExchangeRates($params);
        } catch (SoapFault $e) {
            echo "SOAP hiba: " . $e->getMessage();
        }

        if (isset($response->rates)) {
            echo "<h3>$deviza árfolyama $ev-$honap hónapra:</h3>";
            echo "<table border='1'>
                    <tr><th>Dátum</th><th>Árfolyam</th></tr>";
            foreach ($response->rates as $rate) {
                echo "<tr><td>" . $rate->date . "</td><td>" . $rate->rate . "</td></tr>";
            }
            echo "</table>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNB Devizaárfolyam Lekérdezés</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h1>Magyar Nemzeti Bank Devizaárfolyamok</h1>

<!-- Kereső űrlap -->
<form method="post">
    <label for="deviza">Devizapár:</label>
    <select name="deviza">
        <option value="EURHUF">EUR/HUF</option>
        <option value="EURUSD">EUR/USD</option>
        <option value="USDHUF">USD/HUF</option>
        <!-- További devizapárok hozzáadása itt -->
    </select><br><br>
    
    <label for="datum">Dátum (pl. 2025-01-22):</label>
    <input type="date" name="datum"><br><br>
    
    <label for="ev">Év:</label>
    <input type="number" name="ev" value="2025" required><br><br>

    <label for="honap">Hónap:</label>
    <input type="number" name="honap" value="1" min="1" max="12" required><br><br>
    
    <input type="submit" name="submit" value="Lekérdezés">
</form>

<!-- Grafikon -->
<canvas id="myChart" width="400" height="200"></canvas>

<script>
<?php if (isset($dates) && isset($rates)): ?>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($dates); ?>, // Dátumok
            datasets: [{
                label: '<?php echo $deviza; ?>',
                data: <?php echo json_encode($rates); ?>, // Árfolyamok
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        });
<?php endif; ?>
</script>

</body>
</html>
