				<form method="POST" class="ajaxform w-100">
				<!-- Highlighting rows and columns -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Default System Limits&Settings</h5>
						<div class="header-elements" id="exportbuttons">
							<div class="list-icons">
            		<a class="list-icons-item" data-action="collapse"></a>
            	</div>
          	</div>
					</div>

					<div class="card-body">
						<div class="row">
							<?php
							foreach ($settings as $setting) {
								echo '<div class="col-md-4"><div class="form-group"><label>'.$setting['setting_desc'].':</label><div><div class="input-group"><input type="number" class="form-control" name="setting['.$setting['setting_id'].']" id="setting-'.$setting['setting_id'].'" value="'.$setting['setting_value'].'"><span class="input-group-append"><span class="input-group-text">'.$setting['settings_prefix'].'</span></span></div></div></div></div>';
							}
							?>
						</div>
					</div>

				</div>
				<!-- /highlighting rows and columns -->
				<!-- Highlighting rows and columns -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">States and Winning Costs</h5>
						<div class="header-elements" id="exportbuttons">
							<div class="list-icons">
            		<a class="list-icons-item" data-action="collapse"></a>
            	</div>
          	</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-3">
							<?php
							$col_amount = ceil(count($state_costs)/4);
							$counter = 0;
							foreach ($state_costs as $state_cost) {
								if($counter == $col_amount){echo '</div><div class="col-md-3">';$counter = 0;}
								echo '<div class="form-group"><label>'.$state_cost['state'].':</label><div><div class="input-group"><input type="number" class="form-control" name="states['.$state_cost['state_id'].']" id="state-'.$state_cost['state_id'].'" value="'.$state_cost['cost'].'"><span class="input-group-append"><span class="input-group-text">USD</span></span></div></div></div>';
								$counter++;;
							}
							?>
							</div>
						</div>
					</div>
					<div class="card-footer bg-white text-right">
						<button type="submit" class="btn btn-primary">Save Settings <i class="icon-paperplane ml-2"></i></button>
					</div>
				</div>
				<!-- /highlighting rows and columns -->
				</form>
