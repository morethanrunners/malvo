<?php
include_once("php/check_login_status.php");

/*IMPORTANTE

Aunque esta logica actualmente funciona de manera correcta creo que es una forma errada de hacerlo 

Estar pendiente para coregir cuando se pueda

*/

if(isset($_GET["user"])){
	$user = mysqli_real_escape_string($conn, $_GET['user']);
	if($user != $log_username) {
		header("location: http://localhost/~erwinhenriquezviejo/malvo/loginpage.php");
	}
} 

else {
    header("location: http://localhost/~erwinhenriquezviejo/malvo/loginpage.php");	
}
/*
IMPORTANTE

Con la logica anterior si el ususario cambi algo en la barra de direcciones sera llevado diractamente al dashboard de la cuenta donde esta Logeado. sto no evita problemas de seguridad si alguien cambia sus Cookies o archivos de Session

*/
?>
<!DOCTYPE html>
<html>
<head>
<!--  Titulo-->
  <title>Malvo. A Training Log for runners.</title>
  <meta charset="utf-8">
<!--  Hojas de estilo-->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="angular-chart.js/angular-chart.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.css">
</head>
<body>
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
				<a class="navbar-brand" href="userlog.php">RunLg | <small>A training log for runners.</small>
				</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					
					<!--User Dropdown-->
					<li class="dropdown">
						<a id="userdrop" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user"></i>
							Usuario
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" aria-labelledby="userdrop">
							<li><a href="userlog.php" class="main-color"><?php echo $user?></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="#">Perfil</a></li>
							<li><a href="#">Ajustes</a></li>
						</ul>
					</li>
					<!--/user dropdown-->
					
					<!--Log Dropdown-->
					<li class="dropdown">
						<a id="logdrop" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-bar-chart"></i>
							Registro
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" aria-labelledby="logdrop">
							<li><a href="#">Mis registros</a></li>
							<li><a href="#">Entrnamientos</a></li>
							<li><a href="#">Progreso/Analisis</a></li>
						</ul>
					</li>
					<!--/log Dropdown-->
					
					<!--Log Out Button-->
					<li><a href="php/logout.php" class="sign-in">Log Out</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>
	
	<!--Container fluido para el area de toda la pagina por debajo del navbar-->
	<div class="container-fluid">
		
		<!--Espacio exactamente del tamano del NavBar para que los elemnetos no se oloque detras de el-->
		<div class="back-head"></div>
		<div class="row">
			
			<!--Panel lateral de color-->
			<div class="col-md-2 color-panel">
			</div>
			
			<!--Area central donde se muestran las opciones-->
			<div class="col-md-10">
				<div class="row user-area">
					
					<!--Espacio para la parte de la foto y nombre de usuario-->
					<div class="col-md-4 text-center">
						<img src="assets/css/img/nature2.jpeg" class="img-circle user-img">
						<h1><?php echo $user?></h1>
						<a id="change-btn" href="#" class="btn btn-default" onclick="toggleDisable();">Editar</a>
					</div>
					
					<!--Espacio para el formulario para editar los datos peronales-->
					<div class="col-md-8">
						<form id="user-form">
							<fieldset id="test" disabled>
								<!--El form esta dividido en dos columnas-->
								<div class="row">

									<!--Columna 1-->
									<div class="col-md-6">
										<div class="form-group">
											<p>Sexo</p>
											<select class="form-control" name="sex">
												<option value="M">Masculino</option>
												<option value="F">Femenino</option>
											</select>
										</div>
										<div class="form-group">
											<p>Estatura</p>
											<input class="form-control" type="number" step="1" placeholder="cm">
										</div>
										<div class="form-group">
											<p>PPM en descanzo</p>
											<input class="form-control" type="number" step="1" min="50" max="220" placeholder="PPM">
										</div>
										<div class="form-group">
											<p>Imgen de perfil</p>
											<!--Botton para cambiar el archivo de imagen-->
											<a class="btn btn-primary" onclick="#">Imagen</a>
										</div>
									</div>

									<!--Columna 2-->
									<div class="col-md-6">
										<div class="form-group">
											<p>Fecha de nacimiento</p>
											<input class="form-control" type="text" placeholder="dd/mm/aaaa">
											<!--
												IMPORTANTE

												Esta no es la forma mas elegante de manejar el tema de la fecha pero sin duda es una rapida y facil
											-->

										</div>
										<div class="form-group">
											<p>Peso</p>
											<input class="form-control" type="number" step="0.5" placeholder="Kg">
										</div>
										<div class="form-group">
											<p>Max PPM</p>
											<input class="form-control" type="number" placeholder="PPM" step="1">
											<input type="checkbox" onchange=""> Autocalcular <a href="#">?</a> 
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				
				<!--
				Div para el area de las settings lo dejo comentado porque todavia no he disenado la esctructura que tendra
				-->
				<!--<div class="row user-area"></div>-->
				
			</div>
		</div>
	</div>
</body>
<!--  Javascript-->
<!--Standar .js files-->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>

<!--Personal .js files-->
  <script src="js/functions.js"></script>
	<script>
		function toggleDisable() {
			var dataset = document.getElementById("test");
			var btn = document.getElementById("change-btn");
			if (dataset.disabled == true) {
				dataset.disabled = false;
				btn.className = "btn btn-danger";
			}
			else {
				dataset.disabled = true;
				btn.className = "btn btn-default";
			}
		}
	</script>
	
</html>