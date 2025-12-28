<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.edit.tags
[END_COT_EXT]
==================== */
/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.edit.tags.php
 * Purpose: Хук для market.edit.tags, modules\market\inc\market.edit.php, str 223. Генерирует чекбоксы категорий (structure_id) в форме редактирования страницы. Использует $structure['market'] для списка категорий, с проверкой прав доступа.
 * Date=2025-12-28
 * @package multicat
 * @version 1.1.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('multicatmarket', 'plug');
require_once cot_langfile('multicatmarket', 'plug');

$id = cot_import('id', 'G', 'INT');
$selected = ($id > 0) ? multicatmarket_get_cats($id) : [];

$cats_values = [];
$cats_titles = [];

global $db, $db_structure, $structure;

// Подключаем глобальные переменные i18n4marketpro (аналогично cot_market_selectbox_structure_select2)
global $i18n4marketpro_enabled, $i18n4marketpro_read, $i18n4marketpro_notmain, $i18n4marketpro_locale;

// Определяем, активен ли перевод категорий (текущий язык не основной)
$i18n_enabled = $i18n4marketpro_read && (!empty($i18n4marketpro_locale) && $i18n4marketpro_locale != Cot::$cfg['defaultlang']);

foreach ($structure['market'] as $code => $cat_data) {
    if (cot_auth('market', $code, 'W')) {
        // Получаем structure_id (первичный ключ таблицы cot_structure)
        $sql = "SELECT structure_id FROM $db_structure WHERE structure_code = " . $db->quote($code) . " AND structure_area = 'market'";
        $cat_id = (int) $db->query($sql)->fetchColumn();

        if ($cat_id) {
            $cats_values[] = $cat_id;

            // Оригинальное название
            $title = $cat_data['title'] ?? $code;

            // Если активен плагин i18n4marketpro и перевод включён — берём переведённое название
            if (cot_plugin_active('i18n4marketpro') && $i18n_enabled) {
                $translated_cat = cot_i18n4marketpro_get_cat($code, $i18n4marketpro_locale);
                if ($translated_cat && !empty($translated_cat['title'])) {
                    $title = $translated_cat['title'];
                }
            }

            $cats_titles[] = $title;
        }
    }
}

$t->assign([
    'MARKET_FORM_MULTICAT' => cot_checklistbox(
        $selected,
        'rcat',
        $cats_values,
        $cats_titles,
        ['class' => 'checkbox'],
        '<br />',
        true,
        ''
    ),
    'MARKET_FORM_MULTICAT_HINT' => $L['multicatmarket_select'],
]);
