<?php if(!defined('INPUT_KEY')) {define('INPUT_KEY','Input');}?>
<?php if(isset($ratingId) && !empty($ratingId)): ?>
    <fieldset class="rate" id="<?php echo $ratingId; ?>">
        <legend></legend>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."10".INPUT_KEY; ?>" value="10" /><label id="<?php echo $ratingId; ?>10" title="5 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."9".INPUT_KEY; ?>" value="9" /><label id="<?php echo $ratingId; ?>9" class="half" title="4 1/2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."8".INPUT_KEY; ?>" value="8" /><label id="<?php echo $ratingId; ?>8" title="4 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."7".INPUT_KEY; ?>" value="7" /><label id="<?php echo $ratingId; ?>7" class="half" title="3 1/2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."6".INPUT_KEY; ?>" value="6" /><label id="<?php echo $ratingId; ?>6" title="3 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."5".INPUT_KEY; ?>" value="5" /><label id="<?php echo $ratingId; ?>5" class="half" title="2 1/2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."4".INPUT_KEY; ?>" value="4" /><label id="<?php echo $ratingId; ?>4" title="2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."3".INPUT_KEY; ?>" value="3" /><label id="<?php echo $ratingId; ?>3" class="half" title="1 1/2 stars"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."2".INPUT_KEY; ?>" value="2" /><label id="<?php echo $ratingId; ?>2" title="1 star"></label>
        <input type="radio" name="<?php echo $ratingId; ?>" id="<?php echo $ratingId."1".INPUT_KEY; ?>" value="1" /><label id="<?php echo $ratingId; ?>1" class="half"  title="1/2 star"></label>
    </fieldset>
<?php endif; ?>