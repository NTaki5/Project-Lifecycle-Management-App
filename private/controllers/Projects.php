<?php

class Projects extends Controller
{

    private $errors = array();
    private $table;
    function index()
    {

        $this->view("projects", [
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
            $this->table = "map_users_projects";
            $projectUserMap = new Project();
            $projectUserMap->table = "map_users_projects";
            $projectUserMap->allowedColumns = ['fk_user_id', 'fk_project_id'];
            if ($project->validate($_POST)) {


                $projectSlug = $project->slugify($_POST['title']);
                $_POST['slug'] = $projectSlug;
                $_POST['status'] = $_POST['start_date'] > date('d-m-Y') ? 'ready' : 'started';

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

    public function single()
    {
        $this->view("team", []);
    }
}
