<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include('session_check.php');

include 'head.php';
require_once('db.php');

// Diákok listája
$diak_query = "SELECT az, nev FROM diak";
$diak_stmt = $pdo->prepare($diak_query);
$diak_stmt->execute();
$diakok = $diak_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF Generálás</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script>
        // JavaScript függvények a dinamikus frissítéshez
        function updateYearList() {
            const diakaz = document.getElementById("diakaz").value;

            // Az év lista frissítése a diák alapján
            fetch('get_years.php?diakaz=' + diakaz)
                .then(response => response.json())
                .then(data => {
                    const yearSelect = document.getElementById("ev");
                    yearSelect.innerHTML = '';
                    data.forEach(function (year) {
                        const option = document.createElement("option");
                        option.value = year.ev;
                        option.text = year.ev;
                        yearSelect.appendChild(option);
                    });
                    updateSubjectList(); // Frissítjük a tárgyakat is
                });
        }

        function updateSubjectList() {
            const diakaz = document.getElementById("diakaz").value;
            const ev = document.getElementById("ev").value;

            // A tárgyak lista frissítése a diák és év alapján
            fetch('get_subjects.php?diakaz=' + diakaz + '&ev=' + ev)
                .then(response => response.json())
                .then(data => {
                    const subjectSelect = document.getElementById("tkaz");
                    subjectSelect.innerHTML = '';
                    data.forEach(function (subject) {
                        const option = document.createElement("option");
                        option.value = subject.az;
                        option.text = subject.cim;
                        subjectSelect.appendChild(option);
                    });
                });
        }
    </script>
</head>

<body class="container mt-5">

    <h2 style="margin-top: 8rem;">PDF Generálás</h2>
    <form action="generate_pdf.php" method="GET" class="mt-4">

        <!-- Diák kiválasztása -->
        <div class="mb-3">
            <label for="diakaz" class="form-label">Diák:</label>
            <select name="diakaz" id="diakaz" class="form-select" onchange="updateYearList()">
                <option value="">Válasszon diákot</option>
                <?php foreach ($diakok as $diak): ?>
                    <option value="<?= $diak['az'] ?>"><?= $diak['nev'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Év kiválasztása -->
        <div class="mb-3">
            <label for="ev" class="form-label">Év:</label>
            <select name="ev" id="ev" class="form-select" onchange="updateSubjectList()">
                <option value="">Válasszon évet</option>
            </select>
        </div>

        <!-- Tárgy kiválasztása -->
        <div class="mb-3">
            <label for="tkaz" class="form-label">Tankönyv:</label>
            <select name="tkaz" id="tkaz" class="form-select">
                <option value="">Válasszon tárgyat</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">PDF Generálás</button>

    </form>

    <!-- Bootstrap JS (opcionálisan) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>