app = angular.module('loginapp', []);
app.controller("LoginCtrl",function($scope,$http, $window){

    var loginObj = [];
    $scope.error = false;
    $scope.loginObj = loginObj;
	
    $scope.login = function() {

        request = {email: loginObj.email,
                    password: loginObj.password}

        $http.post("../php/doLogin.php", request).success(function(data) {
                $window.location.href = "loginsuccess.php";
            }).error(function(data) {
                $scope.error = true;
            })
    	
    	/*$http({
    		url:'../php/doLogin.php',
    		method: 'POST',
    		data: {email: loginObj.email, password: loginObj.password},
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    		
    	}).success(function(results){
            // console.log(results);
    		$window.location.href = "template/loginsuccess.php";
        }).error(function(results){
            $scope.error = true;
        });*/
    }
});