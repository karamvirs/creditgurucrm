{*

/**
 * SugarCRM is a customer relationship management program developed by
 * SugarCRM, Inc. Copyright (C) 2004 - 2009 SugarCRM Inc.
 * 
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): FOR ANY PART OF THE COVERED WORK
 * IN WHICH THE COPYRIGHT IS OWNED BY SUGARCRM, SUGARCRM DISCLAIMS THE WARRANTY
 * OF NON INFRINGEMENT OF THIRD PARTY RIGHTS.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA
 * 02110-1301 USA.
 * 
 * You can contact SugarCRM, Inc. headquarters at 10050 North Wolfe Road,
 * SW2-130, Cupertino, CA 95014, USA. or at email address contact@sugarcrm.com.
 * 
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 * 
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * SugarCRM" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by SugarCRM".
 */



*}

{*******************************************************************************
 * Additional code developed by:
 *  
 * Dispage - Patrizio Gelosi
 * Via A. De Gasperi 91 
 * P. Potenza Picena (MC) - Italy
 * 
 * (Hereby referred to as "DISPAGE")
 * 
 * Copyright (c) 2010-2013 DISPAGE.
 * 
 * 
 * This file has been modified as part of the "ModuleSurfer" project.
 ******************************************************************************}

{assign var='moduleName' value=$pageData.bean.moduleDir}
{php}
require_once('custom/include/EnhancedManager/ExtensionManager.php');
if (method_exists('ExtensionManager', 'getInstalledProperties')) {
	$extProp = ExtensionManager::getInstalledProperties('589f27e5-0d96-36d8-c13b-4aab88ba3f81');
}
if (!isset($extProp) || @$extProp['relase'] && $extProp['relase'] < '1.0.10') {
	echo '<script language="javascript">djQuery(document).ready(function () {setTimeout(\'boxyAlert ("This version of ModuleSurfer requires Extension Manager 1.0.10 or superior to work properly.<br/><b>Please upgrade Extension Manager<b/>.", "warning");\', 1000);});</script>';
}
$this->_tpl_vars['overlibPath'] = 'include/javascript/sugar_grp_overlib.js';
if ($this->_tpl_vars['sugarVersion'] > '6.4') $this->_tpl_vars['overlibPath'] = 'cache/' . $this->_tpl_vars['overlibPath'];
$this->_tpl_vars['actionWidth'] = '40';


$this->_tpl_vars['moduleNameLang'] = $GLOBALS['app_list_strings']['moduleList'][$this->_tpl_vars['moduleName']];
{/php}
<link rel="stylesheet" type="text/css" media="screen" href="custom/include/ModuleSurfer/css/modulesurfer.css?s={$moduleSurferJSCode}" />
<link rel="stylesheet" type="text/css" media="print" href="custom/include/ModuleSurfer/css/modulesurfer.print.css?s={$moduleSurferJSCode}" />
{if $sugarVersion lt '5.5'}
<link rel="stylesheet" type="text/css" media="screen" href="custom/include/ModuleSurfer/css/modulesurfer.5.2.css?s={$moduleSurferJSCode}" />
{/if}

{if $overlib}
<div style="width:300px">
	<script type='text/javascript' src='{sugar_getjspath file=$overlibPath}'></script>
	<div id='overDiv' style='position:absolute; visibility:hidden; z-index:1000;'></div>
	<span style="display: inline-block;float:right;">{$moduleSurferLang.defLang.selected}<input type="text" value="0" readonly="" id="MSCheckCount" style="border: 0px; background: transparent; font-size: inherit; color: inherit"></span>
</div>
{/if}
{if $prerow}
	{$multiSelectData}
	{if $sugarVersion gt '6.5'}
		{include file='custom/include/ModuleSurfer/ListView/tpl/ListViewGenericHeader65.tpl'}
	{elseif $sugarVersion gt '6'}
		{$actionsLink}
	{else}
<table border='0' cellpadding='0' cellspacing='0' width='100%'>
	<tr>
		<td class='listViewPaginationTdS1' nowrap>
			{$exportLink}
			{$targetLink}
			{$mergeLink}
			{$mergedupLink}
			{$favoritesLink}
			{$composeEmailLink}
		</td>
	</tr>
</table>
	{/if}
{/if}
<div id="ms-select-records">
	<div onclick="turboMan.selectCurrentRecords()">{$moduleSurferLang.defLang.current}</div>
	<div onclick="turboMan.selectAllRecords()">{$moduleSurferLang.defLang.all}</div>
	<div onclick="turboMan.selectNoneRecords()">{$moduleSurferLang.defLang.none}</div>
</div>
<table id="scroll-listview"></table> 
<div id="pscrolling"></div>


