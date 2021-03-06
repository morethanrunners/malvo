<?php
include_once("php/check_login_status.php");

//si el usuario ya esta logiado no tiene nada que hacer en esta pagina
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
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>RunLg Forgot Password</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom CSS-->
		<link href="assets/css/style.css" rel="stylesheet">
	</head>

  <body>

    <div class="container">
			<div id="navbar" class="navbar">
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
								<li><a href="landing.html">Home</a></li>
								<li><a href="#">Blog</a></li>
								<li><a href="loginpage.php" class="sign-in">Sign in</a></li>

							</ul>
						</div><!--/.nav-collapse -->
					</div>
				</nav>
			</div>
			<row>
				<div class="col-md-3"></div>
				<div class="col-md-6 text-center colorfull">
					<h3>Recuperar contrasena</h3>
					<p>Para recuperar tu contrasena deveras ingresar todos los datos asociados a tu usauario</p>
					<form id="recoverPassForm" action="" method="post" onsubmit="recoverPass(); return false">
						
						<div class="form-group">
							<label for="recoverName" class="sr-only">Nombre</label>
							<input type="text" id="recoverName" class="form-control" placeholder="Nombre" required>
						</div>
						<div class="form-group">
							<label for="recoverLastName" class="sr-only">Apellido</label>
							<input type="text" id="recoverLastName" class="form-control" placeholder="Apellido" required>
						</div>
						<div class="form-group">
							<label for="recoverUser" class="sr-only">Usuario</label>
							<input type="text" id="recoverUser" class="form-control" placeholder="Usuario" required>
						</div>
						<div class="form-group">
							<label for="recoverEmail" class="sr-only">Email</label>
							<input type="email" id="recoverEmail" class="form-control" placeholder="Email" required>
						</div>
						<div class="form-group">
							<label for="recoverEmail2" class="sr-only">Confirmar email</label>
							<input type="email" id="recoverEmail2" class="form-control" placeholder="Confirma tu email" required>
						</div>
						<div class="form-group">
							<div id="login"></div>
							<div id="test"></div>
						</div>
						<div class="form-group">
							<input type="submit" value="Log In" class="btn btn-default">
						</div>
					</form>
				</div>
				<div class="col-md-3"></div>
			</row>
      

    </div> <!-- /container -->
		<script src="js/functions.js"></script>
  </body>
</html>
