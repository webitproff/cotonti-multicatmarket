<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.edit.tags
[END_COT_EXT]
==================== */
/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.edit.tags.php
 * Purpose: Хук для market.edit.tags. Генерирует иерархический список чекбоксов категорий,
 *          используя тот же принцип получения детей, что и cot_build_structure_market_tree.
 * Date=2026-05-29
 * @package multicat
 * @version 1.2.2
 * @author webitproff
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('multicatmarket', 'plug');
require_once cot_langfile('multicatmarket', 'plug');

$id = cot_import('id', 'G', 'INT');
$selected = ($id > 0) ? multicatmarket_get_cats($id) : [];

global $db, $db_structure, $structure, $cfg;
global $i18n4marketpro_enabled, $i18n4marketpro_read, $i18n4marketpro_notmain, $i18n4marketpro_locale;
$i18n_enabled = $i18n4marketpro_read && (!empty($i18n4marketpro_locale) && $i18n4marketpro_locale != Cot::$cfg['defaultlang']);

// Чёрный список категорий (если используется)
$blacklist_cfg = Cot::$cfg['market']['marketblacktreecatspage'] ?? '';
$blacklist = array_map('trim', explode(',', $blacklist_cfg));

// Кэш соответствий code => structure_id
$code_to_id = [];
$res = $db->query("SELECT structure_code, structure_id FROM $db_structure WHERE structure_area = 'market'");
foreach ($res->fetchAll() as $row) {
    $code_to_id[$row['structure_code']] = (int) $row['structure_id'];
}

/**
 * Рекурсивная генерация HTML-списка чекбоксов.
 * @param string $parent Код родительской категории ('' для корня)
 * @param array $selected Массив выбранных structure_id
 * @param array $code_to_id Соответствие code => structure_id
 * @param array $blacklist Чёрный список кодов категорий
 * @param bool $i18n_enabled Активен ли перевод категорий
 * @return string HTML-код вложенных <li>
 */
function multicatmarket_render_checkbox_tree($parent, $selected, $code_to_id, $blacklist, $i18n_enabled)
{
    global $structure, $i18n4marketpro_locale;

    // Получаем дочерние категории по аналогии с cot_build_structure_market_tree
    if (empty($parent)) {
        // Корневой уровень: все категории, у которых в path нет точек
        $allcat = cot_structure_children('market', '');
        $children = [];
        foreach ($allcat as $code) {
            if (
                !isset($structure['market'][$code]['path']) ||
                mb_substr_count($structure['market'][$code]['path'], '.') != 0 ||
                in_array($code, $blacklist)
            ) {
                continue;
            }
            $children[] = $code;
        }
    } else {
        // Подкатегории: берём из subcats родителя
        if (!isset($structure['market'][$parent]['subcats'])) {
            return '';
        }
        $children = array_filter($structure['market'][$parent]['subcats'], function($code) use ($blacklist) {
            return !in_array($code, $blacklist);
        });
    }

    if (empty($children)) {
        return '';
    }

    $html = '';
    foreach ($children as $code) {
        if (!cot_auth('market', $code, 'W')) continue;
        if (!isset($code_to_id[$code])) continue;

        $cat_id = $code_to_id[$code];
        $title = $structure['market'][$code]['title'] ?? $code;

        // Перевод через i18n
        if (cot_plugin_active('i18n4marketpro') && $i18n_enabled) {
            $translated = cot_i18n4marketpro_get_cat($code, $i18n4marketpro_locale);
            if ($translated && !empty($translated['title'])) {
                $title = $translated['title'];
            }
        }

        $checked = in_array($cat_id, $selected) ? ' checked="checked"' : '';
        $id_attr = 'rcat_' . $cat_id;

        // Разделитель <hr> только между корневыми категориями
        if (empty($parent) && $html !== '') {
            $html .= '<hr>';
        }

        $html .= '<li class="list-group-item bg-transparent border-0 py-0">';
        $html .= '<div class="form-check" style="margin: 0;">';
        $html .= '<input class="form-check-input" type="checkbox" name="rcat[]" value="' . $cat_id . '"' . $checked . ' id="' . $id_attr . '">';
        $html .= '<label class="form-check-label" for="' . $id_attr . '">' . htmlspecialchars($title) . '</label>';
        $html .= '</div>';

        // Рекурсивно рендерим подкатегории
        $sub = multicatmarket_render_checkbox_tree($code, $selected, $code_to_id, $blacklist, $i18n_enabled);
        if ($sub !== '') {
            $html .= '<ul>' . $sub . '</ul>';
        }
        $html .= '</li>';
    }
    return $html;
}

// Генерация полного списка в скроллируемом контейнере высотой 480px
$list_html = '<div style="max-height: 480px; overflow-y: auto; width: 100%;">';
$list_html .= '<ul class="list-group list-group-flush">';
$list_html .= multicatmarket_render_checkbox_tree('', $selected, $code_to_id, $blacklist, $i18n_enabled);
$list_html .= '</ul>';
$list_html .= '</div>';
$t->assign([
    'MARKET_FORM_MULTICAT' => $list_html,
    'MARKET_FORM_MULTICAT_HINT' => $L['multicatmarket_select'],
]);
