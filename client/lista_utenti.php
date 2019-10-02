<?php
require "MySQL.php";
//visualizza tutti gli utenti registrati al sito
session_start();
$link=mysqli_connect("localhost","root","","db_giochi");

if(isset($_POST['E-mail'])){
	$mail = $_POST['E-mail'];
	$db="DELETE FROM users WHERE mail='$mail';";
	$result = $link->query($db);
}
$array=array();
$sql="SELECT mail,pwd,classe,nome,provincia FROM users ;";
$res = mysqli_query($link, $sql);
	$i=0;
	while ($row=mysqli_fetch_array($res)) {
		$mail=$row['mail'];
		$pwd=$row['pwd'];
		$classe=$row['classe'];
		$nome=$row['nome'];
		$provincia=$row['provincia'];
		$array[$i]=['mail'=>"$mail",'pwd'=>"$pwd",'classe'=>"$classe",'nome'=>"$nome",'provincia'=>"$provincia"];
		$i++;
	}
	mysqli_close($link);
?>
<html>
<head>
	<title>Lista utenti/negozi</title>
	<link rel="stylesheet" type="text/css" href="menu.css">
	<style>
		body{
			background-image: url(sito/sfondoG.jpg);
		}
		h1{
				text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
		}
		th{
			padding-top: 8px;
			background-color: #ffa07a;
		}
		td{
			padding-left: 30px;
			padding-right: 30px;
			padding-top: 10px;
			padding-bottom: 10px;
		}
		#utenteins{
			margin-left: 480px;
		}
		h3{
			margin-top: 150px;
		}
	</style>
</head>
<body bgcolor="lightyellow">

<?php
$nome = $_SESSION['nome'];
?>
<ul>
	<li><a class="active" href="negozio.php">&emsp;&emsp;Inserisci gioco&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active" href="lista_giochi.php">&emsp;&emsp;&nbsp;Lista giochi&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active" href="lista_giochiprenotati.php">&emsp;&emsp;&nbsp;Lista giochi prenotati&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active" href="lista_tavoliprenotati.php">&emsp;&emsp;&nbsp;Lista tavoli prenotati&nbsp;&emsp;&emsp;</a></li>
	<li><a class="active">&emsp;&emsp;&nbsp;Lista utenti&emsp;&emsp;&nbsp;</a></li>
	<li style="float:right"><a href="logout.php">&emsp;&emsp; Loguot&emsp;&emsp;</a></li>
</ul>

<div><h1 align="center" id="intestazione">ELENCO &nbsp;DEGLI &nbsp;UTENTI &nbsp;REGISTRATI &nbsp;AL &nbsp;SITO</h1></div>
</br></br>
<?php
	echo '<div id="utenteins"><table border="solid 1px #333333"  style="width:50%; background-color:lightyellow";>';
	echo '<tr><th>E-mail</th></tr>';
	$max=count($array);
	for($i=0; $i<$max; $i++){
		$mail=$array[$i]['mail'];
		$classe=$array[$i]['classe'];
		if( $classe == 0 ){
			echo "<tr><td><div align=center> $mail</div></td></tr>";
		}
	}
	 echo '</table></div>';
?>
</body>
</html>
