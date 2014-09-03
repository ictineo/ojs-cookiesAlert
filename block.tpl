{**
 * plugins/generic/externalFeed/block.tpl
 *
 * Copyright (c) 2013-2014 Simon Fraser University Library
 * Copyright (c) 2003-2014 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * External feed plugin navigation sidebar.
 *
 *}
 {literal}
 <style>
  #cookiesAlert {
    position: fixed;
    bottom: 0px;
    left: 5%;
    width: 80%;
    right: 5%;
    padding: 12px 5%;
  }
  #cookiesAlert #cookieAlertButton {
    width: 10%;
    float: right;
  }
  #cookiesAlert #cookieAlertButton a {
    padding: 8px;
    border-radius: 4px;
    text-decoration: none;
    text-transform: uppercase;
  }
 </style>
 {/literal}
<div class="block" id="cookiesAlert" style="border-radius: {$cookiesAlertStyleBd|escape} {$cookiesAlertStyleBd|escape} 0 0; background-color: {$cookiesAlertStyleBgwrapper|escape}">
  <div id="cookieAlertText">
  {$cookiesAlertText|escape}
  </div>
  <div id="cookieAlertButton">
    <a href="{$currentUrl|escape}?acceptCookies=1" style="background-color: {$cookiesAlertStyleBgbutton|escape}">{$cookiesAlertButton|escape}</a>
  </div>
</div>
