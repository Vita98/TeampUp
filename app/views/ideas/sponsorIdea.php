<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="container text-center">
            <label class="display-4 ">Sponsorizza IDEA</label>
        </div>
        <div class="container bg-light border rounded mt-3 col-md-10 p-5">
            <form action="<?php echo URLROOT; ?>/ideas/sponsorIdea/<?php echo $data[IDEADTO]->getId(); ?>" method="post">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="firstName" class="d-flex justify-content-center">Data fine sponsorizzazione: *</label>
                        </div>
                        <div class="col-md-9">
                            <input type="date" min="<?php echo date("Y-m-d")?>" name="<?php echo IDEA_SPONSOR_DATE_FIELD ?>" class="form-control form-control-sm
                            <?php echo (!empty($data[ERRORS][IDEA_SPONSOR_DATE_FIELD])) ? 'is-invalid' : ''; ?>" value="<?php echo $data[IDEADTO]->getSponsorEndDate(); ?>"/>
                            <span class="invalid-feedback"><?php echo $data[ERRORS][IDEA_SPONSOR_DATE_FIELD]; ?></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="abilities" class="d-flex justify-content-center">Categoria sponsorizzazione: *</label>
                        </div>
                        <div class="col-md-9">
                            <?php foreach($data[CATEGORIES] as $category): ?>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input
                                            type="radio"
                                            id="<?php echo $category->getId()?>"
                                            name="<?php echo IDEA_SPONSOR_CATEGORY_ID_FIELD . "[]"?>"
                                            value="<?php echo $category->getId(); ?>"
                                            <?php echo $category->getId() === $data[IDEADTO]->getSponsorCategoryid() ? "checked=checked" : ""; ?>
                                            class="custom-control-input"
                                    >
                                    <label
                                            class="custom-control-label"
                                            for="<?php echo $category->getId()?>">
                                        <?php echo $category->getDescription(); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                            <input type="text" class= "is-invalid" hidden = "hidden"/>
                            <span class="invalid-feedback"><?php echo $data[ERRORS][IDEA_SPONSOR_CATEGORY_ID_FIELD]; ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mt-5">
                        <input type="submit" value="Sponsorizza" class="btn btn-success btn-block">
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>