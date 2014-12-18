<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_stats
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="stats-module">
<?php foreach ($list as $item) : ?>
	<span class="stats-title"><?php echo $item->title;?></span>
	<span class="stats-data"><?php echo $item->data;?></span>
	<span class="clearfix"></span>
<?php endforeach; ?>
</div>
