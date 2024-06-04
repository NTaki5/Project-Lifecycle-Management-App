<?php
$this->view("/includes/header");
?>
<!-- SignIn modal content -->
<div id="login-modal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Session Timeout </h5>
            </div>
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <span class="text-success">
                        <span>
                            <img src="assets/images/logos/logo.png" class="me-3 img-fluid" alt="matdash-img" />
                        </span>
                    </span>
                </div>

                <form method="POST">
                    <div class="mb-3">
                        <label for="inputEmail" class="form-label">Email or Username</label>
                        <input type="text" value="<?= get_var("email") ?>" class="form-control" name="email" id="inputEmail" />
                    </div>
                    <div class="mb-2 position-relative">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" value="<?= get_var("password") ?>" name="password" class="form-control" id="inputPassword" />
                        <i class="bi bi-eye-slash" id="togglePassword"></i>
                    </div>
                    <div class="invalid-feedback mt-2 mb-4">
                        <?php echo isset($errors["emailOrPassword"]) ? $errors["emailOrPassword"] : "" ?>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customCheck2" />
                            <label class="form-check-label" for="customCheck2">Remember me</label>
                        </div>
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn btn-rounded bg-info-subtle text-info " type="submit">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php
$this->view("/includes/footer");
?>

<!-- Script to show modal on page load -->
<script defer>
    $(document).ready(function() {
        $('#login-modal').modal({
            backdrop: 'static',
            keyboard: false
        }).modal('show');
    });

    const togglePassword = document.querySelector('#togglePassword');

    togglePassword.addEventListener('click', () => {
      // Toggle the type attribute using
      // getAttribure() method
      const type = togglePassword.previousElementSibling
        .getAttribute('type') === 'password' ?
        'text' : 'password';
      togglePassword.previousElementSibling.setAttribute('type', type);
      // Toggle the eye and bi-eye icon
      togglePassword.classList.toggle('bi-eye');
    });
  </script>