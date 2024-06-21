<?php

class Projects extends Controller
{

    private $errors = array();
    private $table;
    function index()
    {

        $user = new User();

        $projectDB = new Project();

        $projectUserMap = new Project();
        $projectUserMap->table = "map_users_projects";
        
        $statusDB = new Project();
        $statusDB->table = "projects_status";

        $status = $statusDB->findAll();
        $projects = array();

        if(Auth::getRole() === 'admin'){

            $projects = $projectDB->query("SELECT p.*, count(mup.fk_user_id) as membersCount FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE p.fk_company_id = :company_id GROUP BY p.id",["company_id" => Auth::getFk_company_id()]);
           
        }

        if(Auth::getRole() === 'employee' || Auth::getRole() === 'client'){

                $projects = $projectDB->query("SELECT p.*, count(mup.fk_user_id) as membersCount FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE mup.fk_user_id = :user_id GROUP BY p.id",["user_id" => Auth::getId()]);

        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (count($_POST)) {
                if (isset($_POST['delete-project'])) {
                    $feedDB = new Feed();
                    $feeds = $feedDB->where('fk_project_id', $_POST["projectID"]);
                    $feedUserLikesMap = new Feed();
                    $feedUserLikesMap->table = "map_feed_user_likes";
                    $taskDB = new Task();
                    $tasks = $taskDB->where('fk_project_id', $_POST["projectID"]);
                    $taskUserMap = new Task();
                    $taskUserMap->table = "map_users_tasks";
                    $documentDB = new Document();
                    $documents = $documentDB->where('fk_project_id', $_POST["projectID"]);
                    $commentDB = new Comment();
                    $invitationDB = new Invitation();

                    if (($projectDB->delete($_POST["projectID"], "id") !== null) && 
                    ($projectUserMap->delete($_POST["projectID"], "fk_project_id") !== null) &&
                    ($feedDB->delete($_POST["projectID"], "fk_project_id") !== null)&&
                    ($documentDB->delete($_POST["projectID"], "fk_project_id") !== null)&&
                    ($invitationDB->delete($_POST["projectID"], "fk_project_id") !== null)&&
                    ($taskDB->delete($_POST["projectID"], "fk_project_id") == null)){

                        // Delete the files uploaded to the deleted project
                        foreach ($documents as $key => $value) {
                            if(str_contains($value->type, 'image'))
                                unlink('uploads/feed/images/' . $value->name);
                            else
                                unlink('uploads/feed/documents/' . $value->name);
                        }

                        foreach ($feeds as $key => $value) {
                            $commentDB->delete($value->id, 'fk_feed_id');
                            $feedUserLikesMap->delete($value->id, 'fk_feed_id');
                        }

                        foreach ($tasks as $key => $value) {
                            $taskUserMap->delete($value->id, "fk_task_id");
                        }
                    }else{
                        echo "Error at delete";
                    }
                    exit();
                }
            }
        }

        $this->view("projects", [
            'projectClass' => $projectDB,
            'projects' => $projects,
            'status'=>$status,
            "errors" => $this->errors
        ]);
    }

