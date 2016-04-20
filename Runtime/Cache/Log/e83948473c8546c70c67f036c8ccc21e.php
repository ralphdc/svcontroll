<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent">
	<div class="pageFormContent">
		<?php if($type == 1 ): ?><iframe width="1370px" height="696px" frameborder="0" marginwidth="0" marginheight="0" src="/index.php?s=/Log/Jsonedit/index/id/<?php echo ($id); ?>/type/<?php echo ($ltype); ?>" name="frame" id="frame">
		<?php else: ?>
		<div style="height: 634px; overflow: auto;" layouth="58"><?php echo ($info); ?></div><?php endif; ?>
	</div>
</div>