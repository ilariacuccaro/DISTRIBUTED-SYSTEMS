<?php
/**
*
* @service giochi
*/

class giochi{

    /**
* addgiochi
*
* @param string $titolo
* @param string $giocatori
* @param double $prezzo
* @param double $etaMinima
* @param double $durata
* @param string $nome
* @param string $codice
* @param string $disponibili
*
* @return boolean
*/
   function addgiochi($titolo,$giocatori,$prezzo,$etaMinima,$durata,$nome,$codice,$disponibili) {
       //aggiunge il nuovo gioco inserito dal negoziante
      	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$query = "INSERT INTO giochi(titolo,giocatori,prezzo,etaMinima,durata,nome,Codice,disponibili) VALUES ('$titolo','$giocatori','$prezzo','$etaMinima','$durata','$nome','$codice','$disponibili');";
     	$result = $db->query($query);
	if (!$result){
		return false;}
	mysqli_close($db) or die('Errore chiusura db');
	return true;
  }

    /**
* prenotagioco
*
* @param integer $codice
* @param string $mail
*
* @return boolean
*/
   function prenotagioco($codice,$mail) {
	//inserisce nel DB i giochi prenotati dall'utente
	$link=mysqli_connect("localhost","root","","db_giochi");
	$sql="SELECT titolo,giocatori,prezzo,etaMinima,durata,nome FROM giochi WHERE Codice='$codice';";
	$res = mysqli_query($link, $sql);
	$row=mysqli_fetch_array($res);
	$titolo=$row['titolo'];
	$giocatori=$row['giocatori'];
	$prezzo=$row['prezzo'];
  $etaMinima=$row['etaMinima'];
  $durata=$row['durata'];
	$nome=$row['nome'];
	$prenota=1;
	$query = "INSERT INTO giochiprenotati(titolo,giocatori,prezzo,etaMinima,durata,prenotati,Codice,nome,nomenegozio) VALUES ('$titolo','$giocatori','$prezzo','$etaMinima','$durata',$prenota,'$codice','$mail','$nome');";
     	$result = $link->query($query);
	if (!$result){
	return false;}
	mysqli_close($link) or die('Errore chiusura db');
	return true;
  }

/**
* prenotate_giochi
*
* @param string $codice
*
* @return integer
*/
  function prenotate_giochi($codice){
		//restituisce la quantità di giochi in prenotazione relative al codice
	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$sql = "SELECT prenotati FROM giochiprenotati WHERE Codice='$codice';";
	$res = mysqli_query($db, $sql);
  $row = mysqli_fetch_array($res);
	$prenotati = $row['prenotati'];
	return $prenotati;
  }
/**
* prendoDisponibili
*
* @param string $codice
*
* @return integer
*/
  function prendoDisponibili($codice){
	//restituisce la quantità di giochi presenti nel magazzino del negozio, pronti per essere venduti
	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$sql = "SELECT disponibili FROM giochi WHERE Codice='$codice';";
	$res = mysqli_query($db, $sql);
        $row = mysqli_fetch_array($res);
		$disponibili = $row['disponibili'];
	return $disponibili;

  }

  /**
* addPrenotati
*
* @param integer $prenotato
* @param integer $codice
*
* @return boolean
*/
   function addPrenotati($prenotato,$codice) {
	//prenota un gioco il cui titolo e caratteristiche sono già presenti nel db
    	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$query = "UPDATE giochiprenotati SET prenotati='$prenotato' WHERE Codice='$codice';";
     	$result = $db->query($query);
	if (!$result){
		return false;
  }
	mysqli_close($db) or die('Errore chiusura db');
	return true;
  }

  /**
* infovis
*
* @param string $giocatori
* @param string $titolo
*
* @return Array Response string
*/
  function infovis(){
	//restituisce un array con i titoli e il numero di giocatori corrispondenti presenti nel db
	$link=mysqli_connect("localhost","root","","db_giochi");
	$sql="SELECT giocatori,titolo FROM giochi;";
	$res = mysqli_query($link, $sql);
	$i=0;
	while ($row=mysqli_fetch_array($res)) {
		$titolo=$row['titolo'];
		$giocatori=$row['giocatori'];
		$array[$i]=['titolo'=>"$titolo",'giocatori'=>"$giocatori"];
		$i++;
	}
	mysqli_close($link);
	return $array;
}

