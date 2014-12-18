<div id="style-switcher">
	<form name="style-switcher">
		<button type="button" class="toggler"><i class="fa fa-cog"></i></button>
		<div class="schemes-list">
			<h3><?php echo JText::_('JARVIS_LABEL_FRONT_PRESET_COLORS'); ?></h3>
		</div>
		<div class="layout-style">
			<h3><?php echo JText::_('JARVIS_LABEL_LAYOUT_MODE'); ?></h3>
			<select name="layout">
				<option value="full-width"><?php echo JText::_('JARVIS_OPTION_FULL_WIDTH'); ?></option>
				<option value="boxed"><?php echo JText::_('JARVIS_OPTION_BOXED'); ?></option>
			</select>
		</div>
		<div class="background-patterns">
			<h3><?php echo JText::_('JARVIS_LABEL_BACKGROUND_PATTERN'); ?></h3>
		</div>
        <div class="switcher-toolbar">
			<button type="button" class="reset"><i class="fa fa-undo"></i> <?php echo JText::_('JARVIS_BUTTON_RESET'); ?></button>
		</div>
	</form>
</div>