<?php
include_once("php/check_login_status.php");

if(isset($_GET["user"])){
	$user = mysqli_real_escape_string($conn, $_GET['user']);
	if($user != $log_username) {
		header("location: http://localhost/~erwinhenriquezviejo/malvo/loginpage.php");
	}
} 

else {
    header("location: http://localhost/~erwinhenriquezviejo/malvo/loginpage.php");	
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
  <link rel="stylesheet" href="assets/angular-chart.js/angular-chart.min.css">
</head>
  
<body ng-app="app" onload="logTable();getData();">
	
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
            <li><a href="landing.html">User</a></li>
            <li><a href="#">Options</a></li>
            
            <li><a href="php/logout.php" class="sign-in">Log Out</a></li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<!-- Espacio para los forms -->
  <div class="forms">
  <div class="container">
      
     <form id="form">
<!--        Row para los forms-->
        <div class="row">
          
<!--				Fecha-->
          <div class="col-md-2">
            <h4>Fecha</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-calendar"></span></span>
							<input type="text" name="fecha" id="fecha" class="form-control" placeholder="mm/dd/yy" aria-describedby="date" required>
            </div>
          
          </div>
          
<!--          Distancia-->  
          <div class="col-md-3">
            <h4>Distancia</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-road"></span></span>
							<input type="number" id="distancia" name="distancia" step="0.1" class="form-control" placeholder="in Km" aria-describedby="dist" required>
            </div>
          </div>
          
<!--          Tiempo-->
          <div class="col-md-3">
            <h4>Tiempo</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-time"></span></span>
              <input type="text" id="horas" name="horas" class="form-control" placeholder="Hrs" aria-describedby="dist">
    <span class="input-group-addon timeSpace" id="time">:</span>
    <input type="text" id="minutos" name="minutos" class="form-control" placeholder="Min" aria-describedby="dist">
              <span class="input-group-addon timeSpace" id="time">:</span>
              <input type="text" id="segundos" name="segundos" class="form-control" placeholder="Sec">
            </div>
            
          </div>

<!--          PPM-->
          <div class="col-md-2">
            <h4>PPM</h4>
            <div class="input-group"><span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-heart"></span></span>
							<input type="text" id="ppm" name="ppm" class="form-control" placeholder="BPM" aria-describedby="dist">
            </div>
          </div>
<!--          Tipo-->
          
          <div class="col-md-2">
            <h4>Entrenamiento</h4>
            <div class="input-group"><span class="input-group-addon custom-padding" id="pace"><span class="glyphicon glyphicon-flag"></span></span>
							<input type="text" id="entrenamiento" name="entrenamiento" class="form-control" placeholder="Type" aria-describedby="dist">
            </div>
          </div>
        </div>
        
<!--        Boton Submit-->
          <div class="align-center">
            <input type="submit" name="running_log" value="Submit" class="btn btn-default espacio25" onclick="newLog();logTable();">
          </div>
			 </form>
    </div>
  </div>

<!--  Espacio para la tabla y gráfica-->
  <div class="data">
<!--    Contenedor-->
    <div class="container">
      <div class="row">
        
<!--        Tabla en 6 col medianas-->
        <div class="col-md-6">
					<div id="runlog"></div>
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
              </tr>
            </thead>
            <tbody id="logtable">
              <!-- Aqui se genera la tabla con el .js y el .php-->
            </tbody>
          </table>
          
<!--          Boton para ver todo-->
          <div class="align-center">
            <button type="button" class="btn btn-default" onclick="openNewWindow()" >See All</button>
          </div>
        </div>
<!--        Espacio de gráfico en 6 col medianas-->
        <div class="col-md-6 ng-scope" ng-controller="TabController as tab">
<!--          Pills para cambiar de gráfica-->
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
	
<!--  Javascript-->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.6/angular.min.js" type="text/javascript"></script>
  <script src="js/Chart.min.js"></script>
  <script src="angular-chart.js/angular-chart.min.js"></script>
  <script src="js/app2.js"></script>
  <script src="js/functions.js"></script>
	<script src="js/runlog.js"></script>
</body>
</html>