<!DOCTYPE html>
<html>
<head>
<!--  Titulo-->
  <title>Malvo. A Training Log for runners.</title>
  <meta charset="utf-8">
<!--  Hojas de estilo-->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="angular-chart.js/angular-chart.min.css">
</head>
  
<body ng-app="app">
<!--  Jumbotron-->
  <div class="jumbotron">
    <div class="container">
<!--      Titulo principal-->
      <h1 class="lead">Malvo. <small>A Training Log for runners.</small></h1>
			</div>
  </div>
<!-- Espacio para los forms -->
  <div class="forms">
    
    <div class="container">
      
      <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<!--        Row para los forms-->
        <div class="row">
          
          <div class="col-md-2">
            <h4>Date</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-calendar"></span></span>
              <input type="text" name="fecha" class="form-control" placeholder="mm/dd/yy" aria-describedby="date" required>
            </div>
          
          </div>
          
<!--          Distancia-->  
          <div class="col-md-3">
            <h4>Distance</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-road"></span></span>
    
    <input type="number" name="distancia" step="0.1" class="form-control" placeholder="in Km" aria-describedby="dist" required>
            </div>
          </div>
          
<!--          Tiempo-->
          <div class="col-md-3">
            <h4>Time</h4>
            <div class="input-group">
              <span class="input-group-addon custom-padding"><span class="glyphicon glyphicon-time"></span></span>
              <input type="text" name="horas" class="form-control" placeholder="Hrs" aria-describedby="dist">
    <span class="input-group-addon timeSpace" id="time">:</span>
    <input type="text" name="minutos" class="form-control" placeholder="Min" aria-describedby="dist">
              <span class="input-group-addon timeSpace" id="time">:</span>
              <input type="text" name="segundos" class="form-control" placeholder="Sec">
            </div>
            
          </div>

<!--          PPM-->
          <div class="col-md-2">
            <h4>BPM</h4>
            <div class="input-group">
    <span class="input-group-addon custom-padding" id="ppm"><span class="glyphicon glyphicon-heart"></span></span>
    <input type="text" name="ppm" class="form-control" placeholder="BPM" aria-describedby="dist">
            </div>
          </div>
<!--          Tipo-->
          
          <div class="col-md-2">
            <h4>Type of Training</h4>
            <div class="input-group">
    <span class="input-group-addon custom-padding" id="pace"><span class="glyphicon glyphicon-flag"></span></span>
    <input type="text" name="entrenamiento" class="form-control" placeholder="Type" aria-describedby="dist">
            </div>
          </div>
        </div>
        
<!--        Boton Submit-->
          <div class="align-center">
            <input type="submit" name="running_log" value="Submit" class="btn btn-default espacio25">
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
            <tbody>
              <?php
include 'php/runlogtable.php';
							?>
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
			<div class="training_plan">
			<div class="plan_input">
				<h2>Training program</h2>
				<form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?> "method="post">
			Date<br>
			<input type="text" name="fecha_train" placeholder="mm/dd/yy" required><br>
			Distance<br>
			<input type="number" name="distancia_train" step="0.1" placeholder="distance in 'Km'"><br>
			Training type<br>
			<input type="text" name="tipo_train" required><br>
			Comments<br>
			<input type="text" name="coment_train" maxlength="140"><br>
			<input type="submit" name="training_program">
				</form>
			</div>
			<div class="plan">
				
			<?php
include 'php/trainplantable.php';
			?>
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
  
</body>
</html>