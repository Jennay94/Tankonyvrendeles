<?php
// Adatbázis kapcsolat
require_once('db.php');
require_once('tcpdf/tcpdf.php');

// Paraméterek lekérése a GET-ből
$diakaz = $_GET['diakaz'] ?? '';
$ev = $_GET['ev'] ?? '';
$tkaz = $_GET['tkaz'] ?? '';

// Lekérjük a diák nevét és osztályát
$diak_query = "SELECT nev, osztaly FROM Diak WHERE az = :diakaz";
$diak_stmt = $pdo->prepare($diak_query);
$diak_stmt->bindParam(':diakaz', $diakaz, PDO::PARAM_INT);
$diak_stmt->execute();
$diak = $diak_stmt->fetch(PDO::FETCH_ASSOC);

// Lekérjük a tárgy nevét
$tk_query = "SELECT cim FROM tk WHERE az = :tkaz";
$tk_stmt = $pdo->prepare($tk_query);
$tk_stmt->bindParam(':tkaz', $tkaz, PDO::PARAM_INT);
$tk_stmt->execute();
$targy = $tk_stmt->fetch(PDO::FETCH_ASSOC);

// Lekérjük a rendeléseket az adott diákhoz, évhez és tárgyhoz, valamint a rendelés azonosítóját
$rendezes_query = "
    SELECT r.az, r.ev, t.cim, r.ingyenes 
    FROM rendeles r
    JOIN tk t ON r.tkaz = t.az
    WHERE r.diakaz = :diakaz AND r.ev = :ev AND r.tkaz = :tkaz
";
$rendezes_stmt = $pdo->prepare($rendezes_query);
$rendezes_stmt->bindParam(':diakaz', $diakaz, PDO::PARAM_INT);
$rendezes_stmt->bindParam(':ev', $ev, PDO::PARAM_INT);
$rendezes_stmt->bindParam(':tkaz', $tkaz, PDO::PARAM_INT);
$rendezes_stmt->execute();
$rendelesek = $rendezes_stmt->fetchAll(PDO::FETCH_ASSOC);

// TCPDF beállítások
$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('dejavusans', '', 12);

// Diák és osztály adatok
$html = "
    <h1>Rendelés - {$diak['nev']}</h1>
    <h2>Osztály: {$diak['osztaly']}</h2>
    
    <br><br>
    <table border='1' cellpadding='5'>
        <thead>
            <tr>
                <th>Rendelés Azonosító</th>
                <th>Év</th>
                <th>Tárgy</th>
                <th>Ingyenes</th>
            </tr>
        </thead>
        <tbody>
";

// Ha a rendeléseket nem találtuk, akkor kiírjuk, hogy nincs rendelés
if (empty($rendelesek)) {
    $html .= "
        <tr>
            <td colspan='4'>Nincs rendelés a kiválasztott szűrési feltételek alapján.</td>
        </tr>
    ";
} else {
    // Rendelések kiírása, beleértve az azonosítót
    foreach ($rendelesek as $rendeles) {
        $html .= "
            <tr>
                <td>{$rendeles['az']}</td>
                <td>{$rendeles['ev']}</td>
                <td>{$rendeles['cim']}</td>
                <td>" . ($rendeles['ingyenes'] == 'I' ? 'Igen' : 'Nem') . "</td>
            </tr>
        ";
    }
}

$html .= "</tbody></table>";

// PDF tartalom generálása
$pdf->writeHTML($html);

// PDF mentése
$pdf->Output('rendeles.pdf', 'I');
?>