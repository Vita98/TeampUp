<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container text-center">
    <label class="display-4">Associa team a Fase</label>
    <p>In questa sezione è associare un team alla fase di realizzazione <strong><?php echo $data[REALIZATION_PHASE_DTO]->getName();?></strong></p>
</div>
<?php   if(empty($data[TEAM_DTO])):?>
    <div class="alert text-center" role="alert">
        <strong>Questa idea non possiede team</strong>
    </div>
<?php else :?>
    <form action="<?php echo URLROOT."/realizationPhases/realizationPhaseTeamAssociation/".$data[REALIZATION_PHASE_DTO]->getId();?>" method="POST">
        <div class="container bg-light rounded mt-2 col-md-6">
        <?php foreach ($data[TEAM_DTO] as $team): ?>
        <div class="row mb-3 mt-3">
            <span class="col-md-5 mt-4">
                <input type="radio" name="choosedTeam" id="choosedTeam" value="<?php echo $team->getId(); ?>"
                        <?php if($data[REALIZATION_PHASE_DTO]->getTeamId() != null && $data[REALIZATION_PHASE_DTO]->getTeamId()==$team->getId()){ echo "checked"; }?> />
                <label><strong><?php echo $team->getName(); ?></strong></label>
            </span>
        </div>
        <hr>
    <?php endforeach; ?>
        </div>
        <div class=" text-center row col-md-6" style="margin-left: auto; margin-right: auto;">
            <div class="col p-3 mt-4">
                <input type="submit" value="Associa" class="btn btn-success btn-block">
            </div>
        </div>
    </form>
<?php endif;?>

<?php require APPROOT . '/views/inc/footer.php'; ?>
