{php} 
global $current_user;
include_once('modules/ACLRoles/ACLRole.php');
$isAffiliateRole = in_array("affiliate role", ACLRole::getUserRoleNames($current_user->id)); {/php}
{php}if ($isAffiliateRole != 1){ {/php} 
{if $AUTHENTICATED}
<div id="search">
    <form name='UnifiedSearch' action='index.php' onsubmit='return SUGAR.unifiedSearchAdvanced.checkUsaAdvanced()'>
        <input type="hidden" name="action" value="UnifiedSearch">
        <input type="hidden" name="module" value="Home">
        <input type="hidden" name="search_form" value="false">
        <input type="hidden" name="advanced" value="false">
        {sugar_getimage name="searchMore" ext=".gif" alt=$APP.LBL_SEARCH other_attributes='border="0" id="unified_search_advanced_img" '}&nbsp;
        <input type="text" name="query_string" id="query_string" size="20" value="{$SEARCH}">&nbsp;
        <input type="submit" class="button" value="{$APP.LBL_SEARCH}">
    </form><br />
    <div id="unified_search_advanced_div"> </div>
</div>
<div id="sitemapLink">
    <span id="sitemapLinkSpan">
        {$APP.LBL_SITEMAP}
        {sugar_getimage name="MoreDetail" alt=$app_strings.LBL_MOREDETAIL ext=".png" other_attributes=''}
    </span>
</div>
<span id='sm_holder'></span>
{/if}
{php} } {/php} 
