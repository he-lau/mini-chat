<?php

function connect_db() {

  global $db;

  $db = new PDO('mysql:host=localhost;port=3306;dbname=minichat', 'root', '');

}

/*
  Vérifier si l'utilisateur est déjà dans la db
*/

function user_in_db():bool {
  global $db;

  $user_name = $_POST['user_name'];
  $exist = $db -> prepare("SELECT COUNT(*) AS exist FROM users WHERE user_name = :user_name");

  $exist -> execute(
    [':user_name' => $user_name ]
  );

  $result = $exist->fetch(PDO::FETCH_ASSOC);

  return $result["exist"];
}

/*
  Vérifier si l'utilisateur est autorisé à se connecter
*/

function connect_success():bool {
  global $db;

  $user_name = $_POST['user_name'];
  $password = $_POST['password'];

  $correct_pass = $db -> prepare("SELECT COUNT(password) AS pass FROM users WHERE user_name = :user_name AND password = $password");

  $correct_pass -> execute(
    [':user_name' => $user_name ]
  );

  $result = $correct_pass->fetch(PDO::FETCH_ASSOC);

  // 1 si exist, 0 sinon
  $test = $result['pass'];

  // si l'utilisateur est dans la db et que le mot de passe est correct
  if (user_in_db() && $result['pass']==1)
    return true;
  return false;

}

/*
  retourne le num de l'utilisateur sur sa session courante
*/

function num_user() {

  global $db;

  $user_name = $_SESSION['username'];

  $query = $db -> prepare("SELECT num FROM users WHERE user_name = :user_name");

  $query -> execute(
    [':user_name' => $user_name ]
  );

  $result = $query->fetch(PDO::FETCH_ASSOC);

  return $result['num'];

}



?>
