<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: StyleEditor.php 14 2014-07-17 04:49:10Z linhnt $
 */
defined('_JEXEC') or die('Access denied!');

/**
 * 
 * @package     Jarvis
 */
class JFormFieldStyleEditor extends JFormField
{
	protected $type = 'StyleEditor';

	public function getInput() {
		$items = array();

		if (!empty($this->value) && is_array($this->value)) {
			foreach($this->value as $options) {
				$itemOptions = json_decode($options, true);
				$itemValue = htmlentities($options);

				$items[] = "
					<div class=\"jarvis-editor-item\">
						<div class=\"jarvis-editor-header\">
							<h3>{$itemOptions['style-name']}</h3>
							<ul class=\"jarvis-toolbox\">
								<li><a href=\"#\" data-command=\"edit\" class=\"jarvis-icon jarvis-icon-edit\"></a></li>
								<li><a href=\"#\" data-command=\"dupplicate\" class=\"jarvis-icon jarvis-icon-copy\"></a></li>
								<li><a href=\"#\" data-command=\"remove\" class=\"jarvis-icon jarvis-icon-remove\"></a></li>
							</ul>
						</div>
						<input type=\"hidden\" name=\"{$this->name}[]\" value=\"{$itemValue}\" />
					</div>
				";
			}
		}

		return "
			<div class=\"jarvis-style-editor\" id=\"{$this->id}\" data-input-name=\"{$this->name}[]\">" .
				implode('', $items) .
				"<a href=\"#add-style\" data-command=\"add\" class=\"jarvis-button\">".JText::_('JARVIS_BUTTON_ADD_STYLE')."</a>
			</div>
		";
	}
}
