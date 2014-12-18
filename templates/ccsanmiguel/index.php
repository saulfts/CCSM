<?php
use Jarvis\Template\Builder;

$doc = JFactory::getDocument();
// Add Stylesheets
$doc->addStyleSheet('templates/'.$this->template.'/assets/css/template.css');
// Add JavaScripts
JHtml::_('jquery.framework');
$doc->addScript('templates/' .$this->template. '/assets/js/bootstrap.min.js');
$doc->addScript('templates/' .$this->template. '/assets/js/otscript.js');
$doc->addScript('templates/' .$this->template. '/assets/js/wow.js');
$doc->addScript('templates/' .$this->template. '/assets/js/jquery.mobile.custom.min.js');
// Add Fonts
// $doc->addStyleSheet('http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700');

$builder = Builder::instance();
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
	<head>
		<?php $builder->head() ?>
		<script>
			new WOW().init();
		</script>
	</head>
	<body id="ot-body" class="<?php $builder->bodyClasses() ?>">
		<div class="body-bg">
			<div class="clearfix"></div>
			<div class="wrapper">
				<?php $builder->layout() ?>
			</div>

			<?php $builder->foot() ?>
			<div class="clearfix"></div>
		</div>
	</body>
</html>