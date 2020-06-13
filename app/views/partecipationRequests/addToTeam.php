<?php require APPROOT . '/views/inc/header.php'; ?>


<div class="row">
    <div class="container text-center mt-3">
        <label class="display-4">Assegna team ad un partecipante</label>
        <p>In questa sezione è possibile assegnare un team al partecipante <strong><?php echo $data['USER_DATA']; ?></strong></p>
    </div>
</div>
<hr>
<?php if (isset($data[TEAM_LIST_KEY]) && is_array($data[TEAM_LIST_KEY]) && count($data[TEAM_LIST_KEY]) > 0): ?>
            <form method="post">
                <div class="container bg-light rounded mt-2 col-md-10">
                    <div class="container text-center">
                        <div class="d-flex justify-content-center mt-4"><?php flash('INVITE_CORRECTLY_SENT') ?></div>
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
                        <div class="row align-items-center mb-5 mt-5">
                            <div class="col">
                                <input type="submit" value="Aggiungi" class="btn btn-success btn-block">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
<?php else: ?>
    <div class="alert alert-danger text-center" role="alert">
        <strong>Questa idea non possiede team</strong>
    </div>
<?php endif; ?>

<hr>


<?php require APPROOT . '/views/inc/footer.php'; ?>
