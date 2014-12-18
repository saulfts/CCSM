<?php
/**
* @version		$Id: category_item.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
* @package		K2
* @author		JoomlaWorks http://www.joomlaworks.net
* @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
* @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
*/

// no direct access
defined('_JEXEC') or die;

// $params = K2HelperUtilities::getParams('com_k2');
// var_dump($params->get('categories'));

// var_dump($this->params->get('categories'));
// var_dump($this->params->get('catCatalogMode'));

if ($this->params->get('catCatalogMode')) {
	$recursive = 0;
} else {
	$recursive = 1;
}

require_once JPATH_ROOT . '/templates/'.JFactory::getApplication()->getTemplate().'/html/com_k2/templates/helper.php';

$tags = K2TagsHelper::getCatTags($this->params->get('categories'), $recursive);
?>

<?php if (count($tags)) : ?>
	<div class="itemListTags clearfix">
		<div class="navbar navbar-default">
		<form method="post">
			<ul class="nav navbar-nav">
				<!-- <li>
					<button class="btn btn-link" type="submit" name="tagid" value=""><?php echo JText::_('K2_ALL'); ?></button>
				</li> -->
				<?php foreach($tags as $key=>$tag): ?>
					<li>
						<button class="catItemTag<?php echo (JRequest::getString('tagid') == $tag->value) ? ' active' : ''; ?>" type="submit" name="tagid" value="<?php echo $tag->value; ?>"><?php echo $tag->tag; ?></button>
					</li>
				<?php endforeach; ?>
			</ul>
		</form>
		</div>
	</div>
	<div class="clr"></div>
<?php endif; ?>
