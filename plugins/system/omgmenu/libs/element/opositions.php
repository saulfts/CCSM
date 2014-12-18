<?php
/**
*	OMGMenu Extension for Joomla 1.6 By Omegatheme
*	
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/
 
 // Ensure this file is being included by a parent file
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.html.html');
jimport('joomla.form.formfield');
class JFormFieldOpositions extends JFormField
{

	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	protected	$_name = 'opositions';

	protected function getInput()
    {
		$db =& JFactory::getDBO();
        $attr = '';
		$html = array();	
		
        // Initialize some field attributes.
        $attr .= !empty($this->element['class']) ? ' class="'.(string) $this->element['class'].'"' : '';
        // To avoid user's confusion, readonly="true" should imply disabled="true".
		// $attr .= $this->element['disabled'] ? ' disabled' : '';
        $attr .= ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true') ? ' disabled="disabled"' : '';
        $attr .= !empty($this->element['size'] )? ' size="'.(int) $this->element['size'].'"' : '';
        $attr .= $this->multiple ? ' multiple="multiple"' : '';
        // Initialize JavaScript field attributes.
        $attr .= !empty($this->element['onchange']) ? ' onchange="'.(string) $this->element['onchange'].'"' : '';
        
		$query = $db->getQuery(true);
		// $query = "SELECT DISTINCT position FROM #__modules ORDER BY position ASC";
		// Build the query.
		$query->select('DISTINCT position')
			->from('#__modules')
			->order('position ASC');
		$db->setQuery($query);
		$groups = $db->loadObjectList();
		
		if ($groups && count ($groups)) {
			foreach ($groups as $tvalue=>$item){
				$html[] = JHTML::_('select.option', $item->position, $item->position);
			}
		}
		if( !empty($value) && !is_array($value) )
			$value = explode("|", $value);
            
        $lists = JHTML::_('select.genericlist', $html, $this->name,trim($attr), 'value', 'text', $this->value, $this->id);
		
		return $lists;
	}
} 