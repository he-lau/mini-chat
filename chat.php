<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Chat</title>
    <link type="text/css" rel="stylesheet" href="style/chat.css"/>
	</head>
	<body>
<!--------------------->



<div id="principal">

	<h2>
	<?php
	session_start();

	if(isset($_SESSION['username'])){echo "Bienvenu(e) ".$_SESSION['username']." ! ";}
	?>
</h2>

  <form action="" method="post" >

	<label>Pseudo : </label>
	<input name="pseudo" type="text"/>
	<label>Message : </label>
	<input name="message" type="text"/>
	<input type="submit" value="Envoyer">

	</form>

	<ul id="chat">

		<?php

			// session bien init
			if (isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_GET['page'])) {

				require_once 'php/functions-db.php';

				connect_db();


				/*
									// test
									for ($i=0; $i < 200; $i++) {
										$req=$db->prepare("INSERT INTO chat VALUES(:num, :pseudo, :msg, UNIX_TIMESTAMP())");
										$req->execute(array('num'=>$num,'pseudo'=>$i,'msg'=>$i));
									}
				*/

									// supprimer les messages en trops (max 100)
									$query = $db -> prepare("SELECT * FROM chat ORDER BY timestamp DESC");
									$query -> execute();

									$result = $query->fetchAll();

									foreach ($result as $cle => $ligne) {

										// a partir de la 101 ème valeur
										if ($cle>99) {
											$query=$db->prepare("DELETE FROM chat WHERE num=:num AND pseudo=:pseudo AND msg=:msg AND timestamp=:timestamp");
											$query -> execute([
												':num' => $ligne['num'],
												':pseudo' => $ligne['pseudo'],
												':msg' => $ligne['msg'],
												':timestamp' => $ligne['timestamp']
											]

											);
										}
									}

									// ajout à la liste ul (affichage resultat)

									$user_name = $_SESSION['username'];
									$password = $_SESSION['password'];

									// pagination messages
									$nombreDeMessagesParPage = 25;
									$totalDesMessages = 100;

									$nombreDePages = ceil($totalDesMessages / $nombreDeMessagesParPage);

									$indiceDebut;

									switch ($_GET['page']) {
										// 1-25
										case 1: $indiceDebut = 0;
											break;
										// 25-50
										case 2: $indiceDebut = 25;
											break;
										// 50-75
										case 3: $indiceDebut = 50;
											break;
										// 75-100
										case 4: $indiceDebut = 75;
											break;

										default: true;
									}

									//echo $_GET['page'];
									//echo $nombreMessages;

									//$query = $db -> prepare("SELECT timestamp,pseudo,msg FROM chat ORDER BY timestamp DESC LIMIT 10");
									$query = $db -> prepare("SELECT timestamp,pseudo,msg FROM chat ORDER BY timestamp DESC LIMIT $indiceDebut,$nombreDeMessagesParPage");

									$query -> execute();

									//$result = $query->fetch(PDO::FETCH_DEFAULT);
									$result = $query->fetchAll();

									$date = date_create();

									// parcours du resultat de la requete
									foreach ($result as $ligne) {

										date_timestamp_set($date, $ligne['timestamp']);

										echo '<li>'.date_format($date, 'Y-m-d H:i:s').'&nbsp&nbsp'.$ligne['pseudo'].'&nbsp&nbsp'.$ligne['msg'].'</li>';
									}

									echo "</ul>";

									// afficher le menu de navigation de page
									//echo $nombreDePages;

									echo "<ul class='menu'>";

									for ($i=0; $i <$nombreDePages; $i++) {
										$page = $i+1;
										echo "<li><a href='chat.php?page="."$page'".">Page ".$page."</a></li>";
									}

									echo "</ul>";

				// champs non vide
				if ((!empty($_POST['pseudo']) && (!empty($_POST['message'])))) {

					$num = num_user();
					$pseudo = htmlentities($_POST['pseudo']);
					$message = htmlentities($_POST['message']);

					// envoyer sur la base
					$req=$db->prepare("INSERT INTO chat VALUES(:num, :pseudo, :msg, UNIX_TIMESTAMP())");
					$req->execute(array('num'=>$num,'pseudo'=>$pseudo,'msg'=>$message));

				}
		    else
		      echo"champ(s) vide(s) !";
		  }
			else {
				echo "session expirée !";
			}

		 ?>

	</ul>

	<button onClick="window.location.reload();">Actualiser</button>


</div>



<!--------------------->
	</body>
</html>
