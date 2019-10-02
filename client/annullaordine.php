<?php
//pagina che esegue la rimozione dei giochi in prenotazione nel DB
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$drs1Client = new SoapClient($wsdl_url);
$nome = $_SESSION['nome'];
$codice = $_POST['codice'];
$disponibili=0;

try{
	$prenotati=$drs1Client->prenotati_giochi($codice);
}catch (Exception $e) {
		echo "<h2>Exception Error! addgioco</h2>";
		echo $e->getMessage();
}

if($prenotati==0){
	try{
		$drs1Client->removegiocoprenotato($codice);
		}
		catch (Exception $e) {
			echo "<h2>Exception Error! addgioco</h2>";
			echo $e->getMessage();
		}
}else {
	$prenotati -1;
	try{
		$drs1Client->addPrenotati($prenotati,$codice);
	}catch (Exception $e) {
		echo "<h2>Exception Error! addgioco</h2>";
		echo $e->getMessage();
	}
}
	header("location:lista_giochicliente.php");
?>
