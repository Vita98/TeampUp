
<?php if(isset($ratingId) && !empty($ratingId)): ?>
    <fieldset class="rate" id="<?php echo $ratingId; ?>">
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."10"."Input"; ?>" value="10" /><label id="<?php echo $ratingId; ?>10" title="5 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."9"."Input"; ?>" value="9" /><label id="<?php echo $ratingId; ?>9" class="half" title="4 1/2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."8"."Input"; ?>" value="8" /><label id="<?php echo $ratingId; ?>8" title="4 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."7"."Input"; ?>" value="7" /><label id="<?php echo $ratingId; ?>7" class="half" title="3 1/2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."6"."Input"; ?>" value="6" /><label id="<?php echo $ratingId; ?>6" title="3 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."5"."Input"; ?>" value="5" /><label id="<?php echo $ratingId; ?>5" class="half" title="2 1/2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."4"."Input"; ?>" value="4" /><label id="<?php echo $ratingId; ?>4" title="2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."3"."Input"; ?>" value="3" /><label id="<?php echo $ratingId; ?>3" class="half" title="1 1/2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."2"."Input"; ?>" value="2" /><label id="<?php echo $ratingId; ?>2" title="1 star"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."1"."Input"; ?>" value="1" /><label id="<?php echo $ratingId; ?>1" class="half"  title="1/2 star"></label>
    </fieldset>
<?php endif; ?>