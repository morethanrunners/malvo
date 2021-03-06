<?php
include_once("php/check_login_status.php");
// If user is already logged in, header that weenis away
if($user_ok == true){
	header("location: userlog.php?user=".$_SESSION["user"]);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->  
		
    <title>Malvo</title>
		
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Open+Sans|Droid+Sans' rel='stylesheet' type='text/css'>
		<!-- Custom CSS-->
		<link rel="stylesheet" href="assets/css/landing-style.css">
		<link href="assets/css/style.css" rel="stylesheet">
		
	</head>

  <body class="bodyback">
		<div class="container-fluid">
		<!--    Navbar-->
    	<nav class="navbar navbar-default navbar-fixed-top texto">
      	<div class="container">
        	<div class="navbar-header">
          	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
            	<span class="icon-bar"></span>
          	</button>
          	<a class="navbar-brand" href="#">RunLg | <small>A training log for runners.</small></a>
        	</div>
        	<div id="navbar" class="navbar-collapse collapse">
          
          	<ul class="nav navbar-nav navbar-right">
            	<li><a href="landing.html">Inicio</a></li>
            	<li><a href="#">Blog</a></li>
            	<li><a href="loginpage.php" class="sign-in">Entrar</a></li>
            
          	</ul>
        	</div><!--/.nav-collapse -->
      	</div>
    	</nav>
			<div class="row login">
					<div class="col-md-4"></div>
					<div class="col-md-4 text-center backdrop">
						<div class="transparent">
							
							<!--Mecanismo de intercambio de formulario con botones con botones-->
							
							<div class="row">
								<div class="col-md-6">
									
									<!--IMPORTANTE-->
<!--										corregir el aspecto de los botones para que sean del mismo tamano-->
									
								<button id="loginBtn" class="btn btn-default" onclick="toggleLtS('loginForm', 'signupForm', 'loginBtn', 'signupBtn');">Entrar</button>
								</div>
								<div class="col-md-6">
								<button id="signupBtn" class="btn btn-primary" onclick="toggleStL('signupForm', 'loginForm', 'signupBtn', 'loginBtn');">Registrarse</button>
								</div>
							</div>
							<form id="loginForm" class="form texto-blanco" action="" method="post" onsubmit="logIn(); return false">
								<h3>Entrar</h3>
								<div class="form-group">
									<label for="loginUser" class="sr-only">Username</label>
									<input type="text" id="loginUser" class="form-control" placeholder="Nombre de usuario" required>
								</div>
								<div class="form-group">
									<label for="loginPass" class="sr-only">Password</label>
									<input type="password" id="loginPass" class="form-control" placeholder="Contrasena" required>
								</div>	
								<div class="form-group">
									<div id="loginresult"></div>
								</div>
								<div class="form-group">
									<input type="submit" value="Log In" class="btn btn-default">
								</div>
							</form>
						<form id="signupForm" class="form texto-blanco" action="" method="post" onsubmit="signUp(); return false" class="form-signup" style="display:none">
						<h3>Registrarse</h3>
							<div class="form-group">
								<label for="signupUser" class="sr-only">Username</label>
								<input type="text" id="signupUser" placeholder="Nombre de Usuario" class="form-control">
							</div>
							<div class="form-group">
								<label for="signupEmail" class="sr-only">Email</label>
								<input type="email" id="signupEmail" class="form-control" placeholder="Email" required>
							</div>
							<div class="form-group">
								<label for="signupPass" class="sr-only">Password</label>
								<input type="password" id="signupPass" placeholder="Contrasena" class="form-control" required>
							</div>
							<div class="form-group">
								<label for="signupPass2" class="sr-only">Password</label>
								<input type="password" id="signupPass2" placeholder="Confirma tu contrasena" class="form-control" required>
							</div>
							<div class="form-group">
								
								<!--Lineas de codigo para usar el api de reCaptcha-->
								<!--<div id="captcha" class="g-recaptcha" data-sitekey="6Lfhtw8TAAAAAM_f6XwYRs9BEqANXkTLetOU-Tey"></div>-->
							</div>
							<div class="form-group">
								<div id="result"></div>
							</div>
							
							
							<div class="form-group">
							<input type="submit" value="Sign Up" Class="btn btn-default">
							</div>
						</form>
						<a class="textoblanco" href="recoverpage.php">Olvidaste tu clave?</a>
						</div>
					</div>
					<div class="col-md-4"></div>
			</div>
    </div> <!-- /container -->
    <script>
			function toggleStL(id1, id2, btnId1, btnId2) {
				var signupForm = document.getElementById(id1);
				var loginForm = document.getElementById(id2);
				var signupBtn = document.getElementById(btnId1);
				var loginBtn = document.getElementById(btnId2);
				if (signupForm.style.display === 'none') {
					signupForm.style.display = '';
					loginForm.style.display = 'none';
					signupBtn.className = "btn btn-default";
					loginBtn.className = "btn btn-primary";
				}
			}
		</script>
		<script>
			function toggleLtS(id1, id2, btnId1, btnId2) {
				var loginForm = document.getElementById(id1)
				var signupForm = document.getElementById(id2)
				var loginBtn = document.getElementById(btnId1);
				var signupBtn = document.getElementById(btnId2);
				if (loginForm.style.display === 'none') {
					loginForm.style.display = '';
					signupForm.style.display = 'none';
					loginBtn.className = "btn btn-default";
					signupBtn.className = "btn btn-primary";
				}
			}
		</script>
		<script src="js/functions.js"></script>
		<script src='https://www.google.com/recaptcha/api.js?hl=es'></script>
		
  </body>
</html>
