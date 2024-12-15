<?php
// TCPDF és adatbázis kapcsolat betöltése
require_once __DIR__ . '/beadando/pdf/tcpdf.php'; // TCPDF helyes elérési útja
require_once __DIR__ . '/db.php'; // Adatbázis kapcsolat

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Űrlapról érkező adatok
    $diakId = $_POST['diak'] ?? '';
    $rendelesId = $_POST['rendeles'] ?? '';
    $tkId = $_POST['tk'] ?? '';

    try {
        // Adatbázisból adatok lekérése
        // 1. Diák adatok
        $stmt = $conn->prepare("SELECT nev, osztaly FROM diak WHERE az = ?");
        $stmt->bind_param("i", $diakId);
        $stmt->execute();
        $diak = $stmt->get_result()->fetch_assoc();

        // 2. Rendelés adatok
        $stmt = $conn->prepare("SELECT ev, ingyenes FROM rendeles WHERE az = ?");
        $stmt->bind_param("i", $rendelesId);
        $stmt->execute();
        $rendeles = $stmt->get_result()->fetch_assoc();

        // 3. Tankönyv adatok
        $stmt = $conn->prepare("SELECT cim, targy FROM tk WHERE az = ?");
        $stmt->bind_param("i", $tkId);
        $stmt->execute();
        $tk = $stmt->get_result()->fetch_assoc();

        // PDF létrehozása
        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Tankönyvrendelés Rendszer');
        $pdf->SetTitle('Tankönyvrendelés PDF');
        $pdf->SetHeaderData('', '', 'Tankönyvrendelés', 'Generált PDF dokumentum');

        // Betűk és margók
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);
        $pdf->SetAutoPageBreak(TRUE, 25);

        // Új oldal létrehozása
        $pdf->AddPage();

        // PDF tartalom (HTML formátumban)
        $html = "
            <h1>Tankönyvrendelés Adatok</h1>
            <h2>Diák adatai</h2>
            <p><strong>Név:</strong> {$diak['nev']}</p>
            <p><strong>Osztály:</strong> {$diak['osztaly']}</p>

            <h2>Rendelés adatai</h2>
            <p><strong>Év:</strong> {$rendeles['ev']}</p>
            <p><strong>Ingyenes:</strong> " . ($rendeles['ingyenes'] ? 'Igen' : 'Nem') . "</p>

            <h2>Tankönyv adatai</h2>
            <p><strong>Cím:</strong> {$tk['cim']}</p>
            <p><strong>Tárgy:</strong> {$tk['targy']}</p>
        ";

        // PDF tartalom hozzáadása
        $pdf->writeHTML($html, true, false, true, false, '');

        // PDF letöltése
        $pdf->Output('tankonyvrendeles.pdf', 'D'); // D: letöltés
        exit;

    } catch (Exception $e) {
        echo "Hiba történt: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>PDF Generálás</title>
</head>
<body>
    <h1>PDF Generálás</h1>
    <form method="POST" action="pdf_menu.php">
        <label for="diak">Diák (ID):</label>
        <input type="number" id="diak" name="diak" required><br><br>

        <label for="rendeles">Rendelés (ID):</label>
        <input type="number" id="rendeles" name="rendeles" required><br><br>

        <label for="tk">Tankönyv (ID):</label>
        <input type="number" id="tk" name="tk" required><br><br>

        <button type="submit">PDF Generálás</button>
    </form>
</body>
</html>
