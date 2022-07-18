<?php
session_start();

//------------ Verif token + refresh--------------- 
if( $_SERVER['REQUEST_METHOD'] != 'GET') :
  $now = time();
  if ( !isset($_SESSION['user']) OR $now > $_SESSION['expiration']):
      unset($_SESSION['user']);
      unset($_SESSION['token']);
      unset($_SESSION['expiration']);
      $auth['response']['message'] = "Token expired";
      $auth['response']['code'] = 401;
      echo json_encode($auth);
      die();
  else:
      $json = file_get_contents('php://input');
      $arrayPOST = json_decode($json, true);
      if($arrayPOST['token'] != $_SESSION['token']) :
          $auth['response']['message'] = "Wrong token";
          $auth['response']['code'] = 401;
          echo json_encode($auth);
          die();
      endif;
  endif;
  $_SESSION['expiration'] = time() + 1 * 600;
endif;
?>