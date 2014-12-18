<?php
/**
*	@version	$Id: default_mobile.php 43 2013-04-11 04:20:04Z linhnt $
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


$last_items = array();
foreach ( array_reverse ( $list, TRUE ) as $v ) {
   if ( !isset ( $last_items[$v->parent_id] ) )
      $last_items[$v->parent_id] = $v->id;
}
$first_start = true;

?>
<div class="otmenu-wrapper otmenu-mobile-wrapper hidden-sm hidden-md hidden-lg" id="otmenu-mobile-wrapper-<?php echo $module->id; ?>">
	<div class="otmenu-wrapper-i">
		<a class="btn btn-default btn-navbar collapsed" data-toggle="collapse" data-parent="#otmenu-mobile-wrapper-<?php echo $module->id; ?>" href="#ot-sliding-<?php echo $module->id; ?>">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</a>
		<div class="clearfix"></div>
		<div id="ot-sliding-<?php echo $module->id; ?>" class="panel-collapse collapse">
			<ul id="ot-sliding1-<?php echo $module->id; ?>" class="ot-menu panel-group <?php echo $class_sfx; ?>" <?php echo $tagId; ?>>
			<?php
				foreach ($list as $i => &$item) :
					$createColumn = (bool)$item->params->get('iomg_create_col', 0);
					$itemSubColumn = $createColumn ? 'hasColumn' : 'notColumn';
					//$itemColumnStyles = 'style="width:' . $item->subWidth . 'px; padding:'.$item->subPadding.'px"';
					//$itemSubStyles = 'style="width:' . $item->params->get('iomg_width', 200) . 'px;"';
					//$itemSubStyles = 'style="width:' . ((isset($item->newSubWidth) && $item->newSubWidth > 0) ? $item->newSubWidth : $item->subWidth) . 'px; padding:'.$item->subPadding.'px"';
					
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
						$class .= ' panel hasChild';
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
					
					echo '<li id="omi-'.$item->id .'" '.$class.'>';
					
					// the click handler
					// if ($item->parent && !$createColumn) echo '<span class="toogle-btn icon-plus-sign"> </span>';
					$dataParent = ($item->level == 1 ? '#ot-sliding1-'.$module->id : '#sub-omi-'.$item->parent_id);
					if ($item->parent && !$createColumn) echo '<a class="toogle-btn collapsed" data-toggle="collapse" data-parent="' . $dataParent .'" href="#submenu-wrap'.$item->id .'"><span class="glyphicon glyphicon-plus"></span></a>';
					
					// if ($createColumn){
						// echo '<div class="submenu-column" >';
					// } else {
						// echo '<div>';
					// }
					
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
					if ((bool)$item->params->get('iomg_loadmod', 0)){
						require JModuleHelper::getLayoutPath('mod_omgmenu', 'default_module');
					}
					
					// The next item is deeper.
					if ($item->deeper)
					{
						// echo '
						// <div id="submenu-wrap'.$item->id .'" class="submenu-wrap submenu-wrap-level'.$item->level .' panel-collapse collapse" >
							// <div class="submenu-wrap-i">
								// <div class="submenu-leftbg"></div>
								// <div class="submenu-rightbg"></div>
								// <div class="submenu-wrap-ii">
									// <ul class="ot-menu child-menu">';
						if ($createColumn){
						echo '
						<div id="submenu-wrap'.$item->id .'" class="submenu-wrap submenu-wrap-level'.$item->level .'" >
							<div class="submenu-wrap-i">
								<div class="submenu-leftbg"></div>
								<div class="submenu-rightbg"></div>
								<div class="submenu-wrap-ii">
									<ul id="sub-omi-' . $item->id . '" class="ot-menu child-menu panel-group">';
						} else {
						echo '
						<div id="submenu-wrap'.$item->id .'" class="submenu-wrap submenu-wrap-level'.$item->level .' panel-collapse collapse" >
							<div class="submenu-wrap-i">
								<div class="submenu-leftbg"></div>
								<div class="submenu-rightbg"></div>
								<div class="submenu-wrap-ii">
									<ul id="sub-omi-' . $item->id . '" class="ot-menu child-menu panel-group">';
						}
					}
					// The next item is shallower.
					elseif ($item->shallower)
					{
						// echo '</div>';
						echo '</li>';
						echo str_repeat('</ul></div></div></div></li>', $item->level_diff);
					}
					// The next item is on the same level.
					else {
						// echo '</div>';
						echo '</li>';
					}
				endforeach;
				?>
			</ul>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			function toggleIcon(e) {
				$(e.target)
					.prev().prev('.toogle-btn')
					.find(".glyphicon")
					.toggleClass('glyphicon-plus glyphicon-minus');
			}
			$('#ot-sliding1-<?php echo $module->id; ?>').on('hidden.bs.collapse', toggleIcon);
			$('#ot-sliding1-<?php echo $module->id; ?>').on('shown.bs.collapse', toggleIcon);
		});
	</script>
	
</div>
