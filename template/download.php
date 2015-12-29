<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-8">
</div>
      <div class="container">
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
          <ol class="breadcrumb">
            <li ng-repeat="folder in folderTrain"><a href="" ng-click="loadFolder(folder)">{{folder.name}}</a></li>
          </ol>
          <table class="table table-condensed">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th width="10%" align="center">Actions</th>
            </tr>
            </thead>
            <tbody>
              <tr ng-repeat="file in files">
                <th scope="row">{{$index+1}}</th>
                <!-- <td name="fileName">
                  <span class="glyphicon glyphicon-file" ng-show="file.type == 'file'" aria-hidden="true" />
                  <span class="glyphicon glyphicon-folder-open" ng-show="file.type == 'folder'" aria-hidden="true" />
                  &nbsp;<a name="btnDownload" ng-show="file.type == 'file'" onclick="document.getElementById('form-id').submit()">{{file.name}}</a>
                  <a name="btnViewFolder" ng-show="file.type == 'folder'" ng-click="listDocuments(file.id, file.name)">{{file.name}}</a>
                </td> -->
                <td name="fileName">
                  
                    <span class="glyphicon glyphicon-file" title="File" ng-show="file.type == 'file'" aria-hidden="true" />
                    <span class="glyphicon glyphicon-folder-open" title="Folder" ng-show="file.type == 'folder'" aria-hidden="true" />
                  &nbsp;{{file.name}}
                  </td>
                  <td width="10%">
                      <button name="btnViewFolder" class="btn btn-primary" align="center" ng-show="file.type == 'folder'" ng-click="listDocuments(file.id, file.name)">View</button>
                      <form action="uploadTest.php" method="post" enctype="multipart/form-data">
                        <input ng-hide="true" name="fileId" value="{{file.id}}"/>
                        <input ng-hide="true" name="fileName" value="{{file.name}}"/>
                        <input name="btnDownload" type="submit" class="btn btn-primary" align="center" ng-show="file.type == 'file'" value="Download"/>
                    </form>
                  </td>
              </tr>
            <tbody>
          </table>
        </div>

      </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-1"></div>
  </div>