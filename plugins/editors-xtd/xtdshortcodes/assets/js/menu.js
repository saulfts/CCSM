/**
*	@version	$Id: menu.js 5 2014-06-26 10:17:02Z linhnt $
*	@package	Jarvis Template Framework for Joomla!
*	@subpackage	shortcodes plugin for Joomla!
*	@copyright	Copyright (C) 2009 - 2014 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

(function($) {
	"use strict";

	var ShortcodeMenu = (function() {
		var _defaultOptions = {
			shortcodes: [],
			editor: ''
		};

		function ShortcodeMenu(element, options) {
			this.options = $.extend(_defaultOptions, options);
			this.wrapper = $('<div class="omg-shortcodes-menu" />');
			this.overlay = $('<div class="omg-shortcodes-overlay">');
			this.element = $(element);
			this.list    = $('<ul />');

			this.element.after(this.wrapper);
			this.wrapper.append(this.element);
			this.wrapper.append(this.overlay);
			this.create();
		};

		$.extend(ShortcodeMenu.prototype, {
			create: function() {
				var list = this.list;

				$.map(this.options.shortcodes, function(params, id) {
					list.append(
						$('<li />', { 'data-id': id, 'class': 'item item-' + id }).append(
							$('<a />', { href: 'javascript:void(0)', title: params.desc }).text(params.name)
						)
					);
				});

				this.element.after(list);
				this.element.on('click', this.toggle.bind(this));
				this.overlay.on('click', this.toggle.bind(this));

				this.list.on('click', 'a', this.insert.bind(this));
			},

			toggle: function(e) {
				e.preventDefault();

				this.wrapper.toggleClass('active');
				this.element.toggleClass('active');
			},

			insert: function(e) {
				var el = $(e.target),
						li = el.closest('li'),
						id = li.attr('data-id');

				if (this.options.shortcodes[id] !== undefined && this.options.editor != '') {
					jInsertEditorText(this.options.shortcodes[id].syntax, this.options.editor);
					this.element.trigger('click');
				}
			}
		});

		return ShortcodeMenu;
	})();

	$.fn['shortcodeMenu'] = function(options) {
		return this.each(function() {
			$(this).data('shortcodeMenu', new ShortcodeMenu(this, options));
		});
	};

}).call(this, jQuery);