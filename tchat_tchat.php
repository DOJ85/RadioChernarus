<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>

  <?php

  session_start();

  include 'radio_chernarus_bdd.php';
  if(!isset($_POST['logout'])){
    if(isset($_SESSION['username'])){ ?>
      <form method="post">
        <input type="submit" name="logout" value="Se deconecté">
      </form>
      <?php
      echo 'Connecter en tant que ' . $_SESSION['username'];
    } else {
      echo 'Vous n\'êtes pas connecté'; ?>

      <a href="signin.php"><button>Sign In</button></a>
      <a href="login.php"><button>Log In</button></a>

      <?php
    }
  } else {
    session_destroy();
    ?>

    <a href="signin.php"><button>Sign In</button></a>
    <a href="login.php"><button>Log In</button></a>

    <?php
  }

  ?>




</body>
</html>
