<?php
//pagina che visualizza il risultato della ricerca iniziale in base al numero di giocatori scelti dall'Utente standard
//qui è possibile fare una ricerca più accurata del gioco in base al titolo, provincia negozio o per prezzo
session_start();
require 'User.php';

$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client2 = new SoapClient($wsdl_url);
$mail=$_SESSION['mail'];

if(isset($_POST['titolo'])){
	$titoloStart = $_POST['titolo'];

	$Client2->tienimi($titoloStart);
}
else{
	$titoloStart = $Client2->ridammi();
}

$array=array();
$array2=array();

try{
		$array=$Client2->infogioco($titoloStart);
		}
		catch (Exception $e) {
			echo "<h2>Exception Error! addData</h2>";
			echo $e->getMessage();
		}
?>
<html>
		<?php
		if (isset($_SESSION['Err'])){
			echo $_SESSION['Err'];
		}
		?>
		<head>
<title>Info Giochi</title>
<link rel="stylesheet" type="text/css" href="menu.css">
<style>
body{
	background-image: url(sito/sfondoG.jpg);
}
 h2{
	 font-family: Georgia;
	 padding-top: 10px;
	 word-spacing: 8px;
	 text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
	 margin-bottom: 50px;
 }
 #gioco{
	 background-color: lightyellow;
	  text-align: center;
		width:100%;
		margin-top: -60px;
 }
 th{
	 background-color: #ffa07a;
	 height: 60px;
 }
 td{
	 padding-left: 10px;
	 padding-right: 10px;
	 padding-top: 3px;
	 padding-bottom: 3px;
 }
 #im{
	 background-color: white;
 }
		#tavolo{
			width: 600px;
			background-color: lightyellow;
			text-align: center;
			margin-left: 400px;
			margin-top: 20px;
		}
		#ta{
			width: 100%;
			padding: 3px;
		}
</style>
</head>
<body style = "background-color:lightyellow;">
	<ul>
		<li><a class="active" href="ricerca.php">&emsp;Ricerca&emsp;</a></li>
		<li style="float:right"><a class="active" href="lista_giochicliente.php">&emsp;Lista prenotati&emsp;</a></li>
	</ul>
		<h2 align="center" id="intestazione">ACQUISTALO ORA </br>O VIENI A PROVARLO NEI NOSTRI NEGOZI</h2>
		<?php
		echo '<table id="gioco" border="solid 1px brown">';
		$max=count($array);

				$titolo=$array[0]['titolo'];
				$giocatori=$array[0]['giocatori'];
				$prezzo=$array[0]['prezzo'];
				$etaMinima=$array[0]['etaMinima'];
				$durata=$array[0]['durata'];
				$nome=$array[0]['nome'];
				$codice=$array[0]['Codice'];

				try{
					$array2=$Client2->contattoEmail($nome);
					}
					catch (Exception $e) {
						echo "<h2>Exception Error! addData</h2>";
						echo $e->getMessage();
					}
				$mailnegozio=$array2[0]['mail'];
				$provincia=$array2[0]['provincia'];
				if($codice<=21){
		     echo "<tr><th style='padding-top:5px;padding-bottom:5px;'>TITOLO</th><th>GIOCATORI</th><th>PREZZO</th><th>ET&Agrave MINIMA</th><th>DURATA</th><th>NEGOZIO</th><th>PROVINCIA</th><th>CONTATTI</th>
         <th id='im' rowspan='2'><img src='/Giochi/client/img//$titolo.jpg' style='height:220px'></th>
				 <th rowspan='2' style='background-color:#ffa07a'><div align=center>Clicca </br>il codice</br>del gioco</br>per prenotarlo</br></br></br>
				 <form name='forminsert' method='post' action='prenotazione.php'>
				 <input type = 'submit' text ='Prenota' value = '$codice ' class ='button' name='prenota'/><br /><br />
				 </form></div></th></tr>";
			 }else {
				 echo "<tr><th style='padding-top:5px;padding-bottom:5px;'>TITOLO</th><th>GIOCATORI</th><th>PREZZO</th><th>ET&Agrave MINIMA</th><th>DURATA</th><th>NEGOZIO</th><th>PROVINCIA</th><th>CONTATTI</th>
				<th id='im' rowspan='2'><img src='/Giochi/client/sito//pedine-game.jpg' style='height:220px;width:250px'></th>
				<th rowspan='2' style='background-color:#ffa07a'><div align=center>Clicca </br>il codice</br>per prenotarlo</br></br></br>
				<form name='forminsert' method='post' action='prenotazione.php'>
				<input type = 'submit' text ='Prenota' value = '$codice ' class ='button' name='prenota'/><br /><br />
				</form></div></th></tr>";
        }
					echo "<tr>
						<td><div align=center> $titolo</div></td>
						<td><div align=center> $giocatori</div></td>
						<td><div align=center> $prezzo €</div></td>
						<td><div align=center> $etaMinima anni</div></td>
						<td><div align=center> $durata min</div></td>
						<td><div align=center> $nome</div></td>
						<td><div align=center> $provincia</div></td>
						<td><div align=center> $mailnegozio</div></td>

					</tr>";
	?>
	<!--MODIFICA TAVOLI -->

