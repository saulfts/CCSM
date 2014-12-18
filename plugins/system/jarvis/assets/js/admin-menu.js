/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-menu.js 34 2014-08-30 05:08:31Z linhnt $
 */
(function($) {
	"use strict";

	$.JarvisAdminMenu = function(parent, container) {
		this.container = container;
		this.currentState = false;

		this.addEvents();
	};

	$.JarvisAdminMenu.prototype = {
		addEvents: function() {
			this.container.find('button[data-command="toggleAll"]').on('click', $.proxy(this.toggleAll, this));
			this.container.find('input[data-command="toggleAllGroup"]').on('change', $.proxy(this.toggleAllGroup, this));
			this.container.find('.jarvis-menu-item :checkbox').on('change', $.proxy(this.itemStateChanged, this));
		},

		toggleAll: function() {
			this.currentState == false
				? this.setState(this.container.find(':checkbox'), this.currentState = true)
				: this.setState(this.container.find(':checkbox'), this.currentState = false);
		},

		toggleAllGroup: function(e) {
			this.setState(
				$(e.target).closest('.jarvis-menu-type').find('.jarvis-menu-item :checkbox'), 
				e.target.checked
			);
		},

		itemStateChanged: function(e) {
			var
			parent = $(e.target).closest('.jarvis-menu-type');

			this.setState(
				parent.find('input[data-command="toggleAllGroup"]'),
				parent.find('.jarvis-menu-item :checkbox:checked').size() == parent.find('.jarvis-menu-item :checkbox').size());
		},

		setState: function(checkboxes, checked) {
			checkboxes.each(function() {
				this.checked = checked;
			});
		}
	};
})(jQuery);