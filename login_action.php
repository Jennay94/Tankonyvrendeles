<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <?php
        // Az adatbázis kapcsolat betöltése
        include "db.php";
        session_start();  // Munkamenet indítása
        
        // Ellenőrizzük, hogy a POST kérés be lett-e küldve
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Felhasználónév és jelszó változók beállítása
            $user_name = $_POST['username'];
            $password = $_POST['password'];

            try {
                // Lekérdezzük a felhasználót az adatbázisból a megadott felhasználónév alapján
                $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = :user_name");
                $stmt->bindParam(':user_name', $user_name);
                $stmt->execute();

                // Ha a felhasználó nem található
                if ($stmt->rowCount() == 0) {
                    echo '<div class="alert alert-danger text-center mt-5" role="alert">
                            A megadott felhasználónév nem létezik!
                          </div>';
                    echo '<script>
                            setTimeout(function() {
                                window.location.href = "login.php"; // Visszairányítjuk a bejelentkezési oldalra
                            }, 3000); // 3 másodperc múlva átirányítjuk
                          </script>';
                } else {
                    // Ha a felhasználó létezik, megnézzük a jelszót
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Ellenőrizzük, hogy a megadott jelszó egyezik-e a titkosított jelszóval
                    if (password_verify($password, $user['password'])) {
                        // Ha a jelszó helyes, beállítjuk a munkamenetet
                        $_SESSION['user_id'] = $user['id']; // Felhasználó azonosítója
                        $_SESSION['user_name'] = $user['user_name']; // Felhasználónév
                        $_SESSION['user_rang'] = $user['rang']; // Felhasználói rang
        
                        // Átirányítás a kezdőlapra vagy egy védett oldalra
                        echo '<div class="alert alert-success text-center mt-5" role="alert">
                                Bejelentkezés sikeres! Átirányítás...
                              </div>';
                        echo '<script>
                                setTimeout(function() {
                                    window.location.href = "index.php"; // Visszairányítjuk a főoldalra
                                }, 1000); // 3 másodperc múlva átirányítjuk
                              </script>';
                    } else {
                        // Ha a jelszó nem egyezik
                        echo '<div class="alert alert-danger text-center mt-5" role="alert">
                                Hibás jelszó!
                              </div>';
                        echo '<script>
                                setTimeout(function() {
                                    window.location.href = "login.php"; // Visszairányítjuk a bejelentkezési oldalra
                                }, 1000); // 3 másodperc múlva átirányítjuk
                              </script>';
                    }
                }
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger text-center mt-5" role="alert">
                        Hiba történt: ' . $e->getMessage() . '
                      </div>';
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "login.php"; // Visszairányítjuk a bejelentkezési oldalra
                        }, 1000); // 3 másodperc múlva átirányítjuk
                      </script>';
            }
        }
        ?>
    </div>

    <!-- Bootstrap JS és Popper.js linkek -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>