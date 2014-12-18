<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: ColorPicker.php 14 2014-07-17 04:49:10Z linhnt $
 */
defined('_JEXEC') or die('Access denied!');

// Load base class
require_once __DIR__ . '/CheckboxList.php';

/**
 * 
 * @package     Jarvis
 */
class JFormFieldColorPicker extends JFormField
{
	protected $type = 'ColorPicker';

	public function getInput() {
		$name  = (string) $this->name;
		$value = (string) $this->value;
		$class = !empty($option->class) ? ' class="' . $option->class . '"' : '';
		$disabled = !empty($option->disable) ? ' disabled' : '';
		$readonly = !empty($option->readonly) ? ' readonly' : '';

		if (!$this->isColor($value))
			$value = '#000000';

		return "
			<div class=\"jarvis-color-picker\">
				<button type=\"button\" class=\"jarvis-button\" style=\"background: {$value}\"></button>
				<input type=\"text\" name=\"{$name}\" value=\"{$value}\" {$disabled} {$readonly} />
			</div>
		";
	}

	private function isColor($color) {
		$named = array(
			'aliceblue', 'antiquewhite', 'aqua', 'aquamarine', 'azure', 'beige',
			'bisque', 'black', 'blanchedalmond', 'blue', 'blueviolet', 'brown',
			'burlywood', 'cadetblue', 'chartreuse', 'chocolate', 'coral', 'cornflowerblue',
			'cornsilk', 'crimson', 'cyan', 'darkblue', 'darkcyan', 'darkgoldenrod',
			'darkgray', 'darkgreen', 'darkkhaki', 'darkmagenta', 'darkolivegreen',
			'darkorange', 'darkorchid', 'darkred', 'darksalmon', 'darkseagreen',
			'darkslateblue', 'darkslategray', 'darkturquoise', 'darkviolet', 'deeppink',
			'deepskyblue', 'dimgray', 'dodgerblue', 'firebrick', 'floralwhite', 'forestgreen',
			'fuchsia', 'gainsboro', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green',
			'greenyellow', 'honeydew', 'hotpink', 'indianred', 'indigo', 'ivory', 'khaki',
			'lavender', 'lavenderblush', 'lawngreen', 'lemonchiffon', 'lightblue', 'lightcoral',
			'lightcyan', 'lightgoldenrodyellow', 'lightgreen', 'lightgrey', 'lightpink',
			'lightsalmon', 'lightseagreen', 'lightskyblue', 'lightslategray', 'lightsteelblue',
			'lightyellow', 'lime', 'limegreen', 'linen', 'magenta', 'maroon', 'mediumaquamarine',
			'mediumblue', 'mediumorchid', 'mediumpurple', 'mediumseagreen', 'mediumslateblue',
			'mediumspringgreen', 'mediumturquoise', 'mediumvioletred', 'midnightblue', 'mintcream',
			'mistyrose', 'moccasin', 'navajowhite', 'navy', 'oldlace', 'olive', 'olivedrab', 'orange',
			'orangered', 'orchid', 'palegoldenrod', 'palegreen', 'paleturquoise', 'palevioletred',
			'papayawhip', 'peachpuff', 'peru', 'pink', 'plum', 'powderblue', 'purple', 'red',
			'rosybrown', 'royalblue', 'saddlebrown', 'salmon', 'sandybrown', 'seagreen', 'seashell',
			'sienna', 'silver', 'skyblue', 'slateblue', 'slategray', 'snow', 'springgreen', 'steelblue',
			'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'wheat', 'white', 'whitesmoke',
			'yellow', 'yellowgreen'
		);
		
		return in_array(strtolower($color), $named) || preg_match('/^#[a-f0-9]{6}$/i', $color);
	}
}
