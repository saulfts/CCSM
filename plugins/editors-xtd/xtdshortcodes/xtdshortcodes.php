<?php
/**
*	@version	$Id: xtdshortcodes.php 5 2014-06-26 10:17:02Z linhnt $
*	@package	Jarvis Template Framework for Joomla!
*	@subpackage	shortcodes plugin for Joomla!
*	@copyright	Copyright (C) 2009 - 2014 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

defined('_JEXEC') or die;

/**
 * Editor Image buton
 *
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.image
 * @since       1.5
 */
class PlgButtonXtdShortcodes extends JPlugin
{
	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	protected $shortcodes = array(
			'quote' => array(
				'name'		=> "Blockquote",
				'desc'		=> "Blockquote",
				'syntax'	=> "[quote class=\"\" width=\"auto\" align=\"none\" border=\"#666\" color=\"#666\" reverse=\"\" title=\"TITLE\" footer=\"FOOTER\"]CONTENT[/quote]"
			),
			'button' => array(
				'name'		=> "Button",
				'desc'		=> "Bootstrap buttons",
				'syntax'	=> "[button class=\"\" type=\"primary\" size=\"default\" url=\"#\" disabled=\"false\"]CONTENT[/button]"
			),
			'carousel' => array(
				'name'		=> "Carousel",
				'desc'		=> "Bootstrap carousel",
				'syntax'	=> "<div class=\"sc-wrapper\">[carousel max_width=\"400px\" class=\"\"]<br/>[carousel_item title=\"TITLE\" class=\"active\" image=\"IMAGE_SRC\"]DESCRIPTION[/carousel_item]<br/>[carousel_item title=\"TITLE\" class=\"\" image=\"IMAGE_SRC\"]DESCRIPTION[/carousel_item]<br/>[carousel_item title=\"TITLE\" class=\"\" image=\"IMAGE_SRC\"]DESCRIPTION[/carousel_item]<br/>[/carousel]</div><p></p>"
			),
			'clearfix' => array(
				'name'		=> "Clearfix",
				'desc'		=> "Clearfix",
				'syntax'	=> "[clearfix /]"
			),
			'collapse' => array(
				'name'		=> "collapse",
				'desc'		=> "Bootstrap Collapse",
				'syntax'	=> "<div class=\"sc-wrapper\">[collapse class=\"\"]<br/>[collapse_item type=\"default\" title=\"ITEM_TITLE\"]ADD_CONTENT_HERE[/collapse_item]<br/>[collapse_item type=\"default\" title=\"ITEM_TITLE\"]ADD_CONTENT_HERE[/collapse_item]<br/>[collapse_item type=\"default\" title=\"ITEM_TITLE\"]ADD_CONTENT_HERE[/collapse_item]<br/>[/collapse]</div><p></p>",
			),
			'column' => array(
				'name'		=> "Column",
				'desc'		=> "Column",
				'syntax'	=> "<div class=\"sc-wrapper\">[columns]<br />[column xs=\"4\" xs_offset=\"0\" sm=\"4\" sm_offset=\"0\" md=\"4\" md_offset=\"0\" lg=\"4\" lg_offset=\"0\" class=\"\"]<div>ADD_CONTENT_HERE</div>[/column]<br />[column xs=\"4\" xs_offset=\"0\" sm=\"4\" sm_offset=\"0\" md=\"4\" md_offset=\"0\" lg=\"4\" lg_offset=\"0\" class=\"\"]<div>ADD_CONTENT_HERE</div>[/column]<br />[column xs=\"4\" xs_offset=\"0\" sm=\"4\" sm_offset=\"0\" md=\"4\" md_offset=\"0\" lg=\"4\" lg_offset=\"0\" class=\"\"]<div>ADD_CONTENT_HERE</div>[/column]<br />[/columns]</div><p></p>"
			),
			'currentdate' => array(
				'name'		=> "Current Date",
				'desc'		=> "Current date",
				'syntax'	=> "[currentdate format=\"D M j Y\"]<br/>"
			),
			'dropcap' => array(
				'name'		=> "Dropcap",
				'desc'		=> "Dropcap on first character of paragraph",
				'syntax'	=> "[dropcap color=\"#000000\" background=\"#\" type=\"default\" class=\"\"]CHARACTER[/dropcap]"
			),
			'dropdown' => array(
				'name'		=> "Dropdown",
				'desc'		=> "Bootstrap Dropdown",
				'syntax'	=> "[dropdown icon=\"\" title=\"DROPDOWN_TITLE\" type=\"default\" class=\"\"]<br/>[drop_item url=\"\"]ADD_LIST_CONTENT[/drop_item]<br/>[drop_item url=\"\"]ADD_LIST_CONTENT[/drop_item]<br/>[/dropdown]"
			),
			'divider' => array(
				'name'		=> "Divider",
				'desc'		=> "Divider",
				'syntax'	=> "[divider type=\"\" margin=\"2em 0 2em 0\" class=\"\"]<br/>"
			),
			'gallery' => array(
				'name'		=> "Gallery",
				'desc'		=> "Gallery",
				'syntax'	=> "[gallery title=\"GALLERY_TITLE\" layout=\"masonry\" datafilter=\"\"  colwidth=\"\" rowheight=\"\" gutter=\"\"  width=\"\" height=\"\"]<br/>[gallery_item title=\"IMAGE_TITLE\" src=\"IMAGE_SRC\" video_addr=\"VIDEO_ADDRESS\" width=\"IMAGE_THUMB_WIDTH\" height=\"IMAGE_THUMB_HEIGHT\" filter=\"\"]IMAGE_DESCRIPTION[/gallery_item]<br/>[gallery_item title=\"IMAGE_TITLE\" src=\"IMAGE_SRC\" video_addr=\"VIDEO_ADDRESS\" width=\"IMAGE_THUMB_WIDTH\" height=\"IMAGE_THUMB_HEIGHT\" filter=\"\"]IMAGE_DESCRIPTION[/gallery_item]<br/>[gallery_item title=\"IMAGE_TITLE\" src=\"IMAGE_SRC\" video_addr=\"VIDEO_ADDRESS\" width=\"IMAGE_THUMB_WIDTH\" height=\"IMAGE_THUMB_HEIGHT\" filter=\"\"]IMAGE_DESCRIPTION[/gallery_item]<br/>[/gallery]<br/>"
			),
			'googlefont' => array(
				'name'		=> "Google Font",
				'desc'		=> "Google Font",
				'syntax'	=> "[googlefont font_family=\"FONT_NAME\" size=\"14\" color=\"#666\" font_weight=\"normal\" align=\"none\" margin=\"1em 0 1em 0\"] ADD_CONTENT_HERE[/googlefont]<br/>"
			),
			'googlemap' => array(
				'name'		=> "Google Map",
				'desc'		=> "Google Map",
				'syntax'	=> "[googlemap iframe_src=\"\" ratio=\"16:9\" title=\"GOOLE_MAP_LABEL\" addr=\"ADDRESS OR Latitude/Longitude\" /]<br/>"
			),
			'icon' => array(
				'name'		=> "Icon",
				'desc'		=> "Glyphicon or Awesome icons",
				'syntax'	=> "[icon type=\"glyphicon|awesome\" name=\"heart\" size=\"font_size\" color=\"default\" class=\"\" /]"
			),
			'list' => array(
				'name'		=> "List Style",
				'desc'		=> "List Style",
				'syntax'	=> "[list class=\"\" type=\"disc\" color=\"\"]<br/>[list_item]ADD_LIST_CONTENT[/list_item] <br/>[list_item]ADD_LIST_CONTENT[/list_item] <br/>[/list]"
			),
			'br' => array(
				'name'		=> "Line Break",
				'desc'		=> "Line Break",
				'syntax'	=> "[br]<br/>"
			),
			'message' => array(
				'name'		=> "Message box",
				'desc'		=> "Bootstrap alert message box",
				'syntax'	=> "<div class=\"sc-wrapper\">[message title=\"TITLE\" type=\"info\" block=\"false\" showclose=\"true\" class=\"\"]CONTENT[/message]</div><p></p>"
			),
			'modal' => array(
				'name'		=> "Modal",
				'desc'		=> "Bootstrap modal box",
				'syntax'	=> "<div class=\"sc-wrapper\">[modal type=\"static|url|iframe\" size=\"default|large|small\" id=\"\" class=\"btn\" title=\"BUTTON_TEXT\" header=\"HEADER_TEXT_OF_MODAL\" footer=\"true\" href=\"\"]<p>CONTENT</p>[/modal]</div><p></p>"
			),
			'module' => array(
				'name'		=> "Module",
				'desc'		=> "Load module",
				'syntax'	=> "<div class=\"sc-wrapper\">[module class=\"\" type=\"module|position\" params=\"\" modstyle=\"none\" /]</div><p></p>"
			),
			'panel' => array(
				'name'		=> "Panel",
				'desc'		=> "Bootstrap Panel",
				'syntax'	=> "<div class=\"sc-wrapper\">[panel type=\"default\" id=\"\" class=\"\" title=\"PANEL_TITLE\" footer=\"PANEL_FOOTER\" ]<p>CONTENT</p>[/panel]</div><p></p>"
			),
			'oprettycode' => array(
				'name'		=> "PrettyCode",
				'desc'		=> "Display code snippets in pretty format",
				'syntax'	=> "<div class=\"sc-wrapper\">[oprettycode lang=\"css\" linenums=\"true\" startnum=\"1\"]<div>PASTE_YOUR_CODE_HERE</div>[/oprettycode]</div><p></p>"
			),
			'pricing' => array(
				'name'		=> "Pricing Tables",
				'desc'		=> "Pricing Tables",
				'syntax'	=> "[pricing columns=\"3\"]<br/>[plan title=\"PRICING_TITLE\" button_link=\"http://\" button_label=\"PRICING_BUTTON_LABEL\" price=\"$0\" featured=\"true/false\" per=\"month\" type=\"\" class=\"\"]<br/>[planrow class=\"\" icon=\"\"]TEXT_OF_PLAN[/planrow]<br/>[planrow class=\"\" icon=\"\"]TEXT_OF_PLAN[/planrow]<br/>[/plan]<br/>[plan title=\"PRICING_TITLE\" button_link=\"http://\" button_label=\"PRICING_BUTTON_LABEL\" price=\"$30\" featured=\"true/false\" per=\"month\" type=\"\" class=\"\"]<br/>[planrow class=\"\" icon=\"\"]TEXT_OF_PLAN[/planrow]<br/>[planrow class=\"\" icon=\"\"]TEXT_OF_PLAN[/planrow]<br/>[/plan]<br/>[plan title=\"PRICING_TITLE\" button_link=\"http://\" button_label=\"PRICING_BUTTON_LABEL\" price=\"$70\" featured=\"true/false\" per=\"month\" type=\"\" class=\"\"]<br/>[planrow class=\"\" icon=\"\"]TEXT_OF_PLAN[/planrow]<br/>[planrow class=\"\" icon=\"\"]TEXT_OF_PLAN[/planrow]<br/>[/plan]<br/>[/pricing]"
			),
			'progress' => array(
				'name'		=> "Progress bar",
				'desc'		=> "Progress bar",
				'syntax'	=> "<div class=\"sc-wrapper\" style=\"clear:both;\">[progress type=\"\" striped=\"true|false\" active=\"true|false\" class=\"\" height=\"20px\" value=\"50\" /]</div><p></p>"
			),
			'social' => array(
				'name'		=> "Social",
				'desc'		=> "Social",
				'syntax'	=> "[social mode=\"facebook_fanpage|facebook_like|twitter_follow|twitter_tweet\" class=\"\" name=\"\" width=\"\" height=\"\" /]",
			),
			'spacer' => array(
				'name'		=> "Spacer",
				'desc'		=> "Add a spacer with specified amount",
				'syntax'	=> "<div class=\"sc-wrapper\" style=\"clear:both;\">[spacer height=\"20px\"/]</div><p></p>"
			),
			'tabs' => array(
				'name'		=> "Tabs",
				'desc'		=> "Bootstrap Tabs",
				'syntax'	=> "<div class=\"sc-wrapper\">[tabs max_width=\"\" class=\"\"]<br/>[tab title=\"TITLE\"]<div>CONTENT</div>[/tab]<br/>[tab title=\"TITLE\"]<div>CONTENT</div>[/tab]<br/>[tab title=\"TITLE\"]<div>CONTENT</div>[/tab]<br/>[/tabs]</div><p></p>"
			),
			'testimonial' => array(
				'name'		=> "Testimonial",
				'desc'		=> "Testimonial",
				'syntax'	=> "[testimonial author=\"TESTIMONIAL_AUTHOR\" position=\"AUTHOR_POSITION\" avatar=\"URL_IMAGES\"]ADD_TESTIMONIAL_HERE[/testimonial]"
			),
			'tooltip' => array(
				'name'		=> "Tooltip",
				'desc'		=> "Bootstrap tooltip",
				'syntax'	=> "[tooltip position=\"top\" mode=\"text\" title=\"TOOLTIP_TEXT\" container=\"false\"]CONTENT[/tooltip] "
			),
			'well' => array(
				'name'		=> "Well text box",
				'desc'		=> "Bootstrap WELL text box",
				'syntax'	=> "<div class=\"sc-wrapper\">[well size=\"default\" class=\"\"]<div>CONTENT</div>[/well]</div><p></p>"
			),
			'video' => array(
				'name'		=> "Video",
				'desc'		=> "Add a video in content",
				'syntax'	=> "<div class=\"sc-wrapper\">[video ratio=\"4:3|16:9\" video_url=\"\" video_type=\"youtube|vimeo\" video_id=\"\" /]</div><p></p>"
			)
	);

	/**
	 * Display the button.
	 *
	 * @param   string   $name    The name of the button to display.
	 * @param   string   $asset   The name of the asset being edited.
	 * @param   integer  $author  The id of the author owning the asset being edited.
	 *
	 * @return  array    A two element array of (imageName, textToInsert) or false if not authorised.
	 */
	public function onDisplay($name, $asset, $author)
	{
		JFactory::getDocument()->addStylesheet( JURI::root(true) . '/plugins/editors-xtd/xtdshortcodes/assets/css/menu.css' );
		JFactory::getDocument()->addScript( JURI::root(true) . '/plugins/editors-xtd/xtdshortcodes/assets/js/menu.js' );
		JFactory::getDocument()->addScriptDeclaration('
			(function($) {
				"use strict";

				$(function() {
					$(\'a.btn-shortcodes\').shortcodeMenu({
						shortcodes: ' . json_encode($this->shortcodes) . ',
						editor: \'' . $name . '\'
					});
				});

			})(jQuery)
		');

		$button = new JObject;
		$button->modal = false;
		$button->class = 'btn btn-shortcodes';
		$button->link = '#';
		$button->text = 'Insert Shortcodes';
		$button->name = 'shortcodes';

		return $button;
	}
}
