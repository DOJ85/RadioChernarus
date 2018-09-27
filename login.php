<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>87.8 | Log In</title>
</head>
<body>

<?php
session_start();

  include 'radio_chernarus_bdd.php';

  if(isset($_POST['pseudoInput']) AND isset($_POST['passwordInput'])){
    if (!empty($_POST['pseudoInput']) && !empty($_POST['passwordInput'])){

      $pseudoInput = $_POST['pseudoInput'];
      $passwordInput = hash('sha512', $_POST['passwordInput']);

    $accountCheck = $bdd->prepare('SELECT * FROM users WHERE  username = :pseudoInput AND password = :passwordInput');
    $accountCheck->bindParam(':pseudoInput', $pseudoInput);
    $accountCheck->bindParam(':passwordInput', $passwordInput);
    $accountCheck->execute();







    if($accountCheck->rowCount() == 1){
      $_SESSION['username'] = $pseudoInput;
      echo '<p> You are connected as ' . $_SESSION['username'];
      header('location: index.php');
    } else {
      echo 'Wrong Username or Password';
    }
  } else {
    echo 'Please fill all the fields';
  }
}

 ?>

  <form method="post">
    <input type="text" name="pseudoInput"> Username<br><br>
    <input type="password" name="passwordInput"> Password<br><br>
    <input type="submit" name="" value="Valider">
  </form><br>

    <label>Or register here </label><a href="signin.php"><button>Register</button></a>



</body>
</html>
