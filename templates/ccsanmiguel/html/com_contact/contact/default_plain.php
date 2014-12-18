<?php
/**
* @package     Joomla.Site
* @subpackage  com_contact
*
* @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
* @license     GNU General Public License version 2 or later; see LICENSE.txt
*/

defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams('com_media');

//jimport('joomla.html.html.bootstrap'); // not need ???
?>

		<div class="row">
			<div class="<?php echo ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) ? 'col-sm-4 col-sm-push-8' : 'col-sm-12'; ?>">
				<h4 class="ot-title text-uppercase"><?php echo JText::_('TPL_CONTACT_DETAILS'); ?></h4>
				<?php if ($this->contact->image && $this->params->get('show_image')) : ?>
					<div class="thumbnail img-thumbnail pull-right">
						<?php echo JHtml::_('image', $this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array('align' => 'middle')); ?>
					</div>
					<div class="clearfix"></div>
				<?php endif; ?>

				<?php if ($this->contact->con_position && $this->params->get('show_position')) : ?>
					<address class="contact-position">
						<?php echo $this->contact->con_position; ?>
					</address>
					<div class="clearfix"></div>
				<?php endif; ?>

				<?php // echo $this->loadTemplate('address'); ?>
				<?php echo $this->loadTemplate('plainaddress'); ?>

				<?php if ($this->params->get('allow_vcard')) :	?>
					<?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS');?>
					<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id='.$this->contact->id . '&amp;format=vcf'); ?>">
						<?php echo JText::_('COM_CONTACT_VCARD');?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>
				<div class="col-sm-8 col-sm-pull-4">
					<h4 class="ot-title text-uppercase"><?php echo JText::_('TPL_CONTACT_EMAIL_FORM'); ?></h4>
					<?php  echo $this->loadTemplate('form');  ?>
					<div class="clearfix"></div>
				</div>
			<?php endif; ?>
		</div>

		<?php if ($this->params->get('show_links')) : ?>
			<?php echo $this->loadTemplate('links'); ?>
		<?php endif; ?>

		<?php if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>		
			<h4 class="ot-title text-uppercase"><?php echo JText::_('JGLOBAL_ARTICLES');  ?></h4>
			<?php echo $this->loadTemplate('articles'); ?>
			<div class="clearfix"></div>
		<?php endif; ?>
		
		<?php if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>
			<h4 class="ot-title text-uppercase"><?php echoJText::_('COM_CONTACT_PROFILE');  ?></h4>
			<?php echo $this->loadTemplate('profile'); ?>
			<div class="clearfix"></div>
		<?php endif; ?>
		
		<?php if ($this->contact->misc && $this->params->get('show_misc')) : ?>
			<h4 class="ot-title text-uppercase"><?php echo JText::_('COM_CONTACT_OTHER_INFORMATION');  ?></h4>
			<div class="contact-miscinfo">
				<dl class="dl-horizontal">
					<dt>
						<span class="<?php echo $this->params->get('marker_class'); ?>">
							<?php echo $this->params->get('marker_misc'); ?>
						</span>
					</dt>
					<dd>
						<span class="contact-misc">
							<?php echo $this->contact->misc; ?>
						</span>
					</dd>
				</dl>
			</div>
			<div class="clearfix"></div>
		<?php endif; ?>
