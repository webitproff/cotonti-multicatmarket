<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.edit.update.import
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti v.1.0.0, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.edit.import.php
 * Purpose: Хук для market.edit.update.import, modules\market\inc\market.edit.php, str 72.
 *          Импортирует категории из POST и устанавливает первую как fieldmrkt_cat.
 *          Если POST['rcat'] пуст, но у товара уже есть основная категория в БД —
 *          сохраняем её (без ошибки).
 * Date=Sep 11, 2026
 * @package multicat
 * @version 1.3.2
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

global $db, $db_structure;

/* --- Собираем выбранные ID категорий из POST --- */
$rcats = [];
if (isset($_POST['rcat']) && is_array($_POST['rcat'])) {
    foreach ($_POST['rcat'] as $v) {
        $v = (int)$v;
        if ($v > 0) {
            $rcats[] = $v;
        }
    }
    $rcats = array_values(array_unique($rcats));
}

if (!empty($rcats)) {
    /* --- Есть выбранные категории: первая становится основной --- */
    $first_cat_id = (int) reset($rcats);
    $code = $db->query(
        "SELECT structure_code FROM $db_structure
         WHERE structure_id = ? AND structure_area = 'market'",
        [$first_cat_id]
    )->fetchColumn();

    $item['fieldmrkt_cat'] = $code ?: $item['fieldmrkt_cat'];
} else {
    /* --- POST['rcat'] пуст: смотрим, есть ли уже основная категория в БД --- */
    $edit_id = cot_import('id', 'G', 'INT');
    if ($edit_id <= 0) {
        $edit_id = cot_import('id', 'P', 'INT');
    }

    $existing_cat = '';
    if ($edit_id > 0) {
        $existing_cat = (string) $db->query(
            "SELECT fieldmrkt_cat FROM " . Cot::$db->market . " WHERE fieldmrkt_id = ?",
            [$edit_id]
        )->fetchColumn();
    }

    if ($existing_cat === '') {
        /* Новый товар без категорий — это ошибка */
        cot_error($L['multicatmarket_error_no_category']);
    } else {
        /* Товар уже имеет основную категорию — оставляем её */
        $item['fieldmrkt_cat'] = $existing_cat;
    }
}