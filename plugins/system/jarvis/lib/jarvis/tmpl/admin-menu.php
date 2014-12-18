<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-menu.php 14 2014-07-17 04:49:10Z linhnt $
 */
?>
<div class="jarvis-section">
	<div class="jarvis-section-header">
		<h3><?php echo JText::_('JARVIS_HEADING_MENU_ASSIGNMENT'); ?></h3>
		<p><?php echo JText::_('JARVIS_MENU_ASSIGNMENT_OPTIONS_DESC'); ?></p>
	</div>

	<button type="button" class="jarvis-button jarvis-button-blue" data-command="toggleAll"><?php echo JText::_('JARVIS_BUTTON_TOGGLE_MENU_SELECTION'); ?></button>
	<ul class="jarvis-menus-assignment">
		<?php foreach (MenusHelper::getMenuLinks() as $menuType): ?>
		<li class="jarvis-menu-type">
			<ul id="menu-type-<?php echo $menuType->menutype ?>">
				<li class="jarvis-menu-type-header">
					<label class="jarvis-checkbox">
						<input type="checkbox" data-command="toggleAllGroup" />
						<?php echo !empty($menuType->title) ? $menuType->title : $menuType->menutype; ?>
					</label>
				</li>

				<?php foreach ($menuType->links as $link): ?>
				<li class="jarvis-menu-item">
					<?php $checked = $link->template_style_id == $styleId ? 'checked' : '' ?>
                    <?php $user = JFactory::getUser(); ?>
					<?php $disabled = !empty($link->checked_out) && $link->checked_out != $user->id ? 'disabled' : '' ?>
					<label class="jarvis-checkbox">
						<input type="checkbox" name="jform[assigned][]"
							value="<?php echo (int) $link->value ?>"
							class="menu-item"
							<?php echo $checked ?>
							<?php echo $disabled ?>
						/>
						<span data-prefix="<?php echo str_repeat('- ', $link->level) ?>">
							<?php echo $link->text ?>
						</span>
					</label>
				</li>
				<?php endforeach ?>
			</ul>
		</li>
		<?php endforeach ?>
	</ul>
</div>