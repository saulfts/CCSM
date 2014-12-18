<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-logo.php 14 2014-07-17 04:49:10Z linhnt $
 */
?>
<!-- Logo -->
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_LOGO_OPTIONS'); ?></h3>
		<p><?php echo JText::_('JARVIS_LOGO_OPTIONS_DESC'); ?></p>
	</div>
	<label for="" class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_LOGO'); ?></label>
	<div class="jarvis-fields">
		<div class="jarvis-field">
			<div class="jarvis-field-media jarvis-input-large">
				<div class="jarvis-input-group">
					<?php echo $jarvisForm->getField('logo', 'jarvis')->input ?>
					<a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_logo"
						class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
				</div>
				<button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
			</div>
			<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_LOGO_NORMAL_DPI_DESC'); ?></div>
		</div>

		<div class="jarvis-field">
			<div class="jarvis-field-media jarvis-input-large">
				<div class="jarvis-input-group">
					<?php echo $jarvisForm->getField('logo2x', 'jarvis')->input ?>
					<a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_logo2x"
						class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
				</div>
				<button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
			</div>
			<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_LOGO_HIGH_DPI_DESC'); ?></div>
		</div>
		<div class="jarvis-fieldset jarvis-fields-inline">
			<div class="jarvis-field jarvis-input-group jarvis-input-tiny">
				<?php echo $jarvisForm->getField('logo2xWidth', 'jarvis')->input ?>
				<span class="jarvis-input-suffix">px</span>
				<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_OPTION_WIDTH_DESC'); ?></div>
			</div>
			<div class="jarvis-field jarvis-input-group jarvis-input-tiny">
				<?php echo $jarvisForm->getField('logo2xHeight', 'jarvis')->input ?>
				<span class="jarvis-input-suffix">px</span>
				<div class="jarvis-input-desc"><?php echo JText::_('JARVIS_OPTION_HEIGHT_DESC'); ?></div>
			</div>
		</div>
	</div>
</div>

<!-- Bookmark Icon -->
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_ICONS_OPTIONS'); ?></h3>
		<p><?php echo JText::_('JARVIS_ICONS_OPTIONS_DESC'); ?></p>
	</div>

	<label for="" class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_FAVICON'); ?></label>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-field-media jarvis-input-large">
			<div class="jarvis-input-group">
				<?php echo $jarvisForm->getField('bookmarkIcon', 'jarvis')->input ?>
				<a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_bookmarkIcon"
					class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
			</div>
			<button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
            <div class="jarvis-input-desc"><?php echo JText::_('JARVIS_OPTION_FAVICON_DESC'); ?></div>
		</div>
	</div>
</div>

<!-- Homescreen Icons -->
<div class="jarvis-section">
	<label for="" class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_BOOKMARK_ICONS'); ?></label>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-field-media jarvis-input-large">
			<div class="jarvis-input-group">
				<?php echo $jarvisForm->getField('xsmallIcon', 'jarvis')->input ?>
				<a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_xsmallIcon"
					class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
			</div>
			
			<button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
            <div class="jarvis-input-desc"><?php echo JText::_('JARVIS_OPTION_ICONS_XSMALL_DESC'); ?></div>
		</div>
		<div class="jarvis-field jarvis-field-media jarvis-input-large">
			<div class="jarvis-input-group">
				<?php echo $jarvisForm->getField('smallIcon', 'jarvis')->input ?>
				<a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_smallIcon"
					class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
			</div>
			
			<button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
            <div class="jarvis-input-desc"><?php echo JText::_('JARVIS_OPTION_ICONS_SMALL_DESC'); ?></div>
		</div>
		<div class="jarvis-field jarvis-field-media jarvis-input-large">
			<div class="jarvis-input-group">
				<?php echo $jarvisForm->getField('mediumIcon', 'jarvis')->input ?>
				<a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_mediumIcon"
					class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
			</div>
			
			<button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
            <div class="jarvis-input-desc"><?php echo JText::_('JARVIS_OPTION_ICONS_MEDIUM_DESC'); ?></div>
		</div>

		<div class="jarvis-field jarvis-field-media jarvis-input-large">
			<div class="jarvis-input-group">
				<?php echo $jarvisForm->getField('largeIcon', 'jarvis')->input ?>
				<a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_largeIcon"
					class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
			</div>

			<button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
            <div class="jarvis-input-desc"><?php echo JText::_('JARVIS_OPTION_ICONS_LARGE_DESC'); ?></div>
		</div>
	</div>
</div>
