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
// no direct access
defined('_JEXEC') or die;

class modOTmegaMenuHelper
{

	public static function getList(&$params)
	{
		$app = JFactory::getApplication();
		$menu = $app->getMenu();

		// Get active menu item
		$active = self::getActive($params);
		$user = JFactory::getUser();
		$levels = $user->getAuthorisedViewLevels();
		asort($levels);
		$key = 'menu_items' . $params . implode(',', $levels) . '.' . $active->id;
		$cache = JFactory::getCache('mod_omgmenu', '');
		if (!($items = $cache->get($key)))
		{
			$path    = $active->tree;
			$start   = (int) $params->get('startLevel');
			$end     = (int) $params->get('endLevel');
			$showAll = $params->get('showAllChildren');
			$items   = $menu->getItems('menutype', $params->get('menutype'));

			$lastitem = 0;

			if ($items)
			{
				foreach ($items as $i => $item)
				{
					if (($start && $start > $item->level)
						|| ($end && $item->level > $end)
						|| (!$showAll && $item->level > 1 && !in_array($item->parent_id, $path))
						|| ($start > 1 && !in_array($item->tree[$start - 2], $path)))
					{
						unset($items[$i]);
						continue;
					}

					$item->deeper     = false;
					$item->shallower  = false;
					$item->level_diff = 0;

					if (isset($items[$lastitem]))
					{
						$items[$lastitem]->deeper     = ($item->level > $items[$lastitem]->level);
						$items[$lastitem]->shallower  = ($item->level < $items[$lastitem]->level);
						$items[$lastitem]->level_diff = ($items[$lastitem]->level - $item->level);
					}

					$item->parent = (boolean) $menu->getItems('parent_id', (int) $item->id, true);

					$lastitem     = $i;
					$item->active = false;
					$item->flink  = $item->link;

					// Reverted back for CMS version 2.5.6
					switch ($item->type)
					{
						case 'separator':
						case 'heading':
							// No further action needed.
							continue;

						case 'url':
							if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false))
							{
								// If this is an internal Joomla link, ensure the Itemid is set.
								$item->flink = $item->link . '&Itemid=' . $item->id;
							}
							break;

						case 'alias':
							// If this is an alias use the item id stored in the parameters to make the link.
							$item->flink = 'index.php?Itemid=' . $item->params->get('aliasoptions');
							break;

						default:
							$router = JSite::getRouter();
							if ($router->getMode() == JROUTER_MODE_SEF)
							{
								$item->flink = 'index.php?Itemid=' . $item->id;
							}
							else
							{
								$item->flink .= '&Itemid=' . $item->id;
							}
							break;
					}

					if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false))
					{
						$item->flink = JRoute::_($item->flink, true, $item->params->get('secure'));
					}
					else
					{
						$item->flink = JRoute::_($item->flink);
					}

					// We prevent the double encoding because for some reason the $item is shared for menu modules and we get double encoding
					// when the cause of that is found the argument should be removed
					$item->title        = htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8', false);
					$item->anchor_css   = htmlspecialchars($item->params->get('menu-anchor_css', ''), ENT_COMPAT, 'UTF-8', false);
					$item->anchor_title = htmlspecialchars($item->params->get('menu-anchor_title', ''), ENT_COMPAT, 'UTF-8', false);
					$item->menu_image   = $item->params->get('menu_image', '') ? htmlspecialchars($item->params->get('menu_image', ''), ENT_COMPAT, 'UTF-8', false) : '';
					
					if ($item->parent) $parentItem = self::getParentItem($item->parent_id, $items, true);
					$tempItem = $item;
					
					$tempItem->item_icon = $tempItem->params->get('iomg_icon', '') ? htmlspecialchars($item->params->get('iomg_icon', ''), ENT_COMPAT, 'UTF-8', false) : '';
					if (trim($tempItem->params->get('iomg_subtitle', '')) != '')
						$tempItem->item_desc = htmlspecialchars(trim($tempItem->params->get('iomg_subtitle', '')), ENT_COMPAT, 'UTF-8', false);
						
					if ((bool)$tempItem->params->get('iomg_custom_color', 0) && trim($tempItem->params->get('iomg_color', '#000')) != '')
						$tempItem->custom_color = trim($tempItem->params->get('iomg_color', '#000'));
						
					$tempItem->classSuffix = htmlspecialchars(trim($tempItem->params->get('iomg_listcls', '')));
					
