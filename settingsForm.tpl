{**
 * plugins/generic/googleAnalytics/settingsForm.tpl
 *
 * Copyright (c) 2013-2014 Simon Fraser University Library
 * Copyright (c) 2003-2014 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * Google Analytics plugin settings
 *
 *}
{strip}
{assign var="pageTitle" value="plugins.generic.cookiesAlert.manager.cookiesAlertSettings"}
{include file="common/header.tpl"}
{/strip}
<div id="cookiesAlertSettings">
<div id="description">{translate key="plugins.generic.cookiesAlert.manager.settings.description"}</div>
<div class="separator"></div>

<br />

<form method="post" action="{plugin_url path="settings"}">
{include file="common/formErrors.tpl"}
<table width="100%" class="data">
{foreach from=$locales key=index item=lang}
  <tr valign="top">
    <td colspan="2">
      <h4>{translate key="plugins.generic.cookiesAlert.manager.settings.langBlockLocaleCaption"} {$lang}</h4>
    </td>
  </tr>
	<tr valign="top">
		<td width="20%" class="label">{fieldLabel name="cookiesAlertButton" required="true" key="plugins.generic.cookiesAlert.manager.settings.cookiesAlertButton"}</td>
		<td width="80%" class="value"><input type="text" name="cookiesAlertButton{$lang|escape}" id="cookiesAlertButton{$lang|escape}" value="{$cookiesAlertButton.$lang|escape}" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label">{fieldLabel name="cookiesAlertText" required="true" key="plugins.generic.cookiesAlert.manager.settings.cookiesAlertText"}</td>
		<td width="80%" class="value"><textarea name="cookiesAlertText{$lang|escape}" id="cookiesAlertText{$lang|escape}"  size="45" maxlength="250" class="textField">{$cookiesAlertText.$lang|escape}</textarea>
		<br />
		<span class="instruct">{translate key="plugins.generic.cookiesAlert.manager.settings.cookiesAlertTextInstructions"}</span>
	</td>
	</tr>
{/foreach}
	<tr valign="top">
		<td width="20%" class="label">{fieldLabel name="cookiesAlertStyleBd"  key="plugins.generic.cookiesAlert.manager.settings.cookiesAlertStyleBd"}</td>
		<td width="80%" class="value"><input type="text" name="cookiesAlertStyleBd" id="cookiesAlertStyleBd" value="{$cookiesAlertStyleBd|escape}" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label">{fieldLabel name="cookiesAlertStyleBgwrapper"  key="plugins.generic.cookiesAlert.manager.settings.cookiesAlertStyleBgwrapper"}</td>
		<td width="80%" class="value"><input type="text" name="cookiesAlertStyleBgwrapper" id="cookiesAlertStyleBgwrapper" value="{$cookiesAlertStyleBgwrapper|escape}" /></td>
	</tr>
	<tr valign="top">
		<td width="20%" class="label">{fieldLabel name="cookiesAlertStyleBgbutton"  key="plugins.generic.cookiesAlert.manager.settings.cookiesAlertStyleBgbutton"}</td>
		<td width="80%" class="value"><input type="text" name="cookiesAlertStyleBgbutton" id="cookiesAlertStyleBgbutton" value="{$cookiesAlertStyleBgbutton|escape}" /></td>
	</tr>
</table>

<br/>

<input type="submit" name="save" class="button defaultButton" value="{translate key="common.save"}"/><input type="button" class="button" value="{translate key="common.cancel"}" onclick="history.go(-1)"/>
</form>

<p><span class="formRequired">{translate key="common.requiredField"}</span></p>
</div>
{include file="common/footer.tpl"}