    public function create()
    {

        if (Auth::getRole() !== 'admin' && Auth::getRole() !== 'employee') {
            $this->redirect("home");
            exit();
        }
        $user = new User();
        $teamMembers = $user->where('fk_company_id', Auth::getFk_company_id());
        $teamMembersRow = "";
        foreach ($teamMembers as $key => $value) {
            $teamMembersRow .= '<option value="' . $teamMembers[$key]->id . '">' . $teamMembers[$key]->name . '</option>';
        }
        
        if (isset($_POST["creat-project"])) {

            $project = new Project();

            $projectUserMap = new Project();
            $projectUserMap->table = "map_users_projects";
            $projectUserMap->allowedColumns = ['fk_user_id', 'fk_project_id'];

            $projectStatus = new Project();
            $projectStatus->table = "projects_status";
            $projectStatus->allowedColumns = ['id', 'name', 'priority', 'active'];
            if ($project->validate($_POST)) {


                $projectSlug = $project->slugify($_POST['title']);
                $_POST['slug'] = $projectSlug;
                $_POST['fk_company_id'] = Auth::getFk_company_id();

                if(!count($projectStatus->where('id', 1)))
                $projectStatus->insert(['id' => 1, 'name' => 'ready', 'priority' => 9999, 'active' => 1]);

                $_POST['fk_status_id'] = 1;
                if(!strlen($_POST['start_date']))
                    $_POST['start_date'] = date('Y-m-d');
                if(!strlen($_POST['end_date']))
                    $_POST['end_date'] = date('Y-m-d' ,strtotime('+7 days'));

                new Toast("The project was successfully created", "");
                if (count($project->insert($_POST)))
                    new Toast("The project could not be created", "Try again later");

                foreach ($_POST['team_members'] as $key => $value) {

                    $projectId = $project->where('slug', $projectSlug)[0]->id;

                    $boolInsert = count($projectUserMap->insert([
                        'fk_user_id' => $value,
                        'fk_project_id' => $projectId
                    ]));

                    if ($boolInsert) {
                        new Toast("The project could not be created", "Try again later");
                        $project->delete($projectId);
                        $projectUserMap->delete($projectId, 'fk_project_id');
                    }
                }
                $this->redirect("projects");
                exit();
            }
            $this->errors = $project->errors;
        }
        $this->view("project-create", [
            'errors' => $this->errors,
            'teamMembers' => $teamMembersRow
        ]);
    }

