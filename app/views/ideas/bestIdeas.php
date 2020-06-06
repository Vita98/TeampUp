<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="container rounded mt-5 col-md-8">
        <div class="container text-center">
            <label class="display-4 ">
            <?php
            if(!empty($data) && isset($data[BEST_IDEA_TYPE])){
                switch ($data[BEST_IDEA_TYPE]){
                    case BEST_IDEA_INNOVATIVITY:
                        echo "Idee più Innovative";
                        break;
                    case BEST_IDEA_CREATIVITY:
                        echo "Idee più Creative";
                        break;
                    case BEST_IDEA:
                        echo "Idee Migliori";
                        break;
                    default:
                        break;
                }
            }
            ?>
            </label>
        </div>
        <?php if(!empty($data) && !empty($data[IDEASDTO])) : foreach($data[IDEASDTO] as $dto): ?>
            <div class="card card-body rounded bg-light mt-5 m-4">
                <div class="justify-center">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="form-group mt-3">
                                <label for="title" class="display-5 font-weight-bolder">Titolo: </label>
                                <label for="firstName"><?php echo $dto->title;?></label>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <div class="form-group mt-3  ">
                                <label for="title" class="display-5 ">Creato da: </label>
                                <label for="firstName" class="font-weight-bolder"><?php echo $data[OWNERS][$dto->id];?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="form-group mt-3 ">
                                <label for="firstName" class="display-5 font-weight-bolder">Categorie: </label>
                                <?php  foreach($data[CATEGORIES][$dto->id] as $ideaCategory): ?>
                                    <kbd style= "color:darkslategray;" class="alert-info"><label for="description"><?php echo $ideaCategory->getDescription(); ?></label></kbd>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-md-6 text-center">
                            <label><strong>Media Feedback: </strong></label>
                            <div><?php if (!empty($data[FEEDBACK_AVG])) {
                                    $feedbackVote = $data[FEEDBACK_AVG][$dto->id];
                                    require('starRatingFixed.php');
                                } ?></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group mt-3 text-center">
                            <a href="<?php echo URLROOT; ?>/ideas/showIdea/<?php echo $dto->id; ?>" type="button" class="btn btn-primary">Visualizza</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>
