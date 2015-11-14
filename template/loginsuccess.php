<!doctype html>
<html ng-app="shspApp">
<head>
<title>My Login</title>
<style type="text/css">
    body{padding-top:20px;}
	h1   {color:#DF7401}
	.form-inline > * {
   margin:7px;
}
</style>
</style>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/safetrec.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="../js/angular.js"></script>
<script src="../js/bootstrap.js"></script>	
<script src="../js/shspapp.js"></script>
</head>
<body >
<div class="container" ng-controller="MainCtrl"> 
<div class="wrapper">
       <img src="../img/shsp-logo.gif" align="right" width="120" height="50" class="img-responsive" alt="Responsive image">
       <br/>
       <br/>
       <br/>
       <br/>
       <h5 align="right">
			<a id="Logout" name="Logout" align="right" ng-click="logout()">Logout</a>
		</h5>
     </div>

<div>
	<!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs" role="tablist">
		
		<li class="active" role="presentation">
			<a href="#home" aria-controls="home" role="tab" data-toggle="tab"> Home
			</a>
		</li>
		<li role="presentation">
			<a href="#home" aria-controls="home" role="tab" data-toggle="tab"> Challenge Areas
			</a>
		</li>
		<li role="presentation">
			<a href="#documents" aria-controls="documents" role="tab" data-toggle="tab" ng-click="listDocuments()"> Documents
			</a>
		</li>
		<li class="dropdown"><a class="dropdown-toggle"
			data-toggle="dropdown"> Admin <span class="caret"></span>
		</a>
			<ul class="dropdown-menu" role="menu">
				<li><a data-target="#viewUser" data-toggle="tab" ng-click="getUsers()">User</a></li>
				<li><a data-target="#viewAgency" data-toggle="tab">Agency</a></li>
				<li><a data-target="#viewDivision" data-toggle="tab">Division</a></li>		
			</ul></li>
	</ul>
<div class="tab-content">	
	<div  role="tabpanel" class="tab-pane active" id="home">
		<br>
		<label> Welcome to SafeTrec </label>
	</div>
	<div role="tabpanel" class="tab-pane" id="documents">
		<ng-include src="'download.php'" ng-controller="MainCtrl"></ng-include>
	</div>
	<div role="tabpanel" class="tab-pane" id="viewUser">
		<ng-include src="'user.html'" ng-controller="UserCtrl"></ng-include>
	</div>
	<div role="tabpanel" class="tab-pane" id="viewAgency">
		<ng-include src="'agency.html'" ng-controller="AgencyCtrl"></ng-include>
	</div>	
	<div role="tabpanel" class="tab-pane" id="viewDivision">
		<ng-include src="'division.html'" ng-controller="DivisionCtrl"></ng-include>
	</div>	
</div>
</div>
</body>
</html>