<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">

    <div class="container text-center mt-3">
        <label class="display-4">Gestisci i partecipanti all'idea</label>
        <p>In questa sezione è possibile gestire le partecipazioni all'idea</p>
    </div>
    <div class="container bg-light rounded mt-2 col-md-10">
        <div class="container text-center">
            <div class="d-flex justify-content-center mt-4"><?php flash('INVITE_CORRECTLY_SENT') ?></div>
            <div class="row mt-3 justify-content-md-center">
                <div class="col-6 mt-3 mb-3">
                    <a href="<?php echo URLROOT; ?>/partecipationRequests/newPartecipationrequestChooser/<?php echo $data['ideaId']; ?>" style="">
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
            </div>
            <hr>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
