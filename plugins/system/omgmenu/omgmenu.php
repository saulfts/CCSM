<?php
/**
*	@version	$Id: omgmenu.php 61 2013-06-05 10:04:55Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	plug_omgmenu	plugin for OMG menu system (mod_omgmenu)
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/
 
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');
// jimport('joomla.html.parameter');

class plgSystemOMGMenu extends JPlugin
{    
	var $plugin;
	var $plgParams;
	var $plgPath;
	var $time = 0;
    
    function __construct(&$subject, $config)
	{      
        parent::__construct($subject, $config);
		$this->plugin = JPluginHelper::getPlugin( 'system', 'omgmenu' );
		// $this->plgParams = new JParameter( $this->plugin->params );
		if(!defined("DS")){
			define("DS", DIRECTORY_SEPARATOR);
		}
		$this->plgPath = JPATH_PLUGINS . DS . "system" . DS . "omgmenu" . DS . 'params' . DS;
		$language = JFactory::getLanguage();
		$language->load('plg_system_omgmenu');
    }
    
    function onContentPrepareForm($form, $data)
    {           
        if($form->getName() == 'com_menus.item')
		{ 
            // $xmlFile = dirname(__FILE__). DS."omgmenu" . DS . 'params';
            // JForm::addFormPath($xmlFile);
			JForm::addFormPath($this->plgPath);
            $form->loadFile('params', false); 
        }
    }
}