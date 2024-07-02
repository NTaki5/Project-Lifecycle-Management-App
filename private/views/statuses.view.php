<?php
$this->view("/includes/header");
?>

<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-md-0 card-title">Project Statuses</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="home">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Project Statuses
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="widget-content searchable-container list">
        <div class="card card-body">
            <div class="row">
                <div class="col-md-4 col-xl-3">
                    <form class="position-relative">
                        <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Search Status..." />
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <a href="javascript:void(0)" id="btn-add-project-status" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-users text-white me-1 fs-5"></i> Add status
                    </a>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addStatusModal" tabindex="-1" role="dialog" aria-labelledby="addStatusModalForm" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title">Add project status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="add-project-status-box">
                            <div class="add-project-status-content">
                                <form id="addStatusModalForm" method="POST">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3 project-status-name">
                                                <input type="text" id="c-name" name="name" class="form-control" placeholder="Name" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3 form-floating project-status-color">
                                                <input type="color" id="c-color" name="color" class="form-control" placeholder="Color" />
                                                <label class="mr-sm-2" for="color">Color</label>
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3 project-status-priority">
                                                <input type="number" min="0" id="c-priority" name="priority" class="form-control" placeholder="Priority" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="project-status-active form-check">
                                                <input class="form-check-input" type="checkbox" name="active" id="c-active">
                                                <label class="form-check-label" for="c-active">
                                                    Active
                                                </label>
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex gap-6 m-0">
                            <button id="btn-add" class="btn btn-success">Add</button>
                            <button id="btn-edit" class="btn btn-success">Save</button>
                            <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal"> Discard
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card card-body">
            <div class="table-responsive">
                <table class="table search-table align-middle text-nowrap">
                    <thead class="header-item">
                        <th>Name</th>
                        <th>Color</th>
                        <th>Priority</th>
                        <th>Active</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?php
                            print_r($allStatus);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="assets/js/apps/statuses.js" defer></script>
<?php
$this->view("/includes/footer");
?>