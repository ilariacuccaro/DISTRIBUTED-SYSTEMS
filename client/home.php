<?php
//Pagina principale dove è possibile scegliere se registrarsi o effettuare la login
session_start();
if(isset($_SESSION['mail'])){
	if ($_SESSION['classe'] == "yes"){
		header("location:negozio.php");
	}
	header("location:ricerca.php");
}
?>

<html>
<head>
	<title>GIOCHI DA TAVOLA</title>
	<link rel="stylesheet" type="text/css" href="home.css">
	<link rel="stylesheet" type="text/css" href="menu.css">
</head>
<body style="background-color:lightyellow;">

	<ul>
		<li><a class="active" href="registration.php">&emsp;Registrati&emsp;</a></li>
		<li style="float:right"><a class="active" href="login.php">&emsp;Login&emsp;</a></li>
	</ul>
	<div style = "width:10px; height:10px; margin-top:-30px;">
		<img src="\Giochi\client\sito\welcome.jpg" height="590px"  width="1345px"/>
	</div>

	<div style="position:center; margin-top:60px; margin-left:400px; width:570px; height:400px; text-align: center; font-family:Georgia;">
		<h1 style="text-shadow:-3px 0 white, 0 3px white, 3px 0 white, 0 -3px white; margin-top: -10px;">BENVENUTI </br>NEL NOSTRO SITO</br></h1>
		<h4></h4>

	 <font color="black" size="4px"><br/><br/>All'interno potete trovare ogni tipologia di gioco!<br/>Per farlo vi basterà registrarvi, accedere ed iniziare la ricerca.</br>Acquistate ora i vostri giochi preferiti, o in alternativa potete prenotare dei tavoli nei nostri negozi per voi e i vostri amici, per passare una serata all'insegna del divertimento.</font>

	</div>
</body>
</html>
