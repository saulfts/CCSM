<?php
/**
*	@version	$Id: mod_omgmenu.php 57 2013-04-26 07:59:43Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	mod_omgmenu
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/
// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';
require_once dirname(__FILE__) . '/module_helper.php';

$list		= modOTmegaMenuHelper::getList($params);
$base		= modOTmegaMenuHelper::getBase($params);
$active		= modOTmegaMenuHelper::getActive($params);
$active_id 	= $active->id;
$path		= $base->tree;

$showAll	= $params->get('showAllChildren');
$class_sfx	= htmlspecialchars($params->get('class_sfx'));

$document = JFactory::getDocument();
$document->addScript(JURI::root().'modules/mod_omgmenu/js/omgmenu.jq.js');
$document->addStyleSheet(JURI::root().'modules/mod_omgmenu/css/omgmenu.css');
$document->addStyleSheet(JURI::root().'modules/mod_omgmenu/css/omgmenu_mobile.css');

$customCss = '
	.ot-menu a {
		'.( intval($params->get('customColor_on', 0)) == 1 && trim($params->get('text_color','')) != '' ? 'color: '.trim($params->get('text_color')).';' : ''). '
		'.( intval($params->get('customFontSize_on', 0)) == 1 && trim($params->get('font_size','')) != '' ? 'font-size: '.trim($params->get('font_size')).';' : ''). '
	}
	.ot-menu a:hover {
		'.( intval($params->get('customColor_on', 0)) == 1 && trim($params->get('text_color_hover','')) != '' ? 'color: '.trim($params->get('text_color_hover')).';' : ''). '
	}
';

if (intval($params->get('customFont_on', 0)) == 1){
	$customFontFamily = trim($params->get('font_family',''));
	$customFont = explode(':', $customFontFamily);

	if (isset($customFont[0]) && isset($customFont[1])){	
		if ($customFont[0] == 'w'){
			// $document->addStyleSheet('http://fonts.googleapis.com/css?family=' . $customFont[1]);
			$document->addStyleSheet('http://fonts.googleapis.com/css?family=' . str_replace('w:', '', $customFontFamily));
		}
		$font = str_replace('+', ' ', trim($customFont[1]));
		$customCss .= '
			.ot-menu a {
				font-family: '.$font.';
			}
		';
	}
}
$document->addStyleDeclaration($customCss);


if (count($list))
{
	require JModuleHelper::getLayoutPath('mod_omgmenu', $params->get('layout', 'default'));
	require JModuleHelper::getLayoutPath('mod_omgmenu', $params->get('layout', 'default').'_mobile');
}
