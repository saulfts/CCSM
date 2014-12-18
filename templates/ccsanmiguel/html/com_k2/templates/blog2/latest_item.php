<?php
/**
 * @version		$Id: latest_item.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Item Layout -->
<div class="latestItemView">

	<!-- Plugins: BeforeDisplay -->
	<?php echo $this->item->event->BeforeDisplay; ?>

	<!-- K2 Plugins: K2BeforeDisplay -->
	<?php echo $this->item->event->K2BeforeDisplay; ?>

	<?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
	  <!-- Item Image -->
	  <div class="latestItemImageBlock text-center col-xs-12 col-sm-4">
		  <span class="latestItemImage">
		    <a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
		    	<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:auto;" />
		    </a>
		  </span>
		  <div class="clr"></div>
	  </div>
	<?php endif; ?>

	<?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
		<div class="col-xs-12 col-sm-8">
	<?php endif; ?>
	<div class="latestItemHeader">
	  <?php if($this->item->params->get('latestItemTitle')): ?>
	  <!-- Item title -->
	  <h3 class="latestItemTitle">
	  	<?php if ($this->item->params->get('latestItemTitleLinked')): ?>
			<a href="<?php echo $this->item->link; ?>">
	  		<?php echo $this->item->title; ?>
	  	</a>
	  	<?php else: ?>
	  	<?php echo $this->item->title; ?>
	  	<?php endif; ?>
	  </h3>
	  <?php endif; ?>
	</div>
	
	<?php if($this->item->params->get('latestItemCategory') || $this->item->params->get('latestItemDateCreated') || ($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) )){ ?>
		<div class="latestItemInfo">
			<?php if($this->item->params->get('latestItemDateCreated')): ?>
			<!-- Date created -->
			<span class="latestItemDateCreated">
				<i class="glyphicon glyphicon-calendar"></i>
				<?php echo JHTML::_('date', $this->item->created , JText::_('K2_DATE_FORMAT_LC2')); ?>
			</span>
			<?php endif; ?>

			<?php if($this->item->params->get('latestItemCategory')): ?>
			<!-- Item category name -->
			<span class="latestItemCategory">
				<i class="glyphicon glyphicon-list-alt"></i>
				<span><?php echo JText::_('K2_PUBLISHED_IN'); ?></span>
				<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
			</span>
			<?php endif; ?>

			<?php if($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
			<!-- Anchor link to comments below -->
				<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
					<!-- K2 Plugins: K2CommentsCounter -->
					<span class="latestItemCommentsLink">
						<i class="glyphicon glyphicon-comment"></i>
						<?php echo $this->item->event->K2CommentsCounter; ?>
					</span>
				<?php else: ?>
					<?php if($this->item->numOfComments > 0): ?>
					<a class="latestItemCommentsLink href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
						<i class="glyphicon glyphicon-comment"></i>
						<?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>
					</a>
					<?php else: ?>
					<a class="latestItemCommentsLink href="<?php echo $this->item->link; ?>#itemCommentsAnchor">
						<i class="glyphicon glyphicon-comment"></i>
						<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
					</a>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php } ?>

  <!-- Plugins: AfterDisplayTitle -->
  <?php echo $this->item->event->AfterDisplayTitle; ?>

  <!-- K2 Plugins: K2AfterDisplayTitle -->
  <?php echo $this->item->event->K2AfterDisplayTitle; ?>

  <div class="latestItemBody">

	  <!-- Plugins: BeforeDisplayContent -->
	  <?php echo $this->item->event->BeforeDisplayContent; ?>

	  <!-- K2 Plugins: K2BeforeDisplayContent -->
	  <?php echo $this->item->event->K2BeforeDisplayContent; ?>

	  <?php if($this->item->params->get('latestItemIntroText')): ?>
	  <!-- Item introtext -->
	  <div class="latestItemIntroText">
	  	<?php echo $this->item->introtext; ?>
	  </div>
	  <?php endif; ?>

		<div class="clr"></div>

	  <!-- Plugins: AfterDisplayContent -->
	  <?php echo $this->item->event->AfterDisplayContent; ?>

	  <!-- K2 Plugins: K2AfterDisplayContent -->
	  <?php echo $this->item->event->K2AfterDisplayContent; ?>

	  <div class="clr"></div>
  </div>

 
  <div class="latestItemLinks">

	  <?php if($this->item->params->get('latestItemTags') && count($this->item->tags)): ?>
	  <!-- Item tags -->
	  <div class="latestItemTagsBlock">
		  <i class="glyphicon glyphicon-tags"></i>
		  <span><?php echo JText::_('K2_TAGGED_UNDER'); ?></span>
		  <ul class="latestItemTags">
		    <?php foreach ($this->item->tags as $tag): ?>
		    <li><a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a></li>
		    <?php endforeach; ?>
		  </ul>
		  <div class="clr"></div>
	  </div>
	  <?php endif; ?>

		<div class="clr"></div>
  </div>

	<div class="clr"></div>

  <?php if($this->params->get('latestItemVideo') && !empty($this->item->video)): ?>
  <!-- Item video -->
  <div class="latestItemVideoBlock">
  	<h4 class="ot-title text-uppercase"><?php echo JText::_('K2_RELATED_VIDEO'); ?></h4>
	  <span class="latestItemVideo<?php if($this->item->videoType=='embedded'): ?> embedded<?php endif; ?>"><?php echo $this->item->video; ?></span>
  </div>
  <?php endif; ?>

	<?php if ($this->item->params->get('latestItemReadMore')): ?>
	<!-- Item "read more..." link -->
	<div class="latestItemReadMore">
		<a class="k2ReadMore btn btn-default" href="<?php echo $this->item->link; ?>">
			<?php echo JText::_('K2_READ_MORE'); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="clr"></div>

  <!-- Plugins: AfterDisplay -->
  <?php echo $this->item->event->AfterDisplay; ?>

  <!-- K2 Plugins: K2AfterDisplay -->
  <?php echo $this->item->event->K2AfterDisplay; ?>

	<div class="clr"></div>
	<?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
		</div>
	<?php endif; ?>
</div>
<hr/>
<!-- End K2 Item Layout -->
