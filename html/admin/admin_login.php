<?php
	//basePage();
	
	/**
	 * Connexion administrateur hotspot
	 * Permet l'accès à l'interface de personnalisation du point d'accès
	 * 
	 */
	 
	$login = isset($_POST['login']) ? $_POST['login']:"";
	$pass = isset($_POST['password']) ? $_POST['password']:"";
	
	$url_config = "config.json";
	$config = json_decode(file_get_contents($url_config));

	// Vérif connexion
	if ( (strcmp($login,$config->{'login'}) == 0) &&
		 (strcmp($pass,$config->{'password'}) == 0) ) {
	
		
		pageAdmin();
	} else {
	
		debug("Erreur : Nom d'utilisateur ou mot de passe erroné");
	}
	
	
	
	
	
	function debug($msg) {
		echo "<p>".$msg."</p>";
	}
	
	
	function basePage() {
		echo
		'<!DOCTYPE html>
		<html lang="fr">
		<head>
		  <meta charset="UTF-8">
		  <title>Gestion Hotspot</title>
		  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
		  
		 
		  <link rel="stylesheet" href="css/admin_style.css">
		 
		</head>
		<body>
			<div class="back">
				<div class="content"></div>
			
		</body>
		
		
		
		';
		
	}
	
	function pageAdmin() {
		// TODO chargement du réglage actuel
		echo
		"<!DOCTYPE html>
		<html lang='fr'>
		<head>
		  <meta charset='UTF-8'>
		  <title>Gestion Hotspot</title>
		  <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=yes' /> 
		  <link rel='stylesheet' href='css/admin_style.css'>
		  <script type='text/javascript>
			var formAdmin = document.getElementById('formAdmin');
			
		  </script>
		</head>
		<body>
			<div class='back'>
			<div class='demo'>
			<div class='admin'>
			<form name='form'>
				<fieldset>
				<legend>Configuration du Hotspot</legend>
					<fieldset>
					<legend>Paramètres Systèmes</legend>
						<div class='admin_row'>
							<input class='admin_input' placeholder='Nom du réseau Wi-Fi' />
						</div>
						<div class='admin_row'>
							<input class='admin_input' placeholder='Serveur FTP (Envoi des logs)'/>
						</div>
					</fieldset>
					
					<fieldset>
					<legend>Paramètres de la page de connexion</legend>
						<div class='admin_row'>
							<input class='admin_input' placeholder='Nom de la bibliothèque'/>
						</div>
					
						<div class='admin_row'>
							<p>Logo : <input type='file' /></p>
						</div>
						<div class='admin_row'>
							<p>Icône : <input type='file' /></p>
						</div>
						<div class='admin_row'>
							<p>Image de fond : <input type='file' /></p>
						</div>
						<div class='admin_row'>
							<input class='admin_input' placeholder='Texte de fond Nom'/>
							<input class='admin_input' placeholder='Texte de fond Numéro de carte'/>
						</div>
						<div class='admin_row'>
							<p>Couleur du texte de fond des champs: <input type='color' /></p>
						</div>
						<div class='admin_row'>
							<p>Couleur du texte<input type='color' /></p>
						</div>
						<div class='admin_row'>
							<p>Couleur des boutons<input type='color' /></p>
						</div>
						<div class='admin_row'>
							<p>Couleur du texte des boutons<input type='color' /></p>
						</div>
					
					</fieldset>
					<fieldset>
					<legend>Paramètres du compte administrateur</legend>
						<div class='admin_row'>
							<input type='password' class='admin_input' placeholder='Nouveau mot de passe'/>
						</div>
						<div class='admin_row'>
							<input type='password' class='admin_input' placeholder='Confirmation nouveau mot de passe'/>
						</div>
					</fieldset>
				</fieldset>
				<input type='button' value='Appliquer' />
			</form>
			
			
		</div></div></div>
		</body>
		</html>
		
		
		";
	}
	
	
	
?>
