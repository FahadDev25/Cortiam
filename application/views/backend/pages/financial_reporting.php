						<div class="row">

							<div class="col">
								<div class="card bg-blue-700">
									<div class="card-body text-center">
										<h6 class="font-weight-semibold mb-0 w-100">Membership Payments</h6>
										<h2 class="font-weight-bold mb-0 w-100" id="numbermembership">$<?php echo $reportdatas['numbers']['membership'];?></h2>
									</div>
								</div>
							</div>

							<div class="col">
								<div class="card bg-teal">
									<div class="card-body text-center">
										<h6 class="font-weight-semibold mb-0 w-100">Package Payments</h6>
										<h2 class="font-weight-bold mb-0 w-100" id="numberproduct">$<?php echo $reportdatas['numbers']['product'];?></h2>
									</div>
								</div>
							</div>

							<div class="col">
								<div class="card bg-success-700">
									<div class="card-body text-center">
										<h6 class="font-weight-semibold mb-0 w-100">Commission Payments</h6>
										<h2 class="font-weight-bold mb-0 w-100" id="numbercommission">$<?php echo $reportdatas['numbers']['commission'];?></h2>
									</div>
								</div>
							</div>

						</div>
			<!-- Highlighting rows and columns -->
				<div class="card" id="blockme">
					<div class="card-header header-elements-inline">
						<h5 class="card-title"><?php echo $header_data['page_title'];?></h5>
						<div class="header-elements" id="exportbuttons">
							<div class="list-icons">
								<div class="form-group mb-0" style="width:320px">

									<div class="input-group">
										<span class="input-group-prepend">
											<span class="input-group-text">Reporting Date <i class="icon-calendar2 ml-2"></i></span>
										</span>
										<input type="text" id="reportrange" class="form-control daterange-basic" value="">
                   <input type="hidden" name="start_date" id="start_date">
                   <input type="hidden" name="end_date" id="end_date">
									</div>
								</div>
            	</div>
          	</div>
					</div>
					<div class="card-body">
						<div class="chart-container">
							<div class="chart has-fixed-height" id="user_chart"></div>
						</div>
					</div>
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Report Data</h5>
					</div>
					<div class="card-body">
						<table class="table table-hover datatable-highlight" id="reporttable">
							<thead>
								<tr>
									<th>Date</th>
									<th>Membership Payments</th>
									<th>Package Payments</th>
									<th>Commission Payments</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
							<?php
//							foreach ($reportdatas['datatable'] as $reportdata) {
//								echo '<tr><td>'.$reportdata['date'].'</td><td>'.$reportdata['commercial'].'</td><td>'.$reportdata['residential'].'</td><td>'.$reportdata['actives'].'</td><td>'.$reportdata['pending'].'</td><td>'.$reportdata['declined'].'</td><td>'.$reportdata['contracted'].'</td><td>'.$reportdata['inactive'].'</td></tr>';
//							}
							?>
							</tbody>
						</table>
					</div>

				</div>

				<!-- /highlighting rows and columns -->