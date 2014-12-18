<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: Form.php 14 2014-07-17 04:49:10Z linhnt $
 */
// Declare namespace
namespace Jarvis\Form;

defined('_JEXEC') or die('Access denied!');

/**
 * 
 * @package     Jarvis
 */
class Form extends \JForm
{
	public function getXML() {
		return $this->xml;
	}
}
