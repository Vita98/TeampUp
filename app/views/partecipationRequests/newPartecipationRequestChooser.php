<?php require APPROOT . '/views/inc/header.php'; ?>

    <div class="row">
        <div class="container text-center ">
            <label class="display-4 ">Invia richiesta di partecipazione</label>
            <p>In questa sezione cercare gli utenti a cui inviare la richiesta di partecipazione</p>
        </div>
        <div class="container bg-light border rounded mt-3 col-md-10 p-5">
            <form action="<?php echo URLROOT; ?>/partecipationRequests/newPartecipationRequestChooser/<?php echo $data['ideaId']; ?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="firstName" class="d-flex justify-content-center">Nome: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="firstName" class="form-control form-control-sm" value="<?php if (isset($data[FIRST_NAME_KEY]) && !empty($data[FIRST_NAME_KEY])) { echo $data[FIRST_NAME_KEY];}?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="lastName" class="d-flex justify-content-center">Cognome: </label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="lastName" class="form-control form-control-sm" value="<?php if (isset($data[LAST_NAME_KEY])) {echo $data[LAST_NAME_KEY];}?>">
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
                            <?php if (isset($data[USER_ABILITIES_KEY])) : foreach($data[USER_ABILITIES_KEY] as $ability): ?>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="checked[]" id = "<?php echo $ability->getId()?>"
                                               value="<?php echo $ability->getId()?>"
                                            <?php if (!empty($data[CHECKED] && in_array($ability->getId(), $data[CHECKED]))){
                                                echo "checked";
                                            }?>>
                                        <?php echo $ability->getDescription();?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            <?php else : ?>
                                <label>Non ci sono abilità nella base di dati!</label>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mt-5">
                        <input type="submit" value="Search" class="btn btn-success btn-block">
                    </div>
                </div>

            </form>
        </div>
    </div>
    <div class = "container rounded mt-5 col-md-8">
        <?php if(isset($data[USERDTO_KEY]) && !empty($data[USERDTO_KEY])) : foreach($data[USERDTO_KEY]as $dto): ?>
            <div class="card card-body bg-light mt-5">
                <div class="justify-center">
                    <div class="form-group mt-3 ">
                        <label for="firstName" class="display-5 font-weight-bolder">Nome: </label>
                        <label for="firstName"><?php echo $dto->getFirstName();?></label>
                    </div>
                    <div class="form-group mt-3 ">
                        <label for="lastName" class="display-5 font-weight-bolder">Cognome: </label>
                        <label for="lastName"><?php echo $dto->getLastName();?></label>
                    </div>
                    <div class="form-group mt-3 text-right">
                        <button onclick="updatePopup('<?php echo URLROOT; ?>/partecipationRequests/sendPartecipationRequest/<?php echo $data['ideaId']; ?>/false/<?php echo $dto->getId()?>')" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                        Invita
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php elseif (isset($data[USERDTO_KEY]) && empty($data[USERDTO_KEY]) && $data['post']): ?>
            <div class="alert alert-warning text-center mt-5 mb-5" role="alert">
                Non puoi invitare nassun utente a partecipare alla tua idea!
            </div>
        <?php endif;?>
    </div>

    <?php
        $popUpData['modal-title'] = "Sei sicuro?";
        $popUpData['modal-body'] = "Sei sicuro di voler invitare questo utente a partecipare alla tua idea?";
        $popUpData['modal-primary'] = "Invia";
        $popUpData['modal-secondary'] = "Annulla";
        require_once APPROOT.'/views/inc/pop-Up.php';
    ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>