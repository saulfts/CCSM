<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: LayoutRow.php 34 2014-08-30 05:08:31Z linhnt $
 */
 
namespace Jarvis\Template;

defined('_JEXEC') or die('Access denied!');

class LayoutRow
{
	/**
	 * Row ID
	 * @var  string
	 */
	protected $id;

	/**
	 * Row class names
	 * 
	 * @var  array
	 */
	protected $classes = array();

	/**
	 * Row custom background
	 * 
	 * @var  array
	 */
	protected $background = array(
		'color'      => null,
		'image'      => null,
		'repeat'     => 'repeat',
		'position-x' => 'left',
		'position-y' => 'top',
		'attachment' => 'scroll'
	);

	/**
	 * Row Visibility
	 * @var array
	 */
	protected $visibility = array();

	/**
	 * Row layout templates
	 * 
	 * @var  array
	 */
	protected $layoutTemplates = array(
		'1-columns' => array(
			'large' => array(12),
			'medium' => array(12),
			'small' => array(12),
			'xsmall' => array(12)
		),

		'2-columns' => array(
			'large' => array(6, 6),
			'medium' => array(6, 6),
			'small' => array(6, 6),
			'xsmall' => array(12, 12)
		),

		'3-columns' => array(
			'large' => array(4, 4, 4),
			'medium' => array(4, 4, 4),
			'small' => array(4, 4, 4),
			'xsmall' => array(12, 12, 12)
		),

		'4-columns' => array(
			'large' => array(3, 3, 3, 3),
			'medium' => array(3, 3, 3, 3),
			'small' => array(3, 3, 3, 3),
			'xsmall' => array(12, 12, 12, 12)
		),

		'5-columns' => array(
			'large' => array(2, 2, 2, 2, 2),
			'medium' => array(2, 2, 2, 2, 2),
			'small' => array(2, 2, 2, 2, 2),
			'xsmall' => array(12, 12, 12, 12, 12)
		),

		'6-columns' => array(
			'large' => array(2, 2, 2, 2, 2, 2),
			'medium' => array(2, 2, 2, 2, 2, 2),
			'small' => array(2, 2, 2, 2, 2, 2),
			'xsmall' => array(12, 12, 12, 12, 12, 12)
		)
	);

	/**
	 * The children columns
	 * 
	 * @var  array
	 */
	protected $columns = array();

	/**
	 * The number of columns will be appeared
	 * on individual screen size
	 * 
	 * @var  integer
	 */
	protected $visibleColumns = array(
		'large'  => array(),
		'medium' => array(),
		'small'  => array()
	);

	/**
	 * This flag will be set to TRUE
	 * if this row contains a column with mapped component position
	 * 
	 * @var  boolean
	 */
	protected $containComponent = false;

	/**
	 * Row cosntructor
	 * 
	 * @param  array  $params  Row params
	 */
	public function __construct($params) {
		// Preparing the row config
		if (isset($params['config']) && is_array($params['config'])) {
			// Set the row ID
			if (!empty($params['config']['id'])) {
				$this->id = $params['config']['id'];
			}

			// Set the row classes
			if (!empty($params['config']['class'])) {
				$this->classes = explode(' ', $params['config']['class']);
				$this->classes = array_unique(array_filter($this->classes));
			}

			// Set the row background
			if (!empty($params['config']['background']) && is_array($params['config']['background'])) {
				$this->background = array_merge($this->background, $params['config']['background']);
			}

			// Set the row visibility
			if (!empty($params['config']['visibility']) && is_array($params['config']['visibility'])) {
				$this->visibility = $params['config']['visibility'];
			}
		}

		// Preparing row layout
		if (isset($params['layout']) && is_array($params['layout'])) {
			foreach($params['layout'] as $length => $options) {
				$this->layoutTemplates["{$length}-columns"] = $options;
			}
		}

		// Preparing row columns
		if (isset($params['items']) && is_array($params['items'])) {
			// Loop through each item and create instance for it
			foreach ($params['items'] as $columnParams) {
				$column = new LayoutColumn($columnParams);

				// We will add created column into this row
				// when it is mapped with an position
				if ($column->hasPositions()) {
					foreach (array('large', 'medium', 'small') as $screensize)
						if ($column->isVisible($screensize))
							array_push($this->visibleColumns[$screensize], $column);

					// Check this column is mapped with component position
					if ($column->hasComponent()) {
						$this->containComponent = true;
					}
					
					$column->setParent($this);
					$column->setOrdering('xsmall', count($this->columns));

					$this->columns[] = $column;
				}
			}
		}

		// We need update width for all columns
		$this->updateColumnsWidth();
	}