<script type="text/javascript" src="custom/include/ModuleSurfer/js/turboManager.js?s={$moduleSurferJSCode}&v=BASIC"></script>
<script type="text/javascript" src="custom/include/EnhancedManager/js/urlEncode.js?s={$moduleSurferJSCode}"></script>
<script type="text/javascript" src="custom/include/EnhancedManager/js/jquery-ui-timepicker.min.js?s={$moduleSurferJSCode}"></script>

<script language="javascript">

var EMimgpath = 'custom/include/EnhancedManager/img';

turboMan.localRequired = 'reqFiles[]={php} echo urlencode('custom/include/ModuleSurfer/data/TSWrapper.php'){/php}';
turboMan.lang = {$moduleSurferLang.jsLang};
turboMan.moduleName = '{$moduleName}';
turboMan.moduleNameLang = '{$moduleNameLang}';
turboMan.colModel = [{ldelim}name: 'id',index: 'id', width:1, hidden: true, key: true{rdelim}];
turboMan.colNames = ["id"];

{if $moduleSurferDisableManual.scrollRows}
turboMan.scrollRows = {$moduleSurferDisableManual.scrollRows};
{/if}
{if $moduleSurferDisableManual.disableTips}
turboMan.disableTips = true;
{/if}
turboMan.pageStamp = '{$pageData.stamp}';

turboMan.dateFormat = '{$USER_DATEFORMAT|regex_replace:"/yyy+/":"yy"}';
turboMan.timeFormat = '{$USER_TIMEFORMAT}';



{foreach from=$displayColumns key=colHeader item=params}
	{assign var='editRules' value='edithidden: true'}
	{assign var='curTs' value=$tsFieldType.$colHeader}
	/*{$curTs.dbType} - {$curTs.type} */
	{if $moduleSurferReadonlyColumns.$colHeader}
		{assign var='isFiltered' value=false}
	{else}
		{assign var='isFiltered' value=true}
	{/if}


	turboMan.colModel.push({ldelim}
		name: '{$colHeader}',
		index: '{$params.orderBy|default:$colHeader|lower}{if $curTs.type == 'multienum'}[]{/if}',
	{if (($curTs.source != 'non-db' || $curTs.function && $curTs.function.name == 'getEmailAddressWidget') && ($curTs.dbType == 'varchar' || $curTs.type == 'varchar' || $curTs.type == 'text' || $curTs.type == 'double' || $curTs.type == 'float' || $curTs.type == 'decimal' || $curTs.dbType == 'int' || $curTs.type == 'int' || $curTs.type == 'date' || $curTs.type == 'datetime' || $curTs.type == 'datetimecombo' || $curTs.type == 'advanceddatetime' && $curTs.ext2 != 'lengthtime' || $curTs.type == 'bool' || $curTs.type == 'currency') || $curTs.type == 'relate' || $curTs.option_list || $colHeader == 'NAME') && $isFiltered}

		editable: true,
	{/if}
		width: parseInt((Math.floor({$params.width}) || 4) * turboMan.gridWidth / {$moduleSurferWidthSum})
	{if !$params.sortable|default:true}
		,sortable: false
	{/if}
	{if $moduleSurferHiddenColumns.$colHeader}
		,hidden: true
	{/if}
	{if $colHeader == 'NAME'}
		,formatter:'showlink'
		,formatoptions:{ldelim}
			idName: 'record', 
			addParam: '&module='+turboMan.moduleName+'&action=DetailView'
		{rdelim}
		,stype: 'text'
		{if $moduleName == 'Contacts' || $moduleName == 'Leads'}
		,edittype: 'custom'
		,unformat: turboMan.nameUnformat
		,editoptions: {ldelim}
			custom_element: turboMan.nameElement,
			custom_value: turboMan.nameValue
		{rdelim}
		{/if}
	{elseif $curTs.type == 'bool'}
		,edittype:'checkbox', editoptions: {ldelim} value:"{$moduleSurferLang.defLang.yes}:{$moduleSurferLang.defLang.no}" {rdelim}
		,stype: 'select'

	{elseif $curTs.dbType == 'int' || $curTs.type == 'int'}
		{assign var='editRules' value=$editRules|cat:', integer: true'}
		,stype: 'text'
	{elseif $curTs.type == 'text'}
		,edittype:'textarea'
		,stype: 'text'
		,editoptions: {ldelim}
			rows: 5,
			cols: 80
		{rdelim}
	{elseif $curTs.type == 'double' || $curTs.type == 'decimal' || $curTs.type == 'float' || $curTs.type == 'currency'}
		{if $curTs.type == 'currency'}
			{assign var='editRules' value=$editRules|cat:', custom: true, custom_func: turboMan.currencyFunc'}
		,formatter:turboMan.currencyFormat
		,unformat: turboMan.currencyUnformat
		,formatoptions:{ldelim}
			decimalSeparator:"{$moduleSurferCurrencies.decimalSeparator}",
			thousandsSeparator: "{$moduleSurferCurrencies.thousandsSeparator}",
			decimalPlaces: {$moduleSurferCurrencies.decimalPlaces},
			prefix: '{$moduleSurferCurrencies.prefix}'
		{rdelim}

		{else}
			{assign var='editRules' value=$editRules|cat:', number: true'}

		{/if}
		,stype: 'text'
	{elseif $curTs.option_list}
		,edittype:'select'
		,editoptions:{ldelim}
			value:{$curTs.option_list}
		{if $curTs.is_user_field}
			,is_user_field:true
			,defaultValue: '{php}echo $GLOBALS['current_user']->id{/php}'
		{/if}
		{if $curTs.type == 'multienum'}
			,multiple:true
		{/if}
		{rdelim}
		,stype: 'select'

	{elseif $curTs.type == 'relate'}
		,edittype: 'custom'
		,editoptions:{ldelim}
			relateModule: '{$curTs.module}',
			custom_element: turboMan.relateElement,
			custom_value: turboMan.relateValue
		{rdelim}		
		{capture name=addOpRelate}
turboMan.relateAlias['{$curTs.name}'] = '{$curTs.id_name}';
		{/capture}
		{assign var='addOptions' value=$addOptions|cat:$smarty.capture.addOpRelate}
		,stype: 'text'
	{elseif $curTs.function && $curTs.function.name == 'getEmailAddressWidget'}
		{assign var='editRules' value=$editRules|cat:', email: true'}
		,stype: 'text'
	{elseif $curTs.type == 'date'}

		,editoptions:{literal}{dataInit: turboMan.dateEditInit}{/literal}
	{elseif $curTs.type == 'datetime' || $curTs.type == 'datetimecombo' || $curTs.type == 'advanceddatetime'}

		,editoptions:{literal}{dataInit: turboMan.datetimeEditInit}{/literal}
	{else}
		,stype: 'text'
	{/if}
	{if $curTs.disable_search}
		,search: false
	{/if}
	{if $curTs.required || $curTs.importable == 'required'}
		{assign var='editRules' value=$editRules|cat:', required: true'}
	{/if}
		,editrules:{ldelim}{$editRules}{rdelim}
	{rdelim});
	turboMan.colNames.push('{sugar_translate label=$params.label module=$moduleName}');
	{if $params.sortable|default:true && $params.orderBy|default:$colHeader|lower == $pageData.ordering.orderBy}
	turboMan.col2sort = '{$colHeader}';
	turboMan.sortOrder = '{$pageData.ordering.sortOrder}';
	{/if}
{/foreach}

	turboMan.colModel.push({ldelim}
		name: 'actions',
		width: {$actionWidth},
		sortable: false,
		search: false,
		formatter: actionColumn
	{rdelim});
	turboMan.colNames.push('{$moduleSurferLang.ltpLang.LBL_ACTIONS}');

