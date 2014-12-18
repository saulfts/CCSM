<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_banners
 * @copyright	Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

require_once JPATH_ROOT . '/components/com_banners/helpers/banner.php';
$baseurl = JURI::base();
?>

<?php
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
				$('#bannergroup-<?php echo $module->id; ?>').carousel();
			});
		-->
		</script>
	<?php }
}
?>

<div id="bannergroup-<?php echo $module->id; ?>" class="bannergroup">
	<?php if ($headerText) : ?>
		<div class="bannerheader">
			<?php echo $headerText; ?>
		</div>
	<?php endif; ?>

	<div class="ot-items<?php echo $slide; ?>">
		<div class="ot-items-i<?php echo $inner; ?>">
			<?php foreach($list as $key=>$item):?>
				<div class="banneritem item<?php echo strpos( $params->get ('moduleclass_sfx'), 'carousel-slide')!==false?$key==0?' active':'':'';?> text-center">
					<?php $link = JRoute::_('index.php?option=com_banners&task=click&id='. $item->id);?>
					<?php if($item->type==1) :?>
						<?php // Text based banners ?>
						<?php echo str_replace(array('{CLICKURL}', '{NAME}'), array($link, $item->name), $item->custombannercode);?>
					<?php else:?>
						<?php $imageurl = $item->params->get('imageurl');?>
						<?php $width = $item->params->get('width');?>
						<?php $height = $item->params->get('height');?>
						<?php if (BannerHelper::isImage($imageurl)) :?>
							<?php // Image based banner ?>
							<?php $alt = $item->params->get('alt');?>
							<?php $alt = $alt ? $alt : $item->name ;?>
							<?php $alt = $alt ? $alt : JText::_('MOD_BANNERS_BANNER') ;?>
							<?php if ($item->clickurl) :?>
								<?php // Wrap the banner in a link?>
								<?php $target = $params->get('target', 1);?>
								<?php if ($target == 1) :?>
									<?php // Open in a new window?>
									<a
										href="<?php echo $link; ?>" target="_blank"
										title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
										<img
											src="<?php echo $baseurl . $imageurl;?>"
											alt="<?php echo $alt;?>"
											<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
											<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
											<?php if (strpos( $params->get ('moduleclass_sfx'), 'autofit')!==false) echo 'style="width: 100%;"';?>
										/>
									</a>
								<?php elseif ($target == 2):?>
									<?php // open in a popup window?>
									<a
										href="<?php echo $link;?>" onclick="window.open(this.href, '',
											'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550');
											return false"
										title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
										<img
											src="<?php echo $baseurl . $imageurl;?>"
											alt="<?php echo $alt;?>"
											<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
											<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
											<?php if (strpos( $params->get ('moduleclass_sfx'), 'autofit')!==false) echo 'style="width: 100%;"';?>
										/>
									</a>
								<?php else :?>
									<?php // open in parent window?>
									<a
										href="<?php echo $link;?>"
										title="<?php echo htmlspecialchars($item->name, ENT_QUOTES, 'UTF-8');?>">
										<img
											src="<?php echo $baseurl . $imageurl;?>"
											alt="<?php echo $alt;?>"
											<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
											<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
											<?php if (strpos( $params->get ('moduleclass_sfx'), 'autofit')!==false) echo 'style="width: 100%;"';?>
										/>
									</a>
								<?php endif;?>
							<?php else :?>
								<?php // Just display the image if no link specified?>
								<img
									src="<?php echo $baseurl . $imageurl;?>"
									alt="<?php echo $alt;?>"
									<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
									<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
											<?php if (strpos( $params->get ('moduleclass_sfx'), 'autofit')!==false) echo 'style="width: 100%;"';?>
								/>
							<?php endif;?>
						<?php elseif (BannerHelper::isFlash($imageurl)) :?>
							<object
								classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
								codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
								<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
								<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
							>
								<param name="movie" value="<?php echo $imageurl;?>" />
								<embed
									src="<?php echo $imageurl;?>"
									loop="false"
									pluginspage="http://www.macromedia.com/go/get/flashplayer"
									type="application/x-shockwave-flash"
									<?php if (!empty($width)) echo 'width ="'. $width.'"';?>
									<?php if (!empty($height)) echo 'height ="'. $height.'"';?>
								/>
							</object>
						<?php endif;?>
					<?php endif;?>
					<div class="clr"></div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if (strpos( $params->get ('moduleclass_sfx'), 'carousel-slide')!==false){ ?>
			<div class="ot_indicators">
				<ol class="carousel-indicators">
					<?php foreach($list as $key=>$item):?>
						<li data-target="#bannergroup-<?php echo $module->id; ?>" data-slide-to="<?php echo $key; ?>" class="ot-square center<?php echo $key==0?' active':'';?>" ></li>
					<?php endforeach;?>
				</ol>
			</div>
		<?php } ?>
	</div>

	<?php if ($footerText) : ?>
		<div class="bannerfooter">
			<?php echo $footerText; ?>
		</div>
	<?php endif; ?>
</div>