    public function single($slug)
    {

        if(!isset($slug)){
            new Toast("The project doesn't exist!");
            $this->redirect('projects');
        }
        $user = new User();
        $projectDB = new Project();
        $projectDetails = $projectDB->where('slug', $slug)[0];
        if($projectDetails === null){
            new Toast("The project doesn't exist!");
            $this->redirect('projects');
        }

        $projectUserMap = new Project();
        $projectUserMap->table = "map_users_projects";
        $projectUserMap->allowedColumns = ['fk_user_id', 'fk_project_id'];

        $feedDB = new Feed();
        $feedDetails = count($feedDB->where('fk_project_id', $projectDetails->id))? $feedDB->where('fk_project_id', $projectDetails->id) : [];

        $feedLikes = new Feed();
        $feedLikes->table = "map_feed_user_likes";
        $feedLikes->allowedColumns = ["fk_user_id", "fk_feed_id"];

        $comment = new Comment();
        
        $commentLikes = new Comment();
        $commentLikes->table = "map_comment_user_likes";
        $commentLikes->allowedColumns = ["fk_user_id", "fk_comment_id"];

        $authUserCommentLikes = $commentLikes->where('fk_user_id', Auth::getId());
        $authUserCommentLikesIDS = array_map(function ($obj){
            return $obj->fk_comment_id;
        }, $authUserCommentLikes);

        $authUserFeedLikes = $feedLikes->where('fk_user_id', Auth::getId());
        $authUserFeedLikesIDS = array_map(function ($obj){
            return $obj->fk_feed_id;
        }, $authUserFeedLikes);

        $documentDB = new Document();
        $documentDetails = count($documentDB->where('fk_project_id', $projectDetails->id))? $documentDB->where('fk_project_id', $projectDetails->id) : [];
    

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // AJAX POST CALL
            if(isset($_POST['send-invitation'])){
                $email = $_POST['email'];

                $token = generateToken();
                $sendeEmail = new SendEmail();
                $invitations = new Invitation();
                $projectID = $projectDetails->id;

                try {

                    if(!$invitations->uniqueValue('email', $email)){
                        new Toast("We have already sent an invitation to this email address.", 999);
                        echo "Fail invitation sent";
                        exit();
                    }
                    

                    $emailSubject = "CMS Invitation";
                    $emailBody = 'Hello! You have been invited to the ' . Auth::getCompanyName() . ' company. <br>
                    Please confirm your account with this link: <a href="'. ROOT . '/signup?token=' . $token . '">'
                    . ROOT . '/signup?token=' . $token;
                    $altBody = 'Hello! You have been invited to the ' . Auth::getCompanyName() . ' company.';

                $sendeEmail->mySend($email,"", $emailSubject, $emailBody, $altBody);
                    
                    // Here the e-mail has been sent
                    
                    $invitations->insert([
                        "fk_company_id" => Auth::getFk_company_id(),
                        "fk_project_id" => $projectID,
                        "email" => $email,
                        "token" => $token,
                        "expires_at" => date('Y-m-d H:i:s',time() + (48 * 60 * 60)),
                        "user_role" => "client"
                    ]);
                    time();
                    Toast::setToast("Invitation has been sent", "");
                    echo "Success";
                    // Send a custom error response
                    // header('Content-Type: application/json');
                    // get a HTML string from Toast::show("show toast-onload") only if the toast is seted $_SESSION['show-toast']
                    // echo json_encode(['value' => Toast::show("show toast-onload")]);
                } catch (Exception $e) {
                    // if you want to display email error message:  "Mailer Error: {$mail->ErrorInfo}"
                    if((int)$e->getCode() == (int)999){
                        Toast::setToast($e->getMessage());
                    }else{
                        Toast::setToast("The invitation could not be sent.", "Try later.");
                    }
                    echo "Invitation sent";
                    // Send a custom error response
                    header('Content-Type: application/json');
                    http_response_code(400); // Set a 4xx or 5xx status code
                    // echo json_encode(['value' => Toast::show("show toast-onload"), 'code' => 999]);
                    echo json_encode(['value' => $e, 'code' => 999]);
                }
                exit();
            }
            // AJAX POST CALL
            if(isset($_POST['update-members'])){
                try{

                    $projectID = $projectDetails->id;
                    $teamMembersArr = $_POST['teamMembersArr'];
                    if (count($row = $projectUserMap->where(["fk_project_id"],[$projectID]))){
                        foreach ($row as $key => $mapRow) {
                            if($user->where('id', $mapRow->fk_user_id)[0]->role != 'client')
                                $projectUserMap->delete($mapRow->id);
                        }
                    }
                    foreach ($teamMembersArr as $key => $value) {

                        $projectUserMap ->insert([
                            'fk_user_id' => $value,
                            'fk_project_id' => $projectID
                        ]);

                    }
                    new Toast("Project team was updated!");
                } catch (Exception $e) {
                    // if you want to display email error message:  "Mailer Error: {$mail->ErrorInfo}"
                    if((int)$e->getCode() == (int)999){
                        Toast::setToast($e->getMessage());
                    }else{
                        Toast::setToast("Member could not be added.", "Try later.");
                    }
                    echo "Invitation sent";
                    // Send a custom error response
                    header('Content-Type: application/json');
                    http_response_code(400); // Set a 4xx or 5xx status code
                    // echo json_encode(['value' => Toast::show("show toast-onload"), 'code' => 999]);
                    echo json_encode(['value' => $e, 'code' => 999]);
                }
                exit();
            }

            if(isset($_POST['add-feed'])){
                $feed = new Feed();

                if(!isset($_POST)){
                    new Toast("Not found POST datas");
                    exit();
                }

                $_POST['message'] = htmlspecialchars($_POST['message']);
                $_POST['fk_parent_id'] = -1;
                $_POST['fk_user_id'] = Auth::getId();
                $_POST['fk_project_id'] = $projectDetails->id;
                $_POST['fk_company_id'] = Auth::getFk_company_id();

                if(count($feed->insert($_POST))){
                    new Toast("The feed could not be posted");
                    exit();
                }
                $lastFeedID = $feed->last_inserted_id();
                $_POST['fk_feed_id'] = $lastFeedID;

                if(strlen($_FILES['file_name']['tmp_name'])){
                    if (!file_exists('uploads/feed/documents')) {
                        // If not, create the directory
                        mkdir('uploads/feed/documents', 0777, true);
                    }
                    $fileName = $_FILES['file_name']['name'];
                    $fileType = $_FILES['file_name']['type'];
                    copy($_FILES['file_name']['tmp_name'], 'uploads/feed/documents' . DIRECTORY_SEPARATOR . $_FILES['file_name']['name']);
                }
                if(strlen($_FILES['image_name']['tmp_name'])){
                    if (!file_exists('uploads/feed/images')) {
                        // If not, create the directory
                        mkdir('uploads/feed/images', 0777, true);
                    }
                    $fileName = isset($_FILES['image_name']) ? add_webp_image('uploads/feed/images',$_FILES['image_name']['name'], $_FILES['image_name']['tmp_name']):"";

                    $fileType = $_FILES['image_name']['type'];
                }


                if(isset($fileName)){
                    $_POST['name'] = $fileName;
                    $_POST['type'] = $fileType;

                    $document = new Document();
                    if(count($document->insert($_POST))){
                        new Toast("The feed could not be posted");
                        $feed->delete($lastFeedID);
                        exit();
                    }
                }

                new Toast("The feed was successfully posted");
                $this->redirect('projects/single/'. $slug);
            }

            if(isset($_POST['add-comment'])){

                if(!isset($_POST)){
                    new Toast("Not found POST datas");
                    exit();
                }

                $_POST['comment'] = htmlspecialchars($_POST['commentText']);
                $_POST['fk_user_id'] = Auth::getId();
                // $_POST['fk_feed_id'] = $_POST['feedID'];
                // $_POST['fk_comment_id'] = $_POST['commentID'];

                if(count($comment->insert($_POST))){    
                    new Toast("The comment could not be posted");
                    exit();
                }
                if(isset($_POST['returnForAjaxRequest'])){
                    echo json_encode(['userImage' => Auth::getImage(), 'userName' => Auth::getName()]);
                    exit();
                }

                // else
                $this->redirect('projects/single/'. $slug);
            }

            if(isset($_POST['update-comment-likes'])){

                if(!isset($_POST)){
                    new Toast("Not found POST datas");
                    exit();
                }


                $likesNumber = $comment->where('id', $_POST['fk_comment_id'])[0]->likes;
                $increaseLikes = false;

                // Update the likes number, if the user not liked the post until now ELSE decrease the likes number
                if(count($commentLikes->where(['fk_comment_id','fk_user_id'], [$_POST['fk_comment_id'],Auth::getId()]))){    
                    $likesNumber -= 1;
                    if(count($commentLikes->delete($_POST['fk_comment_id'], 'fk_comment_id'))){    
                        new Toast("The comment could not be posted");
                        exit();
                    }
                    if(count($comment->update($_POST['fk_comment_id'], ['likes' => $likesNumber]))){    
                        new Toast("The comment could not be posted");
                        exit();
                    }
                }else{
                    $likesNumber += 1;
                    $increaseLikes = true;
                    if(count($comment->update($_POST['fk_comment_id'], ['likes' => $likesNumber]))){    
                        new Toast("The comment could not be posted");
                        exit();
                    }
                    if(count($commentLikes->insert(['fk_comment_id' => $_POST['fk_comment_id'], 'fk_user_id' => Auth::getId()]))){    
                        new Toast("The comment could not be posted");
                        exit();
                    }
                }
                // Auth::setLikedComments($_POST['fk_comment_id']);
                
                if(isset($_POST['returnForAjaxRequest'])){
                    
                    echo json_encode(['likesNumber' => $likesNumber, 'increaseLikes' => $increaseLikes]);
                    exit();
                }

                // else
                $this->redirect('projects/single/'. $slug);
            }

            if(isset($_POST['update-feed-likes'])){

                if(!isset($_POST)){
                    new Toast("Not found POST datas");
                    exit();
                }


                $likesNumber = $feedDB->where('id', $_POST['fk_feed_id'])[0]->likes;
                $increaseLikes = false;

                // Increase the likes number, if the user not liked the post until now ELSE decrease the likes number
                if(count($feedLikes->where(['fk_feed_id','fk_user_id'], [$_POST['fk_feed_id'],Auth::getId()]))){  
                    $likesNumber -= 1;
                    if(count($feedLikes->delete($_POST['fk_feed_id'], 'fk_feed_id'))){    
                        new Toast("The feed could not be posted");
                        exit();
                    }
                    if(count($feedDB->update($_POST['fk_feed_id'], ['likes' => $likesNumber]))){    
                        new Toast("The feed could not be posted");
                        exit();
                    }
                }else{
                    $likesNumber += 1;
                    $increaseLikes = true;
                    if(count($feedDB->update($_POST['fk_feed_id'], ['likes' => $likesNumber]))){    
                        new Toast("The feed could not be posted");
                        exit();
                    }
                    if(count($feedLikes->insert(['fk_feed_id' => $_POST['fk_feed_id'], 'fk_user_id' => Auth::getId()]))){    
                        new Toast("The feed could not be posted");
                        exit();
                    }
                }
                // Auth::setLikedfeeds($_POST['fk_feed_id']);
                
                if(isset($_POST['returnForAjaxRequest'])){
                    
                    echo json_encode(['likesNumber' => $likesNumber, 'increaseLikes' => $increaseLikes]);
                    exit();
                }

                // else
                $this->redirect('projects/single/'. $slug);
            }
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            if(isset($_GET['update-status'])){

                $projectDB->update($projectDetails->id, ['fk_status_id' => $_GET['status-id']] );
                new Toast('Project status saved!');
            }
        }


