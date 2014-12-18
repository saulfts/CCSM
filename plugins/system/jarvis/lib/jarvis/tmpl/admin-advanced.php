<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-advanced.php 14 2014-07-17 04:49:10Z linhnt $
 */
?>
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_ADVANCED_OPTIONS'); ?></h3>
		<p><?php echo JText::_('JARVIS_ADVANCED_OPTIONS_DESC'); ?></p>
	</div>

	<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_HOME_COMPONENT'); ?></div>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-buttonset">
			<?php echo $jarvisForm->getInput('componentOnFrontpage', 'jarvis') ?>
		</div>
	</div>
</div>

<div class="jarvis-section">
	<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_STYLE_SWITCHER'); ?></div>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-buttonset">
			<?php echo $jarvisForm->getInput('styleSwitcher', 'jarvis') ?>
		</div>
	</div>
</div>

<div class="jarvis-section">
	<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_GA_CODE'); ?></div>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-code-editor jarvis-code-small" data-language="javascript">
			<?php echo $jarvisForm->getInput('scriptAnalytics', 'jarvis') ?>
		</div>
		<div class="jarvis-field jarvis-buttonset">
			<?php echo $jarvisForm->getInput('analyticsPosition', 'jarvis') ?>
		</div>
	</div>
</div>

<div class="jarvis-section">
	<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_CUSTOM_JS_CODE'); ?></div>
	<div class="jarvis-fields">
		<div class="jarvis-fields jarvis-tabs jarvis-tabs-top jarvis-tabs-large">
			<div class="jarvis-tabs-nav">
				<ul>
					<li><a href="#script-before-head"><?php echo JText::_('JARVIS_OPTION_BEFORE_HEAD_END'); ?></a></li>
					<li><a href="#script-before-body"><?php echo JText::_('JARVIS_OPTION_BEFORE_BODY_END'); ?></a></li>
				</ul>
			</div>
			<div class="jarvis-tabs-pages">
				<div id="script-before-head" class="jarvis-tab-page">
					<div class="jarvis-code-editor jarvis-code-fluid" data-language="javascript">
						<?php echo $jarvisForm->getInput('customScriptHead', 'jarvis') ?>
					</div>
				</div>
				<div id="script-before-body" class="jarvis-tab-page">
					<div class="jarvis-code-editor jarvis-code-fluid" data-language="javascript">
						<?php echo $jarvisForm->getInput('customScriptBody', 'jarvis') ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Performances -->
<!--
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php //echo JText::_('JARVIS_HEADING_PERFORMANCE'); ?></h3>
		<p><?php //echo JText::_('JARVIS_ADVANCED_PERFORMANCE_DESC'); ?></p>
	</div>
    
	<div class="jarvis-label"><?php //echo JText::_('JARVIS_LABEL_LAYOUT_CACHE'); ?></div>
	<div class="jarvis-fields">
        <div class="jarvis-fieldset jarvis-fields-inline">
            <div class="jarvis-field jarvis-buttonset">
                <?php //echo $jarvisForm->getInput('layoutCache', 'jarvis') ?>
            </div>
            <div class="jarvis-field jarvis-input-group jarvis-input-tiny">
                <?php //echo $jarvisForm->getField('layoutCacheTime', 'jarvis')->input ?>
                <span class="jarvis-input-suffix"><?php //echo JText::_('JARVIS_OPTION_MINUTES_DESC'); ?></span>
                <div class="jarvis-input-desc"><?php //echo JText::_('JARVIS_OPTION_CACHE_TIME_DESC'); ?></div>
            </div>
        </div>
	</div>
    <div class="jarvis-fields jarvis-message alert alert-info"><i class="icon-info"></i> <?php //echo JText::_('JARVIS_MESSAGE_CLEAR_CACHE'); ?></div>
</div>

<div class="jarvis-section">
    <div class="jarvis-section-header">
		<h3><?php //echo JText::_('JARVIS_HEADING_PERFORMANCE'); ?></h3>
	</div>
    <div class="jarvis-label"><?php //echo JText::_('JARVIS_LABEL_COMPRESS_CSS'); ?></div>
    <div class="jarvis-fields">
        <div class="jarvis-field jarvis-buttonset">
            <?php //echo $jarvisForm->getInput('mergeCss', 'jarvis') ?>
        </div>
    </div>
    
    <div class="jarvis-label"><?php //echo JText::_('JARVIS_LABEL_COMPRESS_JS'); ?></div>
    <div class="jarvis-fields">
        <div class="jarvis-field jarvis-buttonset">
            <?php //echo $jarvisForm->getInput('mergeJs', 'jarvis') ?>
        </div>
    </div>
</div>
-->

<!-- Maintance -->
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_MAINTAIN'); ?></h3>
		<p><?php echo JText::_('JARVIS_ADVANCED_MAINTAIN_DESC'); ?></p>
	</div>

	<div class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_MAINTAIN'); ?></div>
	<div class="jarvis-fields">
		<div class="jarvis-field">
			<a href="index.php?action=jarvis.backup&style=<?php echo Jarvis\Jarvis::get('joomla.styleId'); ?>"
				class="jarvis-button jarvis-button-blue" data-command="backup"><?php echo JText::_('JARVIS_BUTTON_BACKUP'); ?></a>
			<a href="javascript:void(0)" class="jarvis-button jarvis-button-blue" data-command="restore"><?php echo JText::_('JARVIS_BUTTON_RESTORE'); ?></a>
		</div>
	</div>
</div>