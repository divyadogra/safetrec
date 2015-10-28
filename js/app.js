app = angular.module('app', []);
app.controller("NavCtrl",function($scope,$http, $window){
	var myURL = 'php/list.php';
	$http.get(myURL).success(function (results) {
		// $scope.rows = results;
        $scope.files = results.item_collection.entries;
    });

    $scope.download = function(file) {
    	
    	$http({
    		url:'php/download.php',
    		method: 'POST',
    		data: {id: file.id},
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
    		
    	}).then(function(results){
    		var anchor = angular.element('<a/>');
             anchor.attr({
                 href: 'data:text/plain;charset=utf-8,' + encodeURIComponent(results.data),
                 target: '_blank',
                 download: 'filename.pdf'
             })[0].click();
        });
    }

    $scope.upload = function() {
        var f = document.getElementById('myfile').files[0],
        r = new FileReader();
        r.onloadend = function(e){
        var data = e.target.result;
    //send you binary data via $http or $resource or do anything else with it
        $http({
            url:'php/upload.php',
            method: 'POST',
            data: {fileData: data}
            }).then(function(results){

            })
        }
    };


    
});