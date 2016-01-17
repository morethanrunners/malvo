/*global angular */
var app = angular.module("app", ["chart.js"]);

app.controller("BarCtrl", function ($scope, $http) {
  'use strict';
	$http.get('http://localhost/~erwinhenriquezviejo/malvo/php/chart_data_dist.php').then(function(response) {
		$scope.labels = ['1', '2', '3', '4', '5', '6', '7'];
  	$scope.series = ['Distancias (Km)'];
  	$scope.data = [response.data] || "Request Failed";
	});
});
	

app.controller("LineCtrl", function ($scope, $http) {
  'use strict';
  $http.get('http://localhost/~erwinhenriquezviejo/malvo/php/chart_data_time.php').then(function(response) {
		$scope.labels = ['1', '2', '3', '4', '5', '6', '7'];
  	$scope.series = ['Tiempo en minutos'];
  	$scope.data = [response.data] || "Request Failed";
	});
});

app.controller("PaceCtrl", function ($scope, $http) {
  'use strict';
  http.get('http://localhost/~erwinhenriquezviejo/malvo/php/chart_data_pace.php').then(function(response) {
		$scope.labels = ['1', '2', '3', '4', '5', '6', '7'];
  	$scope.series = ['Tiempo en '];
  	$scope.data = [response.data] || "Request Failed";
	});
});

app.controller('TabController', function () {
  'use strict';
  this.tab = 1;

  this.setTab = function (newValue) {
    this.tab = newValue;
  };

  this.isSet = function (tabName) {
    return this.tab === tabName;
  };
});