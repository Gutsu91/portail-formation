<?php
require_once 'config.php';

// ---------------- Gestion du GET ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'GET'):
  if(isset($_GET['id_session'])):
    $req_inscr = sprintf(
                      "SELECT 
                        u.prenom_user, u.nom_user, u.email,
                        i.id_session, s.nom_session
                      FROM inscription i
                      INNER JOIN user u ON i.id_user = u.id_user
                      INNER JOIN session s on i.id_session = s.id_session
                      WHERE i.id_session = %d",
                    $_GET['id_session']);
      $result = $connect->query($req_inscr);
      $inscription['response']['code'] = 200;
      $inscription['response']['message'] = 'Tous les utilisateurs inscrit à une session spécifique';
      $inscription['response']['nbhits'] = $result->num_rows;
      while($row = $result->fetch_assoc()):
        $inscription['data'][] = $row;
      endwhile;
  endif;
endif;

// ---------------- Gestion du POST ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'POST') :
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

// ---------------- Gestion du delete ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'DELETE') :
  if(isset($_GET['id_inscription'])):
    $req_inscr = sprintf("DELETE FROM inscription WHERE `id_inscription` = %d",
    $_GET['id_inscription']);
    $result = $connect->query($req_inscr);
    echo $connect->error;
    $inscription['response']['code'] = 200;
    $inscription['response']['message'] = "Inscription supprimée";
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
    $inscription['response']['nbhits'] = $result->num_rows;
  endif;

echo json_encode($inscription);
exit;
?>