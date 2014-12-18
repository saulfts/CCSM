<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:	http://www.omegatheme.com
 *	Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version	$Id: Helper.php 14 2014-07-17 04:49:10Z linhnt $
 */
 
namespace Jarvis\Template;

defined('_JEXEC') or die('Access denied!');

class Helper
{
	private static $templateDetails = array();
	private static $templatePositions = array();
	private static $templateManifest = array();

	public static function getPositions($template) {
		if (!isset(self::$templatePositions[$template])) {
			self::$templatePositions[$template] = array();

			foreach(self::getXML($template)->positions->position as $position) {
				self::$templatePositions[$template][] = (string) $position;
			}
		}

		return self::$templatePositions[$template];
	}

	public static function getXML($template) {
		if (!isset(self::$templateDetails[$template])) {
			self::$templateDetails[$template] = simplexml_load_file(self::getPath($template) . '/templateDetails.xml');
		}

		return self::$templateDetails[$template];
	}

	public static function getPath($template) {
		return JPATH_ROOT . '/templates/' . $template;
	}

	public static function addPosition($template, $name) {
		$templateXml = file_get_contents(self::getPath($template) . '/templateDetails.xml');

		if (strpos($templateXml, '</positions>')) {
			$templateXml = str_replace('</positions>', "<position>{$name}</position></positions>", $templateXml);
			file_put_contents(self::getPath($template) . '/templateDetails.xml', $templateXml);
		}
	}

	public static function getManifestCache($template) {
		if (!isset(self::$templateManifest[$template])) {
			$dbo = \JFactory::getDBO();
			$query = $dbo->getQuery(true);
			$query->select('manifest_cache')
						->from('#__extensions')
						->where($dbo->quoteName('name') . '=' . $dbo->quote($template))
						->limit(1);

			$dbo->setQuery($query);
			$manifest = $dbo->loadResult();

			self::$templateManifest[$template] = json_decode($manifest);
		}

		return self::$templateManifest[$template];
	}

	public static function getChromeStyles($template) {
		$templates = array('system', $template);
		$styles = array();

		foreach($templates as $template) {
			$modulesFilePath = JPATH_SITE . '/templates/' . $template . '/html/modules.php';

			// Is there modules.php for that template?
			if (file_exists($modulesFilePath)) {
				if (preg_match_all('/function[\s\t]*modChrome\_([a-z0-9\-\_]*)[\s\t]*\(/i',
					file_get_contents($modulesFilePath),
					$matches
				)) {
					$styles = array_merge($styles, $matches[1]);
				}
			}
		}

		return $styles;
	}

	public static function backup($styleId) {
		$dbo = \JFactory::getDBO();
		$query = $dbo->getQuery(true);
		$query->select('template, params')
				  ->from('#__template_styles')
				  ->where('id=' . intval($styleId));

		$dbo->setQuery($query);
		$params = $dbo->loadObject();

		header('Pragma: public'); 	// required
		header('Expires: 0');		// no cache
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Cache-Control: private',false);
		header('Content-Type: application/json');
		header('Content-Disposition: attachment; filename="' . $params->template . '_backup.json"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.strlen($params->params));	// provide file size
		header('Connection: close');

		echo $params->params;
		exit;
	}

	public static function restore($styleId) {
		//import joomlas filesystem functions, we will do all the filewriting with joomlas functions,
		//so if the ftp layer is on, joomla will write with that, not the apache user, which might
		//not have the correct permissions
		\jimport('joomla.filesystem.file');
		\jimport('joomla.filesystem.folder');
		 
		//this is the name of the field in the html form, filedata is the default name for swfupload
		//so we will leave it as that
		$fieldName = 'options-file';

		//any errors the server registered on uploading
		$fileError = $_FILES[$fieldName]['error'];

		if ($fileError > 0) {
			$errors = array(
				1 => \JText::_( 'FILE_TO_LARGE_THAN_PHP_INI_ALLOWS' ),
				2 => \JText::_( 'FILE_TO_LARGE_THAN_HTML_FORM_ALLOWS' ),
				3 => \JText::_( 'ERROR_PARTIAL_UPLOAD' ),
				4 => \JText::_( 'ERROR_NO_FILE' )
			);

			echo $errors[$fileError];
			exit;
		}
		 
		//check the file extension is ok
		$fileName = $_FILES[$fieldName]['name'];
		$uploadedFileNameParts = pathinfo( $fileName, PATHINFO_FILENAME );
		$uploadedFileExtension = pathinfo( $fileName, PATHINFO_EXTENSION );
		 
		if ($uploadedFileExtension != 'json') {
			echo \JText::_( 'INVALID_EXTENSION' );
			exit;
		}
		 
		//the name of the file in PHP's temp directory that we are going to move to our folder
		$fileTemp = $_FILES[$fieldName]['tmp_name'];
		 
		//lose any special characters in the filename
		$fileName = preg_replace("/[^A-Za-z0-9]/i", "-", $fileName);
		 
		//always use constants when making file paths, to avoid the possibilty of remote file inclusion
		$uploadPath = JPATH_SITE . '/tmp/' . $fileName;
		 
		if(!\JFile::upload($fileTemp, $uploadPath)) {
			echo \JText::_( 'ERROR_MOVING_FILE' );
			exit;
		}

		// Import options
		$options = json_decode(file_get_contents($uploadPath), true);

		if (!empty($options)) {
			$dbo = \JFactory::getDBO();
			$query = $dbo->getQuery(true);
			$query->update('#__template_styles')
						->set('params=' . $dbo->quote(json_encode($options)))
						->where('id=' . intval($styleId));

			$dbo->setQuery($query);
			$dbo->execute();
		}

		echo 'done';
		exit;
	}

	public static function getSchemes($template) {
		$schemes = array();
		$manifest = self::getXML($template);

		foreach($manifest->schemes->scheme as $schemeXml) {
			$scheme				= array();
			$scheme['cssFile']	= (string) $schemeXml['cssFile'];
			$scheme['color']	= (string) $schemeXml['color'];
			$schemes[(string) $schemeXml['id']] = $scheme;
		}

		return $schemes;
	}

	public static function getPatterns($template) {
		$patterns = array();
		$path = JPATH_ROOT . "/templates/{$template}/assets/images/patterns";

		foreach(glob("{$path}/*") as $file) {
			if (is_dir($file))
				continue;

			$extension = pathinfo($file, PATHINFO_EXTENSION);
			$name = pathinfo($file, PATHINFO_FILENAME);

			if (in_array($extension, array('jpg', 'png', 'gif', 'svg'))) {
				$patterns[$name] = pathinfo($file, PATHINFO_BASENAME);
			}
		}

		return $patterns;
	}
}
