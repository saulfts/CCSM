<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: FontList.php 14 2014-07-17 04:49:10Z linhnt $
 */
defined('_JEXEC') or die('Access denied!');

/**
 * 
 * @package     Jarvis
 */
class JFormFieldFontList extends JFormField
{
	protected $type = 'FontList';

	public function getInput() {
		$fonts = Jarvis\Jarvis::get('jarvis.webfonts');
		$options = array();
		$options['System Fonts'] = array(
			JHtml::_('select.option', 'arial', 'Arial, Helvetica, sans-serif'),
			JHtml::_('select.option', 'arial-black', '"Arial Black", Gadget, sans-serif'),
			JHtml::_('select.option', 'comic-sans', '"Comic Sans MS", cursive, sans-serif'),
			JHtml::_('select.option', 'impact', 'Impact, Charcoal, sans-serif'),
			JHtml::_('select.option', 'lucida-sans', '"Lucida Sans Unicode", "Lucida Grande", sans-serif'),
			JHtml::_('select.option', 'tahoma', 'Tahoma, Geneva, sans-serif'),
			JHtml::_('select.option', 'trebuchet-ms', '"Trebuchet MS", Helvetica, sans-serif'),
			JHtml::_('select.option', 'verdana', 'Verdana, Geneva, sans-serif'),
			JHtml::_('select.option', 'courier-new', '"Courier New", Courier, monospace'),
			JHtml::_('select.option', 'lucida-console', '"Lucida Console", Monaco, monospace')
		);

		$options['Goggle Fonts'] = array();
		foreach ($fonts as $value => $font) {
			$options['Goggle Fonts'][] = JHtml::_('select.option', $value, $font['family']);
		}

		// Initialize some field attributes.
		$attr  = !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$attr .= $this->disabled ? ' disabled' : '';
		$attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$attr .= $this->multiple ? ' multiple' : '';
		$attr .= $this->required ? ' required aria-required="true"' : '';
		$attr .= $this->autofocus ? ' autofocus' : '';

		return JHtml::_(
			'select.groupedlist', $options, $this->name, array(
				'list.attr' => $attr, 'id' => $this->id, 'list.select' => $this->value, 'group.items' => null, 'option.key.toHtml' => false,
				'option.text.toHtml' => false
			)
		);
	}
}
