<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C)2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Access denied!');

/**
 * 
 * @package     Jarvis
 * @subpackage  Override
 */
class JView extends JViewBase {
	public function __construct($config = array()) {
		parent::__construct($config);

		$component = JApplicationHelper::getComponentName();
		$app       = JFactory::getApplication();
		$path      = JARVIS_ROOT . '/lib/override/html/' . $component . '/' . $this->getName();

		array_unshift($this->_path['template'], $path);
	}
}