function actionColumn (cellvalue, options, rowObject) {ldelim}

	return "<div class='ms-row-actions'><a title='{$moduleSurferLang.ltpLang.EDIT_TITLE}' href='index.php?module="+turboMan.moduleName+"&stamp="+turboMan.pageStamp+"&return_module="+turboMan.moduleName+"&action=EditView&record="+options.rowId+"'><img border='0' src='{sugar_getimagepath file='edit_inline.gif'}'></a></div>";
{rdelim}



d$(document).ready(function(){ldelim}
	d$('#ms-select-records > div').button();
{rdelim});

</script>
<div id="ms-disable-container" style="padding-top:10px;">
	<input type="submit" style="width:0px; float:left; color:white;" id="cr-interceptor" onclick="return false"/>
{if !$moduleSurferDisableManual || !$moduleSurferDisableManual.disableManual}
	<input type="checkbox" style="float:left;" name="surfer-disable" onclick="javascript:document.location.href = EMAddURIParameter('disable_ms', '1');" /><span style="position:relative; top:1px; left:3px;">{$moduleSurferLang.ltpLang.LBL_DISABLE_MODULESURFER}</span>
{/if}
	<input type="checkbox" id="massall4ie" name="massall" value="1" style="display:none;"/>
</div>

<script language="javascript">
d$('#cr-interceptor').css('opacity', '0');
</script>

{if $contextMenus}
<script>
	{$contextMenuScript}
{literal}function lvg_nav(m,id,act,offset,t){if(t.href.search(/#/) < 0){return;}else{if(act=='pte'){act='ProjectTemplatesEditView';}else if(act=='d'){ act='DetailView';}else{ act='EditView';}{/literal}url = 'index.php?module='+m+'&offset=' + offset + '&stamp={$pageData.stamp}&return_module='+m+'&action='+act+'&record='+id;t.href=url;{literal}}}{/literal}
{literal}function lvg_dtails(id){{/literal}return SUGAR.util.getAdditionalDetails( '{$params.module|default:$moduleName}',id, 'adspan_'+id);{literal}}{/literal}
</script>
{/if}
