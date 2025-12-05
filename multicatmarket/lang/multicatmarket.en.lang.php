<?php
/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: lang/multicat.en.lang.php
 * Purpose: English language file for the Multicat plugin. Defines the strings for the UI
 * Date=2025-12-05
 * @package multicat
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/**
 * Plugin Conf
 */
$L['cfg_enabled'] = 'Enable multiple categories';

/**
 * Plugin Info
 */
$L['info_name'] = 'Multicat for Market Module';
$L['info_desc'] = 'Allows assigning pages to multiple categories at once';
$L['info_notes'] = 'In templates page.edit.tpl: Add {MARKET_FORM_MULTICAT} and {MARKET_FORM_MULTICAT_HINT} right after the category field.';

$L['multicatmarket_select'] = 'Select categories (multiple selection allowed)';
$L['multicatmarket_cats'] = 'Categories';
$L['multicatmarket_cats_edit'] = 'Show in Categories';
$L['multicatmarket_error_no_category'] = 'Error: you must select at least one category';

$L['multicatmarket_help'] = 'In templates page.edit.tpl: Add {MARKET_FORM_MULTICAT} and {MARKET_FORM_MULTICAT_HINT} right after the category field.';
