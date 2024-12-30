						<div class="row">

							<div class="col">
								<div class="card bg-blue-700">
									<div class="card-body text-center">
										<h6 class="font-weight-semibold mb-0 w-100">Seller Accounts</h6>
										<h2 class="font-weight-bold mb-0 w-100" id="numberseller"><?php echo $reportdatas['numbers']['seller'];?></h2>
									</div>
								</div>
							</div>

							<div class="col">
								<div class="card bg-teal">
									<div class="card-body text-center">
										<h6 class="font-weight-semibold mb-0 w-100">Agent Accounts</h6>
										<h2 class="font-weight-bold mb-0 w-100" id="numberagent"><?php echo $reportdatas['numbers']['agent'];?></h2>
									</div>
								</div>
							</div>

							<div class="col">
								<div class="card bg-success-700">
									<div class="card-body text-center">
										<h6 class="font-weight-semibold mb-0 w-100">Approved Accounts</h6>
										<h2 class="font-weight-bold mb-0 w-100" id="numberapproveds"><?php echo $reportdatas['numbers']['approveds'];?></h2>
									</div>
								</div>
							</div>

							<div class="col">
								<div class="card bg-warning-600">
									<div class="card-body text-center">
										<h6 class="font-weight-semibold mb-0 w-100">Waiting Approval</h6>
										<h2 class="font-weight-bold mb-0 w-100" id="numberwaitings"><?php echo $reportdatas['numbers']['waitings'];?></h2>
									</div>
								</div>
							</div>

							<div class="col">
								<div class="card bg-danger-600">
									<div class="card-body text-center">
										<h6 class="font-weight-semibold mb-0 w-100">Denied Accounts</h6>
										<h2 class="font-weight-bold mb-0 w-100" id="numberdenieds"><?php echo $reportdatas['numbers']['denieds'];?></h2>
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
									<th>Seller Accounts</th>
									<th>Agent Accounts</th>
									<th>Approved Accounts</th>
									<th>Waiting Approval</th>
									<th>Denied Accounts</th>
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