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
    // Подключаем глобальные переменные i18n4marketpro (аналогично cot_market_selectbox_structure_select2 и edit.tags.php)
    global $i18n4marketpro_enabled, $i18n4marketpro_read, $i18n4marketpro_notmain, $i18n4marketpro_locale;
    // Определяем, активен ли перевод категорий (текущий язык не основной)
    $i18n_enabled = $i18n4marketpro_read && (!empty($i18n4marketpro_locale) && $i18n4marketpro_locale != Cot::$cfg['defaultlang']);
    $cats = multicatmarket_get_cats($page_id);
    $titles = [];
    if (!empty($cats)) {
        // Расширяем SQL, чтобы получить structure_code (нужен для перевода)
        $sql = "SELECT structure_id, structure_title, structure_code FROM $db_structure WHERE structure_id IN (" . implode(',', array_map('intval', $cats)) . ") AND structure_area = 'market'";
        $res = $db->query($sql);
        // Индексируем по structure_id
        $db_cats = [];
        foreach ($res->fetchAll() as $row) {
            $db_cats[$row['structure_id']] = $row;
        }
        foreach ($cats as $cat_id) {
            if (isset($db_cats[$cat_id])) {
                $code = $db_cats[$cat_id]['structure_code'];
                $title = $db_cats[$cat_id]['structure_title'];
            } else {
                // Fallback: ищем в $structure['market'] по structure_id
                $code = null;
                $title = null;
                foreach ($structure['market'] as $struct_code => $cat_data) {
                    if (isset($cat_data['id']) && $cat_data['id'] == $cat_id) {
                        $code = $struct_code;
                        $title = $cat_data['title'] ?? $code;
                        break;
                    }
                }
                if ($title === null) {
                    continue; // Если не нашли — пропускаем
                }
            }
            // Если активен плагин i18n4marketpro и перевод включён — берём переведённое название
            if (cot_plugin_active('i18n4marketpro') && $i18n_enabled && $code !== null) {
                $translated_cat = cot_i18n4marketpro_get_cat($code, $i18n4marketpro_locale);
                if ($translated_cat && !empty($translated_cat['title'])) {
                    $title = $translated_cat['title'];
                }
            }
            $titles[] = $title;
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
