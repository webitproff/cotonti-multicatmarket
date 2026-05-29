<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.list.first
[END_COT_EXT]
==================== */

defined('COT_CODE') or die('Wrong URL');

// Получаем категорию из GET (она уже импортирована в market.list.php как $c)
global $c;

if (!empty($c)) {
    $db = Cot::$db;
    $cat_id = (int)$db->query(
        "SELECT structure_id FROM {$db->structure}
         WHERE structure_code = " . $db->quote($c) . "
           AND structure_area = 'market'"
    )->fetchColumn();
    
    if ($cat_id > 0) {
        $has_multi = (bool)$db->query(
            "SELECT 1 FROM {$db->market_multicats}
             WHERE pcat_cat_id = {$cat_id} LIMIT 1"
        )->fetchColumn();
        
        if ($has_multi) {
            Cot::$cache = false; // отключаем кеширование данных и запросов к БД для этой страницы
        }
    }
}