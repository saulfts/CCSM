<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: Jarvis.php 14 2014-07-17 04:49:10Z linhnt $
 */
 
// Declare namespace
namespace Jarvis;
 
defined('_JEXEC') or die('Access denied!');

/**
 * 
 * @package     Jarvis
 */
class Jarvis
{
	private static $registry = array();

	/**
	 * Store item into registry that associated with a key
	 * 
	 * @param   string  $key    Item key
	 * @param   mixed   $value  Item data
	 * 
	 * @return  void
	 */
	public static function set($key, $value) {
		self::$registry[$key] = $value;
	}

	/**
	 * Retrieve an item from registry that determined by key
	 * 
	 * @param   string  $key  Item key
	 * @return  mixed
	 */
	public static function get($key) {
		return (self::has($key))
			? self::$registry[$key]
			: null;
	}

	/**
	 * Return true if given key is existed in the registry
	 * 
	 * @param   string  $key  Item key
	 * @return  boolean
	 */
	public static function has($key) {
		return isset(self::$registry[$key]);
	}
}
