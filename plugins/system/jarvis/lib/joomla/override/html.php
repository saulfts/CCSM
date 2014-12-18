<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C)2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Access denied!');

/**
 * This class will be override original class of Joomla to provide
 * more utility methods
 *
 * 
 * @package     Jarvis
 * @subpackage  Override
 */
class JDocumentHTML extends JDocumentBaseHTML {
	public function getOption($name, $default = '') {
		
	}

	public function hasPositions() {
		$positions = func_get_args();
		$hasPositions = false;

		foreach($positions as $position) {
			if ($this->countModules($position)) {
				$hasPositions = true;
				break;
			}
		}

		return $hasPositions;
	}
}