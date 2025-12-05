<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.admin.loop
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.admin.loop.php
 * Purpose: Хук для market.admin.loop modules\market\market.admin.php str 373. Отображает список категорий (structure_title) в админ-списке страниц.
 * Date=2025-12-05
 * @package multicat
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */
 
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('multicatmarket', 'plug');


/**
 * @var array $row Current market row
 * @var XTemplate $t Current template object
 */

if (!empty($row['fieldmrkt_id'])) {
    $multicats = multicatmarket_get_cat_titles($row['fieldmrkt_id']);
    $t->assign([
        'ADMIN_PAGE_MULTICATS' => !empty($multicats) ? implode(', ', $multicats) : ''
    ]);
}
