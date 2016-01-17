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
			<div class="text-center">
				<h4 class="text-info">Nuevo registro <small><a href="#"><span class="glyphicon glyphicon-info-sign" aria-hidden="true" data-toggle="modal" data-target="#infoModal"></span></a></small></h4>
			</div>
			
<!--			Formulario de registro rapido-->
			<form id="reg-rapido" onsubmit="logTable();">
			
<!--				Doble row imput-->
				<div class="row">

<!--				Fecha-->
					<div class="form-group col-md-6 p-right-5">
						<h5>Fecha</h5>
          		<div class="input-group">
            		<span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-calendar"></span></span>
								<input type="text" name="fecha" id="fecha" class="form-control" placeholder="dd/mm/aa" aria-describedby="date">
            	</div>
        	</div>
				
<!--				Hora-->
				<div class="form-group col-md-6 p-left-5">
					<h5>Hora</h5>
          	<div class="input-group">
            	<span class="input-group-addon custom-padding"><span><i class="fa fa-clock-o"></i></span></span>
							<select name="hora" id="hora" class="form-control" aria-describedby="time">
								<option selected disabled hidden="hidden" value="">-</option>
								<option value="1">Amanecer</option>
								<option value="2">Mañana</option>
								<option value="3">Tarde</option>
								<option value="4">Noche</option>
							</select>
            </div>
        	</div>
				</div>
				
<!--				Clima-->
				<div class="form-group">
					<h5>Clima</h5>
          	<div class="input-group">
            	<span class="input-group-addon custom-padding"><span><i class="fa fa-sun-o"></i></span></span>
							<select id="clima" name="clima" class="form-control">
								<option selected disabled hidden="hidden" value="">-</option>
								<option value="1">Despejado</option>
  							<option value="2">Parcialmente Nublado</option>
  							<option value="3">Nublado</option>
  							<option value="4">Lluvia</option>
  							<option value="5">Nieve</option>
</select>
            </div>
        </div>		
				
<!--				Distancia  -->
				<div class="form-group">
					<h5>Distancia</h5>
					<div class="input-group">
						<span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-road"></span></span>
						<input type="number" id="distancia" name="distancia" step="0.1" class="form-control" placeholder="en Km" aria-describedby="dist" required>
					</div>
				</div>
				
<!--				Tiempo-->
				<div class="form-group">
					<h5>Tiempo</h5>
					<div class="input-group">
						<span class="input-group-addon custom-padding"><span><i class="fa fa-tachometer"></i></span></span>
						<input type="text" id="horas" name="horas" class="form-control" placeholder="Hrs" aria-describedby="dist">
	<span class="input-group-addon timeSpace" id="time">:</span>
	<input type="text" id="minutos" name="minutos" class="form-control" placeholder="Min" aria-describedby="dist">
						<span class="input-group-addon timeSpace" id="time">:</span>
						<input type="text" id="segundos" name="segundos" class="form-control" placeholder="Sec">
					</div>
				</div>
				
<!--				PPM-->
				<div class="form-group">
					<h5>PPM</h5>
					<div class="input-group"><span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-heart"></span></span>
						<input type="text" id="ppm" name="ppm" class="form-control" placeholder="BPM" aria-describedby="dist">
					</div>
				</div>

<!--        Tipo-->
          <div class="form-group">
            <h5>Entrenamiento</h5>
            <div class="input-group"><span class="input-group-addon custom-padding" id="pace"><span class="glyphicon glyphicon-flag"></span></span>
							<input type="text" id="entrenamiento" name="entrenamiento" class="form-control" placeholder="Type" aria-describedby="dist">
            </div>
          </div>
				
<!--				Clasificacion-->
				<div class="form-group">
					<h5>Clacificacion</h5>
          	<div class="input-group">
            	<span class="input-group-addon custom-padding"><span><i class="fa fa-star"></i></span></span>
							<select id="clasi" name="clasificacion" class="form-control">
								<option selected disabled hidden="hidden" value="">-</option>
								<option>1</option>
  							<option>2</option>
  							<option>3</option>
  							<option>4</option>
  							<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
								<option>9</option>
								<option>10</option>
</select>
            </div>
        </div>
				
<!--        Boton Submit-->
          <div class="align-center">
            <input type="submit" name="running_log" value="Agregar" class="btn btn-default" onclick="newLog();logTable();reset();">
          </div>
			 </form>
			
<!--			Espacio para repsuetsa del formulario-->
		<div id="runlog"></div>
			
<!--			/forms-->
    </div>
		
