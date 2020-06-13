<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="container text-center">
            <label class="display-4 ">Abbandono Team</label>
        </div>
        <div class="container bg-light border rounded mt-3 col-md-10 p-5">
            <p>Sei sicuro di voler abbandonare il team?</p>
            <div class="row justify-content-end">
                <div class="mr-2">
                    <a href="<?php echo URLROOT; ?>/teams/showMyTeams" class="btn btn-secondary">Annulla</a>
                </div>
                <form action="<?php echo URLROOT; ?>/teams/doLeaveTeam/<?php echo $data[TEAM_ID]; ?>/<?php echo $data[PARTICIPANT_REQUEST_ID]; ?>" method="post">
                    <input type="submit" class="btn btn-danger" value="Rimuovi"/>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>