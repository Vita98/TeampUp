<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">

    <div class="container text-center mt-3">
        <?php if(!empty($data[REQUEST_CONTROL_TYPE]) && $data[REQUEST_CONTROL_TYPE] == USERTYPE): ?>
            <label class="display-4">Mie richieste di partecipazione</label>
            <p>In questa sezione sono visibili tutte le tue richieste di partecipazione</p>
        <?php elseif (!empty($data[REQUEST_CONTROL_TYPE]) && $data[REQUEST_CONTROL_TYPE] == IDEATYPE): ?>
            <label class="display-4">Richieste di partecipazione</label>
            <p>In questa sezione sono visibili tutte le tue richieste di partecipazione relative all'idea: </p>
            <strong class="display-4"><?php echo $data['ideaDTO']->getTitle(); ?></strong>
        <?php endif; ?>
    </div>
    <div class="container rounded mt-2 col-md-10">

        <?php if(!empty($data[REQUEST_CONTROL_TYPE]) && $data[REQUEST_CONTROL_TYPE] == USERTYPE): foreach ($data['REQUESTS_DTO'] as $request):?>
        <div class="container card  mt-5 mb-5 col-md-8">
            <div class="row">
                <div class="col-10 mt-4 mb-4 ">
                    <div class="display-5"><strong>Titolo idea: </strong><?php echo $data['ideasDTO'][$request->getPartecipationRequestId()]->getTitle(); ?></div>
                    <?php if($request->getIsUserRequesting() == false): ?>
                        <div class="mt-2"><strong>Richiedente: </strong><?php echo $data['ideasOwner'][$request->getPartecipationRequestId()]->getFirstName() . " " . $data['ideasOwner'][$request->getPartecipationRequestId()]->getLastName(); ?></div>
                    <?php else: ?>
                        <div class="mt-2"><strong>Inviata a: </strong><?php echo $data['ideasOwner'][$request->getPartecipationRequestId()]->getFirstName() . " " . $data['ideasOwner'][$request->getPartecipationRequestId()]->getLastName(); ?></div>
                    <?php endif; ?>
                    <div class="mt-3">
                        <div><strong>Abilità in comune: </strong>

                        </div>
                    </div>
                </div>

                <div class="col-2 mt-2 mb-3 d-flex justify-content-end">
                    <?php if($request->getIsUserRequesting() == false): ?>
                        <svg class="bi bi-box-arrow-in-left" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.854 11.354a.5.5 0 0 0 0-.708L5.207 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0 0 1h9A.5.5 0 0 0 15 8z"/>
                            <path fill-rule="evenodd" d="M2.5 14.5A1.5 1.5 0 0 1 1 13V3a1.5 1.5 0 0 1 1.5-1.5h8A1.5 1.5 0 0 1 12 3v1.5a.5.5 0 0 1-1 0V3a.5.5 0 0 0-.5-.5h-8A.5.5 0 0 0 2 3v10a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 1 0V13a1.5 1.5 0 0 1-1.5 1.5h-8z"/>
                        </svg>
                    <?php else: ?>
                        <svg class="bi bi-box-arrow-right" width="1.6em" height="1.6em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M11.646 11.354a.5.5 0 0 1 0-.708L14.293 8l-2.647-2.646a.5.5 0 0 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                            <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                            <path fill-rule="evenodd" d="M2 13.5A1.5 1.5 0 0 1 .5 12V4A1.5 1.5 0 0 1 2 2.5h7A1.5 1.5 0 0 1 10.5 4v1.5a.5.5 0 0 1-1 0V4a.5.5 0 0 0-.5-.5H2a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 1 0V12A1.5 1.5 0 0 1 9 13.5H2z"/>
                        </svg>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($request->getIsUserRequesting() == false):?>
                <div class="row d-flex justify-content-center mb-3">
                    <div class="col-md-5">
                        <input type="submit" value="Rifiuta" class="btn btn-danger btn-block">
                    </div>
                    <div class="col-md-5">
                        <input type="submit" value="Accetta" class="btn btn-success btn-block">
                    </div>
                </div>
            <?php else: ?>
                <div class="row d-flex justify-content-end mb-3">
                    <div class="col-md-5">
                        <input type="submit" value="Non ancora accettata" class="btn btn-warning btn-block disabled">
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <? endforeach; ?>

        <? elseif (!empty($data[REQUEST_CONTROL_TYPE]) && $data[REQUEST_CONTROL_TYPE] == IDEATYPE): foreach ($data['REQUESTS_DTO'] as $request):?>
            <div class="container card  mt-5 mb-5 col-md-8">
                <div class="row">
                    <div class="col-10 mt-4 mb-4 ">
                        <?php if($request->getIsUserRequesting()): ?>
                            <div class="mt-2"><strong>Richiedente: </strong><?php echo $data['userDTO'][$request->getPartecipationRequestId()]->getFirstName() . " " . $data['userDTO'][$request->getPartecipationRequestId()]->getLastName(); ?></div>
                        <?php else: ?>
                            <div class="mt-2"><strong>Inviata a: </strong><?php echo $data['userDTO'][$request->getPartecipationRequestId()]->getFirstName() . " " . $data['userDTO'][$request->getPartecipationRequestId()]->getLastName(); ?></div>
                        <?php endif; ?>
                        <div class="mt-3">
                            <div><strong>Abilità in comune: </strong>

                            </div>
                        </div>
                    </div>

                    <div class="col-2 mt-2 mb-3 d-flex justify-content-end">
                        <?php if($request->getIsUserRequesting()): ?>
                            <svg class="bi bi-box-arrow-in-left" width="1.5em" height="1.5em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M7.854 11.354a.5.5 0 0 0 0-.708L5.207 8l2.647-2.646a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708 0z"/>
                                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0 0 1h9A.5.5 0 0 0 15 8z"/>
                                <path fill-rule="evenodd" d="M2.5 14.5A1.5 1.5 0 0 1 1 13V3a1.5 1.5 0 0 1 1.5-1.5h8A1.5 1.5 0 0 1 12 3v1.5a.5.5 0 0 1-1 0V3a.5.5 0 0 0-.5-.5h-8A.5.5 0 0 0 2 3v10a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 1 0V13a1.5 1.5 0 0 1-1.5 1.5h-8z"/>
                            </svg>
                        <?php else: ?>
                            <svg class="bi bi-box-arrow-right" width="1.6em" height="1.6em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M11.646 11.354a.5.5 0 0 1 0-.708L14.293 8l-2.647-2.646a.5.5 0 0 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0z"/>
                                <path fill-rule="evenodd" d="M4.5 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5z"/>
                                <path fill-rule="evenodd" d="M2 13.5A1.5 1.5 0 0 1 .5 12V4A1.5 1.5 0 0 1 2 2.5h7A1.5 1.5 0 0 1 10.5 4v1.5a.5.5 0 0 1-1 0V4a.5.5 0 0 0-.5-.5H2a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5v-1.5a.5.5 0 0 1 1 0V12A1.5 1.5 0 0 1 9 13.5H2z"/>
                            </svg>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if($request->getIsUserRequesting()):?>
                    <div class="row d-flex justify-content-center mb-3">
                        <div class="col-md-5">
                            <input type="submit" value="Rifiuta" class="btn btn-danger btn-block">
                        </div>
                        <div class="col-md-5">
                            <input type="submit" value="Accetta" class="btn btn-success btn-block">
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row d-flex justify-content-end mb-3">
                        <div class="col-md-5">
                            <input type="submit" value="Non ancora accettata" class="btn btn-warning btn-block disabled">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <? endforeach; ?>
        <? endif; ?>

        <?php if($data[REQUEST_CONTROL_TYPE] == USERTYPE && empty($data['REQUESTS_DTO'])):?>
            <div class="row d-flex justify-content-center">
                <div class="alert alert-warning col-md-6 mt-4 mb-4 text-center" role="alert">
                    <strong>Non ci sono richieste di partecipazione</strong>
                </div>
            </div>
        <?php endif;?>
        <?php   if($data[REQUEST_CONTROL_TYPE] == IDEATYPE && empty($data['REQUESTS_DTO']) ):?>
            <div class="row d-flex justify-content-center">
                <div class="alert alert-warning col-md-6 mt-4 mb-4 text-center" role="alert">
                    <strong>Non ci sono richieste di partecipazione all'idea</strong>
                </div>
            </div>
        <?php endif;?>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
