<?php require APPROOT . '/views/inc/header.php'; ?>

    <div class="container rounded mt-2 col-md-10">
        <div class="container text-center">
            <label class="display-4 ">Membri del Team</label>
            <p>Qui trovi tutti i membri del team</p>
        </div>
        <?php flash("remove_member_message"); ?>
        <div class = "container">
        <?php if($data[USERDTO_KEY] != null && sizeof($data[USERDTO_KEY]) > 0) : foreach ($data[USERDTO_KEY] as $user) : ?>
            <div class="card card-body rounded bg-light row mt-5">
                <div>
                    <div class="row" style="justify-content: center;">
                        <strong><label>Nome e cognome</label></strong>
                    </div>
                    <div class="row" style="justify-content: center;">
                        <?php echo $user->getFirstName() . " " . $user->getLastName(); ?>
                    </div>
                    <div class="row mt-2" style="justify-content: center;">
                        <strong><label>Email</label></strong>
                    </div>
                    <div class="row" style="justify-content: center;">
                        <?php echo $user->getEmail();?>
                    </div>
                </div>
                <?php if($data[OWNER]) : ?>
                <div>
                    <div class="col mt-3">
                        <a href="" data-toggle="modal" data-target="#exampleModalCenter" onclick="updateNewPopup('<?php echo URLROOT; ?>/teams/removeMemberFromTeam/<?php echo $data[IDEA_ID]; ?>/<?php echo $data[TEAM_ID]; ?>/<?php echo $user->getReqId(); ?>','Conferma','Annulla','Sei sicuro di voler rimuovere questo membro dal team?','Cancellazione Membro')" style="color: red">
                            <div class="row d-flex justify-content-center">
                                <svg class="bi bi-trash" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                                <div>Rimuovi Membro</div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <?php else :?>
            <div class="alert alert-warning text-center mt-5 mb-5" role="alert">
                Non sono presenti membri per questo team!
            </div>
        <?php endif;?>
        </div>
    </div>

<?php require APPROOT . '/views/inc/pop-Up.php'; ?>


<?php require APPROOT . '/views/inc/footer.php'; ?>