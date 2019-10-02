<?php
//pagina login per 2 tipi di utente: "Utenti standard", "proprietario negozio/servizio"
session_start();
/*Si usa require quando si vuole che venga inviato un segnale di errore fatale di compilazione e il programma venga interrotto se la pagina da includere non esiste*/
require 'User.php';

$nome = NULL;
$prov = NULL;
$email_errata = false;
$email_errata = false;
$classe = NULL;

//il form nella pagina richiama i dati
//gli eventi del controllo dati ed indirizzamento vengono eseguiti soltanto se il botone "submit" viene cliccato
if(isset($_POST['submit'])){
$mail = $_POST['mail'];
$pwd = $_POST['pwd'];
	if( !filter_var( $_POST['mail'] , FILTER_VALIDATE_EMAIL )){
		$email_errata = true;
	}
	if( $email_errata == true ){
		echo "<div style = 'position: absolute; margin-top:470px;left: 7%; background-color:RED; padding:5px;'>ATTENZIONE: L'E-MAIL INSERITA NON È VALIDA</div>";
	}

	$user = new User($mail , $pwd, $classe, $nome, $prov );
	//richiamo la funzione login da User che controlla se i dati inseriti corrispondono ad una tupla del DB
	$res = $user->login();
	if ( $res == 'no') {
		$password_errata = true;
	}
	if( $password_errata == true ){
		echo "<div style = 'position: absolute;  margin-top:505px;left: 7%; background-color:RED; padding:5px;'>ATTENZIONE: LA PASSWORD INSERITA NON È VALIDA</div>";
	}
	//se tutti i dati sono corretti,l'utente viene reindirizzato ad una pagina in base alla sua tipologia
	if($email_errata == false && $password_errata == false) {
		if( strcmp( $res , "classeok" ) == 0 ){
			$_SESSION['classe'] = "yes";
		   	 header("location:negozio.php");
		}
		elseif( strcmp( $res , "ok" ) == 0 ){
			header("location:ricerca.php");
		}
		else {
			echo $res;
		    header("location:login.php");
		}
	}
}
?>
<html>
<head>
	<title>Login</title>
		<link rel="stylesheet" type="text/css" href="login.css">
		<link rel="stylesheet" type="text/css" href="menu.css">
		<style>
			#bot{
				background-color: brown;
				width: 100%;
			}
			h1{
					text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
					text-align: center;
			}
			#forml{
				margin-top:160px;
				margin-left:180px;
				padding:10px;
				height:160px;
				width:280px;
				font-size:22px;
				border-radius:8px;
			}
			input{
				padding: 5px;
				margin-right: 10px;
			}
			label{
				text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;
				font-size: 18px;
			}
			#iml{
				width:1200px;
				height: 100px;
				margin-top:-230px;
			}
		</style>
</head>
<body bgcolor="lightyellow">
	<ul>
		<li><a class="active" href="home.php">Indietro</a></li>
    <li style="float:right"></li>
  </ul>
	<div style = "width:10px; height: 1px; margin-top:-28px;">
		<img src="\Giochi\client\sito\sfondoG.jpg" height="590px"  width="1345px"/>
	</div>
	<div><strong><h1>Entrate nell'area riservata inserendo la vostra E-mail</h></strong></div>

	<div id=forml>
		<form name="formregistration" method="post" action="login.php">
			<label>E-mail:&emsp;&nbsp;</label><input type =  "mail" placeholder =  "mail"  id="mail" name = "mail" class = "box" required/><br /><br />
			<label>Password:&nbsp;</label><input type = "password" placeholder = "password" name = "pwd" class = "box" required/><br/><br />
			<strong><input id="bot" type = "submit" value = " Login " class ="button" align="center" name="submit"/><br /></strong>
		</form>
	</div>

	<div align="right" id="iml"><img src="\Giochi\client\sito\pedine.jpg" height="300px"  width="450px" border="3px solid black"/></div>
</body>
</html>
