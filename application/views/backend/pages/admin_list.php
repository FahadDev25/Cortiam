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
								<th></th>
								<th>Full Name</th>
								<th>Phone Number</th>
								<th>Email</th>
								<th>Created On</th>
								<th class="text-center">Status</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<!-- /highlighting rows and columns -->