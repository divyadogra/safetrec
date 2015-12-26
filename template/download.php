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

      </div>
    </div>
    <div class="col-md-1"></div>
    <div class="col-md-1"></div>
  </div>