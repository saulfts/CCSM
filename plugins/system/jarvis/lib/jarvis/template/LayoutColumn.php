<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: LayoutColumn.php 34 2014-08-30 05:08:31Z linhnt $
 */
 
namespace Jarvis\Template;

defined('_JEXEC') or die('Access denied!');

class LayoutColumn
{
	/**
	 * Column ID
	 * 
	 * @var  string
	 */
	public $id;

	/**
	 * Column classes
	 * 
	 * @var  array
	 */
	public $classes = array();

	/**
	 * The ordering number of this column
	 * 
	 * @var  integer
	 */
	public $sourceOrder = 0;

	/**
	 * The parent instance
	 * 
	 * @var  LayoutRow
	 */
	public $parent;

	/**
	 * Mapped position
	 * 
	 * @var  string
	 */
	public $position;

	/**
	 * Style for the modules position
	 * 
	 * @var  string
	 */
	public $positionStyle = 'none';

	/**
	 * Pull offset
	 * 
	 * @var  array
	 */
	public $pullOffset = array(
		'large'  => 0,
		'medium' => 0,
		'small'  => 0,
		'xsmall' => 0
	);

	/**
	 * Push offset
	 * 
	 * @var  array
	 */
	public $pushOffset = array(
		'large'  => 0,
		'medium' => 0,
		'small'  => 0,
		'xsmall' => 0
	);

	/**
	 * This flag will be used to determine
	 * the column has mapped position
	 * 
	 * @var  boolean
	 */
	public $containPositions = false;

	/**
	 * Column visibility
	 * 
	 * @var  array
	 */
	public $visibility = array();

	/**
	 * Column size
	 * 
	 * @var  array
	 */
	public $size = array(
		'large'  => 12,
		'medium' => 12,
		'small'  => 12,
		'xsmall' => 12
	);

	/**
	 * Column ordering
	 * 
	 * @var  array
	 */
	public $ordering = array(
		'large'  => 0,
		'medium' => 0,
		'small'  => 0,
		'xsmall' => 0
	);

	/**
	 * Column rows
	 * 
	 * @var  array
	 */
	public $rows = array();

	/**
	 * Document instance
	 * 
	 * @var  JDocumentHtml
	 */
	public $document;

	/**
	 * Column constructor
	 * 
	 * @param   array  $params  Column params
	 */
	public function __construct($params) {
		$this->document = \JFactory::getDocument();

		// Preparing the column config
		if (isset($params['config']) && is_array($params['config'])) {
			// Set the column ID
			if (!empty($params['config']['id'])) {
				$this->id = $params['config']['id'];
			}
            
            // Set the column classes
			if (!empty($params['config']['class'])) {
				$this->classes = explode(' ', $params['config']['class']);
				$this->classes = array_unique(array_filter($this->classes));
			}

			// Set the column visibility
			if (!empty($params['config']['visibility']) && is_array($params['config']['visibility'])) {
				$this->visibility = $params['config']['visibility'];
			}
		}

		// Preparing column position
		if (isset($params['position']) && $params['position'] != '') {
			$this->position = $params['position'];
		}

		// Preparing column position
		if (isset($params['positionStyle'])) {
			$this->positionStyle = $params['positionStyle'];
		}

		// Preparing column ordering
		if (isset($params['order']) && isset($params['order'])) {
			$this->ordering = array_merge($this->ordering, $params['order']);
		}

		// Preparing child rows
		if (isset($params['items']) && is_array($params['items'])) {
			foreach ($params['items'] as $rowParams) {
				$row = new LayoutRow($rowParams);

				if ($row->hasPositions()) {
					$this->containPositions = true;
					$this->rows[] = $row;
				}
			}
		}
	}

	public function getPosition() {
		return $this->position;
	}

	/**
	 * Return TRUE if this column is mapped with an template position
	 * 
	 * @return  boolean
	 */
	public function hasPositions() {
		$hasPosition = $this->position != '' && $this->document->countModules($this->position) > 0;
		return $this->position == 'logo' ||
			$hasPosition ||
			$this->hasComponent() ||
			$this->hasMessage() ||
			$this->containPositions;
	}

	/**
	 * Return TRUE if this column is mapped with the message position
	 * 
	 * @return  boolean
	 */
	public function hasMessage() {
		return ($this->position == 'system-message' && count(\JFactory::getApplication()->getMessageQueue()));
	}
	/**
	 * Return TRUE if this column is mapped with the component position
	 * 
	 * @return  boolean
	 */
	public function hasComponent() {
    if ((int)$this->document->params->get('componentOnFrontpage') == 0 && Builder::isHomepage()) return false;
		return $this->position == 'component';
	}

	/**
	 * Return TRUE if this column will be appeared on given screensize
	 * 
	 * @param   string  $screensize  The screensize
	 * @return  boolean
	 */
	public function isVisible($screensize) {
		return in_array($screensize, $this->visibility);
	}

