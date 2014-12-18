<?php
/**
*	@version	$Id: fonts.php 9 2013-03-21 09:47:13Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	lib_omg
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

//No direct access!
defined( 'JPATH_BASE' ) or die();

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldFont extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var    string
	 * @since  11.3
	 */
	protected $type = 'Font';	
	
	protected $fonts;

	/**
	 * Method to get the field input markup.
	 *
	 * @return  string  The field input markup.
	 *
	 * @since   11.3
	 */
	protected function getInput()
	{
		$attr = '';

		// Initialize some field attributes.
		$attr .= !empty($this->class) ? ' class="' . $this->class . '"' : '';
		$attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
		$attr .= $this->multiple ? ' multiple' : '';
		$attr .= $this->required ? ' required aria-required="true"' : '';
		$attr .= $this->autofocus ? ' autofocus' : '';

		// To avoid user's confusion, readonly="true" should imply disabled="true".
		if ((string) $this->readonly == '1' || (string) $this->readonly == 'true' || (string) $this->disabled == '1'|| (string) $this->disabled == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		// Initialize JavaScript field attributes.
		$attr .= $this->onchange ? ' onchange="' . $this->onchange . '"' : '';

		$font_group = array('default' => 'Default', 'sansserif' => 'Safe Fonts: Sans-Serif', 'serif' => 'Safe Fonts: Serif', 'monospace' => 'Safe Fonts: Monospace', 'gwfont' => 'Google WebFonts');
		
		$sans_safe = array(
			"Arial, Helvetica, sans-serif",
			"'Arial Black', Gadget, sans-serif",
			"Impact, Charcoal, sans-serif",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif",
			"Tahoma, Geneva, sans-serif",
			"'Trebuchet MS', Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"
		);
		$serif_safe = array(
			"'Book Antiqua', 'Palatino Linotype', Palatino, serif",
			"Bookman, serif",
			"Garamond, serif",
			"Georgia, serif",
			"'MS Serif', 'New York', serif",
			"'Times New Roman', Times, serif"
		);
		$monospace_safe = array(
			"Courier, monospace",
			"'Courier New', Courier, monospace",
			"'Lucida Console', Monaco, monospace"
		);
		
		$html = array();
		$optionsHtml = array();
		
		foreach ($font_group as $key => $value) {
			$optionsHtml[] = JHTML::_('select.optgroup', $value);
			switch ($key) {
				case 'default':
					$optionsHtml[] = JHtml::_('select.option', 's:\'Helvetica Neue\',Helvetica,Arial,sans-serif', '\'Helvetica Neue\', Arial, Helvetica, sans-serif');
					break;
				case 'sansserif':
					foreach($sans_safe as $sansfont){
						$optionsHtml[] = JHtml::_('select.option', 's:' . $sansfont, $sansfont);
					}
					break;
				case 'serif':
					foreach($serif_safe as $seriffont){
						$optionsHtml[] = JHtml::_('select.option', 's:' . $seriffont, $seriffont);
					}
					break;
				case 'monospace':
					foreach($monospace_safe as $monospacefont){
						$optionsHtml[] = JHtml::_('select.option', 's:' . $monospacefont, $monospacefont);
					}
					break;
				case 'gwfont':
					// $jsonResponse = @file_get_contents('http://phat-reaction.com/googlefonts.php?format=php');
					$jsonResponse = @file_get_contents(JURI::root() . DS . "modules" . DS . "mod_omgmenu" . DS . 'libs' . DS . "fonts.json");
					if ($jsonResponse) {
						$decodedResponse = json_decode($jsonResponse);
						// $decodedResponse = unserialize($jsonResponse);
						if (isset($decodedResponse)) {
							JHtml::addIncludePath(JURI::root() . DS . "modules" . DS . "mod_omgmenu" . DS . 'libs' . DS);
							$optionsVariant = array();
							$optionsSubset = array();
							$htmlVariant = array();
							$htmlSubset = array();
							foreach ($decodedResponse as $key => $font) {
								$value_ = 'w:' . $key;
								$value_ .= ':' . implode(",", $font->variants);
								// $value_ .= '&subset=' . implode(",", $font->subsets);
								
								$optionsHtml[] = JHtml::_('select.option', $value_, $font->family);
							}
						} else{
							$optionsHtml[] = JHtml::_('select.option', '', 'ERROR: None or bad JSON received');
						}
					} else {
						$optionsHtml[] = JHtml::_('select.option', '', 'ERROR: Wrong URL or google API KEY?');
					}
					break;
			}
			$optionsHtml[] = JHTML::_('select.optgroup', '');
		}
		
		$html = JHTML::_('select.genericlist', $optionsHtml, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);
		return $html;
	}
}