</br></br></br></br>
<form method="post" action="infogiochi.php" name="form1">
	<table id="tavolo" border="1 solid black">
		<tr>
			<td colspan="2"; style="padding:5px;">
				<label for="numero">Prenota un tavolo nei nostri negozi</br>Puoi venire a giocare con i tuoi amici o partecipare ai tornei organizzati dal nostro Team </label>
			</td>
		</tr>

		<tr>
			<td>
				Punto vendita DalTenda:
				<?php
				$link = mysqli_connect("localhost", "root", "", "db_giochi");
				$sql = "SELECT * FROM tavoli_negozio1 ORDER BY numeroTavolo";
				$res = mysqli_query($link, $sql);
			?>
				<select name="numero1">
					<option value="--">--</option>
    <?php
					while($row = mysqli_fetch_assoc($res)) {
						if(isset($_GET["numeroTavolo"]) && $_GET["numeroTavolo"] == $row['numeroTavolo'])
							print '<option value="'.$row['numeroTavolo'].'" selected>'.$row['numeroTavolo'].'</option>';
						else
							print '<option value="'.$row['numeroTavolo'].'">'.$row['numeroTavolo'].'</option>';
					}
    ?>
				</select>
			</td>
			<td>
				Punto vendita PoloNerd:
				<?php
				$link = mysqli_connect("localhost", "root", "", "db_giochi");
				$sql = "SELECT * FROM tavoli_negozio2 ORDER BY numeroTavolo";
				$res = mysqli_query($link, $sql);
			?>
				<select name="numero2">
					<option value="--">--</option>
    <?php
					while($row = mysqli_fetch_assoc($res)) {
						if(isset($_GET["numeroTavolo"]) && $_GET["numeroTavolo"] == $row['numeroTavolo'])
							print '<option value="'.$row['numeroTavolo'].'" selected>'.$row['numeroTavolo'].'</option>';
						else
							print '<option value="'.$row['numeroTavolo'].'">'.$row['numeroTavolo'].'</option>';
					}
    ?>
				</select>
			</td>
		</tr>
		<tr><td align="center" colspan="2" style="padding:5px;"><input id="ta" type="submit" name="dettaglio" value="Prenota ora" /></td>
		</tr>
	</table>
</form>
<?php
if(isset($_POST["numero1"]) && $_POST["numero1"] != "--") {
		$sql = "SELECT * FROM tavoli_negozio1 WHERE numeroTavolo=".$_POST['numero1'];
		$res = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($res);
		$numeroTavolo=$row['numeroTavolo'];
		$disponibiliT=$row['disponibiliT'];
		$nomenegozio=$row['nomenegozio'];

	if(isset($_POST['dettaglio'])){
		if($disponibiliT==1){
			$disponibiliT=$disponibiliT-1;
			$query = "DELETE FROM tavoli_negozio1 WHERE numeroTavolo='{$numeroTavolo}';";
      $result = $link->query($query);
			$prenota=1;
	 		$query = "INSERT INTO tavoliprenotati(numeroTavolo,prenotatoT,nome,nomenegozio) VALUES ('$numeroTavolo','$prenota','$mail','$nomenegozio');";
	 		    $result = $link->query($query);

		echo "<div align=center stile='font-size:16px;'></br>Il tuo tavolo è stato prenotato</div>";
	  }
	}
}
if(isset($_POST["numero2"]) && $_POST["numero2"] != "--") {
		$sql = "SELECT * FROM tavoli_negozio2 WHERE numeroTavolo=".$_POST['numero2'];
		$res = mysqli_query($link, $sql);
		$row = mysqli_fetch_array($res);
		$numeroTavolo=$row['numeroTavolo'];
		$disponibiliT=$row['disponibiliT'];
		$nomenegozio=$row['nomenegozio'];

	if(isset($_POST['dettaglio'])){
		if($disponibiliT==1){
			$disponibiliT=$disponibiliT-1;
			$query = "DELETE FROM tavoli_negozio2 WHERE numeroTavolo='{$numeroTavolo}';";
      $result = $link->query($query);
			$prenota=1;
	 		$query = "INSERT INTO tavoliprenotati(numeroTavolo,prenotatoT,nome,nomenegozio) VALUES ('$numeroTavolo','$prenota','$mail','$nomenegozio');";
	 		    $result = $link->query($query);

		echo "<div align=center stile='font-size:16px;'></br>Il tuo tavolo è stato prenotato</div>";
	  }
	}
}
 ?>
</body>
</html>
