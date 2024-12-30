				<form method="POST" class="ajaxform w-100">
				<!-- Highlighting rows and columns -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Free Payment Periods</h5>
						<div class="header-elements" id="exportbuttons">
							<div class="list-icons">
            		<a class="list-icons-item" data-action="collapse"></a>
            	</div>
          	</div>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-6 col-xl-4">
							<?php
							$col_amount = ceil(count($free_periods)/4);
							$counter = 0;
							foreach ($free_periods as $free_period) {
								if($counter == $col_amount){echo '</div><div class="col-md-6 col-xl-4">';$counter = 0;}
								echo '<div class="form-group border rounded p-2 alpha-grey" id="stset-'.$free_period['state_id'].'"><label>'.$free_period['state'].':</label><div class="row"><div class="col-md-6"><div class="form-group"><input name="enable['.$free_period['state_id'].']" data-id="'.$free_period['state_id'].'" id="enable-'.$free_period['state_id'].'" type="checkbox" data-on-color="success" data-off-color="default" data-on-text="Enabled" data-off-text="Disabled" class="form-check-input-switchery" '.(($free_period['free_period'] == 'Yes')? 'checked':'').'></div></div><div class="col-md-6"><div class="input-group"><input type="number" class="form-control" name="days['.$free_period['state_id'].']" id="state-'.$free_period['state_id'].'" value="'.$free_period['free_days'].'" '.(($free_period['free_period'] == 'Yes')? '':'readonly').'><span class="input-group-append"><span class="input-group-text">Days</span></span></div></div></div></div>';
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
