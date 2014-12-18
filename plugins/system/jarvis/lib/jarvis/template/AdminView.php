<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: AdminView.php 14 2014-07-17 04:49:10Z linhnt $
 */
 
namespace Jarvis\Template;

defined('_JEXEC') or die('Access denied!');

class AdminView
{
	public function bodyAttributes($matches) {
		$attributes = trim($matches[1]);
		$joomlaVersion = substr(JARVIS_JVERSION, 0, 1);

		return "<body {$attributes} data-joomla-{$joomlaVersion}>";
	}

	public function componentForm() {
		$joomlaUser = \JFactory::getUser();
		$joomlaForm = \Jarvis\Jarvis::get('joomla.form');

		$jarvisForm = \Jarvis\Jarvis::get('jarvis.form');
		// $jarvisForm->addFieldPath(JARVIS_ROOT . '/lib/jarvis/form/fields');

		$template = \Jarvis\Jarvis::get('joomla.template');
		$templateManifest = \Jarvis\Jarvis::get('joomla.templateManifest');

		$styleId = \JFactory::getApplication()->input->getInt('id');

		if (!class_exists('MenusHelper')) {
			require_once JPATH_ADMINISTRATOR.'/components/com_menus/helpers/menus.php';
		}

		ob_start();
		include JARVIS_ROOT . '/lib/jarvis/tmpl/admin.php';
		return ob_get_clean();
	}
}
