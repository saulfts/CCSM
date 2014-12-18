<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: PresetList.php 14 2014-07-17 04:49:10Z linhnt $
 */
defined('_JEXEC') or die('Access denied!');

/**
 * 
 * @package     Jarvis
 */
class JFormFieldPresetList extends JFormField
{
	protected $type = 'PresetList';

	public function getInput() {
		$name = (string) $this->name;
		$value = (string) $this->value;

		$options = \Jarvis\Template\Helper::getSchemes(Jarvis\Jarvis::get('joomla.template'));
		$html    = array();

		foreach ($options as $index => $option) {
			$checked = $index == $value ? 'checked="checked"' : '';
			$html[] = "
				<input type=\"radio\" name=\"{$name}\" value=\"{$index}\" id=\"{$this->id}_{$index}\" {$checked} />
				<label for=\"{$this->id}_{$index}\" style=\"background: {$option['color']}\"></label>
			";
		}

		return "
			<div class=\"jarvis-image-options\">" . implode('', $html) . "</div>
		";
	}
}
