app = angular.module('shspApp', []);
app.controller("MainCtrl",function($scope,$http, $window){

    var user = {};
    var model = {};
    $scope.model = model;
    $scope.user = user;
    $scope.userCreated = false;
	
    $scope.listDocuments = function() {
        var myURL = 'php/list.php';
        $http.get(myURL).success(function (results) {
        $scope.files = results.item_collection.entries;
        });
    }

    $scope.logout = function() {
    	$window.location.href = "login.php";
    }

    $scope.getUsers = function() { 
        $http.post("php/viewUsers.php").success(function(data) {
            $scope.users = data;   
        }).error(function(data) {
            model.errorObj = data;
        })
    }

    $scope.createUser = function() {
        if ($scope.form1.$invalid) {
            return;
        }
        user.userId = null;
        var request = {};
        request.firstName = user.firstName;
        request.lastName = user.lastName;
        request.email = user.email;
        request.password = user.password;
        request.role = user.role;
        
        $http.post("php/createUser.php", request).success(function(data) {
            $scope.userCreated = true;
            resetUser();
        }).error(function(data) {
            model.errorObj = data;
        })
    }

    $scope.viewUser = function(suser) {
        var request = {};
        request.userId = suser.userId;
        
        $http.post("php/viewUser.php", request).success(function(data) {
            $scope.viewUser = data;
            $scope.users = null;
        }).error(function(data) {
            model.errorObj = data;
        })
    }

    var toggleView = function(){
        if (toggleView == false) {
            toggleView = true;
        } else {
            toggleView = false;
        }
    }

    var resetUser = function () {
        var userId = user.userId;
        user = {};
        $scope.user = user;
        user.userId = userId;
    }
});