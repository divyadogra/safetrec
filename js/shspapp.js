app = angular.module('shspApp', []);
app.controller("MainCtrl",function($scope,$http, $window){

    var user = {};
    var model = {};
    $scope.model = model;
    $scope.user = user;
    $scope.userCreated = false;
	
    $scope.listDocuments = function() {
        var myURL = '../php/list.php';
        $http.get(myURL).success(function (results) {
        $scope.files = results.item_collection.entries;
        });
    }

    $scope.logout = function() {
    	$window.location.href = "login.php";
    }

    $scope.getUsers = function() { 
        $http.post("../php/viewUsers.php").success(function(data) {
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
        
        $http.post("../php/createUser.php", request).success(function(data) {
            $scope.userCreated = true;
            resetUser();
        }).error(function(data) {
            model.errorObj = data;
        })
    }

    $scope.viewUser = function(suser) {
        var request = {};
        request.userId = suser.userId;
        
        $http.post("../php/viewUser.php", request).success(function(data) {
            $scope.viewUser = data.length != 0 ? data: undefined;
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

app.controller("AgencyCtrl", function($scope, $http){
    var agencyModel = {};
    $scope.agencyModel = agencyModel;

    var init = function(){
        agencyModel.agencyName = null;
        agencyModel.agencyDescription = undefined;
        agencyModel.editMode = false;
        agencyModel.create = false;
        $http.get("../php/agency.php").success(function(data) {
            agencyModel.agencies = data.length != 0 ? data: undefined;   
        }).error(function(data) {
            agencyModel.errorObj = data;
        })
    }

    $scope.editAgency = function(agency) {
        agencyModel.editMode = true;
        agencyModel.selectedAgency = agency.id;
    }

    $scope.cancel = function() {
        init();
    }

    $scope.createNewAgency = function() {
        agencyModel.create = true;
    }

    $scope.createAgency = function() {
        $http.post("../php/agency.php", {name:agencyModel.agencyName, description:agencyModel.agencyDescription}).success(function(data) {
            init();
        }).error(function(data) {
            agencyModel.errorObj = data;
        })  
    }

    $scope.updateAgency = function(agency) {
       $http.put("../php/agency.php", {id:agency.id, name:agency.name, description:agency.description}).success(function(data) {
            init();
        }).error(function(data) {
            agencyModel.errorObj = data;
        })  
    }

    $scope.deleteAgency = function(agency) {
        $http.delete("../php/agency.php", {params: {id:agency.id}}).success(function(data) {
           init(); 
        }).error(function(data) {
            agencyModel.errorObj = data;
        })
    }

    init();
})

app.controller("DivisionCtrl", function($scope, $http){
    var divisionModel = {};
    $scope.divisionModel = divisionModel;

    var init = function(){
        $http.get("../php/agency.php").success(function(data) {
            divisionModel.agencies = data;
        }).error(function(data) {
            divisionModel.errorObj = data;
        })
    }

    var setDefaults = function() {
        divisionModel.divisionName = null;
        divisionModel.divisionDescription = undefined;
        divisionModel.editMode = false;
        divisionModel.create = false;
    }

    $scope.getDivisions = function(agencyId) {
        setDefaults();
        $http.get("../php/division.php", {params: {agencyId: agencyId}}).success(function(data) {
            divisionModel.divisions = data.length != 0 ? data: undefined;   
        }).error(function(data) {
            divisionModel.errorObj = data;
        })
    }

    $scope.editDivision = function(division) {
        divisionModel.editMode = true;
        divisionModel.selectedDivision = division.id;
    }

    $scope.cancel = function() {
        setDefaults();
    }

    $scope.createNewDivision = function() {
        divisionModel.create = true;
    }

    $scope.createDivision = function() {
        $http.post("../php/division.php", {name:divisionModel.divisionName, description:divisionModel.divisionDescription, agencyId: divisionModel.agency}).success(function(data) {
            $scope.getDivisions(divisionModel.agency);
        }).error(function(data) {
            divisionModel.errorObj = data;
        })  
    }

    $scope.updateDivision = function(division) {
       $http.put("../php/division.php", {id:division.id, name:division.name, description:division.description}).success(function(data) {
            $scope.getDivisions(divisionModel.agency);
        }).error(function(data) {
            divisionModel.errorObj = data;
        })  
    }

    $scope.deleteDivision = function(division) {
        $http.delete("../php/division.php", {params: {id:division.id}}).success(function(data) {
           $scope.getDivisions(divisionModel.agency);
        }).error(function(data) {
            divisionModel.errorObj = data;
        })
    }

    init();
})