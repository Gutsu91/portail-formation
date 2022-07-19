<?php
require_once 'config.php';
session_start();

/* Ce fichier est un test pour grouper les info différemment dans JSON, i.e. faire une entrée par savoir via la boucle habituelle, puis à l'intérieur du while faire une autre requête pour aller chercher les comportements liés. Si ça fonctionne, je m'en servirai dans gestion-evaluation.html, si pas on peut le supprimer

*/

if($_SERVER['REQUEST_METHOD'] == 'GET'):
  if(isset($_GET['id_formation'])):
    $req_formation = sprintf(
      "SELECT 
      f.id_formation, f.nom_formation,
      s.id_savoir, s.nom_savoir, s.definition_savoir
    FROM formation f
    INNER JOIN savoir s ON f.id_formation = s.id_formation
    WHERE f.id_formation = %s",
      $_GET['id_formation']
    );
    $result = $connect->query($req_formation);
    $i = 0;
    while($row = $result->fetch_assoc()):
      $i ++;
      $eval['formation'.$i] = $row;
      $req_eval = sprintf(
        "SELECT 
          c.id_comportement, c.grade_comportement, c.definition_comportement, s.id_savoir
        FROM comportement c 
        INNER JOIN savoir s ON c.id_savoir = s.id_savoir
        WHERE s.id_formation = %d AND c.id_savoir = %d
        ORDER BY c.id_savoir ASC, c.grade_comportement ASC",
        $_GET['id_formation'],
        $i);
        $result2 = $connect->query($req_eval);
        while($row = $result2->fetch_assoc()):
          $eval['formation'.$i]['comportement'][] = $row;
        endwhile;
    endwhile;
  endif;
endif;

echo json_encode($eval);
exit;
?>