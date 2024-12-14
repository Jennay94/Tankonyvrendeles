<?php
	class Szolgaltatas {
		private $x =50;
		public function szoveg()  {
			return "Hello";
		}
		public function ketszeres($y){
			return 2*$y;
		}
		public function ido()  {
			return date("Y-m-d H:i:s",time());
		}
		public function get3X()  {
			return $this->x*3;
		}
		public function adatok()  {
			$eredmeny = Array();
			$eredmeny[] = "Szöveg1";
			$eredmeny[] = 20;
			$eredmeny[] = 25.34;
			return $eredmeny;
		}
	}
	$options = array("uri" => "http://localhost/beadando/szerver/soapSzerver.php");
	$server = new SoapServer(null, $options);
	$server->setClass('Szolgaltatas');
	$server->handle();
?>

<?php
// A szkript ereménye az $eredmeny nevű string.
// lásd végén: echo $eredmeny;
// mind a 4 esetben (GET, POST, PUT, DELETE) ezt készíti el
$eredmeny = "";
$eredmeny2 = "";
try {
	// belép az adatbázisba:
	$dbh = new PDO('mysql:host=localhost;dbname=tankonyvrendeles', 'root', '',
	array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	$dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
	// lekérdezi a módszert: GET, POST, PUT, DELETE
	switch($_SERVER['REQUEST_METHOD']) 
	{
		// GET módszer esetén:
		// -lekérdezi a felhasznalok tábla adatait
		// - az $eredmeny stringbe elkészít egy HTML táblázatot,
		// amiben megjeleníti a felhasználók tábla adatait
		case "GET":
			$sql = "SELECT * FROM users";
			//$sql2 = "SELECT * FROM diak";
			$sql3 = "
				SELECT diak.nev as DiakNeve, diak.osztaly as Osztaly, rendeles.ev as RendelesEve, rendeles.ingyenes as Ingyenes, tk.kiadoikod as KiadoiKod, tk.cim as Cim, tk.targy as Targy FROM diak, rendeles, tkar, tk WHERE diak.az = rendeles.diakaz AND rendeles.ev = tkar.ev AND tkar.tkaz = tk.az AND rendeles.diakaz = '140';
			";


			$sth = $dbh->query($sql);
			//$sth2 = $dbh->query($sql2);
			$sth3 = $dbh->query($sql3);
			// HTML táblázat készítése a kiolvasott adatokkal:
			$eredmeny .= "<table style=\"border-collapse: collapse;\">
				<tr>
					<th>ID</th>
					<th>User Name</th>
					<th>Password (HASH)</th>
					<th>Rang</th>
					<th>Keresztnév</th>
					<th>Vezeték név</th>
					
					
				</tr>";
			while($row = $sth->fetch(PDO::FETCH_ASSOC)) 
			{
				$eredmeny .= "<tr>";
				foreach($row as $column)
					$eredmeny .= "<td style=\"border: 1px solid black; padding: 3px;\">".$column."</td>";
					$eredmeny .= "</tr>";
			}
			$eredmeny .= "</table>";

			/*$eredmeny2 .= "<table style=\"border-collapse: collapse;\">
				<tr>
					<th>ID</th>
					<th>Név</th>
					<th>Osztály</th>
				</tr>";
			while($row = $sth2->fetch(PDO::FETCH_ASSOC)) 
			{
				$eredmeny2 .= "<tr>";
				foreach($row as $column)
					$eredmeny2 .= "<td style=\"border: 1px solid black; padding: 3px;\">".$column."</td>";
					$eredmeny2 .= "</tr>";
			}
			$eredmeny2 .= "</table>";
			*/

			$eredmeny3 .= "<table style=\"border-collapse: collapse;\">
				<tr>
					<th>Diák Neve</th>
					<th>Osztály</th>
					<th>Rendelés éve</th>
					<th>Ingyenes</th>
					<th>Kiadói kód</th>
					<th>Cím</th>
					<th>Tárgy</th>
				</tr>";
				while($row = $sth3->fetch(PDO::FETCH_ASSOC)) 
				{
					$eredmeny3 .= "<tr>";
					foreach($row as $column)
						$eredmeny3 .= "<td style=\"border: 1px solid black; padding: 3px;\">".$column."</td>";
						$eredmeny3 .= "</tr>";
				}
			$eredmeny3 .= "</table>";
			break;
			// POST módszer esetén:
			// Preparált lekérdezéssel beszúrja a kapott adatokat a felhasználók táblába
		case "POST":
			$sql = "insert into felhasznalok values (0, :csn, :un, :bn, :jel)";
			$sth = $dbh->prepare($sql);
			// A klienstől küldött adatokat 2 lépesben olvassuk ki a $data változóba:
			// file_get_contents: Reads entire file into a string
			// https://www.php.net/manual/en/function.file-get-contents.php
			// php://input: This is a read-only stream that allows us to read raw data from the request body.
			// It returns all the raw data after the HTTP-headers of the request, regardless of the content type.
			// https://www.geeksforgeeks.org/how-to-receive-json-post-with-php/
			$incoming = file_get_contents("php://input");
			// parse_str: Parses the string into variables
			// https://www.php.net/manual/en/function.parse-str.php
			parse_str($incoming, $data);
			$count = $sth->execute(Array(":csn"=>$data["csn"], ":un"=>$data["un"], ":bn"=>$data["bn"], ":jel"=>$data["jel"]));
			// Ez is jó lenne, mert a $_POST tömbben IS megjelenik az elküldött adat:
			// Ilyenkor ezek sem kellenének:
			// $incoming = file_get_contents("php://input");
			// parse_str($incoming, $data);
			//$count = $sth->execute(Array(":csn"=>$_POST["csn"], ":un"=>$_POST["un"], ":bn"=>$_POST["bn"], ":jel"=>$_POST["jel"]));
			// lastInsertId():Returns the ID of the last inserted row or sequence value
			// https://www.php.net/manual/en/pdo.lastinsertid.php
			$newid = $dbh->lastInsertId();
			// Ebben az esetben a szerver által visszaadott eredmény string ehhez hasonló lesz:
			// 1 beszúrt sor: 12 (1 db sort szúrt be a 12. pozícióba)
			$eredmeny .= $count." beszúrt sor: ".$newid;
			break;
			// PUT módszer esetén:
		case "PUT":
			$data = array();
			$incoming = file_get_contents("php://input");
			parse_str($incoming, $data);
			// Update esetén ehhez hasonló lekérdezést kell összeállítani preparált formában:
			// UPDATE felhasznalok SET csaladi_nev = 'Kovács', utonev = 'Ferenc'
			// WHERE id = 1;
			// A $modositando stringbe állítja össze a preparált lekérdezés
			// Update felhasznalok set ……… where kipontozott részét
			// A $params tömbbe állítja össze a preparált lekérdezéshez az adatokat,
			// amiket a változók helyére kell beszúrni
			// amelyik adat benne van a $data tömbben, azzal kiegészíti a $modositando stringet és a $params tömböt
			// Az id biztos, hogy benne van a $data tömbben
			$modositando = "id=id"; $params = Array(":id"=>$data["id"]);
			if($data['csn'] != "") {$modositando .= ", csaladi_nev = :csn"; $params[":csn"] = $data["csn"];}
			if($data['un'] != "") {$modositando .= ", utonev = :un"; $params[":un"] = $data["un"];}
			if($data['bn'] != "") {$modositando .= ", bejelentkezes = :bn"; $params[":bn"] = $data["bn"];}
			if($data['jel'] != "") {$modositando .= ", jelszo = :jel"; $params[":jel"] = sha1($data["jel"]);}
			$sql = "update users set ".$modositando." where id=:id";
			$sth = $dbh->prepare($sql);
			$count = $sth->execute($params);
			$eredmeny .= $count." módositott sor. Azonosítója:".$data["id"];
		break;
			// DELETE módszer esetén:
		case "DELETE":
			// Mint a PUT módszernél: kiolvassuk a küldött adatokat
			$data = array();
			$incoming = file_get_contents("php://input");
			parse_str($incoming, $data);
			// DELETE esetén csak az ID van továbbítva
			// törli a felhasznalok táblából azt a rekordot, amelyiknek meg lett adva az ID-je.
			$sql = "delete from felhasznalok where id=:id";
			$sth = $dbh->prepare($sql);
			$count = $sth->execute(Array(":id" => $data["id"]));
			$eredmeny .= $count." sor törölve. Azonosítója:".$data["id"];
		break;
	}
}
catch (PDOException $e) 
{
	$eredmeny = $e->getMessage();
	$eredmeny2 = $e->getMessage();
}
echo $eredmeny;
//echo $eredmeny2;
echo $eredmeny3;
?>