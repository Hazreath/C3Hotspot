<!DOCTYPE html>
<html lang="fr" >
<?php
session_start();


?>
<head>
  <meta charset="UTF-8">
  <title>Gestion Hotspot</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
  
 
  <link rel="stylesheet" href="css/style.css">
  
</head>

<body>
	
	  <div class="cont">
	  <div class="demo">
		<div class="login">
		  <div class="logo"></div>
		  <h1>Administration</h1>
		  <form class="login__form" method="POST" action="admin_login.php">
			<div class="login__row">
			  
			  <input type="text" name='login' class="login__input name" placeholder="Nom d'utilisateur"/>
			</div>
			<div class="login__row">
				<input type="password" name='password' class="login__input pass" placeholder="Mot de passe"/>
			</div>
			
			<div id='connexion_result'></div>
			<button type="submit" id='btn_co' class="admin_submit">Sign in</button>
		  </form>
		</div>
    </div>
  </div>
</div>



</body>

</html>
