<?php
require_once 'config.php';

// ---------------- Gestion du GET ---------------- //

// ---------------- Gestion du POST ---------------- //
if ($_SERVER['REQUEST_METHOD'] == 'POST') :
  $json_inscr = file_get_contents('php://input');
  $arrayINSCR = json_decode($json_inscr, true);
  if(!isset($arrayINSCR['id_user']) OR !isset($arrayINSCR['id_session'])):
    $inscription['response']['code'] = 400;
    $inscription['response']['message'] = "Il manque l'une des information suivante: id_user, id_session";
    else:
      $req_inscr = sprintf(
                          "INSERT INTO inscription SET id_user=%d, id_session=%d;",
                          $arrayINSCR['id_user'],
                          $arrayINSCR['id_session']
                    );
      $result = $connect->query($req_inscr);
      echo $connect->error;
      $inscription['response']['code'] = 200;
      $inscription['response']['message'] = 'L\'utilisateur a bien été inscrit à la session';
  endif;
endif;

// ----------- Info réponse de base -------------- //
  if(MODE =="dev"):
    $inscription['response']['script'] = __FILE__;
    $inscription['response']['foo'] = "bar";
    $inscription['response']['sql'] = $req_inscr;
  endif;
  $inscription['response']['time'] = date('Y-m-d,H:i:s');
  if($_SERVER['REQUEST_METHOD'] == 'GET'):
    $inscription['response']['nbhtis'] = $connect->num_row;
  endif;

echo json_encode($inscription);
exit;
?>