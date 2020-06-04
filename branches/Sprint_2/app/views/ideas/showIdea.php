<?php require APPROOT . '/views/inc/header.php'; ?>

<?php
define('STAR_RATING_FIXED','starRatingFixed.php');
?>

<div class="row">

    <div class="container bg-light rounded mt-5 col-md-10">
        <div class="container text-center">
            <div class="pt-4">
                <label class="display-4 "><strong><?php echo $data[IDEADTO]->getTitle();?></strong></label>
            </div>


            <?php if (!empty($data[FEEDBACK_AVG])) {
                $feedbackVote = $data[FEEDBACK_AVG];
                require(STAR_RATING_FIXED);
            } ?>

            <?php flash("idea_message") ?>
            <?php flash('feedback_message'); ?>
            <hr>
            <div class="pt-3 pb-3">
                <label for="description"><?php echo $data[IDEADTO]->getDescription();?></label>
            </div>
            <hr>
            <div class="pt-3">
                <div class="text-left">
                    <label for="description"><strong>Fasi di realizzazione:</strong> </label>
                    <?php foreach ($data[REALIZATION_PHASE] as $realizationPhase): ?>
                    <kbd style= "color: darkslategray;" class="alert-info"><label for="description"><?php echo $realizationPhase->getName(); ?></label></kbd>
                    <?php endforeach; ?>
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

            <?php if(isLoggedIn()) : ?>
            <form action="<?php echo URLROOT; ?>/ideas/newFeedback/<?php echo $data[IDEADTO]->getId(); ?>" method="post">
                <div class="container p-4 mt-3 mb-3 border rounded <?php if(!empty($data['FEEDBACK_ERROR'])) {echo "border-danger";}?> bg-white ">
                    <div class="row pt-1 pb-2">
                        <div class="col-md-6">
                            <div class="">
                                <label><strong>Feedback innovatività: </strong></label>
                                <div><?php
                                    if(empty($data[FEEDBACK])){
                                        $ratingId = 'ratingInnovativity';
                                        require ('starRatingEditable.php');
                                    }else{
                                        $feedbackVote = $data[FEEDBACK]->innovativityVote;
                                        require(STAR_RATING_FIXED);
                                    }?></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="">
                                <label><strong>Feedback creatività: </strong></label>
                                <div><?php
                                    if(empty($data[FEEDBACK])){
                                        $ratingId = 'ratingCreativity';
                                        require ('starRatingEditable.php');
                                    }else{
                                        $feedbackVote = $data[FEEDBACK]->creativityVote;
                                        require(STAR_RATING_FIXED);
                                    }?></div>
                            </div>
                        </div>
                    </div>
                    <?php if(empty($data[FEEDBACK])): ?>
                        <div class="row pt-1 pb-2 d-flex justify-content-center">
                            <div class="col-md-6"><input type="submit" value="Invia Feedback" class="btn btn-success btn-block"></div>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
            <?php endif; ?>

            <?php if(isset($_SESSION[USER_ID_KEY]) && ($_SESSION[USER_ID_KEY] == $data[IDEADTO]->getOwnerId())): ?>
                    <a href="<?php echo URLROOT; ?>/ideas/editIdea/<?php echo $data[IDEADTO]->getId(); ?>" type="button" class="btn btn-primary mt-3 mb-3">Modifica idea</a>
                    <a href="<?php echo URLROOT; ?>/realizationPhases/manageRealizationPhases/<?php echo $data[IDEADTO]->getId(); ?>" type="button" class="btn btn-primary mt-3 mb-3">Gestisci fasi di realizzazione</a>
                    <a href="<?php echo URLROOT; ?>/realizationPhases/newRealizationPhase/<?php echo $data[IDEADTO]->getId(); ?>" type="button" class="btn btn-primary mt-3 mb-3">Inserisci una fase di realizzazione</a>
            <?php endif;?>

        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
