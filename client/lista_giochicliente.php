<?php
require "MySQL.php";
//pagina del negozio che visualizza i giochi in prenotazione, è anche possibile rimuovere i giochi presenti nel DB
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client1 = new SoapClient($wsdl_url);
$mail = $_SESSION['mail'];
$nome=$_SESSION['nome'];
$array=array();

try{
		$array=$Client1->magazzinoPrenotati($mail);
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
<title>Dati ordine</title>
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
		background-color: lightyellow;
		width: 800px;
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
		.div {
		    border-radius: 5px;
		    background-color: ;
		    padding: 10px;
		    min-height: 0px;
		}
</style>

</head>
<body bgcolor="lightyellow" >
<ul>
<li><a class="active" href="ricerca.php">&emsp;Ricerca&emsp;</a></li>
<li style="float:right"><a href="logout.php" class="active">&emsp;Logout&emsp;</a></li>
</ul>
	<h1 align="center" id="intestazione">I &nbsp; TUOI&nbsp; ORDINI</h1>

<div class="div" align="center">
	<?php
echo '<table align="center" border="solid 1px #333333" width="100%">';
$max=count($array);
echo '<tr><th>TITOLO</th><th>PREZZO</th><th>CODICE</th></tr>';
for($i=0; $i<$max; $i++){
$titolo=$array[$i]['titolo'];
$prezzo=$array[$i]['prezzo'];
$Codice=$array[$i]['Codice'];
$nome=$array[$i]['nome'];
if($mail==$nome)
	echo "<tr><td><div align=center> $titolo</div></td><td><div align=center> $prezzo €</div><td><div align=center> $Codice</div></td></tr>";
}
echo '</table>';
?>
</br>
</div>
<div align="center">
<h3>Se desideri annullare un ordine inserisci il codice del gioco corrispondente.</h3>
			<form name="forminsert" method="post" action="annullaordine.php">
				<input placeholder = "codice" name = "codice" class = "box" required/></br></br>
				<input type = "submit" value = " Rimuovi " class ="button" name="submit" style="background-color: rgba(192,192,192,0.5);"/></br>
			</form>
 </div>
</body>
</html>
