<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">

        <div class="container text-center mt-3">

        </div>

        <div class="container text-center mt-3">
            <?php if($data[ROLE] == PARTICIPANT):?>
            <label class="display-4">Visualizza i team</label>
            <p>In questa sezione è possibile visualizzare i team relativi all'idea <strong><?php echo $data[IDEA_DTO]->getTitle();?></strong></p>
            <?php elseif($data[ROLE] == OWNER):?>
            <label class="display-4">Gestisci i Team</label>
            <p>In questa sezione è possibile gestire i team relativi all'idea <strong><?php echo $data[IDEA_DTO]->getTitle();?></strong></p>
        </div>


        <div class="container bg-light rounded mt-2 col-md-10">
            <div class="container text-center">
                <div class="d-flex justify-content-center mt-4"><?php flash(IDEA_MESSAGE) ?></div>
                <div class="row mt-3 justify-content-md-center">
                    <div class="col-12 mt-3 mb-3">
                        <a href="<?php echo URLROOT; ?>/teams/newTeam/<?php echo $data[IDEA_DTO]->getId(); ?>" style="">
                            <div class="row d-flex justify-content-center">
                                <svg class="bi bi-file-plus" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 1H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V8h-1v5a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h5V1z"/>
                                    <path fill-rule="evenodd" d="M13.5 1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V1.5a.5.5 0 0 1 .5-.5z"/>
                                    <path fill-rule="evenodd" d="M13 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z"/>
                                </svg>
                            </div>
                            <div class="row">
                                <div class="col-md-12">Inserisci un nuovo team</div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif;?>
            <?php flash(TEAM_MESSAGE); ?>
            <hr>
            <?php   if(empty($data[TEAM_DTO])):?>
                <div class="alert alert-danger" role="alert">
                    <strong>Questa idea non possiede team</strong>
                </div>
            <?php else :?>
                <?php foreach ($data[TEAM_DTO] as $team): ?>
                    <div class="row mb-3 mt-3">
                        <div class="col-md-4 mt-4">
                            <kbd style= "color: darkslategray;" class="text-left alert-info"><label for="description"><strong><?php echo $team->getName(); ?></strong></label></kbd>
                        </div>
                        <div class="col-md-4 mt-4">
                                Numero di membri: <?php echo $team->getNumberOfMember()?>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12 mt-3">
                                    <a href="<?php echo URLROOT."/users/getMembersList/".$team->getIdeaId()."/".$team->getId(); ?>" style="color: royalblue">
                                        <div class="row d-flex justify-content-center">
                                            <svg class="bi bi-person-check-fill" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm9.854-2.854a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                            </svg>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">Membri</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                <?php endforeach; ?>
            <?php endif;?>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>