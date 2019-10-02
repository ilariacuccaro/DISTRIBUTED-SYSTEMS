<?php
//pagina principale del negozio, permette di insirire i giochi richiamando la pagina "inserimento_gioco.php"
session_start();
?>
<html>
<head>
<title>Dati di negozio</title>

<link rel="shortcut icon" type="image/png" href="favicon.png"/>
<link rel="stylesheet" type="text/css" href="menu.css">
<link rel="stylesheet" type="text/css" href="/ricerca.css">

<style>
	body{
		background-image: url(sito/sfondoG.jpg);
	}
	h1{
		  text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
	}
</style>

</head>
<body>
	<ul>
		<li><a class="active">&emsp;&emsp;Inserisci gioco&nbsp;&emsp;&emsp;</a></li>
		<li><a class="active" href="lista_giochi.php">&emsp;&emsp;&nbsp;Lista giochi&nbsp;&emsp;&emsp;</a></li>
		<li><a href="lista_giochiprenotati.php" class="active">&emsp;&emsp;&nbsp;Lista giochi prenotati&nbsp;&emsp;&emsp;</a></li>
		<li><a href="lista_tavoliprenotati.php" class="active">&emsp;&emsp;&nbsp;Lista tavoli prenotati&nbsp;&emsp;&emsp;</a></li>
	  <li><a class="active" href="lista_utenti.php">&emsp;&emsp;&nbsp;Lista utenti&emsp;&emsp;&nbsp;</a></li>
    <li style="float:right"><a href="logout.php">&emsp;&emsp; Loguot&emsp;&emsp;</a></li>
	</ul>
		<h1 align="center" id="intestazione">INSERISCI &nbsp;UN &nbsp;NUOVO &nbsp;GIOCO &nbsp;ALL'INTERNO &nbsp;DEL &nbsp;CATALOGO</br></br></h1>

<div class="div" align="center">
			<form name="forminsert" method="post"  action="inserimento_gioco.php" >
				 <input placeholder =  "inserisci il titolo"   name = "titolo" class = "box"required/><br/><br/><br/>
         <input placeholder  = "inserisci numero di giocatori"  name = "giocatori"  class = "box" required  /><br/><br /><br/>
		     <input placeholder = "inserisci il prezzo"    name = "prezzo" class = "box" required/><br/><br /><br/>
				 <input placeholder = "inserisci l'età minima"    name = "etaMinima" class = "box" required/><br/><br /><br/>
				 <input placeholder = "inserisci la durata"    name = "durata" class = "box" required/><br/><br /><br/>
				 <input type = "submit" value = " inserisci " class ="button" name="submit"/><br />
			</form>
</div>
</body>
</html>
