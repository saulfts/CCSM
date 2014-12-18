<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_related_items
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<ul class="relateditems list-items">
<?php foreach ($list as $item) :	?>
<li>
	<a href="<?php echo $item->route; ?>">
		<?php echo $item->title; ?></a>
		<?php /* if ($showDate) echo ' <span class="created">(' . JHTML::_('date', $item->created, JText::_('DATE_FORMAT_LC4')). ')</span>'; */ ?>
		<?php if ($showDate) echo ' <span class="created">(' . JHTML::_('date', $item->created, JText::_('d/m/Y')). ')</span>'; ?>
</li>
<?php endforeach; ?>
</ul>
