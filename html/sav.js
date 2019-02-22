console.log('ok');
        
        
        function login() {
			alert('lol');
			var name=document.getElementById('user').value;
		    var pass=document.getElementById('pass').value;
            $.ajax({
              type: "GET",
              url: "http://192.168.2.141/Auth.aspx",
              data: {
				  login: name,
				  mdp: pass
			  }
              
            }).done(function( msg ) {
              alert( "Data Saved: " + msg );
              $('#result').innerHTML+=msg;
            });
            console.log("called");
         }
         
        function callLogin() {
			
			$.ajax ({
				url:'login.php',
				
				type:'post'
			}).done(function( msg ) {
              alert( "Data Saved: " + msg );
              // TODO parse infos
			});
		}
