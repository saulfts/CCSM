<?php
/**
*	@version	$Id: omgshortcodes.php 5 2014-06-26 10:17:02Z linhnt $
*	@package	Jarvis Template Framework for Joomla!
*	@subpackage	shortcodes plugin for Joomla!
*	@copyright	Copyright (C) 2009 - 2014 Omegatheme. All rights reserved.
*	@license	GNU/GPL version 2, or later
*	@website:	http://www.omegatheme.com
*	Support Forum - http://www.omegatheme.com/forum/
*/

// no direct access
if((int)JVERSION == 3){
	defined('JPATH_PLATFORM') or die;
}else{
	defined('_JEXEC') or die ('Restricted access');
}

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

jimport('joomla.filesystem.folder');
jimport('joomla.filesystem.file');
jimport( 'joomla.plugin.plugin' );
jimport( 'joomla.html.parameter' );

require_once JPATH::clean(dirname(__FILE__) . "/inc/shortcodes-parser.php");
require_once JPATH::clean(dirname(__FILE__) . "/inc/shortcodes-handlers.php");

class plgSystemOmgShortcodes extends JPlugin
{
	var $document;
	var $_pluginPath;
	var $_pluginUri;
	var $_runmode;
	var $_bootstrap;
	var $_awesome;
	
	function __construct(&$subject, $config){
		parent::__construct($subject, $config);

		$this->document = JFactory::getDocument();
		$this->_pluginPath = JPATH_PLUGINS.DS."system".DS."omgshortcodes".DS;
		$this->_pluginUri = JURI::root()."plugins/system/omgshortcodes/";
		$this->_runmode = intval($this->params->get('runmode', 0));
		$this->_bootstrap = intval($this->params->get('load_bootstrap', 1));
		$this->_awesome = intval($this->params->get('load_awesome', 1));
		
		$language = JFactory::getLanguage();
		$language->load('plg_system_omgshortcodes');
	}
	
	public function onBeforeRender(){
		$app = JFactory::getApplication();
		$this->document->addStyleSheet($this->_pluginUri . "assets/css/all.css");

		if($app->isSite()) {
			if($this->_bootstrap==1)
			{
				$this->document->addScript($this->_pluginUri . "assets/js/bootstrap.min.js");
				$this->document->addStyleSheet($this->_pluginUri . "assets/css/bootstrap.min.css");
			}
			if($this->_awesome==1)
			{
				$this->document->addStyleSheet($this->_pluginUri . "assets/css/font-awesome.min.css");
			}
			
			$this->document->addScript($this->_pluginUri . "assets/js/all.js");
			$this->document->addScript($this->_pluginUri . "assets/js/imagesloaded.pkgd.min.js");
			$this->document->addScript($this->_pluginUri . "assets/js/isotope.pkgd.min.js");
			
			// $this->document->addScript($this->_pluginUri . "assets/js/cells-by-column.js");
			// $this->document->addScript($this->_pluginUri . "assets/js/cells-by-row.js");
			// $this->document->addScript($this->_pluginUri . "assets/js/fit-columns.js");
			// $this->document->addScript($this->_pluginUri . "assets/js/horizontal.js");
			// $this->document->addScript($this->_pluginUri . "assets/js/masonry-horizontal.js");
			
			$this->document->addScript("http://maps.googleapis.com/maps/api/js?language=".JFactory::getLanguage()->getTag());
		}
	}
	
	public function onAfterRender(){
		$app = JFactory::getApplication();
		if ($app->isSite()) {
			if ($this->_runmode != 0){
				$page = JResponse::GetBody();
				$page = Shortcodes_Parser::instance()->render($page);
				JResponse::SetBody($page);
			}
		}
	}
	
	public function onContentPrepare( $context, $article, $params, $page=0 ){
		if ($this->_runmode != 0)
			return;

		if (JFactory::getApplication()->isSite())
			$article->text = Shortcodes_Parser::instance()->render($article->text);

		return true;
	}
}
