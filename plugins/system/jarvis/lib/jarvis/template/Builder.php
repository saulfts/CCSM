<?php
/**
 * @package     Jarvis
 *
 * @copyright   Copyright (C) 2009 - 2014 Omegatheme.com. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @website:  http://www.omegatheme.com
 *  Support Forum - http://www.omegatheme.com/forum/
 * 
 * @version $Id: Builder.php 39 2014-09-12 02:26:45Z linhnt $
 */
namespace Jarvis\Template;

defined('_JEXEC') or die('Access denied!');

class Builder
{
  protected static $instance;

  protected $document;
  protected $template;
  protected $params;

  protected $systemFonts = array(
    'arial'       => 'Arial, Helvetica, sans-serif',
    'arial-black'   => '"Arial Black", Gadget, sans-serif',
    'comic-sans'    => '"Comic Sans MS", cursive, sans-serif',
    'impact'      => 'Impact, Charcoal, sans-serif',
    'lucida-sans'   => '"Lucida Sans Unicode", "Lucida Grande", sans-serif',
    'tahoma'      => 'Tahoma, Geneva, sans-serif',
    'trebuchet-ms'    => '"Trebuchet MS", Helvetica, sans-serif',
    'verdana'     => 'Verdana, Geneva, sans-serif',
    'courier-new'   => '"Courier New", Courier, monospace',
    'lucida-console'  => '"Lucida Console", Monaco, monospace'
  );

  public static function instance() {
    if (self::$instance == null) {
      self::$instance = new self();

      if (self::$instance->params == null) {
        $document = \JFactory::getDocument();
      }
    }

    return self::$instance;
  }

  private function __construct() {
    $this->document = \JFactory::getDocument();
    $this->template = $this->document->template;
    $this->params   = $this->document->params;
  }

