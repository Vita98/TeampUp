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
                    <label for="creationDate">il <strong><?php echo date_format(new DateTime($data[IDEADTO]->getCreationDate()), DATE_FORMAT); ?></strong> </label>
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
            <div class="row">


                <div class="col-6 mt-3 ">
                    <a href="<?php echo URLROOT; ?>/ideas/editIdea/<?php echo $data[IDEADTO]->getId(); ?>" style="">
                        <div class="row d-flex justify-content-center">
                            <svg class="bi bi-pencil" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z"/>
                                <path fill-rule="evenodd" d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z"/>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-12">Modifica idea</div>
                        </div>
                    </a>
                </div>
                <div class="col-6 mt-3 ">
                    <a href="<?php echo URLROOT; ?>/realizationPhases/manageRealizationPhases/<?php echo $data[IDEADTO]->getId(); ?>" style="color:gray">
                        <div class="row d-flex justify-content-center">
                            <svg class="bi bi-gear" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                                <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-12">Gestisci fasi di Realizzazione</div>
                        </div>
                    </a>
                </div>
                    <!--<a href="<?php echo URLROOT; ?>/realizationPhases/newRealizationPhase/<?php echo $data[IDEADTO]->getId(); ?>" type="button" class="btn btn-primary mt-3 mb-3">Inserisci una fase di realizzazione</a>-->
            </div>
            <?php endif;?>

        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
