/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: admin.js 34 2014-08-30 05:08:31Z linhnt $
 */
(function ($) {
	"use strict";

	/**
	 * Color picker
	 */
	$.fn.colorPicker = function() {
		return this.each(function() {
			var
			element = $(this),
			button  = element.find('button'),
			input   = element.find('input');

			button.css('background', input.val());
			button.colpick({
				submit: false,
				layout: 'hex',
				color: input.val(),
				onChange: function(hsb, hex, rgb) {
					button.css('background', '#' + hex);
					input.val('#' + hex)
				}
			});

			input.on('change', function() {
				var currentValue = $(this).val();

				if (/^#([0-9a-f]{3}){1,2}$/i.test(currentValue)) {
					button.css('background', currentValue);
					button.colpickSetColor(currentValue);
				}
			});
		});
	};

	/**
	 * Code editor
	 */
	$.fn.mirrorEditor = function() {
		return this.each(function() {
			var
			wrapper = $(this),
			textarea = wrapper.find('textarea');

			var editor = CodeMirror.fromTextArea(textarea.get(0), {
				mode: wrapper.attr('data-language'),
				theme: 'base16-light',
				lineNumbers: true,
				autoCloseBrackets: true,
				tabSize: 4,
				fixedGutter: true,
				coverGutterNextToScrollbar: true
			});

			editor.setSize(
				wrapper.width(), 
				wrapper.height()
			);

			wrapper.data('jarvis-codemirror', editor);
		});
	};

	/**
	 * Admin Class
	 */
	$.JarvisAdmin = function(options) {
		this.options = $.extend({
			styleId: null,
			template: '',
			fonts: [],
			lang: {}
		}, options);

		$('#jarvis-restore-settings').dialog({
			width: 500,
			title: 'Restore Settings',
			modal: true,
			resizable: false,
			autoOpen: false
		}).closest('.ui-dialog').addClass('jarvis');

		this.wrapper = $('#jarvis');
		this.form = $('#style-form');
		
		this.wrapper.find('.jarvis-buttonset > fieldset').buttonset();
		this.wrapper.find('select').chosen({
			disable_search_threshold: 10
		});

		// Initialize color picker
		this.wrapper.find('.jarvis-color-picker').colorPicker();

		// Initialize mirror editor
		this.wrapper.find('.jarvis-code-editor[data-language]').mirrorEditor();

		$(window).smartresize(function() {
			$('.jarvis-code-editor[data-language]').each(function() {
				$(this).data('jarvis-codemirror').setSize(
					$(this).width(), 
					$(this).height()
				);
			});
		});

		// Initialize image picker
		this.wrapper.find('.jarvis-image-options').buttonset();

		// Initialize tabs
		this.wrapper.find('.jarvis-tabs').tabs();
		this.wrapper.tabs({
			activate: function(event, ui) {
				$.cookie('jarvis-tab-active', ui.newTab.index());
			}
		});
		this.wrapper.tabs('option', 'active', $.cookie('jarvis-tab-active'));
		this.wrapper.find('a[data-command="restore"]').on('click', function() {
			$('#jarvis-restore-settings').dialog('open')
		});

		$('#jarvis-restore-settings input').on('change', function() {
			var path = this.value.replace(/\\/g, '/'),
					segments = path.split('/');

			$('#jarvis-restore-settings iframe').one('load', function() {
				$('#jarvis-restore-settings').removeClass('jarvis-processing');
				var response = $(this).contents().text();
				
				if (response == 'done')
					return window.location.reload();

				alert(response);
			});

			$('#jarvis-restore-settings').addClass('jarvis-processing');
			$('#jarvis-restore-settings form').trigger('submit');
		});

		// Clear media
		$('body').on('click', '.jarvis-field-media button[data-command="clear"]', function() {
			$('input[type="text"]', $(this).parent()).val('');
		});
        
        // Boxed background

        $('[data-depend]').each(function(index, element){
            var desElement = $('[value="'+$(element).attr('data-depend-eq')+'"]');
            if(desElement 
                && $(desElement).attr('name').replace('jarvis[', '').replace(']','') == $(element).attr('data-depend')
                && $(desElement).attr('type') == 'radio'
                && $(desElement).prop('checked')
            ){
                $(element).css('display', 'block');
            }
            else $(element).css('display', 'none');
        });

        $('body').on('click', 'input[type="radio"]', function(){
            var iName = $(this).attr('name').replace('jarvis[', '').replace(']','');
            $('[data-depend="'+iName+'"][data-depend-eq="'+$(this).val()+'"]').css('display', 'block');
            $('[data-depend="'+iName+'"][data-depend-neq="'+$(this).val()+'"]').css('display', 'none');
        });

		// Initialize admin components
		new $.JarvisAdminMenu(this, this.wrapper.find('#jarvis-menu-assignment'));
		new $.JarvisAdminStyles(this, this.wrapper.find('#jarvis-styles'));
		new $.JarvisAdminLayout(this, this.wrapper.find('#jarvis-layout'));
	}

	/**
	 * debouncing function from John Hann
	 * http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
	 */
	var debounce = function (func, threshold, execAsap) {
		var timeout;

		return function debounced () {
			var obj = this, args = arguments;
			function delayed () {
				if (!execAsap)
					func.apply(obj, args);
				timeout = null;
			};

			if (timeout)
				clearTimeout(timeout);
			else if (execAsap)
				func.apply(obj, args);

			timeout = setTimeout(delayed, threshold || 100);
		};
	};

	/**
	 * Register smartresize plugin
	 */
	$.fn['smartresize'] = function(fn){
		return fn ? this.bind('resize', debounce(fn)) : this.trigger('smartresize');
	};
})(jQuery);