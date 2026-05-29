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
 * Date=2026-05-29
 * @package multicat
 * @version 1.2.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */


defined('COT_CODE') or die('Wrong URL');

Cot::$db->registerTable('market_multicats');

global $c, $where, $structure;

if (empty($c) || !isset($structure['market'][$c])) {
    return;
}

$db = Cot::$db;
$cat_id = (int)$db->query(
    "SELECT structure_id FROM {$db->structure}
     WHERE structure_code = " . $db->quote($c) . "
       AND structure_area = 'market'"
)->fetchColumn();

if ($cat_id <= 0) {
    return;
}

// Все подкатегории текущей категории (включая её саму)
$catsub = cot_structure_children('market', $c, true);
$catsub[] = $c;
$catsub_quoted = array_map([$db, 'quote'], $catsub);

// Основное условие: товар лежит в одной из указанных категорий (с учётом подкатегорий)
$main_cond = "fieldmrkt_cat IN (" . implode(',', $catsub_quoted) . ")";

// Дополнительное условие: товар привязан к текущей категории через мультикатегории
$multi_cond = "p.fieldmrkt_id IN (
    SELECT pcat_page_id
    FROM {$db->market_multicats}
    WHERE pcat_cat_id = {$cat_id}
)";

// Перезаписываем условие, не расширяем
$where['cat'] = "(" . $main_cond . " OR " . $multi_cond . ")";
