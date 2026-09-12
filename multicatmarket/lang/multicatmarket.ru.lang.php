<?php
/**
 * Multicat plugin for Market Module, CMF Cotonti v.1.0.0, PHP v.8.4+, MySQL v.8.0
 * Filename: plugins/multicatmarket/lang/multicatmarket.ru.lang.php
 * Purpose: Russian language file for the Multicat plugin. Defines the strings for the UI
 * Date=2026-09-11
 * @package multicatmarket
 * @version 1.3.2
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 | https://github.com/webitproff
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

/**
 * Plugin Conf
 */
$L['cfg_enabled'] = 'Включить множественные категории';

/**
 * Plugin Info
 */
$L['info_name']  = 'Multicat for Market Module';
$L['info_desc']  = 'Для модуля Market v5+. Позволяет назначать страницы сразу в несколько категорий';
$L['info_notes'] = 'в шаблоны market.edit.tpl/market.add.tpl: Добавить {MARKET_FORM_MULTICAT} и {MARKET_FORM_MULTICAT_HINT} сразу после категорий.';

// Общие строки фронтенда
$L['multicatmarket_select']            = 'Выберите категории (можно выбрать несколько)';
$L['multicatmarket_cats']              = 'Мультикатегории';
$L['multicatmarket_cats_edit']         = 'Показывать в категориях';
$L['multicatmarket_error_no_category'] = 'Ошибка: необходимо выбрать хотя бы одну категорию';
$L['multicatmarket_help']              = 'в шаблоны market.edit.tpl/market.add.tpl: Добавить {MARKET_FORM_MULTICAT} и {MARKET_FORM_MULTICAT_HINT} сразу после категорий.';

// Заголовок страницы админки
$L['multicatmarket_admin_title'] = 'Управление мультикатегориями';

// Вкладки
$L['multicatmarket_tab_list']  = 'Список связей';
$L['multicatmarket_tab_add']   = 'Добавить связь';
$L['multicatmarket_tab_clean'] = 'Очистка мусора';
$L['multicatmarket_tab_stats'] = 'Статистика';
$L['multicatmarket_tab_mass']  = 'Массовые операции';
$L['multicatmarket_warning_tab_under_develop']  = 'Эта вкладка еще на стадии разработки. Функционал ограничен и может работать не корректно.';

// Заголовки разделов
$L['multicatmarket_list_title']  = 'Список связей';
$L['multicatmarket_add_title']   = 'Добавление новой связи';
$L['multicatmarket_edit_title']  = 'Редактирование связи';
$L['multicatmarket_clean_title'] = 'Очистка мусора';
$L['multicatmarket_stats_title'] = 'Статистика';
$L['multicatmarket_mass_title']  = 'Массовые операции';

// Сообщения действий
$L['multicatmarket_deleted']         = 'Связь удалена.';
$L['multicatmarket_massdeleted']     = 'Удалено связей: %d';
$L['multicatmarket_clean_done']      = 'Удалено %d мусорных записей.';
$L['multicatmarket_added']           = 'Связь добавлена.';
$L['multicatmarket_updated']         = 'Связь обновлена.';
$L['multicatmarket_item_not_found']  = 'Товар с таким ID не найден.';
$L['multicatmarket_fill_required']   = 'Заполните обязательные поля.';
$L['multicatmarket_already_exists']  = 'Такая связь уже существует.';
$L['multicatmarket_massbound']       = 'Привязано товаров: %d';
$L['multicatmarket_massunbound']     = 'Отвязано товаров: %d';
$L['multicatmarket_not_exists']      = '[не существует]';
$L['multicatmarket_no_records']      = 'Записей не найдено.';

// Список / фильтр
$L['multicatmarket_filter_title_placeholder'] = 'Название товара';
$L['multicatmarket_filter_btn']               = 'Фильтр';
$L['multicatmarket_reset']                    = 'Сбросить';
$L['multicatmarket_col_id']                   = 'ID товара';
$L['multicatmarket_col_title']                = 'Название товара';
$L['multicatmarket_col_cat_id']               = 'ID категории';
$L['multicatmarket_col_category']             = 'Категория';
$L['multicatmarket_col_code']                 = 'Код';
$L['multicatmarket_col_actions']              = 'Действия';
$L['multicatmarket_btn_edit_short']           = 'Изм.';
$L['multicatmarket_btn_delete_short']         = 'Уд.';
$L['multicatmarket_confirm_delete']           = 'Точно удалить?';
$L['multicatmarket_confirm_massdelete']       = 'Удалить выбранные связи?';
$L['multicatmarket_btn_delete_selected']      = 'Удалить выбранные';

