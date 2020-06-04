
<?php
if (!defined('SELECTED_COLOR')) {define('SELECTED_COLOR','color:orange;');}
?>

<fieldset class="rate" id="ratingFixed">
    <legend></legend>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 5) ? SELECTED_COLOR : "" ?>" title="5 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 4.5) ? SELECTED_COLOR : "" ?>" class="half" title="4 1/2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 4) ? SELECTED_COLOR : "" ?>" title="4 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 3.5) ? SELECTED_COLOR : "" ?>" class="half" title="3 1/2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 3) ? SELECTED_COLOR : "" ?>" title="3 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 2.5) ? SELECTED_COLOR : "" ?>" class="half" title="2 1/2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 2) ? SELECTED_COLOR : "" ?>" title="2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 1.5) ? SELECTED_COLOR : "" ?>" class="half" title="1 1/2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 1) ? SELECTED_COLOR : "" ?>" title="1 star"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 0.5) ? SELECTED_COLOR : "" ?>" class="half"  title="1/2 star"></label>
</fieldset>