
<fieldset class="rate" id="ratingFixed">
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 5) ? "color:orange;" : "" ?>" title="5 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 4.5) ? "color:orange;" : "" ?>" class="half" title="4 1/2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 4) ? "color:orange;" : "" ?>" title="4 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 3.5) ? "color:orange;" : "" ?>" class="half" title="3 1/2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 3) ? "color:orange;" : "" ?>" title="3 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 2.5) ? "color:orange;" : "" ?>" class="half" title="2 1/2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 2) ? "color:orange;" : "" ?>" title="2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 1.5) ? "color:orange;" : "" ?>" class="half" title="1 1/2 stars"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 1) ? "color:orange;" : "" ?>" title="1 star"></label>
    <input type="radio" name="rating" /><label style="<?php echo ($feedbackVote >= 0.5) ? "color:orange;" : "" ?>" class="half"  title="1/2 star"></label>
</fieldset>