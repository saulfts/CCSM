<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JForm::addFieldPath(JPATH_ROOT . '/' . 'templates/'.JFactory::getApplication()->getTemplate().'/html/layouts/libraries/joomla/form/fields');
JForm::addRulePath(JPATH_ROOT . '/' . 'templates/'.JFactory::getApplication()->getTemplate().'/html/layouts/libraries/joomla/form/fields');

$app = JFactory::getApplication();
$form = $displayData->getForm();

$name = $displayData->get('fieldset');
$fieldSet = $form->getFieldset($name);

if (empty($fieldSet))
{
	return;
}

$ignoreFields = $displayData->get('ignore_fields') ? : array();
$extraFields = $displayData->get('extra_fields') ? : array();

if ($displayData->get('show_options', 1))
{
	if (isset($extraFields[$name]))
	{
		foreach ($extraFields[$name] as $f)
		{
			if (in_array($f, $ignoreFields))
			{
				continue;
			}
			if ($form->getField($f))
			{
				$fieldSet[] = $form->getField($f);
			}
		}
	}

	$html = array();

	foreach ($fieldSet as $field)
	{
		$html[] = $field->renderField();
	}

	echo implode('', $html);
}
else
{
	$html = array();
	$html[] = '<div style="display:none;">';
	foreach ($fieldSet as $field)
	{
		$html[] = $field->input;
	}
	$html[] = '</div>';

	echo implode('', $html);
}