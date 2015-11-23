<div class="row">
	<div class="col-md-12 search-row">
		<form id="filters-form" method="post" data-href="<?php echo site_url('collection/reload/' . $active); ?>">
		<div class="row">
		<div class="field-wrapper col-md-3 col-lg-3">
			<div class="row">
				<div class="col-md-2 col-lg-2">
					<p class="small">From</p>
				</div>
				<div class="col-md-9 col-lg-9">
					<select id="type" name="type">
						<?php foreach ($filter_postcards as $key => $postcard_type): ?>
							<option value="<?php echo $key; ?>"><?php echo $postcard_type; ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</div>
		</div>
			<div class="field-wrapper col-md-5 col-lg-5">
				<div class="row">
					<div class="col-md-2 col-lg-2">
						<p class="small">Filter by</p>
					</div>
					<div class="multiple-selects col-md-9 col-lg-9">
						<select id="filter" name="filter" data-href="<?php echo site_url('search/get_select'); ?>">
							<?php foreach ($filters as $key => $filter): ?>
								<option value="<?php echo $key; ?>"><?php echo $filter; ?></option>
							<?php endforeach; ?>
						</select>
						<select class="hidden" id="filter-type" name="filter-type">
						</select>
					</div>
				</div>
			</div>
		</div>
	</form>
	</div>
</div>
<div class="col-md-12 history-wrapper">
