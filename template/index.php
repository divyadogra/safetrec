<!DOCTYPE html>
<html lang="en" ng-app="app">
<head>
<meta charset="utf-8">
<meta content="IE=edge" http-equiv="X-UA-Compatible"></meta>
<meta content="width=device-width, initial-scale=1" name="viewport"></meta>

<title>MYPHPTest</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body ng-cloak="">
 
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-8">

      <h1>
        <p class="text-center">My Box Documents</p>
      </h1>
      <br />

<div class="alert alert-success">
</div>
      <div class="container" ng-controller="NavCtrl">
        <div class="panel panel-default">
          <div class="panel-heading">Upload Files</div>
          <div class="panel-body">
            <form action="uploadTest.php" method="post" enctype="multipart/form-data">
            <input name="file" type="file" id="file"/> </br>
            <input name="btnUpload" type="submit" value="Upload" class="btn btn-primary" />
            <!-- <button name="btnUpload" type="button" class="btn btn-primary">Upload</button> -->
            </form>
          </div>
        </div>
        <div class="panel panel-default">
          <div class="panel-heading">Download Files</div>
          <br/>
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
              <tr ng-repeat="file in files">
                <th scope="row">{{$index+1}}</th>
                <td name="fileName">{{file.name}}</td>
                <td width="10">
                  <form action="uploadTest.php" method="post" enctype="multipart/form-data">
                    <input ng-hide="true" name="fileId" value="{{file.id}}"/>
                    <input ng-hide="true" name="fileName" value="{{file.name}}"/>
                    <input name="btnDownload" type="submit" class="btn btn-primary" align="center" value="Download"/>
                  </form>
              </tr>
            <tbody>
          </table>
        </div>


        <!-- <select name="listOfFiles" ng-model="selectedOption" ng-options="file.name for file in files track by file.id">
      </select>
      <button value="Download" ng-click="download()"></button> -->

      </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-1"></div>
  </div>
  <script src="js/angular.js"></script>
  <script src="js/app.js"></script>
</body>
</html>
