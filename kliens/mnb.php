<?php include '../header.php'; ?>


<body class="index-page">

  <header id="header" class="header fixed-top">

    <div class="topbar d-flex align-items-center">
      <div class="container d-flex justify-content-center justify-content-md-between">
        <div class="contact-info d-flex align-items-center">
          <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:contact@example.com">contact@example.com</a></i>
          <i class="bi bi-phone d-flex align-items-center ms-4"><span>+1 5589 55488 55</span></i>
        </div>
        <div class="social-links d-none d-md-flex align-items-center">
          <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
          <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
          <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
          <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>
      </div>
    </div><!-- End Top Bar -->

    <div class="branding d-flex align-items-cente">

      <div class="container position-relative d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
          <!-- Uncomment the line below if you also wish to use an image logo -->
          <!-- <img src="assets/img/logo.png" alt=""> -->
          <h1 class="sitename">Tankönyrendelés</h1>
          <span>.</span>
        </a>

        <?php include '../menubar.php'; ?>

      </div>

    </div>

  </header>

  <main class="main">

    
    <!-- Clients Section -->
    <section id="clients" class="clients section">

      <div class="container">

      

      </div>

    </section><!-- /Clients Section -->

   


  </main>
  
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
    

 include '../footer.php'; ?>
