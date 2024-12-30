<style>
	.error{

		color:red;
	}

	</style>


<input type="hidden" id="base_url" name="base_url" value="<?=  base_url() ?>" />

	<!-- Highlighting rows and columns -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title"><?php echo $header_data['page_title'];?></h5>
						<div class="header-elements" id="exportbuttons">
							<div class="list-icons">
					<a  href="javascript:void(0);" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal">Add</a>

            		<a class="list-icons-item" data-action="collapse"></a>

            		<a class="list-icons-item reload" data-action="reloadtable"></a>
            	</div>
          	</div>
					</div>

					<table class="table table-hover datatable-highlight" id="ourdatatable">
						<thead>
							<tr>	
							    <th>#</th>
								<th>Title</th>
								<th>Details</th>
								<th>Total price</th>
								<th>Discount price</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<!-- /highlighting rows and columns -->


<!-- The Modal -->
<div class="modal modal-design" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Membership Plan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
	  <form id="addmembership">
		<div class="modal-body">
			<div class="form-group">
				<label for="title">Title:</label>
				<input type="text" class="form-control" placeholder="Enter title" id="title" name="title" required />
			</div>

			<div class="form-group">
				<label for="detail">Details:</label>
				<textarea name="detail" id="detail" class="form-control maxlength-textarea" rows="2" cols="1" placeholder="Enter your details & features..." required></textarea>
			</div>  		
						
			<h2>List of Features</h2>
			<div class="form-group">
				<div class="col-sm12">
					<div class="row">

					
				
			<?php
				if(isset($features) && $features !== '')
				{
		
					foreach ($features as $key => $feature)
					{
			?>			
						<div class="col-sm-4">
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" id="<?= $feature['id'] ?>"  name="features[]" value="<?= $feature['id'] ?>">
								<label class="form-check-label" for="<?= $feature['id'] ?>"><?= $feature['title'] ?></label>
							</div>
						</div>						

						<div class="col-sm-2">
								$ <?= $feature['price'] ?> 
						</div>
			<?php
					}
				}	
			?>
					</div>
				</div>
			</div>  		

			
		</div>
      <!-- Modal footer -->
		<div class="modal-footer">
			<button type="button" class="btn btn-success" id="formSave">Add</button>
			<a herf="javascript:void(0);" class="btn btn-danger" data-dismiss="modal" style="color:#fff;">close</a>
		</div>
	  </form>
    </div>
  </div>
</div>			



<!-- The Modal -->

<div class="modal" id="editmyModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update New Membership Plan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
	  <form id="updatemembership">
		<input type="hidden" id="updateid" name="id" value="" />
		<div class="modal-body">
			<div class="form-group">
				<label for="editTitle">Title:</label>
				<input type="text" class="form-control" placeholder="Enter title" id="editTitle" name="editTitle" required />
			</div>

			<div class="form-group">
				<label for="editDetail">Details:</label>
				<textarea name="editDetail" id="editDetail" class="form-control maxlength-textarea" rows="3" cols="1" placeholder="Enter your details & features..." required></textarea>
			</div>  

	
			<?php
				if(isset($features) && $features !== '')
				{
			?>
			
		     	<h2>List of Features</h2>
		         	<div class="col-sm12">
					<div class="row">
		   <?php
					foreach ($features as $key => $feature)
					{
			?>				
						<div class="col-sm-4">
							<div class="form-check form-check-inline">
								<input class="form-check-input updateFeatures" type="checkbox" id="<?= $feature['id'] ?>"  name="features[]" value="<?= $feature['id'] ?>">
								<label class="form-check-label" for="<?= $feature['id'] ?>"><?= $feature['title'] ?></label>
							</div>
						</div>

						<div class="col-sm-2">
								$ <?= $feature['price'] ?> 
						</div>
			<?php
					}
			?>	
					</div>
			</div>	
			<?php

				}	
			?>

				

      <!-- Modal footer -->
		<div class="modal-footer">
			<button type="button" class="btn btn-success" id="formUpdate">Update</button>
			<a herf="javascript:void(0);" class="btn btn-danger" data-dismiss="modal" style="color:#fff;">close</a>
		</div>
	  </form>
    </div>
  </div>
</div>
