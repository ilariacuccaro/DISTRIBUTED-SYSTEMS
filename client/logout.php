<?php
//pagina di logout, serve a reindirizzare l'utente nella pagina iniziale
   session_start();

   if(session_destroy()) {
      header("Location: home.php");
   }
?>
