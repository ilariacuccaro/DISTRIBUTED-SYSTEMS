<?php
/*Una volta creato il client Soap che punta al file wsdl viene richiamata la funzione addgioco
che aggiunge al database i valori inseriti dal negozio*/
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client1 = new SoapClient($wsdl_url);
$codice=$_POST['prenota'];
$prenotati=0;
$disponibili=0;
$mail = $_SESSION['mail'];

try{
		$array=$Client1->gioco_rimosso($codice);
	}catch (Exception $e) {
			echo "<h2>Exception Error! addgioco</h2>";
			echo $e->getMessage();
	}
		$titolo=$array[0]['titolo'];
		$giocatori=$array[0]['giocatori'];
		$prezzo=$array[0]['prezzo'];
		$etaMinima=$array[0]['etaMinima'];
		$durata=$array[0]['durata'];
		$nome=$array[0]['nome'];
try{
	$prenotati=$Client1->prenotate_giochi($codice);
}catch (Exception $e) {
		echo "<h2>Exception Error! addgioco</h2>";
		echo $e->getMessage();
}
if( $prenotati == 0 ){
	try{

		$Client1->prenotagioco($codice,$mail);
	}
	catch (Exception $e) {
		echo "<h2>Exception Error! addData</h2>";
		echo $e->getMessage();
	}

}else{
	$prenotati = $prenotati+1;
	try{
		$Client1->addPrenotati($prenotati,$codice);
	}catch (Exception $e) {
		echo "<h2>Exception Error! addgioco</h2>";
		echo $e->getMessage();
	}
	}
echo $disponibili;
try{
	$disponibili = $Client1->prendoDisponibili($codice);
}catch (Exception $e) {
	echo "<h2>Exception Error! addgioco</h2>";
	echo $e->getMessage();
}

if( $disponibili == 1){
	try{
		$Client1->removegioco($codice);
		}
		catch (Exception $e) {
			echo "<h2>Exception Error! addgioco</h2>";
			echo $e->getMessage();
		}
}else{
		$disponibili=$disponibili-1;
		try{
		$Client1->addDisponibili($titolo,$giocatori,$prezzo,$etaMinima,$durata,$nome,$disponibili);
	}catch (Exception $e) {
		echo "<h2>Exception Error! addgioco</h2>";
		echo $e->getMessage();
	}
}
header("location:infogiochi.php");
?>
