<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.edit.update.done
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti v.1.0.0, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.edit.update.done.php
 * Purpose: Хук для market.edit.update.done, modules\market\inc\market.functions.php, str 796. Сохраняет категории (structure_id) после обновления страницы товара.
 * Date=Sep 11, 2026
 * @package multicat
 * @version 1.3.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('multicatmarket', 'plug');

$page_id = (int)$id;
if ($page_id > 0) {
    $rcats = (isset($_POST['rcat']) && is_array($_POST['rcat'])) ? $_POST['rcat'] : [];
    multicatmarket_save_cats($page_id, $rcats);
}


/* defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('multicatmarket', 'plug');

if (!empty($_POST['rcat']) && is_array($_POST['rcat'])) {
    $page_id = (int)$id;
    if ($page_id > 0) {
        multicatmarket_save_cats($page_id, $_POST['rcat']);
    }
}
 */