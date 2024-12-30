				<div class="row">
					<div class="col">
						<div class="card bg-blue-700">
							<div class="card-body text-center">
								<h6 class="font-weight-semibold mb-0 w-100">Commercial Properties</h6>
								<h2 class="font-weight-bold mb-0 w-100" id="numbercommercial"><?php echo $reportdatas['numbers']['commercial'];?></h2>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card bg-teal">
							<div class="card-body text-center">
								<h6 class="font-weight-semibold mb-0 w-100">Residential Properties</h6>
								<h2 class="font-weight-bold mb-0 w-100" id="numberresidential"><?php echo $reportdatas['numbers']['residential'];?></h2>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card bg-success-700">
							<div class="card-body text-center">
								<h6 class="font-weight-semibold mb-0 w-100">Activated</h6>
								<h2 class="font-weight-bold mb-0 w-100" id="numberactivated"><?php echo $reportdatas['numbers']['active'];?></h2>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card bg-warning-600">
							<div class="card-body text-center">
								<h6 class="font-weight-semibold mb-0 w-100">Pending</h6>
								<h2 class="font-weight-bold mb-0 w-100" id="numberpending"><?php echo $reportdatas['numbers']['pending'];?></h2>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card bg-danger-600">
							<div class="card-body text-center">
								<h6 class="font-weight-semibold mb-0 w-100">Declined</h6>
								<h2 class="font-weight-bold mb-0 w-100" id="numberdeclined"><?php echo $reportdatas['numbers']['declined'];?></h2>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card bg-indigo-600">
							<div class="card-body text-center">
								<h6 class="font-weight-semibold mb-0 w-100">Contracted</h6>
								<h2 class="font-weight-bold mb-0 w-100" id="numbercontracted"><?php echo $reportdatas['numbers']['contracted'];?></h2>
							</div>
						</div>
					</div>

					<div class="col">
						<div class="card bg-danger-600">
							<div class="card-body text-center">
								<h6 class="font-weight-semibold mb-0 w-100">Inactivated</h6>
								<h2 class="font-weight-bold mb-0 w-100" id="numberinactivated"><?php echo $reportdatas['numbers']['inactive'];?></h2>
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
							<div class="chart has-fixed-height" id="prop_chart"></div>
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
									<th>Commercial</th>
									<th>Residential</th>
									<th>Activated</th>
									<th>Pending</th>
									<th>Declined</th>
									<th>Contracted</th>
									<th>Inactivated</th>
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