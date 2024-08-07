<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href=" <?= ROOT ?>/assets/images/logos/logo.png" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <!-- Core Css -->
  <link rel="stylesheet" href="assets/css/styles.css" />

  <title>Project Lifecycle Managemenet</title>
</head>

<body>
<?php
  // if(!isset($_SESSION['welcome-toast']))
  echo Toast::show("show toast-onload");
  ?>
  <!-- Preloader -->
  <div class="preloader">
    <img src=" <?= ROOT ?>/assets/images/logos/logo.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
      <div class="position-relative z-index-5">
        <div class="row gx-0">

          <div class="col-lg-6 col-xl-5 col-xxl-4">
            <div class="authentication-login min-vh-100 bg-body row justify-content-center justify-content-lg-start align-items-center p-5">
              <div class="col-12 auth-card">
                <a href=" <?= ROOT ?>/main/index.html" class="text-nowrap logo-img d-block w-100">
                  <img src=" <?= ROOT ?>/assets/images/logos/logo.png" class="dark-logo" alt="Logo-Dark" />
                </a>
                <h2 class="mb-2 mt-4 fs-7 fw-bolder">Sign Up</h2>
                <!-- <div class="row">
                  <div class="col-6 mb-2 mb-sm-0">
                    <a class="btn btn-link border border-muted d-flex align-items-center justify-content-center rounded-2 py-8 text-decoration-none" href="javascript:void(0)" role="button">
                      <img src=" <?= ROOT ?>/assets/images/svgs/google-icon.svg" alt="PLM-img" class="img-fluid me-2" width="18" height="18" />
                      Google
                    </a>
                  </div>
                  <div class="col-6">
                    <a class="btn btn-link border border-muted d-flex align-items-center justify-content-center rounded-2 py-8 text-decoration-none" href="javascript:void(0)" role="button">
                      <img src=" <?= ROOT ?>/assets/images/svgs/facebook-icon.svg" alt="PLM-img" class="img-fluid me-2" width="18" height="18" />
                      Facebook
                    </a>
                  </div>
                </div> -->
                <!-- <div class="position-relative text-center my-4">
                  <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">
                    or sign up with
                  </p>
                  <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                </div> -->
                <form method="POST" class="needs-validation" enctype="multipart/form-data">

                  <?php if (!isset($_GET['token'])) : ?>
                    <div class="mb-3">
                      <label for="companyName" class="form-label">Company Name</label>
                      <input type="text" value="<?= get_var("companyName") ?>" name="companyName" class="form-control" id="companyName">
                      <div class="invalid-feedback">
                        <?php echo isset($errors["companyName"]) ? $errors["companyName"] : "" ?>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="companyCUI" class="form-label">Unique identification code (CUI/CIF)</label>
                      <input type="text" value="<?= get_var("companyCUI") ?>" name="companyCUI" class="form-control" id="companyCUI">
                      <div class="invalid-feedback">
                        <?php echo isset($errors["companyCUI"]) ? $errors["companyCUI"] : "" ?>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="companyAddress" class="form-label">Company Address</label>
                      <input type="text" value="<?= get_var("companyAddress") ?>" name="companyAddress" class="form-control" id="companyAddress">
                      <div class="invalid-feedback">
                        <?php echo isset($errors["companyAddress"]) ? $errors["companyAddress"] : "" ?>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="companyType" class="form-label">Type of legal entity (SRL, PFA, etc.)</label>
                      <input type="text" value="<?= get_var("companyType") ?>" name="companyType" class="form-control" id="companyType">
                      <div class="invalid-feedback">
                        <?php echo isset($errors["companyType"]) ? $errors["companyType"] : "" ?>
                      </div>
                    </div>
                  <?php endif; ?>

                  <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" value="<?= get_var("username") ?>" name="username" class="form-control" id="username">
                    <div class="invalid-feedback">
                      <?php echo isset($errors["username"]) ? $errors["username"] : "" ?>
                    </div>
                  </div>

                  <?php if (isset($_GET['token'])): ?>
                    <div class="mb-3">
                      <label for="occupation" class="form-label">Occupation</label>
                      <input type="text" value="<?= get_var("occupation") ?>" name="occupation" class="form-control" id="occupation">
                      <div class="invalid-feedback">
                        <?php echo isset($errors["occupation"]) ? $errors["occupation"] : "" ?>
                      </div>
                    </div>
                  <?php endif; ?>
                  <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" value="<?= strlen(get_var("name"))? get_var("name") : (isset($invitationDatas->name) ? $invitationDatas->name : "");?>" name="name" class="form-control" id="name">
                    <div class="invalid-feedback">
                      <?php echo isset($errors["name"]) ? $errors["name"] : "" ?>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="birthday" class="form-label">Day of birth</label>
                    <input type="date" value="<?= get_var("birthday") ?>" name="birthday" class="form-control" id="birthday">
                    <div class="invalid-feedback">
                      <?php echo isset($errors["birthday"]) ? $errors["birthday"] : "" ?>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text" value="<?= strlen(get_var("email"))? get_var("email") : (isset($invitationDatas->email) ? $invitationDatas->email : ""); ?>" name="email" class="form-control" id="email">
                    <div class="invalid-feedback">
                      <?php echo isset($errors["email"]) ? $errors["email"] : "" ?>
                    </div>
                  </div>
                  <div class="mb-3">
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
                  <div class="mb-4 position-relative">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" value="<?= get_var("password") ?>" name="password" class="form-control" id="password">
                    <i class="bi bi-eye-slash" id="togglePassword"></i>
                    <div class="invalid-feedback">
                      <?php echo isset($errors["password"]) ? $errors["password"] : "" ?>
                    </div>
                  </div>
                  <div class="mb-4 position-relative">
                    <label for="password2" class="form-label">Retype password</label>
                    <input type="password" value="<?= (!isset($errors["password"])) ? get_var("password2") : "" ?>" name="password2" class="form-control" id="password2">
                    <i class="bi bi-eye-slash pass2" id="togglePassword"></i>

                  </div>
                  <div class="mb-4 position-relative">
                    <label for="image" class="form-label">Profile image
                      <span>(Upload your photo, or choose an avatar)</span>
                    </label>
                    <div class="row signup our-avatars w-100 m-auto mb-4 justify-content-center">
                      <input type="file" name="image" class="form-control col-12 mb-3" accept="images/*">

                      <?php $avatarsArr = get_avatars();

                      if (!count($avatarsArr)) echo '<h6>No avatars at the moment</h6>';
                      foreach ($avatarsArr['paths'] as $key => $value) {
                        echo '<img class="avatar p-0 col-3 col-sm-2 col-md-2 object-fit-cover border" src="' . $value . '" alt="Avatar 1" data-avatar="' . $avatarsArr['names'][$key] . '">';
                      }

                      ?>
                      <input type="text" name="avatar" id="selectedAvatar" hidden>
                    </div>
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">Sign Up</button>
                  <div class="d-flex align-items-center">
                    <p class="fs-4 mb-0 text-dark">Already have an Account?</p>
                    <a class="text-primary fw-medium ms-2" href=" <?= ROOT ?>/login">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-7 col-xxl-8 position-relative overflow-hidden bg-dark d-none d-lg-block">
            <div class="circle-top"></div>
            <div>
              <img src=" <?= ROOT ?>/assets/images/logos/logo.png" class="circle-bottom" alt="Logo-Dark" />
            </div>
            <div class="d-lg-flex align-items-center z-index-5 position-relative h-n80 position-fixed top-0">
              <div class="row justify-content-center w-100">
                <div class="col-lg-6">
                  <h2 class="text-white fs-10 mb-3 lh-base">
                    Welcome to
                    <br />
                    ProLifeManagement
                  </h2>
                  <span class="opacity-75 fs-4 text-white d-block mb-3">
                    your trusted partner in managing and streamlining your project lifecycle. Our mission is to provide you with the tools and support you need to plan, execute, and track your projects efficiently.
                  </span>
                  <a href=" <?= ROOT ?>/login" class="btn btn-primary">Sign In</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->
  <script src=" <?= ROOT ?>/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src=" <?= ROOT ?>/assets/js/app/theme.js"></script>
  <script src=" <?= ROOT ?>/assets/js/custom/bootstrapValidate.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script src="<?= ROOT ?>/assets/libs/dropzone/dist/min/dropzone.min.js"></script>
  <!-- show and hide the password -->
  <script defer>
    const togglePassword = document
      .querySelector('#togglePassword');
    const togglePassword2 = document
      .querySelector('.pass2#togglePassword');

    const passArray = [togglePassword, togglePassword2];

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
  </script>


  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const avatarList = Array.from(document.getElementsByClassName('avatar'));

      // Add click event listener to each avatar
      avatarList.forEach(function(avatar) {
        avatar.addEventListener('click', function() {
          // Remove border from all avatars
          avatarList.forEach(function(a) {
            a.classList.remove("border-dark", "border-4");
          });
          this.classList.add("border-dark", "border-4");

          // Set the selected avatar value to a hidden input field (optional)
          document.getElementById('selectedAvatar').value = this.dataset.avatar;
        });
      });
    });
  </script>
</body>

</html>