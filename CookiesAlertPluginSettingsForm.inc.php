<?php

/**
 * @file plugins/generic/googleAnalytics/GoogleAnalyticsSettingsForm.inc.php
 *
 * Copyright (c) 2013-2014 Simon Fraser University Library
 * Copyright (c) 2003-2014 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class GoogleAnalyticsSettingsForm
 * @ingroup plugins_generic_googleAnalytics
 *
 * @brief Form for journal managers to modify Google Analytics plugin settings
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

		//$this->addCheck(new FormValidator($this, 'googleAnalyticsSiteId', 'required', 'plugins.generic.googleAnalytics.manager.settings.googleAnalyticsSiteIdRequired'));

		//$this->addCheck(new FormValidator($this, 'trackingCode', 'required', 'plugins.generic.googleAnalytics.manager.settings.trackingCodeRequired'));
	}

	/**
	 * Initialize form data.
	 */
	function initData() {
		$journalId = $this->journalId;
		$plugin =& $this->plugin;
    $site =& Request::getSite();
    $locales = $site->getSupportedLocales();
    $this->_data = array(
      'locales' => $locales
    );
    $values = array();
    $this->_data['cookiesAlertText'] =  array();
    $this->_data['cookiesAlertButton'] =  array();

    foreach($locales as $index => $locale) {
      $this->_data['cookiesAlertText'] +=  array($locale =>  $plugin->getSetting($journalId, 'cookiesAlertText' . $locale));
      $this->_data['cookiesAlertButton'] +=  array($locale => $plugin->getSetting($journalId, 'cookiesAlertButton' . $locale));
    }
    $this->_data['cookiesAlertStyleBd'] = $plugin->getSetting($journalId, 'cookiesAlertStyleBd');
    $this->_data['cookiesAlertStyleBgwrapper'] = $plugin->getSetting($journalId, 'cookiesAlertStyleBgwrapper');
    $this->_data['cookiesAlertStyleBgbutton'] = $plugin->getSetting($journalId, 'cookiesAlertStyleBgbutton');
    //print($plugin->getSetting($journalId, 'cookiesAlertButton'));
    //var_dump($this->_data);

		//$this->_data = array(
			//'googleAnalyticsSiteId' => $plugin->getSetting($journalId, 'googleAnalyticsSiteId'),
			//'trackingCode' => $plugin->getSetting($journalId, 'trackingCode')
		//);
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
