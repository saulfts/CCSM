<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: Background.php 14 2014-07-17 04:49:10Z linhnt $
 */
defined('_JEXEC') or die('Access denied!');


class JFormFieldBackground extends JFormField
{
	protected $type = 'Background';

	public function getInput() {
		$patterns = \Jarvis\Jarvis::get('jarvis.patterns');
		$markup = array();
		$url = \JURI::root(true) . '/templates/' . \Jarvis\Jarvis::get('joomla.template') . '/assets/images/patterns';

		foreach($patterns as $id => $file) {
			$markup[] = sprintf('<input type="radio" name="%s" value="%s" id="%s" %s>', $this->name, $file, $this->name . '_' . $id, $file == $this->value ? 'checked="checked"' : '');
			$markup[] = sprintf('<label for="%s" style="background-image: url(%s);">&nbsp;</label>', $this->name . '_' . $id, "{$url}/{$file}");
		}

		$markup[] = sprintf('<input type="radio" name="%s" value="%s" id="%s" %s>', $this->name, 'none', $this->name . '_none', 'none' == $this->value ? 'checked="checked"' : '');
		$markup[] = sprintf('<label for="%s" title="None">&nbsp;</label>', $this->name . '_none', "{$url}/{$file}");

		return sprintf('<div class="jarvis-patterns-bg">%s</div>', implode('', $markup));
	}
}
