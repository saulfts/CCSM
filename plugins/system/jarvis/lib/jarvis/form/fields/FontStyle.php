<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: FontStyle.php 14 2014-07-17 04:49:10Z linhnt $
 */
defined('_JEXEC') or die('Access denied!');

// Load base class
require_once __DIR__ . '/CheckboxList.php';

/**
 * 
 * @package     Jarvis
 */
class JFormFieldFontStyle extends JFormFieldCheckboxList
{
	protected $type = 'FontStyle';
	protected function getOptions() {
		return array(
			JHtml::_('select.option', 'bold', 'B', 'value', 'text'),
			JHtml::_('select.option', 'underline', 'U', 'value', 'text'),
			JHtml::_('select.option', 'italic', 'I', 'value', 'text'),
			JHtml::_('select.option', 'strikethrough', 'S', 'value', 'text')
		);
	}
}
