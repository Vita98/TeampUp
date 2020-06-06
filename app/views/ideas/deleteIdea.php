<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="container text-center">
            <label class="display-4 ">Rimozione IDEA</label>
        </div>
        <div class="container bg-light border rounded mt-3 col-md-10 p-5">
            <p>Sei sicuro di voler rimuovere l'idea?</p>
            <div class="row justify-content-end">
                <div class="mr-2">
                    <a href="<?php echo URLROOT; ?>/ideas/getIdeasByOwnerId" class="btn btn-secondary">Annulla</a>
                </div>
                <form action="<?php echo URLROOT; ?>/ideas/deleteIdea/<?php echo $data[IDEADTO]->getId(); ?>" method="post">
                    <input type="submit" class="btn btn-danger" value="Rimuovi"/>
                </form>
            </div>
        </div>
    </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>