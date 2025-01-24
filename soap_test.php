<?php
include('session_check.php'); 
$options = [
    'location' => 'http://localhost/tankonyvrendeles/soap_server.php',
    'uri' => 'http://localhost/tankonyvrendeles/soap_server.php',
];
$client = new SoapClient(null, $options);

try {
    // SOAP adatok lekérdezése
    $students = $client->getStudents();
    $orders = $client->getOrders();
    $books = $client->getBooks();
} catch (SoapFault $e) {
    die("SOAP hiba: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SOAP Teszt</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>SOAP Teszt</h1>

    <h2>Diákok</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Név</th>
            <th>Osztály</th>
        </tr>
        <?php foreach ($students as $student): ?>
        <tr>
            <td><?= htmlspecialchars($student['az']) ?></td>
            <td><?= htmlspecialchars($student['nev']) ?></td>
            <td><?= htmlspecialchars($student['osztaly']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Rendelések</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Év</th>
            <th>Diák</th>
            <th>Könyv</th>
            <th>Ingyenes</th>
        </tr>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= htmlspecialchars($order['id']) ?></td>
            <td><?= htmlspecialchars($order['ev']) ?></td>
            <td><?= htmlspecialchars($order['diak_nev']) ?></td>
            <td><?= htmlspecialchars($order['konyv_cim']) ?></td>
            <td><?= $order['ingyenes'] ? 'Igen' : 'Nem' ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <h2>Tankönyvek</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Cím</th>
            <th>Tantárgy</th>
        </tr>
        <?php foreach ($books as $book): ?>
        <tr>
            <td><?= htmlspecialchars($book['az']) ?></td>
            <td><?= htmlspecialchars($book['cim']) ?></td>
            <td><?= htmlspecialchars($book['targy']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
