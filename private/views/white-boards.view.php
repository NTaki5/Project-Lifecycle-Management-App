<?php
$this->view("/includes/header");
?>


<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-md-0 card-title">Boards</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="home">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Boards
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="widget-content">
        <div class="row">
            <?php if (count($boardsArr)) :

                echo $boardDB->getHTMLBoards($boardsArr);

            ?>
            <?php else : ?>
                <div class="col-12 d-flex flex-column align-items-center">
                    <h4>We did not find any board. Create one right now!</h4><br>
                    <a href="whiteBoards/create" class="btn btn-secondary m-auto">
                        New board
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
    $this->view("/includes/footer");
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js" defer></script>
    <script src="assets/js/apps/whiteBoard.js" defer></script>
