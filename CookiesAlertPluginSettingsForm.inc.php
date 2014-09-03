<?php

/**
* @file CookiesAlertPluginSettingsForm.inc.php
*
* Copyright (c) 2014 UOC, Universitat Oberta de Catalunya
* Developed by Julià Mestieri (Journal Services -- http://journal-services.com)
* Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
*
* @class CookiesPlugin
* @ingroup plugins_generic_cookies
*
* @brief Cookies Alert form for journal managers to configure the cookies alert
*/


import('lib.pkp.classes.form.Form');

class CookiesAlertSettingsForm extends Form {

	/** @var $journalId int */
	var $journalId;

	/** @var $plugin object */
	var $plugin;

	/**
	 * Constructor
	 * @param $plugin object
	 * @param $journalId int
	 */
	function CookiesAlertSettingsForm(&$plugin, $journalId) {
		$this->journalId = $journalId;
		$this->plugin =& $plugin;

		parent::Form($plugin->getTemplatePath() . 'settingsForm.tpl');

	}

	/**
	 * Initialize form data.
	 */
	function initData() {
		$journalId = $this->journalId;
		$plugin =& $this->plugin;
    $site =& Request::getSite();
    $locales = $site->getSupportedLocales();
    // all aviable locales 
    $this->_data = array(
      'locales' => $locales
    );
    // array to store button and text for each locale
    $this->_data['cookiesAlertText'] =  array();
    $this->_data['cookiesAlertButton'] =  array();

    // values for each locale
    foreach($locales as $index => $locale) {
      $this->_data['cookiesAlertText'] +=  array($locale =>  $plugin->getSetting($journalId, 'cookiesAlertText' . $locale));
      $this->_data['cookiesAlertButton'] +=  array($locale => $plugin->getSetting($journalId, 'cookiesAlertButton' . $locale));
    }
    // some style options for every locale
    $this->_data['cookiesAlertStyleBd'] = $plugin->getSetting($journalId, 'cookiesAlertStyleBd');
    $this->_data['cookiesAlertStyleBgwrapper'] = $plugin->getSetting($journalId, 'cookiesAlertStyleBgwrapper');
    $this->_data['cookiesAlertStyleBgbutton'] = $plugin->getSetting($journalId, 'cookiesAlertStyleBgbutton');
	}

	/**
	 * Assign form data to user-submitted data.
	 */
	function readInputData() {
    $site =& Request::getSite();
    $locales = $site->getSupportedLocales();
    foreach($locales as $index => $locale) {
      $this->readUserVars(array('cookiesAlertButton'.$locale));
      $this->readUserVars(array('cookiesAlertText'.$locale));
    }
    $this->readUserVars(array('cookiesAlertStyleBd'));
    $this->readUserVars(array('cookiesAlertStyleBgbutton'));
    $this->readUserVars(array('cookiesAlertStyleBgwrapper'));
	}

	/**
	 * Save settings.
	 */
	function execute() {
		$plugin =& $this->plugin;
		$journalId = $this->journalId;
    $site =& Request::getSite();
    $locales = $site->getSupportedLocales();
    foreach($locales as $index => $locale) {
      $plugin->updateSetting($journalId, 'cookiesAlertText'.$locale, $this->getData('cookiesAlertText'.$locale), 'string');
      $plugin->updateSetting($journalId, 'cookiesAlertButton'.$locale, $this->getData('cookiesAlertButton'.$locale),  'string');
    }
    $plugin->updateSetting($journalId, 'cookiesAlertStyleBd', $this->getData('cookiesAlertStyleBd'),  'string');
    $plugin->updateSetting($journalId, 'cookiesAlertStyleBgwrapper', $this->getData('cookiesAlertStyleBgwrapper'),  'string');
    $plugin->updateSetting($journalId, 'cookiesAlertStyleBgbutton', $this->getData('cookiesAlertStyleBgbutton'),  'string');
	}
}

?>
