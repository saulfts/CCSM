<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();

JHtml::_('bootstrap.tooltip');
?>
<div class="clearfix"></div>
<div class="col-xs-12 col-sm-3">
	<!-- <i class="glyphicon glyphicon-search ot-color"></i> -->
	<img src="templates/ot_smartsolutions/assets/images/search_bg.png" />
</div>
<div class="col-xs-12 col-sm-9">

	<div class="searchintro<?php echo $this->params->get('pageclass_sfx'); ?>">
		<h4 class="ot-title text-uppercase"><?php echo JText::_('TPL_SEARCH_ERROR_SEARCH_NOT_FOUND'); ?></h4>
		<p><?php echo JText::_('TPL_SEARCH_ERROR_SEARCH_MSG_NOT_FOUND'); ?></p>
	</div>

	<form id="searchForm" class="form-inline" action="<?php echo JRoute::_('index.php?option=com_search');?>" method="post">

		<div class="btn-toolbar">
			<div class="btn-group pull-left">
				<input type="text" name="searchword" placeholder="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" id="search-searchword" size="30" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>" class="inputbox form-control" />
			</div>
			<div class="btn-group pull-left">
				<button name="Search" onclick="this.form.submit()" class="btn ot-bg ot-title text-uppercase hasTooltip" title="<?php echo JText::_('COM_SEARCH_SEARCH');?>">
					<!-- <span class="glyphicon glyphicon-search"></span> -->
					<?php echo JText::_('TPL_SEARCH_BUTTON'); ?>
				</button>
			</div>
			<input type="hidden" name="task" value="search" />
			<div class="clearfix"></div>
		</div>
		
		<div class="panel-heading">
			<h4 class="panel-title">
				<a href="#advanced-search" data-toggle="collapse" data-parent="#searchForm"><?php echo JText::_('TPL_SEARCH_ADVANCED_SEARCH'); ?></a>
			</h4>
		</div>
		<div id="advanced-search" class="panel-collapse collapse">
			<div class="panel-body">
				<fieldset class="phrases">
					<legend><?php echo JText::_('COM_SEARCH_FOR');?>
					</legend>
						<div class="phrases-box">
						<?php echo $this->lists['searchphrase']; ?>
						</div>
						<div class="ordering-box">
						<label for="ordering" class="ordering">
							<?php echo JText::_('COM_SEARCH_ORDERING');?>
						</label>
						<?php echo $this->lists['ordering'];?>
						</div>
				</fieldset>

				<?php if ($this->params->get('search_areas', 1)) : ?>
					<fieldset class="only">
					<legend><?php echo JText::_('COM_SEARCH_SEARCH_ONLY');?></legend>
					<?php foreach ($this->searchareas['search'] as $val => $txt) :
						$checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : '';
					?>
					<label for="area-<?php echo $val;?>" class="checkbox">
						<input type="checkbox" name="areas[]" value="<?php echo $val;?>" id="area-<?php echo $val;?>" <?php echo $checked;?> >
						<?php echo JText::_($txt); ?>
					</label>
					<?php endforeach; ?>
					</fieldset>
				<?php endif; ?>
			</div>
		</div>
	</form>
</div>
<div class="clearfix"></div>