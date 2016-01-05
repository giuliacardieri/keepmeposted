<div class="row">
	<div class="col-md-12 stats-wrapper">
		<?php if ($collection_count > 0): ?>
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-3 stats-square">
							<div class="square-wrapper">
								<h2><?php echo $collection_count; ?></h2>
								<p>Postcards</p>
							</div>			
						</div>			
						<div class="col-md-3 stats-square">
							<div class="square-wrapper color-2">
								<h2><span class="stats-icon glyphicon glyphicon-globe"></span><?php echo $country_count; ?></h2>
								<p>Countries</p>
							</div>
						</div>	
						<div class="col-md-3 stats-square">
							<div class="square-wrapper color-3">
								<h2><span class="stats-icon glyphicon glyphicon-star"></span><?php echo $favorites_count; ?></h2>
								<p>Favorites</p>
							</div>
						</div>	
						<div class="col-md-3 stats-square">
							<div class="square-wrapper color-4">
								<h2><?php echo $swap_count; ?></h2>
								<p>Postcards for swap</p>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3 stats-square">
							<div class="square-wrapper">
								<h2 class="smaller"><span class="stats-icon glyphicon glyphicon-list"></span><?php echo $popular_category[0]['name']; ?></h2>
								<p>Most popular category</p>
							</div>
						</div>
						<div class="col-md-3 stats-square">
							<div class="square-wrapper color-2">
								<h2 class="smaller"><span class="stats-icon glyphicon glyphicon-map-marker"></span><?php echo $popular_country['name']; ?></h2>
								<p>Most popular country</p>
							</div>
						</div> 
						<div class="col-md-3 stats-square">
							<div class="square-wrapper color-3">
								<h2 class="smaller"><span class="stats-icon glyphicon glyphicon-info-sign"></span><?php echo $popular_type; ?></h2>
								<p>Most popular type</p>
							</div>
						</div>
						<div class="col-md-3 stats-square">
							<div class="square-wrapper color-4">
								<h2 class="smaller"><span class="stats-icon glyphicon glyphicon-pushpin"></span><?php echo $popular_state; ?></h2>
								<p>Most popular state</p>
							</div>
						</div>
					</div>
				</div>
			</div>				
			<div class="col-md-12 graphs-wrapper">
				<div class="row">
					<div class="col-md-6 charts-wrapper countries-chart-wrapper" data-href="<?php echo site_url('stats/get_countries/'.$id); ?>">
						<div class="chart">
							<canvas id="countriesChart"></canvas>
							<h2>Countries Received</h2>
						</div>
					</div>
					<div class="col-md-6 charts-wrapper categories-chart-wrapper" data-href="<?php echo site_url('stats/get_categories/'.$id); ?>">
						<div class="chart">
							<canvas id="categoriesChart"></canvas>
							<h2>Categories Received</h2>
						</div>
					</div>
				</div>
			</div>
		<?php else: ?>
			<h2>No postcards on the collection for the statistics D:</h2>
		<?php endif; ?>
	</div>
</div>