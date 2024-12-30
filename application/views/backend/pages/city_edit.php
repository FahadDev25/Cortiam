				<!-- Inner container -->
				<div class="d-md-flex align-items-md-start" id="changeforlowres">

					<!-- Right content -->
					<form method="POST" class="ajaxform w-100">

							<div class="card">
								<div class="card-header bg-transparent header-elements-inline">
									<h6 class="card-title">City Details</h6>
								</div>

								<div class="card-body">
									<div class="row">
										<div class="col-md-12">
											<fieldset>
												<div class="form-group">
													<label>City Name:</label>
													<input type="text" class="form-control" name="city_name" id="city_name" value="<?php echo $city['city_name'];?>">
												</div>
											</fieldset>
										</div>
									</div>
								</div>

								<div class="card-footer bg-white text-right">
									<input type="hidden" name="state_id" value="<?php echo $state['state_id'];?>">
									<input type="hidden" name="recordID" value="<?php echo $city['city_id'];?>">
									<button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
								</div>
							</div>

					<!-- /right content -->
					</form>
				</div>
				<!-- /inner container -->