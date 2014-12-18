<?php
/**
*	@version	$Id: error.php 9 2013-03-21 09:47:13Z linhnt $
*	@package	OMG Responsive Template for Joomla! 2.5
*	@subpackage	template ot_smartsolutions
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die;
if (!isset($this->error))
{
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}
if (($this->error->getCode()) == '404') {
header('Location: '.$this->baseurl.'/index.php?option=com_content&view=article&id=2&Itemid=157');
// header('Location: '.$this->baseurl.'/index.php/404-page-not-found');
exit;
}
//get language and direction
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
	<meta name="HandheldFriendly" content="true" />
	<meta name="apple-mobile-web-app-capable" content="YES" />
	<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/error.css" type="text/css" />
	<?php if ($this->direction == 'rtl') : ?>
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/error_rtl.css" type="text/css" />
	<?php endif; ?>
	
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/assets/css/bootstrap.min.css" type="text/css" />
</head>
<body>
	<div class="container">
		<div class="row">
			<div id="content" class="col-lg-12 col-lg-reset col-md-12 col-md-reset col-sm-12 col-sm-reset col-xs-12 col-xs-reset">
				<!-- Begin Content -->
				<h1 class="page-header"><?php echo JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></h1>
				<div class="well">
					<div class="row">
						<div class="col-lg-6 col-lg-reset col-md-6 col-md-reset col-sm-6 col-sm-reset col-xs-12 col-xs-reset">
							<p><strong><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>
							<p><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>
							<ul>
								<li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
								<li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
								<li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
								<li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
							</ul>
						</div>
						<div class="col-lg-6 col-lg-reset col-md-6 col-md-reset col-sm-6 col-sm-reset col-xs-12 col-xs-reset">
							<?php if (JModuleHelper::getModule('search')) : ?>
								<p><strong><?php echo JText::_('JERROR_LAYOUT_SEARCH'); ?></strong></p>
								<p><?php echo JText::_('JERROR_LAYOUT_SEARCH_PAGE'); ?></p>
								<?php
									$module = JModuleHelper::getModule('search');
									echo JModuleHelper::renderModule($module);
								?>
							<?php endif; ?>
							<p><?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></p>
							<p><a href="<?php echo $this->baseurl; ?>/index.php" class="btn btn-default"><i class="glyphicon glyphicon-home"></i> <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
						</div>
					</div>
					<hr />
					<p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>
					<blockquote>
						<span class="label label-default"><?php echo $this->error->getCode(); ?></span> <?php echo $this->error->getMessage();?>
					</blockquote>
					<p>
						<?php if ($this->debug) :
							echo $this->renderBacktrace();
						endif; ?>
					</p>
				</div>
				<!-- End Content -->
			</div>
		</div>
	</div>
</body>
</html>
