<?php
require_once 'config.php';

// ---------------- Gestion du GET ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'GET'):
  $req_session = "SELECT * FROM session s;";
  $result = $connect->query($req_session);
  $session['response']['code'] = 200;
  $session['response']['message'] = "Liste de toutes les sessions";
  while($row = $result->fetch_assoc()):
   $session['data'][] = $row;
  endwhile;
endif;

// ---------------- Gestion du POST ---------------- //

// ----------- Info réponse de base -------------- //
  if(MODE =="dev"):
    $session['response']['script'] = __FILE__;
    $session['response']['foo'] = "bar";
    $session['response']['sql'] = $req_session;
  endif;
  $session['response']['time'] = date('Y-m-d,H:i:s');
  $session['response']['nbhits'] = $result->num_rows;

echo json_encode($session);
exit;
?>