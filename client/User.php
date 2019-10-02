<?php
//Funzioni che eseguono le operazioni relative all'utente nel db MySql, login, registrazione
require "MySQL.php";
class User {
    var $mail, $pwd;
	//funzione che crea riferimenti a variabili
    public function User( $mail, $pwd, $classe, $nome, $prov ) {
	$this->nome = $nome;
	$this->prov = $prov;
	$this->mail = $mail;
        $this->pwd = $pwd;
	$this->classe = $classe;
    }

    public function getMail() {
        return $this->mail;
    }
//funzione di login che richiama 2 query, rispettivamente per: "Proprietario Servizio" e "utente standard"
	//e restituisce un valore in base al tipo di utente che sta effettuando la login
    public function login() {
        $mysql = new MySQL(); //richiama la classe MySQL del file MySQL.php
        $res = $mysql->connect(); //richiama la funzione connect di MYSQL
        if( strcmp( $res , "ok" ) == 0 ) {
		$sql = "SELECT mail, pwd FROM users WHERE mail='$this->mail' AND pwd='$this->pwd' AND classe=2";
		$res = $mysql->querySelect( $sql );
		if ( strcmp( $res , "ok" ) == 0 && $mysql->getLastSelectRows()>0 ) {+
			$this->genSession();
			$mysql->disconnect();
			return "adminok";
		}else{
		    $sql = "SELECT mail, pwd FROM users WHERE mail='$this->mail' AND pwd='$this->pwd' AND classe=1";
	//seleziona la mail e la password all'interno del database uguale a quelli immessi, inoltre classe deve essere 1,cioè è un amministratore.
		    $res = $mysql->querySelect( $sql );
			    if ( strcmp( $res , "ok" ) == 0 && $mysql->getLastSelectRows()>0 ) {
				$this->genSession();
				$mysql->disconnect();
				return "classeok";
				//autenticazione di un admin
			    }else{
					$sql = "SELECT mail, pwd FROM users WHERE mail='$this->mail' AND pwd='$this->pwd' AND classe=0";
					$res = $mysql->querySelect($sql);
					if ( strcmp( $res , "ok" ) == 0 && $mysql->getLastSelectRows() > 0 ) {
						$this->genSession();
						$mysql->disconnect();
						return "ok";
						//autenticazione di un utente normale
					}else{
						$mysql->disconnect();
						if( strcmp( $res , "ok" ) == 0 ){
							return "no";
						}
						return $res;
					}//questa se l'utente non è stato trovato nel database
				}
			}
	}else{
		    return $res;
	}
    }
//funzione che registra nel database i dati immessi dalla pagina registration.php
    public function registration() {
        $mysql = new MySQL();
        $res = $mysql->connect();
        if( strcmp( $res , "ok" ) == 0 ) {
/*strcmp — Confronto tra stringhe affidabile con dati binari
int strcmp ( string $str1 , string $str2 )
Restituisce < 0 se str1 è minore di str2; > 0 se str1 è maggiore di str2, e 0 se sono uguali.
*/
            $sql = "SELECT mail FROM users WHERE mail='$this->mail'";
            $res = $mysql->querySelect( $sql );
            if ( strcmp( $res , "ok" ) != 0 || $mysql->getLastSelectRows() > 0) {
//Se la funzione querySelect restituisce ok o le righe con una corrispondenza sono maggiori di 0 allora significa che la mail è stata già inserita nel database e quindi si viene disconnessi
                $mysql->disconnect();
                return $res;
            }
//questo dovrebbe servire per verificare se la mail è già inserita nel database
            else {
                $sql = "INSERT INTO users (mail, pwd, classe, nome, provincia) VALUES ('$this->mail', '$this->pwd', '0','NULL','NULL')";
                $res = $mysql->queryInsert($sql);
//Altrimenti viene fatto l'inserimento (di un utente normale in questo caso '0')
                if ( strcmp( $res , "ok" ) == 0){
                    $mysql->disconnect();
                    return $res;
                }//inserimento riuscito
                else {
                    $mysql->disconnect();
                    return $res;
                }
            }
        }
        else {
            return $res;
        }
    }
    //funzione per la generazione dei dati Session
    function genSession() {
	$link=mysqli_connect("localhost","root","","db_giochi");
        session_destroy();
        session_start();
	$_SESSION['pwd'] = $this->pwd;
        $_SESSION['mail'] = $this->mail;
	$sql="SELECT nome FROM users WHERE mail='$this->mail';";
	$res=mysqli_query($link,$sql);
	$nome=mysqli_fetch_array($res);
	$_SESSION['nome'] = $nome['nome'];
    }
}
?>
