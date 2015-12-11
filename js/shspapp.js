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
});

app.controller("UserCtrl", function($scope, $http){

    var userModel = {};
    $scope.userModel = userModel;
    userModel.viewMode = false;
    $scope.getUsers = function() {
        userModel.viewMode = false;
        userModel.editMode = false; 
        $http.get("../php/user.php").success(function(data) {
            userModel.users = data;   
        }).error(function(data) {
            userModel.errorObj = data;
        })
        $http.get("../php/agency.php").success(function(data) {
            userModel.agencies = data;
        }).error(function(data) {
            userModel.errorObj = data;
        });
    }

    $scope.createNewUser = function() {
        userModel.showPassword = true;
        userModel.selectedUser = undefined;
        userModel.editMode = true;   
    }

    $scope.getDivisions = function(agencyId) {
         $http.get("../php/division.php", {params: {agencyId: agencyId}}).success(function(data) {
            userModel.divisions = data.length != 0 ? data: undefined;   
        }).error(function(data) {
            userModel.errorObj = data;
        })
    }

    $scope.saveUser = function() {  
        var request = {};
        request.id = userModel.selectedUser.id;
        request.firstName = userModel.selectedUser.firstName;
        request.lastName = userModel.selectedUser.lastName;
        request.email = userModel.selectedUser.email;
        request.password = userModel.selectedUser.password;
        request.role = userModel.selectedUser.role;
        request.phone = userModel.selectedUser.phone;
        request.agencyId = userModel.selectedUser.agencyId;
        request.divisionId = userModel.selectedUser.division;

        if (request.id != null) {
            $http.put("../php/user.php", request).success(function(data) {
            $scope.getUsers();
            }).error(function(data) {
            userModel.errorObj = data;
            })
        }else {
            $http.post("../php/user.php", request).success(function(data) {
            $scope.getUsers();
            }).error(function(data) {
            userModel.errorObj = data;
            })
        }
    }

    var viewUser = function(user) {
        $http.get("../php/user.php", {params: {id: user.id}}).success(function(data) {
            userModel.selectedUser = data.length != 0 ? data[0]: undefined;  
            // userModel.selectedUser.agency = data.length != 0 ? data[0].agencyId: undefined;
        }).error(function(data) {
            userModel.errorObj = data;
        })
    }

    $scope.viewUser = function(user) {   
        viewUser(user);
        userModel.viewMode = true;
    }

    $scope.editUser = function(user) {
        viewUser(user);
        userModel.editMode = true;
        userModel.viewMode = false;
        userModel.showPassword = false;
    }

    $scope.deleteUser = function() {
         $http.delete("../php/user.php", {params: {id: userModel.selectedUser.id}}).success(function(data) {
            $scope.getUsers();
        }).error(function(data) {
            userModel.errorObj = data;
        })
    }

     $scope.getUsers();

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

app.controller("ChallengeAreaCtrl", function($scope, $http){
    var challengeAreaModel = {};
    $scope.challengeAreaModel = challengeAreaModel;

    var init = function(){
        $scope.showSpecificChallengeArea = false;
        challengeAreaModel.challengeAreaName = null;
        challengeAreaModel.editMode = false;
        challengeAreaModel.editStrategy = false;
        challengeAreaModel.create = false;
        $http.get("../php/challengeArea.php").success(function(data) {
            challengeAreaModel.challengeAreas = data.length != 0 ? data: undefined;   
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
        $http.get("../php/user.php").success(function(data) {
            challengeAreaModel.leaders = data;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        });
    }

    $scope.editChallengeArea = function(challengeArea) {
        challengeAreaModel.editMode = true;
        challengeAreaModel.selectedChallengeArea = challengeArea;
        challengeAreaModel.leader1 = challengeArea.leader1_id;
        challengeAreaModel.leader2 = challengeArea.leader2_id;

    }

    $scope.cancel = function() {
        init();
    }

    $scope.createNewChallengeArea = function() {
        challengeAreaModel.create = true;
    }

    $scope.createChallengeArea = function() {
        
        $http.post("../php/challengeArea.php", {name:challengeAreaModel.challengeAreaName, leader1:challengeAreaModel.leader1,leader2:challengeAreaModel.leader2}).success(function(data) {
            init();
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })  
    }

    $scope.updateChallengeArea = function(challengeArea) {
       
       $http.put("../php/challengeArea.php", {id:challengeArea.id, name:challengeArea.name,leader1:challengeAreaModel.leader1,leader2:challengeAreaModel.leader2}).success(function(data) {
            init();
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })  
    }

    $scope.deleteChallengeArea = function(challengeArea) {
        $http.delete("../php/challengeArea.php", {params: {id:challengeArea.id}}).success(function(data) {
           init(); 
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.getUsers = function() {
        userModel.viewMode = false;
        userModel.editMode = false; 
        $http.get("../php/user.php").success(function(data) {
            userModel.users = data;   
        }).error(function(data) {
            userModel.errorObj = data;
        })
    }

    $scope.viewChallengeArea = function(challengeArea) {
        $scope.showSpecificAction = false;
        $scope.showSpecificChallengeArea = true;
        challengeAreaModel.challengeArea = challengeArea;
        challengeAreaModel.challengeAreaId = challengeArea.id;
        $scope.viewActions(challengeArea.id);
    };

    $scope.viewActions = function(challengeAreaId) {
        $http.get("../php/action.php", {params: {challengeId: challengeAreaId}}).success(function(data) {
            challengeAreaModel.strategies = data.length != 0 ? data: undefined;   
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.viewAction = function(action) {
        $scope.showSpecificAction = true;
        $scope.challengeAreaModel.action = action;
    }

    $scope.editStrategy = function(strategy) {
         challengeAreaModel.strategy = strategy;
         challengeAreaModel.editStrategy = true;
    }

    $scope.cancelEditStrategy = function() {
         challengeAreaModel.editStrategy = false;
    }

    $scope.saveStrategy = function() {
          $http.put("../php/action.php", {name: challengeAreaModel.strategy.name,
                 description:challengeAreaModel.strategy.description, challengeId: challengeAreaModel.challengeArea.id}).success(function(data) {
          
            $scope.viewActions(challengeAreaModel.challengeArea.id); 
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

     $scope.createStrategy = function() {
        $http.post("../php/action.php", {name: challengeAreaModel.newStrategy.name, description:challengeAreaModel.newStrategy.description,
           challengeId: challengeAreaModel.challengeArea.id}).success(function(data) {
            $scope.viewActions(challengeAreaModel.challengeArea.id); 
            challengeAreaModel.createStrategy = false;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.createNewStrategy = function() {
          challengeAreaModel.createStrategy = true;
    }

    $scope.cancelCreateStrategy = function() {
          challengeAreaModel.createStrategy = false;
    }

    $scope.createNewAction = function(strategy) {
        challengeAreaModel.createAction = true;
        challengeAreaModel.strategy = strategy;
    }

    // $scope.createAction = function() {
    //      $http.post("../php/action.php", {name: challengeAreaModel.newStrategy.name, description:challengeAreaModel.newStrategy.description,
    //        challengeId: challengeAreaModel.challengeArea.id}).success(function(data) {
    //         $scope.viewActions(challengeAreaModel.challengeArea.id); 
    //         challengeAreaModel.createStrategy = false;
    //     }).error(function(data) {
    //         challengeAreaModel.errorObj = data;
    //     })
    // }

    init();
})