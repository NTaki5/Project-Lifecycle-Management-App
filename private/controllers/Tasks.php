<?php 
// Task Controller

class Tasks extends Controller{

    function index(){

        $errors = array();
        $userDB = new User();
        $userDetails = $userDB->where('fk_company_id', Auth::getFk_company_id());

        $companyDB = new Company();
        $companyDetails = $companyDB->where('id', Auth::getFk_company_id());

        $projectDB = new Project();

        $projectUserMap = new Project();
        $projectUserMap->table = "map_users_projects";
        $projectUserMap->allowedColumns = ['fk_user_id', 'fk_project_id'];

        $taskDB = new Task();
        $taskUserMap = new Task();
        $taskUserMap->table = "map_users_tasks";
        $taskUserMap->allowedColumns = ['fk_user_id', 'fk_task_id'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($_POST)) {
                if (isset($_POST['create-task'])) {
                    try {

                        $_POST['title'] = htmlspecialchars($_POST['title']);
                        $_POST['description'] = htmlspecialchars($_POST['description']);

                        $_POST['status'] = 'todo';
                        $_POST['fk_company_id'] = Auth::getFk_company_id();
                        $_POST['priority'] = count($taskDB->findAll("DESC", "1")) ? ($taskDB->findAll("DESC", "1")[0]->priority + 1) : 1;

                        // print_r($_POST);
                        // exit();
                        if (count($taskDB->insert($_POST))) {
                            new Toast("The task could not be created.");
                            exit();
                        }

                        $lastTaskId = $taskDB->last_inserted_id();
                        $teamMembers = $_POST['teamMembers'];

                        foreach ($teamMembers as $key => $value) {
                            if (count($taskUserMap->insert([
                                "fk_user_id" => $value,
                                "fk_task_id" => $lastTaskId
                            ]))) {
                                $taskUserMap->delete($lastTaskId, 'fk_task_id');
                                $taskDB->delete($lastTaskId);
                            }
                        }

                        new Toast("Task created");
                        $getSpecificProject = $projectDB->where('id', $_POST['fk_project_id']);
                        $projectName = count($getSpecificProject) ? $getSpecificProject[0]->title : "";
                        $projectColor = count($getSpecificProject) ? $getSpecificProject[0]->color : "";

                        echo json_encode([
                            "insertedTaskId" => $taskDB->last_inserted_id(),
                            "projectName" => $projectName,
                            "projectColor" => $projectColor,
                            "toast" => Toast::show("show toast-onload")
                        ]);
                    } catch (Exception $e) {

                        // Send a custom error response
                        header('Content-Type: application/json');
                        http_response_code(400); // Set a 4xx or 5xx status code
                        new Toast("The task could not be created.");
                        echo "The task could not be created.";
                    }
                    exit();
                }

                if (isset($_POST['edit-task'])) {
                    try {


                        if (!isset($_POST['taskID']) || !count($editTask = $taskDB->where("id", $_POST['taskID']))) {
                            new Toast("The edited task not exist");
                            exit();
                        }
                        $taskID = $_POST['taskID'];

                        // check fk_keys is set, if not, unset the $_POST fk values;
                        if (isset($_POST['fk_project_id']) && $_POST['fk_project_id'] <= 0)
                        unset($_POST['fk_project_id']);

                        $_POST['title'] = htmlspecialchars($_POST['title']);
                        $_POST['description'] = htmlspecialchars($_POST['description']);

                        if (count($taskDB->update($_POST['taskID'], $_POST))) {
                            new Toast("The task could not be saved.");
                            exit();
                        }

                        $taskUserMap->delete($taskID, 'fk_task_id');

                        $teamMembers = isset($_POST['teamMembers']) ? $_POST['teamMembers'] : array();
                        foreach ($teamMembers as $key => $value) {
                            if (count($taskUserMap->insert([
                                "fk_user_id" => $value,
                                "fk_task_id" => $taskID
                            ]))) {
                                new Toast("The task could not be created.");
                                $taskUserMap->delete($taskID, 'fk_task_id');
                                $taskDB->delete($taskID);
                            }
                        }

                        new Toast("Task saved");
                    } catch (Exception $e) {

                        // Send a custom error response
                        header('Content-Type: application/json');
                        http_response_code(400); // Set a 4xx or 5xx status code
                        new Toast("The task could not be created.");
                        echo "The task could not be created.";
                    }
                    exit();
                }

                if (isset($_POST['get-projects-fromCompany'])) {
                    print_r(json_encode($projectDB->where('fk_company_id', $_POST['companyID'])));
                    exit();
                }

                if (isset($_POST['get-members-fromProject'])) {

                    $projectID = $_POST['projectID'];

                    $projectMembersIDs = $projectUserMap->where('fk_project_id', $projectID);
                    $projectMembersIDs = array_map(function ($obj) {
                        return $obj->fk_user_id;
                    }, $projectMembersIDs);
                    $projectMembersIDs = array_unique($projectMembersIDs);
                    $returnUsers = array();
                    foreach ($projectMembersIDs as $key => $value) {
                        $userData = $userDB->where('id', $value)[0];
                        array_push($returnUsers, ["userId" => $userData->id, "userName" => $userData->name, "userRole" => $userData->role]);
                    }

                    print_r(json_encode($returnUsers));
                    exit();
                }

                if (isset($_POST['update-status'])) {
                    if (isset($_POST['taskStatus'])) {
                        if (count($taskDB->update($_POST['taskID'], ['status' => $_POST['taskStatus']]))) {
                            new Toast("The task status could not be saved.", "Try again later!");
                            exit();
                        }
                    }
                    exit();
                }

                if (isset($_POST['delete-task'])) {
                    $taskDB->delete($_POST["taskID"], "id");
                    $taskUserMap->delete($_POST["taskID"], "fk_task_id");
                    exit();
                }
            }
        }
        
