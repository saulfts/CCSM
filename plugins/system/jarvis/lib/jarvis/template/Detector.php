<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: Detector.php 14 2014-07-17 04:49:10Z linhnt $
 */
 
namespace Jarvis\Template;

defined('_JEXEC') or die('Access denied!');

/**
 * This class will be use to detect a template is supported
 * by Jarvis framework
 * 
 * 
 * @package     Jarvis
 */
class Detector
{
	public static function isSupported($template) {
		$manifestCache = Helper::getManifestCache($template);
		return isset($manifestCache->group) && $manifestCache->group == 'jarvis';
	}

	public static function isEditMode() {
		$app = \Jarvis\Jarvis::get('joomla.app');

		// Get requested component, view and task
		$option	= $app->input->getCmd('option');
		$view		= $app->input->getCmd('view');
		$layout = $app->input->getCmd('layout');

		return (
			'com_templates' == $option &&
			'style' == $view &&
			'edit' == $layout
		);
	}
}