	/**
	 * Set the column width that based on screensize
	 * 
	 * @param   string  $screensize  The screensize
	 * @param   int     $width       The column width
	 *
	 * @return  void
	 */
	public function setWidth($screensize, $width) {
		$this->size[$screensize] = $width;
	}

	/**
	 * Get the column width that based on screensize
	 * 
	 *
	 * @return  int
	 */
	public function getWidth($screensize) {
		if ($this->document->params['enableResponsive'] == 0)
			return $this->size['large'];

		return $this->size[$screensize];
	}

	public function setOrdering($screensize, $order) {
		$this->ordering[$screensize] = $order;
	}

	/**
	 * Return the index number of this column that
	 * determined by screensize
	 * 
	 * @param   string  $screensize  The screensize
	 * @return  int
	 */
	public function getOrdering($screensize) {
		return $this->ordering[$screensize];
	}

	/**
	 * Set the order of this column in the source code
	 * 
	 * @param   int  $orderIndex  The order index
	 * @return  void
	 */
	public function setSourceOrder($orderIndex) {
		$this->sourceOrder = $orderIndex;
	}

	/**
	 * Get the order of this column in the source code
	 * 
	 * @return  int
	 */
	public function getSourceOrder() {
		return $this->sourceOrder;
	}

	/**
	 * Set instance of the parent for this row
	 * 
	 * @param   LayoutRow  $parent  Parent instance
	 * @return  void
	 */
	public function setParent($parent) {
		$this->parent = $parent;
	}

	public function setPullOffset($screensize, $offset) {
		$this->pullOffset[$screensize] = $offset;
	}

	public function setPushOffset($screensize, $offset) {
		$this->pushOffset[$screensize] = $offset;
	}

	/**
	 * Render this column into html markup
	 * 
	 * @return  string
	 */
	public function render() {
    
    if (!$this->hasPositions()) return '';
    
		$classMap = array(
			'large'  => 'lg',
			'medium' => 'md',
			'small'  => 'sm',
			'xsmall' => 'xs'
		);
        
		if ($this->document->params['enableResponsive'] == 0) {
			$screensize = 'large';
			$prefix = 'xs';

			$this->classes[] = sprintf('col-%s-%d', $prefix, $this->getWidth($screensize));

			if ($this->isVisible($screensize) == false)
				$this->classes[] = sprintf('hidden-%s', $prefix);

			if ($this->pullOffset[$screensize] > 0)
				$this->classes[] = sprintf('col-%s-pull-%d', $prefix, $this->pullOffset[$screensize]);
			elseif ($this->pushOffset[$screensize] > 0)
				$this->classes[] = sprintf('col-%s-push-%d', $prefix, $this->pushOffset[$screensize]);
			else
				$this->classes[] = sprintf('col-%s-reset', $prefix);
		}
		else {
			foreach ($classMap as $screensize => $prefix) {
				$this->classes[] = sprintf('col-%s-%d', $prefix, $this->getWidth($screensize));

				if ($this->isVisible($screensize) == false)
					$this->classes[] = sprintf('hidden-%s', $prefix);

				if ($this->pullOffset[$screensize] > 0)
					$this->classes[] = sprintf('col-%s-pull-%d', $prefix, $this->pullOffset[$screensize]);
				elseif ($this->pushOffset[$screensize] > 0)
					$this->classes[] = sprintf('col-%s-push-%d', $prefix, $this->pushOffset[$screensize]);
				else
					$this->classes[] = sprintf('col-%s-reset', $prefix);
			}
		}

		
		$attributes = array();
		if (!empty($this->id))
			$attributes[] = "id=\"{$this->id}\"";

		$attributes[] = "class=\"" . implode(' ', $this->classes) . "\"";

		if (!empty($this->rows)) {
			$rows = array();
			foreach($this->rows as $row) {
        if ($row->hasPositions())
          $rows[] = $row->render();
			}
      
			return sprintf('<div %s>%s</div>', implode(' ', $attributes), implode('', $rows));
		}
		elseif (!empty($this->position)) {
			$blockFile = strtolower($this->position);
			$paths = array(
				\JPATH_ROOT . "/templates/{$this->document->template}/blocks/",
				\JARVIS_ROOT . "/tmpl/blocks/"
			);
			$blockFilePath = \JPath::find($paths, "{$blockFile}.php");

			if (is_file($blockFilePath)) {
				ob_start();
				include $blockFilePath;
				return sprintf('<div %s>%s</div>', implode(' ', $attributes), ob_get_clean());
			}
			else{
      
        switch ($this->position) {
          case 'component':            
            return sprintf('<div %s><jdoc:include type="component" /></div>', implode(' ', $attributes));
          break;
          
          case 'system-message':
            return sprintf('<div %s><jdoc:include type="message" /></div>', implode(' ', $attributes));
          break;
          
          default:
              return sprintf('<div %s><jdoc:include type="modules" name="%s" style="%s" /></div>',
                implode(' ', $attributes),
                $this->position,
                $this->positionStyle
              );
          break;
        }
			}

			
		}
	}
}
