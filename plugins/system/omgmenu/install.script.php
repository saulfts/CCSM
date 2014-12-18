<?php
/**
*	@version	$Id: install.script.php 9 2013-03-21 09:47:13Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	plg_omgmenu plugin for OMG menu system (mod_omgmenu)
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// no direct access 
if((int)JVERSION == 3){
	defined('JPATH_PLATFORM') or die;
}else{
	defined('_JEXEC') or die ('Restricted access');
}

class plgSystemOMGMenuInstallerScript{
 
    public function postflight($type, $parent){
		if(!JPluginHelper::getPlugin('system', 'omgmenu') && JFile::exists(JPATH_SITE.DIRECTORY_SEPARATOR.'plugins'.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'omgmenu'.DIRECTORY_SEPARATOR.'omgmenu.php')){
			$db = JFactory::getDBO();
			$query = "UPDATE #__extensions SET enabled='1' WHERE element='omgmenu'";
			$db->setQuery($query);
			$db->query();
		}
    }
}