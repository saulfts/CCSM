<?php
/**
*	@version	$Id: default_heading.php 62 2013-06-06 02:31:37Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	mod_omgmenu
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die;
$inlineStyle = (isset($item->custom_color) && trim($item->custom_color) !='') ? 'style="color: '.trim($item->custom_color).';"' : '';
$item_icon = (isset($item->item_icon) && trim($item->item_icon) != '') ? '<img class="item-icon" src="'.$item->item_icon.'" alt="'.$item->title.'"/>' : '';
?>
<?php echo $item_icon; ?>
<?php if ((int)$item->params->get('iomg_showtitle', 1) == 1) : ?>
<span class="nav-header" <?php echo $inlineStyle; ?>><?php echo $item->title; ?></span>
<?php endif; ?>
<?php if (isset($item->item_desc) && trim($item->item_desc) !='')	$linktype .= '<br /><span class="item-desc">'.$item->item_desc.'</span>'; ?>