  /**
* addDisponibili
*
* @param string $titolo
* @param string $giocatori
* @param string $prezzo
* @param string $etaMinima
* @param string $durata
* @param string $nome
* @param integer $disponibili
*
* @return boolean
*/
   function addDisponibili($titolo,$giocatori,$prezzo,$etaMinima,$durata,$nome,$disponibili) {
	//se inserito un gioco  già presente nel db viene incrementato l'attributo "disponibile"
      	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$query = "UPDATE giochi SET disponibili='$disponibili' WHERE giocatori='$giocatori' AND titolo='$titolo' AND prezzo='$prezzo' AND etaMinima='$etaMinima' AND durata='$durata' AND nome='$nome';";
     	$result = $db->query($query);
	if (!$result){
		return false;}
	mysqli_close($db) or die('Errore chiusura db');
	return true;
  }
 /**
* tienimi
*
* @param string $giocatori
*
* @return boolean
*/
   function tienimi($titolo) {
	//funzione che memorizza nel db NEL DB il gioco che è stato selezionato
  //per poterlo recuperare una volta che la pagine verrà aggiornata
      	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$query = "UPDATE AppoggioVariabili SET appoggio='$titolo';";
     	$result = $db->query($query);
	if (!$result){
		return false;
  }
	mysqli_close($db) or die('Errore chiusura db');
	return true;
  }
/**
* ridammi
*
*
* @return string
*/

  function ridammi(){
	//riprende il gioco memorizzato precedentemente
	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$sql = "SELECT appoggio FROM AppoggioVariabili;";
        $res = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($res);
		$appoggio = $row['appoggio'];
	return $appoggio;

  }
/**
* disponibili_gioco
*
* @param string $giocatori
* @param string $titolo
* @param string $prezzo
* @param string $etaMinima
* @param string $durata
* @param string $nome
*
* @return integer
*/

