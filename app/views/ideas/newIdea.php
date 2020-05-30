<?php require APPROOT . '/views/inc/header.php'; ?>

    <a href="<?php echo URLROOT; ?>/pages/index" class="btn btn-light"><em class="fa fa-backward"></em> Back</a>
    <div class="card card-body bg-light mt-5">
        <h2>Nuova idea</h2>
        <p>Compila il form per aggiungere una nuova idea</p>
        <form action="<?php echo URLROOT; ?>/ideas/newIdea" method="post">
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" placeholder = "Inserisci un titolo" name="title" class="form-control form-control-lg
                <?php echo (!empty($data[ERRORS][TITLE_FIELD])) ? 'is-invalid' : ''; ?>"
                       value="<?php echo $data[IDEADTO]->getTitle(); ?>">
                <span class="invalid-feedback"><?php echo $data[ERRORS][TITLE_FIELD]; ?></span>
            </div>
            <div class="form-group">
                <label for="description">Descrizione</label>
                <textarea name="description" placeholder = "Inserisci una descrizione" class="form-control form-control-lg
                <?php echo (!empty($data[ERRORS][DESCRIPT_FIELD])) ? 'is-invalid' : ''; ?>" ><?php echo $data[IDEADTO]->getDescription(); ?></textarea>
                <span class="invalid-feedback"><?php echo $data[ERRORS][DESCRIPT_FIELD]; ?></span>
            </div>
            <label>Categorie:</label></br>
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
            <br/>
            <input type="submit" class="btn btn-success" value="Submit">
        </form>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>