        // I'm asking for the user's details, because after POST and GET requests the user's details may change.
        $projectDetails = $projectDB->where('slug', $slug)[0];

        $projectStatus = $projectDB->getProjectStatus($projectDetails->fk_status_id);
        $allStatus = $projectDB->getAllStatus();
    
        $teamLead = !empty($user->where('id',$projectDetails->fk_teamlead_id))? $user->where('id',$projectDetails->fk_teamlead_id)[0] : array();
        
        // This is for progress bar
        $startDate = new DateTime($projectDetails->start_date);
        $endDate = new DateTime($projectDetails->end_date);
        $now = new DateTime('now');
        
        $projectInterval = $endDate->diff($startDate);
        $months = $projectInterval->m . " Months " . $projectInterval->d. " d";

        $elapsedDays = $now->diff($startDate);
        $elapsedDaysString = $endDate > $now ? "Elapsed time ".$elapsedDays->days . " Days " . $elapsedDays->h. " h" : "Time expired";

        $progressPercantege = round(($elapsedDays->days * 100) / $projectInterval->days, 2);
        $projectInterval = $endDate->diff($startDate);

        // GET the company members;
        $companyMembers = $user->where('fk_company_id', Auth::getFk_company_id());

        $projectTeam = $projectUserMap->where('fk_project_id', $projectDetails->id);

