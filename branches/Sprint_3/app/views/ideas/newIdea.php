<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <?php $editMode = isset($data[EDITMODE]) && $data[EDITMODE]; ?>
    <?php if($editMode): ?>
        <div class="container text-center mt-3">
            <label class="display-4">Modifica idea</label>
            <p>In questa sezione è possibile modificare i dati relativi all'idea</p>
        </div>
        <?php else : ?>
        <div class="container text-center mt-3">
            <label class="display-4">Nuova idea</label>
            <p>Compila il form per aggiungere una nuova idea</p>
        </div>
        <?php endif ?>

        <div class="card card-body bg-light mt-5">
            <?php if($editMode): ?>
            <form action="<?php echo URLROOT; ?>/ideas/editIdea/<?php echo $data[IDEADTO]->getId() ?>" method="post">
            <?php else: ?>
                <form action="<?php echo URLROOT; ?>/ideas/newIdea" method="post">
            <?php endif ?>
                <div class="form-group">
                    <strong><label for="title">Titolo*</label></strong>
                    <input type="text" placeholder = "Inserisci un titolo" name="title" class="form-control form-control-lg
                    <?php echo (!empty($data[ERRORS][TITLE_FIELD])) ? 'is-invalid' : ''; ?>" value="<?php echo $data[IDEADTO]->getTitle(); ?>"/>
                    <span class="invalid-feedback"><?php echo $data[ERRORS][TITLE_FIELD]; ?></span>
                </div>
                <div class="form-group">
                    <strong><label for="description">Descrizione*</label></strong>
                    <textarea name="description" placeholder = "Inserisci una descrizione" class="form-control form-control-lg
                    <?php echo (!empty($data[ERRORS][DESCRIPT_FIELD])) ? 'is-invalid' : ''; ?>" ><?php echo $data[IDEADTO]->getDescription(); ?></textarea>
                    <span class="invalid-feedback"><?php echo $data[ERRORS][DESCRIPT_FIELD]; ?></span>
                </div>
                    <strong><label>Categorie*</label></br></strong>
                <div>
                    <?php foreach($data[CATEGORIES] as $category): ?>
                        <div class='form-check form-check-inline'>
                            <?php if (in_array($category->getId(), $data[CHECKED])) :?>
                                <input class='form-check-input' checked='checked' type='checkbox'
                                       name='<?php echo CATEGORIES . "[]"?>' id='<?php echo $category->getId()?>'
                                       value='<?php echo $category->getId()?>'/>
                            <?php else : ?>
                                <input class='form-check-input' type='checkbox' name='<?php echo CATEGORIES . "[]"?>'
                                       id='<?php echo $category->getId()?>' value='<?php echo $category->getId()?>'/>
                            <?php endif; ?>
                            <label for='<?php echo CATEGORIES."[]"; ?>' class ='form-check-label'> <?php echo $category->getDescription(); ?> </label>
                        </div>
                    <?php endforeach; ?>
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