<?php

/**
* @file CookiesPlugin.inc.php
*
* Copyright (c) 2014 UOC, Universitat Oberta de Catalunya
* Developed by Julià Mestieri (Journal Services -- http://journal-services.com)
* Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
*
* @class CookiesPlugin
* @ingroup plugins_generic_cookies
*
* @brief Cookies plugin class
*/


import('lib.pkp.classes.plugins.GenericPlugin');

class CookiesAlertPlugin extends GenericPlugin {
	/**
	 * Called as a plugin is registered to the registry
	 * @param $category String Name of category plugin was registered to
	 * @return boolean True iff plugin initialized successfully; if false,
	 * 	the plugin will not be registered.
	 */
	function register($category, $path) {
		$success = parent::register($category, $path);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
		if ($success && $this->getEnabled()) {
			// Insert field into author submission page and metadata form
			//HookRegistry::register('Templates::Author::Submit::Authors', array($this, 'metadataField'));
			//HookRegistry::register('Templates::Submission::MetadataEdit::Authors', array($this, 'metadataField'));

			// Hook for initData in two forms
			//HookRegistry::register('metadataform::initdata', array($this, 'metadataInitData'));
			//HookRegistry::register('authorsubmitstep3form::initdata', array($this, 'metadataInitData'));

			// Hook for execute in two forms
			//HookRegistry::register('Author::Form::Submit::AuthorSubmitStep3Form::Execute', array($this, 'metadataExecute'));
			//HookRegistry::register('Submission::Form::MetadataForm::Execute', array($this, 'metadataExecute'));

			// Add element for AuthorDAO for storage
			//HookRegistry::register('authordao::getAdditionalFieldNames', array($this, 'authorSubmitGetFieldNames'));

			// Insert Google Analytics page tag to common footer
			HookRegistry::register('Templates::Common::Footer::PageFooter', array($this, 'insertFooter'));

			// Insert Google Analytics page tag to article footer
			HookRegistry::register('Templates::Article::Footer::PageFooter', array($this, 'insertFooter'));

			// Insert Google Analytics page tag to article interstitial footer
			HookRegistry::register('Templates::Article::Interstitial::PageFooter', array($this, 'insertFooter'));

			// Insert Google Analytics page tag to article pdf interstitial footer
			HookRegistry::register('Templates::Article::PdfInterstitial::PageFooter', array($this, 'insertFooter'));

			// Insert Google Analytics page tag to reading tools footer
			HookRegistry::register('Templates::Rt::Footer::PageFooter', array($this, 'insertFooter'));

			// Insert Google Analytics page tag to help footer
			HookRegistry::register('Templates::Help::Footer::PageFooter', array($this, 'insertFooter'));
		}
		return $success;
	}

	function getDisplayName() {
		return __('plugins.generic.cookiesAlert.displayName');
	}

	function getDescription() {
		return __('plugins.generic.cookiesAlert.description');
	}

	/**
	 * Extend the {url ...} smarty to support this plugin.
	 */
	function smartyPluginUrl($params, &$smarty) {
		$path = array($this->getCategory(), $this->getName());
		if (is_array($params['path'])) {
			$params['path'] = array_merge($path, $params['path']);
		} elseif (!empty($params['path'])) {
			$params['path'] = array_merge($path, array($params['path']));
		} else {
			$params['path'] = $path;
		}

		if (!empty($params['id'])) {
			$params['path'] = array_merge($params['path'], array($params['id']));
			unset($params['id']);
		}
		return $smarty->smartyUrl($params, $smarty);
	}


	/**
	 * Display verbs for the management interface.
	 */
  function getManagementVerbs() {
    $verbs = array();
    if ($this->getEnabled()) {
      $verbs[] = array('settings', __('plugins.generic.cookiesAlert.manager.settings'));
    }
    return parent::getManagementVerbs($verbs);
  }

	/**
	 * Insert Google Analytics page tag to footer
	 */
	function insertFooter($hookName, $params) {
		$smarty =& $params[1];
		$output =& $params[2];
    /** Initial objects **/
    $sessionManager =& SessionManager::getManager();
    $session =& $sessionManager->getUserSession();
    $templateMgr =& TemplateManager::getManager();
    //$templateMgr =& $params[0];
    //$site = $templateMgr->request->getSite();
    $journal =& Request::getJournal();
    $journalId = $journal->getId();
    $currentLocale = AppLocale::getLocale();
    $templateMgr->assign('cookiesAlertText', $this->getSetting($journalId, 'cookiesAlertText'.$currentLocale));
    $templateMgr->assign('cookiesAlertButton', $this->getSetting($journalId, 'cookiesAlertButton'.$currentLocale));
    $templateMgr->assign('cookiesAlertStyleBd', $this->getSetting($journalId, 'cookiesAlertStyleBd'));
    $templateMgr->assign('cookiesAlertStyleBgwrapper', $this->getSetting($journalId, 'cookiesAlertStyleBgwrapper'));
    $templateMgr->assign('cookiesAlertStyleBgbutton', $this->getSetting($journalId, 'cookiesAlertStyleBgbutton'));

    $url_params = $templateMgr->request->getQueryArray();
    if(array_key_exists('acceptCookies', $url_params) ) {
      //$url_params['acceptCookies'] == 1) {
      $session->setSessionVar('cookiesAlertAccepted',$url_params['acceptCookies']);
    }
    if($session->getSessionVar('cookiesAlertAccepted') != 1){
      $templateMgr->display($this->getTemplatePath() . 'block.tpl');
    }

		return false;
	}

	/**
	 * Execute a management verb on this plugin
	 * @param $verb string
	 * @param $args array
	 * @param $message string Result status message
	 * @param $messageParams array Parameters for the message key
	 * @return boolean
	 */
  function manage($verb, $args, &$message, &$messageParams) {
    if (!parent::manage($verb, $args, $message, $messageParams)) return false;

    switch ($verb) {
      case 'settings':
        $site =& Request::getSite();
        $templateMgr =& TemplateManager::getManager();
        $templateMgr->register_function('plugin_url', array(&$this, 'smartyPluginUrl'));
        $journal =& Request::getJournal();

        $this->import('CookiesAlertPluginSettingsForm');
        $form = new CookiesAlertSettingsForm($this, $journal->getId());
        if (Request::getUserVar('save')) {
          $form->readInputData();
          if ($form->validate()) {
            $form->execute();
            Request::redirect(null, 'manager', 'plugin');
            return false;
          } else {
            //$this->setBreadCrumbs(true);
            $form->display();
          }
        } else {
          //$this->setBreadCrumbs(true);
          $form->initData();
          $form->display();
        }
        return true;
      default:
        //Unknown management verb
        assert(false);
        return false;
    }
  }
}
?>
