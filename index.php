<?php
if(empty($_GET['page']))
{
?>
	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" href="design.css" />
		<title>Formulaire de contact</title>
	</head>

	<body>
	<section>
		<form method="post" action="index.php?page=traite">
			<p><label for="nom">Votre nom</label><br/><input type="text" name="nom" id="name" /></p>
			<p><label for="mail">Votre adresse courriel</label><br/><input type="email" name="mail" id="email" /></p>
			<p><label for="message">Votre message</label><br/><textarea name="message" id="message"></textarea></p>
			<p><input type="submit" value="Envoyer" /></p>
		</form>
	</section>
	</body>
	</html>
<?php
}

elseif($_GET['page'] == traite)
{
	if((empty($_POST['nom']) OR empty($_POST['mail']) OR empty($_POST['message'])))
	{
		header('Location: index.php?page=oubli');
	}

	else
	{
		$mail = 'romainarreghini@hotmail.fr';

		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
		{
		    $passage_ligne = "\r\n";
		}
		else
		{
		    $passage_ligne = "\n";
		}

		//=====Déclaration des messages au format texte et au format HTML.
		$message_txt = $_POST['message'];
		$message_txt .= $_POST['nom'];
		$message_txt .= $_POST['mail'];
		$message_html = "<html><head><meta charset=\"utf-8\" /></head><body>".htmlspecialchars($_POST['message'])."<br/><br/>".htmlspecialchars($_POST['nom'])."<br/>".htmlspecialchars($_POST['mail'])."</body></html>";
		//==========

		//=====Création de la boundary
		$boundary = "-----=".md5(rand());
		//==========

		//=====Définition du sujet.
		$sujet = "Aurore vous avez un nouveau message de ".htmlspecialchars($_POST['prenom'])." ".htmlspecialchars($_POST['nom'])." <".htmlspecialchars($_POST['mail']).">";
		//=========

		//=====Création du header de l'e-mail.
		$header = "From: \"".htmlspecialchars($_POST['nom'])."\"".htmlspecialchars($_POST['mail'])."".$passage_ligne;
		$header .= "Reply-to: \"".htmlspecialchars($_POST['nom'])."\"".htmlspecialchars($_POST['mail'])."".$passage_ligne;
		$header .= "MIME-Version: 1.0".$passage_ligne;
		$header .= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========

		//=====Création du message.
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format texte.
		$message .= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_ligne;
		$message .= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message .= $passage_ligne.$message_txt.$passage_ligne;
		//==========
		$message .= $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format HTML
		$message .= "Content-Type: text/html; charset=\"UTF-8\"".$passage_ligne;
		$message .= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message .= $passage_ligne.$message_html.$passage_ligne;
		//==========
		$message .= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message .= $passage_ligne."--".$boundary."--".$passage_ligne;
		//==========

		//=====Envoi de l'e-mail.
		mail($mail,$sujet,$message,$header);
		//========

		header('Location: index.php?page=sent');
	}
}
?>
