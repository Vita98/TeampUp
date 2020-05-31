<?php require APPROOT . '/views/inc/header.php'; ?>

    <div class="row">
        <div class="container bg-light rounded mt-3 col-md-10">
            <div class="container text-center p-3">
                <label class="display-4 ">Modifica Profilo</label>
            </div>

            <form action="<?php echo URLROOT; ?>/users/editMyProfile" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="firstName" class="d-flex justify-content-center">Nome: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="firstName" class="form-control form-control-sm <?php echo (!empty($data["errors"]['firstName'])) ? 'is-invalid' : ''; ?>" value="<?php if (isset($data['userDTO'])) echo ($data['userDTO']->getFirstName());?>">
                            <span class="invalid-feedback"><?php echo $data["errors"]["firstName"]; ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="lastName" class="d-flex justify-content-center">Cognome: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="lastName" class="form-control form-control-sm <?php echo (!empty($data["errors"]['lastName'])) ? 'is-invalid' : ''; ?>" value="<?php if (isset($data['userDTO'])) echo ($data['userDTO']->getLastName());?>">
                            <span class="invalid-feedback"><?php echo $data["errors"]["lastName"]; ?></span>
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
                                            if($ability->getId() == $userAbility->getId()) echo "checked";
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
                            <input type="password" name="old_psw" class="form-control form-control-sm <?php echo (!empty($data["errors"]['old_psw'])) ? 'is-invalid' : ''; ?>" value="">
                            <span class="invalid-feedback"><?php echo $data["errors"]["old_psw"]; ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="new_psw" class="d-flex justify-content-center">Nuova Password: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" name="new_psw" class="form-control form-control-sm <?php echo (!empty($data["errors"]['new_psw'])) ? 'is-invalid' : ''; ?>" value="">
                            <span class="invalid-feedback"><?php echo $data["errors"]["new_psw"]; ?></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="confirm_psw" class="d-flex justify-content-center">Conferma Password: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="password" name="confirm_psw" class="form-control form-control-sm <?php echo (!empty($data["errors"]['confirm_psw'])) ? 'is-invalid' : ''; ?>" value="">
                            <span class="invalid-feedback"><?php echo $data["errors"]["confirm_psw"]; ?></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col p-5">
                        <input type="submit" value="Modifica" class="btn btn-outline-warning btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>