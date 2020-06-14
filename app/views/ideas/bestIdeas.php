<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="container rounded mt-3 col-md-8">
        <div class="container text-center">
            <label class="display-3 ">TeamUp</label>
            <p>La piattaforma dove ogni tua idea può prendere forma!</p>
        </div>
        <div class="mt-5 text-center">
            <div class="d-flex justify-content-center">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link <?php echo "" . (isset($data[BEST_IDEA_TYPE]) && $data[BEST_IDEA_TYPE] == BEST_IDEA_CREATIVITY) ? "active" : "" ?>"  href="<?php echo URLROOT?>/ideas/bestIdeas/CREATIVITY">Idee più creative</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo "" . (isset($data[BEST_IDEA_TYPE]) && $data[BEST_IDEA_TYPE] == BEST_IDEA) ? "active" : "" ?>"  href="<?php echo URLROOT?>/ideas/bestIdeas/">Idee Migliori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo "" . (isset($data[BEST_IDEA_TYPE]) && $data[BEST_IDEA_TYPE] == BEST_IDEA_INNOVATIVITY) ? "active" : "" ?>"  href="<?php echo URLROOT?>/ideas/bestIdeas/INNOVATIVITY">Idee più innovative</a>
                    </li>
                </ul>
            </div>
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
                            <label><strong><?php
                                if(isset($data[BEST_IDEA_TYPE]) && $data[BEST_IDEA_TYPE] == BEST_IDEA_INNOVATIVITY)   {
                                    echo "Media feedback Innovatività";
                                }elseif (isset($data[BEST_IDEA_TYPE]) && $data[BEST_IDEA_TYPE] == BEST_IDEA_CREATIVITY){
                                    echo "Media feedback Creatività";
                                }elseif (isset($data[BEST_IDEA_TYPE]) && $data[BEST_IDEA_TYPE] == BEST_IDEA){
                                    echo "Media feedback";
                                }

                            ?> </strong></label>
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
