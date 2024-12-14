<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNB Árfolyam Lekérdezés</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>MNB Árfolyam Lekérdezés</h1>
    <form method="POST" action="">
        <label for="currencyPair">Devizapár (pl. EUR/HUF):</label>
        <input type="text" name="currencyPair" id="currencyPair" required>
        <br><br>

        <label for="specificDate">Dátum (YYYY-MM-DD):</label>
        <input type="date" name="specificDate" id="specificDate">
        <br><br>

        <label for="monthStart">Havi időszak kezdete (YYYY-MM-DD):</label>
        <input type="date" name="monthStart" id="monthStart">
        <br>
        <label for="monthEnd">Havi időszak vége (YYYY-MM-DD):</label>
        <input type="date" name="monthEnd" id="monthEnd">
        <br><br>

        <button type="submit">Lekérdezés</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $currencyPair = $_POST['currencyPair'] ?? '';
        $specificDate = $_POST['specificDate'] ?? '';
        $monthStart = $_POST['monthStart'] ?? '';
        $monthEnd = $_POST['monthEnd'] ?? '';

        try {
            $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");

            // Egy adott nap árfolyamának lekérdezése
            if (!empty($specificDate)) {
                $response = $client->GetExchangeRates([
                    'startDate' => $specificDate,
                    'endDate' => $specificDate,
                    'currencyNames' => $currencyPair
                ]);

                $xml = simplexml_load_string($response->GetExchangeRatesResult);
                if (isset($xml->Day->Rate)) {
                    echo "<h2>$currencyPair árfolyama $specificDate dátumon:</h2>";
                    echo "<p>" . (string)$xml->Day->Rate . "</p>";
                } else {
                    echo "<p>Nincs adat a megadott dátumra.</p>";
                }
            }

            // Egy adott hónap árfolyamainak lekérdezése
            if (!empty($monthStart) && !empty($monthEnd)) {
                $response = $client->GetExchangeRates([
                    'startDate' => $monthStart,
                    'endDate' => $monthEnd,
                    'currencyNames' => $currencyPair
                ]);

                $xml = simplexml_load_string($response->GetExchangeRatesResult);

                if (isset($xml->Day)) {
                    echo "<h2>$currencyPair árfolyamai $monthStart és $monthEnd között:</h2>";
                    echo "<table border='1'><tr><th>Dátum</th><th>Árfolyam</th></tr>";

                    $labels = [];
                    $data = [];
                    foreach ($xml->Day as $day) {
                        $date = (string)$day->attributes()->date;
                        $rate = (string)$day->Rate;
                        echo "<tr><td>$date</td><td>$rate</td></tr>";
                        $labels[] = $date;
                        $data[] = $rate;
                    }
                    echo "</table>";

                    // Grafikon adatok betöltése
                    echo "
                        <canvas id='exchangeRateChart' width='800' height='400'></canvas>
                        <script>
                            const labels = " . json_encode($labels) . ";
                            const data = " . json_encode($data) . ";

                            const ctx = document.getElementById('exchangeRateChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [{
                                        label: '$currencyPair Árfolyam',
                                        data: data,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Dátum'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Árfolyam'
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                    ";
                } else {
                    echo "<p>Nincs adat a megadott időszakra.</p>";
                }
            }
        } catch (SoapFault $e) {
            echo "<p>Hiba történt: " . $e->getMessage() . "</p>";
        }
    }
    ?>
</body>
</html>