					$tempItem->subWidth = strval($tempItem->params->get('iomg_width', 200));
					$tempItem->subPadding = strval($tempItem->params->get('iomg_padding', 5));
					$tempItem->subMargin = strval($tempItem->params->get('iomg_margin', 0));
					$tempItem->newSubWidth = 0;
					$tempItem->createColumn = (bool)$tempItem->params->get('iomg_create_col', 0);
					
					
					require_once(dirname(__FILE__).DS."module_helper.php");
					$modHelper = new OModuleHelper();

					$loadby = $tempItem->params->get("iomg_loadby", "mod");
					// $cols = $item->params->get("iomg_cols", 1);
					// $colWidth = $item->params->get("iomg_colwidth", '280');
					$width = $tempItem->params->get("iomg_width", '200');

					$item->mod = "";

					switch($loadby)
					{
						case "mod":
							$item->mod = $modHelper->getContentByModule($tempItem->params->get("iomg_modules",""), $tempItem->params->get('iomg_module_style', 'xhtml'), 'auto', $width, $item->title);
							$item->mod = str_replace(array("\r\n", "\r"), "\n",$item->mod);
							$item->mod = str_replace("\n", "",$item->mod);
							// $item->mod = '<![CDATA['.$item->mod.']]>';
						break;
						case "pos":
							$item->mod = $modHelper->getContentByPosition($tempItem->params->get("iomg_positions",""), $tempItem->params->get('iomg_module_style', 'xhtml'), 'auto', $width, $item->title);
						break;
					}
					
					$items[$i] = $tempItem;
					//OMG <<
				}
				
				
				if (isset($items[$lastitem]))
				{
					$items[$lastitem]->deeper     = (($start?$start:1) > $items[$lastitem]->level);
					$items[$lastitem]->shallower  = (($start?$start:1) < $items[$lastitem]->level);
					$items[$lastitem]->level_diff = ($items[$lastitem]->level - ($start?$start:1));
				}
			}

			$cache->store($items, $key);
		}
		$items = self::getStyleItems($items);
		return $items;
	}
	
	/**
	 * Get a the parent item object
	 */
	public static function getParentItem($id, $items, $returnKey = false) {
        foreach ($items as $idx => $item) {
            if ($item->id == $id)
                return $returnKey ? $idx : $item;
        }
    }
	
	/**
	 * Get a the parent item object
	 */
	public static function getStyleItems($items) {
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
        for ($i=(count($items) - 1); $i>=0; $i--) {
			$items[$i]->parent = (boolean) $menu->getItems('parent_id', (int) $items[$i]->id, true);
			if ($items[$i]->parent) {
				$parentItem = self::getParentItem($items[$i]->parent_id, $items, true);
			}
			
			$items[$i]->createColumn = (bool)$items[$i]->params->get('iomg_create_col', 0);
			if ($items[$i]->newSubWidth > 0){
				$items[$i]->subWidth = $items[$i]->newSubWidth;
			}
			if ($items[$i]->createColumn && isset($parentItem) && isset($items[$parentItem])) {
				$items[$parentItem]->newSubWidth = $items[$parentItem]->newSubWidth + $items[$i]->subWidth + $items[$i]->subPadding * 2 + $items[$i]->subMargin * 2;
			}
		}
		return $items;
    }

	/**
	 * Render the module
	 */
    public static function getModuleById($moduleID, $params, $modulesList, $style) {
			
		$attribs['style'] = $style;
		
		if (in_array($moduleID, array_keys($modulesList))) {
			// get the title of the module
			$moduleTitle = $modulesList[$moduleID]->title;
			$moduleName = $modulesList[$moduleID]->module;
			
			// load the module
			if (JModuleHelper::isEnabled($moduleName)) {
				$module = JModuleHelper::getModule($moduleName, $moduleTitle);
				return JModuleHelper::renderModule($module, $attribs);
			}
			
		} else {
			return 'Module ID='.$moduleID.'<br> does not exist !';
		}
    }

	/**
	 * Create the list of all modules published as Object
	 */
    public static function createModulesList() {
        $db = JFactory::getDBO();
        $query = "
			SELECT *
			FROM #__modules
			WHERE published=1
			ORDER BY id
			;";
        $db->setQuery($query);
        $modulesList = $db->loadObjectList('id');
        return $modulesList;
    }
	
	public static function getBase(&$params)
	{

		// Get base menu item from parameters
		if ($params->get('base'))
		{
			$base = JFactory::getApplication()->getMenu()->getItem($params->get('base'));
		}
		else
		{
			$base = false;
		}

		// Use active menu item if no base found
		if (!$base)
		{
			$base = self::getActive($params);
		}

		return $base;
	}
	
	
	public static function getActive(&$params)
	{
		$menu = JFactory::getApplication()->getMenu();

		return $menu->getActive() ? $menu->getActive() : $menu->getDefault();
	}
}
