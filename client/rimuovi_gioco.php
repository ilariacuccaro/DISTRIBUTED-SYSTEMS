<?php
//pagina che esegue la rimozione dei vestiti nel DB da parte del  negozio
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client1 = new SoapClient($wsdl_url);
$nome = $_SESSION['nome'];
$codice = $_POST['codice'];
$disponibili=0;
$array=array();
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
try{
	$disponibili=$Client1->disponibili_gioco($giocatori,$titolo,$prezzo,$etaMinima,$durata,$nome);
}catch (Exception $e) {
		echo "<h2>Exception Error! addgioco</h2>";
		echo $e->getMessage();
}
if($disponibili==1){

	try{
		$Client1->removegioco($codice);
		}
		catch (Exception $e) {
			echo "<h2>Exception Error! addgioco</h2>";
			echo $e->getMessage();
		}
}else{
//echo $disponibili;
	$disponibili=$disponibili-1;
	try{
		$Client1->addDisponibili($titolo,$giocatori,$prezzo,$etaMinima,$durata,$nome,$disponibili);
	}catch (Exception $e) {
		echo "<h2>Exception Error! addgioco</h2>";
		echo $e->getMessage();
	}
}
	header("location:lista_giochi.php");
?>
