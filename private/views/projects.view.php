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
                    <li class="nav-item">
                        <a class="nav-link d-flex h-100 align-items-center" data-bs-toggle="tab" href="#started" role="tab">
                            <span>
                                <i class="ti ti-player-play"></i>
                            </span>
                            <span class="d-none d-md-block ms-2">Started</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex h-100 align-items-center" data-bs-toggle="tab" href="#ready" role="tab">
                            <span>
                                <i class="ti ti-player-play"></i>
                            </span>
                            <span class="d-none d-md-block ms-2">Ready</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex h-100 align-items-center" data-bs-toggle="tab" href="#approval" role="tab">
                            <span>
                                <i class="ti ti-writing-sign"></i>
                            </span>
                            <span class="d-none d-md-block ms-2">Approval</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex h-100 align-items-center" data-bs-toggle="tab" href="#completed" role="tab">
                            <span>
                                <i class="ti ti-circle-check"></i>
                            </span>
                            <span class="d-none d-md-block ms-2">Completed</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content mt-5">
                    <div class="tab-pane p-3 active" id="All" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow">
                                    <div class="data-bg-color rounded-3 rounded-bottom-0 p-2" style="--bg-color:136, 174, 69">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            Website Dev
                                        </h4>
                                        <p class="mb-0 card-subtitle">
                                            Titudin venenatis ipsum ac feugiat. Vestibulum ullamcorper
                                            quam.
                                        </p>

                                        <div class="d-flex align-items-center my-3">
                                            <div class="row">
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-paperclip me-1 fs-5"></i>
                                                    5 Attach
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-calendar me-1 fs-5"></i>
                                                    4 Months
                                                    </a>
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-users me-1 fs-5"></i>
                                                    5 Members
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
                                                <h6>Progress:</h6>
                                            </div>
                                            <div class="col-sm-6 d-flex justify-content-end">
                                                <span class="mb-1 badge  bg-success-subtle text-success">35 days left</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar text-bg-danger" style="width: 60%; height: 6px" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="started" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow">
                                    <div class="data-bg-color rounded-3 rounded-bottom-0 p-2" style="--bg-color:136, 174, 69">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            Website Dev
                                        </h4>
                                        <p class="mb-0 card-subtitle">
                                            Titudin venenatis ipsum ac feugiat. Vestibulum ullamcorper
                                            quam.
                                        </p>

                                        <div class="d-flex align-items-center my-3">
                                            <div class="row">
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-paperclip me-1 fs-5"></i>
                                                    5 Attach
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-calendar me-1 fs-5"></i>
                                                    4 Months
                                                    </a>
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-users me-1 fs-5"></i>
                                                    5 Members
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
                                                <h6>Progress:</h6>
                                            </div>
                                            <div class="col-sm-6 d-flex justify-content-end">
                                                <span class="mb-1 badge  bg-success-subtle text-success">35 days left</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar text-bg-danger" style="width: 60%; height: 6px" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="ready" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow">
                                    <div class="data-bg-color rounded-3 rounded-bottom-0 p-2" style="--bg-color:136, 174, 69">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            Website Dev
                                        </h4>
                                        <p class="mb-0 card-subtitle">
                                            Titudin venenatis ipsum ac feugiat. Vestibulum ullamcorper
                                            quam.
                                        </p>

                                        <div class="d-flex align-items-center my-3">
                                            <div class="row">
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-paperclip me-1 fs-5"></i>
                                                    5 Attach
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-calendar me-1 fs-5"></i>
                                                    4 Months
                                                    </a>
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-users me-1 fs-5"></i>
                                                    5 Members
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
                                                <h6>Progress:</h6>
                                            </div>
                                            <div class="col-sm-6 d-flex justify-content-end">
                                                <span class="mb-1 badge  bg-success-subtle text-success">35 days left</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar text-bg-danger" style="width: 60%; height: 6px" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="approval" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow">
                                    <div class="data-bg-color rounded-3 rounded-bottom-0 p-2" style="--bg-color:136, 174, 69">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            Website Dev
                                        </h4>
                                        <p class="mb-0 card-subtitle">
                                            Titudin venenatis ipsum ac feugiat. Vestibulum ullamcorper
                                            quam.
                                        </p>

                                        <div class="d-flex align-items-center my-3">
                                            <div class="row">
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-paperclip me-1 fs-5"></i>
                                                    5 Attach
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-calendar me-1 fs-5"></i>
                                                    4 Months
                                                    </a>
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-users me-1 fs-5"></i>
                                                    5 Members
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
                                                <h6>Progress:</h6>
                                            </div>
                                            <div class="col-sm-6 d-flex justify-content-end">
                                                <span class="mb-1 badge  bg-success-subtle text-success">35 days left</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar text-bg-danger" style="width: 60%; height: 6px" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane p-3" id="completed" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow">
                                    <div class="data-bg-color rounded-3 rounded-bottom-0 p-2" style="--bg-color:136, 174, 69">
                                    </div>
                                    <div class="card-body">
                                        <h4 class="card-title">
                                            Website Dev
                                        </h4>
                                        <p class="mb-0 card-subtitle">
                                            Titudin venenatis ipsum ac feugiat. Vestibulum ullamcorper
                                            quam.
                                        </p>

                                        <div class="d-flex align-items-center my-3">
                                            <div class="row">
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-paperclip me-1 fs-5"></i>
                                                    5 Attach
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-calendar me-1 fs-5"></i>
                                                    4 Months
                                                    </a>
                                                </span>
                                                <span class="d-flex align-items-center col-sm-6 mb-2">
                                                    <i class="ti ti-users me-1 fs-5"></i>
                                                    5 Members
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
                                                <h6>Progress:</h6>
                                            </div>
                                            <div class="col-sm-6 d-flex justify-content-end">
                                                <span class="mb-1 badge  bg-success-subtle text-success">35 days left</span>
                                            </div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar text-bg-danger" style="width: 60%; height: 6px" role="progressbar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end Custom Icon Tab -->
</div>
<?php
$this->view("/includes/footer");
?>