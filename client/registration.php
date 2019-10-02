<?php
//pagina di registrazione per Utenti Standard
session_start();
if(isset($_SESSION['mail'])){
	if ($_SESSION['classe'] == "yes"){  //verifico se l'utente registrato è un semplice cliente o un gestore
		header("location:negozio.php");
	}
	header("location:ricerca.php");
}
//richiamo il file User.php ed inizializzo delle variabili che serviranno per la registrazione esclusiva dell'Utente
require 'User.php';
$nome = NULL;
$prov = NULL;
$email_errata = false;
$password_errata = false;
$classe = NULL;
//il form nella pagina richiama e quindi invia i dati alla pagina stessa
//quindi gli eventi del controllo dati e registrazione nel Data Base vengono eseguiti soltanto se il botone "submit" viene cliccato
if(isset($_POST['submit'])){
	//controlla se l'e.mail inserita è valida, se non lo è setta la variabile a true
	if( !filter_var( $_POST['mail'] , FILTER_VALIDATE_EMAIL )){
	    $email_errata = true;
	}
	//controlla se le password inserite sono valide, se non lo sono setta la variabile a true
	if ( strcmp ( $_POST['pwd'] , $_POST['pwdrp'] ) != 0 || (strlen( $_POST['pwd'] ) < 8 || strlen( $_POST['pwd'] ) > 16)) {
		$password_errata = true;
	}
	//messaggio di errore per e-mail errata
	if( $email_errata == true ){
		echo "<div style = 'align: center; position: absolute; top:540px; left:450px; background-color:RED;'>ATTENZIONE: L'E-MAIL INSERITA NON È VALIDA</div>";
	}
	//messaggio di errore per password errata
	if( $password_errata == true ){
		echo "<div style = 'align:center; position: absolute; top:560px; left:450px; background-color:RED;'>ATTENZIONE: LA PASSWORD INSERITA NON È VALIDA</div>";
	}
	//se sono entrambe valide, inizializza le variabili del form e richiama la funzione User e la funzione registration
	//per salvare i dati dell'utente nel database "users" ed infine indirizza l'utente al login
	if($email_errata == false && $password_errata == false) {
	$mail = $_POST['mail'];
	$pwd = $_POST['pwd'];
	$pwdrp = $_POST['pwdrp'];
		$user = new User( $mail , $pwd, $classe, $nome, $prov );
	   	$res = $user->registration();
		if( strcmp( $res , "ok" ) == 0 ){
			header("location:login.php");
	    	}else {
			header("location:home.php");
	   	}
	}
}
?>
<html>
	<head>
		<title>Registrazione</title>
		<link rel="stylesheet" type="text/css" href="menu.css">
  <style>
	#for{
		border: 1px solid black;
		margin-top:200px;
		margin-left:450px;
		padding:10px;
		height:160px;
		width:390px;
		border-radius:8px;
		background-color:lightyellow;
		font-size: 19px;
		text-shadow: -1px 0 white, 0 1px white, 1px 0 white, 0 -1px white;
	}
	#info{
		margin-top: 10px;
		position: absolute;
		top: -3%;
		left: 27%;
		text-align:center;
		text-shadow: -2px 0 white, 0 2px white, 2px 0 white, 0 -2px white;
	}
	input{
		padding: 5px;
		margin-right: 10px;
	}
	.button {
	background-color: brown;
 	padding: 5px;
 	color: #ffffff;
 	font-size: 15px;
 	border: 1px solid black;
 	border-radius: 2px;
  }

	</style>
	</head>
	<body bgcolor="lightyellow">
		<ul>
			<li><a class="active" href="home.php">&emsp;Indietro&emsp;</a></li>
			<li style="float:right"></li>
		</ul>

		<div style = "width:10px; height: 1px; margin-top:-28px;">
			<img src="\Giochi\client\sito\sfondoG.jpg" height="590px"  width="1345px"/>
		</div>

		<div id="for">
		 <form name="formregistration" method="post" action="registration.php">
				<label><strong>E-mail:&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;</label>
				<input type =  "mail"  id="mail" name = "mail" class = "box" required/><br /><br />
				<label>Password:&emsp;&emsp;&emsp;&emsp;&ensp;</label>
				<input type = "password" name = "pwd" class = "box" required/></br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;inserire almeno 8 caratteri</font><br/><br />
				<label>Ripeti Password:&emsp;&emsp;</label><input type = "password" name = "pwdrp" class = "box" required id="pwdrp"/><br/><br />

				<input type = "submit" value = " Registrati " class ="button" name="submit" style="width:100%"/><br />
		</form>
	</div>
	<div id=info><strong><h2></br></br></br>Compila i campi con i tuoi dati per completare la registrazione </br>ed entrare nel mondo dei Games!</h2></strong></div>
	</body>
</html>
