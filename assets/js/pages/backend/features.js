jQuery(document).ready(function() {
	jQuery( "#addPlanship" ).validate();
	jQuery( "#updatePlane" ).validate();

	// jQuery('.maxlength-textarea').trumbowyg();


	// $(".js-example-basic-multiple").select2({
	//     tags: true,
    // 	tokenSeparators: [',', '  ']
	// });
	$('.js-example-basic-multiple').select2();


	ourdatatable = jQuery('#ourdatatable').DataTable({
		"columnDefs": [ {
			"targets": 4,
			"data": "discount_value",
			"render": function ( data, type, row, meta ) {
		
			  return `${data}${row.discount_type == "1" ? '$' : "%"}`;
			}
		  } ],
	processing	: true,
	serverSide	: true,
	order 		: [[ 0, "desc" ]],
	paging  	: true,
	pageLength  : 25,
	lengthMenu  : [ 10, 25, 50, 75, 100 ],
	type        : 'POST',
  	language: {
        searchPlaceholder: "Search By Title"
    	},
	ajax: {
	  url: cortiamajax.featuretableajaxurl,
	  data: function (d) {
			// d.email = $('.searchEmail').val(),
			// d.search = $('input[type="search"]').val()
		}
	},
	columns: [
		{data: 'id', name: 'id',

			render: function (data, type, row, meta ) {
				return meta.row+1;
			},
	
		},
		{data: 'title', name: 'title'},
		{data: 'description', name: 'description'},
		{data: 'price', name: 'price'},
		{data: 'discount_value', name: 'discount_value'},
		{data: 'action', name: 'action', orderable: false, searchable: false}
	]
});


jQuery('body').on( "click", '#formSave', function(ev) {
	jQuery('#addPlanship').submit();
});



	jQuery('#addPlanship').submit(function (){


		if($('#title').val() == '')
		{
			return false;
		}
		
		if($('#detail').val() == '')
		{
			return false;
		}

		if($('#price').val() == '')
		{
			return false;
		}


			jQuery.ajax({
			type: "post",
			url: cortiamajax.addplanajaxurl,
  		    data: $(this).serialize(),
			dataType: "text",
			success: function(response){


				if(response=="success"){
					swal.fire({
						title: "Feature",
						text: "Feature saved successfully",
						type: "success",
						confirmButtonClass: "btn btn-secondary"
					});
				}
		  	if(response == "fail"){
					swal.fire({
						title: "Feature",
						text: "Feature cannot saved",
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
			
			  ourdatatable.draw();
				document.getElementById("addPlanship").reset();				
				jQuery("#myModal").modal('hide');

				$("#js-example-basic-multiple").val(null).empty().select2();
				$(".js-example-basic-multiple").select2({
					tags: true,
					tokenSeparators: [',', '  ']
				});
			

			}
		});
	

		return false;
	});


	
	jQuery('body').on( "click", '.delete', function(ev) {

		  let base_url =$('#base_url').val();
		  let id       = $(this).attr('data-delete');

		  Swal.fire({
			title: 'Do you want to Delete the record?',
			showDenyButton: true,
			showCancelButton: true,
			confirmButtonText: 'Ok',
			denyButtonText: 'cancel',
			confirmButtonClass: "btn btn-success",
			cancelButtonClass: "btn btn-danger"
		  }).then((result) => {
			
			if (result.value) 
			{
				jQuery.ajax({
					type: "post",
					url: base_url+"ajax/backend/feature-deleted/"+id,
					data: { id : id},
					dataType: "text",
					success: function(response){
		
						if(response=="success"){
							swal.fire({
								title: "Feature",
								text: "Record deleted successfully",
								type: "success",
								confirmButtonClass: "btn btn-secondary"
							});
						}
					if(response == "fail"){
							swal.fire({
								title: "Feature",
								text: "Record cannot deleted, due to error",
								type: "error",
								confirmButtonClass: "btn btn-secondary"
							});
						}
					
						ourdatatable.draw();
						
					}
				});	 
			} 

		  })

    

	});


	jQuery('body').on( "click", '.edit', function(ev) {

		let id 		 = $(this).attr('data-edit');
		let base_url = $('#base_url').val();

		jQuery.ajax({
			type: "post",
			url: base_url+"ajax/backend/feature-edit/"+id,
  		    data: { id : id},
			dataType: "json",
			success: function(response){
				
				let id 			   = response[0].id;
				let title   	   = response[0].title;
				let description	   = response[0].description;
				let price          = response[0].price;
				let discount_value = response[0].discount_value;
				let discount_type  = response[0].discount_type;
				let plans          = [];

				for (let index = 0; index < response.length; index++)
				{
					plans.push(response[index].plan_id);
					
				}


				// let plansArray = planIds.split(", ");

				$('#updateOptions').val(plans); // Select the option with a value of '1'
				$('#updateOptions').trigger('change'); // Notify any JS components that the value changed

				if(response !== '')
				{		 
					$('#id').val(id);
					$('#editTitle').val(title);
					$('#editDetail').val(description);
					$('#editPrice').val(price);
					$('#editDiscount').val(discount_value);

					$("#editType > option").each(function() {
						 
						if(discount_type == $(this).val())
						{
							$(this).attr("selected", true);
						}
					});
				}
			}
		});
	});


	jQuery('body').on( "click", '#formUpdate', function(ev) {

		jQuery('#updatePlane').submit();

	});


	jQuery('#updatePlane').submit(function (){


		if($('#editTitle').val() == '')
		{
			return false;
		}
		
		if($('#editDetail').val() == '')
		{
			return false;
		}

		if($('#editPrice').val() == '')
		{
			return false;
		}

	
		jQuery.ajax({
			type: "post",
			url: cortiamajax.planupdateajaxurl,
  		    data: $(this).serialize(),
			dataType: "text",
			success: function(response){


				if(response=="success"){
					swal.fire({
						title: "Feature",
						text: "Feature updated successfully",
						type: "success",
						confirmButtonClass: "btn btn-secondary"
					});
				}
		  	if(response == "fail"){
					swal.fire({
						title: "Feature",
						text: "Feature cannot updated",
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
			
			  	jQuery("#editmyModal").modal('hide');
				  ourdatatable.draw();
				document.getElementById("addmembership").reset();				
			}
		});
	

		return false;
	});	

	
	jQuery('body').on( "click", '.addtionalFeature', function(ev) {

		let featureId = $(this).attr('data-edit');
		$('#id').val(featureId);
	});

	jQuery('body').on( "click", '#additionalFeatureUpdate', function(ev) {

			let featureId  = $('#id').val();
			let display_name =  $('#display_name').val();
			let label   =  $('#label').val();
			let value =  $('#value').val();

			jQuery.ajax({
				type: "post",
				url: cortiamajax.addoption,
				data: {featureId :  featureId,  display_name : display_name, label : label,  value: value},
				dataType: "text",
				success: function(response){


					if(response){
						swal.fire({
							title: "Option",
							text: "Option added successfully",
							type: "success",
							confirmButtonClass: "btn btn-secondary"
						});
					}else{
						swal.fire({
							title: "Option",
							text: "Option cannot added",
							type: "error",
							confirmButtonClass: "btn btn-secondary"
						});
				 	 }
				
					  jQuery("#featuremyModal").modal('hide');
					  ourdatatable.draw();
					  document.getElementById("additionalFeature").reset();		
					}
				
				});	


	});



	
	jQuery('body').on( "click", '.expand', function(ev) {

        var tr = $(this).closest('tr');
        var row = ourdatatable.row(tr);
 
        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row 
			row.child(tableHead(row.data())).show();
                
			row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });



		

});


jQuery(document).on('click', '.deleteOption', function(){

	let row = $(this).closest("tr");
	Swal.fire({
		title: 'Do you want to delete record?',
		showDenyButton: true,
		showCancelButton: true,
		confirmButtonText: 'Delete',
		denyButtonText: 'Cancel',
		confirmButtonClass:"btn btn-success",
		cancelButtonClass:"btn btn-danger",
	  }).then((result) => {
		/* Read more about isConfirmed, isDenied below */
		if (result.value) {

			let optionId = $(this).attr('data-id');
			jQuery.ajax({
				type: "post",
				url: cortiamajax.deleteoptions,
				data: {optionId :  optionId},
				dataType: "text",
				success: function(response){

					if(response == "success")
					{
						console.log("Deleted...");
						row.remove();

					}
				 }	
				});

		} 
	  });
});


jQuery(document).on('click', '.editOption', function(){
	//feature-edit
	let id 		 = $(this).attr('data-id');
	let base_url = $('#base_url').val();

	jQuery.ajax({
		type: "post",
		url: base_url+"ajax/backend/option-edit/"+id,
		  data: { id : id},
		dataType: "json",
		success: function(response){
			
			let updateId     = response[0].id;
			let display_name = response[0].display_name;
			let label	     = response[0].name;
			let value        = response[0].value;
			
			if(response !== '')
			{		 
				$('#editlabel').val(label);
				$('#editvalue').val(value);
				$('#editdisplay_name').val(display_name);	
				$('#updateId').val(updateId);
			
			}
		}
	});
});


jQuery(document).on('click', '#updateOptionset', function(){

			let updateId    	 = $('#updateId').val();
			let editlabel 		 = $('#editlabel').val();
			let editvalue        = $('#editvalue').val();
			let editdisplay_name = $('#editdisplay_name').val();

		

			jQuery.ajax({
				type: "post",
				url: cortiamajax.updateoption,
				data: {updateId :  updateId,  editlabel : editlabel, editvalue : editvalue,  editdisplay_name: editdisplay_name},
				dataType: "text",
				success: function(response){

					if(response){
						swal.fire({
							title: "Update Option",
							text: "Option Updated successfully",
							type: "success",
							confirmButtonClass: "btn btn-secondary"
						});
					}else{
						swal.fire({
							title: "Update Option",
							text: "Option cannot Updated",
							type: "error",
							confirmButtonClass: "btn btn-secondary"
						});
				 	 }
				
					   jQuery(".modal").modal('hide');

					   jQuery(".row"+updateId).find("td:eq(0)").text(editdisplay_name);
					   jQuery(".row"+updateId).find("td:eq(1)").text(editvalue);
					   jQuery(".row"+updateId).find("td:eq(2)").text(editlabel);


					 //   ourdatatable.draw();
					 //   document.getElementById("additionalFeature").reset();		
				  }
				
				});	

});

function tableHead(d)
{
	var table = '<table id="expandedTable" cellpadding="5" cellspacing="0" border="0" style=" width:100%; padding-left:50px;">' +
	'<thead><tr><th>Display Name</th><th>Value</th><th>Label</th><th>Action</th></tr></thead>' +   
	'<tbody id="optionsTbl"></tbody>'+    
	'</table>';
	return table;
}


function format(d) {
    // `d` is the original data object for the row

 

		let featureId = d.id;

	$('#optionsTbl').empty();
	jQuery.ajax({
		type: "post",
		url: cortiamajax.getoptions,
		data: {featureId :  featureId},
		dataType: "json",
		success: function(response){
			console.log(response);
			

			for (let index = 0; index < response.length; index++)
			{
				
				let action = '<a href="javascript:void(0);" class="btn btn-primary btn-sm editOption" data-id="'+response[index].id+'" data-toggle="modal" data-target="#updateOption">Edit</a>'; 
				   action += ' <a href="javascript:void(0);" class="btn btn-danger btn-sm deleteOption" data-id="'+response[index].id+'">Delete</a>';
				$('#optionsTbl').prepend($('<tr class="row'+response[index].id+'"><td>'+response[index].display_name+'</td><td>'+response[index].value+'</td><td>'+response[index].name+'</td><td>'+action+'</td><tr>'));

			}
		 }

		});
}