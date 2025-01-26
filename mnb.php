<?php

include('session_check.php');

$results = '';
$chartData = [
    'labels' => [],
    'rates1' => [],
    'rates2' => []
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $queryType = $_POST['query_type'];
    $year = $_POST['year'];
    $month = str_pad($_POST['month'], 2, '0', STR_PAD_LEFT);
    $currencyPair = $_POST['currency'];

    // Felbontjuk a devizapárt pl EUR-HUF
    $currencies = explode('-', strtoupper($currencyPair));
    if (count($currencies) != 2) {
        $results = "<div class='alert alert-danger mt-4'>Hibás devizapár formátum. Kérlek, használd az 'EUR-USD' formátumot.</div>";
    } else {
        $currencyPair1 = $currencies[0]; // Első deviza
        $currencyPair2 = $currencies[1]; // Második deviza

        if ($queryType === "daily") {
            $day = str_pad($_POST['day'], 2, '0', STR_PAD_LEFT);
            $startDate = "$year-$month-$day";
            $endDate = "$year-$month-$day";
        } elseif ($queryType === "monthly") {
            $startDate = "$year-$month-01";
            $endDate = date("Y-m-t", strtotime($startDate));
        }

        try {
            $client = new SoapClient("https://www.mnb.hu/arfolyamok.asmx?wsdl");

            // Első devizapár lekérése
            $response1 = $client->GetExchangeRates([
                'startDate' => $startDate,
                'endDate' => $endDate,
                'currencyNames' => $currencyPair1
            ]);

            $exchangeRatesXml1 = $response1->GetExchangeRatesResult;
            $xml1 = simplexml_load_string($exchangeRatesXml1);

            // Második devizapár lekérése
            $response2 = $client->GetExchangeRates([
                'startDate' => $startDate,
                'endDate' => $endDate,
                'currencyNames' => $currencyPair2
            ]);

            $exchangeRatesXml2 = $response2->GetExchangeRatesResult;
            $xml2 = simplexml_load_string($exchangeRatesXml2);

            // Adatok feldolgozása az első devizapárhoz
            if ($xml1 !== false && isset($xml1->Day)) {
                $results .= "<h3>Árfolyamok ($currencyPair1)</h3>";
                $results .= "<table class='table table-striped mt-4'>";
                $results .= "<thead><tr><th>Dátum</th><th>Árfolyam Ft-ban</th></tr></thead><tbody>";

                foreach ($xml1->Day as $day) {
                    $date = $day['date'];
                    foreach ($day->Rate as $rate) {
                        $rateValue = (float) $rate;
                        $results .= "<tr>";
                        $results .= "<td>$date</td>";
                        $results .= "<td>$rateValue</td>";
                        $results .= "</tr>";

                        $chartData['labels'][] = (string) $date;
                        $chartData['rates1'][] = $rateValue;
                    }
                }
                $results .= "</tbody></table>";
            }

            // Adatok feldolgozása a második devizapárhoz
            if ($xml2 !== false && isset($xml2->Day)) {
                $results .= "<h3>Árfolyamok ($currencyPair2)</h3>";
                $results .= "<table class='table table-striped mt-4'>";
                $results .= "<thead><tr><th>Dátum</th><th>Árfolyam Ft-ban</th></tr></thead><tbody>";

                foreach ($xml2->Day as $day) {
                    $date = $day['date'];
                    foreach ($day->Rate as $rate) {
                        $rateValue = (float) $rate;
                        $results .= "<tr>";
                        $results .= "<td>$date</td>";
                        $results .= "<td>$rateValue</td>";
                        $results .= "</tr>";

                        // Ha a dátum már létezik az első devizapárban, akkor hozzáadjuk a második deviza értékét is
                        if (!in_array($date, $chartData['labels'])) {
                            $chartData['labels'][] = (string) $date;
                        }

                        $chartData['rates2'][] = $rateValue;
                    }
                }
                $results .= "</tbody></table>";
            }
        } catch (SoapFault $e) {
            $results = "<div class='alert alert-danger mt-4'>SOAP Hiba: " . $e->getMessage() . "</div>";
        }
    }
}
include 'head.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MNB Árfolyam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body style="margin-top: 8rem">
    <div class="container mt-5">
        <h1 class="mb-4">MNB Árfolyam Lekérdezés</h1>

        <form method="POST" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label for="query_type" class="form-label">Lekérdezési módszer:</label>
                <select name="query_type" id="query_type" class="form-select" required>
                    <option value="daily">Egy adott napon</option>
                    <option value="monthly">Egy adott hónapban</option>
                </select>
            </div>


            <!-- Év választó -->
            <div class="mb-3">
                <label for="year" class="form-label">Év:</label>
                <input type="number" id="year" name="year" min="2000" max="2100" class="form-control" required>
            </div>

            <!-- Hónap választó -->
            <div class="mb-3">
                <label for="month" class="form-label">Hónap:</label>
                <select name="month" id="month" class="form-select" required>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Nap választó -->
            <div class="mb-3" id="day_section">
                <label for="day" class="form-label">Nap:</label>
                <select name="day" id="day" class="form-select">
                    <?php for ($i = 1; $i <= 31; $i++): ?>
                        <option value="<?= $i ?>"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <!-- Deviza választó -->
            <div class="mb-3">
                <label for="currency" class="form-label">Devizapár (pl. EUR-USD):</label>
                <input type="text" name="currency" id="currency" class="form-control" placeholder="pl. EUR-USD"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Árfolyam lekérdezése</button>
            <a href="../index.php" style="float: right;">Vissza a főoldalra.</a>
        </form>

        <!-- Lekérdezés eredmény -->
        <?php if ($results): ?>
            <div class="results mt-4">
                <?= $results ?>
            </div>
        <?php endif; ?>

        <!-- Grafikon -->
        <?php if (!empty($chartData['labels'])): ?>
            <div class="mt-5">
                <h3>Árfolyamok Grafikonja</h3>
                <canvas id="exchangeRateChart"></canvas>
            </div>
            <script>
                const chartData = <?php echo json_encode($chartData); ?>;
                const currencyPair1 = '<?php echo $currencyPair1; ?>';
                const currencyPair2 = '<?php echo $currencyPair2; ?>';

                const ctx = document.getElementById('exchangeRateChart').getContext('2d');
                const exchangeRateChart = new Chart(ctx, {
                    type: 'line', // Vonalgrafikon
                    data: {
                        labels: chartData.labels, // Dátumok grafikon alján
                        datasets: [
                            // Első deviza
                            {
                                label: currencyPair1,
                                data: chartData.rates1,
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                fill: true,
                            },
                            // Második deviza
                            {
                                label: currencyPair2,
                                data: chartData.rates2,
                                borderColor: 'rgba(153, 102, 255, 1)',
                                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: { title: { display: true, text: 'Dátum' } },
                            y: { title: { display: true, text: 'Árfolyam Ft-ban' }, beginAtZero: false }
                        }
                    }
                });
            </script>
        <?php endif; ?>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const queryTypeSelect = document.getElementById('query_type');
        const daySection = document.getElementById('day_section');

        // Ha csak hónapot szeretnénk lekérdezni
        queryTypeSelect.addEventListener('change', function () {
            if (this.value === 'daily') {
                daySection.style.display = 'block';
            } else {
                daySection.style.display = 'none';
            }
        });


        if (queryTypeSelect.value !== 'daily') {
            daySection.style.display = 'none';
        }
    </script>
</body>

</html>