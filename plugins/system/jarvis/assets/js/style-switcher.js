/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: style-switcher.js 37 2014-09-11 07:29:22Z linhnt $
 */
(function($) {
	"use strict";

	this.StyleSwitcher = (function() {
		function StyleSwitcher(options) {
			this.options = $.extend({
				templateURI: '',
				defaultColor: '',
				schemes: [],
				patterns: [],
				layout: 'full-width'
			}, options);

			this.templateConfig = {
				layout: this.options.layout,
				scheme: this.options.scheme,
				background: undefined
			};

			try {
				var config = JSON.parse($.cookie('_template_config'));
				if (config != null)
					this.templateConfig = $.extend(this.templateConfig, config);
			} catch(e) {}

			this.refresh();
			this.create();
		};

		StyleSwitcher.prototype = {
			create: function() {
				this.container	= $($('#style-switcher-template').html());
				this.toggler	= $('.toggler', this.container);
				this.reseter	= $('.reset', this.container);
				this.schemes	= $('.schemes-list', this.container);
				this.layout		= $('.layout-style', this.container);
				this.patterns   = $('.background-patterns', this.container);

				// Build schemes list
				$.map(this.options.schemes, (function(preset, id) {
					this.schemes.append(
						$('<label/>').append(
							$('<input/>', { 'type': 'radio', 'value': id, 'name': 'scheme' }),
							$('<span />', { 'style': 'background: ' + preset.color  })
						)
					);
				}).bind(this));

				// Build background patterns
				$.map(this.options.patterns, (function(file) {
					this.patterns.append(
						$('<label/>').append(
							$('<input/>', { 'type': 'radio', 'value': file, 'name': 'background' }),
							$('<span />', { 'style': 'background-image: url(' + this.options.templateURI + '/assets/images/patterns/' + file + ')'  })
						)
					);
				}).bind(this));

				this.container.find('form').populate(this.templateConfig);
				this.toggler.on('click', this.toggle.bind(this));
				this.reseter.on('click', this.reset.bind(this));
				this.container.on('change', 'form', this.change.bind(this));
			},

			toggle: function() {
				
        if ($('html').attr('dir') == 'rtl') {
          
          this.container.animate({
            right: parseInt(this.container.css('right'), 10) == 0 ? - this.container.outerWidth() : 0
          }, 1000, function(){});
        } else {
          this.container.animate({
            left: parseInt(this.container.css('left'), 10) == 0 ? - this.container.outerWidth() : 0
          }, 1000, function(){});
        }
        
        this.container.toggleClass('active');
			},

			reset: function() {
				$.cookie('_template_config', null);
				window.location.reload();
			},

			change: function(e) {
				this.templateConfig = {
					layout		: $('select[name="layout"]', this.container).val(),
					scheme		: $('input[name="scheme"][type="radio"]:checked', this.container).val(),
					background	: $('input[name="background"][type="radio"]:checked', this.container).val()
				};

				// Update template config
				this.refresh();

				$.cookie('_template_config', JSON.stringify(this.templateConfig));
			},

			refresh: function() {
				if (this.templateConfig.layout !== undefined) {
					$('body').removeClass('full-width boxed');
					$('body').addClass(this.templateConfig.layout);
					$('.section > div[class^="container"]').removeClass('container-fluid container');

					if (this.templateConfig.layout == 'full-width')
						$('.section > div').addClass('container');
					else
						$('.section > div').addClass('container-fluid');
				}

				if (this.templateConfig.scheme !== undefined)
					$('#template-scheme').attr('href', this.options.templateURI + '/assets/css/' + this.options.schemes[this.templateConfig.scheme].cssFile);

				if (this.templateConfig.background !== undefined)
					$('.body-bg').css('background-image', 'url(' + this.options.templateURI + '/assets/images/patterns/' + this.templateConfig.background + ')');
			}
		};

		var _instance;

		return {
			init: function(styles) {
				if (_instance == null) {
					_instance = new StyleSwitcher(styles);
					$('body').append(_instance.container);
          $(_instance.container).css(
          'top', 
          ($(window).height() - $(_instance.container).outerHeight() > 0)
          ? ($(window).height() - $(_instance.container).outerHeight()) / 2 : 0
          );
				}
			}
		}
	})();
}).call(this, jQuery);