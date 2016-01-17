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
//seccion para hacer las variables que se usaran luego

$sql = "SELECT * FROM users WHERE username='".$user."'";
$query = mysqli_query($conn, $sql);
$num_row = mysqli_num_rows($query);
if ($num_row > 0){
	while ($row = mysqli_fetch_assoc($query)){
		$user_id = $row['user_id'];
	}
}
else {
	echo "ERROR";
}

//Mayor distancia
$sql = "SELECT MAX(distance) FROM runlog WHERE user_id='".$user_id."'";
$query = mysqli_query($conn, $sql);
$num_row = mysqli_num_rows($query);
if ($num_row > 0){
	while ($row = mysqli_fetch_assoc($query)){
		$distancia = $row["MAX(distance)"] / 1000;
	}
}

//Mejor ritmo
$sql = "SELECT MIN(pace) FROM runlog WHERE user_id='".$user_id."'";
$query = mysqli_query($conn, $sql);
$num_row = mysqli_num_rows($query);
if ($num_row > 0){
	while ($row = mysqli_fetch_assoc($query)){
		$ritmo = $row["MIN(pace)"];
		$ritmosegundos = $ritmo % 60;
		$ritmominutos = ($ritmo / 60) % 60;
		$ritmohoras = floor(($ritmo / 60) / 60);
			if ($ritmosegundos < 10) {
				$ritmosegundos = sprintf('%02d', $ritmosegundos);
			}
			if ($ritmominutos < 10) {
				$ritmominutos = sprintf('%02d', $ritmominutos);
			}
		
	}
}
else {
	echo "ERROR";
}

//Mayor tiempo
$sql = "SELECT MAX(time) FROM runlog WHERE user_id='".$user_id."'";
$query = mysqli_query($conn, $sql);
$num_row = mysqli_num_rows($query);
if ($num_row > 0){
	while ($row = mysqli_fetch_assoc($query)){
		$tiempo = $row["MAX(time)"];
		$segundos = $tiempo % 60;
		$minutos = ($tiempo / 60) % 60;
		$horas = floor(($tiempo / 60) / 60);
			if ($segundos < 10) {
				$segundos = sprintf('%02d', $segundos);
			}
			if ($minutos < 10) {
				$minutos = sprintf('%02d', $minutos);
			}
	}
}
else {
	echo "ERROR";
}
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
			
<!--			Panel lateral de color-->
			<div class="col-md-4 color-panel">
				
<!--				Espacio para la parte de la foto y nombre de usuario-->
					<div class="espacio25 text-center">
						<img src="assets/css/img/nature2.jpeg" class="img-circle user-img">
						<h1 class="textoblanco"><?php echo $user?></h1>
						
<!--						este btn es para cambiarlo por un link para ir a la pagina de SETTINGS donde se ajustan las preferencias del usuario.-->
						<a disabled id="change-btn" href="#" class="btn btn-default" onclick="toggleDisable();"><i class="fa fa-cog"></i></a>
<!--						//btn-->
						<div id="social-links" class="text-center espacio25 bg-danger">
							<div id="social-head" class="p-top-10">
								<h4>Conectar</h4>
							</div>
							
<!--							Los Btn se cambiaran por imagenes de las diferentes redes sociales para que sea mas facil y elegante a la vista
									La funcion de esto es que se pueda compartir la actividad realizad o guardada en redes sociales igualmente culaquier parte del analisis de entrenamiento-->
							<div id="social-links" class="text-center padding15">
								<span id="f-btn" class="espacio10"><i class="fa fa-facebook-square fa-2x"></i></span>
								<span id="tw-btn" class="espacio10"><i class="fa fa-twitter-square fa-2x"></i></span>
								<span id="wp-btn" class="espacio10"><i class="fa fa-wordpress fa-2x"></i></span>
								<span id="tb-btn" class="espacio10"><i class="fa fa-tumblr-square fa-2x"></i></span>
							</div>

							</div>
					</div>
				
			</div>
			
<!--			Area central donde se muestran las opciones-->
			<div class="col-md-8">
					<div id="records" class="row">
						<div class="section-head">
							<p>Records</p>
						</div>
						<div class="col-md-6">
							<ul class="list-default">
								<li>Mayor distancia: <?php echo $distancia;?> Km</li>
								<li>Mayor tiempo: <?php echo "$horas:$minutos:$segundos";?></li>
								<li>Mejor ritmo: <?php echo "$ritmominutos:$ritmosegundos";?>/km</li>
							</ul>
						</div>
						<div class="col-md-6">
							<button class="btn btn-primary">+track</button>
							<div class="dash-border">
								<ul>
									<li>Agregar tu propio record para seguir</li>
								</ul>
							</div>
						</div>
					</div>
					<div id="progreso" class="row">
						<div class="section-head">
							<p>Progreso</p>
						</div>
						<div class="col-md-6">
							<ul class="list-default">
								<li>Progreso 1</li>
								<li>Progreso 2</li>
								<li>Progreso 3</li>
							</ul>
						</div>
						<div class="col-md-6">
							<button class="btn btn-primary">+track</button>
							<div class="dash-border">
								<ul>
									<li>Agregar tu propio progreso para seguir</li>
								</ul>
						</div>
					</div>
				</div>				
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