<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
// JHtml::_('behavior.tooltip');
JHtml::_('bootstrap.tooltip', '.hasTip');
JHtml::_('behavior.formvalidation');

JForm::addFieldPath(JPATH_ROOT . '/' . 'templates/'.JFactory::getApplication()->getTemplate().'/html/layouts/libraries/joomla/form/fields');
JForm::addRulePath(JPATH_ROOT . '/' . 'templates/'.JFactory::getApplication()->getTemplate().'/html/layouts/libraries/joomla/form/fields');
?>
<div class="remind <?php echo $this->pageclass_sfx?>">
<div class="page-content">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<div class="page-header">
		<h1>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
		</h1>
	</div>
	<?php endif; ?>

	<form id="user-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=remind.remind'); ?>" method="post" class="form-validate form-horizontal">

		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
		<p><?php echo JText::_($fieldset->label); ?></p>

		<fieldset>
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
				<div class="control-group form-group">
					<div class="control-label col-sm-3">
						<?php echo $field->label; ?>
					</div>
					<div class="controls col-sm-9">
						<?php echo $field->input; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</fieldset>
		<?php endforeach; ?>
		<div class="form-actions form-group">
			<div class="controls col-sm-9 col-sm-offset-3">
				<button type="submit" class="btn btn-primary validate"><?php echo JText::_('JSUBMIT'); ?></button>
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</div>
	</form>
</div>
</div>
