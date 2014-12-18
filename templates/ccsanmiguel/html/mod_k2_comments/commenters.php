<?php
/**
 * @version		$Id: commenters.php 1492 2012-02-22 17:40:09Z joomlaworks@gmail.com $
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

<?php if(count($commenters)): ?>
	<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2TopCommentersBlock<?php echo $slide; ?>">
		<ul class="itemsList<?php echo $inner; ?>">
			<?php foreach ($commenters as $key=>$commenter): ?>
				<li class="item<?php echo count($comments)==$key+1 ? ' lastItem' : ''; echo $key==0 ? ' firstItem' : ''; echo (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide') && $key==0) ? " active" : ""; ?>">
					<?php echo (strpos( $params->get ('moduleclass_sfx'), 'slide') && $key==0) ? '<div class="col-xs-10  col-xs-offset-1">' : ''; ?>

						<!-- <span class="fa fa-quote-left"></span> -->
						<?php if($commenter->userImage): ?>
							<a class="k2Avatar tcAvatar" rel="author" href="<?php echo $commenter->link; ?>">
								<img src="<?php echo $commenter->userImage; ?>" alt="<?php echo JFilterOutput::cleanText($commenter->userName); ?>" style="width:<?php echo $tcAvatarWidth; ?>px;height:auto;" />
							</a>
						<?php endif; ?>

						<?php if($params->get('commenterLink')): ?>
							<a class="tcLink" rel="author" href="<?php echo $commenter->link; ?>">
						<?php endif; ?>
								<span class="tcUsername"><?php echo $commenter->userName; ?></span>

								<?php if($params->get('commenterCommentsCounter')): ?>
									<span class="tcCommentsCounter">(<?php echo $commenter->counter; ?>)</span>
								<?php endif; ?>
						<?php if($params->get('commenterLink')): ?>
							</a>
						<?php endif; ?>

						<?php if($params->get('commenterLatestComment')): ?>
							<a class="tcLatestComment" href="<?php echo $commenter->latestCommentLink; ?>">
								<?php echo $commenter->latestCommentText; ?>
							</a>
							<span class="tcLatestCommentDate"><?php echo JText::_('K2_POSTED_ON'); ?> <?php echo JHTML::_('date', $commenter->latestCommentDate, JText::_('K2_DATE_FORMAT_LC2')); ?></span>
						<?php endif; ?>

						<div class="clr"></div>
					<?php echo (strpos( $params->get ('moduleclass_sfx'), 'slide') && $key==0) ? '</div>' : ''; ?>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php if (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide')!==false){?>
			<!-- "previous page" action -->
			<a class="carousel-control control-light control-box control-sm left" href="#k2ModuleBox<?php echo $module->id; ?>" data-slide="prev"><span class="ico-prev"></span></a>
			<!-- "next page" action -->
			<a class="carousel-control control-light control-box control-sm right" href="#k2ModuleBox<?php echo $module->id; ?>" data-slide="next"><span class="ico-next"></span></a>
		<?php } ?>
	</div>
<?php endif; ?>
