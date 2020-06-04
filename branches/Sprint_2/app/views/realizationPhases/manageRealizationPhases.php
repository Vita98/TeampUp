<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">

    <div class="container bg-light rounded mt-5 col-md-10">
        <div class="container text-center">
            <div class="pt-4">
                <label class="display-4 "><strong>Gestisci le fasi di realizzazione</strong></label>
            </div>
            <hr>
            <?php   if($data[REALIZATION_PHASE_DTO] == null):?>
                <div class="alert alert-danger" role="alert">
                    <strong>Questa idea non possiede fasi di realizzazione</strong>
                </div>
            <?php else :?>
                <?php foreach ($data[REALIZATION_PHASE_DTO] as $realizationPhase): ?>
                    <kbd style= "color: darkslategray;" class="text-left alert-info"><label for="description"><strong><?php echo $realizationPhase->getName(); ?></strong></label></kbd>
                    <div class="btn-group pull-right" role="group" aria-label="Basic example">
                        <a href="<?php echo URLROOT; ?>/RealizationPhases/editRealizationPhase/<?php echo $realizationPhase->getId(); ?>" type="button" class="btn btn-primary">Modifica</a>
                        <button type="button" id="EliminaButton" onclick="updatePopup('<?php echo URLROOT;?>/realizationPhases/deleteRealizationPhase/<?php echo $realizationPhase->getId();?>')" class="btn btn-danger ml-1" data-toggle="modal" data-target="#exampleModalCenter"> Elimina </button>
                        <button type="button" class="btn btn-secondary ml-1">Gestisci</button>
                    </div>
                    <br>
                    <hr>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
