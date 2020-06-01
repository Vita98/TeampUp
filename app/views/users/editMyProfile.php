<?php require APPROOT . '/views/inc/header.php'; ?>

<?php
define('IS_INVALID_CLASS',"is-invalid");
?>

    <div class="row">
        <div class="container text-center ">
            <label class="display-4 ">Modifica Profilo</label>
            <p>In questa sezione è possibile modificare i dati del profilo</p>
        </div>
        <div class="container bg-light border rounded mt-3 col-md-10 p-5">
            <form action="<?php echo URLROOT; ?>/users/editMyProfile" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="firstName" class="d-flex justify-content-center">Nome: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="firstName" class="form-control form-control-sm <?php echo (!empty($data[ERRORS_KEY]['firstName'])) ? IS_INVALID_CLASS : ''; ?>" value="<?php if (isset($data[USERDTO_KEY])) { echo $data[USERDTO_KEY]->getFirstName();}?>">
                            <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]["firstName"]; ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="lastName" class="d-flex justify-content-center">Cognome: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="lastName" class="form-control form-control-sm <?php echo (!empty($data[ERRORS_KEY]['lastName'])) ? IS_INVALID_CLASS : ''; ?>" value="<?php if (isset($data[USERDTO_KEY])) {echo $data[USERDTO_KEY]->getLastName();}?>">
                            <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]["lastName"]; ?></span>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="abilities" class="d-flex justify-content-center">Abilità: </label>
                        </div>
                        <div class="col-md-9">
                            <?php if (isset($data['allAbilities'])) : foreach($data['allAbilities'] as $ability): ?>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="abilities[]" id = "<?php echo $ability->getId()?>"
                                        value="<?php echo $ability->getId()?>"
                                        <?php foreach ($data['userAbilities'] as $userAbility){
                                            if($ability->getId() == $userAbility->getId()) { echo "checked"; }
                                        }?>>
                                        <?php echo $ability->getDescription()?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            <?php else : ?>
                                <label>Non ci sono abilità nella base di dati!</label>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="old_psw" class="d-flex justify-content-center">Vecchia Password: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" name="old_psw" class="form-control form-control-sm <?php echo (!empty($data[ERRORS_KEY]['old_psw'])) ? IS_INVALID_CLASS : ''; ?>" value="">
                            <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]["old_psw"]; ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="new_psw" class="d-flex justify-content-center">Nuova Password: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" name="new_psw" class="form-control form-control-sm <?php echo (!empty($data[ERRORS_KEY]['new_psw'])) ? IS_INVALID_CLASS : ''; ?>" value="">
                            <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]["new_psw"]; ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="confirm_psw" class="d-flex justify-content-center">Conferma Password: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" name="confirm_psw" class="form-control form-control-sm <?php echo (!empty($data[ERRORS_KEY]['confirm_psw'])) ? IS_INVALID_CLASS : ''; ?>" value="">
                            <span class="invalid-feedback"><?php echo $data[ERRORS_KEY]["confirm_psw"]; ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col mt-5">
                        <input type="submit" value="Modifica" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>