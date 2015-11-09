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
		<div ng-show="users">
			<br><label vertical-align="middle">&nbsp;Users</label>
			<br> <label ng-hide="users">No User Added yet</label>
			<div id="dvData" class="table-responsive">
				<table id="testTable" class="table table-striped table-bordered">
					<thead>
						<tr>
							<td><b>Name</td>
							<td><b>Email</td>
							<td width="2"><b>Action</td>
						</tr>
					</thead>
					<tbody
						ng-repeat="suser in users track by suser.id">
						<tr>
							<td><a href="#" ng-click="viewUser(suser)">{{suser.lastName}}, {{suser.firstName}} </a></td>
							<td>{{suser.email}}</td>
							<td><button class="btn-group btn-group-xs btn-primary" ng-click="toggleView()">Edit</button></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>

		<div ng-hide="users">
			<br><h2>User Details</h2>
			<br>
			<label> First Name : {{viewUser.firstName}} </label>
			<br>
			<label> Last Name : {{viewUser.lastName}} </label>
			<br>
			<label> Email : {{viewUser.email}} </label>
		</div>
	</div>	
	<div role="tabpanel"  class="tab-pane" id="addUser">
			<br>
			<div class="alert alert-success" ng-show="userCreated">User
				successfully created.</div>
			<div class="alert alert-danger" ng-show="model.errorObj">User
				creation failed with error : {{model.errorObj.description}}</div>
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Enter User Details</h3>
				</div>
				<div class="panel-body">
					<form name="form1" role="form">
						<div class="col-xs-4">
							<div class="form-group has-feedback">
								<!--  ng-class="{'has-error': form1.firstName.$invalid, 'has-success': !form1.firstName.$invalid}" -->
								<label>First Name:</label> <input type="text" required
									id="firstName" name="firstName" class="form-control"
									ng-model="user.firstName"></input>
							</div>

							<div class="form-group has-feedback">
								<!-- ng-class="{'has-error': form1.lastName.$invalid, 'has-success': !form1.lastName.$invalid}" -->
								<label>Last Name:</label> <input type="text" required
									id="lastName" name="lastName" class="form-control"
									ng-model="user.lastName"></input>
							</div>
							<div class="form-group has-feedback">
								<!-- ng-class="{'has-error': form1.email.$invalid, 'has-success': !form1.email.$invalid}" -->
								<label>Phone:</label> <input type="number" id="phone" 
									name="phone" class="form-control" ng-model="user.phone"></input>
							</div>

							<div class="form-group has-feedback">
								<!-- ng-class="{'has-error': form1.email.$invalid, 'has-success': !form1.email.$invalid}" -->
								<label>Agency:</label> <select class="form-control" required
									ng-model="user.agency" name="agency" id="agency">
									<option value="" ng-hide="user.agency" selected>Choose
										One</option>
								</select>
							</div>

							<div class="form-group has-feedback">
								<!-- ng-class="{'has-error': form1.email.$invalid, 'has-success': !form1.email.$invalid}" -->
								<label>Division:</label> <select class="form-control" required
									ng-model="user.division" name="division" id="agency">
									<option value="" ng-hide="user.division" selected>Choose
										One</option>
								</select>
							</div>

							<div class="form-group has-feedback">
								<!-- ng-class="{'has-error': form1.email.$invalid, 'has-success': !form1.email.$invalid}" -->
								<label>Email Id:</label> <input type="email" id="email" required
									name="email" class="form-control" ng-model="user.email"></input>
								<!--  <span ng-show="form1.email.$invalid"
									class="glyphicon glyphicon-remove form-control-feedback"></span>
								<span ng-show="!form1.email.$invalid"
									class="glyphicon glyphicon-ok form-control-feedback"></span> -->
							</div>

							<div class="form-group has-feedback">
								<!-- ng-class="{'has-error': form1.email.$invalid, 'has-success': !form1.email.$invalid}" -->
								<label>Password:</label> <input type="password" id="password" required
									name="password" class="form-control" ng-model="user.password"></input>
							</div>

							<div class="form-group">
								<!-- ng-class="{'has-error': form1.role.$invalid, 'has-success': !form1.role.$invalid}" -->
								<label>Role:</label> <select class="form-control" required
									ng-model="user.role" name="role" id="role">
									<option value="" ng-hide="user.role" selected>Choose
										One</option>
									<option>Basic</option>
									<option>Action Lead</option>
									<option>Challenge Area Lead</option>
									<option>Admin</option>
								</select>
							</div>

							<div class="form-group">
								<button class="btn btn-primary" type="submit"
									ng-click="createUser()">Submit</button>
							</div>
						</div>
					</form>
				</div>
			</div>
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