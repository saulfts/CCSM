<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$img = $imagebutton ? $img ? $img : 'templates/ot_porttitor/images/search_btn.png' : 'templates/ot_porttitor/images/search_btn.png';
$output = '';
$cls = '';
if (strpos( $params->get ('moduleclass_sfx'), 'accordion')!==false){
	$cls = ' collapse';
?>
	<input type="image" alt="<?php echo $button_text; ?>" class="button-img" src="<?php echo $img; ?>" data-toggle="collapse" data-target="#search<?php echo $module->id; ?>" />
<?php	
}
?>
<div id="search<?php echo $module->id; ?>" class="search<?php echo $cls; ?>">
    <form action="<?php echo JRoute::_('index.php');?>" method="post" class="form-inline">
		<div class="input-group">
    		<?php
				$output = '';
				//modify to check if no label text set in backend then do not display it. This depends on design.
				if (trim($params->get('label', '')) != '') $output .= '<label for="mod-search-searchword" class="element-invisible invisible">' . $label . '</label>';
				// $output .= '<input name="searchword" id="mod-search-searchword" maxlength="' . $maxlength . '"  class="inputbox'.$moduleclass_sfx.' search-query" type="text" size="' . $width . '" value="' . $text . '"  onblur="if (this.value==\'\') this.value=\'' . $text . '\';" onfocus="if (this.value==\'' . $text . '\') this.value=\'\';" />';
				$output .= '<input name="searchword" id="mod-search-searchword" maxlength="' . $maxlength . '"  class="inputbox search-query" type="text" size="' . $width . '" value="' . $text . '"  onblur="if (this.value==\'\') this.value=\'' . $text . '\';" onfocus="if (this.value==\'' . $text . '\') this.value=\'\';" />';
				
				if ($button) :
					if ($imagebutton) :
						// $button = ' <input type="image" alt="' . $button_text . '" class="button' . $moduleclass_sfx.'" src="' . $img . '" onclick="this.form.searchword.focus();"/>';
						$button = ' <input type="image" alt="' . $button_text . '" class="button btn btn-default" src="' . $img . '" onclick="this.form.searchword.focus();"/>';
					else :
						// modify to check if no button text set in backend, then display the search icon from bootstrap
						if (trim($params->get('button_text', '')) == '') $button_text = '<span class="glyphicon glyphicon-search"></span>';
						// $button = ' <button class="button' . $moduleclass_sfx . ' btn btn-primary" onclick="this.form.searchword.focus();">' . $button_text . '</button>';
						$button = ' <button class="button btn btn-default" onclick="this.form.searchword.focus();">' . $button_text . '</button>';
					endif;
				endif;

				switch ($button_pos) :
					case 'top' :
						$button = $button . '<br />';
						$output = $button . $output;
						break;

					case 'bottom' :
						$button = '<br />' . $button;
						$output = $output . $button;
						break;

					case 'right' :
						$output = $output . $button;
						break;

					case 'left' :
					default :
						$output = $button . $output;
						break;
				endswitch;

				echo $output;
			?>
			<input type="hidden" name="task" value="search" />
			<input type="hidden" name="option" value="com_search" />
			<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
		</div>
    </form>
	<div class="clearfix"></div>
</div>
