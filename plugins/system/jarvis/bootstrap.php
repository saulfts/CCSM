<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: bootstrap.php 14 2014-07-17 04:49:10Z linhnt $
 */
 
defined('_JEXEC') or die('Access denied!');

$version = new JVersion();

define('JARVIS_ROOT', __DIR__);
define('JARVIS_VERSION', '@jarvis.version');
define('JARVIS_JVERSION', $version->getShortVersion());

if (version_compare(JARVIS_JVERSION, '3.0', '>=')) {
	require_once JARVIS_ROOT . '/lib/joomla/document/html3.php';
	require_once JARVIS_ROOT . '/lib/joomla/view/viewlegacy.php';
	require_once JARVIS_ROOT . '/lib/joomla/override/viewlegacy.php';
}
elseif (version_compare(JARVIS_JVERSION, '2.0', '>=')) {
	require_once JARVIS_ROOT . '/lib/joomla/document/html2.php';
	require_once JARVIS_ROOT . '/lib/joomla/view/view.php';
	require_once JARVIS_ROOT . '/lib/joomla/override/view.php';
}

// Override Joomla JDocumentHTML
JLoader::register('JDocumentHTML', JARVIS_ROOT . '/lib/joomla/override/html.php');
JLoader::discover('JFormField', JARVIS_ROOT . '/lib/jarvis/form/fields');

if (JFactory::getApplication()->isSite()) {
	JLoader::register('JHtmlBootstrap', JARVIS_ROOT . '/lib/joomla/override/html/bootstrap.php');
}

// Load Jarvis
require_once JARVIS_ROOT . '/lib/jarvis/Jarvis.php';
require_once JARVIS_ROOT . '/lib/jarvis/template/Detector.php';
require_once JARVIS_ROOT . '/lib/jarvis/template/AdminView.php';
require_once JARVIS_ROOT . '/lib/jarvis/template/Helper.php';
require_once JARVIS_ROOT . '/lib/jarvis/template/Builder.php';

require_once JARVIS_ROOT . '/lib/jarvis/template/LayoutRow.php';
require_once JARVIS_ROOT . '/lib/jarvis/template/LayoutSection.php';
require_once JARVIS_ROOT . '/lib/jarvis/template/LayoutColumn.php';

require_once JARVIS_ROOT . '/lib/jarvis/form/Form.php';
