<?php
include "dbConnect.php";

try {

      session_start();
      if (!isset($_SESSION['loggedInUser'])) {
        throw new Exception("Invalid Login");
      } 

      $request_type = $_SERVER['REQUEST_METHOD']; 

      if ($request_type == 'GET') {
            viewActions($_GET['challengeId']);
      } else if ($request_type == 'POST') {
            createAction();
      } else if ($request_type == 'PUT') {
            updateAction();
      } else if ($request_type == 'DELETE') {
            deleteAction();
      }
} catch (Exception $e) {
  $response = $e->getMessage();
 if ($response == 'Invalid Login') {
    header(':', true, 401);
 }
 echo $response;
}

function viewActions($challengeId) {
      try{

            $query = "select id, name, description from strategy where challenge_id =".$challengeId;               
            $results = executeQuery($query);

            for($i=0, $c = count($results); $i < $c; $i++) {
              $query = "select action.id, action.description, action.status, action.division_id as divisionId, action.lead_id as leadId, DATE_FORMAT(action.start_date, '%m/%d/%Y') as startDate, DATE_FORMAT(action.end_date, '%m/%d/%Y') as endDate, 
                        action.scope_reach as scopeReach, DATE_FORMAT(action.last_activity, '%m/%d/%Y') as lastActivity,
                        user.last_name as leaderLastName, user.first_name as leaderFirstName, agency.name as agencyName, agency.id as agencyId
                        from action, user, agency where action.lead_id = user.id and action.agency_id = agency.id and action.strategy_id=".$results[$i]['id'];
              $actionResults = executeQuery($query);        
              $results[$i]['actions'] = $actionResults;

            }

            $response = json_encode($results);
            echo $response;
            
      } catch (Exception $e) {
       $response = $e->getMessage();
      }
}

function createAction() {
      try{
            $postdata = file_get_contents("php://input");
            $request = json_decode($postdata);
            $strategyId = $request->strategyId;
            $description = $request->description;
            $status = $request->status;
            $leadId = $request->leadId;
            $agencyId = $request->agencyId;
            $divisionId = $request->divisionId;
            $startDate = $request->startDate;
            $startDate = substr($startDate, 0, 10); 
            $endDate = $request->endDate;
            $endDate = substr($endDate, 0, 10); 
            $scopeReach = $request->scopeReach; 
            
            $query = sprintf("insert into action(strategy_id, description, status, lead_id, agency_id, division_id, start_date, end_date, scope_reach, last_activity) values (%d, '%s', '%s', %d, %d, %d, '%s', '%s', '%s', now())", 
                              $strategyId, $description, $status, $leadId, $agencyId, $divisionId, $startDate,
                              $endDate, $scopeReach);   

            $results = executeQuery($query);

            // TODO
            // check the results for success/ failure?

      } catch (Exception $e) {
       $response = $e->getMessage();
 }

}

function updateAction() {
      try{
            $putdata = file_get_contents("php://input");
            $request = json_decode($putdata);
            $id = $request->id;
            $strategyId = $request->strategyId;
            $description = $request->description;
            $status = $request->status;
            $leadId = $request->leadId;
            $agencyId = $request->agencyId;
            $divisionId = $request->divisionId;
            $startDate = $request->startDate; 
            // $startDate = substr($startDate, 0, 10); 
            $endDate = $request->endDate;
            // $endDate = substr($endDate, 0, 10); 
            $scopeReach = $request->scopeReach;
          

            $query = sprintf("update action set strategy_id=%d, description='%s', 
                                status='%s',lead_id=%d, agency_id=%d, division_id=%d, start_date='%s', end_date='%s',
                                scope_reach='%s', last_activity=now() where id=%d",
                                $strategyId, $description, $status, $leadId, $agencyId, $divisionId, $startDate,
                                $endDate, $scopeReach, $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

function deleteAction() {
      try{
            $id = $_GET['id'];

            $query = sprintf("delete from action where id=%d", $id);         
            $results = executeQuery($query);

                  // TODO
                  // check the results for success/ failure?

      } catch (Exception $e) {
           $response = $e->getMessage();
     }
}

?>