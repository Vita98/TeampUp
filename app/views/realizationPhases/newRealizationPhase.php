<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="container text-center mt-3">
        <label class="display-4">Nuova fase di realizzazione</label>
        <p>Compila il form per aggiungere una nuova fase di realizzazione</p>
    </div>

    <div class="card card-body bg-light mt-5">
            <form action="<?php echo URLROOT; ?>/realizationPhases/newRealizationPhase/" method="post">
                <div class="form-group">
                    <strong><label for="title">Nome*</label></strong>
                    <input type="text" placeholder = "Inserisci un nome" name="<?php echo TITLE_FIELD?>" class="form-control form-control-lg
                    <?php echo (!empty($data[ERRORS][TITLE_FIELD])) ? 'is-invalid' : ''; ?>" value="<?php echo $data[REALIZATION_PHASE_DTO]->getName(); ?>"/>
                    <span class="invalid-feedback"><?php echo $data[ERRORS][TITLE_FIELD]; ?></span>
                </div>
                <strong><label>Abilità richieste*</label></br></strong>
                <div>
                    <?php foreach($data[ABILITIES] as $ability): ?>
                        <div class='form-check form-check-inline'>
                            <?php if (in_array($ability->getId(), $data[CHECKED])) :?>
                                <input class='form-check-input' checked='checked' type='checkbox'
                                       name='<?php echo ABILITIES . "[]"?>' id='<?php echo $ability->getId()?>'
                                       value='<?php echo $ability->getId()?>'/>
                            <?php else : ?>
                                <input class='form-check-input' type='checkbox' name='<?php echo ABILITIES . "[]"?>'
                                       id='<?php echo $ability->getId()?>' value='<?php echo $ability->getId()?>'/>
                            <?php endif; ?>
                            <label for='<?php echo ABILITIES."[]"; ?>' class ='form-check-label'> <?php echo $ability->getDescription(); ?> </label>
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