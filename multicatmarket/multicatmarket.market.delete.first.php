<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=market.delete.first
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.market.delete.first.php
 * Purpose: Хук для market.delete.first \modules\market\inc\MarketControlService.php str 58. Удаляет связи категорий перед удалением страницы товара.
 * Date=2026-05-08
 * @package multicatmarket
 * @version 1.2.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */
 
defined('COT_CODE') or die('Wrong URL');
require_once cot_incfile('multicatmarket', 'plug');

global $db, $db_market_multicats;

$db->delete($db_market_multicats, "pcat_page_id = " . (int)$id);

/* 
global $db, $db_market_multicats, $page_id;
$db->delete($db_market_multicats, "pcat_page_id = " . (int)$page_id); 
*/
