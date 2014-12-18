<?php
/**
 * @version		$Id: default.php 1499 2012-02-28 10:28:38Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2012 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$slide = '';
$inner = '';
$cols = '';
$pwidth = '';
if (strpos( $params->get ('moduleclass_sfx'), 'slide')!==false){
	$slide = ' carousel slide';
	$inner = ' carousel-inner';
}
if (strpos( $params->get ('moduleclass_sfx'), 'cols')!==false){
	$class_sfx = explode(' ', $params->get ('moduleclass_sfx'));
	foreach ($class_sfx as $clsSfx){
		if (strpos( $clsSfx, 'cols')!==false){
			$cols = str_replace('cols', '', $clsSfx);
			$pwidth = ' col-xs-12 col-sm-' . floor (12 / $cols);
		}
	}
}
?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock<?php echo $slide; ?>">

	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
		<?php if (strpos( $params->get ('moduleclass_sfx'), 'slide')!==false){?>
			<!-- "previous page" action -->
			<a class="carousel-control control-light control-box left" href="#k2ModuleBox<?php echo $module->id; ?>" data-slide="prev"><span class="ico-prev"></span></a>
			<!-- "next page" action -->
			<a class="carousel-control control-light control-box right" href="#k2ModuleBox<?php echo $module->id; ?>" data-slide="next"><span class="ico-next"></span></a>
		<?php } ?>
	<div class="ot-items ot-blog<?php echo $inner; ?>">
		<div class="item<?php echo (strpos( $params->get ('moduleclass_sfx'), 'slide')) ? " active" : ""; ?>">
			<?php foreach ($items as $key=>$item):	?>
				<div class="k2ItemBlock<?php echo $pwidth; ?>">
					<div class="k2ItemBlock-i">
						
						<!-- Plugins: BeforeDisplay -->
						<?php echo $item->event->BeforeDisplay; ?>
						
						<!-- K2 Plugins: K2BeforeDisplay -->
						<?php echo $item->event->K2BeforeDisplay; ?>
						
						<?php if($params->get('itemAuthorAvatar')): ?>
							<a class="k2Avatar moduleItemAuthorAvatar" rel="author" href="<?php echo $item->authorLink; ?>">
								<img src="<?php echo $item->authorAvatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" style="width:<?php echo $avatarWidth; ?>px;height:auto;" />
							</a>
						<?php endif; ?>
						
						<div class="moduleItemIntro">
							
							<?php if($params->get('itemImage') && isset($item->image)): ?>
								<div class="moduleItemImage pull-left">
									<a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
										<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
									</a>
								</div>
							<?php endif; ?>

							<?php if($params->get('itemTitle')): ?>
								<h6 class="text-uppercase"><a class="moduleItemTitle" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a></h6>
							<?php endif; ?>
							
							<!-- Plugins: AfterDisplayTitle -->
							<?php echo $item->event->AfterDisplayTitle; ?>
							
							<!-- K2 Plugins: K2AfterDisplayTitle -->
							<?php echo $item->event->K2AfterDisplayTitle; ?>
							
							<!-- Plugins: BeforeDisplayContent -->
							<?php echo $item->event->BeforeDisplayContent; ?>
							
							<!-- K2 Plugins: K2BeforeDisplayContent -->
							<?php echo $item->event->K2BeforeDisplayContent; ?>
							
							<?php if($params->get('itemIntroText')): ?>
								<div class="moduleItemIntrotext">
									<?php echo $item->introtext; ?>
								</div>
								<div class="clr"></div>
							<?php endif; ?>
							
							<?php if($params->get('itemDateCreated') || $params->get('itemAuthor') || $params->get('itemCategory') || $params->get('itemHits') || ($params->get('itemCommentsCounter') && $componentParams->get('comments'))){ ?>
								<div class="moduleItemAddition">
									<?php if($params->get('itemDateCreated')): ?>
										<span class="moduleItemDateCreated">
											<i class="glyphicon glyphicon-calendar"></i>
											<?php echo JHTML::_('date', $item->created, JText::_('K2_DATE_FORMAT_LC2')); ?>
										</span>
									<?php endif; ?>
									
									<?php if($params->get('itemAuthor')): ?>
										<!--<div class="moduleItemAuthor">--><span class="moduleItemAuthor">
											<i class="glyphicon glyphicon-user"></i>
											<?php echo K2HelperUtilities::writtenBy($item->authorGender); ?>
											
											<?php if(isset($item->authorLink)): ?>
												<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><?php echo $item->author; ?></a>
											<?php else: ?>
												<?php echo $item->author; ?>
											<?php endif; ?>
											
											<?php if($params->get('userDescription')): ?>
												<?php echo $item->authorDescription; ?>
											<?php endif; ?>
										</span><!--</div>-->
									<?php endif; ?>
									
									<?php if($params->get('itemCategory')): ?>
										<span>
											<i class="glyphicon glyphicon-list-alt"></i>
											<?php echo JText::_('K2_IN') ; ?>
											<a class="moduleItemCategory" href="<?php echo $item->categoryLink; ?>"><?php echo $item->categoryname; ?></a>
										</span>
									<?php endif; ?>
									
									<?php if($params->get('itemHits')): ?>
										<span class="moduleItemHits">
											<i class="glyphicon glyphicon-eye-open"></i>
											<?php echo JText::_('K2_READ'); ?> <?php echo $item->hits; ?> <?php echo JText::_('K2_TIMES'); ?>
										</span>
									<?php endif; ?>
								</div>
							<?php } ?>
							
							<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>		
								<?php if(!empty($item->event->K2CommentsCounter)): ?>
									<!-- K2 Plugins: K2CommentsCounter -->
									<i class="glyphicon glyphicon-comment"></i>
									<?php echo $item->event->K2CommentsCounter; ?>
								<?php else: ?>
									<?php if($item->numOfComments>0): ?>
										<a class="moduleItemComments" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
											<i class="glyphicon glyphicon-comment"></i>
											<?php echo $item->numOfComments; ?> <?php if($item->numOfComments>1) echo JText::_('K2_COMMENTS'); else echo JText::_('K2_COMMENT'); ?>
										</a>
									<?php else: ?>
										<a class="moduleItemComments" href="<?php echo $item->link.'#itemCommentsAnchor'; ?>">
											<i class="glyphicon glyphicon-comment"></i>
											<?php echo JText::_('K2_BE_THE_FIRST_TO_COMMENT'); ?>
										</a>
									<?php endif; ?>
								<?php endif; ?>
								<div class="clr"></div>
							<?php endif; ?>
							
							<?php if($params->get('itemTags') && count($item->tags)>0): ?>
								<div class="moduleItemTags">
									<i class="glyphicon glyphicon-tags"></i>
									<b><?php echo JText::_('K2_TAGS'); ?>:</b>
									<?php foreach ($item->tags as $tag): ?>
										<a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							
							<?php if($params->get('itemAttachments') && count($item->attachments)): ?>
								<div class="moduleAttachments">
									<i class="glyphicon glyphicon-paperclip"></i>
									<?php foreach ($item->attachments as $attachment): ?>
										<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
							
							<?php if($params->get('itemExtraFields') && count($item->extra_fields)): ?>
								<div class="moduleItemExtraFields">
									<b><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></b>
									<ul>
										<?php foreach ($item->extra_fields as $extraField): ?>
											<?php if($extraField->value): ?>
												<li class="type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
													<span class="moduleItemExtraFieldsLabel"><?php echo $extraField->name; ?></span>
													<span class="moduleItemExtraFieldsValue"><?php echo $extraField->value; ?></span>
													<div class="clr"></div>
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</div>
								<div class="clr"></div>
							<?php endif; ?>
							
							<?php if($params->get('itemReadMore') && $item->fulltext): ?>
								<a class="moduleItemReadMore btn btn-default" href="<?php echo $item->link; ?>">
									<?php echo JText::_('K2_READ_MORE'); ?>
								</a>
								<div class="clr"></div>
							<?php endif; ?>
						</div>
						
						<?php if($params->get('itemVideo')): ?>
							<div class="moduleItemVideo">
								<?php echo $item->video ; ?>
								<span class="moduleItemVideoCaption"><?php echo $item->video_caption ; ?></span>
								<span class="moduleItemVideoCredits"><?php echo $item->video_credits ; ?></span>
							</div>
							<div class="clr"></div>
						<?php endif; ?>
						
						<!-- Plugins: AfterDisplayContent -->
						<?php echo $item->event->AfterDisplayContent; ?>
						
						<!-- K2 Plugins: K2AfterDisplayContent -->
						<?php echo $item->event->K2AfterDisplayContent; ?>
						
						<!-- Plugins: AfterDisplay -->
						<?php echo $item->event->AfterDisplay; ?>
						
						<!-- K2 Plugins: K2AfterDisplay -->
						<?php echo $item->event->K2AfterDisplay; ?>
						
						<div class="clr"></div>
					</div>
				</div>
				<?php if ($cols!=='') { 
					if (($key+1)%$cols==false && $key+1 < count($items)) {
						echo '<div class="clr"></div><hr /></div><div class="item">';
					}
				} else {
					if ($key+1 < count($items)) {
						echo '<div class="clr"></div><hr /></div><div class="item">';
					}
				} ?>
			<?php endforeach; ?>
			<div class="clr"></div>
		</div>
	</div>
	<?php endif; ?>

	<?php if($params->get('itemCustomLink')): ?>
		<a class="moduleCustomLink" href="<?php echo $params->get('itemCustomLinkURL'); ?>" title="<?php echo K2HelperUtilities::cleanHtml($itemCustomLinkTitle); ?>"><?php echo $itemCustomLinkTitle; ?></a>
	<?php endif; ?>

	<?php if($params->get('feed')): ?>
		<div class="k2FeedIcon">
			<a href="<?php echo JRoute::_('index.php?option=com_k2&view=itemlist&format=feed&moduleID='.$module->id); ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
				<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
			</a>
			<div class="clr"></div>
		</div>
	<?php endif; ?>

</div>
