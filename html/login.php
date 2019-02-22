<?php
	//header('Access-Control-Allow-Origin: *');
	libxml_disable_entity_loader(false);
	session_start();
	error_reporting(E_ALL);

	/** CODES D'ERREURS */
	define("CONNEXION_OK",0);
	define("ERR_NUMCARTE",-1);
	define("ERR_NONSPEC",-2);
	
	/** C3RB A PAS DE WIFI ? */
	$c3rb = array("steph","benji","sam","nicolas");
	
	/**
	 * Authentifie l'utilisateur si son nom et son numéro de carte
	 * correspondent à un utilisateur dans la base orphee.
	 * @returns -1 si l'authentification a échouée
	 * 
	 */
	function soapCall() {
		
		// Adresse du WS
		$ws_address = "http://192.168.2.156/Auth.aspx";
		
		// Infos de connexion de l'utilisateur
		$login = (isset($_POST['login'])) ? $_POST["login"]:"";
		$mdp= (isset($_POST['mdp'])) ? $_POST["mdp"]:"";
		
		// TODO A ENLEVER ======================================
		if (strcmp($login,'steph') == 0) {
			steph();
			return 0;
		}
		
		
		// =====================================================
		
		// Appel du ws Auth.aspx avec les infos de connexion
		$ws_call_url = $ws_address.'?login='.$login.'&mdp='
				.$mdp;
		$result = file_get_contents($ws_call_url);
		
		$xml = simplexml_load_string($result);
		$status = $xml->{'status'};

		// Traitement en fonction du résultat de l'auth ws
		if (strcmp($status,"OK") == 0) {
			display('Authentification réussie !');
			auth($login,$mdp);
			return CONNEXION_OK;
		} else {
			$msg_err = $xml->{'reason'};
			if (strcmp($msg_err,"Numéro de carte incorrect.") == 0){
				
				display('Échec de l\'authentification : '
				.'Nom ou numéro de carte erroné.');
				return ERR_NUMCARTE;
			} else {
				display($msg_err);
				return ERR_NONSPEC;
			}
			
		}
	}
	
	/**
	 * Authentifie l'utilisateur qui vient de se connecter avec
	 * des identifiants valides en le redirigeant vers
	 * l'url d'authentification nds avec son token de session
	 * 
	 * @see https://nodogsplashdocs.readthedocs.io/en/stable/fas.html
	 */
	function auth($login,$mdp) {
		display_redir($_SESSION['redir']);
		session_abort();
		
		// Infos clients nds
		$ip = $_SERVER['REMOTE_ADDR'];
		$cmdInfos = 'sudo ndsctl json '.$ip.' 2>&1';
		$infos = json_decode(shell_exec("$cmdInfos"));
		
		// Connect the current user
		$cmd_login = 'sudo ndsctl auth '.$ip.' 2>&1';
		$log_user = shell_exec($cmd_login);
		
		trace_user($login,$mdp,$infos->{'ip'},$infos->{'mac'});
		
	}
	
	
	
	// MAIN --------------------------------------------------------
	display_ret(soapCall());
	
	// Envoie l'addresse de redirection de l'utilisateur au portail
	display_redir($_SESSION['redir']);
	session_abort();
	
	/**
	 * Ajoute l'utilisateur venant de se connecter à la liste des
	 * clients entrants (préfixé IN et heure de connection)
	 * @param $nom nom de l'utilisateur
	 * @param $carte numéro de carte de l'utilisateur
	 * @param $ip adresse ip de la machine de l'utilisateur
	 * @param $mac adresse mac de la machine du client
	 */
	function trace_user($nom,$carte,$ip,$mac) {
		$current_time = date("H:i");
		$nom = strtolower($nom);
		$write = shell_exec("sudo C3Trace IN ".$current_time.
				' '.$nom.' '.$carte.' '
				   .' '.$ip.' '.$mac);
		
	}
	
	
	
	
	/**
	 * TODO FAILLE ENLEVER AVANT MISE EN PROD
	 * Permet à un utilisateur du bureau qui ne capte aucun autre
	 * réseau de se connecter sans vérification avec ws.
	 * 
	 */
	// ============================================================
	function steph() {
		display("Tu es désormais authentifié à l'unique réseau"
		." wifi fonctionnel de C3RB");
		auth();
	}
	// ============================================================
		
	/** Fonctions d'affichage */
	function display($message) {
		echo '<p>'.$message.'</p>';
	}
	
	function display_ret($msg) {
		echo '<p id="code_ret">'.$msg.'</p>';
	}
	
	function display_redir($msg) {
		echo '<p id="redir">'.$msg.'</p>';
	}
	
	
	/** DEBUG */
	function wtf(){
	  error_reporting(E_ALL);
	  $args = func_get_args();
	  $backtrace = debug_backtrace();
	  $file = file($backtrace[0]['file']);
	  $src  = $file[$backtrace[0]['line']-1];  // select debug($varname) line where it has been called
	  $pat  = '#(.*)'.__FUNCTION__.' *?\( *?\$(.*) *?\)(.*)#i';  // search pattern for wtf(parameter)
	  $arguments  = trim(preg_replace($pat, '$2', $src));  // extract arguments pattern
	  $args_arr = array_map('trim', explode(',', $arguments));

	  print '<style>
	  div.debug {visible; clear: both; display: table; width: 100%; font-family: Courier,monospace; border: medium solid red; background-color: yellow; border-spacing: 5px; z-index: 999;}
	  div.debug > div {display: unset; margin: 5px; border-spacing: 5px; padding: 5px;}
	  div.debug .cell {display: inline-flex; padding: 5px; white-space: pre-wrap;}
	  div.debug .left-cell {float: left; background-color: Violet;}
	  div.debug .array {color: RebeccaPurple; background-color: Violet;}
	  div.debug .object pre {color: DodgerBlue; background-color: PowderBlue;}
	  div.debug .variable pre {color: RebeccaPurple; background-color: LightGoldenRodYellow;}
	  div.debug pre {white-space: pre-wrap;}
	  </style>'.PHP_EOL;
	  print '<div class="debug">'.PHP_EOL;
	  foreach ($args as $key => $arg) {
	    print '<div><div class="left-cell cell"><b>';
	    array_walk(debug_backtrace(),create_function('$a,$b','print "{$a[\'function\']}()(".basename($a[\'file\']).":{$a[\'line\']})<br> ";'));
	    print '</b></div>'.PHP_EOL;
	    if (is_array($arg)) {
	      print '<div class="cell array"><b>'.$args_arr[$key].' = </b>';
	      print_r(htmlspecialchars(print_r($arg)), ENT_COMPAT, 'UTF-8');
	      print '</div>'.PHP_EOL;
	    } elseif (is_object($arg)) {
	      print '<div class="cell object"><pre><b>'.$args_arr[$key].' = </b>';
	      print_r(htmlspecialchars(print_r(var_dump($arg))), ENT_COMPAT, 'UTF-8');
	      print '</pre></div>'.PHP_EOL;
	    } else {
	      print '<div class="cell variable"><pre><b>'.$args_arr[$key].' = </b>&gt;';
	      print_r(htmlspecialchars($arg, ENT_COMPAT, 'UTF-8').'&lt;');
	      print '</pre></div>'.PHP_EOL;
	    }
	    print '</div>'.PHP_EOL;
	  }
	  print '</div>'.PHP_EOL;
	}

?>

