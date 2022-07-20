<?php
// ------------------- Includes ------------------- //
require_once 'config.php';
session_start();

// ---------------- Gestion du GET ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'GET'):
  if(isset($_GET['id_formation'])):
    $req_eval = sprintf(
      "SELECT
      s.id_savoir, s.id_formation, s.nom_savoir, s.definition_savoir,
      c.id_comportement, c.grade_comportement, c.definition_comportement
    FROM savoir s
    INNER JOIN comportement c ON s.id_savoir = c.id_savoir
    WHERE id_formation=%d
    ORDER BY s.id_savoir ASC, c.grade_comportement ASC",
    $_GET['id_formation']);
    $result = $connect->query($req_eval);
    echo $connect->error;
    $eval['response']['code'] = 200;
    $eval['response']['message'] = 'Info eval propre à un métier particulier';
    $eval['response']['nbhits'] = $result->num_rows;
    while($row = $result->fetch_assoc()):
      $eval['data'][] = $row;
    endwhile;
  else:
    $eval['response']['code'] = 400;
    $eval['response']['message'] = "Il manque l'id de la formation";
  endif;
endif;

/* snippet post je me suis merdé 
if($_SERVER['REQUEST_METHOD'] == 'POST'):
 $json_eval = file_get_contents('php://input');
  $arrayEVAL = json_decode($json_eval, true);
  if(!isset($arrayEVAL['id_metier']) OR !isset($arrayEVAL['id_formation']) OR !isset($arrayEVAL['id_user']))
  */

  // ----------- Info réponse de base -------------- //
if(MODE =="dev"):
  $eval['response']['script'] = __FILE__;
endif;
$eval['response']['time'] = date('Y-m-d,H:i:s');
$eval['response']['foo'] = "bar";


// ------------- Encodage réponse  ---------------- //
echo json_encode($eval);
exit;
?>