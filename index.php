<?php

/**
 * @defgroup plugins_generic_cookies
 */

/**
* @file plugins/generic/cookies/index.php
*
* Copyright (c) 2014 UOC, Universitat Oberta de Catalunya
* Developed by Julià Mestieri (Journal Services -- http://journal-services.com)
* Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
*
* @ingroup plugins_generic_cookies
*
* @brief Cookies plugin main file
*/

require_once('CookiesAlertPlugin.inc.php');

return new CookiesAlertPlugin();

?>
