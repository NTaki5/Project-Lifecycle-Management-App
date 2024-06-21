<?php
$this->view("/includes/header");
?>


<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-md-0 card-title">Create New Board</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="home">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <a class="text-muted text-decoration-none d-flex gap-2 align-items-center" href="whiteBoards">
                                    <iconify-icon icon="octicon:project-roadmap-16"></iconify-icon>
                                    Boards
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Create New Board
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
            <!-- start Create Board -->
            <div class="card">
                <div class="card-body">
                    <form method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="row flex-column content-align-center">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="title" name="title" value="<?= get_var("title") ?>" />
                                    <label for="title">Title *</label>
                                    <div class="invalid-feedback">
                                        <?php echo isset($errors["title"]) ? $errors["title"] : "" ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-md-flex align-items-center">
                                    <div class="mt-3 mt-md-0">
                                        <button type="submit" name="creat-board" class="btn btn-primary hstack gap-6">
                                            Create
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- end Create Board -->
            </div>
        </div>
    </div>
    <?php
    $this->view("/includes/footer");
    ?>