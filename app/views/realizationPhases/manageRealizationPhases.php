<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">

    <div class="container text-center mt-3">
        <label class="display-4">Gestisci le fasi di realizzazione</label>
        <p>In questa sezione è gestire le fasi di realizzazione</p>
    </div>
    <div class="container bg-light rounded mt-2 col-md-10">
        <div class="container text-center">
            <div class="d-flex justify-content-center mt-4"><?php flash(IDEA_MESSAGE) ?></div>
            <div class="row mt-3 justify-content-md-center">
                <div class="col-6 mt-3 mb-3">
                    <a href="<?php echo URLROOT; ?>/realizationPhases/newRealizationPhase/<?php echo $data[IDEA_DTO]->getId(); ?>" style="">
                        <div class="row d-flex justify-content-center">
                            <svg class="bi bi-file-plus" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8h-1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h5V1z"/>
                                <path fill-rule="evenodd" d="M13.5 1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V1.5a.5.5 0 0 1 .5-.5z"/>
                                <path fill-rule="evenodd" d="M13 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-12">Inserisci una nuova fase di realizzazione</div>
                        </div>
                    </a>
                </div>
            </div>
            <hr>
            <?php   if($data[REALIZATION_PHASE_DTO] == null):?>
                <div class="alert alert-danger" role="alert">
                    <strong>Questa idea non possiede fasi di realizzazione</strong>
                </div>
            <?php else :?>



            <?php foreach ($data[REALIZATION_PHASE_DTO] as $realizationPhase): ?>

            <div class="row mb-3 mt-3">
                <div class="col-md-6 mt-4">
                    <kbd style= "color: darkslategray;" class="text-left alert-info"><label for="description"><strong><?php echo $realizationPhase->getName(); ?></strong></label></kbd>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-4 mt-3 ">
                            <a href="#" style="color: gray">
                                <div class="row d-flex justify-content-center">
                                    <svg class="bi bi-gear" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                                        <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                                    </svg>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">Gestisci</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4 mt-3 ">
                            <a href="<?php echo URLROOT; ?>/RealizationPhases/editRealizationPhase/<?php echo $realizationPhase->getId(); ?>" style="">
                                <div class="row d-flex justify-content-center">
                                    <svg class="bi bi-pencil" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                        <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                                    </svg>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">Modifica</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-4 mt-3 ">
                            <a href="javascript:updatePopup('<?php echo URLROOT;?>/realizationPhases/deleteRealizationPhase/<?php echo $realizationPhase->getId();?>')" style="color: red" >
                                <div class="row d-flex justify-content-center">
                                    <svg class="bi bi-trash" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">Elimina</div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <hr>
            <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
