<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card card-body bg-light mt-5">
                <?php flash('register_success'); ?>
                <h2>Login</h2>
                <p>Inserisci le tue credenziali per effettuare il login</p>
                <form action="<?php echo URLROOT; ?>/users/login" method="post">
                    <div class="form-group">
                        <label for="email">Email: <sup>*</sup></label>
                        <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data[ERRORS_KEY]['email'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data["userDTO"]->getEmail(); ?>">
                        <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]['email']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password: <sup>*</sup></label>
                        <input type="password" name="psw" class="form-control form-control-lg <?php echo (!empty($data[ERRORS_KEY]['psw'])) ? 'is-invalid' : ''; ?>" value="">
                        <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]['psw']; ?></span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="submit" value="Login" class="btn btn-success btn-block">
                        </div>
                        <div class="col">
                            <a href="<?php echo URLROOT; ?>/users/signUp" class="btn btn-light btn-block">Registrati ora!</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>