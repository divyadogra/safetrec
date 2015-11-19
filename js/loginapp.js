app = angular.module('loginapp', []);
app.controller("LoginCtrl",function($scope,$http, $window){

    var loginObj = [];
    $scope.error = false;
    $scope.loginObj = loginObj;
	
    $scope.login = function() {
    	
    	$http({
    		url:'../php/login.php',
    		method: 'POST',
    		data: {email: loginObj.email, password: loginObj.password},
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    		
    	}).success(function(results){
            // console.log(results);
    		$window.location.href = "template/loginsuccess.php";
        }).error(function(results){
            $scope.error = true;
        });
    }
});