<?php
$this->view("/includes/header");
// echo Toast::show("show toast-onload");
?>


<div class="container-fluid">
    <!-- start Custom Icon Tab -->
    <div class="card">
        <div class="card-body">

            <h4 class="card-title mb-4">Projects</h4>
            <div>

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item me-4 h-100">
                        <a href="projects/create" class="justify-content-center w-100 btn btn-secondary d-flex align-items-center" fdprocessedid="hvxcfy">
                            <i class="ti ti-folder fs-7 me-2"></i>
                            Create Project
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex h-100 align-items-center active" data-bs-toggle="tab" href="#All" role="tab">
                            <span>
                                <i class="ti ti-clear-all"></i>
                            </span>
                            <span class="d-none d-md-block ms-2">All</span>
                        </a>
                    </li>
                    <?php 
                        foreach ($status as $key => $value) {

                            $thisStatusProjects = $projectClass->getProjectsCards($projects,$value->id);
                            $statusName = ucfirst($value->name);
                            echo <<<DELIMETER
                            <li class="nav-item">
                                <a class="nav-link d-flex h-100 align-items-center" data-bs-toggle="tab" href="#{$value->name}" role="tab">
                                    <span>
                                        <i class="ti ti-player-play"></i>
                                    </span>
                                    <span class="d-none d-md-block ms-2">$statusName</span>
                                </a>
                            </li>
DELIMETER;
                        }
                    
                    ?>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content mt-5">
                    <div class="tab-pane p-3 active" id="All" role="tabpanel">
                        <div class="row">
                        <?php 
                        echo $projectClass->getProjectsCards($projects);
                        
                        ?>
                        </div>
                    </div>
                    <?php 
                        foreach ($status as $key => $value) {

                            $thisStatusProjects = $projectClass->getProjectsCards($projects,$value->id);

                            echo <<<DELIMETER
                            <div class="tab-pane p-3" id="{$value->name}" role="tabpanel">
                                <div class="row">
                                    $thisStatusProjects
                                </div>
                            </div>
DELIMETER;
                        }
                    
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- end Custom Icon Tab -->
</div>
<?php
$this->view("/includes/footer");
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js" defer></script>
<script src="assets/js/apps/project.js" defer></script>