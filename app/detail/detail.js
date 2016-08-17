/**
 * Created by xiaoxiao on 2016/8/16.
 */
angular.module('xhm.detail',['ng','ngRoute','ngAnimate']).controller('detailCtrl',function($scope,$rootScope,$routeParams){
  $scope.detailArr = $rootScope.arrChengji[$routeParams['index']-1];
  console.log($scope.detailArr);
}).config(function($routeProvider){
  $routeProvider.when('/detail/:index',{
    templateUrl:'detail/detail.html',
    controller:'detailCtrl'
  })
})
