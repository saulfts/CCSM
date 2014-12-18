<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: LayoutSection.php 34 2014-08-30 05:08:31Z linhnt $
 */
 
namespace Jarvis\Template;

defined('_JEXEC') or die('Access denied!');

class LayoutSection extends LayoutRow
{
	/**
	 * Render this row into html markup
	 * 
	 * @return  string
	 */
	public function render() {
		$columns = array();
    $background = array();
    $document = \JFactory::getDocument();
    
    if (!empty($this->background['color']) || !empty($this->background['image'])) {
        if(empty($this->id)) $this->id = 'otsection-'.md5(mt_rand(2, 10));
    
        if (!empty($this->background['color'])) $background[] = 'background-color:' . $this->background['color'];
        if (!empty($this->background['image'])) {
            $background[] = 'background-image:url("' . \JURI::root() . $this->background['image'] .'")';
            if (!empty($this->background['repeat'])) $background[] = 'background-repeat:' . $this->background['repeat'];
            if (!empty($this->background['attachment'])) $background[] = 'background-attachment:' . $this->background['attachment'];
            if (!empty($this->background['position-x']) && !empty($this->background['position-y'])) $background[] = 'background-position:' . $this->background['position-x'] . ' ' . $this->background['position-y'];
        }
        $document->addStyleDeclaration("#{$this->id} {". implode( ";\n", $background) ."}");
    }
        
		foreach($this->columns as $column) {
			$columns[] = $column->render();
		}
    if (empty($columns)) return '';
    
		$attributes = array();
		if (!empty($this->id))
			$attributes[] = "id=\"{$this->id}\"";
		$attributes[] = "class=\"section " . implode(' ', $this->classes) . "\"";

		
		$containerClass = $document->params['layoutStyle'] == 'full-width'
			? 'container'
			: 'container-fluid';

		return sprintf('
			<div %s>
				<div class="%s">
					<div class="row">
						%s
					</div>
				</div>
			</div>
			',
			implode(' ', $attributes),
			$containerClass,
			implode("\r\n", $columns)
		);
	}
}