<!--		Modal de Info-->
		<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title text-center" id="myModalLabel">Como llenar un registro</h4>
      </div>
      <div class="modal-body">
        Llenar una entrada al registro es facil. Solo debes colocar la informacion de tu entrenamiento y guardar la data. Es importante que llenes tantos campos como puedas de ese modo la informacion de tus entrenamientos sera mas completa y podras aprender mas de tus entrenamientos. En la tabla podras ver los datos mas importantes. Para mas informacion puedes hacer click en <button class="btn btn-default btn-sm">Ver todos</button><br>
				<table class="table">
					<thead>
						<th></th>
						<th></th>
					</thead>
					<tbody>
						<tr>
							<td><b>Fecha:</b></td>
							<td>La fecha de tu entrenamiento.</td>
						</tr>
						<tr>
							<td><b>Hora:</b></td>
							<td>La hora del dia en la que entrenas puede afectar tu entrenamiento. Selecciona en que hora del dia entrenaste y ve cuando rindes mas.</td>
						</tr>
						<tr>
							<td><b>Clima:</b></td>
							<td>El clima es un factor determinante en el resultado de tu entrenamiento. Seleccona el clima correcto para entrenar mejor.</td>
						</tr>
						<tr>
							<td><b>Distancia:</b></td>
							<td>Cuanto recorriste. Nosotros medimos en Kilometros. Si mides en otra unidad recuerda hacer la conversion antes de hacer el registro.</td>
						</tr>
						<tr>
							<td><b>Tiempo:</b></td>
							<td>Cuanto tiempo dura tu entrenamiento. Aqui puedes registrar la duracion total de tu entrenamiento en horas, minutos y segundos <i>(Pronto una herramienta para intervalos).</i> Usaremos este tiempo para calcular tu ritmo de carrera promedio </td>
						</tr>
						<tr>
							<td><b>PPM</b></td>
							<td>Pulsaciones Por Minutos. Te ayuda a medir la intensidad de tu entrenamiento. Si no tienes una banda cardiaca recuerda tomarte el pulso justo despues de terminar de correr tan pronto como puedas.</td>
						</tr>
						<tr>
							<td><b>Entrenamiento:</b></td>
							<td>Registra que tipo de entrenamiento o carrera hiciste. Ya sea una sesion de intervalos, 'Fartleks' o un dia de recuperacion. Tus entrenamientos son diferentes y su rendimiento tambien. Tienes flexibilidad para colocar tus entrenamientos favoritos, pero recuerda ser consistente en los nombres que colocas para mejor registro.</td>
						</tr>
						<tr>
							<td><b>Clasificacion:</b></td>
							<td>Del 0 al 10. califica tu carrera para que recuerdes buenos momentos y malos tambien. con una calificacion subjetiva puedes analizar patrones y saber como entrenar y sentirte mejor.</td>
						</tr>
					</tbody>
				</table>
      </div>
      <div class="modal-footer">
        
<!--				Este boton lleva a mas informacion-->
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Mas informacion</button>
				
<!--				Este btn regresa al formulario-->
        <button type="button" class="btn btn-primary">Entendido</button>
      </div>
    </div>
  </div>
</div>
		
<!--		Modal para mensaje de borrar reistro-->
		<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='deleteModalLabel'>
			<div class='modal-dialog' role='document'>
				<div class='modal-content'>
					<div class='modal-header'>
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
						<h4 class='modal-title text-center text-success' id='deleteModalLabel'>Registro Borrado</h4>
					</div>
					<div class='modal-footer'>
						<div class='col-md-12 text-center'>
						<button type='button' class='btn btn-primary' data-dismiss='modal' onclick="logTable();">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--		/Modal-->
		
<!--		Modal para mensaje de editar registro-->
		<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						</button>
						<h4 id="edit-resp"></h4>
					</div>
					<div class='modal-footer'>
						<div class='col-md-12 text-center'>
						<button type='button' class='btn btn-primary' data-dismiss='modal' onclick="logTable();">Aceptar</button>
						</div>
					</div>
				</div>
			</div>
		</div>
<!--		/modal-->
		
<!--  Espacio para la tabla y gráfica-->
      <div class="col-md-9">
				
<!--				Botones para cambiar entre tabla y grafica-->
        <div class="botones-nav text-right">
					<button id="btn-tabla" type="button" class="btn btn-primary" onclick="toggle('tabla', 'grafica', 'btn-tabla', 'btn-grafica');">Tabla de registros</button>
					<button id="btn-grafica" type="button" class="btn btn-default" onclick="toggle('grafica', 'tabla', 'btn-grafica', 'btn-tabla');">Graficos</button>
				</div>
<!--       	Tabla-->
				<div id="tabla">
					<div class="table-toolbar">
						
<!--
						<div class="pull-right">
							<button class="btn btn-default">10</button>
						</div>
-->
						
					</div>
        	<table class="table table-hover table-striped">
            <thead>
              <tr>
								<th>Date <span class="caret"></span></th>
                <th>Distance
                  <span class="caret"></span></th>
                  
                <th>Time <span class="caret"></span></th>
                <th>Avg Pace <span class="caret"></span></th>
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
	<script>
		$(function () {
  $('[data-toggle="popover"]').popover()
})
		$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
	</script>
</html>