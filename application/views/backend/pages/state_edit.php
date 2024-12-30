				<!-- Inner container -->
				<div class="d-md-flex align-items-md-start" id="changeforlowres">

					<!-- Right content -->
					<form method="POST" class="ajaxform w-100">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">State Details</h6>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-md-6">
											<fieldset>
												<div class="form-group">
													<label>State Name:</label>
													<input type="text" class="form-control" name="state_name" id="state_name" value="<?php echo $state['state'];?>">
												</div>
											</fieldset>
										</div>
										<div class="col-md-6">
											<fieldset>
												<div class="form-group">
													<label>Winning Cost:</label>
													<div class="input-group"><input type="number" class="form-control" name="state_cost" value="<?php echo $state['cost'];?>"><span class="input-group-append"><span class="input-group-text">USD</span></span></div>
												</div>
											</fieldset>
										</div>
									</div>
								</div>

								<div class="card-footer bg-white text-right">
									<input type="hidden" name="recordID" value="<?php echo $state['state_id'];?>">
									<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>
							</div>

					<!-- /right content -->
					</form>
				</div>
				<!-- /inner container -->