	/**
	 * Calculate the column width based on row layout
	 * 
	 * @return  void
	 */
	private function updateColumnsWidth() {
		reset($this->visibleColumns);

		// Loop through each screen size and columns
		// to calculate the column width
		foreach ($this->visibleColumns as $screensize => $columns) {
			$columnCount = count($columns);

			if ($columnCount > 0) {
				$layoutTemplate = $this->layoutTemplates["{$columnCount}-columns"][$screensize];

				// Sort columns by the screen size to update column width
				usort($columns, function($firstColumn, $secondColumn) use ($screensize) {
					return ($firstColumn->getOrdering($screensize) > $secondColumn->getOrdering($screensize)) ? 1 : -1;
				});

				// Set columns width
				foreach ($columns as $index => $column) {
					$columnSize = array_shift($layoutTemplate);
					$column->setWidth($screensize, $columnSize);
					$column->setOrdering($screensize, $index);
				}

				// Update columns offset
				foreach ($columns as $index => $column) {
					$sourceIndex = $column->getOrdering('xsmall');
					$currentIndex = intval($column->getOrdering($screensize));

					if ($sourceIndex > $currentIndex) {
						$offsetColumns = array_filter($columns, function($offsetColumn) use ($sourceIndex, $currentIndex, $screensize) {
							return $offsetColumn->getOrdering('xsmall') < $sourceIndex &&
								$offsetColumn->getOrdering($screensize) > $currentIndex &&
								$offsetColumn->isVisible($screensize);
						});

						$offset = 0;
						foreach($offsetColumns as $offsetColumn) {
							$offset+= $offsetColumn->getWidth($screensize);
						}

						$column->setPullOffset($screensize, $offset);
					}
					elseif ($sourceIndex < $currentIndex) {
						$offsetColumns = array_filter($columns, function($offsetColumn) use ($sourceIndex, $currentIndex, $screensize) {
							return $offsetColumn->getOrdering('xsmall') > $sourceIndex &&
										 $offsetColumn->getOrdering($screensize) < $currentIndex &&
										 $offsetColumn->isVisible($screensize);
						});

						$offset = 0;
						foreach($offsetColumns as $offsetColumn) {
							$offset+= $offsetColumn->getWidth($screensize);
						}

						$column->setPushOffset($screensize, $offset);
					}
				}
			}
		}
	}

	/**
	 * Return TRUE if this row will contains any template positions
	 * 
	 * @return  boolean
	 */
	public function hasPositions() {
    return count($this->columns) > 0;
    
	}

	/**
	 * Return TRUE if this row is contained column that mapped
	 * with the component position
	 * 
	 * @return  boolean
	 */
	public function hasComponent() {
		return $this->containComponent;
	}

	/**
	 * Return TRUE if this row will be appeared on given screensize
	 * 
	 * @param   string  $screensize  The screensize
	 * @return  boolean
	 */
	public function isVisible($screensize) {
		return in_array($screensize, $this->visibility);
	}

	/**
	 * Render this row into html markup
	 * 
	 * @return  string
	 */
	public function render() {
		$columns = array();
    $countModules = 0;
    $document = \JFactory::getDocument();
    
    foreach($this->columns as $column) {
			$columns[] = $column->render();
		}
    
    if (empty($columns)) return '';
    
		$attributes = array();
		if (!empty($this->id))
			$attributes[] = "id=\"{$this->id}\"";
		$attributes[] = "class=\"row " . implode(' ', $this->classes) . "\"";

		return sprintf('
				<div %s>
					%s
				</div>
			',
			implode(' ', $attributes),
			implode("\r\n", $columns)
		);
	}
}
