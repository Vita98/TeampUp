<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <h2>Create An Account</h2>
                <p>Please fill out this form to register with us</p>
                <form action="<?php echo URLROOT; ?>/users/signUp" method="post">
                    <div class="form-group">
                        <label for="name">First Name: <sup>*</sup></label>
                        <input type="text" name="firstName" class="form-control form-control-lg <?php echo (!empty($data["errors"]["firstName"])) ? 'is-invalid' : ''; ?>" value="<?php echo $data["userDTO"]->getFirstName(); ?>">
                        <span class="invalid-feedback"><?php echo $data["errors"]["firstName"]; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="name">Last Name: <sup>*</sup></label>
                        <input type="text" name="lastName" class="form-control form-control-lg <?php echo (!empty($data["errors"]['lastName'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data["userDTO"]->getLastName(); ?>">
                        <span class="invalid-feedback"><?php echo $data["errors"]['lastName']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data["errors"]['email'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data["userDTO"]->getEmail(); ?>">
                        <span class="invalid-feedback"><?php echo $data["errors"]['email']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="psw" class="form-control form-control-lg <?php echo (!empty($data["errors"]['psw'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data["userDTO"]->getPsw(); ?>">
                        <span class="invalid-feedback"><?php echo $data["errors"]['psw']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password: <sup>*</sup></label>
                        <input type="password" name="confirm_psw" class="form-control form-control-lg <?php echo (!empty($data["errors"]['confirm_psw'])) ? 'is-invalid' : ''; ?>" value="">
                        <span class="invalid-feedback"><?php echo $data["errors"]['confirm_psw']; ?></span>
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