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
            <?php flash('REQUEST_CORRECTLY_SENT'); ?>
            <?php flash('NEW_IDEA_OK'); ?>
            <?php flash('SPONSORIZATION_OK'); ?>

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
        <div class ="row mt-4 mb-4">
                <?php if($_SESSION[USER_ID_KEY] != $data[IDEADTO]->getOwnerId() && $data[ALLOW_SEND_REQUEST] ):?>
                        <div class="<?php echo "".($data[ROLE] == PARTICIPANT) ?  "col-6" :  "col-12"; ?>">
                        <a href="#" onclick="updatePopup('<?php echo URLROOT; ?>/partecipationRequests/sendPartecipationRequest/<?php echo $data[IDEADTO]->getId(); ?>/true')"  data-toggle="modal" data-target="#exampleModalCenter">
                            <div class="row d-flex justify-content-center">
                                <svg class="bi bi-person-plus-fill" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                    <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                                </svg>
                            </div>
                            <div class="row">
                                <div class="col-md-12">Richiedi di partecipare</div>
                            </div>
                        </a>
                    </div>



                <?php elseif ($_SESSION[USER_ID_KEY] != $data[IDEADTO]->getOwnerId()): ?>

                     <div class="<?php echo "".($data[ROLE] == PARTICIPANT) ?  "col-6" :  "col-12"; ?>">
                            <div style="color: gray; cursor: not-allowed">
                                <div class="row d-flex justify-content-center">
                                    <svg class="bi bi-person-plus-fill" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                        <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                                    </svg>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">Richiedi di partecipare</div>
                                </div>
                            </div>
                        </div>

                <?php endif; ?>
                <?php if(isset($_SESSION[USER_ID_KEY]) && ($data[ROLE] == PARTICIPANT)): ?>

                    <div class="col-6 ">
                        <a href="<?php echo URLROOT; ?>/teams/manageTeam/<?php echo $data[IDEADTO]->getId(); ?>" style="color:black ">
                            <div class="row d-flex justify-content-center">
                                <svg class="bi bi-people" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                                </svg>
                            </div>
                            <div class="row">
                                <div class="col-md-12">Visualizza teams</div>
                            </div>
                        </a>
                    </div>

                <?php endif; ?>
            </div>
            <?php endif; ?>



            <?php if(isset($_SESSION[USER_ID_KEY]) && ($_SESSION[USER_ID_KEY] == $data[IDEADTO]->getOwnerId())): ?>
                <div class="row mb-3">
                <div class="col-3 mt-3 ">
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
                <div class="col-3 mt-3 ">
                    <a href="<?php echo URLROOT; ?>/partecipationRequests/manageIdeaPartecipants/<?php echo $data[IDEADTO]->getId(); ?>" style="color:gray">
                        <div class="row d-flex justify-content-center">
                            <svg class="bi bi-person-square" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                <path fill-rule="evenodd" d="M2 15v-1c0-1 1-4 6-4s6 3 6 4v1H2zm6-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-12">Gestione Partecipanti</div>
                        </div>
                    </a>
                </div>
                <div class="col-3 mt-3 ">
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
                <div class="col-3 mt-3 ">
                    <a href="<?php echo URLROOT; ?>/teams/manageTeam/<?php echo $data[IDEADTO]->getId(); ?>" style="color:black ">
                        <div class="row d-flex justify-content-center">
                            <svg class="bi bi-people" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-12">Gestisci teams</div>
                        </div>
                    </a>
                </div>
                </div>

            </div>
            <?php endif;?>


        </div>
    </div>
</div>

<?php
$popUpData['modal-title'] = "Sei sicuro?";
$popUpData['modal-body'] = "Sei sicuro di voler inviare la richiesta di partecipazione?";
$popUpData['modal-primary'] = "Invia";
$popUpData['modal-secondary'] = "Annulla";
if ($_SESSION[USER_ID_KEY] != $data[IDEADTO]->getOwnerId()) {require_once APPROOT.'/views/inc/pop-Up.php';}
?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
