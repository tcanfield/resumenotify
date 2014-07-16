<?php
namespace Craft;

class ResumeNotifyPlugin extends BasePlugin
{

    function getName()
    {
         return Craft::t('Resume Notify');
    }

    function getVersion()
    {
        return '1.0';
    }

    function getDeveloper()
    {
        return 'Tyler Canfield';
    }

    function getDeveloperUrl()
    {
        return 'https://github.com/tcanfield/';
    }
    
    protected function defineSettings(){ 
    	return array(
    				'eAddress'  => array(AttributeType::String, 'required' => true));
    }

    
    /**
    *gives the plugin its own Control Panel section
    *
    */
    public function getSettingsHtml(){
			return craft()->templates->render('resumenotify/_settings', array('settings' => $this->getSettings()));    
    }
}