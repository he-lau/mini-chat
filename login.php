<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

        <h1>Connexion</h1>

        <form action="" method="post">

          <label>ID : </label>
          <br>
          <input type="text" name="user_name" value="">
          <br>
          <label>Mot de passe : </label>
          <br>
          <input type="password" name="password" value="">
          <br><br>
          <input type="submit" value="Confirmer">

        </form>

  </body>
</html>

<?php

  // champs existe bien
  if (isset($_POST['user_name'],$_POST['password'])) {
    if ((!empty($_POST['user_name']) && (!empty($_POST['password'])))) {

      require_once 'php/functions-db.php';

      connect_db();

      $user_name = $_POST['user_name'];
      $password = $_POST['password'];

      if (! connect_success($user_name)) {
        echo"Connexion échouée !";
      }
      else {

        session_start();

        $_SESSION['username'] = $user_name;
        $_SESSION['password'] = $password;

        $_SESSION['num'] = $password;

        //echo $_SESSION['username'];

        header("Location: chat.php?page=1");
      }

    }
    else
      echo"champ(s) vide(s) !";
  }
 ?>
