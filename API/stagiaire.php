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


// ---------------- Gestion du POST ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'POST'):
  $json_user = file_get_contents('php://input');
  $arrayUSER = json_decode($json_user, true);
  if(!isset($arrayUSER['email']) OR !isset($arrayUSER['prenom_user']) OR !isset($arrayUSER['nom_user']) OR !isset($arrayUSER['password']) OR !isset($arrayUSER['type_user'])):
    $user['response']['code'] = 400;
    $user['response']['message'] = `il manque l'une des informations suivantes: email, prenom, nom, mot de passe ou type d'utilisateur`;
    else :
      $req_user  = sprintf(
                    "INSERT INTO user (email, prenom_user, nom_user, password, type_user) VALUES ('%s', '%s', '%s', '%s', '%s');",
                    addslashes(strip_tags($arrayUSER['email'])),
                    addslashes(strip_tags($arrayUSER['prenom_user'])),
                    addslashes(strip_tags($arrayUSER['nom_user'])),
                    addslashes(strip_tags($arrayUSER['password'])),
                    addslashes(strip_tags($arrayUSER['type_user']))
                  );
      $connect->query($req_user);
      echo $connect->error;
      $user['response']['code'] = 200;
      $user['response']['message'] = 'L\'utilisateur a été créé ';
      $user['response']['id_user'] = $connect->insert_id;
  endif;
endif;

// ----------- Info réponse de base -------------- //
if(MODE =="dev"):
  $user['response']['script'] = __FILE__;
  $user['response']['sql'] = $req_user;
endif;
$user['response']['time'] = date('Y-m-d,H:i:s');
$user['response']['foo'] = "bar";


// ------------- Encodage réponse  ---------------- //
echo json_encode($user);
exit;
?>