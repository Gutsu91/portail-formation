<?php
// ------------------- Includes ------------------- //
require_once 'config.php';
// require_once 'verif_auth.php


// ---------------- Gestion du GET ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'GET'):
  if(isset($_GET['id_user'])):
    $req_user = sprintf("SELECT * FROM user WHERE id_user=%d AND type_user=2", // type_user = 2 car a priori on a pas besoin de faire du get sur d'autres user que les stagiaires, à voir quand on définira un formateur référent
    $_GET['id_user']);
  else:
    $req_user = "SELECT * FROM user WHERE type_user=2";
  endif;
    $result = $connect->query($req_user);
    $user['response']['code'] = 200;
    $user['response']['message'] = 'One specific user';
    $user['response']['nbhits'] = $result->num_rows;
    while($row = $result->fetch_assoc()):
      $user['data'][] = $row;
    endwhile;
endif;


// ----------- Info réponse de base -------------- //
if(MODE =="dev"):
  $auth['response']['script'] = __FILE__;
endif;
$user['response']['time'] = date('Y-m-d,H:i:s');
$user['response']['foo'] = "bar";


// ------------- Encodage réponse  ---------------- //
echo json_encode($user);
exit;
?>