<?php
/**
*	@version	$Id: shortcodes-handlers.php 5 2014-06-26 10:17:02Z linhnt $
*	@package	Jarvis Template Framework for Joomla!
*	@subpackage	shortcodes plugin for Joomla!
*	@copyright	Copyright (C) 2009 - 2014 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

/* plugin use shortcode API of WordPress 
* http://codex.wordpress.org/Shortcode_API
*/

if((int)JVERSION == 3){
	defined('JPATH_PLATFORM') or die;
}
else{
	defined('_JEXEC') or die ('Restricted access');
}

class Shortcodes_Handlers
{

	private static function randomString($length) {
		$pattern = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$key = '';
		for($i = 0; $i < $length; $i++)	{
			$key .= $pattern{rand(0,strlen($pattern)-1)};
		}
		return $key;
	}

	/* bootstrap Blockquote */
	public static function quote($atts, $content)
	{
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
			'title' => '',
			'align' => '',
			'border'=>'#666',
			'color'=>'#666',
			'width'=>'auto',
			'reverse'=>'', // default|reverse
			'class'=>'',
			'footer'=>'',
		), $atts));
		
		$cls = ' class="text-' . $align . (($class != '') ? ' ' . $class : '') . '"';
		$styles = (($width != '') ? 'width:' . $width . ';' : '') . (($border != '') ? 'border-color:' . $border . ';' : '') . (($color != '') ? 'color:' . $color . ';' : '');
		$style = $styles != '' ? ' style="' . $styles . '"' : '';
		$html[] = '<blockquote'. $cls . $style . '>'
				. ($title != '' ? '<h4>' . $title . '</h4>' : '')
				. Shortcodes_Parser::instance()->render($content)
				. ($footer != '' ? '<footer>' . $footer . '</footer>' : '')
				. '</blockquote>';
		unset($title, $align, $border, $color, $width, $reverse, $class, $footer);
		return implode($html);
	}
	
	/* bootstrap button */
	public static function button($atts, $content)
	{	
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
			'type' => '', // can be primary|info|success|warning|danger|link
			'size' => 'default', // lg|default|sm|xs
			'url' => '#',
			'disabled' => 'false', // state disabled, true|false
			'class' => '', // additional class
		), $atts));
		
		$html[] = '<a class="btn'
			.((trim($type) != '') ? ' btn-' . trim($type) : '')
			.((trim($size) != 'default' && trim($size) != '') ? ' btn-'. trim($size) : '')
			.((trim($disabled) == 'true') ? ' disabled' : '')
			.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			.
			'" href="'
			.((trim($url) != '' && trim($url) != '#' && trim($disabled) != 'true') ? trim($url) : 'javascript:void(0)')
			.'" title="">'.Shortcodes_Parser::instance()->render($content).'</a>';
		unset($type, $size, $url, $disabled, $class);
		return implode($html);
	}

	/* Bootstrap carousel */
	public static function carousel($atts, $content)
	{
		$html = '';
		$count = 0;
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'max_width' => '', // Apx or B%. If no specify, auto full.
				'class' => '' // additional class
		), $atts));
		
		if (preg_match_all('/\[carousel_item[^\]]*\].*?\[\/carousel_item[^\]]*\]/s', $content, $matches)) {
			$stripedContent = implode('', $matches[0]);
			$count = count($matches[0]);
		}
		else{
			$stripedContent = $content;
		}
		
		$add_id = self::randomString(10);
		$html .= '
			<div id="carousel-'.$add_id.'" class="carousel slide'
				.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
				.'"
				style="'
				.((trim($max_width) != '' && intval($max_width) != 0) ? ' max-width:'. trim($max_width) . ';' : '')
				.'">
				<ol class="carousel-indicators">';
		for($i = 0; $i < $count; $i++){
			$html .= '<li data-target="#carousel-'.$add_id.'" data-slide-to="'.$i.'" '.(($i == 0) ? 'class="active"' : '').'></li>';
		}
		$html .= '
				</ol>
				<div class="carousel-inner">
					'.Shortcodes_Parser::instance()->render($stripedContent).'
				</div>
				<a class="carousel-control left" href="#carousel-'.$add_id.'" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#carousel-'.$add_id.'" data-slide="next">&rsaquo;</a>
			</div>
		';
		unset($max_width, $class);
		return $html;
	}

	public static function carousel_item($atts, $content)
	{
		extract(Shortcodes_Parser::instance()->atts(array(
			'title' => '',
			'image' => '',
			'class' => '' // additional class
		), $atts));
		
		return '
			<div class="item'
			.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			.'">
			<img src="'.$image.'" alt="'.$title.'" />
				<div class="carousel-caption">
					<h4>'.$title.'</h4>
					<p>'.Shortcodes_Parser::instance()->render(strip_tags($content)).'</p>
				</div>
			</div>
		';
	}

	/* Clear Floated */ 
	public static function clearfix($atts)
	{
		$html = "<div class='clearfix' ></div>";

		return $html;
	}

	/* Bootstrap collapse */
	private static $parent = '';
	
	public static function collapse($atts, $content = null)
	{
		$html = '';
		$add_id = self::randomString(10);
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'class' => '' // additional class
		), $atts));
		
		self::$parent = 'collapse-' . $add_id;
		
		if (preg_match_all('/\[collapse_item[^\]]*\].*?\[\/collapse_item[^\]]*\]/s', $content, $matches)) {
			$stripedContent = implode('', $matches[0]);
		}
		else{
			$stripedContent = $content;
		}
		
		$html .= '<div id="' . self::$parent . '" class="panel-group'
				. ((trim($class) != '') ? ' ' . htmlspecialchars(trim($class)) : '')
				. '">'
					.Shortcodes_Parser::instance()->render($stripedContent)
				. '</div>
		';
		unset($max_width, $class);
		return $html;
	}

	public static function collapse_item($atts, $content = null)
	{
		extract(Shortcodes_Parser::instance()->atts(array(
			'type' => '', // can be primary|info|success|warning|danger
			'title' => '',
			'active' => '',
		), $atts));
		// var_dump($atts);
		$ci_id = self::randomString(4);

		$collapse_item = '<div class="panel panel-' . $type . '">'
					. '<div class="panel-heading">'
					. '<h4 class="panel-title">'
					. '<a href="#icollapse-' . $ci_id . '" data-parent="#' . self::$parent . '" data-toggle="collapse" class="'.($active=='active'?'':'collapsed').'">'
					. '<i class="glyphicon glyphicon-minus"></i>'
					. $title 
					. '</a>'
					. '</h4>'
					. '</div>'
					. '<div id="icollapse-'.$ci_id.'" class="panel-collapse collapse'.($active=='active'?' in':'').'"><div class="panel-body">'
						. Shortcodes_Parser::instance()->render(strip_tags($content))
					. '</div></div>'
					. '</div>';

		return $collapse_item;
	}

	/* bootstrap grid columns */
	public static function columns($atts, $content)
	{
		$html = '';
		if (preg_match_all('/\[column[^\]]*\].*?\[\/column[^\]]*\]/s', $content, $matches)) {
			$stripedContent = implode('', $matches[0]);
		}
		else{
			$stripedContent = $content;
		}
		
		$stripedContent = preg_replace("/(\[column[^\]]*\])(<\/[A-Za-z1-9]>)/s", "$1", $stripedContent);
		$stripedContent = preg_replace("/(<[A-Za-z1-9][^>]*>)(\[\/column\])/s", "$2", $stripedContent);
		
		$html = '<div class="container-fluid"><div class="row">'.Shortcodes_Parser::instance()->render($stripedContent).'</div></div>';
		return $html;
	}
	/* bootstrap grid column */
	public static function column($atts, $content)
	{	
		$col = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'xs' => '', // column width
				'xs_offset' => '', // offset
				'sm' => '', // column width
				'sm_offset' => '', // offset
				'md' => '', // column width
				'md_offset' => '', // offset
				'lg' => '', // column width
				'lg_offset' => '', // offset
				'class' => '' // additional class
		), $atts));
		
		$col[] = '<div class="'
			.((trim($xs) != '' && trim($xs) != '0') ? ' col-xs-' . trim($xs) : '')
			.((trim($xs_offset) != '' && trim($xs_offset) != '0') ? ' col-xs-offset-' . trim($xs_offset) : '')
			.((trim($sm) != '' && trim($sm) != '0') ? ' col-sm-' . trim($sm) : '')
			.((trim($sm_offset) != '' && trim($sm_offset) != '0') ? ' col-sm-offset-' . trim($sm_offset) : '')
			.((trim($md) != '' && trim($md) != '0') ? ' col-md-' . trim($md) : '')
			.((trim($md_offset) != '' && trim($md_offset) != '0') ? ' col-md-offset-' . trim($md_offset) : '')
			.((trim($lg) != '' && trim($lg) != '0') ? ' col-lg-' . trim($lg) : '')
			.((trim($lg_offset) != '' && trim($lg_offset) != '0') ? ' col-lg-offset-' . trim($lg_offset) : '')
			.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			.
			'">'.Shortcodes_Parser::instance()->render($content).'</div>';
		unset($width, $offset, $class);
		
		return implode($col);
	}

	/* Current Date */
	public static function currentdate($atts){
		extract(Shortcodes_Parser::instance()->atts(array(
			'format' => '20' // http://php.net/manual/en/function.date.php
		), $atts));

		return date($format);
	}

	/* Dropcap first char of paragraph */
	public static function dropcap($atts, $content)
	{
		$html = '';
		extract(Shortcodes_Parser::instance()->atts(array(
				'color' => '#000000',
				'background' => '',
				'type' => 'default', // type of background: circle, square, none.
				'class' => '' // additional class
		), $atts));
		
		$color = str_replace(array('#', ' '), '', $color);
		$background = str_replace(array('#', ' '), '', $background);
		$style = (($color != '') ? 'color:#' . $color . ';' : '') . (($background != '') ? 'background-color:' . (($background == 'transparent') ? 'transparent;' : '#' . $background . ';') : '');
		
		$html = '<span class="dropcap'
				. ((trim($type) != '' && trim($type) != 'default') ? ' ' . trim($type) : '')
				. ((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
				. '" style="'
				. $style
				. '">'.$content.'</span>';
		return $html;
	}
	
	/* Dropdown bootstrap */
	public static function dropdown($atts, $content)
	{
		$html = '';
		extract(Shortcodes_Parser::instance()->atts(array(
				'icon' => '',
				'title' => '',
				'type' => 'default', // can be default|primary|info|success|warning|danger|link
				'class' => '' // additional class
		), $atts));
		
		$drop_id = self::randomString(10);
		$html = '<div class="dropdown'
				. ((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
				. '">'
				. '<div class="btn-group">'
				. '<button type="button" class="btn btn-'.((trim($type) != '') ? trim($type) : 'default').'">'
				. $title
				. '</button>'
				. '<button type="button" class="btn btn-'.((trim($type) != '') ? trim($type) : 'default').' dropdown-toggle" id="dropMenu'.$drop_id.'" data-toggle="dropdown">'
				. '<span class="'.(trim($icon) != '' ? trim($icon) : 'caret').'"></span>'
				. '</button>'
				. '<ul class="dropdown-menu" role="menu" aria-labelledby="dropMenu'.$drop_id.'">'
				. Shortcodes_Parser::instance()->render(str_replace(array("<br/>", "<br>", "<br />"), " ", $content))
				. '</ul>'
				. '</div>'
				. '</div>';
		return $html;
	}
	
	public static function drop_item($atts, $content)
	{
		$html = '';
		extract(Shortcodes_Parser::instance()->atts(array(
				'url' => ''
		), $atts));
		
		$drop_id = self::randomString(10);
		$html = '<li role="presentation">'
				.'<a role="menuitem" tabindex="-1" href="'.(trim($url) != '' ? $url : '#').'">'
				.$content
				.'</a>'
				.'</li>';
		return $html;
	}

	/* Divider */
	public static function divider($atts, $content = null)
	{
		extract(Shortcodes_Parser::instance()->atts(array(
			'type' => '', // default|line|dotted|shadow|stripes
			'margin' => '',
		), $atts));

		$divider = '<div class="odivider '.$type.'" style="margin:'.$margin.'"></div>';

		return $divider;
	}
	
	/* Gallery Block */
	public static function gallery($atts, $content = null)
	{
		$gal_id = self::randomString(10);
		
		extract(Shortcodes_Parser::instance()->atts(array(
			'title' 	=> '',
			'layout'	=> '', // masonry|fitRows|cellsByRow|vertical|masonryHorizontal|fitColumns|cellsByColumn|horizontal
			'datafilter'=> '',
			'colwidth'	=> 50, // for masonry|cellsByRow|cellsByColumn
			'rowheight'	=> 50, // for masonryHorizontal|cellsByRow|cellsByColumn
			'gutter'	=> '', // for masonry|masonryHorizontal
			'halign'	=> '', // for vertical
			'valign'	=> '', // for horizontal
		), $atts));

		$gal_filter = '';
		$bind_filter = '';
		if ($datafilter != ''){
			$gal_filter = '<div class="filters btn-group js-radio-button-group">';
			$gal_filter .= '<button class="btn btn-default is-checked" data-filter="*">show all</button>';
			$filters = explode(" ", $datafilter);
			foreach ($filters as $dfilter){
				$gal_filter .= '<button class="btn btn-default" data-filter=".' . $dfilter . '">' . $dfilter . '</button>';
			}
			$gal_filter .= '</div>';
			$bind_filter = '$(\'#gallery-'.$gal_id.' .filters\').on( \'click\', \'button\', function() {'
				. 'var filterValue = $( this ).attr(\'data-filter\');'
				. '$container.isotope({ filter: filterValue });'
			. '});';
		}
		
		switch ($layout)
		{
			case 'masonry':
				$layoutoption = 'masonry:{columnWidth: ' . ($colwidth!=''?$colwidth:10) . ($gutter!=''?', gutter: ' . $gutter:'') . '}';
				break;
			case 'fitRows':
				$layoutoption = '';
				break;
			case 'cellsByRow':
				$layoutoption = '';
				$opt = array();
				if($colwidth!='' || $rowheight!=''){
					if($colwidth!=''){
						$opt[] = ($colwidth!=''?'columnWidth: ' . $colwidth:'');
					}
					if($rowheight!=''){
						$opt[] = ($rowheight!=''?'rowHeight: ' . $rowheight:'');
					}
					$layoutoption = 'cellsByRow:{' . implode(',', $opt) . '}';
				}
				break;
			case 'vertical':
				$layoutoption = 'vertical:{horizontalAlignment: ' . ($halign!=''?$halign:0) . '}';
				break;
			case 'masonryHorizontal':
				$layoutoption = 'masonryHorizontal:{rowHeight: ' . ($rowheight!=''?$rowheight:10) . ($gutter!=''?', gutter: ' . $gutter:'') . '}';
				break;
			case 'fitColumns':
				$layoutoption = '';
				break;
			case 'cellsByColumn':
				$layoutoption = '';
				$opt = array();
				if($colwidth!='' || $rowheight!=''){
					if($colwidth!=''){
						$opt[] = ($colwidth!=''?'columnWidth: ' . $colwidth:'');
					}
					if($rowheight!=''){
						$opt[] = ($rowheight!=''?'rowHeight: ' . $rowheight:'');
					}
					$layoutoption = 'cellsByColumn:{' . implode(',', $opt) . '}';
				}
				break;
			case 'horizontal':
				$layoutoption = 'horizontal:{verticalAlignment: ' . ($valign!=''?$valign:0) . '}';
				break;
			default :
				$layoutoption = 'masonry:{columnWidth: ' . ($colwidth!=''?$colwidth:10) . ($gutter!=''?', gutter: ' . $gutter:'') . '}';
				break;
		}
		
		$gallery = '<div id="gallery-'.$gal_id.'" class="ot-gallery clearfix">'
				. (($title !='')? '<h3 class="gallery-title">' . $title . '</h3>' : '')
				. $gal_filter
				. '<div class="ogallery-list clearfix">' . Shortcodes_Parser::instance()->render(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)) . '</div>'
				. '</div>';
		
		$script = '<script type="text/javascript">'
					. 'jQuery(document).ready(function($) {'
						. 'var $container = $(\'#gallery-'.$gal_id.' .ogallery-list\').isotope({'
							. 'itemSelector: \'.masonry-brick\','
							. 'layoutMode: \'' . $layout .'\','
							. $layoutoption	
						. '});'
						. $bind_filter
					. '});'
				. '</script>';
		
		$gallery .= $script;

		return $gallery;
	}

	public static function gallery_item($atts, $content = null){
		
		extract(Shortcodes_Parser::instance()->atts(array(
			'title' => '',
			'src'	=> '',
			'video_addr' => '',
			'width' => '',
			'height' => '',
			'filter' => '',
		), $atts));

		if(strpos($video_addr, 'youtube.com')){
			$src_pop = $video_addr;
			if($src=="" || !is_file($src)) $src = 'plugins/system/omgshortcodes/assets/images/youtube.png';
		}elseif(strpos($video_addr, 'vimeo.com')){
			$src_pop = $video_addr;
			if($src=="" || !is_file($src)) $src = 'plugins/system/omgshortcodes/assets/images/vimeo.jpg';
		}else{
			$src_pop = "";
		}
		$src = (is_file($src))?$src:'plugins/system/omgshortcodes/assets/images/no-image.png';
		$src = (strpos($src, "http://") === false) ? JURI::base() . $src : $src;
		if($src_pop ==""){
			$src_pop = $src;
		}

		$gallery_item = '<div class="masonry-brick pull-left '.$filter.'" style="width: '.$width.';">';
		$gallery_item .='<div class="item-gallery">';
		$gallery_item .= '<div class="item-gallery-hover"></div>';
		$gallery_item .= '<a title="' . $title . '" href="' . $src_pop . '" data-rel="prettyPhoto[bkpGallery]">';
		$gallery_item .= '<h3 class="item-gallery-title">'. $title .'</h3><div class="image-overlay"></div>';
		$gallery_item .= '<img src="' . $src . '" title="' . $title . '" alt="' . $title . '" />';
		$gallery_item .= '</a>';
		if ($content != '') {
		$gallery_item .= '<div class="image-caption">' . Shortcodes_Parser::instance()->render($content) . '</div>';
		}
		$gallery_item .= '</div>';
		$gallery_item .= '</div>';

		return str_replace("<br/>", " ", $gallery_item);
	}

	/* Google fonts */
	public static function googlefont($atts, $content = null){
		extract(Shortcodes_Parser::instance()->atts(array(
			'font_family' => '',
			'size' => '',
			'color' => '',
			'align' => '',
			'font_weight' => '',
			'margin' => '',
		), $atts));
		$style = ' style="';
		if($font_family!='')
			$style .= 'font-family:\'' . $font_family . '\';';

		if($size!='')
			$style .= 'font-size:' . $size . ';';
		if($color!='')
			$style .= 'color:' . $color . ';';
		if($font_weight!='')
			$style .= 'font-weight:' . $font_weight . ';';
		$style .='"';
		
		$roundo = '';
		if($align!=''||$margin!='')
		{
			$roundo = '<div style="';
			if($align!='')
				$roundo .= 'text-align:' . $align . ';';
			if($margin!='')
				$roundo .= 'margin:' . $margin . ';';
			$roundo .= '">';
		}
		$rounde = '';
		if($align!=''||$margin!='')
		{
			$rounde = '</div>';
		}
			
		$googlefont = $roundo 
			. '<link href="http://fonts.googleapis.com/css?family=' . str_replace(' ', '+', $font_family) . '" rel="stylesheet" type="text/css">'
			. '<span class="googlefont"'.$style.'>'.$content.'</span>' 
			. $rounde;

		return $googlefont;
	}

	/* Google maps */
	public static function googlemap($atts, $content = null){
		extract(Shortcodes_Parser::instance()->atts(array(
			'title' => '',
			'iframe_src' => '',
			'addr' => '',
			'lat' => '',
			'lng' => '',
			'ratio' => '',
			'width' => '',
			'height' => ''
		), $atts));
		$googlemap = '';
		
		$map_id = self::randomString(10);
		if( $iframe_src==''){
			$address = str_replace(' ', '+', $addr);
			$jsonResponse = @file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address='.$address);
			if ($jsonResponse) {
				$jsonResponse = json_decode($jsonResponse);
				$lat = $lat==''?$jsonResponse->results[0]->geometry->location->lat:$lat;
				$lng = $lng==''?$jsonResponse->results[0]->geometry->location->lng:$lng;
			}
		}
		
		$ratio = explode(':', $ratio);
		$style = ' style="'.($width!=''?'width:'.$width.';':'').($height!=''?'height:'.$height.';':($ratio!=''?'padding-bottom:'.(($ratio[1]/$ratio[0])*100).'%;':'')).'"';
		
		// $googlemap .= '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?language='.JFactory::getLanguage()->getTag().'"></script>';
		$googlemap .= '<div class="embed-responsive"'.$style.'>';
		if ($iframe_src!=''){
			$googlemap .= '<iframe  class="embed-responsive-item" src="'.$iframe_src.'" frameborder="0" style="border:0"></iframe>';
		} else {
			$googlemap .= '<div id="gmap_canvas'.$map_id.'" class="embed-responsive-item"></div>'
						. '<style>#gmap_canvas'.$map_id.' img{max-width:none!important;background:none!important}</style>';
		}
		$googlemap .= '</div>';
		if( $iframe_src==''){
			$googlemap .= '<script type="text/javascript">'
						. 'function init_map(){'
							. 'var myOptions = {'
								. 'zoom:16,'
								. 'center:new google.maps.LatLng(' . $lat . ',' . $lng . '),'
								. 'mapTypeId: google.maps.MapTypeId.ROADMAP'
							. '};'
							. 'map = new google.maps.Map(document.getElementById("gmap_canvas'.$map_id.'"), myOptions);'
							. 'marker = new google.maps.Marker({'
								. 'map: map,'
								. 'position: new google.maps.LatLng(' . $lat . ',' . $lng . ')'
							. '});'
							. 'infowindow = new google.maps.InfoWindow({'
								. 'content:"'. ($title!=''?'<b>'.$title.'</b><br/>':'').$addr.'"'
							. '});'
							. 'google.maps.event.addListener(marker, "click", function(){'
								. 'infowindow.open(map,marker);'
							. '});'
							. 'infowindow.open(map,marker);'
						. '}'
						. 'google.maps.event.addDomListener(window, \'load\', init_map);'
					. '</script>';
		}
		return $googlemap;
	}

	/* bootstrap or awesome icon */
	public static function icon($atts, $content)
	{	
		$html = '';
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'type' => '', // glyphicon|awesome
				'name' => '', // http://twitter.github.io/bootstrap/base-css.html#icons or http://fortawesome.github.io/Font-Awesome/icons/
				'size' => '', // font-size
				'color' => '', // font color
				'class' => '', // additional class
		), $atts));
		
		$cls = '';
		if ((trim($type) != '' && (trim($type) == 'glyphicon' || trim($type) == 'awesome') && trim($name) != '') || (trim($class) != '')) {
			$cls = ' class="';
			if (trim($type) != '' && (trim($type) == 'glyphicon' || trim($type) == 'awesome') && trim($name) != ''){
				if (trim($type) == 'glyphicon'){
					$cls .= 'glyphicon glyphicon-' . trim($name);
				} else {
					$cls .= 'fa fa-' . trim($name);
				}
			}
			if (trim($class) != ''){
				$cls .= ' ' . htmlspecialchars(trim($class));
			}
			$cls .= '"';
		}
		$style = '';
		if (trim($size) != '' || (trim($color) != '' && trim($color) != 'default')){
			$style = ' style="';
			if (trim($size) != ''){
				$style .= 'font-size: ' . trim($size) . ';';
			}
			if (trim($color) != '' && trim($color) != 'default'){
				$style .= 'color: ' . trim($color) . ';';
			}
			$style .= '"';
		}
		
		$html = '<i' . $cls . $style . '></i>';
		unset($type, $name, $color, $class);
		return $html;
	}

	
	/* List Block */
	private static $list_type = '';
	public static function lists($atts, $content = null){
		extract(Shortcodes_Parser::instance()->atts(array(
			'type' => 'check', // http://fortawesome.github.io/Font-Awesome/icons/
			'color' => '',
			'class' => ''
		), $atts));
		
		self::$list_type = $type;
		$color =(($color != '')? 'color:'.$color : "");
		return '<ul class="olist ' . $class . ' type-' . $type . '" style="'.$color.'">'. Shortcodes_Parser::instance()->render(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)) . '</ul>';
	}

	public static function list_item($atts, $content = null ){
		extract(Shortcodes_Parser::instance()->atts(array(
			'offset' => ''
		), $atts));
		$li_i = '<li>'
			. (self::$list_type!='' ? '<i class="fa fa-' . self::$list_type . '"></i>' : '')
			. Shortcodes_Parser::instance()->render($content)
			. '</li>';
		return $li_i;
	}

	/* Line Break */
	public static function br($atts){
		extract(Shortcodes_Parser::instance()->atts(array(
			'height' => '20'
		), $atts));

		return "</br>";
	}

	/* Lightbox Block */
	/* public static function lightbox($atts){
		JHtml::_('behavior.modal', 'a.modal');
		extract(Shortcodes_Parser::instance()->atts(array(
			"src"		=> '#',
			"width"		=> 'auto',
			"height"	=> 'auto',
			"title"		=> '',
			'align'		=> 'none',
			'lightbox'	=> 'on',
			'border'	=> ''
		), $atts));

		$src   =  (strpos($src, "http://") === false) ? JURI::base() . $src : $src;
		$border  = ($border == "No" || $border == "no") ? "no-border" : " " ;
		$style = '';
		if ($width!='' or $height!=''){
			$style = ' style="' . ($width != '' ? 'width:' . $width . ';' : '') . ($height != '' ? 'height:' . $height . ';' : '') . '"';
		}
		

		$frame = '<img src="' . $src . '" alt="' . $title . '" />';
		$titles = ($title != '') ? '<h3 class="img-title">'. $title .'</h3>' : '';
		if($lightbox == 'On' || $lightbox == 'on') {
			$frame = '<a href="' . $src . '" data-toggle="modal" data-target="#modal" title="' . $title . '" >' . $frame . $titles. '</a>';
		}

		$frame = '<div class="olightbox  image-'. $align.' '.$border.'">' . $frame . '</div>';

		return $frame;
	} */

	/* bootstrap message alert */
	public static function message($atts, $content)
	{	
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'title' => '', // http://twitter.github.io/bootstrap/components.html#alerts
				'type' => '', // http://twitter.github.io/bootstrap/components.html#alerts
				'block' => 'false', // if block, larger by padding
				'showclose' => 'true', // additional class
				'class' => '', // additional class
		), $atts));
		
		$content = preg_replace("/^(<\/[A-Za-z1-9]>)(.*?<[A-Za-z1-9][^>]*>)/s", "$2", $content);
		$content = preg_replace("/(<\/[A-Za-z1-9]>.*?)(<[A-Za-z1-9][^>]*>$)/s", "$1", $content);
		
		$html[] = '<div class="alert'
			. ((trim($type) != '') ? ' alert-' . trim($type) : '')
			. ((trim($block) != 'false') ? ' alert-block' : '')
			. ((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			. ((trim($showclose) != 'false') ? ' alert-dismissible' : '')
			. '">';
			if (trim($showclose) != 'false') $html[] = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
			if (trim($title) != '') $html[] = '<h4>'.htmlspecialchars(trim($title), ENT_QUOTES, 'UTF-8').'</h4>';
		$html[] = '<div>'.Shortcodes_Parser::instance()->render($content).'</div>';
		$html[] = '</div>';
		unset($title, $type, $block, $showclose, $class);
		return implode($html);
	}

	/* bootstrap modal box */
	public static function modal($atts, $content)
	{	
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'type' => 'static', // can be static, iframe
				'id' => '', // id of modal box
				'class' => '', // link or button class
				'title' => '', // text of button or link
				'header' => '', // header text of modal box
				'href' => '', // if handler is iframe, must have url
				'footer' => 'true', // if true show the footer of modal box
				'size' => '' // can be default, large, small
		), $atts));
		
		if (trim($id) == "") $id = self::randomString(8);
		
		$html[] = '<div id="modal-'.$id.'" class="modal fade" tabindex="-1" role="dialog">
					<div class="modal-dialog'.(trim($size)=='large'?' modal-lg':(trim($size)=='small'?' modal-sm':'')).'">
						<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						'.((trim($header) != '') ? '<h4 class="modal-title">' . htmlspecialchars(trim($header), ENT_QUOTES, 'UTF-8') . '</h4>' : '')
					.'</div>
					<div class="modal-body">
						'.((trim($type) == 'iframe' && trim($href) != '') ? '<iframe width="100%" height="100%" frameborder="0" scrolling="no" allowtransparency="true" src="'.trim($href).'"></iframe>' : Shortcodes_Parser::instance()->render($content)).'
					</div>';
		if ($footer == 'true'){
			$html[] =	'<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>';
		}
		$html[] =	'</div></div></div>';
		$html[] = '<a href="'.((trim($type) == 'url' && trim($href) != '') ? trim($href) : '#modal-'.$id).'" data-target="#modal-'.$id.'" role="button" class="'.((trim($class) != '') ? htmlspecialchars(trim($class)) : '').'" data-toggle="modal">'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'</a>';
		
		unset($type, $id, $class, $title, $header, $href);
		return implode($html);
	}

	/* Load module */
	public static function module($atts, $content)
	{	
		$html = '';
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'class' => '', 
				'type' => '', // can be module|position
				'params' => '', // module ids or name positions
				'modstyle' => '' // module style: none|xhtml|rounded...
		), $atts));
		
		switch($type)
		{
			case "mod":
				$html = Shortcodes_Parser::instance()->getContentByModule($params, $modstyle);
				$html = str_replace(array("\r\n", "\r"), "\n",$html);
				$html = str_replace("\n", "",$html);
			break;
			case "pos":
				$html = Shortcodes_Parser::instance()->getContentByPosition($params, $modstyle);
			break;
		}
		
		unset($class, $type, $params, $modstyle);
		return $html;
	}

	/* bootstrap panel box */
	public static function panel($atts, $content)
	{	
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'type' => 'default', // can be default|primary|success|info|warning|danger
				'id' => '', // 
				'class' => '', // 
				'title' => '', // 
				'footer' => '', // 
		), $atts));
		
		if (trim($id) == "") $id = self::randomString(8);
		
		$html[] = '<div id="panel-'.$id.'" class="panel panel-'.$type.'">';
		if ($title != ''){
			$html[] =	'<div class="panel-heading">'
							. $title
						. '</div>';
		}
		$html[] = '<div class="panel-body">'
						. Shortcodes_Parser::instance()->render($content)
					. '</div>';
		if ($footer != ''){
			$html[] =	'<div class="panel-footer">'
							. $footer
						. '</div>';
		}
		$html[] =	'</div>';
		
		unset($type, $id, $class, $title, $footer);
		return implode($html);
	}

	/* pretty format for code snippests in content */
	public static function oprettycode($atts, $content)
	{	
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'lang'		=> '',
				'linenums' 	=> 'true',
				'startnum' => 1
		), $atts));
		
		$html[] = '<pre class="prettyprint'.(($lang != '') ? ' lang-' . $lang : '')
				. (($linenums == 'true') ? ' linenums' : '')
				. (($startnum && $linenums == 'true') ? ':' . $startnum : '').'">'
				. $content
				. '</pre>';
		
		
		if(!defined('OPRETTYCODE_KICKED')) {
			$html[] = '<script type="text/javascript">jQuery(document).ready(function($) { window.prettyPrint && prettyPrint(); });</script>';
			define('OPRETTYCODE_KICKED', true);
		}
		
		return implode($html);
	}

	/* Pricing Tables */
	private static $pcolumns = '';
	public static function pricing($atts, $content = null ){

		extract(Shortcodes_Parser::instance()->atts(array(
			'columns' 	=> '3',
			'width' 	=> '',
			'style' 	=> '',
			'class'		=> ''
		), $atts));

		self::$pcolumns	= $columns;
		$class 		= 'opricing block col-' . $columns . ' pricing-' . $style . ((trim($class) != '') ? ' ' . htmlspecialchars(trim($class)) : '');

		return '<div class="'.$class.'"  style="width:'.$width.';" >' . Shortcodes_Parser::instance()->render(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)) . '</div>';
	}

	/* Pricing Table Plan */
	public static function plan($atts, $content = null ){

		extract(Shortcodes_Parser::instance()->atts(array(
			'title' 		=> '',
			'button_link' 	=> '',
			'button_label' 	=> '',
			'price' 		=> '',
			'featured' 		=> '',
			'per'			=> '',
			'type'			=> 'default', // default|success|info|warning|danger|primary
			'class'			=> ''
		), $atts));
		$type = $type!=''?$type:'default';

		return  '<div class="column text-center col-sm-' . round(12/self::$pcolumns) . (('true' == strtolower($featured)) ? ' featured' : '') .'">' .
					'<div class="panel panel-'.$type.'">' .
						'<div class="panel-heading"><h4>' . $title . '</h4></div>' .
						'<div class="panel-body text-center"><h2>' . $price . '</h2>'.($per!=''?'<h4>per ' . $per . '</h4>':'').'</div>' .
						($content!=''?'<ul class="list-group list-group-flush">'.Shortcodes_Parser::instance()->render(str_replace(array("<br/>", "<br>", "<br />"), " ", $content)).'</ul>':'') .
						'<div class="panel-footer"><a class="signup btn btn-lg btn-block btn-'.$type.'" href="' . $button_link . '">' . $button_label . '</a></div>' .
					'</div>' .
				 '</div>';
	}

	/* Pricing Tables Row */
	public static function planrow($atts, $content = null ){

		extract(Shortcodes_Parser::instance()->atts(array(
			'title'	=> '',
			'icon'	=> '',
			'class'	=> ''
		), $atts));

		return  '<li class="list-group-item'.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '').'">' .
					Shortcodes_Parser::instance()->render($content) .
					($icon!='<i class="glyphicon glyphicon-'.$icon.' pull-right"></i>'?'':'') .
				'</li>';
	}

	/* bootstrap Progress bar */
	public static function progress($atts, $content)
	{	
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'type' => 'default', // default|success|info|warning|danger
				'striped' => '', // true|false
				'active' => '', // true|false
				'class' => '', // additional class
				'value' => '',
				'height' => ''
		), $atts));
		
		$html[] = '<div class="progress">'
			. '<div class="progress-bar'
			. ((trim($type) != '' && trim($type) != 'default') ? ' progress-bar-' . trim($type) : '')
			. ((trim($striped) == 'true') ? ' progress-bar-striped' : '')
			. ((trim($active) == 'true') ? ' active' : '')
			. ((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			. '" role="progressbar"'
			. ' aria-valuenow="'.$value.'"'
			. ' aria-valuemin="0"'
			. ' aria-valuemax="100"'
			. 'style="width: '.$value.'%">'
			. '<span class="sr-only">'.$value.'% Complete (success)</span>'
			. '</div>'
			. '</div>';
		unset($type, $class);
		return implode($html);
	}

	/* Social Block */
	public static function social($atts, $content = null){
		extract(Shortcodes_Parser::instance()->atts(array(
			'class'=> '',
			'mode' => '', // facebook_like|facebook_recommend|facebook_fanpage|twitter_follow|twitter_tweet|twitter_timeline|google_plus|pinterest
			'name'=> '',
			'widget_id'=> '',
			'tweet_limit'=>'',
			'tweet_theme'=>'',
			'tweet_colorlnk'=>'',
			'tweet_params'=>'',
			'width'=> '',
			'height'=> ''
		), $atts));
		
		$html = '';
		$html .= '<div' . ($class!=''?' class="'.$class.'"':'') . '>';
		if($mode=="facebook_like"){
			$html .='<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;width&amp;layout=button&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:80px;" allowTransparency="true"></iframe>';
		} else if($mode=="facebook_recommend"){
			$html .='<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;width&amp;layout=button&amp;action=recommend&amp;show_faces=true&amp;share=true&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:80px;" allowTransparency="true"></iframe>';
		}else if($mode=="facebook_fanpage"){
			$html .= '<iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2F'.$name.'&amp;width&amp;height=290&amp;colorscheme=light&amp;show_faces=true&amp;header=true&amp;stream=false&amp;show_border=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:290px;" allowTransparency="true"></iframe>';
		}else if($mode=="twitter_follow"){
			$html .='
					<a href="https://twitter.com/'.$name.'" class="twitter-follow-button" data-show-count="false">Follow @twitter</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			';
		}else if($mode=="twitter_tweet"){
			$html .='
					<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en">Tweet</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			';
		} else if($mode=="twitter_timeline"){
			$html .='
					<a class="twitter-timeline" href="https://twitter.com/'.$name.'" data-widget-id="'.$widget_id.'" data-screen-name="'.$name.'" data-show-replies="false" data-tweet-limit="'.$tweet_limit.'"'.($tweet_theme!=''?' data-theme="'.$tweet_theme.'"':'').($tweet_colorlnk!=''?' data-link-color="'.$tweet_colorlnk.'"':'').' data-chrome="'.$tweet_params.'">Tweets by @'.$name.'</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			';
		} else if ($mode=="google_plus"){
			$html .= '
					<div class="g-plus" data-action="share"></div>
					<script type="text/javascript">window.___gcfg = {lang: '.JFactory::getLanguage()->getTag().'}; (function() { var po = document.createElement("script"); po.type = "text/javascript"; po.async = true; po.src = "https://apis.google.com/js/platform.js"; var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s); })();</script>
			';
		} else if ($mode=="pinterest"){
			$html .= '
					<a href="//www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"  data-pin-height="28"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_28.png" /></a><script type="text/javascript" async src="//assets.pinterest.com/js/pinit.js"></script>
			';
		}
		$html .= '</div>';

		return $html;
	}

	/* Spacer */
	public static function spacer($atts)
	{
		extract(Shortcodes_Parser::instance()->atts(array(
			"height" => '20px'
		), $atts));	
		return '<div style="clear:both; height:' . $height . ';"></div>';
	}

	/* bootstrap tabs */
	private static $tabsArr = array();
	public static function tabs($atts, $content)
	{
		$html = '';
		$count = 0;
		self::$tabsArr = array();
		$add_id = self::randomString(11);
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'max_width' => '', // Apx or B%. If no specify, auto full.
				'class' => '', // additional class
				'position' => 'top' // additional class
		), $atts));
		
		if (preg_match_all('/\[tab[^\]]*\].*?\[\/tab[^\]]*\]/s', $content, $matches)) {
			$stripedContent = implode('', $matches[0]);
			$count = count($matches[0]);
		}
		else{
			$stripedContent = $content;
		}
		
		Shortcodes_Parser::instance()->render($stripedContent);
		
		if ($count < 1 || $count < count(self::$tabsArr)) $count = count(self::$tabsArr);
		
		$cls = ' class="pos-' . $position . ((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '') . '"';
		$style = ((trim($max_width) != '' && intval($max_width) != 0) ? ' style="max-width:'. trim($max_width) . ';"' : '');
		
		$tablist = '<ul class="nav nav-tabs" role="tablist">';
		for($i = 0; $i < $count; $i++){
			$tablist .= '<li'.(($i == 0) ? ' class="active"' : '').'><a data-toggle="tab" href="#tabs-'.$add_id.'-'.$i.'">'.self::$tabsArr[$i]['title'].'</a></li>';
		}
		$tablist .= '</ul>';
		
		$tabcontent = '<div class="tab-content">';
		for($i = 0; $i < $count; $i++){
			$tabcontent .= '<div class="tab-pane'
			.($i == 0 ? ' active' : '')
			.'" id="tabs-'.$add_id.'-'.$i.'">' . self::$tabsArr[$i]['content'] . '</div>';
		}
		$tabcontent .= '</div>';		
		
		$html .= '<div id="tabs-'.$add_id.'"' . $cls . $style .'>'
			. ($position!='bottom' ? $tablist : '')
			// . $tablist
			. $tabcontent
			. ($position=='bottom' ? $tablist : '')
			. '</div>';
		unset($max_width, $class);
		self::$tabsArr = '';
		
		return $html;
	}

	/* bootstrap tab */
	public static function tab($atts, $content)
	{
		
		extract(Shortcodes_Parser::instance()->atts(array(
			'title' => ''
		), $atts));
		
		self::$tabsArr[] = array("title" => $title , "content" => Shortcodes_Parser::instance()->render($content));
		unset($title);
	}

	/* Testimonial Block */
	public static function testimonial($atts, $content = null){
		extract(Shortcodes_Parser::instance()->atts(array(
			'author' => '',
			'position' => '',
			'avatar' => '',
			'style' => ''
		), $atts));
		
		$testimonial_avatar = '<div class="testimonial-avatar">' ;
		if($avatar != '') {
			$testimonial_avatar .='<img src="' . $avatar . '"/> ';
		}
		$testimonial_avatar .= '<small class="testimonial-author">';
		$testimonial_avatar .= '<i class="glyphicon glyphicon-user"></i> ' . $author . ', ';
		$testimonial_avatar .= '<cite class="testimonial-author-position">' . $position . '</cite>';
		$testimonial_avatar .= '</small>';
		$testimonial_avatar .= '</div>';
		// $testimonial = '<blockquote class="otestimonial'.(($avatar != '')? ' tm-avatar' : '').(($style != '')? ' '.$style : '').'">';
		// $testimonial .= '<p>' .Shortcodes_Parser::instance()->render($content). '</p>';
		// $testimonial .= $testimonial_avatar;
		// $testimonial .= '</blockquote>';
		$testimonial = '<blockquote class="otestimonial'.(($avatar != '')? ' tm-avatar' : '').(($style != '')? ' '.$style : '').'">';
		$testimonial .= '<p>' .Shortcodes_Parser::instance()->render($content). '</p>';
		$testimonial .= $testimonial_avatar;
		$testimonial .= '</blockquote>';
		
		return $testimonial;
	}

	/* bootstrap tooltip */
	public static function tooltip($atts, $content)
	{	
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'position' => 'top', // can be top|bottom|left|right
				'mode' => 'text', // text|html. if html will allow title in html mode instead of text
				'title' => '', // title of tooltip / tooltip text 
				'container' => 'false' // Container can be an element, eg: "body"
		), $atts));
		
		$html[] = '<a href="#" data-toggle="tooltip" data-placement="'.$position.'" data-html="'.(($mode == 'text') ? 'false' : 'true').'" data-container="'.$container.'" data-title="'.htmlspecialchars($title, ENT_QUOTES, 'UTF-8').'">'.$content.'</a>';
		if(!defined('OTOOLTIP_KICKED')) {
			$html[] = '<script type="text/javascript">jQuery(document).ready(function($) { $(\'a[data-toggle="tooltip"]\').tooltip(); });</script>';
			define('OTOOLTIP_KICKED', true);
		}
		unset($position, $mode, $title, $container);
		return implode($html);
	}

	/* bootstrap well textbox */
	public static function well($atts, $content)
	{	
		$html = array();
		
		extract(Shortcodes_Parser::instance()->atts(array(
				'size' => 'default', // lg|default|sm|xs
				'class' => '', // additional class
		), $atts));
		
		$content = preg_replace("/^(<\/[A-Za-z1-9]>)(.*?<[A-Za-z1-9][^>]*>)/s", "$2", $content);
		$content = preg_replace("/(<\/[A-Za-z1-9]>.*?)(<[A-Za-z1-9][^>]*>$)/s", "$1", $content);
		
		$html[] = '<div class="well'
			.((trim($size) != '' && trim($size) != 'default') ? ' well-' . trim($size) : '')
			.((trim($class) != '') ? ' '.htmlspecialchars(trim($class)) : '')
			.
			'">'.Shortcodes_Parser::instance()->render($content).'</div>';
		unset($size, $class);
		return implode($html);
	}

	/* Video */
	public static function video($atts, $content)
	{
		$html = '';
		
		extract(Shortcodes_Parser::instance()->atts(array(
			"ratio" => '',
			"video_url" => '',
			"video_type" => '',
			"video_id" => ''
		), $atts));	
		
		$ratio = str_replace(':', 'by', $ratio);
		$vid = $video_id;
		$url = '';
		if(strpos($video_url, 'youtu') || $video_type == 'youtube'){
			if(strpos($video_url, 'youtu')){
				preg_match('#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=embed\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#', $video_url, $id);
				if ($id){
					$vid = $id[0];
				}
			}
			$url = 'http://www.youtube.com/embed/'.$vid;
		} elseif (strpos($video_url, 'vimeo') || $video_type == 'vimeo') {
			if(strpos($video_url, 'vimeo')){
				$jsonResponse = @file_get_contents('http://vimeo.com/api/oembed.json?url='.$video_url);
				if ($jsonResponse) {
					$jsonResponse = json_decode($jsonResponse);
					$vid = $jsonResponse->video_id;
				}
			}
			$url = 'http://player.vimeo.com/video/'.$vid;
		}
		$html .= '<div class="video-sc embed-responsive embed-responsive-'.$ratio.'">'
			.'<iframe class="embed-responsive-item" src="'.$url.'" allowfullscreen=""></iframe>'
		.'</div>';
		return $html;
	}
}

/**
 * Register all tags
 */
foreach(get_class_methods('Shortcodes_Handlers') as $tag) {
	Shortcodes_Parser::instance()->add($tag, array( 'Shortcodes_Handlers', $tag ));
}
