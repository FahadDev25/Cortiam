jQuery(document).ready(function() {

	$( "#addmembership" ).validate();
	$( "#updatemembership" ).validate();

// jQuery('.maxlength-textarea').trumbowyg();


	$(".js-example-basic-multiple").select2({
	    tags: true,
    	tokenSeparators: [',', '  ']
	});

	ourdatatable = jQuery('#ourdatatable').DataTable({
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
	  url: cortiamajax.membershiptableajaxurl,
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
		{data: 'details', name: 'details'},
		{data: 'price', name: 'price'},
		{data: 'discount', name : 'discount'},
		{data: 'action', name: 'action', orderable: false, searchable: false}
	]
});

jQuery('body').on( "click", '#formSave', function() {


	
	jQuery('#addmembership').submit();
	
});



	jQuery('#addmembership').submit(function (e){

		e.preventDefault();
		
		if($('#title').val() == '')
		{
			return false;
		}
		
		if($('#detail').val() == '')
		{
			return false;
		}

		jQuery.ajax({
			type: "post",
			url: cortiamajax.membershipaddajaxurl,
  		    data: $(this).serialize(),
			dataType: "text",
			success: function(response){


				if(response=="success"){
					swal.fire({
						title: "Membership Plan",
						text: "Membership plan saved successfully",
						type: "success",
						confirmButtonClass: "btn btn-secondary"
					});
				}
		  	if(response == "fail"){
					swal.fire({
						title: "Membership Plan",
						text: "Membership plan cannot saved",
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
			
			  ourdatatable.draw();
				document.getElementById("addmembership").reset();				
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
					url: base_url+"ajax/backend/member-deleted/"+id,
					data: { id : id},
					dataType: "text",
					success: function(response){

						if(response=="success"){
							swal.fire({
								title: "Membership Plan",
								text: "Record deleted successfully",
								type: "success",
								confirmButtonClass: "btn btn-secondary"
							});
						}
					if(response == "fail"){
							swal.fire({
								title: "Membership Plan",
								text: "Record cannot deleted, due to error",
								type: "error",
								confirmButtonClass: "btn btn-secondary"
							});
					}
					
					ourdatatable.draw();
						
					}
				});	  
			}
		});

	});


	jQuery('body').on( "click", '.edit', function(ev) {

       $(".updateFeatures").attr("checked", false);
		let id = $(this).attr('data-edit');
		$('#updateid').val(id);
		let base_url =$('#base_url').val();
		jQuery.ajax({
			type: "post",
			url: base_url+"ajax/backend/member-plan-edit/"+id,
  		    data: { id : id},
			dataType: "json",
			success: function(response){

				if(response !== '')
				{	


					for (let index = 0; index < response.length; index++)
					{
						let selectedValue = response[index].feature_id;

						$(".updateFeatures").each(function() {

							console.log("inside..");

							if(selectedValue == $(this).val())
							{
								$(this).attr("checked", true) ;
							}

						});
				
					}


					 
				

					$('#id').val(response[0].plan_id);
					$('#editTitle').val(response[0].title);
					// $('#editDetail').trumbowyg('html', response[0].details);

					$('#editDetail').text(response[0].details);					
					

				}
			}
		});
	});



	jQuery('body').on( "click", '#formUpdate', function(ev) {

		jQuery('#updatemembership').submit();

	});


	jQuery('#updatemembership').submit(function (){


		if($('#editTitle').val() == '')
		{
			return false;
		}
		
		if($('#editDetail').val() == '')
		{
			return false;
		}
	
		jQuery.ajax({
			type: "post",
			url: cortiamajax.membershipupdateajaxurl,
  		    data: $(this).serialize(),
			dataType: "text",
			success: function(response){


				if(response=="success"){
					swal.fire({
						title: "Membership Plan",
						text: "Membership plan updated successfully",
						type: "success",
						confirmButtonClass: "btn btn-secondary"
					});
				}
		  	if(response == "fail"){
					swal.fire({
						title: "Membership Plan",
						text: "Membership plan cannot updated",
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
			
			  ourdatatable.draw();
				document.getElementById("addmembership").reset();				
				jQuery("#editmyModal").modal('hide');
			}
		});
	

		return false;
	});
	

});