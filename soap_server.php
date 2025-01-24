<?php
require_once 'db.php';

class TankonyvService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function getAllRendelesek($limit) {
            global $pdo;

            // Az adatbázis lekérdezés limitálása
            $stmt = $pdo->prepare("SELECT az, ev, tkaz, diakaz, ingyenes FROM rendeles LIMIT :limit");
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();

            $rendelesek = $stmt->fetchAll();
            
            return $rendelesek;
    }

    // Egy adott rendelés lekérése ID alapján
    public function getRendelesById($rendelesId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM rendeles WHERE az = :az");
        $stmt->bindValue(':az', $rendelesId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    // Új rendelés hozzáadása
    public function addRendeles($diakaz, $tkaz, $ev, $ingyenes)
    {
        $stmt = $this->pdo->prepare("INSERT INTO rendeles (diakaz, tkaz, ev, ingyenes) VALUES (:diakaz, :tkaz, :ev, :ingyenes)");
        $stmt->bindValue(':diakaz', $diakaz, PDO::PARAM_INT);
        $stmt->bindValue(':tkaz', $tkaz, PDO::PARAM_INT);
        $stmt->bindValue(':ev', $ev, PDO::PARAM_INT);
        $stmt->bindValue(':ingyenes', $ingyenes, PDO::PARAM_BOOL);
        $stmt->execute();
        return "Új rendelés sikeresen hozzáadva!";
    }
}

$options = ['uri' => 'http://localhost/tankonyvrendeles/'];
$server = new SoapServer(null, $options);

$service = new TankonyvService($pdo);
$server->setObject($service);

header("Content-Type: text/xml; charset=utf-8");

try {
    $server->handle();
} catch (Exception $e) {
    echo "SOAP Szerver hiba: " . $e->getMessage();
}
?>
