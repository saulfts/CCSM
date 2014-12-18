<div id="jarvis-layout-column-edit" class="jarvis-dialog">
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