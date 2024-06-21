<?php
$this->view("/includes/header");
?>

<div class="container-fluid">
    <div class="section pb-4">
        <div class="row">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <!-- ----------------------------------------- -->
                <!-- Welcome Card -->
                <!-- ----------------------------------------- -->
                <div class="card mb-0 text-white bg-primary-gt overflow-hidden h-100">
                    <div class="card-body position-relative z-1">
                        <div class="d-flex gap-2 flex-wrap">
                            <span class="badge badge-custom-dark d-inline-flex align-items-center gap-2 fs-3">
                                <iconify-icon icon="solar:check-circle-outline" class="fs-5"></iconify-icon>
                                <span class="fw-normal text-wrap">Username: <?= $username ?></span>
                            </span>
                            <?php if ($role === "admin" || $role === "employee") : ?>

                                <span class="badge badge-custom-dark d-inline-flex align-items-center gap-2 fs-3">
                                    <iconify-icon icon="solar:check-circle-outline" class="fs-5"></iconify-icon>
                                    <span class="fw-normal text-wrap">Company: <?= $companyName ?></span>
                                </span>

                            <?php endif; ?>
                            </span>
                        </div>
                        <h4 class="text-white fw-normal mt-5 pt-7">Hey, <span class="fw-semibold"><?= $name ?></span>
                        </h4>
                        <h6 class="opacity-75 fw-normal text-white mb-0">
                            <p class="fw-semibold">For questions or help, you can contact us at <br /> <a class="text-info" href="mailto:takacsn525@gmail.com" target="_blank">takacsn525@gmail.com</a></p>
                            </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-lg-0">
                <!-- -------------------------------------------- -->
                <!-- Your Performance -->
                <!-- -------------------------------------------- -->
                <div class="card h-100  mb-0">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">Your Performance</h5>
                        <p class="card-subtitle mb-0">Last check on 25 february</p>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="vstack gap-9 mt-2">
                                    <div class="hstack align-items-center gap-3">
                                        <div class="d-flex align-items-center justify-content-center round-48 rounded bg-primary-subtle flex-shrink-0">
                                            <iconify-icon icon="solar:shop-2-linear" class="fs-7 text-primary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-nowrap">64 projects</h6>
                                            <span>Done</span>
                                        </div>

                                    </div>
                                    <div class="hstack align-items-center gap-3">
                                        <div class="d-flex align-items-center justify-content-center round-48 rounded bg-danger-subtle">
                                            <iconify-icon icon="solar:filters-outline" class="fs-7 text-danger"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">4 tasks</h6>
                                            <span>Waiting to be resolved</span>
                                        </div>

                                    </div>
                                    <div class="hstack align-items-center gap-3">
                                        <div class="d-flex align-items-center justify-content-center round-48 rounded bg-secondary-subtle">
                                            <iconify-icon icon="solar:pills-3-linear" class="fs-7 text-secondary"></iconify-icon>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">355</h6>
                                            <span>Active hours</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- <div class="col-md-6">
                                <div class="text-center">
                                    <div id="your-preformance"></div>
                                    <h2 class="fs-8">275</h2>
                                    <p class="mb-0 fs-2">
                                        Learn insigs how to manage all aspects of your
                                        startup.
                                    </p>
                                </div>
                            </div> -->
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="section  pb-4">
        <div class="row">
            <div class="col-lg-4 mb-4 mb-lg-0">
                <!-- ----------------------------------------- -->
                <!-- Company Employees -->
                <!-- ----------------------------------------- -->
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Daily activities</h5>
                                <ul class="timeline-widget mb-0 position-relative mb-n5" data-simplebar style="height: 425px;">
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time mt-n1 text-muted flex-shrink-0 text-end">09:46
                                        </div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge bg-primary flex-shrink-0 mt-2"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Payment received from John
                                            Doe of $385.90</div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time mt-n6 text-muted flex-shrink-0 text-end">09:46
                                        </div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge bg-warning flex-shrink-0"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n6 fw-semibold">New sale
                                            recorded <a href="javascript:void(0)" class="text-primary d-block fw-normal ">#ML-3467</a>
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time mt-n6 text-muted flex-shrink-0 text-end">09:46
                                        </div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge bg-warning flex-shrink-0"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n6">Payment was made of $64.95
                                            to Michael</div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time mt-n6 text-muted flex-shrink-0 text-end">09:46
                                        </div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge bg-secondary flex-shrink-0"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n6 fw-semibold">New sale
                                            recorded <a href="javascript:void(0)" class="text-primary d-block fw-normal ">#ML-3467</a>
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time mt-n6 text-muted flex-shrink-0 text-end">09:46
                                        </div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge bg-danger flex-shrink-0"></span>
                                            <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n6 fw-semibold">Project meeting
                                        </div>
                                    </li>
                                    <li class="timeline-item d-flex position-relative overflow-hidden">
                                        <div class="timeline-time mt-n6 text-muted flex-shrink-0 text-end">09:46
                                        </div>
                                        <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                            <span class="timeline-badge bg-primary flex-shrink-0"></span>
                                        </div>
                                        <div class="timeline-desc fs-3 text-dark mt-n6">Payment received from John
                                            Doe of $385.90</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-6 mb-4 pb-3">
                                    <span class="round-48 d-flex align-items-center justify-content-center rounded bg-secondary-subtle">
                                        <iconify-icon icon="solar:football-outline" class="fs-7 text-secondary"> </iconify-icon>
                                    </span>
                                    <h6 class="mb-0 fs-4">Company Employees</h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mb-6">
                                    <h6 class="mb-0 fw-medium">Active Users</h6>
                                    <h6 class="mb-0 fw-medium">5/13</h6>
                                </div>
                                <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="5" aria-valuemin="0" aria-valuemax="13">
                                    <div class="progress-bar bg-secondary" style="width: <?= (5 * 100) / 13 ?>%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- ----------------------------------------- -->
            <!-- Daily activities -->
            <!-- ----------------------------------------- -->
            <div class="col-lg-8">
                <!-- ----------------------------------------- -->
                <!-- Total Projects -->
                <!-- ----------------------------------------- -->
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-6 mb-4">
                            <div class="row w-100">
                                <div class="col-8 d-flex gap-2 align-items-center">
                                    <span class="round-48 d-flex align-items-center justify-content-center rounded bg-danger-subtle">
                                        <iconify-icon icon="solar:box-linear" class="fs-7 text-danger"></iconify-icon>
                                    </span>
                                    <h6 class="mb-0 fs-4">Total Projects (<?=date("Y")?>)</h6>

                                </div>
                                <div class="col-4">

                                    <h4>10</h4>
                                    <span class="fs-11 text-success fw-semibold">+18%</span>
                                </div>
                            </div>
                        </div>
                        <div id="total-projects"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
// echo '<pre>';
// print_r($data);
$this->view("/includes/footer");
?>

<script src="assets/js/dashboards/my-dashboard.js" defer></script>