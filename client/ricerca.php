
<?php
//paginadove vine visualizzata una lista iniziale il titolo dei giochi e il numero di giocatori presenti nel DB
require "MySQL.php";
session_start();
$wsdl_url="/xampp/htdocs/Giochi/server/cache/Giochi.wsdl";
$Client1 = new SoapClient($wsdl_url);
$nomenegozio = $_SESSION['nome'];
$array=array();
try{
		$array=$Client1->infovis();
		}
		catch (Exception $e) {
			echo "<h2>Exception Error! addgioco</h2>";
			echo $e->getMessage();
		}
?>
<html>
<head>
	<title>Ricerca</title>
	<link rel="stylesheet" type="text/css" href="menu.css">
	<style>
		#page {
		     width: 1330px;
		     height: 280px;
			 }
			 #primo{
				 margin-top: -30px;
			 }
			 #titolo{
			 	background-color: rgba(239,239,239,0.5);
			 	position: absolute;
			 	margin-top: 70px;
			 	left: 35%;
				padding: 10px;
				border-radius: 10px;
			}
			#sotto{
				background-color: rgba(192,192,192,0.5);
				margin-top: -20px;
			}
			#barra{
				margin-top: -15px;
			}
			 th{
				 background-color: 	#ffa07a;
			 }
			 td{
				 text-align: center;
				 width: 50%;
			 }
			 form{
				 height: 20px;
			 }
			 input{
				  padding-top:8px;
					padding-bottom:8px;
					 width: 100%;
			 }
				h1{
					 text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
				}
				h2{
					margin-bottom: 30px;
					margin-left: 260px;
				}
	</style>
</head>
<body bgcolor="lightyellow">
<div id=page  style = "background-image : url(sito/giochi-tavolo-2.jpg); background-repeat: no-repeat;">
	<div id=titolo><font color="black"><h1 align="center" id="intestazione">DATE INIZIO </br>ALLA VOSTRA PARTITA!</h1></font></div>

</div>
<div id=primo>
<!--Pulsanti menu: in questo caso è possibile visualizzare la lista dei giochi che sono stati prenotati dall'utente oppure uscire dal sito-->
	<ul>
		<li><a class="active" href="lista_giochicliente.php">&emsp;Lista prenotati&emsp;</a></li>
		<li style="float:right"><a class="active" href="logout.php">&emsp;Logout&emsp;</a></li>
	</ul>
</div>
<div id=sotto>
	<div id=div>
		 </br><h2>Scegli un gioco presente nella lista seguente per visualizzare le informazioni.</h2>
		<div align="right">
				<?php
				echo '<table align="center" border="solid 1px #333333" width="100%">';
				$max=count($array);
				echo '<tr><th style="padding-top:5px;padding-bottom:5px;">TITOLO</th><th>NUMERO GIOCATORI</th></tr>';
					for($i=0; $i<$max; $i++){
			  //recupero i dati Titolo e Giocatori
						$titolo=$array[$i]['titolo'];
						$giocatori=$array[$i]['giocatori'];
						$var=0;
						for($j=$i+1;$j<$max;$j++){
							$titolo1=$array[$j]['titolo'];
							$giocatori1=$array[$j]['giocatori'];
							if(($titolo==$titolo1)&&($giocatori==$giocatori1)){
							$var++;
							}
						}
						if($var==0){
	//Stampa: un button per ogni gioco (se cliccato si verrà reindirizzati nelle pagine infogiochi.php) e il numero di giocatori per ogni gioco
							echo "<tr class='sel' style='height:30px;'>
							<td><div>
							<form name='forminsert' method='post' action='infogiochi.php'>
					      <input type = 'submit' value = '$titolo ' class ='button' name='titolo'/><br /><br />
				  		</form></div></td>
					  	<td> $giocatori</td></tr>";}
				 }
				echo '</table>';
				?>
		  </div>
		</div>
	</div>
 </body>
</html>
