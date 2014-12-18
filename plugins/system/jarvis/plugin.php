<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: plugin.php 14 2014-07-17 04:49:10Z linhnt $
 */
 
defined('_JEXEC') or die('Access denied!');

/**
 * 
 * @package     Jarvis
 */
class plgSystemJarvis extends JPlugin
{
	/**
	 * @var  JApplication
	 */
	private $app;

	/**
	 * @var  JDocumentHTML
	 */
	private $document;

	/**
	 * After initialise action
	 * 
	 * @return  void
	 */
	public function onAfterInitialise() {
		// Load language
		$this->loadLanguage();
		$this->app = JFactory::getApplication();
		$this->document = JFactory::getDocument();
		
		Jarvis\Jarvis::set('joomla.app', $this->app);
		Jarvis\Jarvis::set('joomla.document', $this->document);
		Jarvis\Jarvis::set('joomla.root', JUri::root(true));

		if ($this->app->isSite()) {
			$template = $this->app->getTemplate(true);
		}

		$user = JFactory::getUser();

		if ($this->app->isAdmin() && $user->authorise('core.edit', 'com_templates')) {
			$action = $this->app->input->getCmd('action');

			switch($action) {
				case 'jarvis.addPosition':
					$template = $this->app->input->getString('template');
					$position = $this->app->input->getString('name');

					if (!empty($template) && !empty($position))
						Jarvis\Template\Helper::addPosition($template, $position);
				break;

				case 'jarvis.backup':
					Jarvis\Template\Helper::backup($this->app->input->getInt('style'));
				break;

				case 'jarvis.restore':
					Jarvis\Template\Helper::restore($this->app->input->getInt('style'));
				break;
			}
		}
	}

	public function onContentPrepareForm($context, $data) {
		if (empty($data))
			return;
        
		if ($context->getName() == 'com_templates.style' &&
				Jarvis\Template\Detector::isSupported($data->template)) {

			$jarvisForm = new Jarvis\Form\Form('jarvis');
			// $jarvisForm->addFieldPath(JARVIS_ROOT . '/lib/jarvis/form/fields');
			$jarvisForm->loadFile(__DIR__ . '/lib/jarvis/form/base.xml');
			$jarvisForm->bind(array(
				'jarvis' => $data->params
			));

			Jarvis\Jarvis::set('joomla.form', $context);
			Jarvis\Jarvis::set('joomla.data', $data);
			Jarvis\Jarvis::set('joomla.styleId', $data->id);
			Jarvis\Jarvis::set('joomla.template', $data->template);
			Jarvis\Jarvis::set('joomla.templateManifest', Jarvis\Template\Helper::getManifestCache($data->template));
			Jarvis\Jarvis::set('joomla.positions', Jarvis\Template\Helper::getPositions($data->template));
			Jarvis\Jarvis::set('jarvis.form', $jarvisForm);
            Jarvis\Jarvis::set('jarvis.patterns', Jarvis\Template\Helper::getPatterns($data->template));
		}
	}

	public function onExtensionAfterSave($context, $data, $isNew = false) {
		if ($context == 'com_templates.style' && Jarvis\Template\Detector::isSupported($data->template)) {

			$app = JFactory::getApplication();
			$params = $app->input->getVar('jarvis');

			if (!empty($params)) {
				$data->params = json_encode($params);
				$data->store();
			}
		}
	}

	public function onBeforeRender() {
		if (Jarvis\Template\Detector::isEditMode() && Jarvis\Template\Detector::isSupported(Jarvis\Jarvis::get('joomla.template'))) {
			if (version_compare(JARVIS_JVERSION, '3.0', '<')) {
				$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery/jquery.js');
				$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery/jquery-no-conflict.js');
			}
			else {
				JHtml::_('jquery.framework');
			}

			$this->loadFonts();

			$this->document->addStylesheet(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery-colpick/colpick.css');
			$this->document->addStylesheet(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery-chosen/chosen.css');
			$this->document->addStylesheet(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/codemirror/codemirror.css');
			$this->document->addStylesheet(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/css/admin.css');
			
			JHtml::_('behavior.modal');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery-ui/jquery-ui.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery-colpick/colpick.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery-cookie/cookie.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery-chosen/chosen.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery-populate/populate.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/jquery-serialize-form/serialize-form.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/3rd/codemirror/codemirror.js');
			
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/js/admin.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/js/admin-map-position.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/js/admin-styles.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/js/admin-layout.js');
			$this->document->addScript(Jarvis\Jarvis::get('joomla.root') . '/plugins/system/jarvis/assets/js/admin-menu.js');

			// Get chrome styles
			$chromeStyles = Jarvis\Template\Helper::getChromeStyles(Jarvis\Jarvis::get('joomla.template'));

			// Build the script.
			$script = array();
			$script[] = '	function jInsertFieldValue(value, id) {';
			$script[] = '		var old_value = document.id(id).value;';
			$script[] = '		if (old_value != value) {';
			$script[] = '			var elem = document.id(id);';
			$script[] = '			elem.value = value;';
			$script[] = '			elem.fireEvent("change");';
			$script[] = '			if (typeof(elem.onchange) === "function") {';
			$script[] = '				elem.onchange();';
			$script[] = '			}';
			$script[] = '		}';
			$script[] = '	}';

			// Add the script to the document head.
			$this->document->addScriptDeclaration(implode("\n", $script));
			$this->document->addScriptDeclaration('
				var _jarvisChromeStyles = ' . json_encode($chromeStyles) . ';
				
				(function($) {
					"use strict";

					$(function() {
						new $.JarvisAdmin({
							styleId: ' . Jarvis\Jarvis::get('joomla.styleId') . ',
							template: "' . Jarvis\Jarvis::get('joomla.template') . '",
							fonts: ' . json_encode(Jarvis\Jarvis::get('jarvis.webfonts')) . ',
							positions: ' . json_encode(Jarvis\Jarvis::get('joomla.positions')) . '
						});
					});
				})(jQuery);
			');
            $this->prepareTemplates();
		}
	}

	public function onAfterRender() {
		if (Jarvis\Template\Detector::isEditMode() &&
				Jarvis\Template\Detector::isSupported(Jarvis\Jarvis::get('joomla.template'))) {

			$adminView = new Jarvis\Template\AdminView();

			JResponse::setBody(
				preg_replace_callback(
					'/<form[^>]+name="adminForm"[^>]*>.*<\/form>/is',
					array(
						$adminView,
						'componentForm'
					), 
					preg_replace_callback(
						'/<body([^>]*)>/',
						array(
							$adminView,
							'bodyAttributes'
						),
						JResponse::getBody()
					)
				)
			);
		}
	}

	protected function loadFonts() {
		$listFile = JARVIS_ROOT . '/assets/fonts.json';

		if (is_file($listFile) && is_readable($listFile)) {
			Jarvis\Jarvis::set('jarvis.webfonts', json_decode(
				file_get_contents($listFile),
				true
			));
		}
	}

	protected function prepareTemplates() {
		$path = JARVIS_ROOT . '/lib/jarvis/tmpl/js-partials';
		foreach(glob("{$path}/*.php") as $file) {
			$id = pathinfo($file, PATHINFO_FILENAME);
			ob_start();
			include $file;
			$content = ob_get_clean();
            
			$this->document->addCustomTag("
				<script type=\"text/template\" id=\"{$id}\">
					{$content}
				</script>
			");
		}
	}
}
