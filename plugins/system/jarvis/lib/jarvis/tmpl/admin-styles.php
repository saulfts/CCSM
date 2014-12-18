<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-styles.php 14 2014-07-17 04:49:10Z linhnt $
 */
?>
<!-- Preset colors -->
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_PRESET_OPTIONS'); ?></h3>
		<p><?php echo JText::_('JARVIS_PRESET_STYLES_OPTIONS_DESC'); ?></p>
	</div>

	<label class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_PRESET_COLORS'); ?></label>
	<div class="jarvis-fields">
		<div class="jarvis-field">
			<?php echo $jarvisForm->getInput('templateColor', 'jarvis') ?>
		</div>
	</div>
</div>


<!-- Typography -->
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_TYPO_OPTIONS'); ?></h3>
		<p><?php echo JText::_('JARVIS_TYPO_OPTIONS_DESC'); ?></p>
	</div>

	<label class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_COMMON_STYLE'); ?></label>
	<div class="jarvis-fields jarvis-fields-inline">
		<div class="jarvis-field">
			<div class="jarvis-input-tiny">
				<?php echo $jarvisForm->getInput('generalSize', 'jarvis') ?>
			</div>
			<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_FONTSIZE_OPTION_DESC'); ?></div>
		</div>
		<div class="jarvis-field jarvis-input-fit" style="margin-left: -4px;">
			<?php echo $jarvisForm->getInput('generalSizeUnit', 'jarvis') ?>
		</div>
		<div class="jarvis-field">
			<?php echo $jarvisForm->getInput('generalFont', 'jarvis') ?>
			<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_FONTFAMILY_OPTION_DESC'); ?></div>
		</div>
		<div class="jarvis-field">
			<div class="jarvis-input-tiny">
				<?php echo $jarvisForm->getInput('generalLineHeight', 'jarvis') ?>
			</div>
			<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_LINEHEIGHT_OPTION_DESC'); ?></div>
		</div>
		<div class="jarvis-field jarvis-input-fit" style="margin-left: -4px;">
			<?php echo $jarvisForm->getInput('generalLineHeightUnit', 'jarvis') ?>
		</div>
		<div class="jarvis-field">
			<?php echo $jarvisForm->getInput('generalColor', 'jarvis') ?>
			<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_COLOR_OPTION_DESC'); ?></div>
		</div>
	</div>
</div>

<div class="jarvis-section">
	<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_HEADING_STYLE'); ?></div>
	<div class="jarvis-fields">
		<div class="jarvis-fields-inline">
			<div class="jarvis-field">
				<?php echo $jarvisForm->getInput('headingFont', 'jarvis') ?>
				<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_FONTFAMILY_OPTION_DESC'); ?></div>
			</div>
			<div class="jarvis-field">
				<?php echo $jarvisForm->getInput('headingColor', 'jarvis') ?>
				<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_COLOR_OPTION_DESC'); ?></div>
			</div>
		</div>
		
		<div class="jarvis-field">
			<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_SHEADING_STYLE'); ?></div>

			<div class="jarvis-tabs jarvis-tabs-top jarvis-tabs-medium">
				<div class="jarvis-tabs-nav">
					<ul>
						<li><a href="#jarvis-h1-style">H1</a></li>
						<li><a href="#jarvis-h2-style">H2</a></li>
						<li><a href="#jarvis-h3-style">H3</a></li>
						<li><a href="#jarvis-h4-style">H4</a></li>
						<li><a href="#jarvis-h5-style">H5</a></li>
						<li><a href="#jarvis-h6-style">H6</a></li>
					</ul>
				</div>
				<div class="jarvis-tabs-pages">
					<?php foreach (range(1, 6) as $index): ?>
					<div class="jarvis-tab-page" id="jarvis-h<?php echo $index ?>-style">
						<div class="jarvis-fields-inline">
							<!-- FontSize -->
							<div class="jarvis-field">
								<div class="jarvis-input-tiny">
									<?php echo $jarvisForm->getInput("h{$index}Size", 'jarvis') ?>
								</div>
								<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_FONTSIZE_OPTION_DESC'); ?></div>
							</div>
							<div class="jarvis-field jarvis-input-fit" style="margin-left: -4px;">
								<?php echo $jarvisForm->getInput("h{$index}SizeUnit", 'jarvis') ?>
							</div>

							<!-- FontStyle -->
							<div class="jarvis-field">
								<div class="jarvis-buttonset">
									<?php echo $jarvisForm->getInput("h{$index}Style", 'jarvis') ?>
								</div>
								<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_FONTSTYLE_OPTION_DESC'); ?></div>
							</div>

							<!-- LineHeight -->
							<div class="jarvis-field">
								<div class="jarvis-input-tiny">
									<?php echo $jarvisForm->getInput("h{$index}LineHeight", 'jarvis') ?>
								</div>
								<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_LINEHEIGHT_OPTION_DESC'); ?></div>
							</div>
							<div class="jarvis-field jarvis-input-fit" style="margin-left: -4px;">
								<?php echo $jarvisForm->getInput("h{$index}LineHeightUnit", 'jarvis') ?>
							</div>

							<!-- Color -->
							<div class="jarvis-field">
								<?php echo $jarvisForm->getInput("h{$index}Color", 'jarvis') ?>
								<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_COLOR_OPTION_DESC'); ?></div>
							</div>
						</div>
					</div>
					<?php endforeach ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="jarvis-section">
	<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_ADDITIONAL_STYLE'); ?></div>
	<div class="jarvis-fields">
		<?php echo $jarvisForm->getInput('additionStyles', 'jarvis') ?>
	</div>
</div>

<div class="jarvis-section" style="margin-bottom: -1px; border-bottom: none;">
	<div class="jarvis-section-header" style="margin-bottom: -40px;">
		<h3><?php echo JText::_('JARVIS_HEADING_ADVANCED_STYLES'); ?></h3>
		<p><?php echo JText::_('JARVIS_STYLES_ADVANCED_OPTIONS_DESC'); ?></p>
	</div>
</div>
<div class="jarvis-section" data-require-edition="pro">
	<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_CUSTOM_CSS'); ?></div>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-code-editor" data-language="css">
			<?php echo $jarvisForm->getInput('customCSS', 'jarvis') ?>
		</div>
	</div>
</div>
