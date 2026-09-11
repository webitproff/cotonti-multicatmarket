<!--
	/**
	* Admin panel for Multicat Market – Список связей, Добавление, Редактирование,
	* Очистка, Статистика, Массовые операции
	*
	* Filename: plugins/multicatmarket/tpl/multicatmarket.admin.tpl
	*
	* Multicat plugin for Market Module, CMF Cotonti v1.0.0+, PHP 8.4+, MySQL 8.0+
	*
	* Date=Sep 11, 2026
	* @package multicatmarket
	* @version 1.3.5
	* @author webitproff
	* @copyright Copyright (c) webitproff 2026 | https://github.com/webitproff
	* @license BSD
	*/
-->
<!-- BEGIN: MAIN -->
<div class="container-fluid py-4">
    <h2>{PHP.L.multicatmarket_admin_title}</h2>
    {FILE "{PHP.cfg.themes_dir}/{PHP.cfg.defaulttheme}/warnings.tpl"}
	
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {TAB_LIST_ACTIVE}" href="{URL_LIST}">{PHP.L.multicatmarket_tab_list}</a>
		</li>
        <li class="nav-item">
            <a class="nav-link {TAB_ADD_ACTIVE}" href="{URL_ADD}">{PHP.L.multicatmarket_tab_add}</a>
		</li>
        <li class="nav-item">
            <a class="nav-link {TAB_CLEAN_ACTIVE}" href="{URL_CLEAN}">{PHP.L.multicatmarket_tab_clean}</a>
		</li>
        <li class="nav-item">
            <a class="nav-link {TAB_STATS_ACTIVE}" href="{URL_STATS}">{PHP.L.multicatmarket_tab_stats}</a>
		</li>
        <li class="nav-item">
            <a class="nav-link {TAB_MASS_ACTIVE}" href="{URL_MASS}">{PHP.L.multicatmarket_tab_mass}</a>
		</li>
	</ul>
	
    <!-- ================= ВКЛАДКА: СПИСОК ================= -->
    <!-- IF {PHP.tab} == 'list' -->
	<div class="card filter-section p-3 mb-4" style="border:5px var(--bs-dark-border-subtle) solid">
		<form method="get" action="{LIST_FORM_ACTION}">
			<input type="hidden" name="m" value="other"/>
			<input type="hidden" name="p" value="multicatmarket"/>
			<input type="hidden" name="tab" value="list"/>
			<div class="row g-2 align-items-end">
				<div class="col-12 col-lg-4">
					<label class="form-label">{PHP.L.multicatmarket_col_category}</label>
					{LIST_FILTER_CAT_SELECT}
				</div>
				<div class="col-12 col-lg-4">
					<label class="form-label">{PHP.L.multicatmarket_col_title}</label>
					{LIST_FILTER_TITLE}
				</div>
				<div class="col-12 col-lg-2">
					<button type="submit" class="btn btn-outline-primary w-100">
						<i class="fa-solid fa-filter me-1"></i>{PHP.L.multicatmarket_filter_btn}
					</button>
				</div>
				<div class="col-12 col-lg-2">
					<a class="btn btn-outline-danger w-100" href="{LIST_RESET_URL}">
						<i class="fa-solid fa-broom me-1"></i>{PHP.L.multicatmarket_reset}
					</a>
				</div>
			</div>
			<div class="row mt-2">
				<div class="col-12">
					<label class="form-label d-block">{PHP.L.multicatmarket_filter_link_label}</label>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="lf" value="all" id="lf-all" {LIST_FILTER_LINK_ALL_CHECKED}>
						<label class="form-check-label" for="lf-all">{PHP.L.multicatmarket_filter_link_all}</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="lf" value="with" id="lf-with" {LIST_FILTER_LINK_WITH_CHECKED}>
						<label class="form-check-label" for="lf-with">{PHP.L.multicatmarket_filter_link_with}</label>
					</div>
					<div class="form-check form-check-inline">
						<input class="form-check-input" type="radio" name="lf" value="without" id="lf-without" {LIST_FILTER_LINK_WITHOUT_CHECKED}>
						<label class="form-check-label" for="lf-without">{PHP.L.multicatmarket_filter_link_without}</label>
					</div>
				</div>
			</div>
		</form>
	</div>
	
	<form method="post" action="{LIST_MASSDELETE_URL}">
		<input type="hidden" name="back" value="{LIST_BACK_B64}"/>
		<div class="table-responsive">
			<table class="table table-bordered table-striped align-middle">
				<thead>
					<tr>
						<th style="width:32px;"><input type="checkbox" id="mc-check-all"/></th>
						<th>{PHP.L.multicatmarket_col_id}</th>
						<th>{PHP.L.multicatmarket_col_title}</th>
						<th>{PHP.L.multicatmarket_col_main_cat}</th>
						<th>{PHP.L.multicatmarket_col_links}</th>
						<th>{PHP.L.multicatmarket_col_actions}</th>
					</tr>
				</thead>
				<tbody>
					<!-- BEGIN: LIST_ROW -->
					<tr>
						<td><input class="row-check" type="checkbox" name="ids[]" value="{ROW_CHECKBOX}"/></td>
						<td><a href="{ROW_ITEM_URL}" target="_blank" rel="noopener">#{ROW_PAGE_ID}</a></td>
						<td>{ROW_TITLE}</td>
						<td>{ROW_MAIN_CAT}</td>
						<td>{ROW_LINKS}</td>
						<td class="text-nowrap">
							<a href="{ROW_EDIT_URL}" class="btn btn-sm btn-outline-info" title="{PHP.L.multicatmarket_btn_edit_product}">
								<i class="fa-solid fa-pen"></i>
							</a>
							<a href="{ROW_DELETE_URL}" class="btn btn-sm btn-outline-danger" title="{PHP.L.multicatmarket_btn_unlink_short}" onclick="return confirm('{PHP.L.multicatmarket_confirm_unlink_all}');">
								<i class="fa-solid fa-trash"></i>
							</a>
						</td>
					</tr>
					<!-- END: LIST_ROW -->
					<!-- BEGIN: LIST_EMPTY -->
					<tr><td colspan="6" class="text-center text-muted">{PHP.L.multicatmarket_no_records}</td></tr>
					<!-- END: LIST_EMPTY -->
				</tbody>
			</table>
		</div>
		
		<!-- IF {PAGINATION} -->
		<nav class="mt-3">
			<div class="text-center mb-2">{PHP.L.Total}: {TOTAL_ENTRIES}, {PHP.L.Onpage}: {ENTRIES_ON_CURRENT_PAGE}</div>
			<ul class="pagination justify-content-center">{PREVIOUS_PAGE} {PAGINATION} {NEXT_PAGE}</ul>
		</nav>
		<!-- ENDIF -->
		
		<button type="submit" class="btn btn-danger"
		onclick="return confirm('{PHP.L.multicatmarket_confirm_massunlink}');">
			<i class="fa-solid fa-trash me-1"></i>{PHP.L.multicatmarket_btn_unlink_selected}
		</button>
	</form>
	
	<script>
        (function () {
            var all = document.getElementById('mc-check-all');
            if (!all) return;
            all.addEventListener('change', function () {
                var boxes = document.querySelectorAll('.row-check');
                for (var i = 0; i < boxes.length; i++) {
                    boxes[i].checked = all.checked;
				}
			});
		})();
	</script>
    <!-- ENDIF -->
	
    <!-- ================= ВКЛАДКА: РЕДАКТИРОВАНИЕ СВЯЗИ ================= -->
    <!-- IF {PHP.tab} == 'edit' -->
	<div class="alert alert-danger">
		<h4>{PHP.L.Warning}</h4>
		<ul>
			<li>{PHP.L.multicatmarket_warning_tab_under_develop}</li>
		</ul>
	</div>
    <div class="card p-4 mb-4 mx-auto" style="max-width:640px;">
        <h4 class="mb-3">{PHP.L.multicatmarket_edit_title}</h4>
        <form method="post" action="{EDIT_FORM_URL}">
            <input type="hidden" name="old_pid" value="{EDIT_PAGE_ID}"/>
            <input type="hidden" name="old_cid" value="{EDIT_OLD_CID}"/>
            <div class="mb-3">
                <label class="form-label">{PHP.L.multicatmarket_edit_label_page}</label>
                <div class="form-control-plaintext">
                    <strong>{EDIT_PAGE_TITLE}</strong>
                    <small class="text-muted"> (ID {EDIT_PAGE_ID})</small>
				</div>
			</div>
            <div class="mb-3">
                <label class="form-label">{PHP.L.multicatmarket_edit_label_new_cat}</label>
                {EDIT_CAT_SELECT}
			</div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk me-1"></i>{PHP.L.multicatmarket_btn_save}
				</button>
                <a class="btn btn-outline-secondary" href="{EDIT_BACK_URL}">
                    <i class="fa-solid fa-arrow-left me-1"></i>{PHP.L.multicatmarket_back_to_list}
				</a>
			</div>
		</form>
	</div>
    <!-- ENDIF -->
	
    <!-- ================= ВКЛАДКА: ДОБАВЛЕНИЕ ================= -->
    <!-- IF {PHP.tab} == 'add' -->
	<div class="alert alert-danger">
		<h4>{PHP.L.Warning}</h4>
		<ul>
			<li>{PHP.L.multicatmarket_warning_tab_under_develop}</li>
		</ul>
	</div>
    <div class="card p-4 mb-4 mx-auto" style="max-width:640px;">
        <h4 class="mb-3">{PHP.L.multicatmarket_add_title}</h4>
        <form method="post" action="{ADD_FORM_URL}">
            <div class="mb-3">
                <label class="form-label">{PHP.L.multicatmarket_add_label_page}</label>
                {ADD_PAGE_ID}
                <div class="form-text">{PHP.L.multicatmarket_add_page_hint}</div>
			</div>
            <div class="mb-3">
                <label class="form-label">{PHP.L.multicatmarket_add_label_cat}</label>
                {ADD_CAT_SELECT}
			</div>
            <button type="submit" class="btn btn-success">
                <i class="fa-solid fa-plus me-1"></i>{PHP.L.multicatmarket_btn_add}
			</button>
		</form>
	</div>
    <!-- ENDIF -->
	
    <!-- ================= ВКЛАДКА: ОЧИСТКА ================= -->
    <!-- IF {PHP.tab} == 'clean' -->
	<div class="alert alert-danger">
		<h4>{PHP.L.Warning}</h4>
		<ul>
			<li>{PHP.L.multicatmarket_warning_tab_under_develop}</li>
		</ul>
	</div>
    <div class="card p-4 mb-4">
        <h4 class="mb-3">{PHP.L.multicatmarket_clean_header}</h4>
        <p class="text-muted">{PHP.L.multicatmarket_clean_desc}</p>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{CLEAN_ZERO}</h5>
                        <p class="card-text">{PHP.L.multicatmarket_clean_zero_cat}</p>
					</div>
				</div>
			</div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{CLEAN_ORPHAN_ITEMS}</h5>
                        <p class="card-text">{PHP.L.multicatmarket_clean_orphan_items}</p>
					</div>
				</div>
			</div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{CLEAN_ORPHAN_CATS}</h5>
                        <p class="card-text">{PHP.L.multicatmarket_clean_orphan_cats}</p>
					</div>
				</div>
			</div>
            <div class="col-md-3">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{CLEAN_TOTAL}</h5>
                        <p class="card-text">{PHP.L.multicatmarket_clean_total}</p>
					</div>
				</div>
			</div>
		</div>
		
        <!-- IF {CLEAN_ALL_CLEAN} -->
        <div class="alert alert-success mb-0">{PHP.L.multicatmarket_clean_all_clean}</div>
        <!-- ELSE -->
        <form method="post" action="{CLEAN_FORM_URL}">
            <button type="submit" class="btn btn-danger"
			onclick="return confirm('{PHP.L.multicatmarket_confirm_clean}');">
                <i class="fa-solid fa-broom me-1"></i>{PHP.L.multicatmarket_btn_clean_all}
			</button>
		</form>
        <!-- ENDIF -->
	</div>
    <!-- ENDIF -->
	
    <!-- ================= ВКЛАДКА: СТАТИСТИКА ================= -->
    <!-- IF {PHP.tab} == 'stats' -->
	<div class="alert alert-danger">
		<h4>{PHP.L.Warning}</h4>
		<ul>
			<li>{PHP.L.multicatmarket_warning_tab_under_develop}</li>
		</ul>
	</div>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">{STATS_TOTAL_LINKS}</h5>
                    <p class="card-text">{PHP.L.multicatmarket_stats_total_links}</p>
				</div>
			</div>
		</div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">{STATS_TOTAL_ITEMS}</h5>
                    <p class="card-text">{PHP.L.multicatmarket_stats_unique_items}</p>
				</div>
			</div>
		</div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">{STATS_TOTAL_CATS}</h5>
                    <p class="card-text">{PHP.L.multicatmarket_stats_total_cats}</p>
				</div>
			</div>
		</div>
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">{STATS_AVG_PER_ITEM}</h5>
                    <p class="card-text">{PHP.L.multicatmarket_stats_avg}</p>
				</div>
			</div>
		</div>
	</div>
	
    <h4>{PHP.L.multicatmarket_stats_top_cats}</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th style="width:60px;">#</th>
                    <th>{PHP.L.multicatmarket_stats_col_category}</th>
                    <th>{PHP.L.multicatmarket_col_code}</th>
                    <th style="width:140px;">{PHP.L.multicatmarket_stats_col_count}</th>
				</tr>
			</thead>
            <tbody>
                <!-- BEGIN: STATS_ROW -->
                <tr>
                    <td>{TOP_RANK}</td>
                    <td>{TOP_CAT_TITLE}</td>
                    <td><code>{TOP_CAT_CODE}</code></td>
                    <td>{TOP_CAT_COUNT}</td>
				</tr>
                <!-- END: STATS_ROW -->
                <!-- BEGIN: STATS_EMPTY -->
                <tr><td colspan="4" class="text-center text-muted">{PHP.L.multicatmarket_no_records}</td></tr>
                <!-- END: STATS_EMPTY -->
			</tbody>
		</table>
	</div>
    <!-- ENDIF -->
	
    <!-- ================= ВКЛАДКА: МАССОВЫЕ ОПЕРАЦИИ ================= -->
    <!-- IF {PHP.tab} == 'mass' -->
	<div class="alert alert-danger">
		<h4>{PHP.L.Warning}</h4>
		<ul>
			<li>{PHP.L.multicatmarket_warning_tab_under_develop}</li>
		</ul>
	</div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card p-4 mb-4">
                <h4 class="mb-3">{PHP.L.multicatmarket_mass_bind_title}</h4>
                <p class="text-muted">{PHP.L.multicatmarket_mass_bind_desc}</p>
                <form method="post" action="{MASS_BIND_FORM_URL}">
                    <div class="mb-3">
                        <label class="form-label">{PHP.L.multicatmarket_mass_label_ids}</label>
                        <input type="text" name="page_ids" class="form-control" placeholder="1,2,3"/>
                        <div class="form-text">{PHP.L.multicatmarket_mass_ids_hint}</div>
					</div>
                    <div class="mb-3">
                        <label class="form-label">{PHP.L.multicatmarket_mass_label_bind_cat}</label>
                        {MASS_BIND_CAT_SELECT}
					</div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-link me-1"></i>{PHP.L.multicatmarket_btn_bind}
					</button>
				</form>
			</div>
		</div>
        <div class="col-lg-6">
            <div class="card p-4 mb-4">
                <h4 class="mb-3">{PHP.L.multicatmarket_mass_unbind_title}</h4>
                <p class="text-muted">{PHP.L.multicatmarket_mass_unbind_desc}</p>
                <form method="post" action="{MASS_UNBIND_FORM_URL}">
                    <div class="mb-3">
                        <label class="form-label">{PHP.L.multicatmarket_mass_label_ids_unbind}</label>
                        <input type="text" name="page_ids" class="form-control" placeholder="1,2,3"/>
                        <div class="form-text">{PHP.L.multicatmarket_mass_ids_hint}</div>
					</div>
                    <div class="mb-3">
                        <label class="form-label">{PHP.L.multicatmarket_mass_label_unbind_cat}</label>
                        {MASS_UNBIND_CAT_SELECT}
					</div>
                    <button type="submit" class="btn btn-warning">
                        <i class="fa-solid fa-link-slash me-1"></i>{PHP.L.multicatmarket_btn_unbind}
					</button>
				</form>
			</div>
		</div>
	</div>
    <!-- ENDIF -->
</div>
<!-- END: MAIN -->