        if(Auth::getRole() == 'admin'){
            $projectDetails = $projectDB->where('fk_company_id', Auth::getFk_company_id());
            $taskDetails = $taskDB->where('fk_company_id', Auth::getFk_company_id());
        }
        if(Auth::getRole() == 'employee'){
            $projectDetails = $projectDB->where('fk_company_id', Auth::getFk_company_id());
            // GET JUST THE CLIENT TASKS
            $clientTasksIds = $taskUserMap->where('fk_user_id', Auth::getId());
            $clientTasksIds = array_map(function($obj){
                return $obj->fk_task_id;
            }, $clientTasksIds);
            $taskDetails = array();
            foreach ($clientTasksIds as $key => $value) {
                array_push($taskDetails, $taskDB->where('id', $value)[0]);
            }
        }
        if(Auth::getRole() == 'client'){
            // $userDetails = $userDB->where('fk_company_id', Auth::getFk_company_id());

            // // GET JUST THE CLIENT PROJECTS
            $clientProjectsIds = $projectUserMap->where('fk_user_id', Auth::getId());
            $clientProjectsIds = array_map(function($obj){
                return $obj->fk_project_id;
            }, $clientProjectsIds);
            $projectDetails = array();
            foreach ($clientProjectsIds as $key => $value) {
                array_push($projectDetails, $projectDB->where('id', $value)[0]);
            }

            $projectDetails = $taskDB->query("SELECT DISTINCT p.* FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE mup.fk_user_id = :user_id",
            ["user_id" => Auth::getId()]);

            // // GET JUST THE CLIENT TASKS
            // $clientTasksIds = $taskUserMap->where('fk_user_id', Auth::getId());
            // $clientTasksIds = array_map(function($obj){
            //     return $obj->fk_task_id;
            // }, $clientTasksIds);
            // $taskDetails = array();
            // foreach ($clientTasksIds as $key => $value) {
            //     array_push($taskDetails, $taskDB->where('id', $value)[0]);
            // }

            // Megnezem a projekteket, amik a bejelentkezett Users-hez tartozik, majd le kerem a taskeket hozza
            $taskDetails = $taskDB->query("SELECT DISTINCT t.* FROM tasks as t INNER JOIN map_users_tasks as mut ON t.id = mut.fk_task_id WHERE mut.fk_user_id = :user_id1 AND t.fk_project_id IN (
            SELECT DISTINCT p.id FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE mup.fk_user_id = :user_id2
            )",["user_id1" => Auth::getId(), "user_id2" => Auth::getId()]);
        }


        $this->view("tasks", [
            'taskDetails' => $taskDetails,
            'userDetails'=> $userDetails,
            'projectDetails' => $projectDetails,
            'companyDetails' => $companyDetails,
            'errors' => $errors
        ]);
    }
}