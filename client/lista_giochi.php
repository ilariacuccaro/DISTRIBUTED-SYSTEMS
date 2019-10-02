<?php
require "MySQL.php";
//visualizza nel database i giochi presenti, è inoltre possibile la cancellazione
session_start(); //apro la sessione
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";  //recupero il file wsdl
$Client1 = new SoapClient($wsdl_url); //la classe SoapClient fornisce un client per il server
$nome = $_SESSION['nome'];
$array=array();

try{
		$array=$Client1->magazzino($nome);
		}
		catch (Exception $e) {
			echo "<h2>Exception Error! addgiochi</h2>";
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
<title>Dati di negozio</title>

<link rel="stylesheet" type="text/css" href="menu.css">
<link rel="stylesheet" type="text/css" href="/ricerca.css">

<style>
	body{
		background-image: url(sito/sfondoG.jpg);
	}
	h1{
	  text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
	}
	table{
		margin-top: -15px;
	}
	th{
		padding: 3px;
		background-color: #ffa07a;
	}
	td{
		padding: 3px;
	}
	h3{
		  text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
	}
</style>

</head>
<body bgcolor="lightyellow" >
<ul>
	<li><a class="active" href="negozio.php">&emsp;&emsp;Inserisci gioco&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active">&emsp;&emsp;&nbsp;Lista giochi&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active" href="lista_giochiprenotati.php">&emsp;&emsp;&nbsp;Lista giochi prenotati&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active" href="lista_tavoliprenotati.php">&emsp;&emsp;&nbsp;Lista tavoli prenotati&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active" href="lista_utenti.php">&emsp;&emsp;&nbsp;Lista utenti&emsp;&emsp;&nbsp;</a></li>
	<li style="float:right"><a href="logout.php">&emsp;&nbsp;&ensp;Loguot&emsp;&emsp;</a></li>
</ul>
<h1 align="center" id="intestazione">GIOCHI &nbsp;PRESENTI &nbsp;IN &nbsp;MAGAZZINO</h1>
</br>

<div class="div" align="center">
	<?php
echo '<table align="center" border="solid 1px #333333" style="width:100%; background-color:lightyellow";>';
$max=count($array);
echo '<tr><th>TITOLO</th><th>GIOCATORI</th><th>PREZZO</th><th>QUANTITÀ</th><th>CODICE</th></tr>';
for($i=0; $i<$max; $i++){
$titolo=$array[$i]['titolo'];
$giocatori=$array[$i]['giocatori'];
$prezzo=$array[$i]['prezzo'];
$Codice=$array[$i]['Codice'];
$disponibili=$array[$i]['disponibili'];
	echo "<tr><td><div align=center> $titolo</div></td><td><div align=center> $giocatori</div></td><td><div align=center> $prezzo €</div></td><td><div align=center> $disponibili</div></td><td><div align=center> $Codice</div></td></tr>";
}
echo '</table>';
?>
</div>
<div align="center">
<h3>Se desideri rimuovere un gioco dal magazzino inserisci qui sotto il codice corrispondente.</h3>
			<form name="forminsert" method="post" action="rimuovi_gioco.php">
				<input placeholder = "codice" name = "codice" class = "box" required/><br/><br />
				<input type = "submit" value = " Rimuovi " class ="button" name="submit" style="background-color: rgba(192,192,192,0.5);"/><br /></div>
	</body>
</html>
