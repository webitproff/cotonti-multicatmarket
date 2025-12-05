<?php
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

/**
 * Multicat plugin for Market Module, CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: multicatmarket.global.php
 * Purpose: Глобальный хук для плагина Multicat. Определяет имя таблицы и загружает языковой файл.
 * Date=2025-12-05
 * @package multicatmarket
 * @version 1.1.0
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */
 
defined('COT_CODE') or die('Wrong URL');

require_once cot_langfile('multicatmarket', 'plug');
Cot::$db->registerTable('market_multicats');
global $db_market_multicats, $db_x, $cfg;

$db_market_multicats = $db_x . 'market_multicats';