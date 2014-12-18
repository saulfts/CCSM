<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-layout.php 27 2014-07-22 09:40:05Z linhnt $
 */
?>
<!-- Layout Style -->
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_DISPLAYING_OPTIONS'); ?></h3>
		<p><?php echo JText::_('JARVIS_DISPLAYING_OPTIONS_DESC'); ?></p>
	</div>
    
	<label class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_LAYOUT_MODE'); ?></label>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-buttonset" id="jarvis-field-layout-mode">
			<?php echo $jarvisForm->getInput('layoutStyle', 'jarvis') ?>
		</div>

		<div class="jarvis-fieldset-group jarvis-fieldset-inline" data-depend="layoutStyle" data-depend-eq="boxed" data-depend-neq="full-width">
			<fieldset class="jarvis-fieldset">
				<legend><?php echo JText::_('JARVIS_LABEL_CONTENT_WIDTH'); ?></legend>

				<div class="jarvis-fields-inline">
					<div class="jarvis-field jarvis-input-tiny">
						<?php echo $jarvisForm->getInput('layoutWidth', 'jarvis') ?>
					</div>
					<div class="jarvis-field jarvis-buttonset">
						<?php echo $jarvisForm->getInput('layoutWidthUnit', 'jarvis') ?>
					</div>
				</div>
			</fieldset>

			<fieldset class="jarvis-fieldset">
				<legend><?php echo JText::_('JARVIS_LABEL_BOXED_MARGIN'); ?></legend>

				<div class="jarvis-fields-inline">
					<div class="jarvis-field jarvis-input-tiny">
						<?php echo $jarvisForm->getInput('boxedMarginTop', 'jarvis') ?>
						<div class="jarvis-input-desc">Top</div>
					</div>
					<div class="jarvis-field jarvis-input-tiny">
						<?php echo $jarvisForm->getInput('boxedMarginBottom', 'jarvis') ?>
						<div class="jarvis-input-desc">Bottom</div>
					</div>
				</div>
			</fieldset>
		</div>
        
        <div class="jarvis-fieldset-group" data-depend="layoutStyle" data-depend-eq="boxed" data-depend-neq="full-width">
        <fieldset class="jarvis-fieldset">
            <legend><?php echo JText::_('JARVIS_LABEL_BACKGROUND_IMAGE'); ?></legend>
            <div class="jarvis-field">
                <div class="jarvis-field-media jarvis-input-medium">
                    <div class="jarvis-input-group">
                        <?php echo $jarvisForm->getField('backgroundImage', 'jarvis')->input ?>
                        <a href="index.php?option=com_media&view=images&tmpl=component&fieldid=jarvis_backgroundImage"
                            class="jarvis-button jarvis-input-suffix modal" rel="{handler: 'iframe', size: {x: 800, y: 500}}">...</a>
                    </div>
                    <button type="button" class="jarvis-button jarvis-button-red" data-command="clear"><?php echo JText::_('JARVIS_BUTTON_CLEAR'); ?></button>
                </div>
			</div>
		</fieldset>
        
        <fieldset class="jarvis-fieldset">
            <legend><?php echo JText::_('JARVIS_LABEL_BOXED_BACKGROUND'); ?></legend>
            <div class="jarvis-field">
                <?php echo $jarvisForm->getInput('boxedBackground', 'jarvis') ?>
            </div>
        </fieldset>
        </div>
	</div>
</div>

<!-- Responsive Options -->
<div class="jarvis-section" data-require-edition="pro">
	<label class="jarvis-label"><?php echo JText::_('JARVIS_LABEL_ENABLE_RESPONSIVE'); ?></label>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-buttonset">
			<?php echo $jarvisForm->getInput('enableResponsive', 'jarvis') ?>
		</div>
	</div>
<?php /*
	<label class="jarvis-label">Enable Off-Canvas Position</label>
	<div class="jarvis-fields">
		<div class="jarvis-field jarvis-buttonset">
			<?php echo $jarvisForm->getInput('enableOffCanvas', 'jarvis') ?>
		</div>
	</div> */?>
</div>

<!-- Layout Builder -->
<div class="jarvis-section jarvis-section-empty">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_LAYOUT_OPTIONS'); ?></h3>
		<p><?php echo JText::_('JARVIS_LAYOUT_OPTIONS_DESC'); ?></p>
	</div>
</div>

<div class="jarvis-layout-builder">
	<div class="jarvis-layout-toolbar jarvis-buttonset">
		<fieldset>
			<input type="radio" name="screen-size" id="screen-size-large" value="large" checked="checked" /><!-- 
			 --><label for="screen-size-large"><?php echo JText::_('JARVIS_OPTION_LARGE'); ?></label><!-- 

			 --><input type="radio" name="screen-size" id="screen-size-medium" value="medium" /><!-- 
			 --><label for="screen-size-medium"><?php echo JText::_('JARVIS_OPTION_MEDIUM'); ?></label><!-- 

			 --><input type="radio" name="screen-size" id="screen-size-small" value="small" /><!-- 
			 --><label for="screen-size-small"><?php echo JText::_('JARVIS_OPTION_SMALL'); ?></label><!-- 

			 --><input type="radio" name="screen-size" id="screen-size-xsmall" value="xsmall" /><!-- 
			 --><label for="screen-size-xsmall"><?php echo JText::_('JARVIS_OPTION_XSMALL'); ?></label>
		</fieldset>
	</div>
	<div class="jarvis-layout-container">
	</div>
</div>

<?php echo $jarvisForm->getInput('layoutConfig', 'jarvis') ?>
<?php echo $jarvisForm->getInput('layoutHash', 'jarvis') ?>
