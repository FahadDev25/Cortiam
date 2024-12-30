				<!-- Highlighting rows and columns -->
				<div class="card card-collapsed" id="tablefilters">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Search Filters</h5>
						<div class="header-elements" id="exportbuttons">
							<div class="list-icons">
            		<a class="list-icons-item" data-action="collapse"></a>
            	</div>
          	</div>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>Coupon Status</label>
									<select name="coupon_status" id="coupon_status">
										<option value="">Please select</option>
										<option value="Active" selected>Active</option>
										<option value="Inactive">Inactive</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>State</label>
									<select name="coupon_type" id="coupon_type">
										<option value="">Please select</option>
										<option value="Amount" data-prepend="-" data-append="USD">Cash Discount</option>
										<option value="Percentage" data-prepend="-" data-append="Percent">Percentage Discount</option>
										<option value="Win Limit" data-prepend="+" data-append="Extra Win">Extra Win Limit</option>
										<option value="Interest Limit" data-prepend="+" data-append="Extra Interest">Extra Interest Limit</option>
									</select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group mb-0">
									<label>Action Date</label>
									<div class="input-group">
										<span class="input-group-prepend">
											<span class="input-group-text"><i class="icon-calendar2"></i></span>
										</span>
										<input type="text" id="reportrange" class="form-control daterange-basic" value="">
                   <input type="hidden" name="start_date" id="start_date">
                   <input type="hidden" name="end_date" id="end_date">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-footer text-right">
						<button class="btn btn-secondary float-left" id="resetfilters">Reset Filters <i class="icon-reset ml-2"></i></button>
						<button type="submit" class="btn btn-primary" id="applyfilters">Apply Filters <i class="icon-paperplane ml-2"></i></button>
					</div>
				</div>

				<!-- Highlighting rows and columns -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title"><?php echo $header_data['page_title'];?></h5>
						<div class="header-elements" id="exportbuttons">
							<div class="list-icons">
            		<a class="list-icons-item" data-action="collapse"></a>
            		<a class="list-icons-item" data-action="reloadtable"></a>
            	</div>
          	</div>
					</div>

					<table class="table table-hover datatable-highlight" id="accountstable">
						<thead>
							<tr>
								<th>Coupon Code</th>
								<th>Description</th>
								<th>Discount Type</th>
								<th>Discount Amount</th>
								<th>Valid Between</th>
								<th>Status</th>
								<th>Added on</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<!-- /highlighting rows and columns -->