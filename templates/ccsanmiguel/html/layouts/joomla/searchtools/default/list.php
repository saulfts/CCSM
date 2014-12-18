<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JForm::addFieldPath(JPATH_ROOT . '/' . 'templates/'.JFactory::getApplication()->getTemplate().'/html/layouts/libraries/joomla/form/fields');
JForm::addRulePath(JPATH_ROOT . '/' . 'templates/'.JFactory::getApplication()->getTemplate().'/html/layouts/libraries/joomla/form/fields');

$data = $displayData;

// Load the form list fields
$list = $data['view']->filterForm->getGroup('list');
?>
<?php if ($list) : ?>
	<div class="ordering-select hidden-phone hidden-xs">
		<?php foreach ($list as $fieldName => $field) : ?>
			<div class="js-stools-field-list">
				<?php echo $field->input; ?>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
