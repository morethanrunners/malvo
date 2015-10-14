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
    <link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- Custom CSS-->
		<link href="css/style.css" rel="stylesheet">
	</head>

  <body>

    <div class="container">
			<row>
				<div class="col-12 text-center header">
					<h2>RunLg<br><small>Empieza a llevar rigistro de tus entrenamientos</small></h2>
				</div>
			</row>
			<row>
				<div class="col-md-3"></div>
				<div class="col-md-6 text-center colorfull">
					<h3>Recuperar contrasena</h3>
					<p>Para modificar tu contrasena ingresa tu nueva contrasena en el formulario</p>
					<form id="changePassForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
						<div class="form-group">
							<label for="newPass" class="sr-only">Contrasena</label>
							<input type="password" id="newPass" name="newPass" class="form-control" placeholder="Nueva contrasena" required>
						</div>
						<div class="form-group">
							<label for="newPass2" class="sr-only">Confirma tu contrasena</label>
							<input type="password" id="newPass2" name="newPass2" class="form-control" placeholder="Confirma tu contrasena" required>
						</div>
						<div class="form-group">
						<input type="submit" value="Sign Up" Class="btn btn-default">
						</div>
					</form>
				</div>
				<div class="col-md-3"></div>
			</row>
      

    </div> <!-- /container -->
		<script src="js/login.js"></script>
  </body>
</html>
<?php
$user_id = $_GET['user_id'];
if (empty($user_id)) {
	$error = "no se envio nada";
	exit;
}
else {
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$pass1 = $_POST['newPass'];
	$pass2 = $_POST['newPass2'];
	echo $pass1;
	echo $pass2;
	echo $user_id;
}
}
?>