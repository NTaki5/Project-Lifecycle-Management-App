<?php
$this->view("/includes/header");
?>


<div class="container-fluid">
    <div class="card rounded-2 overflow-hidden">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between">
                <div class="row">
                    <div class="col-12 col-sm-auto d-flex ms-auto">
                        <div class="btn-group">
                            <button class="btn bg-success-subtle dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" fdprocessedid="smruve">
                            <?= !empty($projectStatus) ? ucfirst($projectStatus[0]->name) : 'No status'; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php 
                                    foreach ($allStatus as $key => $value) {
                                        if($value->id === $projectDetails->fk_status_id) continue;
                                        $statusName = ucfirst($value->name);
                                        echo <<<DELIMETER
                                            <li>
                                                <a class="dropdown-item" href="projects/single/next-problem?update-status&status-id={$value->id}">$statusName</a>
                                            </li>
DELIMETER;
                                    }
                                ?>
                                <!-- <li>
                                    <a class="dropdown-item" href="update-status/">Action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="update-status/">Another action</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="update-status/">Something else here</a>
                                </li> -->
                            </ul>
                        </div>
                        <a href="tasks/" class="btn btn-secondary d-flex align-items-center ms-4">
                            Tasks
                        </a>
                    </div>
                </div>
                <?php if (Auth::getRole() !== 'client') : ?>
                    <div class="hstack gap-2 ms-4">
                        <div class="dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0)" role="button" id="dropdownMenuLink-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="ti ti-dots-vertical text-dark"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink-1" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 26.4px, 0px);" data-popper-placement="bottom-end">
                                <a class="dropdown-item list-edit" href="projects/edit/<?= $slug ?>">Edit</a>
                                <a class="dropdown-item" name="delete-project" data-projectID="<?=$projectDetails->id?>">Delete</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <h2 class="fs-9 fw-semibold my-4"><?= $projectDetails->title ?></h2>
            <div class="d-flex align-items-center gap-4 mb-4">
                <div class="row w-100">
                    <div class="d-flex align-items-center mb-3 mb-md-0 justify-content-between justify-content-sm-start gap-2 col-sm-4 col-md-3">
                        <h6>Team: </h6>
                        <div class="d-flex">
                        <?php 
                        
                        foreach ($teamMembers as $key => $value) {
                            // print_r($value);  echo "<br><br>";
                            if(isset($value->role) && $value->role !== 'client'){
                                $image = strlen($value->image) ? 'uploads/users/'.$value->image : 'assets/images/profile/'.$value->avatar;
                                echo <<<DELIMETER
                                <img src="$image" alt="$value->name" class="hover-scale img-fluid rounded-circle bottom-0 start-0" width="40" height="40" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="$value->name">
DELIMETER;
                            }
                        }
                        
                        // exit();
                        ?>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 mb-md-0 justify-content-between justify-content-sm-start gap-2 col-sm-4 col-md-3">
                        <h6>Clients: </h6>
                        <?php 
                        
                        foreach ($teamMembers as $key => $value) {
                            if(isset($value->role) && $value->role === 'client'){
                                $image = strlen($value->image) ? 'uploads/users/'.$value->image : 'assets/images/profile/'.$value->avatar;
                                echo <<<DELIMETER
                                <img src="$image" alt="$value->name" class="hover-scale img-fluid rounded-circle bottom-0 start-0" width="40" height="40" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="$value->name">
DELIMETER;
                            }
                        }
                        
                        ?>
                    </div>
                    <div class="d-flex align-items-center mb-3 mb-md-0 justify-content-start gap-2 col-sm-4 col-md-3">
                        <i class="ti ti-message-2 text-dark fs-5"></i>3
                    </div>

                    <div class="d-flex gap-2 align-items-center mb-3 mb-md-0 justify-content-start fs-2 ms-lg-auto col-md-3 flex-wrap">
                        <span>
                            <i class="ti ti-point text-dark"></i>
                            Team Leader is <a href="user-details/<?= !empty($teamLead) ? $teamLead->id : "" ?>"><?= !empty($teamLead) ? $teamLead->name : " NOBODY" ?></a>
                        </span>
                        <span>The project was created on <?= $projectDetails->date ?></span>
                    </div>
                </div>
            </div>

            <?php if (Auth::getRole() !== 'client') : ?>
                <div class="d-flex align-items-center justify-content-center justify-content-sm-start ps-0 ps-sm-3 gap-4">
                    
                        <div class="row gap-2">
                            <a href="javascript:void(0)" id="btn-add-team" class="col-12 col-sm-auto btn btn-primary d-flex align-items-center">
                                <i class="ti ti-users text-white me-1 fs-5"></i> Select Team Member
                            </a>
                            <a href="javascript:void(0)" id="invite-client" class="col-12 col-sm-auto btn btn-primary d-flex align-items-center">
                                <i class="ti ti-users text-white me-1 fs-5"></i> Invite Client
                            </a>
                            <a href="projects/edit/<?= $slug ?>" class="col-12 col-sm-auto btn btn-secondary d-flex align-items-center">
                                Edit
                            </a>
                        </div>
                        
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xl-4 mt-4 col-sm-6">
                    <div class="d-flex">
                        <span><i class="ti ti-time text-white me-1 fs-5"></i></span>
                        <div>
                            <h4 class="fs-18 font-w500">Project Create</h4>
                            <span><?= getFormattedDate($projectDetails->date) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mt-4 col-sm-6">
                    <div class="d-flex">
                        <div>
                            <h4 class="fs-18 font-w500">Due date</h4>
                            <span><?= getFormattedDate($projectDetails->end_date) ?></span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mt-4 col-sm-12">
                    <div class="mb-3">
                        <span class="fs-18 font-w500"><b><?= $elapsedDays ?></b></span>
                    </div>
                    <div class="progress h-auto">
                        <div class="progress-bar progress-animated" style="width: <?= $progressPercantege ?>%; height:14px;" role="progressbar">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body border-top p-4">
            <p class="mb-3">
                <?= $projectDetails->description ?>
            </p>
        </div>
    </div>

    <div class="card shadow-none border">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <textarea class="form-control h-auto" placeholder="Share your thoughts" name="message" id="message" rows="10"></textarea>
                    <label for="message">Share your thoughts</label>
                </div>
                <div class="d-flex align-items-center gap-6 flex-wrap">
                    <div class="d-flex gap-2 align-items-center" onclick="document.getElementById('image_name').click()">
                        <div class="d-flex align-items-center round-32 justify-content-center btn btn-primary rounded-circle">
                            <input type="file" name="image_name" id="image_name" accept="image/*" hidden>
                            <i class="ti ti-photo"></i>
                        </div>
                        <span class="text-dark link-primary pe-3 py-2">Photo</span>
                    </div>

                    <div class="d-flex gap-2 align-items-center" onclick="document.getElementById('file_name').click()">
                        <div class="d-flex align-items-center round-32 justify-content-center btn btn-secondary rounded-circle" href="javascript:void(0)">
                            <input type="file" name="file_name" id="file_name" accept=".docx,.xlsx,.txt,application/pdf" hidden>
                            <i class="ti ti-notebook"></i>
                        </div>
                        <span class="text-dark link-secondary pe-3 py-2">File</span>
                    </div>
                    <button type="submit" name="add-feed" class="btn btn-primary ms-auto">Post</button>
                </div>
            </form>
        </div>
    </div>

    <?php 
    $currentUserImage = Auth::getImage();
    foreach ($feedDetails as $key => $feedValue) {
        if($feedValue->fk_parent_id > 0)
            continue;
        // print_r($teamMembers);
        // print_r($userName);
        $startDate = new DateTime($feedValue->date);
        $endDate = new DateTime();
        $interval = $startDate->diff($endDate);
        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;
        $displayTime = $days != '0' ? $days.' d' : $hours.' h';
        $displayTime = $displayTime[0] != '0' ? $displayTime : $minutes.' min';

        // print_r(findInObjectsArrayById($teamMembers,'id', $feedValue->fk_user_id));
        $feedPostedBy = count(findInObjectsArrayById($teamMembers,'id', $feedValue->fk_user_id)) ? findInObjectsArrayById($teamMembers,'id', $feedValue->fk_user_id)[0] : null;
        $userName = $feedPostedBy->name;
        $likedFeedsButtonClass  = "";
        if(isset($authUserFeedLikesIDS)){
            $likedFeedsButtonClass =  in_array($feedValue->id, $authUserFeedLikesIDS) ? "opacity-50" : "";
        }

        $userImage = strlen($feedPostedBy->image) ? 'uploads/users/'.$feedPostedBy->image : 'assets/images/profile/'.$feedPostedBy->avatar;

        if(empty($feedDocuments = findInObjectsArrayById($documentDetails,'fk_feed_id', $feedValue->id))){
            $feedDocuments = array();
        }

        // SET THE images and files html <div>
        $displayDocuments = '<div class="d-flex flex-column gap-2">';
        $displayImages = '<div class="image-grid">';
        foreach ($feedDocuments as $key => $document) {
            $displayDocuments .= '<div class="h6 mb-0">Documents:</div>';
            if(str_contains($document->type,'application/pdf')){
                $displayDocuments .= '
                <a href="'.ROOT.'/uploads/feed/documents/'.$document->name.'" target="_blank">
                '.$document->name.'
                </a>';
            }else
                if(str_contains($document->type,'application') || str_contains($document->type,'text')){
                    $displayDocuments .= '
                    <a href="'.ROOT.'/uploads/feed/documents/'.$document->name.'" download>
                    <i class="ti ti-notebook text-primary"></i>
                    <strong>'.$document->name.'</strong>
                    </a>';
                }
            if(str_contains($document->type,'image')){
                $displayImages .= '
                    <img src="uploads/feed/images/'.$document->name.'" alt="'.$userName.' feed image" height="360" class="rounded-4 w-100 object-fit-cover">
                ';
            }
        }
        $displayDocuments .= '</div>';
        $displayImages .= '</div>';

        $commentDB = new Comment();
        $commentDetails = ($commentsCount = count($commentDB->where('fk_feed_id', $feedValue->id)))? $commentDB->where('fk_feed_id', $feedValue->id) : [];
        
        $commentDetails = array_filter($commentDetails, function($obj){
            return $obj->fk_parent_id == 0;
        });

        // Create the comments section, under the actual FEED (comments , replies)
        $comments = "";  
        foreach ($commentDetails as $key => $commentValue) {

            $commentBy = findInObjectsArrayById($teamMembers,'id', $commentValue->fk_user_id)[0];
            $userName = $commentBy->name;
            $commentUserImage = strlen($commentBy->image) ? 'uploads/users/'.$commentBy->image : 'assets/images/profile/'.$commentBy->avatar;

            $startDate = new DateTime($commentValue->date);
            $endDate = new DateTime();
            $interval = $startDate->diff($endDate);
            $days = $interval->d;
            $hours = $interval->h;
            $minutes = $interval->i;
            $displayTime = $days != '0' ? $days.' d' : $hours.' h';
            $displayTime = $displayTime[0] != '0' ? $displayTime : $minutes.' min';

            $childCommentDetails = ($childCommentsCount = count($commentDB->where('fk_parent_id', $commentValue->id)))? $commentDB->where('fk_parent_id', $commentValue->id) : [];

            if(isset($authUserCommentLikesIDS)){
                $likedCommentsButtonClass =  in_array($commentValue->id, $authUserCommentLikesIDS) ? "opacity-50" : "";
            }

            $comments .= <<<DELIMETER
            <div class="p-4 rounded-2 text-bg-light mb-3 replyBox">
                <div class="d-flex align-items-center gap-6 flex-wrap">
                    <img src="$commentUserImage" alt="matdash-img" class="rounded-circle" width="33" height="33">
                    <h6 class="mb-0">$userName</h6>
                    <span class="fs-2">
                        <span class="p-1 text-bg-muted rounded-circle d-inline-block"></span> $displayTime ago
                    </span>
                </div>
                <p class="my-3">
                    {$commentValue->comment}
                </p>
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <a class="$likedCommentsButtonClass round-32 rounded-circle btn btn-primary p-0 hstack justify-content-center comment-like" data-commentID="{$commentValue->id}" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Like">
                            <i class="ti ti-thumb-up"></i>
                        </a>
                        <span class="text-dark fw-semibold">
                            {$commentValue->likes}
                        </span>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-4">
                        <a id="" data-commentID="$commentValue->id" data-feedID="$feedValue->id" class="round-32 rounded-circle btn btn-secondary p-0 hstack justify-content-center comment-reply" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reply">
                            <i class="ti ti-arrow-back-up"></i>
                        </a>
                        <span class="text-dark fw-semibold">$childCommentsCount</span>
                    </div>
                </div>
            </div>
DELIMETER;

            if(isset($commentValue->id)){
                foreach ($childCommentDetails as $key => $childCommentValue) {

                    $commentBy = findInObjectsArrayById($teamMembers,'id', $childCommentValue->fk_user_id)[0];
                    $userName = $commentBy->name;

                    $commentUserImage = strlen($commentBy->image) ? 'uploads/users/'.$commentBy->image : 'assets/images/profile/'.$commentBy->avatar;

                    $startDate = new DateTime($childCommentValue->date);
                    $endDate = new DateTime();
                    $interval = $startDate->diff($endDate);
                    $days = $interval->d;
                    $hours = $interval->h;
                    $minutes = $interval->i;
                    $childDisplayTime = $days != '0' ? $days.' d' : $hours.' h';
                    $childDisplayTime = $childDisplayTime[0] != '0' ? $childDisplayTime : $minutes.' min';

                    if(isset($authUserCommentLikesIDS)){
                        $likedChildCommentsButtonClass =  in_array($childCommentValue->id, $authUserCommentLikesIDS) ? "opacity-50" : "";
                    }
                    $comments .= <<<DELIMETER
                        <div class="p-4 rounded-2 text-bg-light mb-3 ms-7">
                            <div class="d-flex align-items-center gap-6 flex-wrap">
                                <img src="$commentUserImage" alt="matdash-img" class="rounded-circle" width="33" height="33">
                                <h6 class="mb-0">$userName</h6>
                                <span class="fs-2">
                                    <span class="p-1 text-bg-muted rounded-circle d-inline-block"></span> $childDisplayTime ago
                                </span>
                            </div>
                            <p class="my-3">
                                {$childCommentValue->comment}
                            </p>
                            <div class="d-flex align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <a class="$likedChildCommentsButtonClass round-32 rounded-circle btn btn-primary p-0 hstack justify-content-center comment-like" data-commentID="{$childCommentValue->id}" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Like">
                                        <i class="ti ti-thumb-up"></i>
                                    </a>
                                    <span class="text-dark fw-semibold">
                                        {$childCommentValue->likes}
                                    </span>
                                </div>
                            </div>
                        </div>
DELIMETER;
                }
            }
        }
        
        

        // The entire feed card (4 feed -> 4 cards)
        echo <<<DELIMETER
        <div class="card">
            <div class="card-body border-bottom">
                <div class="d-flex align-items-center gap-6 flex-wrap">
                    <img src="$userImage" alt="matdash-img" class="rounded-circle" width="40" height="40">
                    <h6 class="mb-0">$userName</h6>
                    <span class="fs-2 hstack gap-2">
                        <span class="round-10 text-bg-light rounded-circle d-inline-block"></span> $displayTime ago
                    </span>
                </div>
                <p class="text-dark my-3">
                    {$feedValue->message}
                </p>
                $displayDocuments
                $displayImages
                <div class="d-flex align-items-center my-3">
                    <div class="d-flex align-items-center gap-2">
                        <a class="$likedFeedsButtonClass round-32 rounded-circle btn btn-primary p-0 hstack justify-content-center feed-like" data-feedID="{$feedValue->id}" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Like">
                            <i class="ti ti-thumb-up"></i>
                        </a>
                        <span class="text-dark fw-semibold">{$feedValue->likes}</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-4">
                        <a class="$likedFeedsButtonClass round-32 rounded-circle btn btn-secondary p-0 hstack justify-content-center" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Comment">
                            <i class="ti ti-message-2"></i>
                        </a>
                        <span class="text-dark fw-semibold">$commentsCount</span>
                    </div>
                    <a class="text-dark ms-auto d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Share">
                        <i class="ti ti-share"></i>
                    </a>
                </div>
                <div class="position-relative">
                    $comments
                </div>
            </div>
            <form method="POST" class="d-flex align-items-center gap-6 flex-wrap p-3 flex-lg-nowrap">
                <input value="{$feedValue->id}" name="fk_feed_id" type="text" hidden/>
                <img src="$currentUserImage" alt="matdash-img" class="rounded-circle" width="33" height="33">
                <input type="text" class="form-control py-8" id="commentText" name="commentText" aria-describedby="textHelp" placeholder="Comment">
                <button class="btn btn-primary" name="add-comment">Comment</button>
            </form>
        </div>
DELIMETER;
    }
    
    ?>
