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
<div class="latestItemView oeffect">

	<?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
		<!-- Item Image -->
		<div class="latestItemImage text-center">
			<a href="latestItemModal<?php echo $this->item->id; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" data-toggle="modal" data-target="#latestItemModal<?php echo $this->item->id; ?>">
				<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:auto;" />
			</a>
			<div class="clr"></div>
		</div>
	<?php endif; ?>
	<div class="latestItemDesc col-xs-12">		
		<div class="latestItemHeader">
			<?php if($this->item->params->get('latestItemTitle')): ?>
				<!-- Item title -->
				<h5 class="latestItemTitle">
					<a href="latestItemModal<?php echo $this->item->id; ?>" data-toggle="modal" data-target="#latestItemModal<?php echo $this->item->id; ?>">
						<?php echo $this->item->title; ?>
					</a>
				</h5>
				<div class="clr"></div>	
			<?php endif; ?>

			<?php if($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
				<!-- Anchor link to comments below -->
				<div class="latestItemComments pull-right">
					<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
						<!-- K2 Plugins: K2CommentsCounter -->
						<a class="img-circle glyphicon glyphicon-heart" data-toggle="tooltip" href="#" title="<?php echo $this->item->event->K2CommentsCounter; ?>"> </a>
					<?php else: ?>
						<?php if($this->item->numOfComments > 0): ?>
							<a class="img-circle glyphicon glyphicon-heart" data-toggle="tooltip" href="<?php echo $this->item->link; ?>#itemCommentsAnchor" title="<?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>"> </a>
						<?php else: ?>
							<a class="img-circle glyphicon glyphicon-heart" data-toggle="tooltip" href="<?php echo $this->item->link; ?>#itemCommentsAnchor" title="<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>"> </a>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			
			<?php if($this->item->params->get('latestItemDateCreated') || $this->item->params->get('latestItemCategory')): ?>
				<div class="latestItemInfo">
					<?php if($this->item->params->get('latestItemDateCreated')): ?>
						<!-- Date created -->
						<div class="latestItemDateCreated">
							<i class="glyphicon glyphicon-calendar"></i>
							<?php echo JHTML::_('date', $this->item->created , JText::_('K2_DATE_FORMAT_LC2')); ?>
						</div>
					<?php endif; ?>

					<?php if($this->item->params->get('latestItemCategory')): ?>
						<!-- Item category name -->
						<div class="latestItemCategory">
							<i class="glyphicon glyphicon-list-alt"></i>
							<?php echo JText::_('K2_PUBLISHED_IN'); ?>
							<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>			
		</div>

		<div class="clr"></div>
	</div>
</div>
<div id="latestItemModal<?php echo $this->item->id; ?>" class="modal fade">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="latestItemBody">
				<?php if($this->item->params->get('latestItemImage') && !empty($this->item->image)): ?>
					<!-- Item Image -->
					<div class="latestItemImage text-center">
						<a href="<?php echo $this->item->link; ?>" title="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>">
							<img src="<?php echo $this->item->image; ?>" alt="<?php if(!empty($this->item->image_caption)) echo K2HelperUtilities::cleanHtml($this->item->image_caption); else echo K2HelperUtilities::cleanHtml($this->item->title); ?>" style="width:<?php echo $this->item->imageWidth; ?>px;height:auto;" />
						</a>
						<div class="clr"></div>
					</div>
				<?php endif; ?>

				<div class="col-xs-12 col-sm-<?php echo ($this->item->params->get('latestItemImage') && !empty($this->item->image)) ? '5' : '12'; ?>">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;<!-- <i class="glyphicon glyphicon-remove-circle"></i> --></button>

					<!-- Plugins: BeforeDisplay -->
					<?php echo $this->item->event->BeforeDisplay; ?>

					<!-- K2 Plugins: K2BeforeDisplay -->
					<?php echo $this->item->event->K2BeforeDisplay; ?>
					
					<div class="latestItemHeader">
						<?php if($this->item->params->get('latestItemTitle')): ?>
							<!-- Item title -->
							<h5 class="latestItemTitle">
								<?php if ($this->item->params->get('latestItemTitleLinked')): ?>
									<a href="<?php echo $this->item->link; ?>">
										<?php echo $this->item->title; ?>
									</a>
								<?php else: ?>
									<?php echo $this->item->title; ?>
								<?php endif; ?>
							</h5>
							<div class="clr"></div>	
						<?php endif; ?>

						<?php if($this->item->params->get('latestItemCommentsAnchor') && ( ($this->item->params->get('comments') == '2' && !$this->user->guest) || ($this->item->params->get('comments') == '1')) ): ?>
							<!-- Anchor link to comments below -->
							<div class="latestItemComments pull-right">
								<?php if(!empty($this->item->event->K2CommentsCounter)): ?>
									<!-- K2 Plugins: K2CommentsCounter -->
									<a class="img-circle glyphicon glyphicon-heart" data-toggle="tooltip" href="#" title="<?php echo $this->item->event->K2CommentsCounter; ?>"> </a>
								<?php else: ?>
									<?php if($this->item->numOfComments > 0): ?>
										<a class="img-circle glyphicon glyphicon-heart" data-toggle="tooltip" href="<?php echo $this->item->link; ?>#itemCommentsAnchor" title="<?php echo $this->item->numOfComments; ?> <?php echo ($this->item->numOfComments>1) ? JText::_('K2_COMMENTS') : JText::_('K2_COMMENT'); ?>"> </a>
									<?php else: ?>
										<a class="img-circle glyphicon glyphicon-heart" data-toggle="tooltip" href="<?php echo $this->item->link; ?>#itemCommentsAnchor" title="<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>"> </a>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						<?php endif; ?>
						
						<?php if($this->item->params->get('latestItemDateCreated') || $this->item->params->get('latestItemCategory')): ?>
							<div class="latestItemInfo">
								<?php if($this->item->params->get('latestItemDateCreated')): ?>
									<!-- Date created -->
									<div class="latestItemDateCreated">
										<i class="glyphicon glyphicon-calendar"></i>
										<?php echo JHTML::_('date', $this->item->created , JText::_('K2_DATE_FORMAT_LC2')); ?>
									</div>
								<?php endif; ?>

								<?php if($this->item->params->get('latestItemCategory')): ?>
									<!-- Item category name -->
									<div class="latestItemCategory">
										<i class="glyphicon glyphicon-list-alt"></i>
										<?php echo JText::_('K2_PUBLISHED_IN'); ?>
										<a href="<?php echo $this->item->category->link; ?>"><?php echo $this->item->category->name; ?></a>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>			
					</div>
		
					<!-- Plugins: AfterDisplayTitle -->
					<?php echo $this->item->event->AfterDisplayTitle; ?>

					<!-- K2 Plugins: K2AfterDisplayTitle -->
					<?php echo $this->item->event->K2AfterDisplayTitle; ?>
					
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
					<div class="clr"></div>
					<?php endif; ?>

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
							<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('JLIB_HTML_BEHAVIOR_CLOSE'); ?></button>
						</div>
					<?php endif; ?>
					
					<!-- Plugins: AfterDisplay -->
					<?php echo $this->item->event->AfterDisplay; ?>

					<!-- K2 Plugins: K2AfterDisplay -->
					<?php echo $this->item->event->K2AfterDisplay; ?>
					
					<div class="clr"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End K2 Item Layout -->
