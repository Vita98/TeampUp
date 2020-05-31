<?php require APPROOT . '/views/inc/header.php'; ?>

<?php
define('IS_INVALID_CLASS',"is-invalid");
?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Create An Account</h2>
                <p>Please fill out this form to register with us</p>
                <form action="<?php echo URLROOT; ?>/users/signUp" method="post">
                    <div class="form-group">
                        <label for="name">First Name: <sup>*</sup></label>
                        <input type="text" name="firstName" class="form-control form-control-lg <?php echo (!empty($data[ERRORS_KEY]["firstName"])) ? IS_INVALID_CLASS : ''; ?>" value="<?php echo $data[USERDTO_KEY]->getFirstName(); ?>">
                        <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]["firstName"]; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Last Name: <sup>*</sup></label>
                        <input type="text" name="lastName" class="form-control form-control-lg <?php echo (!empty($data[ERRORS_KEY]['lastName'])) ? IS_INVALID_CLASS : ''; ?>" value="<?php echo $data[USERDTO_KEY]->getLastName(); ?>">
                        <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]['lastName']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data[ERRORS_KEY]['email'])) ? IS_INVALID_CLASS : ''; ?>" value="<?php echo $data[USERDTO_KEY]->getEmail(); ?>">
                        <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]['email']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="psw" class="form-control form-control-lg <?php echo (!empty($data[ERRORS_KEY]['psw'])) ? IS_INVALID_CLASS : ''; ?>" value="<?php echo $data[USERDTO_KEY]->getPsw(); ?>">
                        <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]['psw']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                        <input type="password" name="confirm_psw" class="form-control form-control-lg <?php echo (!empty($data[ERRORS_KEY]['confirm_psw'])) ? IS_INVALID_CLASS : ''; ?>" value="">
                        <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]['confirm_psw']; ?></span>
                    </div>

                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Register" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-light btn-block">Have an account? Login</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>