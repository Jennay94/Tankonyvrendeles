<?php
ini_set("soap.wsdl_cache_enabled", "0");
require_once('db.php');  // Adatbázis kapcsolódás

class UserService
{
    // Diákok lekérése
    public function getDiakok()
    {
        global $pdo;
        $sql = "SELECT az, nev,osztaly FROM diak";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }

    // Oldalak lekérése
    public function getPages()
    {
        global $pdo;
        $sql = "SELECT id,name,url,parent_id,rang FROM pages";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }

    // Rendelések lekérése
    public function getRendelesek()
    {
        global $pdo;
        $sql = "SELECT az,ev,tkaz,diakaz,ingyenes FROM rendeles";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }

    // Tankönyvek lekérése
    public function getTk()
    {
        global $pdo;
        $sql = "SELECT az,kiadoikod,cim,targy FROM tk";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }

    // Tankönyv kategóriák lekérése
    public function getTkar()
    {
        global $pdo;
        $sql = "SELECT ev,tkaz,ertek FROM tkar";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }

    // Felhasználók lekérése
    public function getUsers()
    {
        global $pdo;
        $sql = "SELECT id,user_name,password,rang,last_name,first_name,email FROM users";
        $stmt = $pdo->query($sql);
        $result = $stmt->fetchAll();

        return $result;
    }
}

$server = new SoapServer(NULL, [
    'uri' => "http://tankonyrendeles.nhely.hu/soap_server.php"
]);

$server->setClass('UserService');
$server->handle();
?>