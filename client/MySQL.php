<?php
//Vengono inseriti i parametri di connessione al database MySql
class MySQL {

    private $con;
    private $active = false;
    private $lastSelectRows = 0;

    public function MySQL(){}

    public function connect() {
	//indirizzo utente password database
        $this->con = mysqli_connect("localhost","root","","db_giochi");
        if (mysqli_connect_errno($this->con))
        {
            return "Connect ".mysqli_error($this->con);
        }
        $this->active = true;
        return "ok";
    }

    public function disconnect() {
        if($this->active){
            mysqli_close($this->con);
        }
    }
//funzione che restituisce ok se la query trova una corrispondenza nel database e eventualmente restituisce anche il numero di righe coinvolte
    public function querySelect($sql) {
        if($this->active)
        {
            $res = mysqli_query($this->con, $sql);
            if (!$res) {
                return "querySelect ".mysqli_error($this->con); //ha restituito falso quindi c'è stato un'errore
            }
            $this->lastSelectRows = mysqli_num_rows($res); //Ottiene il numero di righe in un risultato
            return "ok";
        }
        else
            return "Errore, connessione inattiva funzione querySelect";
    }

	public function querySelectReturn($sql,$message) {
		if($this->active)
        {
            $res = mysqli_query($this->con, $sql);
            if (!$res) {
                return "querySelect ".mysqli_error($this->con);
            }
            $this->lastSelectRows = mysqli_num_rows($res);
            $string = "";
            while($row = mysqli_fetch_array($res))
			{
				$string = $string.$row[$message]."</br>";
			}
            return $string;
        }
        else
            return "Errore, connessione inattiva funzione querySelectReturn";
	}

	public function queryDelete($sql) {
		if($this->active)
        {
            if (!mysqli_query($this->con, $sql)) {
                return "queryDelete ".mysqli_error($this->con);
            }
            return "ok";
        }
        else
            return "Errore, connessione inattiva funzione queryDelete";
	}

    public function queryInsert($sql) {
        if($this->active)
        {
            if (!mysqli_query($this->con, $sql)) {
                return "queryInsert ".mysqli_error($this->con);
            }
            return "ok";
        }
        else
            return "Errore, connessione inattiva funzione queryInsert";
    }

    public function getLastSelectRows() {
        return $this->lastSelectRows;
    }
}
