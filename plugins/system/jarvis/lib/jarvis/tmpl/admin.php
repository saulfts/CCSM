<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin.php 14 2014-07-17 04:49:10Z linhnt $
 */
?>
<form action="" method="POST" name="adminForm" id="style-form">
	<div id="joomla-toolbar">
		<label for="jform_title"><?php echo JText::_('COM_TEMPLATES_FIELD_TITLE_LABEL'); ?></label>
		<?php $joomlaForm->setFieldAttribute('title', 'class', 'input-xlarge input-large-text'); ?>
		<?php echo $joomlaForm->getInput('title') ?>

		<label for="jform_template"><?php echo JText::_('COM_TEMPLATES_FIELD_TEMPLATE_LABEL'); ?></label>
		<?php echo $joomlaForm->getInput('template') ?>

		<label for="jform_home"><?php echo JText::_('COM_TEMPLATES_FIELD_HOME_LABEL'); ?></label>
		<?php echo $joomlaForm->getInput('home') ?>

		<?php echo $joomlaForm->getInput('client_id') ?>
	</div>

	<div id="jarvis" class="jarvis">
		<div class="jarvis-wrapper jarvis-tabs jarvis-tabs-left jarvis-tabs-indicator">
			<input type="hidden" name="task" />
			<?php echo JHtml::_('form.token'); ?>

			<div id="jarvis-nav" class="jarvis-tabs-nav">
				<div class="jarvis-logo">
					<a href="" target="_blank">
						<img src="<?php echo JUri::root(true) ?>/plugins/system/jarvis/assets/img/logo.png" alt="Jarvis Framework" />
					</a>
				</div>
				<ul>
					<li><a class="jarvis-icon-overview" href="#jarvis-overview"><?php echo JText::_('JARVIS_TAB_OVERVIEW'); ?></a></li>
					<li><a class="jarvis-icon-image" href="#jarvis-logo-icons"><?php echo JText::_('JARVIS_TAB_LOGO_ICONS'); ?></a></li>
					<li><a class="jarvis-icon-style" href="#jarvis-styles"><?php echo JText::_('JARVIS_TAB_STYLES'); ?></a></li>
					<li><a class="jarvis-icon-layout" href="#jarvis-layout"><?php echo JText::_('JARVIS_TAB_LAYOUT'); ?></a></li>
					<li><a class="jarvis-icon-gear" href="#jarvis-advanced"><?php echo JText::_('JARVIS_TAB_ADVANCED'); ?></a></li>
					<li class="jarvis-space-top"><a class="jarvis-icon-menu" href="#jarvis-menu-assignment"><?php echo JText::_('JARVIS_TAB_MENU_ASSIGMENT'); ?></a></li>
				</ul>
			</div>
			<div class="jarvis-tabs-pages">
				<div class="jarvis-tab-page" id="jarvis-overview">
					<?php include __DIR__ . '/admin-overview.php' ?>
				</div>
				<div class="jarvis-tab-page" id="jarvis-logo-icons">
					<?php include __DIR__ . '/admin-logo.php' ?>
				</div>
				<div class="jarvis-tab-page" id="jarvis-styles">
					<?php include __DIR__ . '/admin-styles.php' ?>
				</div>
				<div class="jarvis-tab-page" id="jarvis-layout">
					<?php include __DIR__ . '/admin-layout.php' ?>
				</div>
				<div class="jarvis-tab-page" id="jarvis-advanced">
					<?php include __DIR__ . '/admin-advanced.php' ?>
				</div>
				<div class="jarvis-tab-page" id="jarvis-menu-assignment">
					<?php include __DIR__ . '/admin-menu.php' ?>
				</div>
			</div>
		</div>
	</div>
</form>

<div id="jarvis-restore-settings" class="jarvis-dialog">
	<form method="post" action="index.php?action=jarvis.restore&style=<?php echo Jarvis\Jarvis::get('joomla.styleId') ?>" enctype="multipart/form-data" target="jarvis-restore-frame">
		<div class="jarvis-section">
			<div class="jarvis-button jarvis-button-blue">
				<input type="file" name="options-file" />
				<span><?php echo JText::_('JARVIS_BUTTON_SELECT_OPTIONS_FILE'); ?></span>
			</div>
		</div>
	</form>
	<iframe id="jarvis-restore-frame" name="jarvis-restore-frame" src="about:blank"></iframe>
</div>