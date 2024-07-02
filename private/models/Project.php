<?php

class Project extends Model
{

    public $allowedColumns = ["title", "fk_status_id", "description", "priority", "start_date", "end_date", "fk_teamlead_id", "fk_company_id", "color", "slug"];

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

        if (!empty($data["start_date"]) && !$this->myCheckDate($data["start_date"])) {
            $this->errors["start_date"] = "Invalid date";
            $return = false;
        }
        if (!empty($data["end_date"]) && !$this->myCheckDate($data["end_date"])) {
            $this->errors["end_date"] = "Invalid date";
            $return = false;
        }

        if (!isset($data["priority"]) && in_array(["low", "medium", "high"], $data["priority"])) {
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

        if (!empty($data["fk_teamlead_id"]) && $user->uniqueValue("id", $data["fk_teamlead_id"])) {
            $this->errors["fk_teamlead_id"] = "The selected user does not exist";
            $return = false;
        }

        // if(!isset($data["team_members"])){
        //     $this->errors["team_members"] = "Please select the Team members";
        //     $return = false;
        // }

        return $return;
    }

    public function getProjectsCards($projects, $allStatus, $status = 'all')
    {
        $returnString = '';
        $existElement = false;
        if (count($projects)) {
            $existElement = true;
            $documents = new Document();
            $now = new DateTime('now');
            foreach ($projects as $key => $valueProject) {
                if ($valueProject->fk_company_id === Auth::getFk_company_id())
                    if ($valueProject->fk_status_id === $status || $status === 'all') {

                        $startDate = new DateTime($valueProject->start_date);
                        $endDate = new DateTime($valueProject->end_date);

                        $projectInterval = $endDate->diff($startDate);

                        $timeBoxClass = 'bg-danger-subtle text-danger';
                        $remainedDaysString = '<span class=" text-danger p-2 round rounded"> Times expired </span>';
                        $percantege = "100";

                        $remainedDays = $now->diff($endDate);
                        $elapsedDays = $now->diff($startDate);

                        if ($endDate >= $now) {
                            if ($remainedDays->d > 0) {
                                $timeBoxClass = 'bg-success-subtle text-success';
                                $remainedDays = $now->diff($endDate);
                                $remainedDaysString = strval($remainedDays->days + 1)  . " days left";
                                $percantege = $projectInterval->days > 0 ? ($elapsedDays->days * 100) / $projectInterval->days : 0;
                            }
                            if ($remainedDays->d == 0) {
                                $timeBoxClass = 'bg-warning-subtle text-warning';
                                $remainedDays = $now->diff($endDate);
                                $remainedDaysString = "Last day";
                                $percantege = $projectInterval->days > 0 ? ($elapsedDays->days * 100) / $projectInterval->days : 0;
                            }
                        }
                        $documentsQuery = $documents->where('fk_project_id', $valueProject->id);
                        $documentsCount = count($documentsQuery) ? count($documentsQuery) . ' Attach' : 'No files';

                        $percantege = $projectInterval->days > 0 ? ($elapsedDays->days * 100) / $projectInterval->days : 0;

                        $statuses = "";
                        $thisProjectStatus = "No status";
                        $thisProjectStatusColorRGBA = "";
                        $thisProjectStatusColorRGB = "";
                        foreach ($allStatus as $key => $valueStatus) {
                            if ($valueStatus->id == $valueProject->fk_status_id) {
                                $thisProjectStatus = ucfirst($valueStatus->name);
                                $thisProjectStatusColorRGBA = hex2rgba($valueStatus->color, 0.2);
                                $thisProjectStatusColorRGB = hex2rgba($valueStatus->color);
                            } else
                                $statuses .= '<a class="dropdown-item" href="projects/single/' . $valueProject->slug . '?update-status&status-id=' . $valueStatus->id . '&allprojects">' . ucfirst($valueStatus->name) . '</a>';
                        }
                        if (!strlen($statuses)) {
                            $statuses = "No status available";
                        }

                        $returnString .= <<<DELIMETER
                        <div class="col-md-6 col-lg-4 entire-card">
                            <div class="card shadow h-100">
                                    <div class="data-bg-color rounded-3 rounded-bottom-0 position-relative" style="--bg-color:{$valueProject->color}">
                                        <div class="hstack gap-2 ms-4 justify-content-end me-3">
                                    
                                            <div class="dropdown">
                                                <a class="" href="javascript:void(0)" role="button" id="dropdownMenuLink-2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    <i class="ti ti-dots-vertical text-dark"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-2" style="position: absolute; inset: 0px 0px auto; margin: 0px; transform: translate3d(0px, 26.4px, 0px);" data-popper-placement="bottom-end">
                                                    <a class="dropdown-item list-edit" href="projects/edit/{$valueProject->slug}?backto-all-projects">Edit</a>
                                                    <a class="dropdown-item" name="delete-project" data-projectID="{$valueProject->id}">Delete</a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="mb-1 badge text-success" style="background-color:$thisProjectStatusColorRGBA;">
                                            <div class="dropdown">
                                                <a class="dropdown-toggle" style="color:$thisProjectStatusColorRGB" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                    $thisProjectStatus
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1" style="position: absolute; inset: 0px 0px auto; margin: 0px; transform: translate3d(0px, 26.4px, 0px);" data-popper-placement="bottom-end">
                                                        $statuses
                                                </div>
                                            </div>
                                        </span>
                                        <a href="projects/single/{$valueProject->slug}">
                                            <h4 class="card-title">
                                                {$valueProject->title}
                                            </h4>
                                        </a>
                                    </div>
                                    <p class="mb-0 card-subtitle">
                                        {$valueProject->description}
                                    </p>

                                    <div>
                                        <div class="d-flex align-items-center my-3">
                                            <div class="row w-100">
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-paperclip me-1 fs-5"></i>
                                                    $documentsCount
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2 text-nowrap">
                                                    <i class="ti ti-users me-1 fs-5"></i>
                                                    {$valueProject->membersCount} Members
                                                </span>
                                            </div>
                                        </div>
                                        <span class="sidebar-divider lg"></span>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h6>Time:</h6>
                                            </div>
                                            <div class="col-sm-6 d-flex justify-content-end">
                                                <span class="mb-1 badge $timeBoxClass">$remainedDaysString</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar text-bg-danger" style="width: $percantege%; height: 6px" role="progressbar"></div>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
        DELIMETER;
                    }
            }
        }
        if (!$existElement)
            $returnString = "<h5>No projects found here</h5>";
        // return $projects;
        return $returnString;
    }

