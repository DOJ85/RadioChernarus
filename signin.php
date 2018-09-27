<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="style.css">
  <title>87.8 | Sign In</title>
</head>
<body class="signInBody">



  <div class="signInContainer">

    <?php

  session_start();

    include 'radio_chernarus_bdd.php';

    // $reponse = $bdd->query('SELECT username FROM users');
    // while($donnees = $reponse->fetch()){
    //   echo '<p>' . $donnees['username'] . '</p>';
    // }

  if(isset($_POST['submit'])){
    if(isset($_POST['pseudoInput']) AND isset($_POST['passwordInput'])){
      if (!empty($_POST['pseudoInput']) && !empty($_POST['passwordInput']) && !empty($_POST['passwordInputConfirm'])){

        $emailHash = htmlspecialchars(bin2hex(random_bytes(16)));
        $emailInput = filter_var($_POST['emailInput'], FILTER_SANITIZE_EMAIL);
        $pseudoInput = htmlspecialchars($_POST['pseudoInput']);
        $passwordInput = hash('sha512', $_POST['passwordInput']);
        $passwordInputConfirm = hash('sha512', $_POST['passwordInputConfirm']);


        //$passwordInput = password_hash($_POST['passwordInput'], PASSWORD_BCRYPT);
        //$passwordInputConfirm = password_hash($_POST['passwordInputConfirm'], PASSWORD_BCRYPT);


        $pseudoDouble = $bdd->prepare('SELECT username FROM users WHERE username = :pseudoInput');
        $pseudoDouble->bindParam(':pseudoInput', $pseudoInput);

        $emailDouble = $bdd->prepare('SELECT email FROM users WHERE email = :emailInput');
        $emailDouble->bindParam(':emailInput', $emailInput);
        $emailDouble->execute();

        if(filter_var($emailInput, FILTER_VALIDATE_EMAIL)){
        if($emailDouble->rowCount() < 1){
          if($pseudoDouble->rowCount() < 1){

            if (strlen($_POST['passwordInput']) >= 8 ){




              if($passwordInput == $passwordInputConfirm){
                $stmt = $bdd->prepare("INSERT INTO `users`(`username`, `hash`, `email`, `password`) VALUES (:pseudoInput, :emailHash, :emailInput, :passwordInput)");
                $stmt->bindParam(':pseudoInput', $pseudoInput);
                $stmt->bindParam(':emailHash', $emailHash);
                $stmt->bindParam(':passwordInput', $passwordInput);
                $stmt->bindParam(':emailInput', $emailInput);
                $stmt->execute();

                $_SESSION['active'] = 0;


                require_once('PHPMailer/PHPMailerAutoLoad.php');
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = '465';
                $mail->isHTML();
                $mail->Username = 'radiochernarus@gmail.com';
                $mail->Password = 'spSCy3972EgfUThD749vR3';
                $mail->SetFrom('radiochernarus@gmail.com');
                $mail->Subject = 'Account Verification';
                $mail->Body = '
                              Hello, survivor!

                              Thanks you for joining our group, click on the link below to activate your account:

                                http://localhost/radio_chernarus_verify.php?email='.$emailInput.'&hash='.bin2hex($emailHash);
              $mail->AddAddress($emailInput);
              $mail->send();


                header('Location: login.php');
                exit();
              } else {
                echo 'les mdp ne sont pas identiques';
              }
            } else {
              echo 'Votre mot de passe doit contenir au moins 8 characters';
            }
          } else {
            echo 'Ce compte existe déjà';
          }
        } else {
          echo 'Cet Email est deja pris';
        }
      } else {
        echo 'Ce n\'est pas une adresse email valide';
      }
    } else {
      echo 'Veuillez remplir tous les champs';
    }
  }
  }

    ?>

    <form class="signInForm" method="post" name="tchatForm">
      <input type="text" name="emailInput" placeholder="E-mail"><br><br>
      <input type="text" name="pseudoInput" placeholder="Username"><br><br>
      <input type="password" name="passwordInput" placeholder="Password"><br><br>
      <input type="password" name="passwordInputConfirm" placeholder="Confirm Password"><br><br>

      <div class="caca">
        <input class="inputValidate" type="submit" name="submit" value="Valider">
      </div>


    </form><br>

    <label>Or connect here </label><a href="login.php"><button>Connect</button></a>

  </div>


</body>
</html>
