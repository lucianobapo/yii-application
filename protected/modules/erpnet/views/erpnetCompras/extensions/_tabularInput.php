<div class="simple">
	<?php echo CHtml::activeLabelEx($model,"username"); ?>
	<?php echo CHtml::activeTextField($model,"[$index]username"); ?>
	<?php echo CHtml::error($model,"[$index]username"); ?>
</div>

<div class="simple">
	<?php echo CHtml::activeLabelEx($model,"email"); ?>
	<?php echo CHtml::activeTextField($model,"[$index]email"); ?>
	<?php echo CHtml::error($model,"[$index]email"); ?>
</div>

