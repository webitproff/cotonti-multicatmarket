# 🇬🇧 Multicat Market — Multiple Categories for a Single Product in Market Module v.5.x.x (CMF Cotonti v.1.0.0, PHP v.8.5+, MySQL v.8.4)

## Description and How It Works

The **Multicat Market** plugin adds the ability to place a single listing/product (Market module page) in **multiple categories** of the market structure simultaneously.

Before installing this plugin, each Market page could belong to only one category (`page_cat` → `fieldmrkt_cat`). After installation:

* The primary category is still stored in the standard field `fieldmrkt_cat` (required for compatibility with the core and other plugins).
* All selected categories (including the primary one) are additionally saved in a separate table `cot_market_multicats`.
* When viewing the product list in any category (`market.list`), the plugin automatically adds a condition to the query that finds products both by the old field and by the new relationship table — so the product appears in all selected categories.
* When editing a listing, instead of a single category dropdown, a set of checkboxes appears — you can select as many categories as you want.
* The first selected category automatically becomes the "primary" one (`fieldmrkt_cat`) — this guarantees full compatibility with all existing templates and core functions.

Thus, the plugin is completely transparent to the user and other extensions: everything continues to work as before, but a new feature appears — **multi-categorization**.

> **Important:** The plugin will not work with your Market module if it is not version 5 and not developed by me.
> You can order adaptation of the plugin for **[ freelance exchange builds](https://github.com/webitproff/cot_2waydeal_build)**. . To do so, **[write to me on the page](https://abuyfile.com/users/webitproff)**

---

## Installation

1. Unpack the archive and upload the `multicatmarket` folder to the `plugins/` directory on the server.
2. Go to **Admin Panel → Extensions → Multicat Market → Install**.
3. After installation, in the `market.edit.tpl` template, add the two tags right after the standard category selector:

```html
<!-- IF {PHP|cot_plugin_active('multicatmarket')} -->
<div class="col-12">
	<label for="marketCat" class="form-label fw-semibold">{PHP.L.multicatmarket_cats_edit}</label>
	<div class="multicat-checkboxes">{MARKET_FORM_MULTICAT}</div>
	<small class="form-text text-muted mt-1">{MARKET_FORM_MULTICAT_HINT}</small>
</div>
<!-- ENDIF -->
```	
...

```html
<!-- IF {PHP|cot_plugin_active('multicatmarket')} -->
<style>
/* Красивый вертикальный список категорий в форме редактирования товара (multicat) */
.multicat-checkboxes .form-check {
    display: block;          /* Каждый чекбокс на новой строке */
    margin-bottom: 0.75rem;  /* Отступ между элементами */

}

.multicat-checkboxes .form-check + br {
    display: none;           /* Скрываем <br>, они больше не нужны */
}

.multicat-checkboxes .form-check-label {
    font-weight: normal;     /* По желанию — убираем жирность, если хочется легче */
    cursor: pointer;
}

.multicat-checkboxes .form-check-input {
    margin-right: 0.5rem;    /* Небольшой отступ между чекбоксом и текстом */
}
</style>
<!-- ENDIF -->
```

In the `market.admin.tpl` template, in the desired place (e.g., right after the status), add:

```html
<!-- IF {PHP|cot_plugin_active('multicatmarket')} -->
<div class="text-muted small">{ADMIN_PAGE_MULTICATS}</div>
<!-- ENDIF -->
```

Done! Now when editing a product card, you will see a list of category checkboxes.

> **Important:** If you do not add these tags to the template — multiple categories will not work (there will simply be no selection form).

---

## Plugin Files Structure & Purpose

```
/multicatmarket/
├── inc/
│   └── multicatmarket.functions.php        ← Core functions for multi-categories
├── lang/
│   ├── multicatmarket.ru.lang.php          ← Russian language file
│   └── multicatmarket.en.lang.php          ← English language file
├── setup/
│   ├── multicatmarket.install.sql          ← Creates table `cot_market_multicats` + migrates existing data
│   └── multicatmarket.uninstall.sql        ← Removes table on uninstall
├── multicatmarket.admin.loop.php           ← Hook market.admin.loop — displays categories in admin list
├── multicatmarket.market.delete.first.php  ← Hook market.delete.first — removes relations when deleting product
├── multicatmarket.market.edit.import.php   ← Hook market.edit.update.import — takes categories from POST and sets first as main
├── multicatmarket.market.edit.tags.php     ← Hook market.edit.tags — generates checkboxes in edit form
├── multicatmarket.market.edit.update.done.php ← Hook market.edit.update.done — saves relations to DB after update
├── multicatmarket.market.list.query.php    ← Hook market.list.query — main list filter with multi-category support
├── multicatmarket.global.php               ← Global hook — table registration, without it → 500 error
└── multicatmarket.setup.php                ← Registers plugin in Cotonti core and config
```

---

## Detailed Description of Each File & Hook

### 1. `multicatmarket.global.php`

Global plugin file. Loaded automatically on every Cotonti load.
Registers the `cot_market_multicats` table in the system:

```php
Cot::$db->registerTable('market_multicats');
```

Without this file, accessing the table will cause a 500 error.

### 2. `multicatmarket.setup.php`

* Registers plugin metadata in the `cot_core` table.
* Adds configuration settings to the `cot_config` table.

### 3. `inc/multicatmarket.functions.php`

Contains three core functions:

* `multicatmarket_get_cats($page_id)` — returns array of `structure_id` of categories where the product is located.
* `multicatmarket_get_cat_titles($page_id)` — returns array of category titles (used in admin).
* `multicatmarket_save_cats($page_id, $cats)` — on save, completely replaces product-category relations (deletes old, inserts new in `cot_market_multicats`). Do not confuse with `fieldmrkt_cat`.

### 4. `lang/multicatmarket.ru.lang.php`

All interface strings and hints in Russian:

* Plugin name
* Text hint under checkboxes
* Error message if no category is selected
* Instructions for inserting tags into the template

### 5. `setup/multicatmarket.install.sql`

Creates the table and migrates existing data:

```sql
CREATE TABLE IF NOT EXISTS `cot_market_multicats` (
  `pcat_page_id` int UNSIGNED NOT NULL,
  `pcat_cat_id` mediumint UNSIGNED NOT NULL,
  UNIQUE KEY `pcat_unique` (`pcat_page_id`, `pcat_cat_id`),
  KEY `pcat_page_id` (`pcat_page_id`),
  KEY `pcat_cat_id` (`pcat_cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Migration of existing categories
INSERT IGNORE INTO `cot_market_multicats` (`pcat_page_id`, `pcat_cat_id`)
SELECT p.fieldmrkt_id, s.structure_id
FROM `cot_market` p
JOIN `cot_structure` s 
  ON p.fieldmrkt_cat = s.structure_code
WHERE p.fieldmrkt_id > 0
  AND s.structure_id > 0
  AND p.fieldmrkt_cat != ''
  AND s.structure_area = 'market';
```

### 6. `multicatmarket.admin.loop.php` → hook `market.admin.loop`

In the admin panel, adds a column listing all categories a product belongs to using `multicatmarket_get_cat_titles()`. Outputs `ADMIN_PAGE_MULTICATS`.

### 7. `multicatmarket.market.delete.first.php` → hook `market.delete.first`

Runs before product deletion. Removes all entries from `cot_market_multicats` for that `page_id` to avoid dangling relations.

### 8. `multicatmarket.market.edit.import.php` → hook `market.edit.update.import`

During form import, if `$_POST['rcat']` contains selected categories, takes the first one, finds its `structure_code`, and writes it to `fieldmrkt_cat`. Ensures primary category is filled.

### 9. `multicatmarket.market.edit.tags.php` → hook `market.edit.tags`

Generates checkboxes for all Market categories, respecting user write permissions. Creates two template tags:

* `{MARKET_FORM_MULTICAT}` — the checkboxes
* `{MARKET_FORM_MULTICAT_HINT}` — hint "Select categories (you can choose several)"

### 10. `multicatmarket.market.edit.update.done.php` → hook `market.edit.update.done`

After successful product update, saves all selected category relations using `multicatmarket_save_cats()`.

### 11. `multicatmarket.market.list.query.php` → hook `market.list.query`

Handles displaying products in multiple categories:

1. Finds the `structure_id` of the category `$c`.
2. Replaces filter condition:

```sql
(p.fieldmrkt_cat = 'code' OR EXISTS (SELECT 1 FROM cot_market_multicats …))
```

Returns products with primary or additional categories.

---

## Summary

The plugin fully enables **multiple categories** for the Market module while maintaining 100% compatibility with Cotonti core and other extensions.
No changes to core files or Market module are required — everything is implemented via standard hooks and a separate relationship table.

Install **Multicat Market** and add the template tags to your product editing templates to make one product appear in multiple categories.

---

**Version:** 1.1.0 
**Date:** 2025-12-05 
**Author:** webitproff 
**Compatibility:** Cotonti Siena 0.9.26+, Market v5+, PHP 8.1–8.4, MySQL 8.0+
**License:** BSD
**Repository:** [https://github.com/webitproff/cotonti-multicatmarket](https://github.com/webitproff/cotonti-multicatmarket)


___

# 🇷🇺 


# Multicat Market — множественные категории одного товара для модуля Market v.5.x.x (Cotonti Siena)
 

## Описание и принцип работы

Плагин **Multicat Market** добавляет возможность размещать одно объявление/товар (страницу модуля Market) одновременно в **нескольких категориях** структуры `market`.

До установки этого плагина каждая страница Market могла принадлежать только одной категории (поле `page_cat` → `fieldmrkt_cat`). После установки плагина:

- Основная категория по-прежнему хранится в стандартном поле `fieldmrkt_cat` (это нужно для совместимости с ядром и другими плагинами).

- Все выбранные категории (включая основную) дополнительно сохраняются в отдельной таблице `cot_market_multicats`.

- При просмотре списка товаров в любой категории (`market.list`) плагин автоматически подмешивает в запрос условие, которое находит товары и по старому полю, и по новой таблице связей — поэтому товар отображается во всех выбранных категориях.

- При редактировании объявления вместо одного селекта категории появляется набор чекбоксов — можно выбрать сколько угодно категорий.

- Первая выбранная категория автоматически становится «основной» (`fieldmrkt_cat`) — это гарантирует полную совместимость со всеми существующими шаблонами и функциями ядра.


Таким образом, плагин полностью прозрачен для пользователя и других расширений: всё продолжает работать как раньше, но появляется новая возможность — мультикатегоризация.


> Важно: плагин не будет работать с вашим модулем **Market**, если он не 5-й версии и не моей разработки.
> Вы можете заказать адаптацию плагина под **[модули сборки фриланс-биржи](https://github.com/webitproff/cot_2waydeal_build)**. Для этого **[напишите мне на странице](https://abuyfile.com/users/webitproff)**


## Установка

1. Распаковать архив и папку `multicatmarket` загрузить на сервер в папку `plugins/`.
2. Зайти в админку → Расширения → Multicat Market → Установить.
3. После установки плагина, в шаблон `market.edit.tpl` добавить два тега сразу после стандартного селектора категорий:

```html
<!-- IF {PHP|cot_plugin_active('multicatmarket')} -->
<div class="col-12">
	<label for="marketCat" class="form-label fw-semibold">{PHP.L.multicatmarket_cats_edit}</label>
	<div class="multicat-checkboxes">{MARKET_FORM_MULTICAT}</div>
	<small class="form-text text-muted mt-1">{MARKET_FORM_MULTICAT_HINT}</small>
</div>
<!-- ENDIF -->
```	
...

```html
<!-- IF {PHP|cot_plugin_active('multicatmarket')} -->
<style>
/* Красивый вертикальный список категорий в форме редактирования товара (multicat) */
.multicat-checkboxes .form-check {
    display: block;          /* Каждый чекбокс на новой строке */
    margin-bottom: 0.75rem;  /* Отступ между элементами */

}

.multicat-checkboxes .form-check + br {
    display: none;           /* Скрываем <br>, они больше не нужны */
}

.multicat-checkboxes .form-check-label {
    font-weight: normal;     /* По желанию — убираем жирность, если хочется легче */
    cursor: pointer;
}

.multicat-checkboxes .form-check-input {
    margin-right: 0.5rem;    /* Небольшой отступ между чекбоксом и текстом */
}
</style>
<!-- ENDIF -->
```
в шаблон `market.admin.tpl`
в нужном месте, например сразу после статуса, добавить
```
	<!-- IF {PHP|cot_plugin_active('multicatmarket')} -->
	<div class="text-muted small">{ADMIN_PAGE_MULTICATS}</div>
	<!-- ENDIF -->	
```

4. Готово! Теперь при редактировании карточки товара будет список чекбоксов с категориями.

> Важно: если не добавить эти теги в шаблон — множественные категории работать не будут (просто не будет формы выбора).



## Структура файлов и назначение каждого файла

```
/multicatmarket/

├── inc/
│   └── multicatmarket.functions.php       ← основные функции работы с мультикатугориями
├── lang/
│   ├── multicatmarket.ru.lang.php         ← русский языковой файл
│   └── multicatmarket.en.lang.php         ← английский языковой файл 
├── setup/
│   ├── multicatmarket.install.sql         ← создание таблицы `cot_market_multicats` + миграция существующих данных
│   └── multicatmarket.uninstall.sql       ← удаление таблицы при деинсталляции
├── multicatmarket.admin.loop.php          ← хук market.admin.loop — выводит категории в админ-списке
├── multicatmarket.market.delete.first.php ← хук market.delete.first — удаляет связи при удалении товара
├── multicatmarket.market.edit.import.php  ← хук market.edit.update.import — берёт категории из POST и ставит первую как основную
├── multicatmarket.market.edit.tags.php     ← хук market.edit.tags — генерирует чекбоксы в форме редактирования
├── multicatmarket.market.edit.update.done.php ← хук market.edit.update.done — сохраняет связи в БД после обновления
├── multicatmarket.market.list.query.php   ← хук market.list.query — главный фильтр списка по категории с учётом мультикатегорий
├── multicatmarket.global.php              ← хук global - глобальная инициализация, регистрация таблицы, без него получим ошибку 500
└── multicatmarket.setup.php               ← регистрация плагина в ядре Cotonti и настройки конфигурации
```

### Подробное описание каждого файла и хука


#### 1. `multicatmarket.global.php`
Глобальный файл плагина. Подключается автоматически при любой загрузке Cotonti.  
Да, это не очень желательно, но пока это так.
Регистрирует таблицу `cot_market_multicats` в системе:

```php
Cot::$db->registerTable('market_multicats');
```

Без этого файла при обращении к таблице будет ошибка 500.


#### 2. `multicatmarket.setup.php`

Регистрирует метаданные плагина в таблице `cot_core`
Добавляет настройки конфигурации в таблице `cot_config`


#### 3. `inc/multicatmarket.functions.php`

Содержит три основные функции:

- `multicatmarket_get_cats($page_id)` — возвращает массив structure_id категорий, в которых находится товар.
- `multicatmarket_get_cat_titles($page_id)` — возвращает массив названий категорий (используется в админке).
- `multicatmarket_save_cats($page_id, $cats)` — при сохранении, на странице редактирования, полностью заменяет связи товара с категориями (удаляет старые, вставляет новые в `cot_market_multicats`) **не путать с `fieldmrkt_cat` !!!**.


#### 4. `lang/multicatmarket.ru.lang.php`

Все строки интерфейса и подсказки на русском языке:

- название плагина,
- текст подсказки под чекбоксами,
- сообщение об ошибке, если не выбрана ни одна категория,
- инструкция по вставке тегов в шаблон.


#### 5. `setup/multicatmarket.install.sql`

Создаёт таблицу.
И сразу выполняет миграцию: берёт все существующие товары, смотрит их `fieldmrkt_cat` (код категории), находит соответствующий `structure_id` и записывает связь в новую таблицу.  
Благодаря этому после установки плагина все старые товары автоматически появляются в своих категориях — ничего не теряется.

```sql
CREATE TABLE IF NOT EXISTS `cot_market_multicats` (
  `pcat_page_id` int UNSIGNED NOT NULL,
  `pcat_cat_id` mediumint UNSIGNED NOT NULL,
  UNIQUE KEY `pcat_unique` (`pcat_page_id`, `pcat_cat_id`),
  KEY `pcat_page_id` (`pcat_page_id`),
  KEY `pcat_cat_id` (`pcat_cat_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Миграция существующих категорий, только валидные fieldmrkt_id и structure_id
INSERT IGNORE INTO `cot_market_multicats` (`pcat_page_id`, `pcat_cat_id`)
SELECT p.fieldmrkt_id, s.structure_id
FROM `cot_market` p
JOIN `cot_structure` s 
  ON p.fieldmrkt_cat = s.structure_code
WHERE p.fieldmrkt_id > 0
  AND s.structure_id > 0
  AND p.fieldmrkt_cat != ''
  AND s.structure_area = 'market';
```


#### 6. `multicatmarket.admin.loop.php` → хук `market.admin.loop`

В Панели Управления, в админке, при просмотре списка товаров 
`Управление сайтом -> Расширения -> Market -> Администрирование`
(market.admin.php) добавляет колонку с перечислением всех категорий, в которых находится товар.  
Использует функцию `multicatmarket_get_cat_titles()` и выводит тег `ADMIN_PAGE_MULTICATS`.


#### 7. `multicatmarket.market.delete.first.php` → хук `market.delete.first`

Выполняется до удаления товара. Удаляет все записи из `cot_market_multicats` для данного `page_id`.  
Необходим, чтобы не оставалось «висячих» связей.


#### 8. `multicatmarket.market.edit.import.php` → хук `market.edit.update.import` 

Выполняется на этапе импорта данных из формы редактирования карточки товара.  
Если в `$_POST['rcat']` пришли выбранные категории — берёт первую из них, находит её код (`structure_code`) и записывает в стандартное поле `fieldmrkt_cat`.  
Это гарантирует, что основная категория всегда заполнена и все остальные функции продолжают работать.


#### 9. `multicatmarket.market.edit.tags.php` → хук `market.edit.tags`

Самый «видимый» хук. Генерирует набор чекбоксов со всеми категориями Market, учитывая права доступа пользователя (`cot_auth('market', $code, 'W')`).  
Создаёт два тега для шаблона:

- `{MARKET_FORM_MULTICAT}` — сами чекбоксы
- `{MARKET_FORM_MULTICAT_HINT}` — подсказка «Выберите категории (можно выбрать несколько)»


#### 10. `multicatmarket.market.edit.update.done.php` → хук `market.edit.update.done`

Выполняется после успешного обновления товара в БД.  
Если в POST пришли `rcat` — вызывает `multicatmarket_save_cats()` и сохраняет все выбранные связи.


#### 11. `multicatmarket.market.list.query.php` → хук `market.list.query`

**Самая важная часть плагина** — именно здесь реализуется отображение товара в нескольких категориях.  
Когда пользователь заходит в категорию с кодом `$c`, плагин:

1. Находит `structure_id` этой категории.
2. Подменяет условие фильтрации по категории:  
   вместо простого `p.fieldmrkt_cat = 'code'`  
   ставит  
   `(p.fieldmrkt_cat = 'code' OR EXISTS (SELECT 1 FROM cot_market_multicats …))`

Таким образом запрос возвращает как товары, у которых эта категория основная, так и товары, у которых она дополнительная.

## Итог

Плагин полностью решает задачу множественных категорий для модуля Market, сохраняя 100% совместимость с ядром и другими расширениями.  
Никаких изменений в ядро Cotonti и в модуль Market не вносится — всё реализовано через стандартные хуки и отдельную таблицу связей.

Если вам нужно, чтобы один и тот же товар отображался в нескольких рубриках — просто установите Multicat Market и добавьте два тега в шаблоны редактирования карточки товара.


**Версия:** 1.1.0  
**Дата:** 2025-12-05  
**Автор:** webitproff  
**Совместимость:** Cotonti Siena 0.9.26+, модуль Market v5+, PHP 8.1–8.4, MySQL 8.0+  
**Лицензия:** BSD  
**Репозиторий:** https://github.com/webitproff/cotonti-multicatmarket 

