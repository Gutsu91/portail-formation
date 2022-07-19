<?php
require_once 'config.php';
session_start();

// ---------------- GET comportement lié à un savoir ---------------- //
if($_SERVER['REQUEST_METHOD'] == 'GET'):
  if(isset($_GET['id_savoir'])) :
    $req_savoir = sprintf("SELECT * FROM comportement WHERE id_savoir=%d",
    $_GET['id_savoir']);
    $result = $connect->query($req_savoir);
    while($row = $result->fetch_assoc()):
      $savoir[] = $row;
    endwhile;
  endif;
endif;

echo json_encode($savoir);
exit;