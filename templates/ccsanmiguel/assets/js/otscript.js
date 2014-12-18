/* OT Document JAVASCRIPT */
jQuery.noConflict();
jQuery(document).ready(function($) {
	// Fix Bootstrap 3 tooltip conflicting with mootools-more
	if(window.MooTools && window.MooTools.More){
		$('.hasTooltip, [rel=tooltip], [data-toggle="tooltip"]').each(function(){
			this.show = null; this.hide = null
		});
		
		$('.carousel').each(function(index, element) {
			$(this)[index].slide = null;
		});
	}
	
	// TOOLTIP
	$('a[data-toggle="tooltip"]').tooltip();
	
	// SCROLL TOP
	$('a.ot_scrollable').bind('click', function(e) {
		e.preventDefault();
		$('html,body').animate({scrollTop: $(this.hash).offset().top});                                                         
	});
	
	// FIX COLLAPSE
	// $('.accordion').addClass('panel-group');
	// $('.accordion-group').addClass('panel');
	// $('.accordion-heading').addClass('panel-heading');
	// $('.accordion-body').addClass('panel-collapse');
	// $('.accordion-inner').addClass('panel-body');
	
	// FIX FORM CONTACT
	// $('.control-group').addClass('form-group');
	// $('.form-group.control-group .controls input, .form-group.control-group .controls textarea, .form-group.control-group .controls select').addClass('form-control');
	// $('.form-group.control-group .controls input[type="checkbox"], .form-group.control-group .controls input[type="radio"]').removeClass('form-control');
	
	// TOGGLE COLLAPSE
	function toggleActive(e) {
		$(e.target)
			.prev('.panel-heading')
			.toggleClass('active');
	}
	$('body').on('hidden.bs.collapse', toggleActive);
	$('body').on('shown.bs.collapse', toggleActive);
	
	function toggleIcon(e) {
		$(e.target)
			.prev('.panel-heading')
			.find(".glyphicon")
			// .toggleClass('glyphicon-plus glyphicon-minus')
			.toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
		$(e.target)
			.prev().prev('.panel-heading')
			.find(".glyphicon")
			.toggleClass('glyphicon-plus glyphicon-minus')
			// .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
		$(e.target)
			.prev().prev('.toogle-btn')
			.find(".glyphicon")
			.toggleClass('glyphicon-plus glyphicon-minus')
			// .toggleClass('glyphicon-chevron-down glyphicon-chevron-up');
	}
	$('body').on('hidden.bs.collapse', toggleIcon);
	$('body').on('shown.bs.collapse', toggleIcon);
	
	//SHOW/HIDE FORM SEARCH
	$count = 0;	
	//SHOW FORM SEARCH
	$('#oTopBlock .search .btn-search').click(function(event){
		
		var value = $('#oTopBlock .search input.search-query').val();
		$count++; 
		if ($count == 1) {
			event.preventDefault();
		}
		if (value.length == 0) { 
			event.preventDefault();
		}
		$('#oTopBlock .search input.search-query').css({
			'width':'272px',
			'padding': '10px 14px'
		}); 
		$(this).css('margin-left',0);
		$(this).addClass('btn-active');
		event.stopPropagation();
	   
	});
	$('#oTopBlock .search input.search-query').click(function(event){
		event.stopPropagation();
	  
	})
	//HIDE FORM SEARCH
	$('html').click(function(){
		$('#oTopBlock .search input.search-query').animate({'width':0,'padding':'0'},300); 
		$('#oTopBlock .search .btn-active').removeClass('btn-active');
	});
	
	if ($('#ot-breadcrumbs').length > 0){
		$('#oBreadcrumbBlock').addClass('bor_top bor_bot');
	}
	
	// CHECK INTO VIEW EFFECT
	function checkIntoView(){
		$('.ot-effect').each(function() {
			var docViewTop = $(window).scrollTop();
			var docViewBottom = docViewTop + $(window).height();
			var elemTop = $(this).offset().top;
			var elemBottom = elemTop + $(this).height();
			if ((elemTop <= docViewBottom - 50) && (elemBottom >= docViewTop + 50)){
				// console.log($(this).attr('id') + ' ' + elemTop + ' ' + (docViewBottom - 50) + ' ' + elemBottom + ' ' + (docViewTop + 50));
				$(this).addClass('ot-appear').removeClass('ot-disappear');
			} else {
				$(this).addClass('ot-disappear').removeClass('ot-appear');
			}
		});
	}
	checkIntoView();
	$(window).scroll(function() {
		checkIntoView();
	});
	
	$(".carousel-inner").swiperight(function() {  
		$(this).parent().carousel('prev');  
	});  
	$(".carousel-inner").swipeleft(function() {  
		$(this).parent().carousel('next');  
	});
	
});

