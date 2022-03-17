<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link type="text/css" rel="stylesheet" href="style/index.css"/>
  </head>
  <body>

    <h1>Inscription</h1>

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

      // n'existe pas dans la db
      if (! user_in_db()) {

        $user_name = $_POST['user_name'];
        $password = $_POST['password'];

        // ajouter dans la db
        $insert = $db -> prepare("INSERT INTO users VALUES(NULL,:user_name,:password)");
        $insert -> execute([':user_name'=>$user_name, ':password'=>$password]);

        echo"Ajout réussi.";

        // retour Acceuil
        header("Location: index.html");
        die();
      }
      else {
        echo"déjà dans la DB !";

      }
    }
    else
      echo"champ(s) vide(s) !";
  }
 ?>
