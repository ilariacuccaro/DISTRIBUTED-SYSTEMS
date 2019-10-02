<?php
//pagina che esegue la rimozione dei tavoli
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client1 = new SoapClient($wsdl_url);
$nome = $_SESSION['nome'];
$numeroTavolo = $_POST['numeroTavolo'];
$prenotatoT=1;

	if($prenotatoT==1){
	try{
		$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
		if($nome=='DalTenda'){
			$query = "SELECT nomenegozio FROM tavoliprenotati WHERE nomenegozio='DalTenda';";
			$res = mysqli_query($db, $query);
			$row = mysqli_fetch_array($res);
			$nomenegozio=$row['nomenegozio'];
			if($nomenegozio){
				$disponibiliT=1;
				$query = "INSERT INTO tavoli_negozio1(numeroTavolo,disponibiliT,nomenegozio) VALUES ('$numeroTavolo','$disponibiliT','DalTenda');";
						$result = $db->query($query);
	    }
			$query = "DELETE FROM tavoliprenotati WHERE numeroTavolo='{$numeroTavolo}';";
			$result = $db->query($query);
		}else{
			$query = "SELECT nomenegozio FROM tavoliprenotati WHERE nomenegozio='PoloNerd';";
			$res = mysqli_query($db, $query);
			$row = mysqli_fetch_array($res);
			$nomenegozio=$row['nomenegozio'];
			if($nomenegozio){
				$disponibiliT=1;
				$query = "INSERT INTO tavoli_negozio2(numeroTavolo,disponibiliT,nomenegozio) VALUES ('$numeroTavolo','$disponibiliT','PoloNerd');";
						$result = $db->query($query);
	    }
			$query = "DELETE FROM tavoliprenotati WHERE numeroTavolo='{$numeroTavolo}';";
			$result = $db->query($query);
		}
   }catch (Exception $e) {
			echo "<h2>Exception Error! addtavolo</h2>";
			echo $e->getMessage();
		}
	}
	header("location:lista_tavoliprenotati.php");
?>
