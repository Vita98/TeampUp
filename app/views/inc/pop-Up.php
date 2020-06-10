<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php if (isset($popUpData)) {echo $popUpData['modal-title'];}?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="ModificationBody">
                <?php if (isset($popUpData)) {echo $popUpData['modal-body'];}?>
            </div>
            <div class="modal-footer">
                <button type="button" id="ModificationDeleteButton" class="btn btn-secondary" data-dismiss="modal"><?php if (isset($popUpData)) {echo $popUpData['modal-secondary'];}?></button>
                <a href="" id="ModificationSaveButton" <button type="button" class="btn btn-primary"><?php if (isset($popUpData)) {echo $popUpData['modal-primary'];}?></button></a>
            </div>
        </div>
    </div>
</div>
