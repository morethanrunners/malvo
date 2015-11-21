<?php
include_once("php/check_login_status.php");

/*IMPORTANTE

aunque esta logica actualmente funciona de manera correcta creo que es una forma errada de hacerlo 

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

Con la logica anterior si el ususario cambia algo en la barra de direcciones sera llevado diractamente al dashboard de la cuenta donde esta Logeado. esto no evita problemas de seguridad si alguien cambia sus Cookies o archivos de Session

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
  
<body ng-app="app" onload="logTable();">
	
<!--    Navbar-->
	<nav class="navbar navbar-default texto">
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
						
						<!--User Dropdown-->
						<li class="dropdown">
              <a id="userdrop" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-user"></i>
                Usuario
                <span class="caret"></span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="userdrop">
                <li><a data-target="#" href="#" class="main-color"><?php echo $user?></a></li>
                <li role="separator" class="divider"></li>
                <li><a href="user.php?user=<?php echo $user?>">Perfil</a></li>
								<li><a href="user.php?user=<?php echo $user?>">Ajustes</a></li>
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

<!--Contenedor-->
	<div class="container-fluid row">

<!--Espacio para los forms -->
		<div class="col-md-3">
			
<!--			Botnes para cambiar los formularios-->
			<div class="botones-nav text-center">
				<button id="btn-reg-rapido" type="button" class="btn btn-primary" onclick="toggle('reg-rapido', 'reg-completo', 'btn-reg-rapido', 'btn-reg-completo');">Registro rapido</button>
				<button id="btn-reg-completo" type="button" class="btn btn-default" onclick="toggle('reg-completo', 'reg-rapido', 'btn-reg-completo', 'btn-reg-rapido');">Registro completo</button>
			</div>
			
<!--			Formulario de registro rapido-->
			<form id="reg-rapido">
     
<!--Fecha-->
				<div class="form-group">
					<h5>Fecha</h5>
          	<div class="input-group">
            	<span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-calendar"></span></span>
							<input type="text" name="fecha" id="fecha" class="form-control" placeholder="dd/mm/aa" aria-describedby="date" required>
            </div>
        </div>
          
<!--Distancia-->  
				<div class="form-group">
					<h5>Distancia</h5>
					<div class="input-group">
						<span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-road"></span></span>
						<input type="number" id="distancia" name="distancia" step="0.1" class="form-control" placeholder="in Km" aria-describedby="dist" required>
					</div>
				</div>
          
<!--Tiempo-->
				<div class="form-group">
					<h5>Tiempo</h5>
					<div class="input-group">
						<span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-time"></span></span>
						<input type="text" id="horas" name="horas" class="form-control" placeholder="Hrs" aria-describedby="dist">
	<span class="input-group-addon timeSpace" id="time">:</span>
	<input type="text" id="minutos" name="minutos" class="form-control" placeholder="Min" aria-describedby="dist">
						<span class="input-group-addon timeSpace" id="time">:</span>
						<input type="text" id="segundos" name="segundos" class="form-control" placeholder="Sec">
					</div>
				</div>

<!--PPM-->
				<div class="form-group">
					<h5>PPM</h5>
					<div class="input-group"><span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-heart"></span></span>
						<input type="text" id="ppm" name="ppm" class="form-control" placeholder="BPM" aria-describedby="dist">
					</div>
				</div>

<!--          Tipo-->
          
          <div class="form-group">
            <h5>Entrenamiento</h5>
            <div class="input-group"><span class="input-group-addon custom-padding" id="pace"><span class="glyphicon glyphicon-flag"></span></span>
							<input type="text" id="entrenamiento" name="entrenamiento" class="form-control" placeholder="Type" aria-describedby="dist">
            </div>
          </div>
        
<!--        Boton Submit-->
          <div class="align-center">
            <input type="submit" name="running_log" value="Agregar" class="btn btn-default espacio25" onclick="newLog();logTable();reset();">
          </div>
			 </form>
			
<!--			Formulario de registro completo-->
			<form id="reg-completo" style="display:none">
				<p>***NOTA***</p>
				<p>En esta area se colocora un registro mas completo para poner mas informacion.</p>
			</form>
			
<!--			Espacio para repsuetsa del formulario-->
		<div id="runlog"></div>
			
<!--			/forms-->
    </div>
<!--		Modal-->
		<?php
	$select = "SELECT * FROM runlog WHERE user_id='".$log_id."' ORDER BY run_date DESC, run_id DESC LIMIT 7";
$query_select = mysqli_query($conn, $select);

  //cuenta el numero de rows
$num_rows = mysqli_num_rows($query_select);
	
//si existen rows
if ($num_rows > 0){
	while ($row = mysqli_fetch_assoc($query_select)){
    
		//transforma las variables tiempo y ritmo a minutos y segundos 
		$run_id = $row["run_id"];
	}
}
	?>
		<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'><div class='modal-header'>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						<span aria-hidden='true'>&times;</span></button>
							<h4 class='modal-title text-center text-success' id='myModalLabel".$run_id."'>Registro Borrado</h4>
				</div>
				<div class='modal-footer'>
					<div class='col-md-12 text-center'>
						<button type='button' class='btn btn-default' data-dismiss='modal'>Aceptar</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!--		/Modal-->
<!--  Espacio para la tabla y gráfica-->
      <div class="col-md-9">
				
<!--				Botones para cambiar entre tabla y grafica-->
        <div class="botones-nav text-right">
					<button id="btn-tabla" type="button" class="btn btn-primary" onclick="toggle('tabla', 'grafica', 'btn-tabla', 'btn-grafica');">Tabla de registros</button>
					<button id="btn-grafica" type="button" class="btn btn-default" onclick="toggle('grafica', 'tabla', 'btn-grafica', 'btn-tabla');">Graficos</button>
				</div>
<!--       	Tabla-->
				<div id="tabla">
        	<table class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
                <th>Distance
                  <span class="caret"></span></th>
                  
                <th>Time <span class="caret"></span></th>
                <th>Pace <span class="caret"></span></th>
                <th>BPM <span class="caret"></span></th>
                <th>Type <span class="caret"></span></th>
								<th></th>
              </tr>
            </thead>
            <tbody id="logtable">
              <!-- Aqui se genera la tabla con el .js y el .php-->
            </tbody>
          </table> 
<!--        Boton para ver todo-->
          <div id="test" class="align-center">
            <button type="button" class="btn btn-default" onclick="openNewWindow()" >Ver todos</button>
          </div>
        </div>
				
<!--        Grafico-->
				<div id="grafica" style="display:none">
        <div class="ng-scope" ng-controller="TabController as tab">
<!--        Pills para cambiar de gráfica-->
            <ul class="nav nav-pills">
              <li ng-class="{ active:tab.isSet(1)}"><a href ng-click=tab.setTab(1)>Distance</a></li>
              <li ng-class="{ active:tab.isSet(2)}"><a href ng-click=tab.setTab(2)>Time</a></li>
              <li ng-class="{ active:tab.isSet(3)}"><a href ng-click=tab.setTab(3)>Pace</a></li>
            </ul>
<!--          Este es el gráfico-->
          <div ng-controller="BarCtrl" ng-show="tab.isSet(1)">
            <canvas id="line" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-legend="true" chart-series="series" chart-click="onClick">
            </canvas>
          </div>
          <div ng-controller="LineCtrl" ng-show="tab.isSet(2)">
            <canvas id="line" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-legend="true" chart-series="series" chart-click="onClick">
            </canvas>
          </div>
          <div ng-controller="PaceCtrl" ng-show="tab.isSet(3)">
            <canvas id="line" class="chart chart-bar" chart-data="data" chart-labels="labels" chart-legend="true" chart-series="series" chart-click="onClick">
            </canvas>
          </div>
          
          </div>
        </div>
      </div>
		</div>
    
</body>
	<!--  Javascript-->
	<!--Standar .js files-->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js"></script>
  <script src="js/Chart.min.js"></script>
  <script src="angular-chart.js/angular-chart.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	

	<!--Personal .js files-->
  <script src="js/app2.js"></script>
  <script src="js/functions.js"></script>
</html>