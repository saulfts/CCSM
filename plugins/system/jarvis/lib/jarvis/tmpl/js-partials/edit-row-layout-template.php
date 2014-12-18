<div id="jarvis-layout-row-edit" class="jarvis-dialog">
	<form>
		<div class="jarvis-section">
			<div class="jarvis-buttonset">
				<fieldset><!--
				--><input type="radio" id="jarvis_screensize0" name="screensize" value="large" checked="checked"><!--
				--><label for="jarvis_screensize0" class="ui-button"><?php echo JText::_('JARVIS_OPTION_LARGE'); ?></label><!--
				--><input type="radio" id="jarvis_screensize1" name="screensize" value="medium"><!--
				--><label for="jarvis_screensize1" class="ui-button"><?php echo JText::_('JARVIS_OPTION_MEDIUM'); ?></label><!--
				--><input type="radio" id="jarvis_screensize2" name="screensize" value="small"><!--
				--><label for="jarvis_screensize2" class="ui-button"><?php echo JText::_('JARVIS_OPTION_SMALL'); ?></label><!--
				--><input type="radio" id="jarvis_screensize3" name="screensize" value="xsmall"><!--
				--><label for="jarvis_screensize3" class="ui-button"><?php echo JText::_('JARVIS_OPTION_XSMALL'); ?></label><!--
				--></fieldset>
			</div>
			<div class="jarvis-layout-container" data-screen-size="large">
			</div>
		</div>
		<div class="jarvis-editor-toolbar">
			<button type="button" data-command="save" class="jarvis-button jarvis-button-large jarvis-button-blue"><?php echo JText::_('JARVIS_BUTTON_SAVE'); ?></button>
			<button type="button" data-command="cancel" class="jarvis-button jarvis-button-large"><?php echo JText::_('JARVIS_BUTTON_CANCEL'); ?></button>
		</div>
	</form>
</div>
