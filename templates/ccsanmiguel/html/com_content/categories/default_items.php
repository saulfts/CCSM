<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$class = ' class="first"';
JHtml::_('bootstrap.tooltip');
$lang	= JFactory::getLanguage();

if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) :
?>
<?php foreach ($this->items[$this->parent->id] as $id => $item) : ?>
	<?php
	if ($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
	if (!isset($this->items[$this->parent->id][$id + 1]))
	{
		$class = ' class="last"';
	}
	?>
	<div<?php echo $class; ?>>
	<?php $class = ''; ?>
		<?php if ($lang->isRTL()) : ?>
		<h3 class="page-header item-title<?php echo (count($item->getChildren()) > 0) ? ' panel-heading' : ''; ?>">
			<?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
				<span class="badge badge-info tip hasTooltip" title="<?php echo JText::_('COM_CONTENT_NUM_ITEMS'); ?>">
					<?php echo $item->numitems; ?>
				</span>
			<?php endif; ?>
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
			<?php echo $this->escape($item->title); ?></a>

			<?php if (count($item->getChildren()) > 0) : ?>
				<a href="#category-<?php echo $item->id; ?>" data-toggle="collapse" data-toggle="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span></a>
			<?php endif;?>
		<?php else : ?>
		<h3 class="page-header item-title<?php echo (count($item->getChildren()) > 0) ? ' panel-heading' : ''; ?>"><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)); ?>">
			<?php echo $this->escape($item->title); ?></a>
			<?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
				<span class="badge badge-info tip hasTooltip" title="<?php echo JText::_('COM_CONTENT_NUM_ITEMS'); ?>">
					<?php echo $item->numitems; ?>
				</span>
			<?php endif; ?>

			<?php if (count($item->getChildren()) > 0) : ?>
				<a href="#category-<?php echo $item->id; ?>" data-toggle="collapse" data-toggle="button" class="btn btn-default btn-xs pull-right"><span class="glyphicon glyphicon-plus"></span></a>
			<?php endif;?>
		<?php endif;?>
		</h3>
		<?php if ($this->params->get('show_subcat_desc_cat') == 1) :?>
		<?php if ($item->description) : ?>
			<div class="category-desc">
				<?php echo JHtml::_('content.prepare', $item->description, '', 'com_content.categories'); ?>
			</div>
		<?php endif; ?>
        <?php endif; ?>

		<?php if (count($item->getChildren()) > 0) :?>
			<div class="panel-collapse collapse fade" id="category-<?php echo $item->id; ?>">
			<?php
			$this->items[$item->id] = $item->getChildren();
			$this->parent = $item;
			$this->maxLevelcat--;
			echo $this->loadTemplate('items');
			$this->parent = $item->getParent();
			$this->maxLevelcat++;
			?>
			</div>
		<?php
		endif; ?>

	</div>
	<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
