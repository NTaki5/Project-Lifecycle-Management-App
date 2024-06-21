<?php
$this->view("/includes/header");
?>

<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-md-0 card-title">Team</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="home">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Team
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
                        <input type="text" class="form-control product-search ps-5" id="input-search" placeholder="Search Team Members..." />
                        <i class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                    </form>
                </div>
                <div class="col-md-8 col-xl-9 text-end d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                    <a href="javascript:void(0)" id="btn-add-team" class="btn btn-primary d-flex align-items-center">
                        <i class="ti ti-users text-white me-1 fs-5"></i> Invite Member
                    </a>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="addTeamModalForm" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header d-flex align-items-center">
                        <h5 class="modal-title">Add team member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="add-team-member-box">
                            <div class="add-team-member-content">
                                <form id="addTeamModalForm" method="POST">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="mb-3 team-member-name">
                                                <input type="text" id="c-name" name="name" class="form-control" placeholder="Name" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3 team-member-email">
                                                <input type="text" id="c-email" name="email" class="form-control" placeholder="Email" />
                                                <span class="validation-text text-danger"></span>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3 team-member-phone">
                                                <input type="text" id="c-phone" name="phone" class="form-control" placeholder="Phone no." />
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
                        <th>
                            <div class="n-chk align-self-center text-center">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input primary" id="team-member-check-all" />
                                    <label class="form-check-label" for="team-member-check-all"></label>
                                    <span class="new-control-indicator"></span>
                                </div>
                            </div>
                        </th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        <?=
                        $invitations .
                            $teamMembers
                        ?>
                        <!-- start row -->
                        <!-- <tr class="search-items">
                                <td>
                                    <div class="n-chk align-self-center text-center">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input team-member-chkbox primary" id="checkbox1" />
                                            <label class="form-check-label" for="checkbox1"></label>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="assets/images/profile/user-10.jpg" alt="avatar" class="rounded-circle" width="35" />
                                        <div class="ms-3">
                                            <div class="user-meta-info">
                                                <h6 class="user-name mb-0" data-name="Emma Adams">Emma Adams</h6>
                                                <span class="user-work fs-3" data-occupation="Web Developer">Web Developer</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="usr-email-addr" data-email="adams@mail.com">adams@mail.com</span>
                                </td>
                                <td>
                                    <span class="usr-ph-no" data-phone="+1 (070) 123-4567">+91 (070) 123-4567</span>
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
                            </tr> -->
                        <!-- end row -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$this->view("/includes/footer");
?>
<script src="assets/js/apps/team.js"></script>