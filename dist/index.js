'use strict';
angular.module('xhm',['ng','ngRoute','ngAnimate','xhm.login','xhm.main','xhm.detail']).run(function($http){
  $http.defaults.headers.post = {'Content-type':'application/x-www-form-urlencoded'};
}).config(function($routeProvider){
  $routeProvider.otherwise({
    redirectTo:'/login'
  })
});