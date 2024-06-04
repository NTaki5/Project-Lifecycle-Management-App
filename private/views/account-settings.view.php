<?php
$this->view("/includes/header");
?>
<div class="container-fluid">
    <div class="card card-body py-3">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="d-sm-flex align-items-center justify-space-between">
                    <h4 class="mb-4 mb-md-0 card-title">Account Setting</h4>
                    <nav aria-label="breadcrumb" class="ms-auto">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item d-flex align-items-center">
                                <a class="text-muted text-decoration-none d-flex" href="home">
                                    <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">
                                <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                    Account Setting
                                </span>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="true">
                    <i class="ti ti-user-circle me-2 fs-6"></i>
                    <span class="d-none d-md-block">Account</span>
                </button>
            </li>
        </ul>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
                    <div class="row">
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="card w-100 border position-relative overflow-hidden">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Change Profile</h4>
                                    <p class="card-subtitle mb-4">Change your profile picture from here</p>
                                    <form id="profile-image-form" method="POST" enctype="multipart/form-data">
                                        <div class="text-center">
                                            <img src="<?= strlen(Auth::getImage()) ? 'uploads/users/' . Auth::getImage() : 'assets/images/profile/' . Auth::getAvatar() ?>" alt="matdash-img" class="object-fit-cover rounded-circle" width="120" height="120">
                                            <div class="d-flex align-items-center justify-content-center my-4 gap-6">
                                                <a id="upload-button" class="btn btn-primary">Upload</a>
                                                <input type="file" id="file-input" name="image" class="d-none" accept="images/*">
                                                <button type="submit" name="delete-image" class="btn bg-danger-subtle text-danger">Reset</b>
                                            </div>
                                            <h6 class="mb-0">OR choose from our avatars</h6>
                                        </div>

                                        <div class="row our-avatars w-100 m-auto mb-4 justify-content-center">

                                            <?php $avatarsArr = get_avatars();

                                            if (!count($avatarsArr)) echo '<h6>No avatars at the moment</h6>';
                                            else {
                                                $userAvatar = Auth::getAvatar();
                                                foreach ($avatarsArr['paths'] as $key => $value) {
                                                    $border = strpos($value, $userAvatar) ? (" border-dark border-4") : "";
                                                    echo '<img class="avatar p-0 col-3 col-sm-2 col-md-2 object-fit-cover border' . $border . '" src="' . $value . '" alt="Avatar 1" data-avatar="' . $avatarsArr['names'][$key] . '">';
                                                }
                                            }

                                            ?>
                                            <input type="text" name="avatar" id="selectedAvatar" value="<?= $userAvatar ?>" hidden>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" name="update-profile-image" class="btn btn-primary w-100">Save</button>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-stretch">
                            <div class="card w-100 border position-relative overflow-hidden">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Change Password</h4>

                                    <div class="valid-feedback mb-4">
                                        <?php echo isset($successes["resetPassword"]) ? $successes["resetPassword"] : "" ?>
                                    </div>

                                    <form method="POST">

                                        <div class="mb-4 position-relative">
                                            <label for="old_password" class="form-label">Current Password</label>
                                            <input type="password" value="<?= get_var("old_password") ?>" name="old_password" class="form-control" id="old_password">
                                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                                            <div class="invalid-feedback">
                                                <?php echo isset($errors["old_password"]) ? $errors["old_password"] : "" ?>
                                            </div>
                                        </div>
                                        <div class="mb-4 position-relative">
                                            <label for="new_password" class="form-label">New password</label>
                                            <input type="password" value="<?= get_var("password") ?>" name="password" class="form-control" id="password">
                                            <i class="bi bi-eye-slash pass2" id="togglePassword"></i>

                                        </div>
                                        <div class="mb-4 position-relative">
                                            <label for="password_confirm" class="form-label">Confirm password</label>
                                            <input type="password" value="<?= get_var("password_confirm") ?>" name="password_confirm" class="form-control" id="new_password_confirm">
                                            <i class="bi bi-eye-slash pass2-confirm" id="togglePassword"></i>
                                            <div class="invalid-feedback">
                                                <?php echo isset($errors["password"]) ? $errors["password"] : "" ?>
                                            </div>

                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-end gap-6">
                                                <button type="submit" name="resetPassword" class="btn btn-primary">Save</button>
                                                <a href="<?= $_SERVER['REQUEST_URI']; ?>" class="btn bg-danger-subtle text-danger">Cancel</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" id="account-details">
                            <div class="card w-100 border position-relative overflow-hidden mb-0">
                                <div class="card-body p-4">
                                    <h4 class="card-title">Personal Details</h4>
                                    <p class="card-subtitle mb-4">To change your personal detail , edit and save from here</p>
                                    <span class="valid-feedback"><?= isset($successes['accountUpdated']) ? $successes['accountUpdated'] : ""; ?></span>
                                    <form method="POST" class="needs-validation" enctype="multipart/form-data">
                                        <div class="row">
                                            <?php if (Auth::getRole() === 'admin') : ?>
                                                <div class="mb-3 col-lg-4 col-md-6">
                                                    <label for="companyName" class="form-label">Company Name</label>
                                                    <input type="text" value="<?= strlen(get_var("companyName")) ? get_var("companyName") : Auth::getCompanyName(); ?>" name="companyName" class="form-control" id="companyName">
                                                    <div class="invalid-feedback">
                                                        <?php echo isset($errors["companyName"]) ? $errors["companyName"] : "" ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-lg-4 col-md-6">
                                                    <label for="companyCUI" class="form-label">Unique identification code (CUI/CIF)</label>
                                                    <input type="text" value="<?= strlen(get_var("companyCUI")) ? get_var("companyCUI") : Auth::getCompanyCUI(); ?>" name="companyCUI" class="form-control" id="companyCUI">
                                                    <div class="invalid-feedback">
                                                        <?php echo isset($errors["companyCUI"]) ? $errors["companyCUI"] : "" ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-lg-4 col-md-6">
                                                    <label for="companyAddress" class="form-label">Company Address</label>
                                                    <input type="text" value="<?= strlen(get_var("companyAddress")) ? get_var("companyAddress") : Auth::getCompanyAddress(); ?>" name="companyAddress" class="form-control" id="companyAddress">
                                                    <div class="invalid-feedback">
                                                        <?php echo isset($errors["companyAddress"]) ? $errors["companyAddress"] : "" ?>
                                                    </div>
                                                </div>
                                                <div class="mb-3 col-lg-12 col-md-6">
                                                    <label for="companyType" class="form-label">Type of legal entity (SRL, PFA, etc.)</label>
                                                    <input type="text" value="<?= strlen(get_var("companyType")) ? get_var("companyType") : Auth::getCompanyType(); ?>" name="companyType" class="form-control" id="companyType">
                                                    <div class="invalid-feedback">
                                                        <?php echo isset($errors["companyType"]) ? $errors["companyType"] : "" ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                                <label for="username" class="form-label">Username</label>
                                                <input type="text" value="<?= strlen(get_var("username")) ? get_var("username") : Auth::getUsername(); ?>" name="username" class="form-control" id="username">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["username"]) ? $errors["username"] : "" ?>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                                <label for="firstname" class="form-label">First Name</label>
                                                <input type="text" value="<?= strlen(get_var("firstname")) ? get_var("firstname") : Auth::getFirstname(); ?>" name="firstname" class="form-control" id="firstname">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["firstname"]) ? $errors["firstname"] : "" ?>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                                <label for="lastname" class="form-label">Last Name</label>
                                                <input type="text" value="<?= strlen(get_var("lastname")) ? get_var("lastname") : Auth::getLastname(); ?>" name="lastname" class="form-control" id="lastname">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["lastname"]) ? $errors["lastname"] : "" ?>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                                <label for="birthday" class="form-label">Day of birth</label>
                                                <input type="date" value="<?= strlen(get_var("birthday")) ? get_var("birthday") : Auth::getBirthday(); ?>" name="birthday" class="form-control" id="birthday">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["birthday"]) ? $errors["birthday"] : "" ?>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                                <label for="email" class="form-label">Email address</label>
                                                <input type="text" value="<?= strlen(get_var("email")) ? get_var("email") : Auth::getEmail(); ?>" name="email" class="form-control" id="email">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["email"]) ? $errors["email"] : "" ?>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-lg-4 col-md-6">
                                                <label for="phone" class="form-label">Phone</label>
                                                <input type="text" value="<?= get_var("phone") ?>" name="phone" class="form-control" id="phone">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["phone"]) ? $errors["phone"] : "" ?>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="facebook" class="form-label">Facebook</label>
                                                <input type="text" value="<?= get_var("facebook") ?>" name="facebook" class="form-control" id="facebook">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["facebook"]) ? $errors["facebook"] : "" ?>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="instagram" class="form-label">Instagram</label>
                                                <input type="text" value="<?= get_var("instagram") ?>" name="instagram" class="form-control" id="instagram">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["instagram"]) ? $errors["instagram"] : "" ?>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="youtube" class="form-label">YouTube</label>
                                                <input type="text" value="<?= get_var("youtube") ?>" name="youtube" class="form-control" id="youtube">
                                                <div class="invalid-feedback">
                                                    <?php echo isset($errors["youtube"]) ? $errors["youtube"] : "" ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-end gap-6">
                                                <button type="submit" name="edit-account-details" class="btn btn-primary">Save</button>
                                                <a href="<?= $_SERVER['REQUEST_URI']; ?>" class="btn bg-danger-subtle text-danger">Cancel</a>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
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

