<?php
require 'db.php';
include 'head.php';
include 'session_check.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form adatok kezelése
    $user_id = $_POST['id'];
    $is_admin = ($_POST['admin_rang'] == 'igen') ? 103 : 102;

    // Felhasználó rangjának módosítása
    try {
        $stmt = $pdo->prepare("UPDATE users SET rang = :rang WHERE id = :id");
        $stmt->bindParam(':rang', $is_admin, PDO::PARAM_INT);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $message = "Rang sikeresen frissítve!";
    } catch (PDOException $e) {
        $message = "Hiba történt: " . $e->getMessage();
    }
}
?>

<body style="margin-top: 8rem">
    <div class="container">
        <h2 class="text-center my-4">Felhasználói Rang Frissítés</h2>

        <?php if (isset($message)): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form action="" method="POST" class="w-50 mx-auto">
            <div class="form-group">
                <label for="id">Felhasználó ID</label>
                <input type="number" class="form-control" id="id" name="id" required
                    placeholder="Add meg a felhasználó ID-ját">
            </div>

            <div class="form-group">
                <label for="admin_rang">Admin rang</label>
                <select class="form-control" id="admin_rang" name="admin_rang" required>
                    <option value="igen">Igen</option>
                    <option value="nem">Nem</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Frissítés</button>
        </form>
    </div>
</body>