<div id="jarvis-layout-map-position" class="jarvis-dialog">
	<form>
		<div class="jarvis-section">
			<div class="jarvis-field">
				<div class="jarvis-input-large">
					<input type="text" name="position-filter" class="jarvis-input" placeholder="<?php echo JText::_('JARVIS_TITLE_SEARCH_ADD_POSITION'); ?>" />
					<button type="button" class="jarvis-button" data-command="addPosition" title="<?php echo JText::_('JARVIS_TITLE_ADD_POSITION'); ?>"><?php echo JText::_('JARVIS_BUTTON_ADD_POSITION'); ?></button>
				</div>
			</div>
			<div class="jarvis-field">
				<div class="jarvis-input-fit">
					<select name="position" size="10">
					</select>
				</div>
			</div>
			<div class="jarvis-field">
				<label class="jarvis-input-label"><?php echo JText::_('JARVIS_LABEL_MODULE_STYLE'); ?></label>
				<div class="jarvis-input-fit">
					<select name="style">
					</select>
				</div>
			</div>
		</div>
		<div class="jarvis-editor-toolbar">
			<button type="button" data-command="save" class="jarvis-button jarvis-button-large jarvis-button-blue"><?php echo JText::_('JARVIS_BUTTON_SAVE'); ?></button>
			<button type="button" data-command="cancel" class="jarvis-button jarvis-button-large"><?php echo JText::_('JARVIS_BUTTON_CANCEL'); ?></button>
		</div>
	</form>
</div>