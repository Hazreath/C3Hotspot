/** C3Hotspot.js */
/** v 0.1 */

/**
 * Connecte l'utilisateur
 *
 *
 *
 */
function connexion() {
	var displayDiv = document.getElementById('connexion_result');
	$.ajax ({
		url:'login.php',
		type:'post',
		data: {
			login: document.getElementById('user').value,
			mdp:   document.getElementById('pass').value
		},
		
	}).done(function( msg ) {
		display(msg);
		var code_ret = document.getElementById('code_ret').innerHTML;
		if (code_ret == 0) {
			display(msg + "\nVous allez être redirigé dans quel"
			 + "ques secondes...");
			setTimeout(redir(), 4000);
			
		}
	});
}


function display(msg) {
		document.getElementById('connexion_result').innerHTML = msg;
}

function getParam(name) {
    url = location.href;
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( url );
    return results == null ? null : results[1];
}

function redir() {
	
	var redirDiv = document.getElementById('redir');
	var url = redirDiv.innerHTML;
	window.location = (url == "" || url.includes("gstatic")
		|| url.includes("connectivity")) ? 'http://qwant.com':url;
}
// TEST ENV TODO DELETE ========================================
//~ $(document).ready(function(){
	//~ document.getElementById('user').value='Lesieur';
	//~ document.getElementById('pass').value='93448000000801';
	
//~ });

function fillTest() {
	document.getElementById('user').value='';
	document.getElementById('pass').value='';
	var nom = ['LESIEUR','ARNAUD','BORREMANS','VITALIS','GARCIA','MOGNENI','MOINET'];
	var carte = [93448000000801,93448000000108,93448000000140,93448000000561,93448000000306,93448000000942,93448000000132];
	var rand = Math.round(Math.random() * 1000) % nom.length;
	document.getElementById('user').value=nom[rand];
	document.getElementById('pass').value=carte[rand];
	//~ document.getElementById('user').value='Lesieur';
	//~ document.getElementById('pass').value='93448000000801';
}
