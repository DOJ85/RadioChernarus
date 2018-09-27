<?php

include 'radio_chernarus_bdd.php';

function redirect(){
  header('location: signin.php');
  exit();
}

if(!isset($_GET['email']) || !isset($_GET['hash'])) {
//  redirect();
echo '1';
} else {

  include 'radio_chernarus_bdd.php';

  $emailInput = $_GET['email'];
  $emailHash = $_GET['hash'];

  $result = $bdd->prepare("SELECT id FROM users WHERE email='$emailInput' AND hash='$emailHash' AND emailConfirmed=0");
  $result->execute();

  if ($result->rowCount() == 0){
    $insert = $bdd->prepare("UPDATE users SET emailConfirmed='1', hash='' WHERE email='$emailInput'");
    $insert->execute();
    //redirect();
    echo 'Your Email has been verified, you can now Log In';
  } else {
  //  redirect();
  echo '3';
  }

}

 ?>
