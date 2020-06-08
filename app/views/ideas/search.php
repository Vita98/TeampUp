<?php define('STAR_RATING_EDITABLE','starRatingEditable.php')?>
<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
    <?php $searchMode = !isset($data[IDEASDTO]); ?>
    <?php if(!$searchMode) :?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-2">
                <a href="<?php echo URLROOT; ?>/ideas/searchIdea" class="btn btn-light"><em class="fa fa-backward"></em> Back</a>
            </div>
            <div class="col-md-8">
                <div class="container text-center mt-3">
                    <label class="display-4">Risultati Ricerca</label>
                    <p>In questa sezione è possibile consultare i risultati di ricerca idea</p>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <?php else: ?>
    <div class="container text-center mt-3">
        <label class="display-4">Ricerca idea</label>
        <p>In questa sezione è possibile effettuare la ricerca di un'idea</p>
    </div>
    <?php endif; ?>

    <?php if($searchMode) :?>
    <div class="card card-body bg-light mt-5">
        <form id="searchForm" action="<?php echo URLROOT; ?>/ideas/searchIdea/" method="GET">
            <div class="form-group">
                <strong><label for="title">Titolo</label></strong>
                <input type="text" placeholder = "Inserisci un titolo" name="title" class="form-control form-control-lg"/>
            </div>
            <strong><label>Categorie</label></br></strong>
            <div>
                <?php foreach($data[CATEGORIES] as $category): ?>
                    <div class='form-check form-check-inline'>
                            <input class='form-check-input' type='checkbox' name='<?php echo CHECKED . "[]"?>'
                                   id='<?php echo $category->getId()?>' value='<?php echo $category->getId()?>'/>
                        <label for='<?php echo CHECKED."[]"; ?>' class ='form-check-label'> <?php echo $category->getDescription(); ?> </label>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="container p-4 mt-3 mb-3 border rounded bg-white ">
                <div class="row pt-1 pb-2 text-center">
                    <div class="col-md-4">
                        <div class="">
                            <label><strong>Innovatività</strong></label>
                            <div><?php $ratingId = INNOVATIVITY; require (STAR_RATING_EDITABLE); ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="">
                            <label><strong>Creatività</strong></label>
                            <div><?php $ratingId = CREATIVITY; require (STAR_RATING_EDITABLE); ?></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="">
                            <label><strong>Media Feedback</strong></label>
                            <div><?php $ratingId = FEEDBACK_AVG; require (STAR_RATING_EDITABLE); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="text" name="searchMode" value="true" hidden="hidden"/>
            <div class="row">
                <div class="col p-3 mt-4">
                    <input type="submit" value="Avvia Ricerca" class="btn btn-success btn-block">
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="container row">
        <?php if(!$searchMode && ($data[IDEASDTO] == null || !count($data[IDEASDTO])) ) :  ?>
        <div class="col-md-12">
            <div class="alert alert-warning text-center mt-5 mb-5" role="alert">
                Nessuna idea risponde a questi requisiti
            </div>
        </div>

        <?php elseif(!$searchMode && $data[IDEASDTO] != null) :?>
            <?php foreach($data[IDEASDTO] as $dto): ?>
                <div class="col-md-12">
                <?php if(($dto->getSponsorCategoryid() == 1 || $dto->getSponsorCategoryid() == 3) && date_format(new DateTime($dto->getSponsorEndDate()), DATE_FORMAT) >= date_format(new DateTime(), DATE_FORMAT)) :?>
                    <div class="card card-body rounded border-success mt-5"">
                    <div class="card-header bg-transparent border-success text-center"><strong>Sponsorizzata da TeamUp! fino al <?php echo date_format(new DateTime($dto->getSponsorEndDate()), DATE_FORMAT); ?></strong></div>
                <?php else : ?>
                    <div class="card card-body rounded bg-light mt-5">
                <?php endif; ?>
                        <div class="justify-center">
                            <div class="form-group mt-3 ">
                                <label for="title" class="display-5 font-weight-bolder">Titolo: </label>
                                <label for="firstName"><?php echo $dto->getTitle();?></label>
                            </div>
                            <div class="form-group mt-3 ">
                                <label for="creationDate" class="display-5 font-weight-bolder">Data di creazione: </label>
                                <label for="creationDate"><?php echo date_format(new DateTime($dto->getCreationDate()), DATE_FORMAT);?></label>
                            </div>
                            <div class="form-group mt-3 text-right">
                                <a href="<?php echo URLROOT; ?>/ideas/showIdea/<?php echo $dto->getId(); ?>" type="button" class="btn btn-primary">Visualizza</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
<script>
    function init() {
        var ele = document.getElementById("searchForm");
        if(ele){
            ele.reset();
        }
    }
    window.onload = init;
</script>