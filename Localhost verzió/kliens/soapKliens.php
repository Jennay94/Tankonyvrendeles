<?php
	//ini_set("default_socket_timeout", 5000);
   $options = array(
   "location" => "http://localhost/beadando/szerver/soapSzerver.php",
   "uri" => "http://localhost/beadando/szerver/soapSzerver.php",
   'keep_alive' => false,
    //'trace' =>true,
    //'connection_timeout' => 5000,
    //'cache_wsdl' => WSDL_CACHE_NONE,
   );		

   try {
	$kliens = new SoapClient(null, $options);
	echo $kliens->szoveg()."<br>"; 
	$eredm = $kliens->ketszeres(5);
	echo $eredm."<br>"; 
	echo $kliens->ido()."<br>"; 
	echo $kliens->get3X()."<br>"; 
	$eredm = $kliens->adatok();
	var_dump($eredm);
	echo "<br>";
	foreach ($eredm as $elem)
		echo $elem."<br>";	
   } catch (SoapFault $e) 
   {
		var_dump($e);
   }
	$url = "http://localhost/beadando/szerver/soapSzerver.php";
	// Az oldal tetején megjelenítendő üzenet POST, PUT, DELETE módszer esetén, valamint akkor,
	// ha az oldal alján lévő űrlapba nem írunk semmit és úgy kattintunk a Küldés gombra
	$result = "";
	// induláskor nem lép be ide, mert a $_POST tömb még üres.
	// Az űrlap adatait POST módszerrel küldte el önmagának (index.php)
	if(isset($_POST['id']))
	{
		// Felesleges szóközök eldobása
		$_POST['id'] = trim($_POST['id']);
		$_POST['csn'] = trim($_POST['csn']);
		$_POST['un'] = trim($_POST['un']);
		$_POST['bn'] = trim($_POST['bn']);
		$_POST['jel'] = trim($_POST['jel']);
		// Ha nincs id és megadtak minden adatot (családi név, utónév, bejelentkezési név, jelszó),
		// akkor beszúrás: POST módszerrel továbbítja az adatokat a szerver felé
		if($_POST['id'] == "" && $_POST['csn'] != "" && $_POST['un'] != "" && $_POST['bn'] != "" && $_POST['jel'] != "")
		{
			// A küldendő adatokat beteszi a $data asszociatív tömbbe.
			$data = Array("csn" => $_POST["csn"], "un" => $_POST["un"], "bn" => $_POST["bn"], "jel" => sha1($_POST["jel"]));
			// https://www.php.net/manual/en/function.curl-init.php
			// Initialize a cURL session
			$ch = curl_init($url);
			// https://www.php.net/manual/en/function.curl-setopt.php
			// Set an option for a cURL transfer
			// CURLOPT_POST: TRUE to do a regular HTTP POST. This POST is the normal
			// application/x-www-form-urlencoded kind, most commonly used by HTML forms.
			curl_setopt($ch, CURLOPT_POST, 1);
			// CURLOPT_POSTFIELDS: The full data to post in a HTTP "POST" operation.
			// https://www.php.net/manual/en/function.curl-setopt.php
			// http_build_query: Generates a URL-encoded query string from the associative (or indexed)
			// array provided. https://www.php.net/manual/en/function.http-build-query.php
			// A $data mezőit egy stringként kell továbbítani, ezért a tömböt először át kell alakítani stringgé
			// a http_build_query($data) String ehhez hasonló lesz:
			// csn=bbb&un=bbb&bn=bbb&jel=5cb138284d431abd6a053a56625ec088bfb88912
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			// CURLOPT_RETURNTRANSFER: TRUE to return the transfer as a string of the return value of
			// curl_exec() instead of outputting it directly.
			// https://www.php.net/manual/en/function.curl-setopt.php
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// https://www.php.net/manual/en/function.curl-exec.php
			// Execute the given cURL session.
			// a szervertől küldött adatot a $result változóba teszi
			$result = curl_exec($ch);
			// https://www.php.net/manual/en/function.curl-close.php
			// closes a cURL session and frees all resources. The cURL handle, ch, is also deleted.
			curl_close($ch);
		}
		// Ha nincs id, de nem adtak meg minden adatot
		elseif($_POST['id'] == "")
		{
			$result = "Hiba: Hiányos adatok!";
		}
		// Innen már hasonló, mint az előzőek, ezért csak az újdonságot nézzük meg
		// Ha van id, amely >= 1, és megadták legalább az egyik adatot (családi név, utónév, bejelentkezési név, jelszó), akkor módosítás
		elseif($_POST['id'] >= 1 && ($_POST['csn'] != "" || $_POST['un'] != "" || $_POST['bn'] != "" || $_POST['jel'] != ""))
		{
			$data = Array("id" => $_POST["id"], "csn" => $_POST["csn"], "un" => $_POST["un"], "bn" => $_POST["bn"], "jel" => $_POST["jel"]);
			$ch = curl_init($url);
			// CURLOPT_CUSTOMREQUEST:
			// A custom request method to use instead of "GET" or "HEAD" when doing a HTTP request. This is
			// useful for doing "DELETE" or other, more obscure HTTP requests. Valid values are things like
			// "GET", "POST", "CONNECT" and so on; i.e.
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		// Ha van id, amely >=1, de nem adtak meg egy adatot sem: törlés
		elseif($_POST['id'] >= 1)
		{
			$data = Array("id" => $_POST["id"]);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		// Ha van id, de rossz az id, akkor a hiba kiírása
		else
		{
			echo "Hiba: Rossz azonosító (Id): ".$_POST['id']."<br>";
		}
}
// induláskor itt kezdi:
// MINDEN ESETBEN végrehajtja a következő részt:
// lekérdezi az adatbázis felhasználók tábla adatait és azt egy HTML táblázatban adja vissza a
// $tabla változóban, amit majd kiírat az oldalon a HTML kódnál.
// https://www.php.net/manual/en/function.curl-init.php

// Initialize a cURL session
$ch = curl_init($url);
// https://www.php.net/manual/en/function.curl-setopt.php
// Set an option for a cURL transfer
// CURLOPT_RETURNTRANSFER: TRUE to return the transfer as a string of the return value of
// curl_exec() instead of outputting it directly.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// https://www.php.net/manual/en/function.curl-exec.php
// Execute the given cURL session.
// Ha nem adunk meg módszert, akkor lapból GET módszert használ.
// A szerver által visszadott adatot, (ami most egy HTML táblázat string) teszi a $tabla változóba.
$tabla = curl_exec($ch);
// https://www.php.net/manual/en/function.curl-close.php
// closes a cURL session and frees all resources. The cURL handle, ch, is also deleted.
curl_close($ch);
// Mivel az előző részt minden esetben végrahajtotta, ezért a $tabla változóban lesz minden esetben az
// adatbázis felhasználók tábla adatai egy HTML táblázatban
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Soap</title>
</head>
<body>
// Megjeleníti a $result stringet:
<?= $result ?>
<h1>Felhasználók:</h1>
// kiíratja az adatbázis felhasználók tábla adatait MINDEN ESETBEN:
<?= $tabla ?>
<br>
<h2>Módosítás / Beszúrás</h2>
// Űrlap. Az űrlap adatait POST módszerrel továbbítja önmagának (kliens.php):
<form method="post">
// 5 db szöveges beviteli mező: id, csn (családi név), un, bn, jel
Id: <input type="text" name="id"><br><br>
Családi név: <input type="text" name="csn" maxlength="45"> Utónév: <input type="text" name="un" maxlength="45"><br><br>
Bejelentkezési név: <input type="text" name="bn" maxlength="12"> Jelszó: <input type="text" name="jel"><br><br>
// Küldés gomb
<input type="submit" value = "Küldés">
</form>
</body>
</html>