    public function getProjectStatus($statusID)
    {

        $this->table = "projects_status";
        $this->allowedColumns = ['id', 'name', 'priority', 'active'];

        return $this->where(['id', 'active'], [$statusID, 1]);
    }
    public function getAllStatus()
    {

        $this->table = "projects_status";
        $this->allowedColumns = ['id', 'name', 'priority', 'active', 'color'];

        return $this->findAll("active = 1", "priority ASC");
    }

    public function getAllStatusForTableDisplay()
    {

        // $this = new Project();
        $this->table = "projects_status";
        $this->allowedColumns = ['id', 'name', 'priority', 'active', 'color'];

        $projectStatusQuery = $this->findAll(orderby: 'priority ASC');
        $returnTableRows = "";
        foreach ($projectStatusQuery as $key => $value) {
            $activeString = $value->active ? "Yes" : "No";
            $name = ucfirst($value->name);
            $returnTableRows .= <<<DELIMETER
            <tr class="search-items">
                <td>
                    <div class="user-meta-info">
                        <h6 class="user-name mb-0" data-name="{$name}">{$name}</h6>
                    </div>
                </td>
                <td>
                    <span class="status-color" data-color="{$value->color}">
                        <input type="color" name="color" value="{$value->color}" disabled="">
                    </span>
                </td>
                <td>
                    <span class="status-priority" data-priority="{$value->priority}">{$value->priority}</span>
                </td>
                <td>
                    <span class="status-active" data-active="$activeString">$activeString</span>
                </td>
                <td>
                    <div class="action-btn">
                        <a href="javascript:void(0)" class="text-primary edit">
                            <i class="ti ti-eye fs-5"></i>
                        </a>
                        <a href="javascript:void(0)" class="text-dark delete ms-2">
                            <i class="ti ti-trash fs-5"></i>
                        </a>
                    </div>
                </td>
                <td class="d-none position-absolute">
                    <input hidden id="statusid" name="statusId" value="{$value->id}"/>
                </td>
            </tr>
DELIMETER;
        }
        return $returnTableRows;
    }

    public function addStatus($data)
    {

        $this->table = "projects_status";
        $this->allowedColumns = ['id', 'name', 'priority', 'active', 'color'];

        return $this->insert($data);
    }

    public function updateStatus($statusID, $data)
    {

        $this->table = "projects_status";
        $this->allowedColumns = ['id', 'name', 'priority', 'active', 'color'];

        return $this->update($statusID, $data);
    }
}
