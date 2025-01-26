<!DOCTYPE html>
<html lang="hu">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Regisztráció</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

  <div class="container">
    <?php
    include "db.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $last_name = $_POST['last_name'];
      $first_name = $_POST['first_name'];
      $user_name = $_POST['user_name'];
      $email = $_POST['email'];
      $password = $_POST['password'];

      try {

        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_name = :user_name");
        $stmt->bindParam(':user_name', $user_name);
        $stmt->execute();

        // Ha van már ilyen felhasználó
        if ($stmt->rowCount() > 0) {

          echo '<div class="alert alert-danger text-center mt-5" role="alert">
                    A felhasználónév már létezik.
                  </div>';
          echo '<script>
                    setTimeout(function() {
                        window.location.href = "register.php";
                    }, 1000); 
                  </script>';
        } else {
          // Új felhasználó beszúrása
          $stmt = $pdo->prepare("INSERT INTO users (last_name, first_name, user_name, email, password, rang) 
                                   VALUES (:last_name, :first_name, :user_name, :email, :password, :rang)");

          // Jelszó titkosítása
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          $rang = 102; // Alapértelmezett rang
    

          $stmt->bindParam(':last_name', $last_name);
          $stmt->bindParam(':first_name', $first_name);
          $stmt->bindParam(':user_name', $user_name);
          $stmt->bindParam(':email', $email);
          $stmt->bindParam(':password', $hashed_password);
          $stmt->bindParam(':rang', $rang);

          // Lekérdezés végrehajtása
          $stmt->execute();
          echo '<div class="alert alert-success text-center mt-5" role="alert">
                    Felhasználó sikeresen regisztrálva!
                  </div>';
          echo '<script>
                    setTimeout(function() {
                        window.location.href = "index.php";
                    }, 1000); 
                  </script>';
        }
      } catch (PDOException $e) {
        echo '<div class="alert alert-danger text-center mt-5" role="alert">
                Hiba történt: ' . $e->getMessage() . '
              </div>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "register.php";
                }, 1000); 
              </script>';
      }
    }
    ?>

  </div>


  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>