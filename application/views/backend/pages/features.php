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
							    <th>Id</th>
								<th>Title</th>
								<th>Detail</th>
								<th>Price</th>
								<th>Discount (%/$)</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<!-- /highlighting rows and columns -->


<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Feature</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
	  <form id="addPlanship">
		<div class="modal-body">
			<div class="form-group">
				<label for="title">Title:</label>
				<input type="text" class="form-control"  id="title" name="title" required />
			</div>

			<div class="form-group">
				<label for="detail">Details:</label>
				<textarea name="detail" id="detail" class="form-control maxlength-textarea" rows="2" cols="1" required></textarea>
			</div>  			

			<div class="form-group" style="display: none ;">
				<label for="detail">Add Plan / Plans:</label>
				<select class="js-example-basic-multiple" name="plans[]" multiple="multiple">

				<?php
					if(isset($plans) && $plans !== '')
					{
						foreach($plans as $key => $val)
						{
					?>	
							<option value="<?= $val['id'] ?>"><?=  $val['title']?></option>
					<?php
							
						}
					}				
				?>
				 
				</select>
			</div>	 
			
			<div class="form-group">
				<label for="detail">Price:</label>
				<input type="number" step="0.01" class="form-control" id="price" name="price" value="" required/>
			</div>  	
			
			<div class="form-group">
				<label for="discount">Discount:</label>
				<input type="number" step="1" class="form-control" id="discount" name="discount" value=""/>
			</div> 


			<div class="form-group">
				<label for="discount">Discount Type:</label>
				<select class="form-control" id="type" name="type">
						<option value="1">$</option>
						<option value="2">%</option>
				</select>
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
	  <form id="updatePlane">
		<input type="hidden" id="id" name="id" value="" />
		<div class="modal-body">
			<div class="form-group">
				<label for="editTitle">Title:</label>
				<input type="text" class="form-control" placeholder="Enter title" id="editTitle" name="editTitle" required />
			</div>

			<div class="form-group">
				<label for="editDetail">Details:</label>
				<textarea name="editDetail" id="editDetail" class="form-control maxlength-textarea" rows="3" cols="1" placeholder="Enter your details & features..." required></textarea>
			</div>  


			<div class="form-group" style="display: none ;">
				<label for="updateOptions">Update Plan / Plans:</label>
				<select class="js-example-basic-multiple" id="updateOptions" name="updateOptions[]" multiple="multiple">		
				
				<?php
					if(isset($plans) && $plans !== '')
					{
						foreach($plans as $key => $val)
						{
					?>	
							<option value="<?= $val['id'] ?>"><?=  $val['title']?></option>
					<?php
							
						}
					}				
				?>
				</select>
			</div>	

			<div class="form-group">
				<label for="updatePrice">Price:</label>
				<input type="number" step="0.01" class="form-control" id="editPrice" name="editPrice" value="" required/>
			</div>  			
			
			<div class="form-group">
				<label for="discount">Discount:</label>
				<input type="number" step="1" class="form-control" id="editDiscount" name="editDiscount" value="" />
			</div> 


			<div class="form-group">
				<label for="discount">Discount Type:</label>
				<select class="form-control" id="editType" name="editType">
						<option value="1">$</option>
						<option value="2">%</option>
				</select>
			</div> 
		

		</div>
      <!-- Modal footer -->
		<div class="modal-footer">
			<button type="button" class="btn btn-success" id="formUpdate">Update</button>
			<a herf="javascript:void(0);" class="btn btn-danger" data-dismiss="modal" style="color:#fff;">close</a>
		</div>
	  </form>
    </div>
  </div>
</div>




<!-- The Modal -->
<div class="modal" id="featuremyModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Option</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
	  <form id="additionalFeature">
		<input type="hidden" id="id" name="id" value="" />
		<div class="modal-body">		
		<div class="form-group">

				<label for="label">Label:</label>
				<input type="text" class="form-control" placeholder="Enter label name" id="label" name="label" required />

				<label for="value">Value:</label>
				<input type="text" class="form-control" placeholder="Enter Value" id="value" name="value" required />

				<label for="label">Display Name:</label>
				<input type="text" class="form-control" placeholder="Enter Value" id="display_name" name="display_name" required />

			</div>
		</div>
      <!-- Modal footer -->
		<div class="modal-footer">
			<a herf="javascript:void(0);" class="btn btn-success" id="additionalFeatureUpdate" style="color:#fff;">Add</a>
			<a herf="javascript:void(0);" class="btn btn-danger" data-dismiss="modal" style="color:#fff;">close</a>
		</div>
	  </form>
    </div>
  </div>
</div>





<!-- The Modal -->
<div class="modal" id="updateOption">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Update Option</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
	  <form id="additionalFeature">
		<input type="hidden" id="updateId" name="updateId" value="" />
		<div class="modal-body">		
		<div class="form-group">

				<label for="editlabel">Label:</label>
				<input type="text" class="form-control" placeholder="Enter label name" id="editlabel" name="editlabel" required />

				<label for="editvalue">Value:</label>
				<input type="text" class="form-control" placeholder="Enter Value" id="editvalue" name="editvalue" required />

				<label for="editdisplay_name">Display Name:</label>
				<input type="text" class="form-control" placeholder="Enter Value" id="editdisplay_name" name="editdisplay_name" required />

			</div>
		</div>
      <!-- Modal footer -->
		<div class="modal-footer">
			<a herf="javascript:void(0);" class="btn btn-success" id="updateOptionset" style="color:#fff;">Update</a>
			<a herf="javascript:void(0);" class="btn btn-danger" data-dismiss="modal" style="color:#fff;">close</a>
		</div>
	  </form>
    </div>
  </div>
</div>