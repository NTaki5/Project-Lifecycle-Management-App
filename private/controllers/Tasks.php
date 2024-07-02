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
        $taskCategoriesDB = new Task();
        $taskCategoriesDB->allowedColumns =["name", "priority", "active", "fk_project_id"];
        $taskUserMap = new Task();
        $taskUserMap->table = "map_users_tasks";
        $taskUserMap->allowedColumns = ['fk_user_id', 'fk_task_id'];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($_POST)) {
                if (isset($_POST['create-task'])) {
                    try {
                        $_POST['fk_company_id'] = Auth::getFk_company_id();
                        $_POST['createdBy_id'] = Auth::getId();
                        $_POST['priority'] = count($taskDB->findAll(orderby:"priority DESC", limit:"1")) ? ($taskDB->findAll(orderby:"priority DESC", limit:"1")[0]->priority + 1) : 1;

                        if (count($taskDB->insert($_POST))) {
                            new Toast("The task could not be created.");
                            exit();
                        }

                        $lastTaskId = $taskDB->last_inserted_id();

                        if(isset($_POST['teamMembers'])){
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
                        if (isset($_POST['fk_project_id']) && $_POST['fk_project_id'] <= 0){
                            unset($_POST['fk_project_id']);
                            new Toast("The task could not be saved.");
                            $this->redirect('home');         
                        }

                        if($taskCategoryID = $taskDB->where(["id"], [$_POST['taskID']])[0]->fk_category_id){

                                $taskCategory = $taskCategoriesDB->getTaskCategoryWhere(['id'], [$taskCategoryID])[0];
                                $taskCategoryName = $taskCategory->name;
                                $taskCategoryPriority = $taskCategory->priority;
                                $taskCategoryActive = $taskCategory->active;


                                // Ha nem letezik hasonlo elnevezesu feladat kategoria abban a projektben, ahova at akarom koltoztetni
                                // a feladatot, akkor letrehozok                                

                                if(!count($taskCategoriesDB->getTaskCategoryWhere(["fk_project_id", "name"], [$_POST['fk_project_id'], $taskCategoryName]))){
                                    $taskCategoriesDB->addTaskCategory([
                                        "name" => $taskCategoryName,
                                        "fk_project_id" => $_POST['fk_project_id'],
                                        "priority" => $taskCategoryPriority,
                                        "active" => $taskCategoryActive
                                    ]);
                                    $insertTaskCategoryID = $taskCategoriesDB->last_inserted_id();
                                }else{
                                    $insertTaskCategoryID = $taskCategoriesDB->getTaskCategoryWhere(["fk_project_id", "name"], [$_POST['fk_project_id'], $taskCategoryName])[0]->id;
                                }

                                $_POST['fk_category_id'] = $insertTaskCategoryID;

                        }

                        if (count($taskDB->update($taskID, $_POST))) {
                            new Toast("The task could not be saved.");
                            exit();
                        }

                        $taskUserMap->delete($taskID, 'fk_task_id');

                        $teamMembers = isset($_POST['teamMembers']) ? $_POST['teamMembers'] : array();
                        foreach ($teamMembers as $key => $value) {
                           $taskUserMap->insert([
                                "fk_user_id" => $value,
                                "fk_task_id" => $taskID
                           ]);
                        }
                        new Toast("Task saved");
                        echo json_encode([
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

                if (isset($_POST['get-projects-fromCompany'])) {
                    if(isset($_POST['companyID']))
                        print_r(json_encode($projectDB->where('fk_company_id', $_POST['companyID'])));
                    else
                        print_r(json_encode($projectDB->where('fk_company_id', Auth::getFk_company_id())));

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

                if (isset($_POST['get-membersAndProject-associated-with-Task'])) {

                    $taskID = $_POST['taskID'];

                    $taskMembersIDs = $taskUserMap->where('fk_task_id', $taskID);
                    $taskMembersIDs = array_map(function ($obj) {
                        return $obj->fk_user_id;
                    }, $taskMembersIDs);
                    $taskMembersIDs = array_unique($taskMembersIDs);
                    $returnUsersAndProject = array();
                    $users = array();
                    foreach ($taskMembersIDs as $key => $value) {
                        $userData = $userDB->where('id', $value)[0];
                        array_push($users, [
                            "userId" => $userData->id, "userName" => $userData->name, "userRole" => $userData->role
                            ]
                        );
                    }

                    $project = array();
                    array_push($project, $taskDB->where('id', $taskID)[0]->fk_project_id);
                    array_push($returnUsersAndProject, $users);
                    array_push($returnUsersAndProject, $project);

                    print_r(json_encode($returnUsersAndProject));
                    exit();
                }

                if (isset($_POST['update-status'])) {
                    if (isset($_POST['fk_category_id'])) {

                        if (count($taskDB->update($_POST['taskID'], ['fk_category_id' => $_POST['fk_category_id']]))) {
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
        if(!isset($_GET['project'])){
            $this->redirect('projects');
        }
        $actuallyProject = $projectDB->where('slug', $_GET['project'])[0];
        $projectTasksCategories = $taskCategoriesDB->getTaskCategoryWhere('fk_project_id', $actuallyProject->id);

        if(Auth::getRole() == 'admin'){
            if(isset($actuallyProject->id)){
                $projectDetails = $projectDB->where(['fk_company_id','id'], [Auth::getFk_company_id(), $actuallyProject->id]);
                $taskDetails = $taskDB->where(['fk_company_id','fk_project_id'], [Auth::getFk_company_id(), $actuallyProject->id]);
            }
            
            // GET ALL TASKS from company ------>>> DISABLED NOW
            // else{
            //     $projectDetails = $projectDB->where('fk_company_id', Auth::getFk_company_id());
            //     $taskDetails = $taskDB->where('fk_company_id', Auth::getFk_company_id());
            // }
        }
        if(Auth::getRole() == 'employee'){
            if(isset($actuallyProject->id)){
                $projectDetails = $projectDB->where(['fk_company_id','id'], [Auth::getFk_company_id(), $actuallyProject->id]);
                $taskDetails = $taskDB->query("SELECT DISTINCT t.* FROM tasks as t WHERE t.createdBy_id = :user_id1 
                OR t.id IN(
                    SELECT fk_task_id FROM map_users_tasks WHERE fk_user_id = :user_id2
                )
                OR t.id NOT IN (
                    SELECT fk_task_id FROM map_users_tasks
                )
                AND t.fk_project_id IN (
                    SELECT DISTINCT id FROM projects WHERE fk_company_id = :company_id AND fk_project_id = :project_id
                    )",["user_id1" => Auth::getId(), "user_id2" => Auth::getId(), "company_id" => Auth::getFk_company_id(), ":project_id" => $actuallyProject->id]);
            }
            // GET ALL TASKS from company ------>>> DISABLED NOW
            // else{
            //     $projectDetails = $projectDB->where('fk_company_id', Auth::getFk_company_id());
            //     $taskDetails = $taskDB->query("SELECT DISTINCT t.* FROM tasks as t INNER JOIN map_users_tasks as mut ON t.id = mut.fk_task_id WHERE createdBy_id = :user_id1 OR mut.fk_user_id = :user_id2 AND t.fk_project_id IN (
            //         SELECT DISTINCT id FROM projects WHERE fk_company_id = :company_id
            //         )",["user_id1" => Auth::getId(), "user_id2" => Auth::getId(), "company_id" => Auth::getFk_company_id()]);
            // }
            
        }
        if(Auth::getRole() == 'client'){

            if(isset($actuallyProject->id)){
                $projectDetails = $projectDB->query("SELECT DISTINCT p.* FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE mup.fk_user_id = :user_id AND p.id = :project_id;",
                ["user_id" => Auth::getId(),":project_id" => $actuallyProject->id]);
    
                // Megnezem a projekteket, amik a bejelentkezett Users-hez tartozik, majd le kerem a taskeket hozza
                $taskDetails = $taskDB->query("SELECT DISTINCT t.* FROM tasks as t WHERE t.createdBy_id = :user_id1 
                OR t.id IN(
                    SELECT fk_task_id FROM map_users_tasks WHERE fk_user_id = :user_id2
                )
                AND t.fk_project_id IN (
                SELECT DISTINCT p.id FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE mup.fk_user_id = :user_id3 AND p.id = :project_id
                )",["user_id1" => Auth::getId(), "user_id2" => Auth::getId(), "user_id3" => Auth::getId(), ":project_id" => $actuallyProject->id]);
            }
            
            // GET ALL TASKS from company ------>>> DISABLED NOW
            // else{            
            //     $projectDetails = $projectDB->query("SELECT DISTINCT p.* FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE mup.fk_user_id = :user_id",
            //     ["user_id" => Auth::getId()]);
    
            //     // Megnezem a projekteket, amik a bejelentkezett Users-hez tartozik, majd le kerem a taskeket hozza
            //     $taskDetails = $taskDB->query("SELECT DISTINCT t.* FROM tasks as t INNER JOIN map_users_tasks as mut ON t.id = mut.fk_task_id WHERE createdBy_id = :user_id1 OR mut.fk_user_id = :user_id2 AND t.fk_project_id IN (
            //     SELECT DISTINCT p.id FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE mup.fk_user_id = :user_id3
            //     )",["user_id1" => Auth::getId(), "user_id2" => Auth::getId(), "user_id3" => Auth::getId()]);
            // }
        }


        $this->view("tasks", [
            'taskDetails' => $taskDetails,
            'projectTasksCategories' => $projectTasksCategories,
            'userDetails'=> $userDetails,
            'projectDetails' => $projectDetails,
            'actuallyProject' => $actuallyProject,
            'companyDetails' => $companyDetails,
            'errors' => $errors,
            'authId' => Auth::getId()
        ]);
    }
}