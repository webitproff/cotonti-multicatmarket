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

// Проверка, что скрипт запущен в контексте Cotonti, иначе завершение с ошибкой
defined('COT_CODE') or die('Wrong URL');

// Регистрируем пользовательскую таблицу 'market_multicats' в объекте базы данных Cotonti,
// чтобы к ней можно было обращаться через $db->market_multicats
Cot::$db->registerTable('market_multicats');

// Объявляем глобальные переменные $c (код текущей категории) и $where (массив условий WHERE запроса)
global $c, $where;

// Если категория не задана (например, главная страница), выходим из хука – фильтрация не нужна
if (empty($c)) {
    return;
}

// Получаем экземпляр объекта базы данных Cotonti
$db = Cot::$db;

// Определяем числовой ID структуры категории по её коду ($c) из таблицы структур.
// Используется прямой SQL-запрос с экранированием значения для безопасности.
// fetchColumn() возвращает значение первого столбца результата, преобразованное в int
$cat_id = (int)$db->query(
    "SELECT structure_id FROM {$db->structure}
     WHERE structure_code = " . $db->quote($c) . "
       AND structure_area = 'market'"
)->fetchColumn();

// Если структура с таким кодом не найдена или ID <= 0, то выходим – нет смысла добавлять условие
if ($cat_id <= 0) {
    return;
}

// =====================================================================
// ============== ебучий пиздец с хуком если $cfg['cache'] = true;	
// =====================================================================
// Проверяем, есть ли в таблице мультикатегорий хотя бы одна запись для данной категории.
// Если есть, это значит, что в этой категории отображаются товары, привязанные через мультикатегории.
// В таком случае принудительно отключаем кэш для данного запроса, чтобы избежать белого экрана.
// $has_multi = (bool)$db->query(
//     "SELECT 1 FROM {$db->market_multicats} WHERE pcat_cat_id = {$cat_id} LIMIT 1"
// )->fetchColumn();

// Если в таблице мультикатегорий есть записи для этой категории, отключаем кэш
// if ($has_multi) {
//    Cot::$cache = false;
// }
// =====================================================================
// ============== ебучий пиздец с хуком если $cfg['cache'] = true;	
// =====================================================================

// Формируем условие для товаров, у которых основная категория (fieldmrkt_cat) совпадает с текущей
$main_cond = "p.fieldmrkt_cat = " . $db->quote($c);

// Формируем условие для товаров, которые привязаны через мультикатегории:
// p.fieldmrkt_id должен присутствовать в таблице cot_market_multicats с нужным pcat_cat_id
$multi_cond = "p.fieldmrkt_id IN (
    SELECT pcat_page_id
    FROM {$db->market_multicats}
    WHERE pcat_cat_id = {$cat_id}
)";

// Если в массиве $where уже задано условие для категории (например, от другого плагина),
// то расширяем его через OR с нашим мультикатегорийным условием
if (isset($where['cat']) && trim($where['cat']) !== '') {
    $where['cat'] = "(" . $where['cat'] . " OR " . $multi_cond . ")";
} else {
    // Иначе создаём новое условие, объединяющее основную категорию и мультикатегории
    $where['cat'] = "(" . $main_cond . " OR " . $multi_cond . ")";
}





















/* 
defined('COT_CODE') or die('Wrong URL');


Cot::$db->registerTable('market_multicats');

global $c, $where;

if (empty($c)) {
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

// Отключаем кеш для этой категории, если в ней есть товары из мультикатегорий
$has_multi = (bool)$db->query(
    "SELECT 1 FROM {$db->market_multicats} WHERE pcat_cat_id = {$cat_id} LIMIT 1"
)->fetchColumn();
if ($has_multi) {
    Cot::$cache = false;
}

$main_cond = "p.fieldmrkt_cat = " . $db->quote($c);
$multi_cond = "p.fieldmrkt_id IN (
    SELECT pcat_page_id
    FROM {$db->market_multicats}
    WHERE pcat_cat_id = {$cat_id}
)";

if (isset($where['cat']) && trim($where['cat']) !== '') {
    $where['cat'] = "(" . $where['cat'] . " OR " . $multi_cond . ")";
} else {
    $where['cat'] = "(" . $main_cond . " OR " . $multi_cond . ")";
} */