        $projectWorkersRow = "";

        $teamIDS = array_map(function($obj){
            return $obj->fk_user_id;
        }
        ,$projectTeam);

        $companyMembersIDS = array_map(function($obj){
            return $obj->id;
        }
        ,$companyMembers);

        // $uniqueIds1 = array_diff($teamIDS, $companyMembersIDS);
        // $uniqueIds2 = array_diff($companyMembersIDS, $teamIDS);  
        $projectWorkers = array_merge($teamIDS, $companyMembersIDS);
        $projectWorkers = array_unique($projectWorkers);
        
        foreach ($projectWorkers as $key => $value) {
            if($user->where('id', $value)[0]->role !== 'client'){
                $selected = '';
                if(in_array($value,$teamIDS))
                {
                    $selected = 'selected';
                }
                $projectWorkersRow .= '<option value="' . $value . '" '.$selected.'>' . $user->where('id', $value)[0]->name . '</option>';
            }
        }

        $teamMembers = array();
        foreach ($teamIDS as $key => $value) {
            array_push($teamMembers, $user->where('id', $value)[0]);
        }

        $this->view("project", [
            'teamMembers' => $teamMembers,
            'projectWorkers' => $projectWorkersRow,
            'progressPercantege'=>$progressPercantege,
            'months' => $months,
            'elapsedDays' => $elapsedDaysString,
            'teamLead' => $teamLead,
            'projectDetails' => $projectDetails,
            'feedDetails' => $feedDetails,
            'authUserCommentLikesIDS' => $authUserCommentLikesIDS,
            'authUserFeedLikesIDS' => $authUserFeedLikesIDS,
            'documentDetails' => $documentDetails,
            'slug' => $slug,
            'projectStatus' => $projectStatus,
            'allStatus' => $allStatus
        ]);
    }

    public function edit($slug)
    {

        $projectDB = new Project();
        $projectDetails = $projectDB->where('slug', $slug)[0];

        $user = new User();
        $companyMembers = $user->where('fk_company_id', Auth::getFk_company_id());
        $teamLeaderRow = "";
        foreach ($companyMembers as $key => $value) {
            $selected = $companyMembers[$key]->id == $projectDetails->fk_teamlead_id ? "selected" : "";
            $teamLeaderRow .= '<option value="' . $companyMembers[$key]->id . '" '.$selected.'>' . $companyMembers[$key]->name . '</option>';
        }

        
        $projectUserMap = new Project();
        $projectUserMap->table = "map_users_projects";
        $projectTeam = $projectUserMap->where('fk_project_id', $projectDetails->id);
        $teamMembersRow = "";
        foreach ($companyMembers as $keyCompany => $valueCompany) {
            $selected = "";
            foreach ($projectTeam as $keyTeam => $valueTeam) {
                if($projectTeam[$keyTeam]->fk_user_id == $companyMembers[$keyCompany]->id){
                    $selected =  "selected";
                    continue;
                }
            }
            $teamMembersRow .= '<option value="' . $companyMembers[$keyCompany]->id . '" '.$selected.'>' . $companyMembers[$keyCompany]->name . '</option>';

        }

        if(isset($_POST['edit-project'])){

            $project = new Project();

            $projectUserMap = new Project();
            $projectUserMap->table = "map_users_projects";
            $projectUserMap->allowedColumns = ['fk_user_id', 'fk_project_id'];

            $projectStatus = new Project();
            $projectStatus->table = "projects_status";
            $projectStatus->allowedColumns = ['id', 'name', 'priority', 'active'];

            if ($project->validate($_POST)) {

                $projectId = $project->where('slug', $slug)[0]->id;

                // if(!count($projectStatus->where('id', 1)))
                //     $projectStatus->insert(['id' => 1, 'name' => 'ready', 'priority' => 9999, 'active' => 1]);

                // $_POST['fk_status_id'] = 1;

                new Toast("The project was successfully saved", "");
                if (count($project->update($projectId, $_POST)))
                    new Toast("The project could not be saved", "Try again later");

                $projectUserMap->delete($projectId,'fk_project_id');
                foreach ($_POST['team_members'] as $key => $value) {

                    $boolInsert = count($projectUserMap->insert([
                        'fk_user_id' => $value,
                        'fk_project_id' => $projectId
                    ]));

                    if ($boolInsert) {
                        new Toast("The project could not be saved", "Try again later");
                        $project->delete($projectId);
                        $projectUserMap->delete($projectId, 'fk_project_id');
                    }
                }
                $this->redirect("projects/single/" . $slug);
                exit();
            }

            $this->errors = $project->errors;
        }


        $this->view("project-edit",[
            'errors' => $this->errors,
            'projectDetails' => $projectDetails,
            'teamLeaderRow' => $teamLeaderRow,
            'teamMembersRow' => $teamMembersRow
        ]);
        
    }

    // ALL projects from the company
    public function getAdminProjects(){
        $authProjects = array();
        $projects = new Project();
        if(count($authProjects = $projects->query("SELECT DISTINCT p.* FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE p.fk_company_id = :company_id",["company_id" => Auth::getFk_company_id()])));
            return $authProjects;
    
    }
    public function getAuthProjects(){
        $authProjects = array();
        $projects = new Project();
        if(count($authProjects = $projects->query("SELECT DISTINCT p.* FROM projects as p INNER JOIN map_users_projects as mup ON p.id = mup.fk_project_id WHERE mup.fk_user_id = :user_id AND p.fk_company_id = :company_id",["user_id" => Auth::getId(), "company_id" => Auth::getFk_company_id()])));
            return $authProjects;
    }
}
