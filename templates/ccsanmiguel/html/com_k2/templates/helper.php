<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_banners
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'route.php');
require_once (JPATH_SITE.DS.'components'.DS.'com_k2'.DS.'helpers'.DS.'utilities.php');

abstract class K2TagsHelper
{
	public static function getCatTags($catids, $cloud_category_recursive)
	{

		$mainframe = JFactory::getApplication();
		$user = JFactory::getUser();
		$aid = (int)$user->get('aid');
		$db = JFactory::getDBO();

		$jnow = JFactory::getDate();
		$now = K2_JVERSION == '15' ? $jnow->toMySQL() : $jnow->toSql();

		$nullDate = $db->getNullDate();

		$query = "SELECT i.id FROM #__k2_items as i";
		$query .= " LEFT JOIN #__k2_categories c ON c.id = i.catid";
		$query .= " WHERE i.published=1 ";
		$query .= " AND ( i.publish_up = ".$db->Quote($nullDate)." OR i.publish_up <= ".$db->Quote($now)." ) ";
		$query .= " AND ( i.publish_down = ".$db->Quote($nullDate)." OR i.publish_down >= ".$db->Quote($now)." )";
		$query .= " AND i.trash=0 ";
		if (K2_JVERSION != '15')
		{
			$query .= " AND i.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
		}
		else
		{
			$query .= " AND i.access <= {$aid} ";
		}
		$query .= " AND c.published=1 ";
		$query .= " AND c.trash=0 ";
		if (K2_JVERSION != '15')
		{
			$query .= " AND c.access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
		}
		else
		{
			$query .= " AND c.access <= {$aid} ";
		}

		if (is_array($catids))
		{
			$catids = array_filter($catids);
		}
		if ($catids)
		{
			if (!is_array($catids))
			{
				$catids = (array)$catids;
			}
			foreach ($catids as $cloudCategoryID)
			{
				$categories[] = $cloudCategoryID;
				if ($cloud_category_recursive)
				{
					$children = K2TagsHelper::getCategoryChildren($cloudCategoryID);
					$categories = @array_merge($categories, $children);
				}
			}
			$categories = @array_unique($categories);
			JArrayHelper::toInteger($categories);
			if (count($categories) == 1)
			{
				$query .= " AND i.catid={$categories[0]}";
			}
			else
			{
				$query .= " AND i.catid IN(".implode(',', $categories).")";
			}
		}

		if (K2_JVERSION != '15')
		{
			if ($mainframe->getLanguageFilter())
			{
				$languageTag = JFactory::getLanguage()->getTag();
				$query .= " AND c.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") AND i.language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") ";
			}
		}

		$db->setQuery($query);
		$IDs = K2_JVERSION == '30' ? $db->loadColumn() : $db->loadResultArray();

		if (!is_array($IDs) || !count($IDs))
		{
			return array();
		}

		$query = "SELECT tag.name, tag.id
        FROM #__k2_tags as tag
        LEFT JOIN #__k2_tags_xref AS xref ON xref.tagID = tag.id 
        WHERE xref.itemID IN (".implode(',', $IDs).") 
        AND tag.published = 1";
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$cloud = array();
		$cloudid = array();
		if (count($rows))
		{

			$i = 0;
			foreach ($rows as $tag)
			{
				if (@array_key_exists($tag->name, $cloudid))
				{
					$cloudid[$tag->name]++;
				}
				else
				{
					$cloudid[$tag->name] = 1;
					$i++;
				}
				$cloud[$i-1]['id'] = $tag->id;
				$cloud[$i-1]['name'] = $tag->name;
				$cloud[$i-1]['counter'] = $cloudid[$tag->name];
			}

			$counter = 0;
			// arsort($cloud, SORT_NUMERIC);
			// uksort($cloud, "strnatcasecmp");
			
			$tmp = new stdClass;
			$tmp->tag = JText::_('TPL_ALL_PROJECT');
			$tmp->count = count($cloud);
			$tmp->value = '';
			$tags[$counter] = $tmp;

			foreach ($cloud as $key => $value)
			{
				$counter++;
				$tmp = new stdClass;
				$tmp->tag = $value['name'];
				$tmp->count = $value['counter'];
				$tmp->value = $value['id'];
				$tags[$counter] = $tmp;
			}

			return $tags;
		}
	}
	
	public static function getCategoryChildren($catid)
	{

		static $array = array();
		$mainframe = JFactory::getApplication();
		$user = JFactory::getUser();
		$aid = (int)$user->get('aid');
		$catid = (int)$catid;
		$db = JFactory::getDBO();
		$query = "SELECT * FROM #__k2_categories WHERE parent={$catid} AND published=1 AND trash=0 ";
		if (K2_JVERSION != '15')
		{
			$query .= " AND access IN(".implode(',', $user->getAuthorisedViewLevels()).") ";
			if ($mainframe->getLanguageFilter())
			{
				$languageTag = JFactory::getLanguage()->getTag();
				$query .= " AND language IN (".$db->Quote($languageTag).", ".$db->Quote('*').") ";
			}
		}
		else
		{
			$query .= " AND access <= {$aid}";
		}
		$query .= " ORDER BY ordering ";

		$db->setQuery($query);
		$rows = $db->loadObjectList();
		if ($db->getErrorNum())
		{
			echo $db->stderr();
			return false;
		}
		foreach ($rows as $row)
		{
			array_push($array, $row->id);
			if (modK2ToolsHelper::hasChildren($row->id))
			{
				modK2ToolsHelper::getCategoryChildren($row->id);
			}
		}
		return $array;
	}
	
	public static function getTagName($tagid)
	{

		$mainframe = JFactory::getApplication();
		$user = JFactory::getUser();
		$aid = (int)$user->get('aid');
		$tagid = (int)$tagid;
		$db = JFactory::getDBO();
		$query = "SELECT tag.name
        FROM #__k2_tags as tag
        WHERE tag.id = (".$tagid.")
        AND tag.published = 1";
		$db->setQuery($query);
		$result = $db->loadresult();
		
		return $result;
	}
}
