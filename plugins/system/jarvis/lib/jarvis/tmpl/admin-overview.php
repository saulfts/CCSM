<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-overview.php 14 2014-07-17 04:49:10Z linhnt $
 */
?>
<div id="jarvis-style-details" class="jarvis-section">
	<div id="jarvis-style-thumbnail">
		<img src="<?php echo JUri::root(true) ?>/templates/<?php echo $template ?>/template_thumbnail.png" alt="" />
	</div>
	<div id="jarvis-style-info">
		<h1 class="jarvis-title">
			<?php echo $templateManifest->name ?>
		</h1>
		<div class="jarvis-meta">
			<div class="jarvis-template-version">
				<strong><?php echo JText::_('JARVIS_LABEL_TEMPLATE_VERSION'); ?></strong>
				<span><?php echo $templateManifest->version ?></span>
			</div>
			<div class="jarvis-framework-version">
				<strong><?php echo JText::_('JARVIS_LABEL_FRAMEWORK_VERSION'); ?></strong>
				<span>1.0.0</span>
			</div>
		</div>

		<div class="jarvis-template-desc">
			<p><?php echo JText::_($templateManifest->description) ?></p>
		</div>

		<div class="jarvis-toolbar">
			<a href="http://www.omegatheme.com/documentation" class="jarvis-button jarvis-outline"><?php echo JText::_('JARVIS_BUTTON_LINK_DOCUMENT'); ?></a>
			<a href="http://www.omegatheme.com/forum/" class="jarvis-button jarvis-outline"><?php echo JText::_('JARVIS_BUTTON_LINK_FORUM'); ?></a>
			<a href="http://www.omegatheme.com/videos" class="jarvis-button jarvis-outline"><?php echo JText::_('JARVIS_BUTTON_LINK_VIDEOS'); ?></a>
		</div>
	</div>
</div>