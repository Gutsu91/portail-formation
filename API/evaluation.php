<?php
// ------------------- Includes ------------------- //
require_once 'config.php';
session_start();

// ---------------- Gestion du GET ---------------- //
/*if($_SERVER['REQUEST_METHOD'] == 'GET'):
  if(isset($_GET['id_formation'])):
    $req_eval = sprintf(
      "SELECT
      s.id_savoir, s.id_formation, s.nom_savoir, s.definition_savoir,
      c.id_comportement, c.grade_comportement, c.definition_comportement,
      f.nom_formation
    FROM savoir s
    INNER JOIN comportement c ON s.id_savoir = c.id_savoir
    INNER JOIN formation f ON s.id_formation = f.id_formation
    WHERE s.id_formation=%d
    ORDER BY s.id_savoir ASC, c.grade_comportement ASC",
    $_GET['id_formation']);
    $result = $connect->query($req_eval);
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
endif;*/
// ---------------- Test GET multi dimension ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'GET'):
  if(isset($_GET['id_formation'])):
    // une requête ou on va aller chercher le nom de la formation, les savoir et définitions liées
    $req_formation = sprintf(
      "SELECT 
        f.id_formation, f.nom_formation,
        s.id_savoir, s.nom_savoir, s.definition_savoir
      FROM formation f
      INNER JOIN savoir s ON f.id_formation = s.id_formation
      WHERE f.id_formation = %s
       ",
      $_GET['id_formation']);
    // une requête ou on va aller chercher les comportements et grades liés à la formation
    $req_eval = sprintf(
      "SELECT 
      c.id_comportement, c.grade_comportement, c.definition_comportement, s.id_savoir
    FROM comportement c 
    INNER JOIN savoir s ON c.id_savoir = s.id_savoir
    WHERE s.id_formation = %d",
    $_GET['id_formation']);
    $result = $connect->query($req_eval);
    $eval['response']['code'] = 200;
    $eval['response']['message'] = 'Info eval propre à un métier particulier';
    $eval['response']['nbhits'] = $result->num_rows;
    while($row = $result->fetch_assoc()):
      $eval['comportement'][] = $row;
    endwhile;
    $result2 = $connect->query($req_formation);
    while($row = $result2->fetch_assoc()):
      $eval['formation'][] = $row;
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