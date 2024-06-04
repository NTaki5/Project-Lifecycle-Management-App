<?php
$this->view("/includes/header");
?>


<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-md-0 card-title">Create New Project</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="home">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="text-muted text-decoration-none d-flex gap-2 align-items-center" href="projects">
                                    <iconify-icon icon="octicon:project-roadmap-16"></iconify-icon>
                                    Projects
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Create New Project
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="widget-content">
        <div class="col-12">
            <!-- ----------------------------------------- -->
            <!-- start Create Project -->
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="title" name="title" value="<?= get_var("title") ?>"/>
                                    <label for="title">Project Title *</label>
                                    <div class="invalid-feedback">
                                        <?php echo isset($errors["title"]) ? $errors["title"] : "" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?= get_var("start_date") ?>"/>
                                    <label for="start_date">Start Date *</label>
                                    <div class="invalid-feedback">
                                        <?php echo isset($errors["start_date"]) ? $errors["start_date"] : "" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?= get_var("end_date") ?>"/>
                                    <label for="end_date">End Date *</label>
                                    <div class="invalid-feedback">
                                        <?php echo isset($errors["end_date"]) ? $errors["end_date"] : "" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating mb-4">
                                    <select class="form-select form-control mr-sm-2" id="priority" name="priority">
                                        <option selected="">Choose...</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                    <label class="mr-sm-2" for="priority">Priority</label>
                                    <div class="invalid-feedback">
                                        <?php echo isset($errors["priority"]) ? $errors["priority"] : "" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating mb-4">
                                    <input type="color" class="form-control" id="color" name="color" value="<?= strlen(get_var("color")) ? get_var("color") : "#88AE45" ?>">
                                    <label class="mr-sm-2" for="color">Color</label>
                                    <div class="invalid-feedback">
                                        <?php echo isset($errors["color"]) ? $errors["color"] : "" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="form-floating mb-4">
                                    <select class="form-select form-control mr-sm-2" id="fk_teamlead_id" name="fk_teamlead_id">
                                        <option selected="" value="">Choose...</option>
                                        <?= $teamMembers ?>
                                    </select>
                                    <label class="mr-sm-2" for="fk_teamlead_id">Team Lead</label>
                                    <div class="invalid-feedback">
                                        <?php echo isset($errors["fk_teamlead_id"]) ? $errors["fk_teamlead_id"] : "" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4">
                                <div class="mb-4">
                                    <select class="form-select form-control select2 mr-sm-2" multiple="multiple" id="team_members" name="team_members[]">
                                        <?= $teamMembers ?>
                                    </select>
                                    <label class="mr-sm-2" for="team_members">Team</label>
                                    <div class="invalid-feedback">
                                        <?php echo isset($errors["team_members"]) ? $errors["team_members"] : "" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-4">
                                    <label class="mr-sm-2 form-label" for="description">Description</label>
                                    <textarea class="form-control h-auto" name="description" id="description" rows="5"><?= get_var("description") ?></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-md-flex align-items-center">
                                    <div class="mt-3 mt-md-0">
                                        <button type="submit" name="creat-project" class="btn btn-primary hstack gap-6">
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- end Create Project -->
        </div>
    </div>
</div>
<?php
$this->view("/includes/footer");
?>

<script src="assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="assets/libs/select2/dist/js/select2.min.js"></script>
<script src="assets/js/forms/select2.init.js"></script>
<script defer>
    $(".select2").select2({
        placeholder: "Select Team",
        allowClear: true
    });
</script>