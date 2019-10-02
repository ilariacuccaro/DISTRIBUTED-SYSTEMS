<?php
/*Una volta creato il client Soap che punta al file wsdl viene richiamata la funzione addvestiti
che aggiunge al database i valori inseriti dal negozio*/
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client1 = new SoapClient($wsdl_url);

$titolo = $_POST['titolo'];
$giocatori = $_POST['giocatori'];
$prezzo = $_POST['prezzo'];
$etaMinima = $_POST['etaMinima'];
$durata = $_POST['durata'];
$nome = $_SESSION['nome'];
$codice=0;
$disponibili=0;
try{
	$disponibili=$Client1->disponibili_gioco($giocatori,$titolo,$prezzo,$etaMinima,$durata,$nome);
}catch (Exception $e) {
		echo "<h2>Exception Error! addgiochi</h2>";
		echo $e->getMessage();
}
echo $disponibili;
if($disponibili==0){
	$disponibili=1;
	$t=1;
	while($t>0){
		$codice = $codice +1;
		try{
			$t=$Client1->codice_gioco($codice);
		}catch (Exception $e) {
			echo "<h2>Exception Error! addgiochi</h2>";
			echo $e->getMessage();
		}
	}
	try{
		$Client1->addgiochi($titolo,$giocatori,$prezzo,$etaMinima,$durata,$nome,$codice,$disponibili);
	}catch (Exception $e) {
			echo "<h2>Exception Error! addgiochi</h2>";
			echo $e->getMessage();
	}
}else{$disponibili=$disponibili+1;
echo $titolo;
	try{
		$Client1->addDisponibili($titolo,$giocatori,$prezzo,$etaMinima,$durata,$nome,$disponibili);
	}catch (Exception $e) {
		echo "<h2>Exception Error! addgiochi</h2>";
		echo $e->getMessage();
	}
}
	header("location:negozio.php");
?>
