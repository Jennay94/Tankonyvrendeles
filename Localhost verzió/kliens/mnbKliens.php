<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currencyPair = $_POST['currencyPair'] ?? '';
    $date = $_POST['date'] ?? '';
    $monthStart = $_POST['monthStart'] ?? '';
    $monthEnd = $_POST['monthEnd'] ?? '';

    try {
        $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?wsdl");

        // Eredmények tárolása
        $results = [];

        // Egy adott nap árfolyamának lekérdezése
        if (!empty($currencyPair) && !empty($date)) {
            $response = $client->GetExchangeRates([
                'startDate' => $date,
                'endDate' => $date,
                'currencyNames' => $currencyPair
            ]);
            $xml = simplexml_load_string($response->GetExchangeRatesResult);
            $rate = (string)$xml->Day->Rate;
            $results[] = ['date' => $date, 'rate' => $rate];
            echo "<h2>A $currencyPair árfolyama $date dátumon: $rate</h2>";
        }

        // Havi árfolyamok lekérdezése
        if (!empty($currencyPair) && !empty($monthStart) && !empty($monthEnd)) {
            $response = $client->GetExchangeRates([
                'startDate' => $monthStart,
                'endDate' => $monthEnd,
                'currencyNames' => $currencyPair
            ]);
            $xml = simplexml_load_string($response->GetExchangeRatesResult);
            $days = $xml->Day;

            echo "<h2>$currencyPair árfolyamai $monthStart - $monthEnd között:</h2>";
            echo "<table border='1'>
                    <tr><th>Dátum</th><th>Árfolyam</th></tr>";

            $labels = [];
            $data = [];
            foreach ($days as $day) {
                $date = (string) $day->attributes()->date;
                $rate = (string) $day->Rate;
                $results[] = ['date' => $date, 'rate' => $rate];
                $labels[] = $date;
                $data[] = $rate;

                echo "<tr><td>$date</td><td>$rate</td></tr>";
            }
            echo "</table>";

            // Javascript változók a grafikonhoz
            echo "
                <script>
                    const labels = " . json_encode($labels) . ";
                    const data = " . json_encode($data) . ";

                    const ctx = document.getElementById('exchangeRateChart').getContext('2d');
                    document.getElementById('exchangeRateChart').style.display = 'block';

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: '$currencyPair Árfolyam',
                                data: data,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                tension: 0.1
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
        }
    } catch (SoapFault $e) {
        echo "Hiba történt: " . $e->getMessage();
    }
}
?>