  function disponibili_gioco($giocatori,$titolo,$prezzo,$etaMinima,$durata,$nome){
	//restituisce la quantità del gioco selezionato
	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$sql = "SELECT disponibili FROM giochi WHERE giocatori='$giocatori' AND titolo='$titolo' AND prezzo='$prezzo' AND etaMinima='$etaMinima' AND durata='$durata' AND nome='$nome';";
        $res = mysqli_query($db, $sql);
	$row = mysqli_fetch_array($res);
		$disponibili = $row['disponibili'];
	return $disponibili;

  }
/**
* gioco_rimosso
*
* @param integer $codice
*
* @return Array Response string
*/
   function gioco_rimosso($codice){
	//seleziona il gioco da rimuovere a seconda del codice inserito dall'utente
	$array=array();
	$link=mysqli_connect("localhost","root","","db_giochi");
	$sql="SELECT titolo,giocatori,prezzo,etaMinima,durata,nome FROM giochi WHERE Codice='{$codice}';";
	$res = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($res);
		$titolo = $row['titolo'];
		$giocatori = $row['giocatori'];
		$prezzo = $row['prezzo'];
    $etaMinima = $row['etaMinima'];
    $durata = $row['durata'];
		$nome = $row['nome'];
         	$array[0] = ['titolo' =>"$titolo",
		'giocatori' => "$giocatori",
		'prezzo' => "$prezzo",
    'etaMinima' => "$etaMinima",
    'durata' => "$durata",
		'nome' => "$nome"];
 		 mysqli_close($link);
 		 return $array;
  }
/**
* giocoprenotato_rimosso
*
* @param integer $codice
*
* @return Array Response string
*/
   function giocoprenotato_rimosso($codice){
     //restituisce il gioco prenotato che l'utente desidera rimuovere a seconda del codice inserito
	$array=array();
	$link=mysqli_connect("localhost","root","","db_giochi");
	$sql="SELECT titolo,giocatori,prezzo,etaMinima,durata FROM giochiprenotati WHERE Codice='$codice';";
	$res = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($res);
		$titolo = $row['titolo'];
		$giocatori = $row['giocatori'];
		$prezzo = $row['prezzo'];
    $etaMinima = $row['etaMinima'];
    $durata = $row['durata'];
         	$array[0] = ['titolo' =>"$titolo",
		'giocatori' => "$giocatori",
		'prezzo' => "$prezzo",
    'etaMinima' => "$etaMinima",
    'durata' => "$durata"];
 		 mysqli_close($link);
 		 return $array;
  }
   /**
* magazzino
*
* @param string $nome
*
* @return Array Response string
*/
   function magazzino($nome){
	//restituisce un array di tutti i giochi presenti nella tabella "giochi"
	$array=array();
	$link=mysqli_connect("localhost","root","","db_giochi");
	$sql="SELECT titolo,giocatori,prezzo,etaMinima,durata,Codice,disponibili FROM giochi WHERE nome='{$nome}';";
	$res = mysqli_query($link, $sql);
	$i=0;
	while($row = mysqli_fetch_array($res)){
		$titolo = $row['titolo'];
		$giocatori = $row['giocatori'];
		$prezzo = $row['prezzo'];
    $etaMinima = $row['etaMinima'];
    $durata = $row['durata'];
		$Codice = $row['Codice'];
		$disponibili = $row['disponibili'];
         	$array[$i] = ['titolo' =>"$titolo",
		'giocatori' => "$giocatori",
		'prezzo' => "$prezzo",
    'etaMinima' => "$etaMinima",
    'durata' => "$durata",
		'Codice' => "$Codice",
		'disponibili' => "$disponibili"];
		$i++;
	}
  mysqli_close($link);
  return $array;
  }
 /**
* magazzinoPrenotati
*
* @param string $nomenegozio
*
* @return Array Response string
*/
   function magazzinoPrenotati($nomenegozio){
	//restituisce un array di tutti i giochi presenti nella tabella "gioco_prenotato" a seconda del negozio in login
	$array=array();
	$link=mysqli_connect("localhost","root","","db_giochi");
	$sql="SELECT titolo,giocatori,prezzo,prenotati,Codice,etaMinima,durata,nome,nomenegozio FROM giochiprenotati WHERE prenotati!='0';";
	$res = mysqli_query($link, $sql);
	$i=0;
	while($row = mysqli_fetch_array($res)){
		$titolo = $row['titolo'];
		$giocatori = $row['giocatori'];
		$prezzo = $row['prezzo'];
    $etaMinima = $row['etaMinima'];
    $durata = $row['durata'];
		$Codice = $row['Codice'];
		$prenotati = $row['prenotati'];
		$nome = $row['nome'];
    	$nomenegozio = $row['nomenegozio'];
  	$array[$i] = ['titolo' =>"$titolo",
		'giocatori' => "$giocatori",
		'prezzo' => "$prezzo",
    'etaMinima' => "$etaMinima",
    'durata' => "$durata",
		'Codice' => "$Codice",
		'prenotati' => "$prenotati",
		'nome' => "$nome",
  'nomenegozio' => "$nomenegozio"];
		$i++;
	}
  mysqli_close($link);
  return $array;
  }
 /**
* removegioco
*
* @param string $codice
*
* @return boolean
*/
   function removegioco($codice) {
       //rimuove un gioco dalla tabella "giochi" a seconda del codice inserito
      $db = mysqli_connect('localhost', 'root', '', 'db_giochi');
      $query = "DELETE FROM giochi WHERE Codice='{$codice}';";
      $result = $db->query($query);
		if (!$result){
			return false;}
		mysqli_close($db) or die('Errore chiusura db');
		return true;
  }
 /**
* removegiocoprenotato
*
* @param string $codice
*
* @return boolean
*/
   function removegiocoprenotato($codice) {
        //rimuove un gioco dalla tabella "giochi_prenotate" a seconda del codice inserito
      $db = mysqli_connect('localhost', 'root', '', 'db_giochi');
      $query = "DELETE FROM giochiprenotati WHERE Codice='{$codice}';";
      $result = $db->query($query);
		if (!$result){
			return false;}
		mysqli_close($db) or die('Errore chiusura db');
		return true;
  }
 /**
* codice_gioco
*
* @param string $codice
*
* @return integer
*/
  function codice_gioco($codice){ //richiamata dalla pagina inserimento_gioco
	//controlla se il codice inserito esiste già nella tabella "giochi"
	$db = mysqli_connect('localhost', 'root', '', 'db_giochi');
	$sql = "SELECT Codice FROM giochi WHERE Codice='$codice'";
        $res = mysqli_query($db, $sql);
	$righe = mysqli_num_rows($res);
	return $righe;
  }
    /**
* infogioco
*
* @param string $titolo
*
* @return Array Response string
*/
  function infogioco($titolo){
	//restituisce un array con i giochi disponibili in base ai giocatori inseriti
	$link=mysqli_connect("localhost","root","","db_giochi");
	$sql="SELECT titolo,giocatori,prezzo,etaMinima,durata,nome,Codice FROM giochi WHERE titolo = '$titolo';";
	$res = mysqli_query($link, $sql);
  $row = mysqli_fetch_array($res);
		$titolo=$row['titolo'];
		$giocatori=$row['giocatori'];
		$prezzo=$row['prezzo'];
    $etaMinima=$row['etaMinima'];
    $durata=$row['durata'];
		$nome=$row['nome'];
		$Codice=$row['Codice'];
    $array[0] = ['titolo' => "$titolo", 'giocatori' => "$giocatori",
                'prezzo' => "$prezzo", 'etaMinima' => "$etaMinima",
                'durata' => "$durata", 'nome' => "$nome",
                'Codice' => "$Codice"];
	mysqli_close($link);
	return $array;
}
/**
* contattoEmail
*
* @param string $nome
*
* @return Array Response string
*/
 function contattoEmail($nome){
	//restituisce la provincia e l'e-mail in base al nome inserito
	$link=mysqli_connect("localhost","root","","db_giochi");
	$sql="SELECT mail,provincia FROM users WHERE nome='$nome';";
	$res = mysqli_query($link, $sql);
	$row = mysqli_fetch_array($res);
	$mail = $row['mail'];
	$provincia = $row['provincia'];
 	$array[0] = ['mail' =>"$mail",
	'provincia' => "$provincia"];
  	mysqli_close($link);
  	return $array;
  }
}

  /**
 * magazzinoPrenotatiT
 *
 * @param string $nomenegozio
 *
 * @return Array Response string
 */
    function magazzinoPrenotatiT($nomenegozio){
 	//RESTITUISCE UN ARRAY DI TUTTI I TAVOLI PRESENTI NELLA RISPETTIVA TABELLA RELATIVI AL NEGOZIO IN LOGIN
 	$array=array();
 	$link=mysqli_connect("localhost","root","","db_giochi");
 	$sql="SELECT numeroTavolo,prenotatoT,nome FROM tavoliprenotati WHERE nomenegozio='$nomenegozio' AND prenotati!='0';";
 	$res = mysqli_query($link, $sql);
 	$i=0;
 	while($row = mysqli_fetch_array($res)){
 		$numeroTavolo= $row['numero'];
 		$prenotatoT = $row['prenotatoT'];
 		$nome = $row['nome'];
   	$array[$i] = ['numeroTavolo' =>"$numeroTavolo",
 		'prenotatoT' => "$prenotatoT",
 		'nome' => "$nome"];
 		$i++;
 	}
   mysqli_close($link);
   return $array;
   }

require_once('../lib/class.phpwsdl.php'); //include file esterno, se non viene trovato mostrerà un errore fatale
$soap = PhpWsdl::CreateInstance(null,null,null,null,null,null,null,null,false,false);
$wsdl=$soap->CreateWsdl();
$wsdl = $soap->GetCacheFileName();
rename($wsdl,"./cache/Giochi.wsdl");
/* soapServer*/
//tramite medoto Soap viene creato il file wsdl che viene inserito all'interno della cartella cache
$server = new SoapServer("http://localhost/Giochi/server/cache/Giochi.wsdl");
$server->setClass("giochi");				//la classe che gestisce le richieste SOAP
$server->handle();     							//per gestire una richiesta SOAP, chiama le funzioni e invia una risposta
