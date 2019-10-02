<?php
require "MySQL.php";
// visualizza i tavoli in prenotazione
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client1 = new SoapClient($wsdl_url);
$nomenegozio = $_SESSION['nome'];
$mail = $_SESSION['mail'];
$array=array();

?>
<html>
		<?php
		if (isset($_SESSION['Err'])){
			echo $_SESSION['Err'];
		}
		?>
		<head>
<title>Dati tavoli</title>
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
				padding-top: 10px;
				padding-bottom: 10px;
				padding-left: 70px;
				padding-right: 70px;
				background-color: #ffa07a;
		}
		td{
				padding: 10px;
		}
	</style>
</head>
<body bgcolor="lightyellow" >
	<ul>
		<li><a class="active" href="negozio.php">&emsp;&emsp;Inserisci gioco&nbsp;&emsp;&emsp;</a></li>
		<li><a class="active" href="lista_giochi.php">&emsp;&emsp;&nbsp;Lista giochi&nbsp;&emsp;&emsp;</a></li>
		<li><a class="active" href="lista_giochiprenotati.php">&emsp;&emsp;&nbsp;Lista giochi prenotati&nbsp;&emsp;&emsp;</a></li>
		<li><a class="active">&emsp;&emsp;&nbsp;Lista tavoli prenotati&nbsp;&emsp;&emsp;</a></li>
		<li><a class="active" href="lista_utenti.php">&emsp;&emsp;&nbsp;Lista utenti&emsp;&emsp;&nbsp;</a></li>
		<li style="float:right"><a href="logout.php">&emsp;&emsp; Loguot&emsp;&emsp;</a></li>
	</ul>

	<h1 align="center" id="intestazione">TAVOLI &nbsp;PRENOTATI &nbsp;DAGLI &nbsp;UTENTI</h1>
	</br></br>
	<?php
		$link = mysqli_connect("localhost", "root", "", "db_giochi");
		$sql = "SELECT * FROM tavoliprenotati WHERE prenotatoT='1';";
		$res = mysqli_query($link, $sql);
		$i=0;
			echo '<table align="center" border="solid 1px #333333"  style="background-color:lightyellow";>';
			echo '<tr><th>TAVOLO</th><th>CLIENTE</th></tr>';
		while($row = mysqli_fetch_array($res)){
			$negozio=$row['nomenegozio'];
			if($nomenegozio==$negozio)
			echo "<tr><td><div align=center>".$row['numeroTavolo']."</div></td><td><div align=center>".$row['nome']."</div></td></tr>";
		}
			echo '</table>';
	 ?>
 </br>
	 <div align="center">
	 <h3>E' possibile annullare il tavolo prenotato dal cliente inserendo il numero corrispondente.</h3>
	 			<form name="forminsert" method="post" action="rimuovi_tavoloprenotato.php">
	 				<input placeholder = "tavolo" name = "numeroTavolo" class = "box" required/></br></br>
	 				<input type = "submit" value = " Rimuovi " class ="button" name="submit" style="background-color: rgba(192,192,192,0.5);"/></br>
	 			</form>
	  </div>
	</body>
</html>
