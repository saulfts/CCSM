<?php
require_once JPATH_ROOT . '/templates/'.JFactory::getApplication()->getTemplate().'/html/com_k2/templates/itemlist.php';
// K2Model::addIncludePath( JPATH_ROOT . '/templates/'.JFactory::getApplication()->getTemplate().'/html/com_k2/templates/itemlist.php');
$params = K2HelperUtilities::getParams('com_k2');
$items = K2ModelItemlistExt::getData();
$total = count($items) ? K2ModelItemlistExt::getTotal() : 0;
$view = JRequest::getWord('view');
$task = JRequest::getWord('task');
$user = JFactory::getUser();
$cache = JFactory::getCache('com_k2_extended');
$model = $this->getModel('item');
$limitstart = JRequest::getInt('limitstart');
$limit = $this->params->get('num_leading_items') + $this->params->get('num_primary_items') + $this->params->get('num_secondary_items') + $this->params->get('num_links');

for ($i = 0; $i < sizeof($items); $i++)
{ 
	// Ensure that all items have a group. If an item with no group is found then assign to it the leading group
	$items[$i]->itemGroup = 'leading';

	//Item group
	if ($i < $this->params->get('num_leading_items')) {
		$items[$i]->itemGroup = 'leading';
	}
	elseif ($i < ($this->params->get('num_primary_items') + $this->params->get('num_leading_items'))) {
		$items[$i]->itemGroup = 'primary';
	}
	elseif ($i < ($this->params->get('num_secondary_items') + $this->params->get('num_leading_items') + $this->params->get('num_primary_items'))) {
		$items[$i]->itemGroup = 'secondary';
	}
	elseif ($i < ($this->params->get('num_links') + $this->params->get('num_leading_items') + $this->params->get('num_primary_items') + $this->params->get('num_secondary_items'))) {
		$items[$i]->itemGroup = 'links';
	}
	// Check if the model should use the cache for preparing the item even if the user is logged in
	$cacheFlag = true;
	if (K2HelperPermissions::canEditItem($items[$i]->created_by, $items[$i]->catid))
	{
		$cacheFlag = false;
	}

	// Prepare item
	if ($cacheFlag)
	{
		$hits = $items[$i]->hits;
		$items[$i]->hits = 0;
		JTable::getInstance('K2Category', 'Table');
		$items[$i] = $cache->call(array(
			$model,
			'prepareItem'
		), $items[$i], $view, $task);
		$items[$i]->hits = $hits;
	}
	else
	{
		$items[$i] = $model->prepareItem($items[$i], $view, $task);
	}

	// Plugins
	$items[$i] = $model->execPlugins($items[$i], $view, $task);

	// Trigger comments counter event if needed
	if ($params->get('catItemK2Plugins') &&
		($params->get('catItemCommentsAnchor') ||
		 $params->get('itemCommentsAnchor') ||
		 $params->get('itemComments')))
	{
		// Trigger comments counter event
		$dispatcher = JDispatcher::getInstance();
		JPluginHelper::importPlugin('k2');
		$results = $dispatcher->trigger('onK2CommentsCounter', array(
			&$items[$i],
			&$params,
			$limitstart
		));
		$items[$i]->event->K2CommentsCounter = trim(implode("\n", $results));
	}
}

// Leading items
$offset = 0;
$length = $this->params->get('num_leading_items');
$this->leading = array_slice($items, $offset, $length);

// Primary
$offset = (int)$this->params->get('num_leading_items');
$length = (int)$this->params->get('num_primary_items');
$this->primary = array_slice($items, $offset, $length);

// Secondary
$offset = (int)($this->params->get('num_leading_items') + $this->params->get('num_primary_items'));
$length = (int)$this->params->get('num_secondary_items');
$this->secondary = array_slice($items, $offset, $length);

// Links
$offset = (int)($this->params->get('num_leading_items') + $this->params->get('num_primary_items') + $this->params->get('num_secondary_items'));
$length = (int)$this->params->get('num_links');
$this->links = array_slice($items, $offset, $length);

// Assign data
$this->assignRef('leading', $this->leading);
$this->assignRef('primary', $this->primary);
$this->assignRef('secondary', $this->secondary);
$this->assignRef('links', $this->links);

$this->pagination = new JPagination($total, $limitstart, $limit);

?>
	