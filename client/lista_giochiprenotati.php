<?php
require "MySQL.php";
//visualizza i giochi in prenotazione, è anche possibile rimuovere i giochi presenti nel DB
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client1 = new SoapClient($wsdl_url);
$nomenegozio = $_SESSION['nome'];
$mail = $_SESSION['mail'];
$array=array();
try{
		$array=$Client1->magazzinoPrenotati($nomenegozio);
		}
		catch (Exception $e) {
			echo "<h2>Exception Error! addgioco</h2>";
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
<title>Dati del negozio</title>
<link rel="stylesheet" type="text/css" href="menu.css">
<link rel="stylesheet" type="text/css" href="/ricerca.css">
<style>
	body{
		background-image: url(sito/sfondoG.jpg);
	}
	h1{
		  text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
	}
	th{
		padding: 8px;
		background-color: #ffa07a;
	}
	td{
		padding: 8px;
	}
	h3{
		   text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
	}
</style>

</head>
<body bgcolor="lightyellow" >
<ul>
	<li><a class="active" href="negozio.php">&emsp;&emsp;Inserisci gioco&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active" href="lista_giochi.php">&emsp;&emsp;&nbsp;Lista giochi&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active">&emsp;&emsp;&nbsp;Lista giochi prenotati&nbsp;&emsp;&emsp;</a></li>
	<li><a href="lista_tavoliprenotati.php" class="active">&emsp;&emsp;&nbsp;Lista tavoli prenotati&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active" href="lista_utenti.php">&emsp;&emsp;&nbsp;Lista utenti&emsp;&emsp;&nbsp;</a></li>
	<li style="float:right"><a href="logout.php">&emsp;&emsp; Loguot&emsp;&emsp;</a></li>
</ul>
	<h1 align="center" id="intestazione">GIOCHI &nbsp;PRENOTATI&nbsp; DAGLI&nbsp; UTENTI</h1>
</br>

<div class="div" align="center">
	<?php
echo '<table align="center" border="solid 1px #333333"  style="width:100%; background-color:lightyellow";>';
$max=count($array);
echo '<tr><th>TITOLO</th><th>PREZZO</th><th>PRENOTAZIONI</th><th>CLIENTE</th><th>CODICE</th></tr>';
for($i=0; $i<$max; $i++){
$titolo=$array[$i]['titolo'];
$prezzo=$array[$i]['prezzo'];
$Codice=$array[$i]['Codice'];
$prenotati=$array[$i]['prenotati'];
$nome=$array[$i]['nome'];
$negozio=$array[$i]['nomenegozio'];

if($nomenegozio==$negozio)
	echo "<tr><td><div align=center> $titolo</div></td><td><div align=center> $prezzo €</div></td><td><div align=center> $prenotati</div></td><td><div align=center> $nome</div></td><td><div align=center> $Codice</div></td></tr>";
}
echo '</table>';
?>
</br>
</div>
<div align="center">
<h3>E' possibile annullare l'ordine del cliente inserendo il codice del gioco corrispondente.</h3>
			<form name="forminsert" method="post" action="rimuovi_giocoprenotato.php">
				<input placeholder = "codice" name = "codice" class = "box" required/></br></br>
				<input type = "submit" value = " Rimuovi " class ="button" name="submit" style="background-color: rgba(192,192,192,0.5);"/></br>
			</form>
 </div>

	</body>
</html>
