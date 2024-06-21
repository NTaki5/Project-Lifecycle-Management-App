<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="<?= ROOT ?>/assets/images/logos/logo.png" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <!-- Core Css -->
  <link rel="stylesheet" href="<?= ROOT ?>/assets/css/styles.css" />

  <title>Project Lifecycle Managemenet</title>
</head>

<body>
<?php
  // if(!isset($_SESSION['welcome-toast']))
  echo Toast::show("show toast-onload");
  ?>
  <!-- Preloader -->
  <div class="preloader">
    <img src="<?= ROOT ?>/assets/images/logos/logo.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
      <div class="position-relative z-index-5">
        <div class="row gx-0">

          <div class="col-lg-6 col-xl-5 col-xxl-4">
            <div class="min-vh-100 bg-body row justify-content-center justify-content-lg-start align-items-center p-5">
              <div class="col-12 auth-card">
                <a href="../index.html" class="text-nowrap logo-img d-block w-100">
                  <img src="<?= ROOT ?>/assets/images/logos/logo.png" class="dark-logo" alt="Logo-Dark" />
                </a>

                <?php if($passwordForm): ?>
                <h2 class="mb-2 mt-4 fs-7 fw-bolder">Change the password</h2>
                <!-- <p class="mb-9">Change the password</p> -->
                    <form method="POST">
                        
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
                            <i class="bi bi-eye-slash pass2" id="togglePassword2"></i>
                        </div>
                        <button type="submit" name="reset-password" class="btn btn-primary w-100 py-8 mb-3">Reset password</button>
                    </form>
                <?php else: ?>
                <h2 class="mb-2 mt-4 fs-7 fw-bolder">Forgot Password</h2>
                <p class="mb-9">Please enter the email address associated with your account and We will email you a link
                  to reset your password.</p>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="text" value="<?= get_var("email") ?>" class="form-control" id="email" name="email">
                        </div>
                        <div class="invalid-feedback mt-2 mb-4">
                            <?php echo isset($errors["email"]) ? $errors["email"] : "" ?>
                        </div>
                        <button type="submit" name="send-email" class="btn btn-primary w-100 py-8 mb-3">Forgot Password</button>
                        <a href="login" class="btn bg-primary-subtle text-primary w-100 py-8">Back to Login</a>
                    </form>
                <?php endif;?>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-7 col-xxl-8 position-relative overflow-hidden bg-dark d-none d-lg-block">
            <div class="circle-top"></div>
            <div>
              <img src="<?= ROOT ?>/assets/images/logos/logo.png" class="circle-bottom" alt="Logo-Dark" />
            </div>
            <div class="d-lg-flex align-items-center z-index-5 position-relative h-n80">
              <div class="row justify-content-center w-100">
                <div class="col-lg-6">
                <h2 class="text-white fs-10 mb-3 lh-base">
                    Welcome to
                    <br />
                    Project Lifecycle Management
                  </h2>
                  <span class="opacity-75 fs-4 text-white d-block mb-3">
                    your trusted partner in managing and streamlining your project lifecycle. Our mission is to provide you with the tools and support you need to plan, execute, and track your projects efficiently.
                  </span>
                  <a href="../landingpage/index.html" class="btn btn-primary">Learn More</a>
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
  <script src="<?= ROOT ?>/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?= ROOT ?>/assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="<?= ROOT ?>/assets/js/app/app.init.js"></script>
  <script src="<?= ROOT ?>/assets/js/app/theme.js"></script>
  <script src="<?= ROOT ?>/assets/js/app/app.min.js"></script>
  <script src="<?= ROOT ?>/assets/js/app/sidebarmenu.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  <script defer>
    const togglePassword = document
      .querySelector('#togglePassword');
    const togglePassword2 = document
      .querySelector('#togglePassword2');

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
</body>

</html>