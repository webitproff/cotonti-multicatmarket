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
 * Date=2025-12-05
 * @package multicat
 * @version 1.1.0
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

foreach ($structure['market'] as $code => $cat_data) {
    if (cot_auth('market', $code, 'W')) {
        $sql = "SELECT structure_id FROM $db_structure WHERE structure_code = " . $db->quote($code) . " AND structure_area = 'market'";
        $cat_id = $db->query($sql)->fetchColumn();
        if ($cat_id) {
            $cats_values[] = (int)$cat_id;
            $cats_titles[] = $cat_data['title'] ?? $code;
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