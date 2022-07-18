<?php
// ------------------- Includes ------------------- //
require_once 'config.php';
session_start();


// -------------------- Log ----------------------- //
if ($_SERVER['REQUEST_METHOD'] == 'POST') :
  $json_auth = file_get_contents('php://input');
  $arrayAUTH = json_decode($json_auth, true);
  if ( !isset($arrayAUTH['email']) OR !isset($arrayAUTH['password'])) :
    $auth['response']['message'] = "Il manque votre login (adresse email) et/ou votre mot de passe";
    $auth['response']['code'] = 500;   
  else:
    $sql = sprintf("SELECT * FROM user WHERE email = '%s' AND password = '%s'",
        $arrayAUTH['email'],
        $arrayAUTH['password']    
    );
    $result = $connect->query($sql);
    echo $connect->error;
    $nb_rows =  $result->num_rows;
    if($nb_rows == 0) :
        $auth['response']['message'] = 'error de login et/ou pass';
        $auth['response']['code'] = 403;
    else :
        $row = $result->fetch_assoc();
        $_SESSION['id_user'] = (int)$row['id_user'];
        $_SESSION['token'] = md5($row['email'].time());
        $_SESSION['expiration'] = time() + 1 * 600;
        $auth['response']['message'] = "OK connecté";
        $auth['data']['email'] = $row['email'];
        $auth['data']['token'] = $_SESSION['token'];
        $auth['data']['id_user'] = $_SESSION['id_user'];
    endif;
  endif;
endif;

// ------------------- Delog ---------------------- //
if(isset($_GET['delog'])):
  unset($_SESSION['id_user']);
    unset($_SESSION['token']);
    unset($_SESSION['expiration']);
    if(MODE =="dev"):
      $auth['response']['script'] = __FILE__;
    endif;
    $auth['response']['message'] = "Hasta la vista, bye-bye";
    $auth['response']['time'] = date('Y-m-d,H:i:s');
    $auth['response']['foo'] = "bar";
    $auth['response']['code'] = 200;
    echo json_encode($auth);
    exit;
endif;


// ----------- Info réponse de base -------------- //
if(MODE =="dev"):
  $auth['response']['script'] = __FILE__;
endif;
$auth['response']['time'] = date('Y-m-d,H:i:s');
$auth['response']['foo'] = "bar";


// ------------- Encodage réponse  ---------------- //
echo json_encode($auth);
exit
?>