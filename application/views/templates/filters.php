<div class="col-md-9 search-row">	
	<div class="col-xs-12 col-sm-12 hidden-md hidden-lg btn-wrapper">
		<button class="button show-filters-btn">Show Filters</button>
		<button class="button hide-filters-btn hidden">Hide Filters</button>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12">
		<div class="row">
			<form class="hidden-xs hidden-sm" id="filters-form" method="post" data-href="<?php echo site_url('collection/reload/' . $active); ?>">
				<div class="row">
					<div class="field-wrapper col-md-8 col-lg-8">
						<div class="row">
							<div class="col-md-3 col-lg-2">
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
					<div class="field-wrapper col-md-4 col-lg-4">
						<div class="row">
							<div class="col-md-5 col-lg-4">
								<p class="small">Order by</p>
							</div>
							<div class="col-md-7 col-lg-8">
								<select id="order-by" name="order-by">
									<?php foreach ($order as $key => $order_type): ?>
										<option value="<?php echo $key; ?>"><?php echo $order_type; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<div class="col-md-12 postcards-wrapper">
