<?php

/**
 * Multicat plugin for Market Module, CMF Cotonti v.1.0.0, PHP v.8.4+, MySQL v.8.0
 * Filename: plugins/multicatmarket/inc/multicatmarket.functions.php
 * Purpose: Основные функции для обработки множественных категорий страниц в плагине Multicat. Использует $structure['market'] для получения заголовков и прямые SQL-запросы для работы с cot_market_multicats.
 * Date=Sep 11, 2026
 * @package multicatmarket
 * @version 1.3.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');
require_once cot_langfile('multicatmarket', 'plug');
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
 * Multicat plugin for Market Module, CMF Cotonti v.1.0.0, PHP v.8.4+, MySQL v.8.0
 * Filename: plugins/multicatmarket/inc/multicatmarket.functions.php (фрагмент)
 *
 * Сохраняет категории (structure_id) для страницы, заменяя существующие связи
 * в таблице cot_market_multicats.
 *
 * Логика:
 *   1. Удаляет ВСЕ существующие связи указанной страницы (безусловно).
 *   2. Если переданный массив пуст — это валидная операция «снять все
 *      мультикатегории»; функция возвращает true, ничего не вставляя.
 *   3. Иначе вставляет по одной записи на каждый уникальный положительный
 *      structure_id.
 *
 * Замечание:
 *   Раньше при пустом массиве функция возвращала false и НЕ удаляла старые
 *   связи. Это не давало пользователю снять все мультикатегории у товара
 *   через форму редактирования. Теперь удаление выполняется всегда, а пустой
 *   набор трактуется как «очистить связи».
 *
 * Date=Sep 11, 2026
 *
 * @package multicatmarket
 * @version 1.3.2
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 *
 * @param int   $page_id ID страницы (fieldmrkt_id товара).
 * @param array $cats    Массив ID категорий (structure_id, area = 'market').
 * @return bool          Всегда true — операция выполнена.
 */
function multicatmarket_save_cats($page_id, $cats)
{
    global $db, $db_market_multicats;

    // Приводим ID страницы к целому
    $page_id = (int)$page_id;

    // Нормализуем входной массив: только целые, только уникальные,
    // без нулей и пустых значений
    $cats = is_array($cats)
        ? array_unique(array_map('intval', array_filter($cats)))
        : [];

    // Шаг 1. Удаляем все существующие связи страницы — безусловно.
    // Это позволяет корректно обработать случай «пользователь снял все
    // галочки в дереве мультикатегорий»: старые связи не останутся висеть.
    $db->delete($db_market_multicats, "pcat_page_id = $page_id");

    // Шаг 2. Пустой набор — валидная операция: очистка всех мультикатегорий.
    // Ничего не вставляем, возвращаем true как признак успешного выполнения.
    if (empty($cats)) {
        return true;
    }

    // Шаг 3. Вставляем по одной записи на каждый уникальный structure_id
    foreach ($cats as $cat_id) {
        $db->insert($db_market_multicats, ['pcat_page_id' => $page_id, 'pcat_cat_id' => $cat_id]);
    }

    return true;
}