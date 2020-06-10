<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <div class="container rounded mt-3 col-md-8">
        <div class="container text-center">
            <label class="display-4 ">Le mie idee</label>
            <p>Queste sono tutte le idee create da te</p>
        </div>
        <?php if(isset($data) && !empty($data)) : foreach($data as $dto): ?>
            <div class="card card-body rounded bg-light mt-5">
                <div class="justify-center">
                    <div class="form-group mt-3 ">
                        <label for="title" class="display-5 font-weight-bolder">Titolo: </label>
                        <label for="firstName"><?php echo $dto[IDEADTO]->getTitle();?></label>
                    </div>
                    <div class="form-group mt-3 ">
                        <label for="creationDate" class="display-5 font-weight-bolder">Data di creazione: </label>
                        <label for="creationDate"><?php echo date_format(new DateTime($dto[IDEADTO]->getCreationDate()), DATE_FORMAT);?></label>
                    </div>
                    <div class="form-group mt-3 text-left">
                        <label for="firstName" class="display-5 font-weight-bolder">Lista categorie: </label>

                        <?php  foreach($dto[CATEGORIES] as $ideaCategory): ?>
                            <kbd style= "color:darkslategray;" class="alert-info"><label for="description"><?php echo $ideaCategory->getDescription(); ?></label></kbd>
                        <?php endforeach; ?>
                    </div>

                    <div class="container">
                        <div class="row text-center">

                            <div class="col-4 mt-3 ">
                                <a href="<?php echo URLROOT; ?>/ideas/showIdea/<?php echo $dto[IDEADTO]->getId(); ?>" style="color: #1d70ff">
                                    <div class="row d-flex justify-content-center">
                                        <svg class="bi bi-card-text" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                            <path fill-rule="evenodd" d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">Visualizza</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-4 mt-3 ">
                                <a href="<?php echo URLROOT; ?>/ideas/sponsorIdea/<?php echo $dto[IDEADTO]->getId(); ?>" style="color: green">
                                    <div class="row d-flex justify-content-center">
                                        <svg class="bi bi-graph-up" width="1.7em" height="1.7em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0h1v16H0V0zm1 15h15v1H1v-1z"/>
                                            <path fill-rule="evenodd" d="M14.39 4.312L10.041 9.75 7 6.707l-3.646 3.647-.708-.708L7 5.293 9.959 8.25l3.65-4.563.781.624z"/>
                                            <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4h-3.5a.5.5 0 0 1-.5-.5z"/>
                                        </svg>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">Sponsorizza</div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-4 mt-3 ">
                                <a href="<?php echo URLROOT; ?>/ideas/deleteIdea/<?php echo $dto[IDEADTO]->getId(); ?>"  style="color: red">
                                    <div class="row d-flex justify-content-center">
                                        <svg class="bi bi-trash" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                        </svg>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">Elimina</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        <?php endforeach; ?>
        <?php else : ?>
            <div class="alert alert-warning text-center mt-5 mb-5" role="alert">
               Non sei proprietario di nessuna idea!
            </div>

        <?php endif; ?>

    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
