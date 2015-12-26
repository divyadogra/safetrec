var underscore = angular.module('underscore', []);
underscore.factory('_', ['$window', function($window) {
  return $window._; // assumes underscore has already been loaded on the page
}]);

app = angular.module('shspApp', ['underscore']);
// app.config(['$routeProvider',
//   function($routeProvider) {
//     $routeProvider.
//       when('/', {
//         templateUrl: '../template/login.php',
//         controller: 'PhoneListCtrl'
//       }).
//       otherwise({
//         redirectTo: '../template/loginsuccess.php'
//       });
//   }]);
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
        var myURL = '../php/logout.php';
        $http.get(myURL).then(function (data) {
           $window.location.href = "login.php"; 
        });
    	
    }

    $scope.isUserLoggedIn = function() {
        var myURL = '../php/validate.php';
        $http.get(myURL).success(function (data) {
            $scope.loggedInUser = data;
        }).error(function(data) {
            if (data == 'Invalid Login') {
                $window.location.href = "login.php";
            }
            
        });
    }

    $scope.isAdmin = function() {
        return $scope.loggedInUser.role == 'Admin';
    }

    $scope.isUserLoggedIn();
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

app.controller("ChallengeAreaCtrl", function($scope, $http, _, $window){
    var challengeAreaModel = {};
    $scope.challengeAreaModel = challengeAreaModel;

    var init = function(){
        $scope.showSpecificChallengeArea = false;
        $scope.showSpecificAction = false;
        challengeAreaModel.challengeAreaName = null;
        challengeAreaModel.editMode = false;
        challengeAreaModel.editStrategy = false;
        challengeAreaModel.editAction = false;
        challengeAreaModel.create = false;
        challengeAreaModel.createActionComment = false;
        challengeAreaModel.createNewOutput = false;
        challengeAreaModel.createNewOutcome = false;
        challengeAreaModel.createNewOutputComment = false;
        challengeAreaModel.createNewOutcomeComment = false;
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
        $http.get("../php/agency.php").success(function(data) {
            challengeAreaModel.agencies = data;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        });
    }

    $scope.isChallengeAreaLead = function (){
        if (challengeAreaModel.challengeArea.leader1_id == $scope.loggedInUser.id
                || challengeAreaModel.challengeArea.leader2_id == $scope.loggedInUser.id) {
            return true;
        }
    }

    $scope.getDivisions = function(agencyId) {
         $http.get("../php/division.php", {params: {agencyId: agencyId}}).success(function(data) {
            challengeAreaModel.divisions = data.length != 0 ? data: undefined;   
        }).error(function(data) {
            userModel.errorObj = data;
        })
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
            challengeAreaModel.challengeArea = _.findWhere(challengeAreaModel.challengeAreas, {id:challengeAreaId});
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.viewAction = function(action, strategy) {
        $scope.showSpecificAction = true;
        $scope.challengeAreaModel.action = action;
        $scope.challengeAreaModel.selectedStrategy = strategy;
        // $scope.challengeAreaModel.action.startDate = new Date(action.startDate);
        // $scope.challengeAreaModel.action.endDate = new Date(action.endDate);
        $http.get("../php/actionOutput.php",{params: {actionId: challengeAreaModel.action.id}}).success(function(data) {
            challengeAreaModel.actionOutputs = data;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        });$http.get("../php/actionOutcome.php",{params: {actionId: challengeAreaModel.action.id}}).success(function(data) {
            challengeAreaModel.actionOutcomes = data;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        });
        $http.get("../php/actionComment.php",{params: {actionId: challengeAreaModel.action.id}}).success(function(data) {
            challengeAreaModel.actionComments = data;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        });
    }

    $scope.editStrategy = function(strategy) {
         challengeAreaModel.strategy = strategy;
         challengeAreaModel.editStrategy = true;
    }

    $scope.cancelEditStrategy = function() {
         challengeAreaModel.editStrategy = false;
    }

    $scope.saveStrategy = function() {
          $http.put("../php/strategy.php", {name: challengeAreaModel.strategy.name,
                 description:challengeAreaModel.strategy.description, id: challengeAreaModel.strategy.id}).success(function(data) {
          
            $scope.viewActions(challengeAreaModel.challengeArea.id); 
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

     $scope.createStrategy = function() {
        $http.post("../php/strategy.php", {name: challengeAreaModel.newStrategy.name, description:challengeAreaModel.newStrategy.description,
           challengeId: challengeAreaModel.challengeArea.id}).success(function(data) {
            $scope.viewActions(challengeAreaModel.challengeArea.id); 
            challengeAreaModel.createStrategy = false;
            challengeAreaModel.newStrategy = "";
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.createNewStrategy = function() {
          challengeAreaModel.createStrategy = true;
    }

    $scope.cancelCreateStrategy = function() {
          challengeAreaModel.createStrategy = false;
          challengeAreaModel.newStrategy = "";
    }

    $scope.createAction = function(strategy) {
        challengeAreaModel.createAction = true;
        challengeAreaModel.strategy = strategy;
    }

    $scope.editAction = function() {
        challengeAreaModel.editAction = true;
        challengeAreaModel.action.startDate = new Date(challengeAreaModel.action.startDate);
        challengeAreaModel.action.endDate = new Date(challengeAreaModel.action.endDate);
    }

    $scope.createNewAction = function() {

        request = {strategyId: challengeAreaModel.strategy.id,
                    description: challengeAreaModel.newAction.description, 
                    status: challengeAreaModel.newAction.status,
                    leadId: challengeAreaModel.newAction.actionLead,
                    agencyId: challengeAreaModel.newAction.agency,
                    divisionId: challengeAreaModel.newAction.division,
                    startDate: challengeAreaModel.newAction.startDate,
                    endDate: challengeAreaModel.newAction.endDate,
                    timing: challengeAreaModel.newAction.timing,
                    dataInfoProbId: challengeAreaModel.newAction.dataInfoProbId,
                    provenCountermeasure: challengeAreaModel.newAction.provenCountermeasure,
                    planEval: challengeAreaModel.newAction.planEval,
                    resources: challengeAreaModel.newAction.resources,
                    scopeReach: challengeAreaModel.newAction.scopeReach,
                    legislative: challengeAreaModel.newAction.legislative
                    }
         $http.post("../php/action.php", request).success(function(data) {
            $scope.viewActions(challengeAreaModel.challengeArea.id); 
            challengeAreaModel.createAction = false;
            challengeAreaModel.newAction = {};
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.cancelNewAction = function() {
        challengeAreaModel.createAction = false;
    }

    $scope.cancelEditAction = function() {
         challengeAreaModel.editAction = false;
    }

    $scope.saveStatus = function() {
        $scope.editAndSaveAction();
        alert("Status changed");
    }

    $scope.editAndSaveAction = function() {

        request = { id: challengeAreaModel.action.id,
                    strategyId: challengeAreaModel.selectedStrategy.id,
                    description: challengeAreaModel.action.description, 
                    status: challengeAreaModel.action.status,
                    leadId: challengeAreaModel.action.leadId,
                    agencyId: challengeAreaModel.action.agencyId,
                    divisionId: challengeAreaModel.action.divisionId,
                    startDate: challengeAreaModel.action.startDate,
                    endDate: challengeAreaModel.action.endDate,
                    timing: challengeAreaModel.action.timing,
                    dataInfoProbId: challengeAreaModel.action.dataInfoProbId,
                    provenCountermeasure: challengeAreaModel.action.provenCountermeasure,
                    planEval: challengeAreaModel.action.planEval,
                    resources: challengeAreaModel.action.resources,
                    scopeReach: challengeAreaModel.action.scopeReach,
                    legislative: challengeAreaModel.action.legislative
                    }
         $http.put("../php/action.php", request).success(function(data) {
            $scope.viewActions(challengeAreaModel.challengeArea.id); 
            challengeAreaModel.editAction = false;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.deleteAction= function() {
        $http.delete("../php/action.php", {params: {id:challengeAreaModel.action.id}}).success(function(data) {
            $scope.viewActions(challengeAreaModel.challengeArea.id);
            challengeAreaModel.editAction = false;
            $scope.showSpecificAction = false;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        });
    }

    $scope.createActionComment = function() {
        challengeAreaModel.createActionComment = true;
    };


     $scope.createComment = function() {

        $http.post("../php/actionComment.php", {author: $scope.loggedInUser.last_name + ', ' + $scope.loggedInUser.first_name,
           comment: challengeAreaModel.actionComment, actionId: challengeAreaModel.action.id, fileName: challengeAreaModel.fileName}).success(function(data) {
            $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
            challengeAreaModel.createActionComment = false;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.deleteComment = function(actionComment) {
        $http.delete("../php/actionComment.php", {params: {id: actionComment.id}}).success(function(data) {
             $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
        }).error(function(data) {
             challengeAreaModel.errorObj = data;
        })
    }

    $scope.cancelCreateComment = function() {
        challengeAreaModel.createActionComment  = false;
    }


    $scope.createNewOutput = function() {
        challengeAreaModel.createNewOutput = true;
    }

    $scope.createNewOutcome = function() {
        challengeAreaModel.createNewOutcome = true;
    }

     $scope.createNewOutputComment = function() {
        challengeAreaModel.createNewOutputComment = true;
    }

    $scope.createNewOutcomeComment = function() {
        challengeAreaModel.createNewOutcomeComment = true;
    }

    $scope.showOutputComments = function(output) {
        output.showComments = true;
    }

    $scope.hideOutputComments = function(output) {
        output.showComments = false;
    }

    $scope.hideOutcomeComments = function(outcome) {
        outcome.showComments = false;
    }

    $scope.showOutcomeComments = function(outcome) {
        outcome.showComments = true;
    }

    $scope.createOutput = function() {
        $http.post("../php/actionOutput.php", {description: challengeAreaModel.actionOutputDescription, 
            actionId: challengeAreaModel.action.id}).success(function(data){
            challengeAreaModel.createNewOutput = false;
                $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
                challengeAreaModel.actionOutputDescription = "";
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })    
    }

    $scope.cancelCreateOutput = function() {
        challengeAreaModel.createNewOutput = false;
        challengeAreaModel.actionOutputDescription = "";
    }

    $scope.cancelCreateOutcome = function() {
        challengeAreaModel.createNewOutcome = false;
        challengeAreaModel.actionOutcomeDescription = "";
    }



    $scope.createOutcome = function(actionOutcome) {
        $http.post("../php/actionOutcome.php", {description: challengeAreaModel.actionOutcomeDescription, 
            actionId: challengeAreaModel.action.id}).success(function(data){
            challengeAreaModel.createNewOutcome = false;
            $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
            challengeAreaModel.actionOutcomeDescription = "";
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })    
    }

    $scope.deleteOutput = function(actionOutput) {
        $http.delete("../php/actionOutput.php", {params: {id:actionOutput.id}}).success(function(data) {
             $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
        }).error(function(data) {
             challengeAreaModel.errorObj = data;
        })
    }

    $scope.deleteOutcome = function(actionOutcome) {
        $http.delete("../php/actionOutcome.php", {params: {id: actionOutcome.id}}).success(function(data) {
             $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
        }).error(function(data) {
             challengeAreaModel.errorObj = data;
        })
    }

    $scope.createNewOutputComment = function(id) {
        challengeAreaModel.createNewOutputComment = true;
        challengeAreaModel.selectedOutput = id;
    }

    $scope.createNewOutcomeComment = function(id) {
        challengeAreaModel.createNewOutcomeComment = true;
        challengeAreaModel.selectedOutcome = id;
    }
    $scope.createOutputComment = function(actionOutput) {

        $http.post("../php/actionOutputComment.php", {author: $scope.loggedInUser.last_name + ', ' + $scope.loggedInUser.first_name,
           comment: challengeAreaModel.actionOutputComment, actionOutputId: actionOutput.id, fileName: challengeAreaModel.fileName}).success(function(data) {
            $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
            challengeAreaModel.createNewOutputComment = false;
            challengeAreaModel.actionOutputComment = "";
            actionOutput.showComments = true;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.createOutcomeComment = function(actionOutcome) {

        $http.post("../php/actionOutcomeComment.php", {author: $scope.loggedInUser.last_name + ', ' + $scope.loggedInUser.first_name,
           comment: challengeAreaModel.actionOutcomeComment, actionOutcomeId: actionOutcome.id, fileName: challengeAreaModel.fileName}).success(function(data) {
            $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
            challengeAreaModel.createNewOutcomeComment = false;
            challengeAreaModel.actionOutcomeComment = "";
            actionOutcome.showComments = true;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        })
    }

    $scope.cancelCreateOutputComment = function() {
        challengeAreaModel.createNewOutputComment = false;
        challengeAreaModel.actionOutputComment = "";
    }

 $scope.cancelCreateOutcomeComment = function() {
        challengeAreaModel.createNewOutcomeComment = false;
        challengeAreaModel.actionOutcomeComment = "";
    }
    $scope.deleteOutputComment = function(actionOutputComment) {
        $http.delete("../php/actionOutputComment.php", {params: {id: actionOutputComment.id}}).success(function(data) {
             $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
        }).error(function(data) {
             challengeAreaModel.errorObj = data;
        })
    }

    $scope.deleteOutcomeComment = function(actionOutcomeComment) {
        $http.delete("../php/actionOutcomeComment.php", {params: {id: actionOutcomeComment.id}}).success(function(data) {
             $scope.viewAction(challengeAreaModel.action, challengeAreaModel.strategy);
        }).error(function(data) {
             challengeAreaModel.errorObj = data;
        })
    }

    $scope.sendMail = function(userId, subjectArea, subjectName) {
        $http.get("../php/user.php", {params: {id: userId}}).success(function(data) {
            var link = "mailto:"+ data[0].email +"?subject=" + subjectArea + ":" + subjectName;
            $window.location.href = link;
        }).error(function(data) {
            challengeAreaModel.errorObj = data;
        });
       
    }

    $scope.hasPrivileges = function() {
        return $scope.isAdmin() || $scope.loggedInUser.id == challengeAreaModel.challengeArea.leader1_id 
        || $scope.loggedInUser.id == challengeAreaModel.challengeArea.leader2_id || $scope.loggedInUser.id == challengeAreaModel.action.leadId;
    }

    $scope.hasPrivilegesForChangeStatus = function() {
        return $scope.loggedInUser.id == challengeAreaModel.challengeArea.leader1_id 
        || $scope.loggedInUser.id == challengeAreaModel.challengeArea.leader2_id || $scope.loggedInUser.id == challengeAreaModel.action.leadId;
    }

    $scope.setFile = function(element) {
        $scope.$apply(function($scope) {
            challengeAreaModel.fileName = element.files[0].name;
        });
    };

    init();
})