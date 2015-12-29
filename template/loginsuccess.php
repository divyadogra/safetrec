<html ng-app="shspApp">
<head>
<title>SHSP Tracking Tool</title>
<style type="text/css">
    body{padding-top:20px;}
	h1   {color:#DF7401}
	.form-inline > * {
   margin:7px;
}
</style>
<link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
<link href="../css/safetrec.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="../js/angular.js"></script>
<script src="../js/angular-route.js"></script>
<script src="../js/angular-file-upload.js"></script>
<script src="../js/bootstrap.js"></script>	
<script src="../js/underscore.js"></script>
<script src="../js/shspapp.js"></script>
<script src="http://www.datejs.com/build/date.js" type="text/javascript"></script>
</head>
<body >
<div ng-controller="MainCtrl"> 
		<img src="../img/SHSPTracker.jpg" width="100%", height="150" class="image-border"> 
<div>
	<div class="container">
	<!-- Only required for left/right tabs -->
	<ul class="nav nav-tabs navbar-blue" role="tablist">
		
		<li class="active" role="presentation">
			<a href="#home" class="navbar-text" aria-controls="home" role="tab" data-toggle="tab"> HOME
			</a>
		</li>
		<li role="presentation">
			<a href="#viewChallengeArea" class="navbar-text" aria-controls="viewChallengeArea" role="tab" data-toggle="tab" ng-click="init()"> CHALLENGE AREAS
			</a>
		</li>
		<li role="presentation">
			<a href="#documents" class="navbar-text" aria-controls="documents" role="tab" data-toggle="tab" ng-click="listDocuments(0, 'root')"> DOCUMENTS
			</a>
		</li>
		<li class="dropdown"  ng-show="loggedInUser.role == 'Admin'">
		<a class="dropdown-toggle navbar-text" 
			data-toggle="dropdown"> ADMIN <span class="caret"></span>
		</a>
			<ul class="dropdown-menu" role="menu">
				<li><a data-target="#viewUser" data-toggle="tab" ng-click="getUsers()">USER</a></li>
				<li><a data-target="#viewAgency" data-toggle="tab">AGENCY</a></li>
				<li><a data-target="#viewDivision" data-toggle="tab">DIVISION</a></li>		
			</ul>
		</li>
		
		<h5 class="right-align" >
       		Welcome, {{loggedInUser.first_name}} {{loggedInUser.last_name}}!
			<a id="Logout" name="Logout" class="logout" href ng-click="logout()">Logout</a>
		</h5>
		
	</ul>

<div class="tab-content">	
	<div  role="tabpanel" class="tab-pane active" id="home">
		<br>
		<label> Welcome to Strategic Highway Safety Plan Tracking Tool  </label>
		<p>SHSP Tracker enables agency employees and their team members to organize and track plans and actions across offices. SHSP Tracker requires its users to sort their activities into a hierarchy of Challenge Areas, Strategies and Actions. The system allows users of different types to add, edit, and update information on these items, and to view the data associated with each one. 
Tracking is a central feature of SHSP Tracker. Users can drill through visualized lists to observe progress and identify obstacles.
SHSP Tracker allows all users to view these items and their associated details. Only some users can edit information, and an even smaller number of users can add and delete information. Roles determine the data, user information, or agency information that can be maintained through SHSP Tracker. 
</p>
<p>For more information on SHSP reporting, contact Greg Tom: greg_tom@dot.ca.gov</p>
	<p>For more information on SHSP Tracker, including technical support, contact Jill Cooper: cooperj@berkeley.edu</p>
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
	<div role="tabpanel" class="tab-pane" id="viewChallengeArea">
		<ng-include src="'challengeArea.html'" ng-controller="ChallengeAreaCtrl"></ng-include>
	</div>	
	</div>
</div>
</div>
</body>
</html>