<?php
require 'db.php';

class TankonyvSOAP {
    private $pdo;

    public function __construct() {
        global $pdo;
        $this->pdo = $pdo;
    }

    public function getStudents() {
        $stmt = $this->pdo->query("SELECT * FROM diak");
        return $stmt->fetchAll();
    }

    public function getOrders() {
        $stmt = $this->pdo->query("
            SELECT r.*, d.nev AS diak_nev, t.cim AS konyv_cim 
            FROM rendeles r
            JOIN diak d ON r.diakaz = d.az
            JOIN tk t ON r.tkaz = t.az
        ");
        return $stmt->fetchAll();
    }

    public function getBooks() {
        $stmt = $this->pdo->query("SELECT * FROM tk");
        return $stmt->fetchAll();
    }
}

$options = [
    'uri' => 'http://localhost/tankonyvrendeles/soap_server.php',
];
$server = new SoapServer(null, $options);
$server->setClass('TankonyvSOAP');
$server->handle();
?>
