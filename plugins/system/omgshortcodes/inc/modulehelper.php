<?php

/**
*	@version	$Id: helper.php 9 2013-03-21 09:47:13Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	mod_omgmenu
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/ 
 
/* no direct access*/
defined('_JEXEC') or die('Restricted access');

/**
 * Main Menu Tree Class.
 *
 * @package		Joomla
 * @subpackage	Menus
 * @since		1.5
 */
class OModuleHelper
{
	var $_type = "";
	public function __construct($type = "modules")
	{
		$this->_type = $type;
	}
	
	public function getContentByModule($modules = "", $modStyle, $colWidth='auto', $width=200, $title='')
	{

		$content = "";
		if(!empty($modules))
		{
			if(!is_array($modules)) $modules = explode("|", $modules);
			
			$modules 	= implode(",", $modules);
			$list 		= $this->_getModules($modules);
			$content 	= $this->_renderModule($list, $modStyle, $colWidth, $width, $title);
		}
		return $content;
	}
	
	public function getContentByPosition($position = "", $modStyle, $colWidth='auto', $width=200, $title='')
	{
		$content = "";
		if(!empty($position))
		{
			if(!is_array($position)) $position = explode("|", $position);
			
			$position 	= implode("','", $position);
			$position 	= "'".$position."'";
			$list 		= $this->_getModules("", $position);

			$content = $this->_renderModule($list, $modStyle, $colWidth, $width, $title);
		}
		return $content;
	}
	
	function _renderModule($list_modules = array(), $modStyle, $colWidth='auto', $width=400, $title='')
	{
		$content="";
		if(!empty($list_modules))
		{   
			$document	= &JFactory::getDocument();
			$renderer	= $document->loadRenderer('module'); 
			ob_start();     
            if(!empty($list_modules))
            {               
                echo '<div class="omg_cover_module" style="width:'.$width.'px">';
                    foreach($list_modules as $mod)
                    {
						
                        if(isset($mod))
                        {
                            // $style = "float:left;"; 
                            
                            if(isset($mod) && @$mod->id)
							{
								// echo '<div class="omg_modulewrap" style="'.$style.'">';
								echo '<div class="omg_modulewrap">';
								// if($mod->showtitle) {
									// echo '<span class="omg_moduletile">'.$mod->title.'</span>';
								// }if($mod->showtitle) {
									// echo '<span class="omg_moduletile">'.$mod->title.'</span>';
								// }
								echo $renderer->render($mod,array("style"=>$modStyle));
								echo '</div>';
                            }
                        }
			        }
                echo '</div>';
            }    
			$content = ob_get_clean();
			ob_start();
		}
		return $content;
	}
	/**
	 * Load published modules
	 *
	 * @access	private
	 * @return	array
	 */
	function _getModules($module_ids = null, $module_pos = "")
	{
		global $mainframe;

		$user	=& JFactory::getUser();
		$db		=& JFactory::getDBO();

		$aid	= $user->get('aid', 0);

		$modules	= array();

		$wheremenu = "";
		if(!empty($module_ids))
		{
			$wheremenu = " m.id in(".$module_ids.")";
		}
		if(!empty($module_pos))
		{
			$wheremenu = " m.position in(".$module_pos.")";
		}
		
        $query = 'SELECT distinct(m.id), title, module, position, content, showtitle, params'
            . ' FROM #__modules AS m'
            . ' LEFT JOIN #__modules_menu AS mm ON mm.moduleid = m.id'
            . ' WHERE '
            . $wheremenu
            . ' AND m.published > 0'
            . ' ORDER BY position, ordering';
 
		$db->setQuery($query);

		if(null ===($modules = $db->loadObjectList()))
		{
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('Error Loading Modules') . $db->getErrorMsg());
			return false;
		}
        
		$total = count($modules);
		for($i = 0; $i < $total; $i++)
		{
			//determine if this is a custom module
			$file					= $modules[$i]->module;
			$custom 				= substr($file, 0, 4) == 'mod_' ?  0 : 1;
			$modules[$i]->user  	= $custom;
			// CHECK: custom module name is given by the title field, otherwise it's just 'om' ??
			$modules[$i]->name		= $custom ? $modules[$i]->title : substr($file, 4);
			$modules[$i]->style		= null;
			$modules[$i]->position	= strtolower($modules[$i]->position);
		}
		return $modules;
	}
}