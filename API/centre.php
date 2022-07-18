<?php
// ------------------- Includes ------------------- //
require_once 'config.php';


// ----------- Info réponse de base -------------- //
if(MODE =="dev"):
  $auth['response']['script'] = 'auth.php';
endif;
$auth['response']['time'] = date('Y-m-d,H:i:s');
$auth['response']['foo'] = "bar";

// ------------- Encodage réponse  ---------------- //
echo json_encode($auth);
exit
?>