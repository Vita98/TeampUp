<?php require APPROOT . '/views/inc/header.php'; ?>

<form method="post">
    <div class="row">
        <div class="container text-center mt-3">
            <label class="display-4">Assegna team ad un partecipante</label>
            <p>In questa sezione è possibile assegnare un team ad un partecipante</p>
            <strong class="display-4"><?php echo $data['USER_DATA']; ?></strong>
        </div>
        <div class="container bg-light rounded mt-2 col-md-10">
            <div class="container text-center">
                <div class="d-flex justify-content-center mt-4"><?php flash('INVITE_CORRECTLY_SENT') ?></div>
                <hr>
                <?php if (isset($data[TEAM_LIST_KEY]) && is_array($data[TEAM_LIST_KEY])): ?>
                    <?php if (count($data[TEAM_LIST_KEY]) > 0): ?>
                        <?php foreach ($data[TEAM_LIST_KEY] as $team): ?>
                            <div class="row mb-3 mt-3">
                                <div class="col-md-6 ">
                                    <kbd style= "color: darkslategray;" class="text-left alert-info"><label for="description"><strong><?php echo $team->getName(); ?></strong></label></kbd>
                                </div>
                                <div class="col-md-6">
                                    <div>Aggiungi a Team</div>
                                    <input
                                        type="checkbox"
                                        name="<?php echo TEAM_CHECKED_NAME; ?>[]"
                                        value="<?php echo $team->getId();?>">
                                </div>
                            </div>
                            <hr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Non hai team a cui poter aggiungere l'utente</p>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="row align-items-center mb-5 mt-5">
                    <div class="col">
                        <input type="submit" value="Aggiungi" class="btn btn-success btn-block">
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
<?php require APPROOT . '/views/inc/footer.php'; ?>
