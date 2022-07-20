<?php
require_once 'config.php';

// ---------------- Gestion du POST ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'POST'):
  $json_search = file_get_contents('php://input');
  $arraySEARCH = json_decode($json_search, true);
  if(isset($arraySEARCH['search'])):
    $req_search = sprintf("SELECT * FROM user WHERE prenom_user LIKE '%s' OR nom_user LIKE '%s' AND type_user='stagiaire';",
                  $arraySEARCH['search'].'%',
                  $arraySEARCH['search'].'%');
  else:
    $search['response']['code'] = 400;
    $search['response']['message'] = `il manque l'une des informations suivantes: email, prenom, nom, mot de passe ou type d'utilisateur`;
  endif;
  $result = $connect->query($req_search);
  echo $connect->error;
  $search['response']['code'] = 200;
  $search['response']['code'] = 'user matching your research';
  while($row = $result->fetch_assoc()):
    $search['data'][] = $row;
  endwhile;
endif;

// ----------- Info réponse de base -------------- //
if(MODE =="dev"):
  $search['response']['script'] = __FILE__;
  $search['response']['sql'] = $req_search;
endif;
$search['response']['time'] = date('Y-m-d,H:i:s');
$search['response']['foo'] = "bar";
$search['response']['nbhits'] = $result->num_rows;


// ------------- Encodage réponse  ---------------- //
echo json_encode($search);
exit;
?>
?>