<!-- show and hide the password -->
<script>
    const togglePassword = document
        .querySelector('#togglePassword');
    const togglePassword2 = document
        .querySelector('.pass2#togglePassword');
    const togglePassword3 = document
        .querySelector('.pass2-confirm#togglePassword');

    const passArray = [togglePassword, togglePassword2, togglePassword3];

    passArray.forEach(element => {
        element.addEventListener('click', () => {
            // Toggle the type attribute using
            // getAttribure() method
            const type = element.previousElementSibling
                .getAttribute('type') === 'password' ?
                'text' : 'password';
            element.previousElementSibling.setAttribute('type', type);
            // Toggle the eye and bi-eye icon
            element.classList.toggle('bi-eye');
        });
    });

    // Upload Button
    // JavaScript to handle button click and trigger file input
    document.getElementById('upload-button').addEventListener('click', function() {
        document.getElementById('file-input').click();

    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarList = document.getElementsByClassName('avatar');

        // Add click event listener to each avatar
        //   avatarList.forEach(function(avatar) {

        for (let avatar = 0; avatar < avatarList.length; avatar++) {
            avatarList[avatar].addEventListener('click', function() {
                // Remove border from all avatars
                for (let avatar = 0; avatar < avatarList.length; avatar++) {
                    avatarList[avatar].classList.remove("border-dark", "border-4");
                };
                this.classList.add("border-dark", "border-4");

                // Set the selected avatar value to a hidden input field (optional)
                document.getElementById('selectedAvatar').value = this.dataset.avatar;
            });
        };
    });
</script>