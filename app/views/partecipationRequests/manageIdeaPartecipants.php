<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row justify-content-md-center">

    <div class="container text-center mt-3">
        <label class="display-4">Gestisci i partecipanti all'idea</label>
        <p>In questa sezione è possibile gestire le partecipazioni all'idea</p>
    </div>
    <?php flash('add_participant_to_teams'); ?>
    <div class="container bg-light rounded mt-2 col-md-10">
        <div class="container text-center">
            <div class="d-flex justify-content-center mt-4"><?php flash('INVITE_CORRECTLY_SENT') ?></div>
            <div class="row mt-3 justify-content-md-center">
                <div class="col-6 mt-3 mb-3">
                    <a href="<?php echo URLROOT; ?>/partecipationRequests/newPartecipationrequestChooser/<?php echo $data[IDEA_ID]; ?>" style="">
                        <div class="row d-flex justify-content-center">
                            <svg class="bi bi-person-plus-fill" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7.5-3a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
                                <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-12">Invita un nuovo partecipante</div>
                        </div>
                    </a>
                </div>
                <div class="col-6 mt-3 mb-3">
                    <a href="<?php echo URLROOT; ?>/partecipationRequests/getPartecipationRequestList/idea/<?php echo $data[IDEA_ID]; ?>" style="">
                        <div class="row d-flex justify-content-center">
                            <svg class="bi bi-inboxes-fill" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M.125 11.17A.5.5 0 0 1 .5 11H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0 .5.5 0 0 1 .5-.5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 16H1.883a1.5 1.5 0 0 1-1.489-1.314l-.39-3.124a.5.5 0 0 1 .121-.393zM3.81.563A1.5 1.5 0 0 1 4.98 0h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625a.5.5 0 0 1-.78.624l-3.7-4.624A.5.5 0 0 0 11.02 1H4.98a.5.5 0 0 0-.39.188L.89 5.812a.5.5 0 1 1-.78-.624L3.81.563z"/>
                                <path fill-rule="evenodd" d="M.125 5.17A.5.5 0 0 1 .5 5H6a.5.5 0 0 1 .5.5 1.5 1.5 0 0 0 3 0A.5.5 0 0 1 10 5h5.5a.5.5 0 0 1 .496.562l-.39 3.124A1.5 1.5 0 0 1 14.117 10H1.883A1.5 1.5 0 0 1 .394 8.686l-.39-3.124a.5.5 0 0 1 .121-.393z"/>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="col-md-12">Visualizza tutte le</div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">richieste di partecipazione</div>
                        </div>
                    </a>
                </div>
            </div>
            <hr>
            <?php for ($i=0;$i<$data[USER_COUNT_KEY];$i++): ?>
                <?php $user = $data[USER_LIST_KEY][$i]; ?>
                <?php $participantRequest = $data[PARTICIPANT_REQUEST_LIST_KEY][$i]; ?>
                <div class="row mb-3 mt-3">
                    <div class="col-md-6 mt-3">
                        <kbd style= "color: darkslategray;" class="text-left alert-info"><label for="description"><strong><?php echo $user->getFirstName() . " " . $user->getLastName(); ?></strong></label></kbd>
                    </div>

                    <div class="col-md-6">
                        <a href="<?php echo URLROOT; ?>/partecipationRequests/addToTeam/<?php echo $participantRequest->getPartecipationRequestId(); ?>/<?php echo $data['ideaId']; ?>" style="color: gray">
                            <div class="row d-flex justify-content-center">
                                <svg class="bi bi-gear" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8.837 1.626c-.246-.835-1.428-.835-1.674 0l-.094.319A1.873 1.873 0 0 1 4.377 3.06l-.292-.16c-.764-.415-1.6.42-1.184 1.185l.159.292a1.873 1.873 0 0 1-1.115 2.692l-.319.094c-.835.246-.835 1.428 0 1.674l.319.094a1.873 1.873 0 0 1 1.115 2.693l-.16.291c-.415.764.42 1.6 1.185 1.184l.292-.159a1.873 1.873 0 0 1 2.692 1.116l.094.318c.246.835 1.428.835 1.674 0l.094-.319a1.873 1.873 0 0 1 2.693-1.115l.291.16c.764.415 1.6-.42 1.184-1.185l-.159-.291a1.873 1.873 0 0 1 1.116-2.693l.318-.094c.835-.246.835-1.428 0-1.674l-.319-.094a1.873 1.873 0 0 1-1.115-2.692l.16-.292c.415-.764-.42-1.6-1.185-1.184l-.291.159A1.873 1.873 0 0 1 8.93 1.945l-.094-.319zm-2.633-.283c.527-1.79 3.065-1.79 3.592 0l.094.319a.873.873 0 0 0 1.255.52l.292-.16c1.64-.892 3.434.901 2.54 2.541l-.159.292a.873.873 0 0 0 .52 1.255l.319.094c1.79.527 1.79 3.065 0 3.592l-.319.094a.873.873 0 0 0-.52 1.255l.16.292c.893 1.64-.902 3.434-2.541 2.54l-.292-.159a.873.873 0 0 0-1.255.52l-.094.319c-.527 1.79-3.065 1.79-3.592 0l-.094-.319a.873.873 0 0 0-1.255-.52l-.292.16c-1.64.893-3.433-.902-2.54-2.541l.159-.292a.873.873 0 0 0-.52-1.255l-.319-.094c-1.79-.527-1.79-3.065 0-3.592l.319-.094a.873.873 0 0 0 .52-1.255l-.16-.292c-.892-1.64.902-3.433 2.541-2.54l.292.159a.873.873 0 0 0 1.255-.52l.094-.319z"/>
                                    <path fill-rule="evenodd" d="M8 5.754a2.246 2.246 0 1 0 0 4.492 2.246 2.246 0 0 0 0-4.492zM4.754 8a3.246 3.246 0 1 1 6.492 0 3.246 3.246 0 0 1-6.492 0z"/>
                                </svg>
                            </div>
                            <div class="row">
                                <div class="col-md-12">Assegna ad un Team</div>
                            </div>
                        </a>
                    </div>
                </div>
                <hr>
            <?php endfor; ?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
