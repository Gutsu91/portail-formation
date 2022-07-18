<?php 
// ---------------------- Includes ---------------------- //
require_once 'header.php';


// ---------------------- Config DB ---------------------- //
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_HOST', 'localhost');
define('DB_NAME', 'formation');

$connect = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if($connect -> connect_error):
  die('Connection failed' . $connect->connect_error);
  else :
    $connect->set_charset('utf8');
endif;

// ----------------------- Autres ----------------------- //
define('MODE', 'dev');


// --------------------- Fonctions --------------------- //
function myPrint_r($value) { 
  if(MODE =="dev"): 
  echo '<pre>'; 
      print_r($value);
    echo '</pre>';
  endif;
}
?>