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
if (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide')!==false){
	$slide = ' carousel slide';
	$inner = ' carousel-inner';
	?>
	<script type="text/javascript">
	<!--
		jQuery.noConflict();
		jQuery(document).ready(function($) {
			$('#k2ModuleBox<?php echo $module->id; ?> .ot-items<?php echo $module->id; ?>').carousel({
				interval: 5000
			});
			$('#k2ModuleBox<?php echo $module->id; ?> .ot-items<?php echo $module->id; ?>').on('slid.bs.carousel', function (e) {
				$(this).find('.item .moduleItemOverlay .oeffect').removeClass('oactive');
				$(this).find('.item.active .moduleItemOverlay .oeffect').addClass('oactive');
			});
		});
	-->
	</script>
<?php } ?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock ot-single">

	<?php if($params->get('itemPreText')): ?>
	<p class="modulePretext"><?php echo $params->get('itemPreText'); ?></p>
	<?php endif; ?>

	<?php if(count($items)): ?>
	<div class="ot-items<?php echo $module->id; ?><?php echo $slide; ?>">
		<div class="ot-items-i<?php echo $inner; ?>" >
			<?php foreach ($items as $key=>$item):	?>
				<div class="item<?php echo (strpos($params->get ('moduleclass_sfx'), 'carousel-slide')!==false && $key==0) ?' active' : '';?>">
					<?php if (!isset($item->image)) {					
						if ($item->introtext) {
							preg_match_all('/<img src=\"(?P<src>.+?)\"[^>]+\>/i', $item->introtext, $image_f);
							// var_dump($image_f);
							if ($image_f[1]) {
								$item->image = $image_f[1][0];
								$item->introtext = preg_replace("/<img[^>]+\>/i", "", $item->introtext,1);
							}
						}						
					} ?>
					<?php if($params->get('itemImage') && isset($item->image)): ?>
						<div class="moduleItemImage">
							<a href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
								<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>" style="width:100%;" />
							</a>
						</div>
					<?php endif; ?>
					<?php if($params->get('itemTitle') || $params->get('itemIntroText')): ?>
						<div class="container<?php echo ($params->get('itemImage') && isset($item->image)) ? ' moduleItemOverlay' : ''; ?>">
							<div class="col-xs-12">
								<?php if($params->get('itemAuthorAvatar')): ?>
									<a class="k2Avatar moduleItemAuthorAvatar" rel="author" href="<?php echo $item->authorLink; ?>">
										<img src="<?php echo $item->authorAvatar; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" style="width:<?php echo $avatarWidth; ?>px;height:auto;" />
									</a>
									<div class="clr"></div>
								<?php endif; ?>
								<?php if($params->get('itemTitle')): ?>
									<a class="moduleItemTitle<?php echo (strpos($params->get ('moduleclass_sfx'), 'carousel-slide')!==false && $key==0) ?' oactive' : '';?> oeffect otop" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
									<div class="clr"></div>
								<?php endif; ?>
								<?php if($params->get('itemAuthor') || $params->get('itemDateCreated') || $params->get('itemCategory')): ?>
									<div class="moduleItemAddition<?php echo (strpos($params->get ('moduleclass_sfx'), 'carousel-slide')!==false && $key==0) ?' oactive' : '';?> oeffect oright">
										<?php if($params->get('itemAuthor')): ?>
											<span class="moduleItemAuthor">
												<i class="glyphicon glyphicon-user"></i>
												<?php echo K2HelperUtilities::writtenBy($item->authorGender); ?>
												<?php if(isset($item->authorLink)): ?>
													<a rel="author" title="<?php echo K2HelperUtilities::cleanHtml($item->author); ?>" href="<?php echo $item->authorLink; ?>"><?php echo $item->author; ?></a>
												<?php else: ?>
													<?php echo $item->author; ?>
												<?php endif; ?>
											</span>
										<?php endif; ?>
										<?php if($params->get('itemDateCreated')): ?>
											<span class="moduleItemDateCreated">
												<i class="glyphicon glyphicon-calendar"></i>
												<?php echo JText::_('K2_WRITTEN_ON') ; ?> <?php echo JHTML::_('date', $item->created, JText::_('K2_DATE_FORMAT_LC2')); ?>
											</span>
										<?php endif; ?>
										<?php if($params->get('itemCategory')): ?>
											<span class="moduleItemCategory">
												<i class="glyphicon glyphicon-list-alt"></i>
												<?php echo JText::_('K2_IN') ; ?> <a href="<?php echo $item->categoryLink; ?>"><?php echo $item->categoryname; ?></a>
											</span>
										<?php endif; ?>
									</div>
									<div class="clr"></div>
								<?php endif; ?>
								<?php if($params->get('itemIntroText')): ?>
									<div class="moduleItemIntrotext<?php echo (strpos($params->get ('moduleclass_sfx'), 'carousel-slide')!==false && $key==0) ?' oactive' : '';?> oeffect obottom">
										<?php echo $item->introtext; ?>
									</div>
									<div class="clr"></div>
								<?php endif; ?>
								<?php if(($params->get('itemTags') && count($item->tags)>0) || ($params->get('itemAttachments') && count($item->attachments)) || ($params->get('itemCommentsCounter') && $componentParams->get('comments')) || ($params->get('itemHits'))): ?>
									<div class="moduleItemEx">
										<?php if($params->get('itemTags') && count($item->tags)>0): ?>
											<div class="moduleItemTags">
												<i class="glyphicon glyphicon-tags"></i>
												<b><?php echo JText::_('K2_TAGS'); ?>:</b>
												<?php foreach ($item->tags as $tag): ?>
													<a href="<?php echo $tag->link; ?>"><?php echo $tag->name; ?></a>
												<?php endforeach; ?>
											</div>
											<div class="clr"></div>
										<?php endif; ?>
										<?php if($params->get('itemAttachments') && count($item->attachments)): ?>
											<div class="moduleItemAttachments">
												<i class="glyphicon glyphicon-paperclip"></i>
												<?php foreach ($item->attachments as $attachment): ?>
													<a title="<?php echo K2HelperUtilities::cleanHtml($attachment->titleAttribute); ?>" href="<?php echo $attachment->link; ?>"><?php echo $attachment->title; ?></a>
												<?php endforeach; ?>
											</div>
											<div class="clr"></div>
										<?php endif; ?>
										<?php if($params->get('itemCommentsCounter') && $componentParams->get('comments')): ?>
											<?php if(!empty($item->event->K2CommentsCounter)): ?>
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
										<?php endif; ?>
										<?php if($params->get('itemHits')): ?>
											<span class="moduleItemHits">
												<i class="glyphicon glyphicon-eye-open"></i>
												<?php echo JText::_('K2_READ'); ?> <?php echo $item->hits; ?> <?php echo JText::_('K2_TIMES'); ?>
											</span>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if($params->get('itemReadMore') && $item->fulltext): ?>
									<br />
									<a class="moduleItemReadMore" href="<?php echo $item->link; ?>">
										<?php echo JText::_('K2_READ_MORE'); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide')!==false){?>
			<!-- "previous page" action -->
			<!-- <a class="left carousel-control" href="#k2ModuleBox<?php echo $module->id; ?>>.ot-items<?php echo $module->id; ?>" data-slide="prev"><i class="glyphicon glyphicon-chevron-left"></i></a> -->
			<!-- "next page" action -->
			<!-- <a class="right carousel-control" href="#k2ModuleBox<?php echo $module->id; ?>>.ot-items<?php echo $module->id; ?>" data-slide="next"><i class="glyphicon glyphicon-chevron-right"></i></a> -->
			<ol class="carousel-indicators ot_slidenav">
				<?php foreach ($items as $key=>$item):	?>
				<li data-target="#k2ModuleBox<?php echo $module->id; ?>>.ot-items<?php echo $module->id; ?>" data-slide-to="<?php echo $key; ?>" class="ot-square<?php echo $key==0?' active':''?>"></li>
				<?php endforeach; ?>
			</ol>
		<?php } ?>
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
