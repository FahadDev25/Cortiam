				<form method="POST" class="ajaxform w-100">
				<!-- Highlighting rows and columns -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Signup Settings</h5>
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
							$col_amount = ceil(count($states)/4);
							$counter = 0;
							foreach ($states as $state) {
								if($counter == $col_amount){echo '</div><div class="col-md-6 col-xl-4">';$counter = 0;}
								echo '<div class="form-group border rounded p-1 alpha-grey text-center" id="stset-'.$state['state_id'].'"><label class="font-weight-semibold">'.strtoupper($state['state']).'</label><div class="row"><div class="col-md-12"><div class="form-group"><input name="enable['.$state['state_id'].']" data-id="'.$state['state_id'].'" id="enable-'.$state['state_id'].'" type="checkbox" data-on-color="success" data-off-color="default" data-on-text="Sign-up Enabled" data-off-text="Sign-up Disabled" class="form-check-input-switchery" '.(($state['signup'] == 'Enabled')? 'checked':'').'></div></div></div></div>';
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
