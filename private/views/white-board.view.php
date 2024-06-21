<?php
$this->view("/includes/header");
?>


<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-md-0 card-title">Single Board</h4>
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
                                    Single Board
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
            <div class="col-12" id="wt-container"></div>
        </div>
    </div>
    <?php
    $this->view("/includes/footer");
    ?>

    <script src="https://www.whiteboard.team/dist/api.js"></script>
    <script type="text/javascript" defer>
        var wt = new api.WhiteboardTeam('#wt-container', {
            clientId: '<?= $client_id ?>',
            boardCode: '<?= $board_code ?>'
        });
        console.log('here');
        wt.getCurrentUser().then(user => console.log(user));
    </script>