<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_latest
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
?>
<div class="latestnews style2">
	<?php foreach ($list as $key=>$item) : ?>
		<?php 
		if ($key==0) : ?>
			<div class="item-leading">
				<?php $images = json_decode($item->images); ?>
				<?php if(isset($images->image_intro) && !empty($images->image_intro)): ?>
					<?php $imgfloat = (empty($images->float_intro)) ? $params->get('float_intro') : $images->float_intro; ?>
					<div class="img-intro-<?php echo htmlspecialchars($imgfloat); ?>">
						<img <?php if ($images->image_intro_caption): echo 'class="caption"'.' title="' .htmlspecialchars($images->image_intro_caption) .'"'; endif; ?> src="<?php echo htmlspecialchars($images->image_intro); ?>" alt="<?php echo htmlspecialchars($images->image_intro_alt); ?>"/>
					</div>
				<?php endif ?>
				<h5 class="item-title"><a href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h5>
				<div class="item-introtext">
					<?php echo $item->introtext; ?>
				</div>
			</div>
			<?php echo count($list)>1 ? '<ul class="list-items">' : ''; ?>
		<?php else : ?>
			<li>
				<a href="<?php echo $item->link; ?>">
					<?php echo $item->title; ?>
					<span class="created">
						(<?php echo JHtml::_('date', $item->created, JText::_('d/m/Y')); ?>)
					</span>
				</a>
			</li>
			<?php echo (count($list)>1 && $key==count($list)-1) ? '</ul>' : ''; ?>
		<?php endif ?>
	<?php endforeach; ?>
</div>
