<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="container rounded mt-5 col-md-8">
        <div class="container text-center">
            <label class="display-3 ">Le mie idee</label>
        </div>
        <?php if(isset($data) && !empty($data)) : foreach($data as $dto): ?>
            <div class="card card-body rounded bg-light mt-5">
                <div class="justify-center">
                    <div class="form-group mt-3 ">
                        <label for="title" class="display-5 font-weight-bolder">Titolo: </label>
                        <label for="firstName"><?php echo $dto[IDEADTO]->getTitle();?></label>
                    </div>
                    <div class="form-group mt-3 ">
                        <label for="creationDate" class="display-5 font-weight-bolder">Data di creazione: </label>
                        <label for="creationDate"><?php echo $dto[IDEADTO]->getCreationDate();?></label>
                    </div>
                    <div class="form-group mt-3 text-left">
                        <label for="firstName" class="display-5 font-weight-bolder">Lista categorie: </label>

                        <?php  foreach($dto[CATEGORIES] as $ideaCategory): ?>
                            <kbd style= "color:darkslategray;" class="alert-info"><label for="description"><?php echo($ideaCategory->getDescription()) ?></label></kbd>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-group mt-3 text-right">
                        <a href="<?php echo URLROOT; ?>/ideas/show/<?php echo $dto[IDEADTO]->getId(); ?>" type="button" class="btn btn-primary">Visualizza</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-warning text-center mt-5 mb-5" role="alert">
               Non sei proprietario di nessuna idea!
            </div>

        <?php endif; ?>

    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
