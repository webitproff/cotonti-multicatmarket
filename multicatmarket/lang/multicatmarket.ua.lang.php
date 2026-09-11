<?php
/**
 * Multicat plugin for Market Module, CMF Cotonti v.1.0.0, PHP v.8.4+, MySQL v.8.0
 * Filename: plugins/multicatmarket/lang/multicatmarket.ua.lang.php
 * Purpose: Ukrainian language file for the Multicat plugin. Defines the strings for the UI
 * Date=Sep 11, 2026
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
$L['cfg_enabled'] = 'Увімкнути множинні категорії';

/**
 * Plugin Info
 */
$L['info_name']  = 'Multicat for Market Module';
$L['info_desc']  = 'Для модуля Market v5+. Дозволяє призначати товари одразу до кількох категорій';
$L['info_notes'] = 'у шаблони market.edit.tpl / market.add.tpl: додати {MARKET_FORM_MULTICAT} та {MARKET_FORM_MULTICAT_HINT} одразу після категорій.';

// Загальні рядки фронтенду
$L['multicatmarket_select']            = 'Виберіть категорії (можна вибрати декілька)';
$L['multicatmarket_cats']              = 'Категорії';
$L['multicatmarket_cats_edit']         = 'Показувати в категоріях';
$L['multicatmarket_error_no_category'] = 'Помилка: необхідно вибрати хоча б одну категорію';
$L['multicatmarket_help']              = 'у шаблони market.edit.tpl / market.add.tpl: додати {MARKET_FORM_MULTICAT} та {MARKET_FORM_MULTICAT_HINT} одразу після категорій.';

// Заголовок сторінки адмінки
$L['multicatmarket_admin_title'] = 'Керування мультикатегоріями';

// Вкладки
$L['multicatmarket_tab_list']  = 'Список зв\'язків';
$L['multicatmarket_tab_add']   = 'Додати зв\'язок';
$L['multicatmarket_tab_clean'] = 'Очищення сміття';
$L['multicatmarket_tab_stats'] = 'Статистика';
$L['multicatmarket_tab_mass']  = 'Масові операції';
$L['multicatmarket_warning_tab_under_develop']  = 'Ця вкладка ще на стадії розробки. Функціонал обмежений і може працювати некоректно.';

// Заголовки розділів
$L['multicatmarket_list_title']  = 'Список зв\'язків';
$L['multicatmarket_add_title']   = 'Додавання нового зв\'язку';
$L['multicatmarket_edit_title']  = 'Редагування зв\'язку';
$L['multicatmarket_clean_title'] = 'Очищення сміття';
$L['multicatmarket_stats_title'] = 'Статистика';
$L['multicatmarket_mass_title']  = 'Масові операції';

// Повідомлення дій
$L['multicatmarket_deleted']         = 'Зв\'язок видалено.';
$L['multicatmarket_massdeleted']     = 'Видалено зв\'язків: %d';
$L['multicatmarket_clean_done']      = 'Видалено %d сміттєвих записів.';
$L['multicatmarket_added']           = 'Зв\'язок додано.';
$L['multicatmarket_updated']         = 'Зв\'язок оновлено.';
$L['multicatmarket_item_not_found']  = 'Товар з таким ID не знайдено.';
$L['multicatmarket_fill_required']   = 'Заповніть обов\'язкові поля.';
$L['multicatmarket_already_exists']  = 'Такий зв\'язок вже існує.';
$L['multicatmarket_massbound']       = 'Прив\'язано товарів: %d';
$L['multicatmarket_massunbound']     = 'Відв\'язано товарів: %d';
$L['multicatmarket_not_exists']      = '[не існує]';
$L['multicatmarket_no_records']      = 'Записів не знайдено.';

// Список / фільтр
$L['multicatmarket_filter_title_placeholder'] = 'Назва товару';
$L['multicatmarket_filter_btn']               = 'Фільтр';
$L['multicatmarket_reset']                    = 'Скинути';
$L['multicatmarket_col_id']                   = 'ID товару';
$L['multicatmarket_col_title']                = 'Назва товару';
$L['multicatmarket_col_cat_id']               = 'ID категорії';
$L['multicatmarket_col_category']             = 'Категорія';
$L['multicatmarket_col_code']                 = 'Код';
$L['multicatmarket_col_actions']              = 'Дії';
$L['multicatmarket_btn_edit_short']           = 'Ред.';
$L['multicatmarket_btn_delete_short']         = 'Вид.';
$L['multicatmarket_confirm_delete']           = 'Точно видалити?';
$L['multicatmarket_confirm_massdelete']       = 'Видалити вибрані зв\'язки?';
$L['multicatmarket_btn_delete_selected']      = 'Видалити вибрані';

