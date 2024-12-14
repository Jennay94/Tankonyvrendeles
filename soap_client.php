<?php
$options = [
    'location' => 'http://localhost/tankonyvrendeles/soap_server.php',
    'uri' => 'http://localhost/tankonyvrendeles/soap_server.php',
];
$client = new SoapClient(null, $options);

try {
    // 1. Diákok lekérdezése
    echo "Diákok:\n";
    print_r($client->getStudents());

    // 2. Rendelések lekérdezése
    echo "\nRendelések:\n";
    print_r($client->getOrders());

    // 3. Tankönyvek lekérdezése
    echo "\nTankönyvek:\n";
    print_r($client->getBooks());
} catch (SoapFault $e) {
    echo "SOAP hiba: " . $e->getMessage();
}
?>
