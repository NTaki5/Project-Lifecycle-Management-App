<?php

class Project extends Model
{

    public $allowedColumns = ["title","fk_status_id", "description", "priority", "start_date", "end_date", "fk_teamlead_id", "fk_company_id", "color", "slug"];

    // functions before insert the data in DB
    protected $beforeInsert = array();

    public function validate($data)
    {

        $this->errors = array();
        $return = true;
        $user = new User();
        if (!isset($data["title"]) || !preg_match("/^[\p{L}\p{N} ]+$/u", $data["title"])) {
            $this->errors["title"] = "You must specify the title and be careful not to contain any symbols";
            $return = false;
        }

        if (!empty($data["start_date"]) && $this->myCheckDate($data["start_date"])) {
            $this->errors["start_date"] = "Invalid date";
            $return = false;
        }

        if (!empty($data["end_date"]) && $this->myCheckDate($data["end_date"])) {
            $this->errors["end_date"] = "Invalid date";
            $return = false;
        }

        if (!isset($data["priority"]) && in_array(["low","medium","high"], $data["priority"])) {
            $this->errors["priority"] = "The selected priority does not exist";
            $return = false;
        }

        if (!isset($data["color"]) || !preg_match('/^#[0-9a-f]{6}$/i', $data["color"])) {
            $this->errors["color"] = "The selected color does not exist";
            $return = false;
        }

        if (empty($data["fk_teamlead_id"])) {
            $this->errors["fk_teamlead_id"] = "Please select the Team Leader";
            $return = false;
        }

        if (!empty($data["fk_teamlead_id"]) && $user->uniqueValue("id",$data["fk_teamlead_id"])) {
            $this->errors["fk_teamlead_id"] = "The selected user does not exist";
            $return = false;
        }

        // if(!isset($data["team_members"])){
        //     $this->errors["team_members"] = "Please select the Team members";
        //     $return = false;
        // }
        
        return $return;
    }

    public function getProjectsCards($projects, $status='all'){
        $returnString = '';
        $existElement = false;
        if(count($projects)){
            $existElement = true;
            foreach ($projects as $key => $value) {
                if($value->fk_company_id === Auth::getFk_company_id())
                    if($value->fk_status_id === $status || $status === 'all'){

                        $startDate = new DateTime();
                        $endDate = new DateTime($value->end_date);

                        $projectInterval = $endDate->diff($startDate);
                        $months = $projectInterval->m . " Months " . $projectInterval->d. " d";

                        $now = new DateTime('now');
                        $remainedDays = $now->diff($endDate);
                        $elapsedDays = $now->diff($startDate);

                        $percantege = ($elapsedDays->days * 100) / $projectInterval->days;

                        $returnString .= <<<DELIMETER
                        <div class="col-md-6 col-lg-4 entire-card">
                            <div class="card shadow">
                                <a href="projects/single/{$value->slug}">
                                    <div class="data-bg-color rounded-3 rounded-bottom-0 position-relative" style="--bg-color:{$value->color}">
                                        <div class="hstack gap-2 ms-4 justify-content-end me-3">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="ti ti-dots-vertical text-dark"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 26.4px, 0px);" data-popper-placement="bottom-end">
                                                    <a class="dropdown-item list-edit" href="projects/edit/{$value->slug}">Edit</a>
                                                    <a class="dropdown-item" name="delete-project" data-projectID="{$value->id}">Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <div class="card-body">
                                    <a href="projects/single/{$value->slug}">
                                        <h4 class="card-title">
                                            {$value->title}
                                        </h4>
                                    </a>
                                    <p class="mb-0 card-subtitle">
                                        {$value->description}
                                    </p>

                                    <div class="d-flex align-items-center my-3">
                                        <div class="row">
                                            <span class="d-flex align-items-center col-sm-6 mb-2">
                                                <i class="ti ti-paperclip me-1 fs-5"></i>
                                                5 Attach
                                            </span>
                                            <span class="d-flex align-items-center col-sm-6 mb-2">
                                                <i class="ti ti-calendar me-1 fs-5"></i>
                                                $months
                                                </a>
                                            </span>
                                            <span class="d-flex align-items-center col-sm-6 mb-2">
                                                <i class="ti ti-users me-1 fs-5"></i>
                                                {$value->membersCount} Members
                                            </span>
                                            <span class="d-flex align-items-center col-sm-6 mb-2">
                                                <i class="ti ti-message-circle me-1 fs-5"></i>
                                                10
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="sidebar-divider lg"></span>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <h6>Elapsed time:</h6>
                                        </div>
                                        <div class="col-sm-6 d-flex justify-content-end">
                                            <span class="mb-1 badge  bg-success-subtle text-success">$remainedDays->days days left</span>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar text-bg-danger" style="width: $percantege%; height: 6px" role="progressbar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
        DELIMETER;
                    }
        }
            
        }
        if(!$existElement)
            $returnString = "<h5>No projects found here</h5>";
        return $returnString;
    }

    public function getProjectStatus($statusID){
        
        $projectStatus = new Project();
        $projectStatus->table = "projects_status";
        $projectStatus->allowedColumns = ['id', 'name', 'priority', 'active'];

        return $projectStatus->where(['id', 'active'], [$statusID, 1]);

    }
    public function getAllStatus(){
        
        $projectStatus = new Project();
        $projectStatus->table = "projects_status";
        $projectStatus->allowedColumns = ['id', 'name', 'priority', 'active'];

        return $projectStatus->findAll("active = 1");

    }

}
