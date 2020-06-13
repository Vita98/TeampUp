<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container rounded mt-2 col-md-10">
    <div class="container text-center">
        <label class="display-4 ">I Miei Team</label>
        <p>Qui trovi tutti i Team di cui fai parte</p>
    </div>
    <div class="d-flex justify-content-center mt-4"><?php flash(TEAM_MESSAGE) ?></div>

    <?php $isThereSomething = false ?>
    <?php foreach ($data['ideasDTO'] as $idea):?>
        <?php if(!empty($data[$idea->getId()])):?>
        <div class="card card-body rounded bg-light mt-5">

            <div class="row">
                <div class="col-md-12 text-center"><strong><?php echo $idea->getTitle()?></strong></div>
            </div>

            <?php foreach ($data[$idea->getId()] as $ideaTeam): ?>
            <hr>
            <?php $isThereSomething = true; ?>
            <div class="row text-center mt-3">
                <div class="col-md-6 mt-3">
                    <kbd style= "color: darkslategray;" class="text-left alert-info"><label for="description"><strong><?php echo $ideaTeam->getName(); ?></strong></label></kbd>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col mt-3">
                            <a href="<?php echo URLROOT; ?>/teams/removeMember/<?php echo $ideaTeam->getId(); ?>/<?php echo $ideaTeam->getPartecipationRequestId(); ?>" style="color: red" >
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
            </div>
            <?php endforeach;?>
        <?php endif; ?>

        </div>

    <?php endforeach;?>

    <?php if(!$isThereSomething):?>
        <div class="alert alert-warning text-center mt-5 mb-5" role="alert">
            Non sei membro di alcun team!
        </div>
    <?php endif;?>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>