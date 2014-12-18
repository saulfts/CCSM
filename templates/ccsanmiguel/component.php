<?php
use Jarvis\Template\Builder;
$builder = Builder::instance();
$doc = JFactory::getDocument();
// Add Stylesheets
$doc->addStyleSheet('templates/'.$this->template.'/assets/css/font-awesome.min.css');
$doc->addStyleSheet('templates/'.$this->template.'/assets/css/bootstrap.min.css');
$doc->addStyleSheet('templates/'.$this->template.'/assets/css/bootstrap-extended.css');
$doc->addStyleSheet('templates/'.$this->template.'/assets/css/template.css');

// Add JavaScripts
JHtml::_('jquery.framework');
$doc->addScript('templates/' .$this->template. '/assets/js/bootstrap.min.js');
$doc->addScript('templates/' .$this->template. '/assets/js/otscript.js');

?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<?php $builder->head() ?>
		<jdoc:include type="head" />
	</head>
	<body id="ot-body" class="<?php $builder->bodyClasses() ?>">
		<div class="body-bg">
			<div class="clearfix"></div>
			<div class="wrapper">
					<jdoc:include type="message" />
                    <jdoc:include type="component" />
			</div>
			<div class="clearfix"></div>
		</div>
	</body>
</html>