<div id="jarvis-style-edit" class="jarvis-dialog">
	<form>
		<div class="jarvis-section">
			<div class="jarvis-field">
				<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_STYLE_NAME'); ?></div>
				<div class="jarvis-input-fit">
					<input type="text" name="style-name" class="jarvis-input" />
				</div>
			</div>
			<div class="jarvis-fields">
				<div class="jarvis-field">
					<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_STYLE_OPTIONS'); ?></div>
					<select name="font-family" style="width: 408px"></select>
					<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_FONTFAMILY_OPTION_DESC'); ?></div>
				</div>
			</div>
			<div class="jarvis-fields jarvis-fields-inline">
				<div class="jarvis-field">
					<div class="jarvis-buttonset">
						<fieldset class="checkbox-list">
							<input type="checkbox" id="jarvis-fontstyle-bold" name="font-style[]" value="bold" /><!-- 
							 --><label for="jarvis-fontstyle-bold">B</label><!-- 
							 --><input type="checkbox" id="jarvis-fontstyle-underline" name="font-style[]" value="underline" /><!-- 
							 --><label for="jarvis-fontstyle-underline">U</label><!-- 
							 --><input type="checkbox" id="jarvis-fontstyle-italic" name="font-style[]" value="italic" /><!-- 
							 --><label for="jarvis-fontstyle-italic">I</label><!-- 
							 --><input type="checkbox" id="jarvis-fontstyle-strike" name="font-style[]" value="strike" /><!-- 
							 --><label for="jarvis-fontstyle-strike">S</label>
						</fieldset>
					</div>
					<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_FONTSTYLE_OPTION_DESC'); ?></div>
				</div>
				<div class="jarvis-field">
					<div class="jarvis-input-group jarvis-input-tiny">
						<input type="text" class="jarvis-input" name="font-size" />
						<span class="jarvis-input-suffix">px</span>
                        <div class="jarvis-input-desc"><?php echo JText::_('JARVIS_FONTSIZE_OPTION_DESC'); ?></div>
					</div>
				</div>
				<div class="jarvis-field">
					<div class="jarvis-input-group jarvis-input-tiny">
						<input type="text" class="jarvis-input" name="line-height" />
						<span class="jarvis-input-suffix">px</span>
                        <div class="jarvis-input-desc"><?php echo JText::_('JARVIS_LINEHEIGHT_OPTION_DESC'); ?></div>
					</div>
				</div>
				<div class="jarvis-field">
					<div class="jarvis-color-picker">
						<button type="button" class="jarvis-button"></button>
						<input type="text" name="color" value="#000000">
					</div>
					<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_COLOR_OPTION_DESC'); ?></div>
				</div>
			</div>
			<div class="jarvis-field">
				<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_CSS_SELECTOR'); ?></div>
				<div class="jarvis-input-fit">
					<textarea name="selector"></textarea>
				</div>
				<div class="jarvis-input-desc">
					<?php echo JText::_('JARVIS_OPTION_CSS_SELECTOR_DESC'); ?>
				</div>
			</div>
		</div>
		<div class="jarvis-editor-toolbar">
			<button type="button" data-command="save" class="jarvis-button jarvis-button-large jarvis-button-blue"><?php echo JText::_('JARVIS_BUTTON_SAVE'); ?></button>
			<button type="button" data-command="cancel" class="jarvis-button jarvis-button-large"><?php echo JText::_('JARVIS_BUTTON_CANCEL'); ?></button>
		</div>
	</form>
</div>