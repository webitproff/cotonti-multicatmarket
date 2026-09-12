<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.tags
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti v.1.0.0, PHP v.8.5+, MySQL v.8.4
 *
 * Filename: multicatmarket.market.tags.php
 *
 * Path:     plugins/multicatmarket/multicatmarket.market.tags.php
 *
 * ============================================================
 * ДОКУМЕНТАЦИЯ ПО ФАЙЛУ multicatmarket.market.tags.php
 * ============================================================
 *
 * Назначение:
 *   Хук market.tags модуля Market. Передаёт в шаблон список всех категорий,
 *   в которых показывается текущий товар (основная + дополнительные
 *   мультикатегории). Заголовки категорий берутся из cot_structure с учётом
 *   переводов плагина i18n4marketpro (функция cot_i18n4marketpro_get_cat()),
 *   если текущий язык отличается от основного.
 *
 * Вызывается:
 *   modules/market/inc/market.main.php перед финальным парсингом шаблона,
 *   в блоке cot_getextplugins('market.tags').
 *
 * В области видимости доступны:
 *   $item  — массив данных товара (fieldmrkt_id, fieldmrkt_cat и др.);
 *   $id    — ID товара;
 *   $al    — алиас товара;
 *   $c     — код категории товара;
 *   $cat   — массив данных текущей категории;
 *   $t     — объект XTemplate (шаблон товара).
 *
 * Что делает:
 *   1. Получает ID категорий товара через
 *      multicatmarket_get_cats_with_data().
 *   2. Если категорий нет — молча выходит.
 *   3. Для каждой категории присваивает теги MARKET_MULTICATS_ROW_* и
 *      парсит вложенный блок MARKET_MULTICATS_LIST.MARKET_MULTICATS_ROW.
 *   4. Парсит внешний блок MAIN.MARKET_MULTICATS_LIST.
 *
 * ВАЖНО (переменные цикла):
 *   Используется $mcat, а НЕ $c, $id, $al, $pg, $cat, $item, $t.
 *   Все перечисленные имена заняты в market.main.php в глобальной области
 *   видимости. Перезапись любой из них массивом приводит к warning
 *   "Array to string conversion" в system/cotemplate.php при вычислении
 *   {PHP.c} / {PHP.id} / {PHP.item...} в callback-аргументах шаблона.
 *
 * ============================================================
 * ПРИМЕР ПОДКЛЮЧЕНИЯ В ШАБЛОНЕ (market.tpl или market.<tpl>.tpl)
 * ============================================================
 *
 * Внутри блока <!-- BEGIN: MAIN --> один раз, там где должен выводиться
 * список мультикатегорий:
 *
 * <!-- BEGIN: MARKET_MULTICATS_LIST -->
 * <div class="card mb-4">
 *     <div class="card-header">
 *         <h3 class="h6 mb-0">{PHP.L.multicatmarket_market_cats_links}:</h3>
 *         <small>{PHP.L.multicatmarket_market_cats_links_hint}</small>
 *     </div>
 *     <div class="card-body">
 *         <ul class="list-group list-group-striped list-group-flush">
 *             <!-- BEGIN: MARKET_MULTICATS_ROW -->
 *             <li class="list-group-item">
 *                 <a href="{MARKET_MULTICATS_ROW_URL}">{MARKET_MULTICATS_ROW_TITLE}</a>
 *             </li>
 *             <!-- END: MARKET_MULTICATS_ROW -->
 *         </ul>
 *     </div>
 * </div>
 * <!-- END: MARKET_MULTICATS_LIST -->
 *
 * ============================================================
 * ЗАВИСИМОСТИ
 * ============================================================
 *   — inc/multicatmarket.functions.php:
 *       multicatmarket_get_cats_with_data($page_id, $locale)
 *   — lang/multicatmarket.<locale>.lang.php:
 *       $L['multicatmarket_market_cats_links'],
 *       $L['multicatmarket_market_cats_links_hint']
 *   — модуль market, хук market.tags (Cotonti 1.0.0+)
 *   — опционально: плагин i18n4marketpro (для перевода названий категорий)
 *
 * Source and updates   https://github.com/webitproff/cotonti-multicatmarket
 * ReadMeMore:          https://abuyfile.com/ru/market/cotonti/plugs/multicatmarket
 * Support:             https://abuyfile.com/ru/forums/cotonti/custom/plugs/topic229
 *
 * Date: Sep 12, 2026
 *
 * @package multicatmarket
 * @version 1.3.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('multicatmarket', 'plug');


if (empty($item['fieldmrkt_id'])) {
    return;
}

$marketCats = multicatmarket_get_cats_with_data((int)$item['fieldmrkt_id']);

if (empty($marketCats)) {
    return;
}

foreach ($marketCats as $mcat) {
    $t->assign([
        'MARKET_MULTICATS_ROW_ID'    => (int)$mcat['id'],
        'MARKET_MULTICATS_ROW_CODE'  => htmlspecialchars($mcat['code']),
        'MARKET_MULTICATS_ROW_TITLE' => htmlspecialchars($mcat['title']),
        'MARKET_MULTICATS_ROW_URL'   => $mcat['url'],
    ]);
    $t->parse('MAIN.MARKET_MULTICATS_LIST.MARKET_MULTICATS_ROW');
}

$t->parse('MAIN.MARKET_MULTICATS_LIST');