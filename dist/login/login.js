/**
 * Created by xiaoxiao on 2016/8/16.
 */

angular.module('xhm.login',['ng','ngRoute','ngAnimate']).controller('loginCtrl',function($scope,$http,$location,$rootScope){
  $scope.isShow = false;
  $scope.isFail = false;
  $scope.data = {};
  $scope.showTip = function(){
    if($scope.isFail == true){
      $scope.isFail = false;
    }
  };
  $scope.getVcode = function(){
    //重新获得验证码需要显示loadding
    $scope.isShow = false;
    //删除之前的验证码
    if($scope.data.url){
      $http.get("./data/delVcode.php?random="+$scope.data.random).success(function(data){
        console.log(data);
      })
    }
    $http.get('./data/getVcode.php').success(function(data){
      $scope.data = data;
      var url = $scope.data.url.substr(1);
      $scope.img = "data"+url;
      $scope.isShow = true;
    });
  };
  $scope.getVcode();
  $scope.login = function(){
    var post = {};
    post.u = $scope.u;
    post.p = $scope.p;
    post.txtSecretCode = $scope.vcode;
    post.random = $scope.data.random;
    var p = jQuery.param(post);
    console.log(p);
    $scope.waitting = true;
    $http.post("./data/chengji2.php",p).success(function(obj){
      $scope.waitting = false;
      console.log(obj);
      if(obj.status == "fail"){
        $scope.isFail = true;
        $scope.getVcode();
      }
      else {
        obj.data.shift();
        $rootScope.arrChengji = obj.data;
        $location.path("/main");
      }
    })
  };
}).config(function($routeProvider){
  $routeProvider.when('/login',{
    templateUrl:'login/login.html',
    controller:'loginCtrl'
  })
}).run(function($http){
  $http.defaults.headers.post = {'Content-type':'application/x-www-form-urlencoded'};
})