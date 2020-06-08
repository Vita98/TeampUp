<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="container text-center mt-3">
            <label class="display-4">Nuovo team</label>
            <p>Compila il form per aggiungere un nuovo team</p>
        </div>

        <div class="card card-body bg-light mt-5">
            <form action="<?php echo URLROOT; ?>/teams/newTeam/" method="post">
                <div class="form-group">
                    <strong><label for="title">Nome*</label></strong>
                    <input type="text" placeholder = "Inserisci un nome" name="<?php echo TITLE_FIELD?>" class="form-control form-control-lg
                    <?php echo (!empty($data[ERRORS][TITLE_FIELD])) ? 'is-invalid' : ''; ?>" value="<?php echo $data[TEAM_DTO]->getName(); ?>"/>
                    <span class="invalid-feedback"><?php echo $data[ERRORS][TITLE_FIELD]; ?></span>
                </div>
                <strong><label>Fasi di realizzazione*</label></br></strong>
                <div>
                    <?php foreach($data[REALIZATION_PHASE] as $realizationPhase): ?>
                        <div class='form-check form-check-inline'>
                            <?php if (in_array($realizationPhase->getId(), $data[CHECKED])) :?>
                                <input class='form-check-input' checked='checked' type='checkbox'
                                       name='<?php echo REALIZATION_PHASE . "[]"?>' id='<?php echo $realizationPhase->getId()?>'
                                       value='<?php echo $realizationPhase->getId()?>'/>
                            <?php else : ?>
                                <input class='form-check-input' type='checkbox' name='<?php echo REALIZATION_PHASE . "[]"?>'
                                       id='<?php echo $realizationPhase->getId()?>' value='<?php echo $realizationPhase->getId()?>'/>
                            <?php endif; ?>
                            <label for='<?php echo REALIZATION_PHASE."[]"; ?>' class ='form-check-label'> <?php echo $realizationPhase->getName(); ?> </label>
                        </div>
                    <?php endforeach; ?>
                    <input type="text" name = "ideaId" hidden = "hidden" value="<?php echo $data[IDEA_ID]?>"/>
                    <input type="text" class= "is-invalid" hidden = "hidden"/>
                    <span class="invalid-feedback"> <?php echo $data[ERRORS][CHECKED]; ?> </span>
                </div>
                <div class="row">
                    <div class="col p-3 mt-4">
                        <input type="submit" value="Salva" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>