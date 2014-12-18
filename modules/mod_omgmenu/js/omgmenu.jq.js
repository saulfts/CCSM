/**
*	@version	$Id: omgmenu.jq.js 46 2013-04-11 09:48:03Z linhnt $
*	@package	OMG Template Framework for Joomla! 2.5
*	@subpackage	mod_omgmenu
*	@copyright	Copyright (C) 2009 - 2013 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// dropdown menu for desktop layout
;(function($){
	
	// core function
	$.fn.otmenu = function(options){
		var otmenu = $.fn.otmenu;
		
		return this.each(function(){
			var opt = $.extend({}, otmenu.defaults, options);
			
			
			$(this).find("li").each(function(){
				var hasChild = $(this).hasClass('hasChild');
				var subWrapper = $(this).find('.submenu-wrap:first').eq(0);
				
				$(this).hover(
					function(){
						$(this).addClass(opt.hoverClass);
						if ($(this).hasClass('hasColumn')) return;
						
						
						
						if (hasChild){
							if (/msie [1-7]./.test(navigator.userAgent.toLowerCase()) === false)
							{ // Not IE 7
								var containerWidth = $("body").width();
								
								if (opt.direction == 'ltr')
								{
									if ($(this).hasClass('level1')){
										var startAtRight = ((containerWidth - $(this).offset().left) < $(subWrapper).width()) && (($(this).offset().left + $(this).width()) > $(subWrapper).width());
										// var startAtRight = (containerWidth - $(subWrapper).width() - $(this).offset().left < 0) || ($(this).offset().left < $(subWrapper).width());
									}
									else{
										var startAtRight = ((containerWidth - $(this).offset().left - $(this).width()) < $(subWrapper).width()) && ($(this).offset().left > $(subWrapper).width());
									}
									
									if (startAtRight){
										// var theRight = containerWidth - $(this).offset().left + ($(subWrapper).width() - (containerWidth - $(this).offset().left));
										if ($(this).hasClass('level1')){
											var theRight = 0;
										} else {
											var theRight = containerWidth - $(this).offset().left + ($(subWrapper).width() - (containerWidth - $(this).offset().left));
										}
										
										$(subWrapper).addClass('edge-right').css({right: theRight, visibility: "visible",display: "none"});
									}
									else {
										if ($(subWrapper).parents('.submenu-wrap').size() > 0){
											var theLeft = $(subWrapper).parents('.submenu-wrap').eq(0).width();
											$(subWrapper).css({left: theLeft,visibility: "visible",display: "none", right: 'auto'});
										}
										else {
											if (((containerWidth - $(this).offset().left) < $(subWrapper).width()) && (($(this).offset().left + $(this).width()) < $(subWrapper).width())) {
												// var theLeft = ($(subWrapper).width() - containerWidth) / 2;
												// var theLeft = containerWidth - $(subWrapper).width() - $(this).offset().left - 15;
												var theLeft = ((containerWidth - $(subWrapper).width()) / 2 ) - $(this).offset().left;
												$(subWrapper).css({left: theLeft, visibility: "visible",display: "none", right: 'auto'});
											} else {
												$(subWrapper).css({left: 'auto', visibility: "visible",display: "none", right: 'auto'});
											}
										}
									}
								}
								else {
									// var startAtLeft = ($(subWrapper).width() > $(this).offset().left) && $(subWrapper).width() < (containerWidth - $(this).offset().left);
									var startAtLeft = ($(subWrapper).width() > ($(this).offset().left + $(this).width())) && $(subWrapper).width() < (containerWidth - $(this).offset().left);
									
									if (startAtLeft){
										if ($(this).hasClass('level1')){
											var theLeft = 0;
										} else {
											var theLeft = $(this).parents('.submenu-wrap').eq(0).width();
										}
										$(subWrapper).addClass('edge-left').css({left: theLeft, visibility: "visible",display: "none"});
									}
									else {
										if ($(subWrapper).parents('.submenu-wrap').size() > 0){
											var theRight = $(subWrapper).parents('.submenu-wrap').eq(0).width();
											$(subWrapper).css({right: theRight,visibility: "visible",display: "none", left: 'auto'});
											// $(subWrapper).css({width: containerWidth - $(this).offset().left});
										}
										else{
											if (($(subWrapper).width() > ($(this).offset().left + $(this).width())) && $(subWrapper).width() > (containerWidth - $(this).offset().left)) {
												// var theRight = $(this).width() - (((containerWidth - $(subWrapper).width()) / 2 ) - $(this).offset().left) - $(subWrapper).width();
												// $(subWrapper).css({right: theRight,visibility: "visible",display: "none", left: 'auto'});
												var theLeft = ((containerWidth - $(subWrapper).width()) / 2 ) - $(this).offset().left;
												$(subWrapper).css({left: theLeft, visibility: "visible",display: "none", right: 'auto'});
											} else {
												$(subWrapper).css({right: 'auto', visibility: "visible",display: "none", left: 'auto'});
											}
										}
									}
								}
								
							} else { // IE 7
								
								if (opt.direction == 'ltr'){
									if ($(subWrapper).parents('.submenu-wrap').size() > 0){
										var theLeft = $(subWrapper).parents('.submenu-wrap').eq(0).width();
										$(subWrapper).css({left: theLeft,visibility: "visible",display: "none"});
									}
									else {
										$(subWrapper).css({left: 'auto', visibility: "visible",display: "none"});
									}
								} 
								else {
									if ($(subWrapper).parents('.submenu-wrap').size() > 0){
											var theRight = $(subWrapper).parents('.submenu-wrap').eq(0).width();
											$(subWrapper).css({right: theRight,visibility: "visible",display: "none"});
											
										}
										else{
											$(subWrapper).css({right: 'auto', visibility: "visible",display: "none"});
										}
								}
								
							}
							
							$(subWrapper).animate(opt.animation,opt.speed);
						}
					},
					function(){
						$(this).removeClass(opt.hoverClass);
						if ($(this).hasClass('hasColumn')) return;
						if (hasChild){
							$(subWrapper).removeClass('edge-right').removeClass('edge-left').hide();
						}
						
					}
				);
			});
		});
	};
	
	// init and calls
	var otmenu = $.fn.otmenu;
	otmenu.options = {};
	
	otmenu.defaults = { // default options
		// language direction
		direction: 'ltr',
		// li classes
		hoverClass: 'hover',
		// effects
		delay: 400, // delay
		animation: {opacity:"show"}, // the animation effect, eg: opacity:"show",height:"show"
		speed: 'normal' // speed to show animation
	};
	
})(jQuery);


// sliding up/down menu for tablet and mobile layout
;(function($){
	
	// core function
	$.fn.otslmenu = function(options){
		var otslmenu = $.fn.otslmenu;
		
		return this.each(function(){
			var opt = $.extend({}, otslmenu.defaults, options);
			
			$(this).find("li").each(function(){
				if ($(this).hasClass('hasColumn')) return;
				var subWrapper = $(this).find('.submenu-wrap:first').eq(0);
				var subHandler = $(this).find('.toogle-btn:first').eq(0);
				if($(this).hasClass('active')){
					$(subWrapper).slideToggle(opt.speed, function(){
						$(subHandler).toggleClass(opt.openedHandlerClass).toggleClass(opt.closedHandlerClass);
						$(this).toggleClass(opt.openClass);
						
					});
				}
				$(subHandler).click(function(){
					$(subWrapper).slideToggle(opt.speed, function(){
						$(subHandler).toggleClass(opt.openedHandlerClass).toggleClass(opt.closedHandlerClass);
						$(this).toggleClass(opt.openClass);
						
					});
				});
			});
		});
	};
	
	// init and calls
	var otslmenu = $.fn.otslmenu;
	otslmenu.options = {};
	
	otslmenu.defaults = { // default options
		// li classes
		openClass: 'open',
		openedHandlerClass: 'icon-minus-sign',
		closedHandlerClass: 'icon-plus-sign',
		// effects
		delay: 400, // delay
		speed: 'normal' // speed to show animation
	};
	
})(jQuery);
