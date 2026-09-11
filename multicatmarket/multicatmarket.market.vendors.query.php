<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.vendors.query
[END_COT_EXT]
==================== */

/**
 * Multicat Market plugin for CMF Cotonti
 *
 * Filename: multicatmarket.market.vendors.query.php
 *
 * Path:    plugins/multicatmarket/multicatmarket.market.vendors.query.php
 *
 * ============================================================
 * ДОКУМЕНТАЦИЯ ПО ХУКУ market.vendors.list.query
 * ============================================================
 *
 * Назначение:
 *   Хук market.vendors.query срабатывает в файле
 *   modules/market/inc/market.vendors.php ПЕРЕД сборкой SQL-условия
 *   WHERE и формированием основного запроса списка продавцов.
 *   Плагин использует его, чтобы расширить фильтр по категории:
 *   добавить в выборку продавцов, чьи товары привязаны к текущей
 *   категории через таблицу cot_market_multicats.
 *
 * Что делает:
 *   1. Регистрирует таблицу cot_market_multicats в объекте Cot::$db.
 *   2. Если категория не задана или её нет в структуре — выходит.
 *   3. Получает structure_id текущей категории из cot_structure.
 *   4. Формирует список подкатегорий (включая саму категорию).
 *   5. Удаляет из массива $where старое условие по категории
 *      (которое добавил модуль).
 *   6. Добавляет объединённое условие: товар лежит в одной из подкатегорий
 *      OR товар привязан к текущей категории через мультикатегории.
 *
 * Почему нужен:
 *   Стандартный фильтр модуля market.vendors.php отбирает товары только
 *   по полю fieldmrkt_cat. Но если товар выводится сразу в нескольких
 *   категориях (плагин Multicat), он должен попадать в список продавцов
 *   каждой из этих категорий. Плагин добавляет это условие, не изменяя
 *   сам модуль.
 *
 * Source and updates   https://github.com/webitproff/marketpro-cotonti
 * ReadMeMore:          https://abuyfile.com/ru/market/cotonti/plugs/marketpro
 * Support:             https://abuyfile.com/ru/forums/cotonti/custom/marketpro
 *
 * Date: Sep 11, 2026
 *
 * @package multicatmarket
 * @version 1.3.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */

// Стандартная защита от прямого обращения к файлу
defined('COT_CODE') or die('Wrong URL');

// Регистрируем таблицу связей мультикатегорий в объекте Cot::$db
Cot::$db->registerTable('market_multicats');

// Получаем глобальные переменные, переданные из market.vendors.php
global $c, $where;

/* =====================================================================
 * ПРОВЕРКА УСЛОВИЙ
 * ---------------------------------------------------------------------
 * Если категория не задана или её нет в структуре market — хук
 * не должен вносить никаких изменений, выходим.
 * ===================================================================== */

if (empty($c) || !isset(Cot::$structure['market'][$c])) {
    return;
}

// Получаем экземпляр объекта базы данных Cotonti
$db = Cot::$db;

/* =====================================================================
 * ПОЛУЧЕНИЕ structure_id ТЕКУЩЕЙ КАТЕГОРИИ
 * ===================================================================== */

// Получаем числовой ID категории из таблицы структуры
$cat_id = (int) $db->query(
    "SELECT structure_id FROM {$db->structure}
     WHERE structure_code = " . $db->quote($c) . "
       AND structure_area = 'market'"
)->fetchColumn();

// Если structure_id не найден — выходим
if ($cat_id <= 0) {
    return;
}

/* =====================================================================
 * ФОРМИРОВАНИЕ УСЛОВИЙ ФИЛЬТРА
 * ===================================================================== */

// Получаем список всех подкатегорий текущей категории
// (включая саму категорию в конце массива)
$catsub = cot_structure_children('market', $c, true);
$catsub[] = $c;

// Экранируем коды категорий для безопасной подстановки в SQL
$catsub_quoted = array_map([$db, 'quote'], $catsub);

// Основное условие: товар лежит в одной из указанных категорий
// (с учётом подкатегорий). Используется префикс p. — он действует
// на алиас таблицы market в SQL-запросе.
$main_cond = "p.fieldmrkt_cat IN (" . implode(',', $catsub_quoted) . ")";

// Дополнительное условие: товар привязан к текущей категории через
// таблицу мультикатегорий cot_market_multicats
$multi_cond = "p.fieldmrkt_id IN (
    SELECT pcat_page_id
    FROM {$db->market_multicats}
    WHERE pcat_cat_id = {$cat_id}
)";

/* =====================================================================
 * УДАЛЕНИЕ СТАРОГО УСЛОВИЯ И ДОБАВЛЕНИЕ НОВОГО
 * ---------------------------------------------------------------------
 * Модуль market.vendors.php уже добавил своё условие по категории
 * (fieldmrkt_cat IN ...). Чтобы не получить конфликт (два условия
 * соединяются через AND), удаляем старое условие из массива $where
 * и добавляем одно объединённое.
 * ===================================================================== */
// ЕСЛИ ЭТО РАССКОМЕНТИРОВАТЬ ТО УБИРАЕМ if (!cot_plugin_active('multicatmarket'))
// Удаляем из массива $where все условия, содержащие 'p.fieldmrkt_cat IN'
/* $where = array_filter($where, function ($cond) {
    return strpos($cond, 'p.fieldmrkt_cat IN') === false;
}); */
/* ПОКА ЗАКОМЕНТИРОВАЛИ, ПОТОМУ ЧТО В market.vendors.php ОБЕРНУЛИ В УСЛОВИЕ ПРОВЕРКИ РАБОТЫ ПЛАГИНА
ВОТ ТАК
if (!cot_plugin_active('multicatmarket')) {
    if (!empty($c) && isset(Cot::$structure['market'][$c])) {
        $catsub = cot_structure_children('market', $c, true);
        $catsub[] = $c;
        $catsub_quoted = array_map([Cot::$db, 'quote'], $catsub);
        $where[] = 'p.fieldmrkt_cat IN (' . implode(',', $catsub_quoted) . ')';
    }
}
 */
// Добавляем объединённое условие: обычная категория OR мультикатегории
$where[] = "(" . $main_cond . " OR " . $multi_cond . ")";