<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="container rounded mt-3 col-md-8">
            <div class="container text-center">
                <label class="display-4 ">Idee di cui sono partecipante</label>
                <p>Queste sono tutte le idee a cui partecipi</p>
            </div>
            <div class="d-flex justify-content-center "><?php flash('REMOVE_PARTECIPATION_SUCCESS') ?></div>
            <div class="d-flex justify-content-center "><?php flash('partecipation_request_response'); ?></div>
            <?php if(isset($data) && !empty($data)) : foreach($data as $dto): ?>
                <div class="card card-body rounded bg-light mt-3">
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

                                <div class="col-6 mt-3 ">
                                    <a href="/ideas/showIdea/<?php echo $dto[IDEADTO]->getId(); ?>" style="color: #1d70ff">
                                        <div class="row d-flex justify-content-center">
                                            <svg class="bi bi-card-text" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                                <path fill-rule="evenodd" d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8zm0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                                            </svg>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">Visualizza idea</div>
                                        </div>
                                    </a>
                                </div>

                                <div class="col-6 mt-3 ">
                                    <?php $rejectLink = "/partecipationRequests/removePartecipation/" . $dto[IDEADTO]->getId() . '/user'; ?>
                                    <a href="" data-toggle="modal" data-target="#exampleModalCenter" onclick="updateNewPopup('<?php echo $rejectLink; ?>','Conferma','Annulla','Sei sicuro di eliminare la tua partecipazione da questa idea?','Sei sicuro?')" style="color: red" >
                                        <div class="row d-flex justify-content-center">
                                            <svg class="bi bi-trash" width="1.8em" height="1.8em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">Elimina partecipazione</div>
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
                    Non sei partecipante di nessuna idea!
                </div>

            <?php endif; ?>

            <?php require APPROOT . '/views/inc/pop-Up.php'; ?>

        </div>
    </div>


<?php require APPROOT . '/views/inc/footer.php'; ?>