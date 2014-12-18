<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: LayoutList.php 14 2014-07-17 04:49:10Z linhnt $
 */
defined('_JEXEC') or die('Access denied!');

/**
 * 
 * @package     Jarvis
 */
class JFormFieldLayoutList extends JFormField
{
	protected $type = 'LayoutList';

	public function getInput() {
		$options = array();

		// foreach ($fonts as $value => $font) {
		// 	$options[] = JHtml::_('select.option', $value, $font['family']);
		// }

		return JHtml::_('select.genericList', $options, $this->name, '', 'value', 'text', $this->value, $this->id);
	}
}