  public function head() {
      
    $customCode = array();
    
    if ($this->params['enableResponsive'] == 1) {
      $customCode[] = '<meta name="viewport" content="width=device-width, initial-scale=1">';
    }
    
    if (!empty($this->params['bookmarkIcon'])) {
      $extension = pathinfo($this->params['bookmarkIcon'], PATHINFO_EXTENSION);
      $href = \JURI::root(true) . '/' . $this->params['bookmarkIcon'];
      $types = array(
        'png' => 'image/png',
        'ico' => 'image/x-icon',
        'gif' => 'image/gif'
      );

      $customCode[] = "<link rel=\"Shortcut Icon\" type=\"{$types[$extension]}\" href=\"{$href}\" />";
    }

    if (!empty($this->params['xsmallIcon'])) {
      $href = \JURI::root(true) . '/' . $this->params['xsmallIcon'];
      $customCode[] = "<link rel=\"apple-touch-icon-precomposed\" sizes=\"57x57\" href=\"{$href}\" />";
    }
    if (!empty($this->params['smallIcon'])) {
      $href = \JURI::root(true) . '/' . $this->params['smallIcon'];
      $customCode[] = "<link rel=\"apple-touch-icon-precomposed\" sizes=\"72x72\" href=\"{$href}\" />";
    }
    if (!empty($this->params['mediumIcon'])) {
      $href = \JURI::root(true) . '/' . $this->params['mediumIcon'];
      $customCode[] = "<link rel=\"apple-touch-icon-precomposed\" sizes=\"114x114\" href=\"{$href}\" />";
    }
    if (!empty($this->params['largeIcon'])) {
      $href = \JURI::root(true) . '/' . $this->params['largeIcon'];
      $customCode[] = "<link rel=\"apple-touch-icon-precomposed\" sizes=\"144x144\" href=\"{$href}\" />";
    }

    $this->schemes();
    $this->typography();

    // Disable Responsive
    if ($this->params['enableResponsive'] == 0) {
      $this->document->addStyleDeclaration("
        body {
          min-width: {$this->params['layoutWidth']}{$this->params['layoutWidthUnit']} !important;
        }
        .container {
          width: {$this->params['layoutWidth']}{$this->params['layoutWidthUnit']} !important;
        }
      ");
    }

    // Custom css
    if (!empty($this->params['customCSS'])) {
      $this->document->addStyleDeclaration($this->params['customCSS']);
    }

    if (!empty($this->params['scriptAnalytics']) && $this->params['analyticsPosition'] == 'head') {
      $this->document->addScriptDeclaration($this->params['scriptAnalytics']);
    }
    if (!empty($this->params['customScriptHead'])) {
      $this->document->addScriptDeclaration($this->params['customScriptHead']);
    }

    $this->document->addCustomTag(
      implode("\r\n  ", $customCode)
    );

    if (($this->params['layoutStyle'] == 'boxed') || (isset($this->params['styleSwitcher']) && $this->params['styleSwitcher'] == 1)) {
      $maxWidth   = intval($this->params['layoutWidth']);
      $maxWidthUnit = $this->params['layoutWidthUnit'];

      $marginTop    = intval('0' . $this->params['boxedMarginTop']);
      $marginBottom = intval('0' . $this->params['boxedMarginBottom']);

      $this->document->addStyleDeclaration("
        .boxed .wrapper {
          max-width: {$maxWidth}{$maxWidthUnit};
        }
        .boxed .body-bg {
          padding-top: {$marginTop}px;
          padding-bottom: {$marginBottom}px;
        }
      ");
            
      if ($this->params['backgroundImage'] != '') {
        $url = \JURI::root() . $this->params['backgroundImage'];
        $this->document->addStyleDeclaration("
          .boxed .body-bg {
            background-image: url({$url});
          }
        ");
      }
      else
      if ($this->params['boxedBackground'] != 'none') {
        $url = \JURI::root(true) . "/templates/{$this->template}/assets/images/patterns/{$this->params['boxedBackground']}";
        $this->document->addStyleDeclaration("
          .boxed .body-bg {
            background-image: url({$url});
          }
        ");
      }
    }

    // Style Switcher
    if (isset($this->params['styleSwitcher']) && $this->params['styleSwitcher'] == 1) {
      $this->document->addScript(\JURI::root(true) . '/plugins/system/jarvis/assets/3rd/jquery-cookie/cookie.js');
      $this->document->addScript(\JURI::root(true) . '/plugins/system/jarvis/assets/3rd/jquery-populate/populate.js');

      $this->document->addStylesheet(\JURI::root(true) . '/plugins/system/jarvis/assets/css/style-switcher.css');
      $this->document->addScript(\JURI::root(true) . '/plugins/system/jarvis/assets/js/style-switcher.js');
      $this->document->addScriptDeclaration(
        sprintf('
        (function($) {
          "use strict";

          $(function() {
            StyleSwitcher.init(%s);
          });
        }).call(this, jQuery);
        ', json_encode(array(
          'templateURI' => \JURI::root(true) . "/templates/{$this->template}",
          'defaultColor' => $this->params['templateColor'],
          'schemes' => \Jarvis\Template\Helper::getSchemes($this->template),
          'patterns' => \Jarvis\Template\Helper::getPatterns($this->template),
          'layout' => $this->params['layoutStyle'],
          'scheme' => $this->params['templateColor']
        ))
      ));

      ob_start();
      include JARVIS_ROOT . '/lib/jarvis/tmpl/js-partials/style-switcher-template.php';

      $content = ob_get_clean();
      $this->document->addCustomTag("
        <script type=\"text/template\" id=\"style-switcher-template\">
          {$content}
        </script>
      ");
    }

    echo '<jdoc:include type="head" />';
  }

  public function foot() {
    $code = array();

    if (!empty($this->params['scriptAnalytics']) && $this->params['analyticsPosition'] == 'body') {
      $code[] = $this->params['scriptAnalytics'];
    }
    if (!empty($this->params['customScriptBody'])) {
      $code[] = $this->params['customScriptBody'];
    }

    echo '<script type="text/javascript">', implode("\r\n  ", $code), '</script>';
  }

  public function bodyClasses() {
    $classes = array();

    if (!empty($this->params['layoutStyle']))
      $classes[] = $this->params['layoutStyle'];

    echo implode(' ', $classes);
  }
  public function layout() {
        $layoutConfig = json_decode($this->params->get('layoutConfig'), true);
        $layoutSections = array();
        
        foreach($layoutConfig as $rowParams) {
            $section = new LayoutSection($rowParams);
            $layoutSections[] = $section->render();
        }
        
        echo implode("\r\n", $layoutSections);
  }

  private function schemes() {
    if (isset($this->params['templateColor'])) {
      $id = $this->params['templateColor'];
      $schemes = \Jarvis\Template\Helper::getSchemes($this->template);

      if ($this->params['styleSwitcher'] == 1 && isset($_COOKIE['_template_config'])) {
        $id = $_COOKIE['_template_config'];
      }

      if (isset($schemes[$id])) {
        $cssFile = \JURI::root(true) . "/templates/{$this->template}/assets/css/{$schemes[$id]['cssFile']}";
      }
      else {
        $default = array_shift($schemes);
        $cssFile = \JURI::root(true) . "/templates/{$this->template}/assets/css/{$default['cssFile']}";
      }

      $this->document->addStylesheet($cssFile, 'text/css', null, array('id' => 'template-scheme'));
    }
  }

  private function typography() {
    // Load fonts
    $googleFonts = array();
    $additionStyles = array();

    if (!isset($this->systemFonts[$this->params['generalFont']])) {
      $googleFonts[$this->params['generalFont']] =  $this->fontInfo($this->params['generalFont']);
    }

    if (!isset($this->systemFonts[$this->params['headingFont']])) {
      $googleFonts[$this->params['headingFont']] =  $this->fontInfo($this->params['headingFont']);
    }

    if (!empty($this->params['additionStyles']) && is_array($this->params['additionStyles'])) {
      foreach($this->params['additionStyles'] as $style) {
        $additionStyles[] = $style = json_decode($style, true);
        
        if (!isset($this->systemFonts[$style['font-family']])) {
          $googleFonts[$style['font-family']] =  $this->fontInfo($style['font-family']);
        }
      }
    }

    $fontQuery = array();
    foreach($googleFonts as $name => $options) {
      $fontQuery[] = sprintf('%s:%s', $name, implode(':', $options['variants']));
    }

    // Load custom font
    $this->document->addStylesheet(sprintf('//fonts.googleapis.com/css?family=%s', implode('|', $fontQuery)));

    /**
     * General typography
     */
    $generalFamily = isset($this->systemFonts[$this->params['generalFont']])
      ? $this->systemFonts[$this->params['generalFont']]
      : $googleFonts[$this->params['generalFont']]['family'];

    $this->document->addStyleDeclaration("\tbody {
      font: {$this->params['generalSize']}{$this->params['generalSizeUnit']}/{$this->params['generalLineHeight']}{$this->params['generalLineHeightUnit']} {$generalFamily}; 
      line-height: {$this->params['generalLineHeight']}{$this->params['generalLineHeightUnit']};
      color: {$this->params['generalColor']}; }\r\n");

    /**
     * Heading typography
     */
    $headingFamily = isset($this->systemFonts[$this->params['headingFont']])
      ? $this->systemFonts[$this->params['headingFont']]
      : $googleFonts[$this->params['headingFont']]['family'];

    $this->document->addStyleDeclaration("\th1, h2, h3, h4, h5, h6 { font-family: {$headingFamily}; }\r\n");

    foreach(array('h1', 'h2', 'h3', 'h4', 'h5', 'h6') as $tag) {
      $size = "{$tag}Size";
      $sizeUnit = "{$tag}SizeUnit";

      $lineHeight = "{$tag}LineHeight";
      $lineHeightUnit = "{$tag}LineHeightUnit";

      $color = "{$tag}Color";
      $fontStyle = "{$tag}Style";
      
      $tagCSS = array();
      $tagCSS[] = "\t{$tag} {
        font-size: {$this->params[$size]}{$this->params[$sizeUnit]};
        line-height: {$this->params[$lineHeight]}{$this->params[$lineHeightUnit]};
        color: {$this->params[$color]};";
        
      if(in_array('bold', (array)$this->params[$fontStyle])) {
        $tagCSS[] = "font-weight: bold;";
      }
      if(in_array('italic', (array)$this->params[$fontStyle])) {
        $tagCSS[] = "font-style: italic;";
      }
      if (in_array('underline', (array)$this->params[$fontStyle]) || in_array('strikethrough', (array)$this->params[$fontStyle])) {
        $textDecoration = "text-decoration:";

        if (in_array('underline', (array)$this->params[$fontStyle]))
          $textDecoration.= " underline";

        if (in_array('strikethrough', (array)$this->params[$fontStyle]))
          $textDecoration.= " line-through";

        $tagCSS[] = $textDecoration . ";";
        $textDecoration = '';
      }
      $tagCSS[] = "}\r\n";
      $this->document->addStyleDeclaration(implode($tagCSS));
    }

    // Generate css for additional styles
    foreach($additionStyles as $style) {
      $fontStyles = array();

      if (in_array('bold', $style['font-style']))
        $fontStyles[] = "font-weight: bold;";

      if (in_array('italic', $style['font-style']))
        $fontStyles[] = "font-style: italic;";

      if (in_array('underline', $style['font-style']) || in_array('strike', $style['font-style'])) {
        $textDecoration = "text-decoration:";

        if (in_array('underline', $style['font-style']))
          $textDecoration.= ' underline';

        if (in_array('strike', $style['font-style']))
          $textDecoration.= ' line-through';

        $fontStyles[] = $textDecoration . ';';
      }

      $fontStyles = implode(' ', $fontStyles);
      $fontFamily = isset($this->systemFonts[$style['font-family']])
        ? $this->systemFonts[$style['font-family']]
        : $googleFonts[$style['font-family']]['family'];

      $this->document->addStyleDeclaration("\t/* {$style['style-name']} */\r\n");
      $this->document->addStyleDeclaration("\t{$style['selector']} {
        font-family: {$fontFamily};
        font-size: {$style['font-size']}px;
        {$fontStyles}
        line-height: {$style['line-height']}px;
        color: {$style['color']} }\r\n");
    }
  }

  private function fontInfo($name) {
    if (!\Jarvis\Jarvis::has('jarvis.webfonts')) {
      $listFile = JARVIS_ROOT . '/assets/fonts.json';

      if (is_file($listFile) && is_readable($listFile)) {
        \Jarvis\Jarvis::set('jarvis.webfonts', json_decode(
          file_get_contents($listFile),
          true
        ));
      }
    }

    $fonts = \Jarvis\Jarvis::get('jarvis.webfonts');

    return isset($fonts[$name]) ? $fonts[$name] : false;
  }
  
  public static function isHomepage() {
    $app = \JFactory::getApplication();
    $menu = $app->getMenu();
    $lang = \JFactory::getLanguage();
    return ($menu->getActive() == $menu->getDefault($lang->getTag()));
  }
}
