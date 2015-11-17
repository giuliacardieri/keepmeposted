<div class="row">
	<h2>Results for "<?php echo $search_term; ?>" </h2>
</div>
</div>
<div class="main col-md-10 col-lg-10 col-md-offset-2 col-ld-offset-2 results-nav-wrapper">
	<div class="row">
	    <ul class="col-md-12 results-nav nav nav-tabs">
	        <li class="col-md-3" role="presentation"><a href="" data-href="<?php echo site_url('search/load_results/people/' . $search_term); ?>">People</a></li>
	        <li class="col-md-3" role="presentation"><a class="active" href="" data-href="<?php echo site_url('search/load_results/postcards/' . $search_term); ?>">Postcards</a></li>
	        <li class="col-md-3" role="presentation"><a href="" data-href="<?php echo site_url('search/load_results/tags/' . $search_term); ?>">Tags</a></li>
	        <li class="col-md-3" role="presentation"><a href="" data-href="<?php echo site_url('search/load_results/yours/' . $search_term); ?>">Your Postcards</a></li>
	    </ul>
	</div>
</div>

<div class="main col-md-10 col-lg-10 col-md-offset-2 col-ld-offset-2 results-wrapper">
<div class="row search-row">
	<form id="filters-form" method="post" data-href="<?php echo site_url('search/load_results'); ?>">
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
	<div class="field-wrapper col-md-3 col-lg-3">
		<div class="row">
			<div class="col-md-4 col-lg-4">
				<p class="small">Order by</p>
			</div>
			<div class="col-md-8 col-lg-8">
				<select id="order-by" name="order-by">
					<?php foreach ($order as $key => $order_type): ?>
						<option value="<?php echo $key; ?>"><?php echo $order_type; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
	</div>
</form>
</div>
<div class="results-inner-wrapper">
