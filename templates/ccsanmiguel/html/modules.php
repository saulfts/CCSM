<?php 
/**
*	@version	$Id: modules.php 9 2013-03-21 09:47:13Z linhnt $
*	@package	OMG Responsive Template for Joomla! 2.5
*	@subpackage	modules chrome style for template ot_smartsolutions
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die();

/*
* Well large style: Module with border inset rounded, supports title split, icon, badge
* Icon and Badge is in bootstrap icon and badge class format
* See Badge: http://twitter.github.com/bootstrap/components.html#labels-badges
* See Icon: http://twitter.github.com/bootstrap/base-css.html#icons
*/
function modChrome_wellLarge($module, &$params, &$attribs)
{
	$hasIcon = false;
	$icon = array();
	$hasBadge = false;
	$badge = array();
	
	$moduleClassSuffix = htmlspecialchars($params->get('moduleclass_sfx'));

	$finalClassSfx = explode(' ', $moduleClassSuffix); // array contain classes
	
	// check if classSuffix contain icon class or badge class
	if (count($finalClassSfx)){
		$tempClsSfx = $finalClassSfx;
		foreach ($finalClassSfx as $idx => $clsSfx){
			if (strpos($clsSfx, 'icon-') !== false) {
				$hasIcon = true;
				$icon[] = $clsSfx;
				unset($tempClsSfx[$idx]);
				$module->content = str_replace($clsSfx, '', $module->content);
			}
			else if (strpos($clsSfx, 'badge-') !== false) {
				$badgeContent = explode('--', $clsSfx);
				if (isset($badgeContent[0]) && isset($badgeContent[1])){
					$hasBadge = true;
					$badge[] = $badgeContent[0];
					$badgeContent = $badgeContent[1];
				}
				unset($tempClsSfx[$idx]);
				$module->content = str_replace($clsSfx, '', $module->content);
			}
		}
		unset($idx, $clsSfx);
		unset($finalClassSfx);
		$finalClassSfx = $tempClsSfx;
		unset($tempClsSfx);
	}
	
	// prepare title: title split to parts or sub
	if ($module->showtitle){
		$arrtitle = explode('--',trim($module->title), 2);
		$title = '';
		if (count($arrtitle) > 1){
			foreach ($arrtitle as $index => $at) {
				$title .= '<span class="part'.$index.'">'.$at.'</span>';
			}
			unset($index, $at);
		}
		else $title = $module->title;
	}
	
	if ($module->content)
	{
		echo '<div id="mod-'.$module->id.'" class="ot-mod-outer well well-lg module' . (implode(' ', $finalClassSfx)) . '">';
			echo '<div class="ot-mod-inner clearfix">';
				
				if ($module->showtitle) echo '<h3 class="mod-title"><span>' . $title . '</span></h3>';
				
				if ($hasIcon) echo '<span class="glyphicon '.(implode(' ', $icon)).'"> </span>';
				if ($hasBadge) echo '<span class="badge '.(implode(' ', $badge)).'">'.$badgeContent.'</span>';
				
				echo '<div class="mod-content clearfix">';
					echo $module->content;
				echo '</div>';
				
			echo '</div>';
		echo '</div>';
	}
	
}

/*
* Well small style: Module with border inset rounded, supports title split, icon, badge
* Icon and Badge is in bootstrap icon and badge class format
* See Badge: http://twitter.github.com/bootstrap/components.html#labels-badges
* See Icon: http://twitter.github.com/bootstrap/base-css.html#icons
*/
function modChrome_wellSmall($module, &$params, &$attribs)
{
	$hasIcon = false;
	$icon = array();
	$hasBadge = false;
	$badge = array();
	
	$moduleClassSuffix = htmlspecialchars($params->get('moduleclass_sfx'));

	$finalClassSfx = explode(' ', $moduleClassSuffix); // array contain classes
	
	// check if classSuffix contain icon class or badge class
	if (count($finalClassSfx)){
		$tempClsSfx = $finalClassSfx;
		foreach ($finalClassSfx as $idx => $clsSfx){
			if (strpos($clsSfx, 'icon-') !== false) {
				$hasIcon = true;
				$icon[] = $clsSfx;
				unset($tempClsSfx[$idx]);
				$module->content = str_replace($clsSfx, '', $module->content);
			}
			else if (strpos($clsSfx, 'badge-') !== false) {
				$badgeContent = explode('--', $clsSfx);
				if (isset($badgeContent[0]) && isset($badgeContent[1])){
					$hasBadge = true;
					$badge[] = $badgeContent[0];
					$badgeContent = $badgeContent[1];
				}
				unset($tempClsSfx[$idx]);
				$module->content = str_replace($clsSfx, '', $module->content);
			}
		}
		unset($idx, $clsSfx);
		unset($finalClassSfx);
		$finalClassSfx = $tempClsSfx;
		unset($tempClsSfx);
	}
	
	// prepare title: title split to parts or sub
	if ($module->showtitle){
		$arrtitle = explode('--',trim($module->title), 2);
		$title = '';
		if (count($arrtitle) > 1){
			foreach ($arrtitle as $index => $at) {
				$title .= '<span class="part'.$index.'">'.$at.'</span>';
			}
			unset($index, $at);
		}
		else $title = $module->title;
	}
	
	if ($module->content)
	{
		echo '<div id="mod-'.$module->id.'" class="ot-mod-outer well well-sm module' . (implode(' ', $finalClassSfx)) . '">';
			echo '<div class="ot-mod-inner clearfix">';
			
				if ($module->showtitle) echo '<h3 class="mod-title"><span>' . $title . '</span></h3>';
				
				if ($hasIcon) echo '<span class="glyphicon '.(implode(' ', $icon)).'"> </span>';
				if ($hasBadge) echo '<span class="badge '.(implode(' ', $badge)).'">'.$badgeContent.'</span>';
				
				echo '<div class="mod-content clearfix">';
					echo $module->content;
				echo '</div>';
				
			echo '</div>';
		echo '</div>';
	}
	
}