// Добавление
$L['multicatmarket_add_label_page']  = 'Товар (ID)';
$L['multicatmarket_add_label_cat']   = 'Категория';
$L['multicatmarket_add_page_hint']   = 'Укажите числовой ID товара из таблицы market.';
$L['multicatmarket_btn_add']         = 'Добавить связь';
$L['multicatmarket_select_none']     = '-- Выберите категорию --';

// Редактирование
$L['multicatmarket_edit_label_page']    = 'Товар';
$L['multicatmarket_edit_label_new_cat'] = 'Новая категория';
$L['multicatmarket_btn_save']           = 'Сохранить';
$L['multicatmarket_back_to_list']       = 'Назад к списку';

// Очистка
$L['multicatmarket_clean_header']         = 'Мусорные записи';
$L['multicatmarket_clean_desc']           = 'Проверьте количество битых записей и при необходимости запустите очистку.';
$L['multicatmarket_clean_zero_cat']       = 'С нулевым cat_id';
$L['multicatmarket_clean_orphan_items']   = 'С несуществующим товаром';
$L['multicatmarket_clean_orphan_cats']    = 'С несуществующей категорией';
$L['multicatmarket_clean_total']          = 'Всего к удалению';
$L['multicatmarket_clean_all_clean']      = 'Мусорных записей не обнаружено.';
$L['multicatmarket_confirm_clean']        = 'Удалить все мусорные записи?';
$L['multicatmarket_btn_clean_all']        = 'Очистить всё';

// Статистика
$L['multicatmarket_stats_header']       = 'Общая статистика';
$L['multicatmarket_stats_total_links']  = 'Всего связей';
$L['multicatmarket_stats_unique_items'] = 'Уникальных товаров';
$L['multicatmarket_stats_total_cats']   = 'Уникальных категорий';
$L['multicatmarket_stats_avg']          = 'Среднее на товар';
$L['multicatmarket_stats_top_cats']     = 'Топ-10 категорий';
$L['multicatmarket_stats_col_category'] = 'Категория';
$L['multicatmarket_stats_col_count']    = 'Связей';

// Массовые операции
$L['multicatmarket_mass_header']         = 'Массовые операции';
$L['multicatmarket_mass_bind_title']     = 'Привязать товары к категории';
$L['multicatmarket_mass_bind_desc']      = 'Пакетно добавляет связи между указанными товарами и выбранной категорией.';
$L['multicatmarket_mass_unbind_title']   = 'Отвязать товары от категории';
$L['multicatmarket_mass_unbind_desc']    = 'Пакетно удаляет связи между указанными товарами и выбранной категорией.';
$L['multicatmarket_mass_label_ids']      = 'ID товаров (через запятую)';
$L['multicatmarket_mass_ids_hint']       = 'Например: 101,102,103';
$L['multicatmarket_mass_label_bind_cat'] = 'Привязать к категории';
$L['multicatmarket_btn_bind']            = 'Привязать';
$L['multicatmarket_mass_label_ids_unbind'] = 'ID товаров (через запятую)';
$L['multicatmarket_mass_label_unbind_cat'] = 'Отвязать от категории';
$L['multicatmarket_btn_unbind']            = 'Отвязать';

// Список: колонки
$L['multicatmarket_col_main_cat'] = 'Основная категория';
$L['multicatmarket_col_links']    = 'Мультикатегории';

// Фильтр по наличию связей
$L['multicatmarket_filter_link_label']   = 'Наличие связей';
$L['multicatmarket_filter_link_all']     = 'Все';
$L['multicatmarket_filter_link_with']    = 'Только со связями';
$L['multicatmarket_filter_link_without'] = 'Только без связей';

// Пустой список связей
$L['multicatmarket_no_links'] = '— нет связей —';

// Массовая очистка / очистка всех связей товара
$L['multicatmarket_unlinked']          = 'Удалено связей: %d';
$L['multicatmarket_massunlinked']      = 'Удалено связей: %d у %d товаров';
$L['multicatmarket_confirm_unlink_all']   = 'Удалить все связи этого товара?';
$L['multicatmarket_confirm_massunlink']   = 'Удалить все связи выбранных товаров?';
$L['multicatmarket_btn_unlink_short']     = 'Очистить связи';
$L['multicatmarket_btn_unlink_selected']  = 'Очистить связи выбранных';
$L['multicatmarket_btn_edit_product']     = 'Редактировать товар';

$L['multicatmarket_market_cats_links']         = 'Мультикатегории товара';
$L['multicatmarket_market_cats_links_hint']    = 'Дополнительные категории, в которых этот товар показывается как похожий.';
