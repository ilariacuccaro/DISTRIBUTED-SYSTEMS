<?php
$mysqli = new MySQLi('127.0.0.1','root','Marcone91','books');
if($mysqli->connect_error) {
  echo 'Errore...' . 'Errore: ' . $mysqli->connect_errno . ' ' . $mysqli->connect_error;
  exit;
} else {
  $mysqli->set_charset('utf8');
}
$term = trim(strip_tags($_GET['term'])); 
$a_json = array();
$a_json_row = array();
if ($data = $mysqli->query("SELECT DISTINCT title FROM book WHERE title LIKE '%$term%'")) {
    while($row = mysqli_fetch_array($data)) {
        $name = htmlentities(stripslashes($row['title']));
        $a_json_row["value"] = $name;
        array_push($a_json, $a_json_row);
    }
}
echo json_encode($a_json);
flush();
$mysqli->close();
?>
