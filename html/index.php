<!DOCTYPE html>
<html lang="fr" >
<?php
session_start();
$_SESSION['redir'] = $_GET['redir'];

?>
<head>
  <meta charset="UTF-8">
  <title>C3Hotspot[en construction]</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
  
 
  <link rel="stylesheet" href="css/style.css">
  <script src='jquery.min.js'></script>
  <script src='C3Hotspot.js' type='text/javascript'></script>
  
</head>

<body>
	
	  <div class="cont">
	  <div class="demo">
		<div class="login">
		  <div class="logo"></div>
		  <h1>C3Hotspot</h1>
		  <div class="login__form">
			<div class="login__row">
			  
			  <input type="text" id='user' class="login__input name" placeholder="Numéro de carte"/>
			</div>
			<div class="login__row">
				<input type="password" id='pass' class="login__input pass" placeholder="Mot de passe"/>
			</div>
			<div class="login__row">
				<input type='checkbox' id='cgu'>J'ai lu et j'accepte les CGUs</input>
			</div>
			<div id='connexion_result'></div>
			<button type="button" id='btn_co' class="login__submit" onclick='connexion();'>Sign in</button>
			<button type="button" id='testbtn' class="login__submit" onclick="fillTest()">IDTEST</button>
		  </div>
		</div>
    </div>
  </div>
</div>



</body>

</html>
