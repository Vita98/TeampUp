<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container rounded mt-2 col-md-10">
    <div class="container text-center">
        <label class="display-4 ">I Miei Team</label>
        <p>Qui trovi tutti i tuoi Team di cui fai parte</p>
    </div>
    <div class="d-flex justify-content-center mt-4"><?php flash(TEAM_MESSAGE) ?></div>
    <?php foreach ($data[TEAM_LIST_KEY] as $team): ?>
    <div class="card card-body rounded bg-light mt-5">
        <div class="row mb-3 mt-3">
        <div class="col-md-3 mt-4">
            <kbd style= "color: darkslategray;" class="text-left alert-info"><label for="description"><strong><?php echo $team->getName(); ?></strong></label></kbd>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col mt-3">
                    <a href="<?php echo URLROOT; ?>/teams/leaveTeam/<?php echo $team->getId(); ?>/<?php echo $team->getPartecipationRequestId(); ?>" style="color: red" >
                        <div class="row d-flex justify-content-center">
                            <svg class="bi bi-trash" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>
                            <div>Abbandona Team</div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
        <hr>
    </div>
    </div>
    <?php endforeach; ?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>