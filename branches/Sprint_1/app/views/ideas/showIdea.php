<?php require APPROOT . '/views/inc/header.php'; ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .checked{
        color: darkorange;
    }
</style>
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
                    <label for="creationDate">Creato il <br> <strong><?php echo $data[IDEADTO]->getCreationDate()?></strong> </label>
                </div>
            </div>



        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
