<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">

    <div class="container bg-light rounded mt-5 col-md-10">
        <div class="container text-center">
            <div class="pt-4">
                <label class="display-4 "><strong><?php echo $data[IDEADTO]->getTitle();?></strong></label>
            </div>
            <div class="pt-2 pb-3 text-center">
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star checked"></span>
                <span class="fa fa-star"></span>
                <span class="fa fa-star"></span>
            </div>
            <?php flash("idea_message") ?>
            <hr>
            <div class="pt-3 pb-3">
                <label for="description"><?php echo $data[IDEADTO]->getDescription();?></label>
            </div>
            <hr>
            <div class="pt-3">
                <div class="text-left">
                    <label for="description"><strong>Fasi di realizzazione:</strong> </label>
                </div>

            </div>
            <div class="row pt-5 pb-2">
                <div class="col-md-9 form-group mt-3 text-left">
                    <label for="firstName" class="display-5 font-weight-bolder">Lista categorie:  </label>
                    <?php  foreach($data[CATEGORIES] as $ideaCategory): ?>
                        <kbd style= "color:darkslategray;" class="alert-info"><label for="description"><?php echo $ideaCategory->getDescription(); ?></label></kbd>
                    <?php endforeach; ?>
                </div>
                <div class="col-md-3 mt-10 text-right">
                    <label>Creato da <br><strong><?php echo $data[USERDTO]->getFirstName()." ".$data[USERDTO]->getLastName() ?> </strong> </label>
                    <label for="creationDate">il <strong><?php echo date_format(new DateTime($data[IDEADTO]->getCreationDate()), 'd/m/Y H:i:s'); ?></strong> </label>
                </div>
            </div>
            <?php if(isset($_SESSION[USER_ID_KEY]) && ($_SESSION[USER_ID_KEY] == $data[IDEADTO]->getOwnerId())): ?>
            <div>
                <div class="mt-3 mb-3 pull-right">
                    <a href="<?php echo URLROOT; ?>/ideas/editIdea/<?php echo $data[IDEADTO]->getId(); ?>" type="button" class="btn btn-primary">Modifica</a>
                </div>
            </div>
            <?php endif;?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
