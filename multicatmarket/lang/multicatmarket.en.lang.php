<?php
/**
 * Multicat plugin for Market Module, CMF Cotonti v.1.0.0, PHP v.8.4+, MySQL v.8.0
 * Filename: plugins/multicatmarket/lang/multicatmarket.en.lang.php
 * Purpose: English language file for the Multicat plugin. Defines the strings for the UI
 * Date=Sep 11, 2026
 * @package multicatmarket
 * @version 1.3.2
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
$L['info_name']  = 'Multicat for Market Module';
$L['info_desc']  = 'For Market module v5+. Allows assigning items to multiple categories at once';
$L['info_notes'] = 'in market.edit.tpl / market.add.tpl templates: add {MARKET_FORM_MULTICAT} and {MARKET_FORM_MULTICAT_HINT} right after the categories.';

// Common front-end strings
$L['multicatmarket_select']            = 'Select categories (multiple selection allowed)';
$L['multicatmarket_cats']              = 'Categories';
$L['multicatmarket_cats_edit']         = 'Show in categories';
$L['multicatmarket_error_no_category'] = 'Error: at least one category must be selected';
$L['multicatmarket_help']              = 'in market.edit.tpl / market.add.tpl templates: add {MARKET_FORM_MULTICAT} and {MARKET_FORM_MULTICAT_HINT} right after the categories.';

// Admin page title
$L['multicatmarket_admin_title'] = 'Multicategory management';

// Tabs
$L['multicatmarket_tab_list']  = 'Links list';
$L['multicatmarket_tab_add']   = 'Add link';
$L['multicatmarket_tab_clean'] = 'Cleanup';
$L['multicatmarket_tab_stats'] = 'Statistics';
$L['multicatmarket_tab_mass']  = 'Bulk operations';
$L['multicatmarket_warning_tab_under_develop']  = 'This tab is still under development. Functionality is limited and may not work correctly.';

// Section titles
$L['multicatmarket_list_title']  = 'Links list';
$L['multicatmarket_add_title']   = 'Add new link';
$L['multicatmarket_edit_title']  = 'Edit link';
$L['multicatmarket_clean_title'] = 'Cleanup';
$L['multicatmarket_stats_title'] = 'Statistics';
$L['multicatmarket_mass_title']  = 'Bulk operations';

// Action messages
$L['multicatmarket_deleted']         = 'Link deleted.';
$L['multicatmarket_massdeleted']     = 'Links deleted: %d';
$L['multicatmarket_clean_done']      = 'Removed %d orphan records.';
$L['multicatmarket_added']           = 'Link added.';
$L['multicatmarket_updated']         = 'Link updated.';
$L['multicatmarket_item_not_found']  = 'No item found with this ID.';
$L['multicatmarket_fill_required']   = 'Please fill in the required fields.';
$L['multicatmarket_already_exists']  = 'This link already exists.';
$L['multicatmarket_massbound']       = 'Items bound: %d';
$L['multicatmarket_massunbound']     = 'Items unbound: %d';
$L['multicatmarket_not_exists']      = '[does not exist]';
$L['multicatmarket_no_records']      = 'No records found.';

// List / filter
$L['multicatmarket_filter_title_placeholder'] = 'Item title';
$L['multicatmarket_filter_btn']               = 'Filter';
$L['multicatmarket_reset']                    = 'Reset';
$L['multicatmarket_col_id']                   = 'Item ID';
$L['multicatmarket_col_title']                = 'Item title';
$L['multicatmarket_col_cat_id']               = 'Category ID';
$L['multicatmarket_col_category']             = 'Category';
$L['multicatmarket_col_code']                 = 'Code';
$L['multicatmarket_col_actions']              = 'Actions';
$L['multicatmarket_btn_edit_short']           = 'Ed.';
$L['multicatmarket_btn_delete_short']         = 'Del.';
$L['multicatmarket_confirm_delete']           = 'Really delete?';
$L['multicatmarket_confirm_massdelete']       = 'Delete the selected links?';
$L['multicatmarket_btn_delete_selected']      = 'Delete selected';

// Add
$L['multicatmarket_add_label_page']  = 'Item (ID)';
$L['multicatmarket_add_label_cat']   = 'Category';
$L['multicatmarket_add_page_hint']   = 'Enter the numeric ID of the item from the market table.';
$L['multicatmarket_btn_add']         = 'Add link';
$L['multicatmarket_select_none']     = '-- Select a category --';

// Edit
$L['multicatmarket_edit_label_page']    = 'Item';
$L['multicatmarket_edit_label_new_cat'] = 'New category';
$L['multicatmarket_btn_save']           = 'Save';
$L['multicatmarket_back_to_list']       = 'Back to list';

// Cleanup
$L['multicatmarket_clean_header']         = 'Orphan records';
$L['multicatmarket_clean_desc']           = 'Check the number of broken records and run cleanup if necessary.';
$L['multicatmarket_clean_zero_cat']       = 'With zero cat_id';
$L['multicatmarket_clean_orphan_items']   = 'With non-existent item';
$L['multicatmarket_clean_orphan_cats']    = 'With non-existent category';
$L['multicatmarket_clean_total']          = 'Total to delete';
$L['multicatmarket_clean_all_clean']      = 'No orphan records found.';
$L['multicatmarket_confirm_clean']        = 'Delete all orphan records?';
$L['multicatmarket_btn_clean_all']        = 'Clean all';

// Statistics
$L['multicatmarket_stats_header']       = 'General statistics';
$L['multicatmarket_stats_total_links']  = 'Total links';
$L['multicatmarket_stats_unique_items'] = 'Unique items';
$L['multicatmarket_stats_total_cats']   = 'Unique categories';
$L['multicatmarket_stats_avg']          = 'Average per item';
$L['multicatmarket_stats_top_cats']     = 'Top 10 categories';
$L['multicatmarket_stats_col_category'] = 'Category';
$L['multicatmarket_stats_col_count']    = 'Links';

// Bulk operations
$L['multicatmarket_mass_header']         = 'Bulk operations';
$L['multicatmarket_mass_bind_title']     = 'Bind items to a category';
$L['multicatmarket_mass_bind_desc']      = 'Batch-adds links between the specified items and the selected category.';
$L['multicatmarket_mass_unbind_title']   = 'Unbind items from a category';
$L['multicatmarket_mass_unbind_desc']    = 'Batch-removes links between the specified items and the selected category.';
$L['multicatmarket_mass_label_ids']      = 'Item IDs (comma-separated)';
$L['multicatmarket_mass_ids_hint']       = 'For example: 101,102,103';
$L['multicatmarket_mass_label_bind_cat'] = 'Bind to category';
$L['multicatmarket_btn_bind']            = 'Bind';
$L['multicatmarket_mass_label_ids_unbind'] = 'Item IDs (comma-separated)';
$L['multicatmarket_mass_label_unbind_cat'] = 'Unbind from category';
$L['multicatmarket_btn_unbind']            = 'Unbind';

// List: columns
$L['multicatmarket_col_main_cat'] = 'Main category';
$L['multicatmarket_col_links']    = 'Multicategories';

// Filter by link presence
$L['multicatmarket_filter_link_label']   = 'Links presence';
$L['multicatmarket_filter_link_all']     = 'All';
$L['multicatmarket_filter_link_with']    = 'With links only';
$L['multicatmarket_filter_link_without'] = 'Without links only';

// Empty links list
$L['multicatmarket_no_links'] = '— no links —';

// Bulk cleanup / clear all links of an item
$L['multicatmarket_unlinked']          = 'Links deleted: %d';
$L['multicatmarket_massunlinked']      = 'Deleted %d links from %d items';
$L['multicatmarket_confirm_unlink_all']   = 'Delete all links of this item?';
$L['multicatmarket_confirm_massunlink']   = 'Delete all links of the selected items?';
$L['multicatmarket_btn_unlink_short']     = 'Clear links';
$L['multicatmarket_btn_unlink_selected']  = 'Clear links of selected';
$L['multicatmarket_btn_edit_product']     = 'Edit item';

$L['multicatmarket_market_cats_links']         = 'Product multicategories';
$L['multicatmarket_market_cats_links_hint']    = 'Additional categories where this product is shown as similar.';
