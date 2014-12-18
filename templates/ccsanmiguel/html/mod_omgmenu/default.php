<?php
/**
*	@version	$Id: default.php 62 2013-06-06 02:31:37Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	mod_omgmenu
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die;


$langdirection = $document->getDirection();

$tagId = trim($params->get('tag_id', ''));
$tagId = ($tagId != '') ? 'id="'.$tagId.'"' : '';

$speed = trim($params->get('speed', 'normal'));
$effect = explode(',', str_replace(' ', '', $params->get('effect', 'opacity,height')));

$animation = array();
foreach($effect as $ef){
	$animation[] = $ef . ':"show"';
}
$animation = implode(',', $animation);


$last_items = array();//all last item IDs
foreach ( array_reverse ( $list, TRUE ) as $v ) {
   if ( !isset ( $last_items[$v->parent_id] ) )
      $last_items[$v->parent_id] = $v->id;
}
$first_start = true;//using for first item of level 1 menu and submenu

?>
<div class="otmenu-wrapper otmenu-desk-wrapper hidden-xs" id="otmenu-desk-wrapper-<?php echo $module->id; ?>">
	<div class="otmenu-wrapper-i"> 
		<ul class="ot-menu ot-dropdown-<?php echo $module->id; ?> menu <?php echo $class_sfx; ?>" <?php echo $tagId; ?>>
		<?php
		$zIndex = 35000;
		foreach ($list as $i => &$item) :
			$createColumn = (bool)$item->params->get('iomg_create_col', 0);
			$itemSubColumn = $createColumn ? 'hasColumn' : 'notColumn';
			$itemColumnStyles = 'style="width:' . $item->subWidth . 'px; margin:'.$item->subMargin.'px; padding:'.$item->subPadding.'px"';
			// $itemSubStyles = $createColumn ? 'style="width:' . $item->params->get('iomg_width', 200) . 'px;"' : 'style="width:' . ((isset($item->newSubWidth) && $item->newSubWidth > 0) ? $item->newSubWidth : $item->subWidth) . 'px; margin:'.$item->subMargin.'px; padding:'.$item->subPadding.'px"';
			$itemSubStyles = $createColumn ? 'style="width:' . ((isset($item->newSubWidth) && $item->newSubWidth > 0) ? $item->newSubWidth : $item->subWidth) . 'px;"' : 'style="width:' . ((isset($item->newSubWidth) && $item->newSubWidth > 0) ? $item->newSubWidth : $item->subWidth) . 'px; margin:'.$item->subMargin.'px; padding:'.$item->subPadding.'px"';
			// $createColumn ? var_dump($item->id . ': ' . $itemSubStyles) : '';
			
			
			
			$class = 'ot-menu-item level' . $item->level;
			if ($item->id == $active_id)
			{
				$class .= ' current';
			}

			if (in_array($item->id, $path))
			{
				$class .= ' active';
			}
			elseif ($item->type == 'alias')
			{
				$aliasToId = $item->params->get('aliasoptions');
				if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
				{
					$class .= ' active';
				}
				elseif (in_array($aliasToId, $path))
				{
					$class .= ' alias-parent-active';
				}
			}

			if ($item->type == 'separator')
			{
				$class .= ' divider';
			}
			
			if($first_start){
				$class .= ' first';
				$first_start = false;
			}
			if(in_array($item->id, $last_items)){
				$class .= ' last';
			}
			
			if ($item->deeper)
			{
				$class .= ' deeper';
				$first_start = true;
			}

			if ($item->parent)
			{
				$class .= ' hasChild';
			}
			
			$class .= ' '.$itemSubColumn;
			
			if ($item->classSuffix != '')
			{
				$class .= ' '. $item->classSuffix;
			}
			
			if (!empty($class))
			{
				$class = ' class="'.trim($class) .'"';
			}
			
			// echo '<li id="omi-'.$item->id .'" '.$class.' style="z-index:'.$zIndex.';">';
			echo '<li id="omi-'.$item->id .'" '.$class.'>';
			if ($createColumn){
				echo '<div class="submenu-column" ' . $itemColumnStyles . '>';
			} else {
				echo '<div>';
			}
			
			// Render the menu item.
			switch ($item->type) :
				case 'separator':
				case 'url':
				case 'component':
				case 'heading':
					require JModuleHelper::getLayoutPath('mod_omgmenu', 'default_'.$item->type);
					break;

				default:
					require JModuleHelper::getLayoutPath('mod_omgmenu', 'default_url');
					break;
			endswitch;
			
			// load check if load module
			// if ((bool)$item->params->get('iomg_loadmod', 0) && (int)$item->params->get('module_id', 0) > 0){
				// require JModuleHelper::getLayoutPath('mod_omgmenu', 'default_module');
			// }
			if ((bool)$item->params->get('iomg_loadmod', 0)){
				// if(($item->params->get('iomg_loadby')=="mod" && $item->params->get('iomg_modules')) || ($item->params->get('iomg_loadby')=="pos" && $item->params->get('iomg_positions'))){
					require JModuleHelper::getLayoutPath('mod_omgmenu', 'default_module');
				// }
			}
			
			// The next item is deeper.
			if ($item->deeper)
			{
				echo '
				<div class="submenu-wrap submenu-wrap-level'.$item->level .'" ' . $itemSubStyles . '>
					<div class="submenu-wrap-i">
						<div class="submenu-leftbg"></div>
						<div class="submenu-rightbg"></div>
						<div class="submenu-wrap-ii">
							<ul class="ot-menu child-menu">';
			}
			// The next item is shallower.
			elseif ($item->shallower)
			{
				echo '</div>';
				echo '</li>';
				echo str_repeat('</ul></div></div></div></div></li>', $item->level_diff);
			}
			// The next item is on the same level.
			else {
				echo '</div>';
				echo '</li>';
			}
			$zIndex --;
		endforeach;
		?></ul>
	</div>
	<script type="text/javascript">
	
	jQuery(document).ready(function($) {
		$("ul.ot-dropdown-<?php echo $module->id; ?>").otmenu({
			direction: '<?php echo $langdirection; ?>',
			// animation: opacity:"show", height:"show" or combined of them
			animation: {<?php echo $animation; ?>},
			// speed: 200 or 'fast', 400 or 'normal', 600 or 'slow'
			speed: '<?php echo $speed; ?>' 
		});
		
	});

</script>
</div>
