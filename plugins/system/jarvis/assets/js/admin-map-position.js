/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin-map-position.js 34 2014-08-30 05:08:31Z linhnt $
 */
(function($) {
	"use strict";

	var MapPosition = function(button, options) {
		var self = this;

		this.button = button;
		this.opts = $.extend({
			active: 'none',
			activeStyle: 'none',
			positions: [],
			selected: function() {},
			template: ''
		}, options);

		this.positionOptions = function(search) {
			var
			options = '<option value="none">[None]</option>';

			if (self.opts.active == 'none')
				options = '<option value="none" selected>[None]</option>';

			options+= '<option value="component">[Component]</option>';
			options+= '<option value="system-message">[System Message]</option>';

			self.opts.positions.forEach(function(value) {
				if (search === undefined || value.indexOf(search) != -1) {
					if (self.opts.active == value)
						options += '<option value="' + value + '" selected>' + value + '</option>';
					else
						options += '<option value="' + value + '">' + value + '</option>';
				}
			});

			return options;
		};

		this.moduleStyles = function() {
			var
			options = '';
			$.each(_jarvisChromeStyles, function(index, value) {
					if (self.opts.activeStyle == value)
						options += '<option value="' + value + '" selected>' + value + '</option>';
					else
						options += '<option value="' + value + '">' + value + '</option>';
			});

			return options;
		};

		this.openPopup();
	};

	MapPosition.prototype = {
		popupOpened: function(event, ui) {
			var
			self = this,
			popup = this.popup;
			popup.find('input[name="position-filter"]').on('keyup change', function(e) {
				popup.find('select[name="position"]')
					.empty()
					.append(self.positionOptions($(this).val()));
			});

			popup.find('input[name="position-filter"]').on('keydown', function(e) {
				if (e.keyCode == 13) {
					e.preventDefault();

					if ($(this).val() != '') {
						self.addPosition($(this).val());
					}
				}
			});

			popup.find('select[name="position"]')
				.append(self.positionOptions());

			popup.find('select[name="style"]')
				.append(self.moduleStyles());

			popup.on('click', '[data-command="cancel"]', function() {
				popup.dialog('close');
			});

			popup.on('click', '[data-command="addPosition"]', function() {
				var input = popup.find('input[name="position-filter"]');

				if (input.val() != '') {
					self.addPosition(input.val());
				}
			});

			popup.on('click', '[data-command="save"]', function() {
				var selected = popup.find('select[name="position"]').val(),
						style = popup.find('select[name="style"]').val();

				self.opts.selected.call(this, selected, style);
				popup.dialog('close');
			});
		},

		addPosition: function(name) {
			if (this.opts.positions.indexOf(name) == -1) {
				this.opts.active = name;
				this.opts.positions.push(name);
				this.popup.find('select[name="position"]')
						.empty()
						.append(this.positionOptions(name));

				$.post('index.php?action=jarvis.addPosition&template=' + this.opts.template, {
					name: name
				}, function(response) {
				});
			}
		},

		openPopup: function() {
			var
			self = this;

			this.popup = $($('#map-position-template').html());
			this.popup.dialog({
				title: 'Map Position',
				modal: true,
				width: 517,
				open: $.proxy(this.popupOpened, this),

				close: $.proxy(function() {
					// Destroy popup elements
					this.popup.dialog('destroy');
					this.popup.remove();
				}, this)
			});

			this.popup.closest('.ui-dialog').addClass('jarvis');
		}
	};

	/**
	 * Register jquery plugin
	 */
	$.fn['mapPosition'] = function(options) {
		return this.each(function() {
			$(this).data('mapPosition',
				new MapPosition($(this), options)
			);
		});
	};

})(jQuery);