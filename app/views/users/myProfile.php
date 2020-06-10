<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="container text-center mt-3">
            <label class="display-4 ">Il Mio Profilo</label>
            <p>Questo è il tuo profilo</p>
        </div>
        <div class="container bg-light rounded mt-3 col-md-10 p-3">
            <?php flash('profile_edit_success'); ?>

            <div class="row justify-content-center ">
                <div class="col-dm-12 mt-2 ">
                    <label for="firstName" class="display-5 font-weight-bolder">Nome: </label>
                    <label for="firstName"><?php if (isset($data[USERDTO_KEY])) {echo $data[USERDTO_KEY]->getFirstName();}?></label>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-dm-12 mt-3">
                    <label for="firstName" class="display-5 font-weight-bolder">Cognome: </label>
                    <label for="firstName"><?php if (isset($data[USERDTO_KEY])) {echo $data[USERDTO_KEY]->getLastName();}?></label>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-dm-12 mt-3">
                    <label for="firstName" class="display-5 font-weight-bolder">Email: </label>
                    <label for="firstName"><?php if (isset($data[USERDTO_KEY])) {echo $data[USERDTO_KEY]->getEmail();}?></label>
                </div>
            </div>
            <div class="row justify-content-center ">
                <div class="col-dm-12 mt-3">
                    <label for="firstName" class="display-5 font-weight-bolder">Lista Abilità: </label>

                    <?php if (isset($data['userAbilities'])) : foreach($data['userAbilities'] as $userAbility): ?>
                        <kbd><label for="description"><?php echo$userAbility->getDescription(); ?></label></kbd>
                    <?php endforeach; ?>
                    <?php else : ?>
                        <label>Non hai associato nessuna abilità!</label>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>