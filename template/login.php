<!DOCTYPE html>
<html lang="en" ng-app="loginapp">
<head>
<title>My Login</title>
<style type="text/css">
      body{padding-top:20px;}
</style>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/safetrec.css" rel="stylesheet">
<script src="../js/angular.js"></script>
<script src="../js/loginapp.js"></script>
</head>
<body >
<div ng-controller="LoginCtrl"> 
<img src="../img/SHSPTracker.jpg" width="100%", height="150" class="image-border">

		<div class="container" >
		
		<br/>
    <div class="row">
		<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Please sign in</h3>
			 	</div>
			  	<div class="panel-body">
			  		<!--label class="label label-danger" ng-show="loginObj.showAuthenticationError">{{errorObj.description}}</label-->
			    	<br/>
			    	<form accept-charset="UTF-8" role="form">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" placeholder="E-mail" name="email" type="email" ng-model="loginObj.email">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" name="password" type="password" value="" ng-model="loginObj.password">
			    		</div>
			    		<input class="btn btn-lg btn-primary btn-block" type="submit" value="Login" ng-click="login()">
			    	</fieldset>
			      	</form>
			      	<br>
			      	<label align="center" class="label label-danger" ng-if="error">User information not correct</label>
			    </div>
			</div>
		</div>
	</div>
</div>

</body>
</html>