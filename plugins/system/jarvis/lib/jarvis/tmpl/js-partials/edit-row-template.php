<div id="jarvis-layout-section-edit" class="jarvis-dialog">
	<form>
		<div class="jarvis-section">
			<div class="jarvis-field">
				<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_ID'); ?></div>
				<div class="jarvis-input-small">
					<input type="text" name="id" class="jarvis-input" />
				</div>
			</div>
			<div class="jarvis-field">
				<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_CLASS'); ?></div>
				<div class="jarvis-input-large">
					<input type="text" name="class" class="jarvis-input" />
				</div>
			</div>

			<fieldset id="custom-background">
				<legend><?php echo JText::_('JARVIS_LABEL_CUSTOM_BACKGROUND'); ?></legend>
				<div class="jarvis-field">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_COLOR'); ?></div>
					<div class="jarvis-color-picker">
						<button type="button" class="jarvis-button"></button>
						<input type="text" name="background[color]" value="">
					</div>
				</div>
				<div class="jarvis-field">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_IMAGE'); ?></div>
					<div class="jarvis-field-media">
						<div class="jarvis-input-group">
							<input type="text" name="background[image]" id="jarvis_background_image" value="">
							<a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_background_image"
								class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
						</div>
						<button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
					</div>
				</div>
				<div class="jarvis-field">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_REPEAT'); ?></div>
					<select name="background[repeat]">
						<option value="no-repeat">no-repeat</option>
						<option value="repeat-x">repeat-x</option>
						<option value="repeat-y">repeat-y</option>
					</select>
				</div>
				<div class="jarvis-field">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_POSITION'); ?></div>
                    <input type="text" name="background[position-x]" id="jarvis_background_position_x" value="" style="width: 80px">
                    <input type="text" name="background[position-y]" id="jarvis_background_position_y" value="" style="width: 80px">
				</div>
				<div class="jarvis-field">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_ATTACHMENT'); ?></div>
					<div class="jarvis-buttonset">
						<fieldset id="jarvis_attachment" class="radio ui-buttonset"><!--
						--><input type="radio" id="jarvis_attachment0" name="background[attachment]" value="scroll"><!--
						--><label for="jarvis_attachment0" class="ui-button"><?php echo JText::_('JARVIS_OPTION_SCROLL'); ?></label><!--
						--><input type="radio" id="jarvis_attachment1" name="background[attachment]" value="fixed"><!--
						--><label for="jarvis_attachment1" class="ui-button"><?php echo JText::_('JARVIS_OPTION_FIXED'); ?></label><!--
						--></fieldset>
					</div>
				</div>
			</fieldset>
			<fieldset id="visibility">
				<legend><?php echo JText::_('JARVIS_LABEL_VISIBILITY'); ?></legend>

				<div class="jarvis-field jarvis-switcher">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_OPTION_LARGE'); ?></div>
					<input type="checkbox" id="jarvis_visibility0" name="visibility[]" value="large">
					<label for="jarvis_visibility0">
						<span class="jarvis-indicator"></span>
					</label>
				</div>
				<div class="jarvis-field jarvis-switcher">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_OPTION_MEDIUM'); ?></div>
					<input type="checkbox" id="jarvis_visibility1" name="visibility[]" value="medium">
					<label for="jarvis_visibility1">
						<span class="jarvis-indicator"></span>
					</label>
				</div>
				<div class="jarvis-field jarvis-switcher">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_OPTION_SMALL'); ?></div>
					<input type="checkbox" id="jarvis_visibility2" name="visibility[]" value="small">
					<label for="jarvis_visibility2">
						<span class="jarvis-indicator"></span>
					</label>
				</div>
				<div class="jarvis-field jarvis-switcher">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_OPTION_XSMALL'); ?></div>
					<input type="checkbox" id="jarvis_visibility3" name="visibility[]" value="xsmall">
					<label for="jarvis_visibility3">
						<span class="jarvis-indicator"></span>
					</label>
				</div>
			</fieldset>
		</div>
        <div class="jarvis-editor-toolbar">
			<button type="button" data-command="save" class="jarvis-button jarvis-button-large jarvis-button-blue"><?php echo JText::_('JARVIS_BUTTON_SAVE'); ?></button>
			<button type="button" data-command="cancel" class="jarvis-button jarvis-button-large"><?php echo JText::_('JARVIS_BUTTON_CANCEL'); ?></button>
		</div>
	</form>
</div>