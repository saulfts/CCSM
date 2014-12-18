<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="search<?php // echo $moduleclass_sfx ?>">
	<form action="<?php echo JRoute::_('index.php');?>" method="post" class="form-inline">
		<?php
			$output = '<label for="mod-search-searchword" class="element-invisible invisible">' . $label . '</label> ';
			$output .= '<input name="searchword" id="mod-search-searchword" maxlength="' . $maxlength . '"  class="inputbox search-query form-control" type="text" size="' . $width . '" value="' . $text . '"  onblur="if (this.value==\'\') this.value=\'' . $text . '\';" onfocus="if (this.value==\'' . $text . '\') this.value=\'\';" />';

			if ($button) :
				if ($imagebutton) :
					if ($img){
						$btn_output = ' <input type="image" value="' . $button_text . '" class="button btn btn-default btn-search" src="' . $img . '" onclick="this.form.searchword.focus();"/>';
					} else {
						$btn_output = ' <button class="button btn btn-default btn-search" onclick="this.form.searchword.focus();"><i class="glyphicon glyphicon-search"> </i></button>';
					}
				else :
					$btn_output = ' <button class="button btn btn-primary btn-search" onclick="this.form.searchword.focus();">' . $button_text . '</button>';
				endif;

				switch ($button_pos) :
					case 'top' :
						$output = $btn_output . '<br />' . $output;
						break;

					case 'bottom' :
						$output .= '<br />' . $btn_output;
						break;

					case 'right' :
						$output .= $btn_output;
						break;

					case 'left' :
					default :
						$output = $btn_output . $output;
						break;
				endswitch;

			endif;

			echo $output;
		?>
		<input type="hidden" name="task" value="search" />
		<input type="hidden" name="option" value="com_search" />
		<input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
	</form>
</div>