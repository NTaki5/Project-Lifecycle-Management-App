<?php
$this->view("/includes/header");
?>
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-md-0 card-title">Kanban</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="main/index.html">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Kanban
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="action-btn layout-top-spacing mb-7 d-flex align-items-center justify-content-between flex-wrap gap-6">
        <h5 class="mb-0 fs-5"><?=$actuallyProject->title?></h5>
        <?php if(Auth::getRole() === 'admin' || Auth::getRole() === 'employee'):?>
            <button id="add-list" class="btn btn-primary">Add List</button>
        <?php endif;?>
    </div>
    <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="add-task-title modal-title" id="addTaskModalTitleLabel1">Add Task</h5>
                    <h5 class="edit-task-title modal-title" id="addTaskModalTitleLabel2">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="compose-box">
                        <div class="compose-content" id="addTaskModalTitle">
                            <div class="addTaskAccordion" id="add_task_accordion">
                                <div class="task-content task-text-progress">
                                    <div id="collapseTwo" class="collapse show" data-parent="#add_task_accordion">
                                        <div class="task-content-body">
                                            <form action="javascript:void(0);">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="task-title mb-4 d-flex">
                                                            <input id="kanban-title" type="text" placeholder="Task" class="form-control" name="task">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="task-badge d-flex">
                                                            <textarea id="kanban-text" placeholder="Task Text" class="form-control" rows="5" name="taskText"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="task-badge">
                                                            <label class="mr-sm-2" for="projectSelect">Project</label>
                                                            <select class="form-select form-control mr-sm-2" id="projectSelect" name="projectSelect">
                                                                <option value="">Choose ...</option>
                                                                <?php 
                                                                foreach ($projectDetails as $item) {
                                                                    echo '<option value="'. $item->id .'">'. $item->title .'</option>';
                                                                } 
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="task-badge">
                                                            <label class="mr-sm-2" for="teamSelect">Assignement</label>
                                                            <select class="form-select form-control mr-sm-2" multiple="multiple" id="teamSelect" name="teamSelect[]">
                                                                <option value="">Choose ...</option>
                                                                <?php 
                                                                foreach ($userDetails as $item) {
                                                                    echo '<option value="'. $item->id .'">'. $item->name .'</option>';
                                                                } 
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <div class="d-flex gap-6">
                        <button data-btn-action="addTask" class="btn add-tsk btn-primary">Add Task</button>
                        <button data-btn-action="editTask" class="btn edit-tsk btn-success">Save</button>
                        <button class="btn bg-danger-subtle text-danger d-flex align-items-center gap-1" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addListModal" tabindex="-1" role="dialog" aria-labelledby="addListModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title add-list-title" id="addListModalTitleLabel1">Add List</h5>
                    <h5 class="modal-title edit-list-title" id="addListModalTitleLabel2">Edit List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="compose-box">
                        <div class="compose-content" id="addListModalTitle">
                            <form action="javascript:void(0);">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="list-title d-flex align-items-center">
                                            <input id="item-name" type="text" placeholder="List Name" class="form-control" name="task">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <div class="d-flex gap-6">
                        <button class="btn bg-danger-subtle text-danger d-flex align-items-center gap-1" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn add-list btn-primary">Add List</button>
                        <button class="btn edit-list btn-success">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scrumboard" id="cancel-row">
        <div class="layout-spacing pb-3">
            <div data-simplebar>
                <div class="task-list-section">
                    <?php 
                    foreach ($projectTasksCategories as $key => $taskCategoryValue) {
                        

                        $taskCatName = ucfirst($taskCategoryValue->name);
                        $taskCatNameNospace = str_replace(" ", "", $taskCategoryValue->name);
                        echo <<<DELIMETER
                        <div data-item="item-{$taskCatNameNospace}" data-taskCategory-id="{$taskCategoryValue->id}" class="task-list-container" data-action="sorting">
                            <div class="connect-sorting connect-sorting-{$taskCatNameNospace}">
                                <div class="task-container-header">
                                    <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="$taskCatName">$taskCatName</h6>
                                    <div class="hstack gap-2">
                                        <div class="add-kanban-title">
                                            <a class="addTask d-flex align-items-center justify-content-center gap-1 lh-sm" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add Task">
                                                <i class="ti ti-plus text-dark"></i>
                                            </a>
                                        </div>
DELIMETER;
                        if(Auth::getRole() === 'admin' || Auth::getRole() === 'employee')
                        echo <<<DELIMETER
                                        <div class="dropdown">
                                            <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                <i class="ti ti-dots-vertical text-dark"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1">
                                                <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                                <a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>
                                                <a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>
                                            </div>
                                        </div>
DELIMETER;
                        echo <<<DELIMETER
                                        </div>
                                    </div>
                                <div class="connect-sorting-content" data-sortable="true">
DELIMETER;

                                foreach ($taskDetails as $key => $taskValue) {
                                    $createdDate = date('d M y', strtotime($taskValue->date));
                                    $projectName = "";
                                    $project = new Project();
                                    $projectName = $project->where('id', $taskValue->fk_project_id)[0]->title;
                                    $projectColor = $project->where('id', $taskValue->fk_project_id)[0]->color;

                                    if($taskValue->fk_category_id === $taskCategoryValue->id)
                                    echo <<<DELIMETER
                                    <div data-draggable="true" class="card img-task">
                                    <div data-task-id="$taskValue->id" class="d-none"></div>
                                        <div class="card-body">
                                            <div class="task-header">
                                                <div>
                                                    <h4 data-item-title="$taskValue->title">
                                                    $taskValue->title</h4>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <i class="ti ti-dots-vertical text-dark"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1">
                                                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                            <i class="ti ti-pencil fs-5"></i>Edit
                                                        </a>
                                                        <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                            <i class="ti ti-trash fs-5"></i>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-content">
                                                <div class="mb-0" data-item-text="$taskValue->description">
                                                    $taskValue->description
                                                </div>
                                            </div>
                                            <div class="task-body">
                                                <div class="task-bottom flex-wrap-reverse gap-2">
                                                    <div class="tb-section-1">
                                                        <span class="hstack gap-2 fs-2" data-item-date="$createdDate">
                                                            <i class="ti ti-calendar fs-5"></i> $createdDate
                                                        </span>
                                                    </div>
                                                    <div class="tb-section-2">
                                                        <span class="badge fs-1 text-wrap" style="background-color:$projectColor!important;">$projectName</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
DELIMETER;
                                }

                        echo <<<DELIMETER
                              </div>
                        </div>
                    </div>
DELIMETER;
                        
                    }
                    
                    ?>

                                <?php 
                                
                                    
                                
                                ?>


                    <!-- <div data-item="item-inprogress" class="task-list-container" data-action="sorting">
                        <div class="connect-sorting connect-sorting-inprogress">
                            <div class="task-container-header">
                                <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="In Progress">In Progress</h6>
                                <div class="hstack gap-2">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="ti ti-dots-vertical text-dark"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1">
                                            <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                            <a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>
                                            <a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="connect-sorting-content" data-sortable="true">
                            <?php 
                                
                                foreach ($taskDetails as $key => $taskValue) {
                                    $createdDate = date('d M y', strtotime($taskValue->date));
                                    $projectName = "";

                                    $project = new Project();
                                    $projectName = $project->where('id', $taskValue->fk_project_id)[0]->title;
                                    $projectColor = $project->where('id', $taskValue->fk_project_id)[0]->color;

                                    if($taskValue->status === 'inprogress')
                                    echo <<<DELIMETER
                                    <div data-draggable="true" class="card img-task">
                                    <div data-task-id="$taskValue->id" class="d-none"></div>
                                        <div class="card-body">
                                            <div class="task-header">
                                                <div>
                                                    <h4 data-item-title="$taskValue->title">
                                                    $taskValue->title</h4>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <i class="ti ti-dots-vertical text-dark"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1">
                                                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                            <i class="ti ti-pencil fs-5"></i>Edit
                                                        </a>
                                                        <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                            <i class="ti ti-trash fs-5"></i>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-content">
                                                <div class="mb-0" data-item-text="$taskValue->description">
                                                    $taskValue->description
                                                </div>
                                            </div>
                                            <div class="task-body">
                                                <div class="task-bottom flex-wrap-reverse gap-2">
                                                    <div class="tb-section-1">
                                                        <span class="hstack gap-2 fs-2" data-item-date="$createdDate">
                                                            <i class="ti ti-calendar fs-5"></i> $createdDate
                                                        </span>
                                                    </div>
                                                    <div class="tb-section-2">
                                                        <span class="badge fs-1 text-wrap" style="background-color:$projectColor!important;">$projectName</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
DELIMETER;
                                }
                            
                            ?>
                            </div>
                        </div>
                    </div>
                    <div data-item="item-pending" class="task-list-container" data-action="sorting">
                        <div class="connect-sorting connect-sorting-pending">
                            <div class="task-container-header">
                                <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Pending">Pending</h6>
                                <div class="hstack gap-2">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="ti ti-dots-vertical text-dark"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1">
                                            <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                            <a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>
                                            <a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="connect-sorting-content" data-sortable="true">
                                                                <?php 
                                
                                    foreach ($taskDetails as $key => $taskValue) {
                                        $createdDate = date('d M y', strtotime($taskValue->date));
                                        $projectName = "";
                                        $project = new Project();
                                        $projectName = $project->where('id', $taskValue->fk_project_id)[0]->title;
                                        $projectColor = $project->where('id', $taskValue->fk_project_id)[0]->color;

                                        if($taskValue->status === 'pending')
                                        echo <<<DELIMETER
                                        <div data-draggable="true" class="card img-task">
                                        <div data-task-id="$taskValue->id" class="d-none"></div>
                                            <div class="card-body">
                                                <div class="task-header">
                                                    <div>
                                                        <h4 data-item-title="$taskValue->title">
                                                        $taskValue->title</h4>
                                                    </div>
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            <i class="ti ti-dots-vertical text-dark"></i>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1">
                                                            <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                                <i class="ti ti-pencil fs-5"></i>Edit
                                                            </a>
                                                            <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                                <i class="ti ti-trash fs-5"></i>Delete
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="task-content">
                                                    <div class="mb-0" data-item-text="$taskValue->description">
                                                        $taskValue->description
                                                    </div>
                                                </div>
                                                <div class="task-body">
                                                    <div class="task-bottom flex-wrap-reverse gap-2">
                                                        <div class="tb-section-1">
                                                            <span class="hstack gap-2 fs-2" data-item-date="$createdDate">
                                                                <i class="ti ti-calendar fs-5"></i> $createdDate
                                                            </span>
                                                        </div>
                                                        <div class="tb-section-2">
                                                            <span class="badge fs-1 text-wrap" style="background-color:$projectColor!important;">$projectName</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
DELIMETER;
                                    }
                                
                                ?>
                            </div>
                        </div>
                    </div>
                    <div data-item="item-done" class="task-list-container" data-action="sorting">
                        <div class="connect-sorting connect-sorting-done">
                            <div class="task-container-header">
                                <h6 class="item-head mb-0 fs-4 fw-semibold" data-item-title="Done">Done</h6>
                                <div class="hstack gap-2">
                                    <div class="dropdown">
                                        <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <i class="ti ti-dots-vertical text-dark"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1">
                                            <a class="dropdown-item list-edit" href="javascript:void(0);">Edit</a>
                                            <a class="dropdown-item list-delete" href="javascript:void(0);">Delete</a>
                                            <a class="dropdown-item list-clear-all" href="javascript:void(0);">Clear All</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="connect-sorting-content" data-sortable="true">
                            <?php 
                                
                                foreach ($taskDetails as $key => $taskValue) {
                                    $createdDate = date('d M y', strtotime($taskValue->date));
                                    $projectName = "";
                                    $project = new Project();
                                    $projectName = $project->where('id', $taskValue->fk_project_id)[0]->title;
                                    $projectColor = $project->where('id', $taskValue->fk_project_id)[0]->color;

                                    if($taskValue->status === 'done')
                                    echo <<<DELIMETER
                                    <div data-draggable="true" class="card img-task">
                                    <div data-task-id="$taskValue->id" class="d-none"></div>
                                        <div class="card-body">
                                            <div class="task-header">
                                                <div>
                                                    <h4 data-item-title="$taskValue->title">
                                                    $taskValue->title</h4>
                                                </div>
                                                <div class="dropdown">
                                                    <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                        <i class="ti ti-dots-vertical text-dark"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1">
                                                        <a class="dropdown-item kanban-item-edit cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                            <i class="ti ti-pencil fs-5"></i>Edit
                                                        </a>
                                                        <a class="dropdown-item kanban-item-delete cursor-pointer d-flex align-items-center gap-1" href="javascript:void(0);">
                                                            <i class="ti ti-trash fs-5"></i>Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="task-content">
                                                <div class="mb-0" data-item-text="$taskValue->description">
                                                    $taskValue->description
                                                </div>
                                            </div>
                                            <div class="task-body">
                                                <div class="task-bottom flex-wrap-reverse gap-2">
                                                    <div class="tb-section-1">
                                                        <span class="hstack gap-2 fs-2" data-item-date="$createdDate">
                                                            <i class="ti ti-calendar fs-5"></i> $createdDate
                                                        </span>
                                                    </div>
                                                    <div class="tb-section-2">
                                                        <span class="badge fs-1 text-wrap" style="background-color:$projectColor!important;">$projectName</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
DELIMETER;
                                }
                            
                            ?>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$this->view("/includes/footer");
?>
<script src="assets/libs/jquery-ui/dist/jquery-ui.min.js"></script>
<script src="assets/js/apps/kanban.js" defer></script>
<script src="assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="assets/libs/select2/dist/js/select2.min.js"></script>
<script src="assets/js/forms/select2.init.js"></script>
<script defer>
    $(".select2").select2({
        placeholder: "Choose the project",
        allowClear: true,
        closeOnSelect: false
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js" defer></script>