/*
* Standard style: supports title split, icon, badge
* Icon and Badge is in bootstrap icon and badge class format
* See Badge: http://twitter.github.com/bootstrap/components.html#labels-badges
* See Icon: http://twitter.github.com/bootstrap/base-css.html#icons
*/
function modChrome_standard($module, &$params, &$attribs)
{
	$hasIcon = false;
	$icon = array();
	$hasBadge = false;
	$badge = array();
	
	$moduleClassSuffix = htmlspecialchars($params->get('moduleclass_sfx'));

	$finalClassSfx = explode(' ', $moduleClassSuffix); // array contain classes
	
	// check if classSuffix contain icon class or badge class
	if (count($finalClassSfx)){
		$tempClsSfx = $finalClassSfx;
		foreach ($finalClassSfx as $idx => $clsSfx){
			if (strpos($clsSfx, 'icon-') !== false) {
				$hasIcon = true;
				$icon[] = $clsSfx;
				unset($tempClsSfx[$idx]);
				$module->content = str_replace($clsSfx, '', $module->content);
			}
			else if (strpos($clsSfx, 'badge-') !== false) {
				$badgeContent = explode('--', $clsSfx);
				if (isset($badgeContent[0]) && isset($badgeContent[1])){
					$hasBadge = true;
					$badge[] = $badgeContent[0];
					$badgeContent = $badgeContent[1];
				}
				unset($tempClsSfx[$idx]);
				$module->content = str_replace($clsSfx, '', $module->content);
			}
		}
		unset($idx, $clsSfx);
		unset($finalClassSfx);
		$finalClassSfx = $tempClsSfx;
		unset($tempClsSfx);
	}
	
	// prepare title: title split to parts or sub
	if ($module->showtitle){
		$arrtitle = explode('--',trim($module->title), 2);
		$title = '';
		if (count($arrtitle) > 1){
			foreach ($arrtitle as $index => $at) {
				$title .= '<span class="part'.$index.'">'.$at.'</span>';
			}
			unset($index, $at);
		}
		else $title = $module->title;
	}
	
	if ($module->content)
	{
		echo '<div id="mod-'.$module->id.'" class="ot-mod-outer standard module' . (implode(' ', $finalClassSfx)) . '">';
			echo '<div class="ot-mod-inner clearfix">';
				
				if ($module->showtitle) echo '<h3 class="mod-title"><span>' . $title . '</span></h3>';
				
				if ($hasIcon) echo '<span class="glyphicon '.(implode(' ', $icon)).'"> </span>';
				if ($hasBadge) echo '<span class="badge '.(implode(' ', $badge)).'">'.$badgeContent.'</span>';
				
				echo '<div class="mod-content clearfix">';
					echo $module->content;
				echo '</div>';
				
			echo '</div>';
		echo '</div>';
	}
}

/*
* Preview style: display module with info of position and style
*/
function modChrome_preview($module, &$params, &$attribs)
{
	static $css = false;
	if (!$css)
	{
		$css = true;
		$doc = JFactory::getDocument();

		$doc->addStyleDeclaration(".mod-preview-info { padding: 2px 4px 2px 4px; border: 1px solid black; position: absolute; background-color: white; color: red;}");
		$doc->addStyleDeclaration(".mod-preview-wrapper { background-color:#eee; border: 1px dotted black; color:#700;}");
	}
	echo '
	<div class="mod-preview">
		<div class="mod-preview-info">Id: '.$module->id.'<br /> ' . $module->position . ' [' . $module->style . ']</div>
		<div class="mod-preview-wrapper">
			'.$module->content.'
		</div>
	</div>';
}

?>