<?php

/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: inc/multicat.functions.php
 * Purpose: Основные функции для обработки множественных категорий страниц в плагине Multicat. Использует $structure['market'] для получения заголовков и прямые SQL-запросы для работы с cot_market_multicats.
 * Date=2025-12-05
 * @package multicat
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

Cot::$db->registerTable('market_multicats');
/**
 * Получает список ID категорий (structure_id) для указанной страницы.
 *
 * @param int $page_id ID страницы.
 * @return array Массив ID категорий (structure_id).
 */
function multicatmarket_get_cats($page_id)
{
    global $db, $db_market_multicats;
    $page_id = (int)$page_id;
    $sql = "SELECT pcat_cat_id FROM $db_market_multicats WHERE pcat_page_id = $page_id";
    $res = $db->query($sql);
    return array_column($res->fetchAll(), 'pcat_cat_id');
}

/**
 * Получает заголовки категорий для указанной страницы, используя structure_id.
 *
 * @param int $page_id ID страницы.
 * @return array Массив заголовков категорий.
 */
function multicatmarket_get_cat_titles($page_id)
{
    global $db, $db_structure, $structure;
    $cats = multicatmarket_get_cats($page_id);
    $titles = [];
    if (!empty($cats)) {
        $sql = "SELECT structure_id, structure_title FROM $db_structure WHERE structure_id IN (" . implode(',', array_map('intval', $cats)) . ") AND structure_area = 'market'";
        $res = $db->query($sql);
        $db_titles = array_column($res->fetchAll(), 'structure_title', 'structure_id');
        foreach ($cats as $cat_id) {
            if (isset($db_titles[$cat_id])) {
                $titles[] = $db_titles[$cat_id];
            } else {
                // Fallback: ищем в $structure['market'] по structure_id
                foreach ($structure['market'] as $code => $cat_data) {
                    if (isset($cat_data['id']) && $cat_data['id'] == $cat_id) {
                        $titles[] = $cat_data['title'] ?? $code;
                        break;
                    }
                }
            }
        }
    }
    return $titles;
}

/**
 * Сохраняет категории (structure_id) для страницы, заменяя существующие связи.
 *
 * @param int $page_id ID страницы.
 * @param array $cats Массив ID категорий (structure_id).
 * @return bool True при успехе, false если нет категорий.
 */
function multicatmarket_save_cats($page_id, $cats)
{
    global $db, $db_market_multicats;
    $page_id = (int)$page_id;
    $cats = is_array($cats) ? array_unique(array_map('intval', array_filter($cats))) : [];
    if (empty($cats)) {
        return false;
    }
    $db->delete($db_market_multicats, "pcat_page_id = $page_id");
    foreach ($cats as $cat_id) {
        $db->insert($db_market_multicats, ['pcat_page_id' => $page_id, 'pcat_cat_id' => $cat_id]);
    }
    return true;
}