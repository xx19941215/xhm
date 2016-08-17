/**
 * Created by xiaoxiao on 2016/8/16.
 */
angular.module('xhm.main',['ng','ngRoute','ngAnimate']).controller('mainCtrl',function($scope,$rootScope,$location){
  if(!$rootScope.arrChengji){
    $location.path("/login");
  }
}).config(function($routeProvider){
  $routeProvider.when('/main',{
    templateUrl:'main/main.html',
    controller:'mainCtrl'
  })
})
