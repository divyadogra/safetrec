app = angular.module('downloadapp', []);
app.factory('redirectInterceptor', function($q,$location,$window){
    return  {
        'response':function(response){
        if (typeof response.data === 'string') {
            console.log(response.data);
            $window.location.href = "/PHPTest/download.html";
            return $q.reject(response);
        }else{
            return response;
        }
        }
    }

    });
app
  .config(function($httpProvider){
    $httpProvider.interceptors.push('redirectInterceptor');
});
app.controller("DownloadCtrl",function($scope,$http,$location){
	var myURL = 'https://api.box.com/2.0/files/37233808870/content'
	$http.get(myURL, {headers:{"crossDomain": "true", "Authorization": "Bearer TkXMiujRhsUyDieD11f4QMcqhWKaL2MS"}}).then(function (results) {
        console.log(results)
        $location.url(results)
        $scope.rows = results
    });
});