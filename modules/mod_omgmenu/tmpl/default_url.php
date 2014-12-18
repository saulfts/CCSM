<?php
/**
*	@version	$Id: default_url.php 62 2013-06-06 02:31:37Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	mod_omgmenu
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die;

$class = $item->anchor_css ? 'class="item-link level' . $item->level .' ' . $item->anchor_css.'" ' : 'class="item-link level' . $item->level . '" ';
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
if ($item->menu_image)
{
	$item->params->get('menu_text', 1) ?
	$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
	$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
}
else { 
	$item_icon = (isset($item->item_icon) && trim($item->item_icon) != '') ? '<img class="item-icon" src="'.$item->item_icon.'" alt="'.$item->title.'"/>' : '';
	$linktype = $item_icon . (((int)$item->params->get('iomg_showtitle', 1) == 1) ? '<span class="item-text '.($createColumn ? 'columnTitle' : '').'">'.$item->title.'</span>'	: '');
	if (isset($item->item_desc) && trim($item->item_desc) !='')	$linktype .= '<br /><span class="item-desc">'.$item->item_desc.'</span>';
}
$flink = $item->flink;
$flink = JFilterOutput::ampReplace(htmlspecialchars($flink));
$inlineStyle = (isset($item->custom_color) && trim($item->custom_color) !='') ? 'style="color: '.trim($item->custom_color).';"' : '';
switch ($item->browserNav) :
	default:
	case 0:
?><a <?php echo $class; ?> href="<?php echo $flink; ?>" <?php echo $title; ?> <?php echo $inlineStyle ?>><?php echo $linktype; ?></a><?php
		break;
	case 1:
		// _blank
?><a <?php echo $class; ?> href="<?php echo $flink; ?>" target="_blank" <?php echo $title; ?> <?php echo $inlineStyle ?>><?php echo $linktype; ?></a><?php
		break;
	case 2:
		// window.open
		$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,'.$params->get('window_open');
			?><a <?php echo $class; ?> href="<?php echo $flink; ?>" onclick="window.open(this.href,'targetWindow','<?php echo $options;?>');return false;" <?php echo $title; ?> <?php echo $inlineStyle ?>><?php echo $linktype; ?></a><?php
		break;
endswitch;
