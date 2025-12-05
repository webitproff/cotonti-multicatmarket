<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.list.query
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.list.query.php
 * Purpose: Хук для market.list.query, modules\market\inc\market.list.php, str 195. Фильтр списка страниц по выбранной категории $c, учитывая мультикатегории.
 * Date=2025-12-05
 * @package multicat
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $c, $db_market_multicats, $where, $join_condition;

$db = Cot::$db;
$db_structure = $db->structure;
$db_market_multicats = $db->market_multicats;

if (!empty($c)) {
    // Получаем ID структуры по коду категории
    $sql = "SELECT structure_id
              FROM " . $db_structure . "
             WHERE structure_code = " . $db->quote($c) . "
               AND structure_area = 'market'";
    $cat_id = (int)$db->query($sql)->fetchColumn();

    if ($cat_id) {
        // Подмена условия фильтрации: используем алиас p (так как в основном запросе используется p)
        if (isset($where['cat'])) {
            $where['cat'] = "(" . $where['cat'] . " OR EXISTS (
                SELECT 1
                  FROM " . $db_market_multicats . " AS pc
                 WHERE pc.pcat_page_id = p.fieldmrkt_id
                   AND pc.pcat_cat_id = " . (int)$cat_id . "
            ))";
        } else {
            $where['cat'] = "(p.fieldmrkt_cat = " . $db->quote($c) . " OR EXISTS (
                SELECT 1
                  FROM " . $db_market_multicats . " AS pc
                 WHERE pc.pcat_page_id = p.fieldmrkt_id
                   AND pc.pcat_cat_id = " . (int)$cat_id . "
            ))";
        }
    }
}
