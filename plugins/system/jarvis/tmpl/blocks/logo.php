<?php if ($this->document->countModules($this->position) == 0): ?>
	<h1 class="logo">
		<a href="<?php echo \JURI::root(true) ?>">
			<img src="<?php echo \JURI::root(true) ?>/<?php echo \JFactory::getDocument()->params['logo'] ?>" alt="" />
		</a>
	</h1>
<?php else: ?>
	<jdoc:include type="modules" name="<?php echo $this->position ?>" style="<?php echo $this->positionStyle ?>" />
<?php endif ?>