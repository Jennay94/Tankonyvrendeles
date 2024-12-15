<?php

$username = $_POST['username'];
$pass = $_POST['password'];

# mysql connect



#ha megvan akkor select a users táblára, hogy létezik-e a $user változó értéke
# ha igen, ellenőrizd hogy a $pass megegyezik-e a táblában tárolt adattal a $username változóval ellátott usernél

# ha létezik akkor $_SESSION['username'] = $username;
