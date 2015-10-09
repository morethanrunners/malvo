/*global angular */
var app = angular.module("app", ["chart.js"]);

app.controller("BarCtrl", function ($scope) {
  'use strict';
  $scope.labels = ['1', '2', '3', '4', '5', '6', '7'];
  $scope.series = ['Race distances (Km)'];
	
  $scope.data = [
    [8, 10, 3, 0, 10]
    
  ];
});

app.controller("LineCtrl", function ($scope) {
  'use strict';
  $scope.labels = ['1', '2', '3', '4', '5', '6', '7'];
  $scope.series = ['Race times'];
  $scope.data = [
    [45, 34, 58, 75, 99, 23, 65]
  ];
});

app.controller("PaceCtrl", function ($scope) {
  'use strict';
  $scope.labels = ['1', '2', '3', '4', '5', '6', '7'];
  $scope.series = ['Race paces'];
  $scope.data = [
    [6, 6, 8, 4, 5, 7.5, 6.2]
  ];
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