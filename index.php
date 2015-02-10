<?php
if(empty $_GET['page'])
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
?>
