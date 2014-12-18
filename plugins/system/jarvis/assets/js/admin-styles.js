/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-styles.js 34 2014-08-30 05:08:31Z linhnt $
 */
(function($) {
	"use strict";

	$.JarvisAdminStyles = function(parent, container) {
		this.parent = parent;
		this.container = container;

		this.popupOptions = {
			autoOpen: false,
			title: 'Edit Style',
			width: 490,
			modal: true,
			resizable: false,
			draggable: false
		};

		this.fontOptions = [];
		$.map(this.parent.options.fonts, $.proxy(function(value, index) {
			this.fontOptions.push('<option value="' + index + '">' + value.family + '</option>');
		}, this));

		this.customStylePanel = $('#jarvis-custom-styles');
		this.activeItem = null;
		this.activePopup = null;

		this.addEvents();
	};

	$.JarvisAdminStyles.prototype = {
		createPopup: function(data) {
			var
			self  = this,
			popup = $($('#edit-style-template').html());

			popup.dialog(
				$.extend({
					open: function(event, ui) {
						popup.find('select[name="font-family"]')
							.append($(self.fontOptions.join('')))
							// .val(data['font-family'])
							.chosen()
							.trigger('chosen:updated');

						popup.find('form').populate(data);

						// Initialize button-set
						popup.find('.jarvis-buttonset').buttonset();

						// Initialize color picker
						popup.find('.jarvis-color-picker').colorPicker();

						popup.on('click', '.jarvis-editor-toolbar button[data-command="cancel"]', $.proxy(self.cancelEditItem, self));
						popup.on('click', '.jarvis-editor-toolbar button[data-command="save"]', $.proxy(self.saveEditItem, self));

						popup.find('select[name="font-family"]').trigger('chosen:updated');
					},

					close: function() {
						// Destroy popup elements
						self.activePopup.find('.jarvis-color-picker button').each(function() {
							$('#' + $(this).data('colpickId')).remove();
						});

						self.activePopup.dialog('destroy');
						self.activePopup.remove();

						if (self.activeItem != null) {
							self.activeItem.removeClass('jarvis-active');
							self.activeItem = null;
						}
					}
				}, this.popupOptions)
			);

			popup.closest('.ui-dialog').addClass('jarvis');

			return popup;
		},

		addEvents: function() {
			this.container.on('click', '.jarvis-style-editor .jarvis-toolbox a[data-command]', function(e) {
				e.preventDefault();
			});

			this.container.on('click', '.jarvis-style-editor a[data-command="add"]', $.proxy(this.addItem, this));
			this.container.on('click', '.jarvis-style-editor .jarvis-toolbox a[data-command="edit"]', $.proxy(this.editItem, this));
			this.container.on('click', '.jarvis-style-editor .jarvis-toolbox a[data-command="dupplicate"]', $.proxy(this.dupplicateItem, this));
			this.container.on('click', '.jarvis-style-editor .jarvis-toolbox a[data-command="remove"]', $.proxy(this.removeItem, this));

			// this.parent.form.on('change', $.proxy(this.toggleCustomPanel, this));
		},

		addItem: function(e) {
			this.activeItem = null;
			this.activePopup = this.createPopup();
			this.activePopup.dialog('open');
		},

		editItem: function(e) {
			this.activeItem = $(e.target).closest('.jarvis-editor-item');
			this.activeItem.addClass('jarvis-active');

			try {
				var data = JSON.parse(this.activeItem.find('input:hidden').val());
			}
			catch(e) {
				var data = {};
			}

			this.activePopup = this.createPopup(data);
			this.activePopup.dialog('open');
		},

		cancelEditItem: function(e) {
			if (this.activePopup != null)
				this.activePopup.dialog('close');	
		},

		saveEditItem: function(e) {
			var
			data = this.activePopup.find('form').serializeForm(),
			item = $($('#style-item-template').html());

			item.find('.jarvis-editor-header h3').text(data['style-name']);
			item.find('input:hidden')
				.val(JSON.stringify(data))
				.attr('name', this.container.find('.jarvis-style-editor').attr('data-input-name'));

			// Create new item
			if (this.activeItem == null) {
				item.insertBefore(
					this.container.find('.jarvis-style-editor a[data-command="add"]')
				);
			}

			// Update existing item
			else {
				item.insertBefore(this.activeItem);
				this.activeItem.remove();
			}

			this.activePopup.dialog('close');
		},

		dupplicateItem: function(e) {
			var
			item = $(e.target).closest('.jarvis-editor-item');
			item.clone().insertAfter(item);
		},

		removeItem: function(e) {
			var
			item = $(e.target).closest('.jarvis-editor-item');

			if (confirm('Are you sure to remove style "' + item.find('.jarvis-editor-header h3').text() + '"?'))
				item.remove();
		}
	};

})(jQuery);