<?php
// no direct access
defined('_JEXEC') or die();

JLoader::import('joomla.filesystem.folder');
JLoader::import('joomla.filesystem.file');

class pkg_SmartsolutionsInstallerScript
{
  protected $_template = 'ot_smartsolutions';
  function postflight( $type, $parent )
	{
    $db = JFactory::getDBO();
    if(!JPluginHelper::getPlugin('system', 'jarvis') && JFile::exists(JPATH_SITE . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'jarvis' . DIRECTORY_SEPARATOR . 'jarvis.php')){
			
			$query = "UPDATE #__extensions SET enabled='1' WHERE element='jarvis'";
			$db->setQuery($query);
			$db->query();
		}
        
        if ($type == 'install') {           
            $optionFile = JPATH_SITE . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $this->_template . DIRECTORY_SEPARATOR . $this->_template . '_oem.json';
            if (!JFile::exists($optionFile)) return;
            $options = file_get_contents($optionFile);
            if (empty($options)) return;
            unset($query);
            $query = $db->getQuery(true);
            try {
                $query->update('#__template_styles')
                    ->set('params=' . $db->quote($options))
                    ->where('template=' . $db->quote($this->_template));
                $db->setQuery($query);
                $db->execute();
            }
            catch (Exception $e) {
                JFactory::getApplication()->enqueueMessage(JText::_('Default options was NOT added! Please use RESTORE function in "Template Manager: Edit Style" page at "Advanced > Maintenance" section.'), 'warning');
                return;
            }
        }
    }

}