</div>

<?php if (Auth::getRole() !== 'client') : ?>
    <!-- Modal add team member -->
    <input type="text" hidden id="project-slug" name="slug" class="form-control" value="<?= $slug ?>" />
    <div class="modal fade show" id="addTeamModal" tabindex="-1" role="dialog" aria-labelledby="addTeamModalForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">Select team members</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="add-team-member-box">
                        <div class="add-team-member-content">
                            <form id="addTeamModalForm" method="POST">
                                <div class="row">

                                    <div class="mb-4 position-relative">
                                        <label class="mr-sm-2" for="team_members">Team</label>
                                        <select class="form-select select2 form-control mr-sm-2" multiple="multiple" id="team_members" name="team_members[]">
                                            <?= $projectWorkers ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex gap-6 m-0">
                    <button id="btn-add" class="btn bg-success-subtle text-success">
                    Save
                    </button>
                    <button id="btn-edit" class="btn bg-success-subtle text-success">
                    Add
                    </button>
                        <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal"> Discard
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal invite client -->
    <div class="modal fade" id="inviteClient" tabindex="-1" role="dialog" aria-labelledby="inviteClientForm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                    <h5 class="modal-title">Invite Client</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="add-team-member-box">
                        <div class="add-team-member-content">
                            <form id="inviteClientForm" method="POST">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3 team-member-email">
                                            <input type="text" id="c-email" name="email" class="form-control" placeholder="Email" />
                                            <span class="invite-validation-text text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="d-flex gap-6 m-0">
                        <button id="btn-invite-client" class="btn btn-success">Invite</button>
                        <button class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal"> Discard
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php
$this->view("/includes/footer");
?>

<script src="assets/js/apps/project.js"></script>
<script src="assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="assets/libs/select2/dist/js/select2.min.js"></script>
<script src="assets/js/forms/select2.init.js"></script>
<script defer>
    $(".select2").select2({
        placeholder: "Select Team member",
        allowClear: true,
        closeOnSelect: false
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js" defer></script>
<script src="assets/js/apps/project.js" defer></script>