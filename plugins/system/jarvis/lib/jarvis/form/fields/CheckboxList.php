<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: CheckboxList.php 39 2014-09-12 02:26:45Z linhnt $
 */
defined('_JEXEC') or die('Access denied!');

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('checkboxes');

/**
 * 
 * @package     Jarvis
 */
class JFormFieldCheckboxList extends JFormFieldCheckboxes
{
	protected $type = 'CheckboxList';

	public function getInput() {
		$html = array();

		// Initialize some field attributes.
		$class     = !empty($this->class) ? ' class="checkbox-list ' . $this->class . '"' : ' class="checkbox-list"';
		$required  = $this->required ? ' required aria-required="true"' : '';
		$autofocus = $this->autofocus ? ' autofocus' : '';
		$disabled  = $this->disabled ? ' disabled' : '';
		$readonly  = $this->readonly;

		// Start the radio field output.
		$html[] = '<fieldset id="' . $this->id . '"' . $class . $required . $autofocus . $disabled . ' >';

		// Get the field options.
		$options = $this->getOptions();
		$values  = (array)$this->value;
    
		// Build the radio field output.
		foreach ($options as $i => $option)
		{
			$value = (string) $option->value;

			// Initialize some option attributes.
			$checked = (in_array($value, $values)) ? ' checked="checked"' : '';
			$class = !empty($option->class) ? ' class="' . $option->class . '"' : '';

			$disabled = !empty($option->disable) || ($readonly && !$checked);

			$disabled = $disabled ? ' disabled' : '';

			// Initialize some JavaScript option attributes.
			$onclick = !empty($option->onclick) ? ' onclick="' . $option->onclick . '"' : '';
			$onchange = !empty($option->onchange) ? ' onchange="' . $option->onchange . '"' : '';

			$html[] = '<input type="checkbox" id="' . $this->id . $i . '" name="' . $this->name . '" value="'
				. htmlspecialchars($option->value, ENT_COMPAT, 'UTF-8') . '"' . $checked . $class . $required . $onclick
				. $onchange . $disabled . ' />';

			$html[] = '<label for="' . $this->id . $i . '"' . $class . ' >'
				. JText::alt($option->text, preg_replace('/[^a-zA-Z0-9_\-]/', '_', $this->fieldname)) . '</label>';

			$required = '';
		}

		// End the radio field output.
		$html[] = '</fieldset>';

		return implode($html);
	}
}