// Додавання
$L['multicatmarket_add_label_page']  = 'Товар (ID)';
$L['multicatmarket_add_label_cat']   = 'Категорія';
$L['multicatmarket_add_page_hint']   = 'Вкажіть числовий ID товару з таблиці market.';
$L['multicatmarket_btn_add']         = 'Додати зв\'язок';
$L['multicatmarket_select_none']     = '-- Виберіть категорію --';

// Редагування
$L['multicatmarket_edit_label_page']    = 'Товар';
$L['multicatmarket_edit_label_new_cat'] = 'Нова категорія';
$L['multicatmarket_btn_save']           = 'Зберегти';
$L['multicatmarket_back_to_list']       = 'Назад до списку';

// Очищення
$L['multicatmarket_clean_header']         = 'Сміттєві записи';
$L['multicatmarket_clean_desc']           = 'Перевірте кількість битих записів і за потреби запустіть очищення.';
$L['multicatmarket_clean_zero_cat']       = 'З нульовим cat_id';
$L['multicatmarket_clean_orphan_items']   = 'З неіснуючим товаром';
$L['multicatmarket_clean_orphan_cats']    = 'З неіснуючою категорією';
$L['multicatmarket_clean_total']          = 'Всього до видалення';
$L['multicatmarket_clean_all_clean']      = 'Сміттєвих записів не виявлено.';
$L['multicatmarket_confirm_clean']        = 'Видалити всі сміттєві записи?';
$L['multicatmarket_btn_clean_all']        = 'Очистити все';

// Статистика
$L['multicatmarket_stats_header']       = 'Загальна статистика';
$L['multicatmarket_stats_total_links']  = 'Всього зв\'язків';
$L['multicatmarket_stats_unique_items'] = 'Унікальних товарів';
$L['multicatmarket_stats_total_cats']   = 'Унікальних категорій';
$L['multicatmarket_stats_avg']          = 'Середнє на товар';
$L['multicatmarket_stats_top_cats']     = 'Топ-10 категорій';
$L['multicatmarket_stats_col_category'] = 'Категорія';
$L['multicatmarket_stats_col_count']    = 'Зв\'язків';

// Масові операції
$L['multicatmarket_mass_header']         = 'Масові операції';
$L['multicatmarket_mass_bind_title']     = 'Прив\'язати товари до категорії';
$L['multicatmarket_mass_bind_desc']      = 'Пакетно додає зв\'язки між вказаними товарами та вибраною категорією.';
$L['multicatmarket_mass_unbind_title']   = 'Відв\'язати товари від категорії';
$L['multicatmarket_mass_unbind_desc']    = 'Пакетно видаляє зв\'язки між вказаними товарами та вибраною категорією.';
$L['multicatmarket_mass_label_ids']      = 'ID товарів (через кому)';
$L['multicatmarket_mass_ids_hint']       = 'Наприклад: 101,102,103';
$L['multicatmarket_mass_label_bind_cat'] = 'Прив\'язати до категорії';
$L['multicatmarket_btn_bind']            = 'Прив\'язати';
$L['multicatmarket_mass_label_ids_unbind'] = 'ID товарів (через кому)';
$L['multicatmarket_mass_label_unbind_cat'] = 'Відв\'язати від категорії';
$L['multicatmarket_btn_unbind']            = 'Відв\'язати';

// Список: колонки
$L['multicatmarket_col_main_cat'] = 'Основна категорія';
$L['multicatmarket_col_links']    = 'Мультикатегорії';

// Фільтр за наявністю зв\'язків
$L['multicatmarket_filter_link_label']   = 'Наявність зв\'язків';
$L['multicatmarket_filter_link_all']     = 'Всі';
$L['multicatmarket_filter_link_with']    = 'Тільки зі зв\'язками';
$L['multicatmarket_filter_link_without'] = 'Тільки без зв\'язків';

// Порожній список зв\'язків
$L['multicatmarket_no_links'] = '— немає зв\'язків —';

// Масова очистка / очистка всіх зв\'язків товару
$L['multicatmarket_unlinked']          = 'Видалено зв\'язків: %d';
$L['multicatmarket_massunlinked']      = 'Видалено %d зв\'язків у %d товарів';
$L['multicatmarket_confirm_unlink_all']   = 'Видалити всі зв\'язки цього товару?';
$L['multicatmarket_confirm_massunlink']   = 'Видалити всі зв\'язки вибраних товарів?';
$L['multicatmarket_btn_unlink_short']     = 'Очистити зв\'язки';
$L['multicatmarket_btn_unlink_selected']  = 'Очистити зв\'язки вибраних';
$L['multicatmarket_btn_edit_product']     = 'Редагувати товар';