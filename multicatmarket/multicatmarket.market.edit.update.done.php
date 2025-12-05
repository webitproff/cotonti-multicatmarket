<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.edit.update.done
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.edit.update.done.php
 * Purpose: Хук для market.edit.update.done, modules\market\inc\market.functions.php, str 796. Сохраняет категории (structure_id) после обновления страницы товара.
 * Date=2025-12-05
 * @package multicat
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('multicatmarket', 'plug');

if (!empty($_POST['rcat']) && is_array($_POST['rcat'])) {
    $page_id = (int)$id;
    if ($page_id > 0) {
        multicatmarket_save_cats($page_id, $_POST['rcat']);
    }
}
