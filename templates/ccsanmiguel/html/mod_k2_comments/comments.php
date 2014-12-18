<?php
/**
 * @version		$Id: comments.php 1492 2012-02-22 17:40:09Z joomlaworks@gmail.com $
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
	if (strpos( $params->get ('moduleclass_sfx'), 'autoplay')!==false){ ?>
		<script type="text/javascript">
		<!--
			jQuery.noConflict();
			jQuery(document).ready(function($) {
				$('#k2ModuleBox<?php echo $module->id; ?>').carousel();
			});
		-->
		</script>
	<?php }
}

?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2LatestCommentsBlock<?php echo $slide; ?>">
	
	<?php if(count($comments)): ?>
		<ul class="itemsList<?php echo $inner; ?>">
			<?php foreach ($comments as $key=>$comment):	?>
			<li class="item<?php echo count($comments)==$key+1 ? ' lastItem' : ''; echo $key==0 ? ' firstItem' : ''; echo (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide') && $key==0) ? " active" : ""; ?>">
				<?php echo (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide')) ? '<div class="col-xs-10  col-xs-offset-1">' : ''; ?>

					<!-- <span class="fa fa-quote-left"></span> -->
					<?php if($params->get('commentLink')): ?>
						<a href="<?php echo $comment->link; ?>"><span class="lcComment"><?php //echo '"' . $comment->commentText . '"'; ?><?php echo $comment->commentText; ?></span></a>
					<?php else: ?>
						<span class="lcComment"><?php //echo '"' . $comment->commentText . '"'; ?><?php echo $comment->commentText; ?></span>
					<?php endif; ?>
					<div class="clr"></div>
					
					<?php if($comment->userImage || $params->get('commenterName') || $params->get('commentDate')): ?>
						<div class="lcAdditionInfo">
							<?php if($comment->userImage): ?>
								<a class="k2Avatar lcAvatar" href="<?php echo $comment->link; ?>" title="<?php echo K2HelperUtilities::cleanHtml($comment->commentText); ?>">
									<img src="<?php echo $comment->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($comment->userName); ?>" style="width:<?php echo $lcAvatarWidth; ?>px;height:auto;" />
								</a>
							<?php endif; ?>

							<?php if($params->get('commenterName')): ?>
								<span class="lcUsername"><?php //echo JText::_('K2_WRITTEN_BY'); ?>
									<?php if(isset($comment->userLink)): ?>
										<a rel="author" href="<?php echo $comment->userLink; ?>"><?php echo $comment->userName; ?></a>
									<?php elseif($comment->commentURL): ?>
										<a target="_blank" rel="nofollow" href="<?php echo $comment->commentURL; ?>"><?php echo $comment->userName; ?></a>
									<?php else: ?>
										<?php echo $comment->userName; ?>
									<?php endif; ?>
								</span>
							<?php endif; ?>

							<?php if($params->get('commentDate')): ?>
								<div class="clr"></div>
								<span class="lcCommentDate">
									<?php if($params->get('commentDateFormat') == 'relative'): ?>
										<?php echo JText::_('TPL_OT_POSTED'); ?> 
										<?php echo $comment->commentDate; ?>
									<?php else: ?>
										<?php echo JText::_('K2_ON'); ?> <?php //echo JHTML::_('date', $comment->commentDate, JText::_('K2_DATE_FORMAT_LC2')); ?><?php echo JHTML::_('date', $comment->commentDate, JText::_('F jS Y')); ?>
									<?php endif; ?>
								</span>
							<?php endif; ?>
						</div>
						<div class="clr"></div>
					<?php endif; ?>

					<?php if($params->get('itemTitle')): ?>
						<span class="lcItemTitle"><a href="<?php echo $comment->itemLink; ?>"><?php echo $comment->title; ?></a></span>
					<?php endif; ?>

					<?php if($params->get('itemCategory')): ?>
						<span class="lcItemCategory">(<a href="<?php echo $comment->catLink; ?>"><?php echo $comment->categoryname; ?></a>)</span>
					<?php endif; ?>

					<div class="clr"></div>
				<?php echo (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide')) ? '</div>' : ''; ?> 
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="clearList"></div>
		<?php if (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide')!==false){?>
			<!-- "previous page" action -->
			<!-- <a class="carousel-control control-light control-box control-sm left" href="#k2ModuleBox<?php echo $module->id; ?>" data-slide="prev"><span class="glyphicon glyphicon-chevron-prev"></span></a> -->
			<!-- "next page" action -->
			<!-- <a class="carousel-control control-light control-box control-sm right" href="#k2ModuleBox<?php echo $module->id; ?>" data-slide="next"><span class="glyphicon glyphicon-chevron-next"></span></a> -->
			<ol class="carousel-indicators">
				<?php foreach ($comments as $key=>$comment):	?>
				<li data-target="#k2ModuleBox<?php echo $module->id; ?>" data-slide-to="<?php echo $key; ?>"<?php echo $key==0?' class="active"':''?>></li>
				<?php endforeach; ?>
			</ol>
		<?php } ?>
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
