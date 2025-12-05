<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.edit.update.import
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.edit.import.php
 * Purpose: Хук для market.edit.update.import, modules\market\inc\market.edit.php, str 72. Импортирует категории из POST и устанавливает первую как fieldmrkt_cat (алиас/код категории в таблице маркет).
 * Date=2025-12-05
 * @package multicat
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

if (!isset($_POST['rcat']) || !is_array($_POST['rcat']) || empty($_POST['rcat'])) {
    cot_error($L['multicatmarket_error_no_category']);
} else {
    global $db, $db_structure;
    $first_cat_id = (int) reset($_POST['rcat']);
    $sql = "SELECT structure_code FROM $db_structure
            WHERE structure_id = $first_cat_id AND structure_area = 'market'";
    $item['fieldmrkt_cat'] = $db->query($sql)->fetchColumn() ?: $item['fieldmrkt_cat'];
}
