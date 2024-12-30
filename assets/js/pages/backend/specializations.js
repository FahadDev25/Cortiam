jQuery(document).ready(function() {
    // jQuery( "#addspecialization" ).validate();
    // jQuery( "#updatespecialization" ).validate();

    // jQuery('.maxlength-textarea').trumbowyg();


    // $(".js-example-basic-multiple").select2({
    //     tags: true,
    // 	tokenSeparators: [',', '  ']
    // });
    $('.specialization-selection').select2();


    specializationdatatable = jQuery('#specializationdatatable').DataTable({
        processing	: true,
        serverSide	: true,
        order 		: [[ 0, "desc" ]],
        paging  	: true,
        pageLength  : 10,
        lengthMenu  : [ 5, 10, 15, 20, 25 ],
        type        : 'POST',
        language: {
            searchPlaceholder: "Search By Name"
        },
        ajax: {
            url: cortiamajax.specializationtableajaxurl,
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
            {data: 'name', name: 'name'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });


    // jQuery('body').on( "click", '#formspecialization', function(ev) {
    //     jQuery('#addspecialization').submit();
    // });



    jQuery('#addspecialization').submit(function (){

        jQuery.ajax({
            type: "post",
            url: cortiamajax.addspecializationajaxurl,
            data: $(this).serialize(),
            dataType: "text",
            success: function(response){


                if(response=="success"){
                    swal.fire({
                        title: "Specialization",
                        text: "Specialization saved successfully",
                        type: "success",
                        confirmButtonClass: "btn btn-secondary"
                    });
                }
                if(response == "fail"){
                    swal.fire({
                        title: "Specialization",
                        text: "Specialization cannot saved",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary"
                    });
                }

                specializationdatatable.draw();
                document.getElementById("addspecialization").reset();
                jQuery("#addSpecializationModal").modal('hide');


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
                    url: base_url+"ajax/backend/specialization-deleted/"+id,
                    data: { id : id},
                    dataType: "text",
                    success: function(response){

                        if(response=="success"){
                            swal.fire({
                                title: "Specialization",
                                text: "Record deleted successfully",
                                type: "success",
                                confirmButtonClass: "btn btn-secondary"
                            });
                        }
                        if(response == "fail"){
                            swal.fire({
                                title: "Specialization",
                                text: "Record cannot deleted, due to error",
                                type: "error",
                                confirmButtonClass: "btn btn-secondary"
                            });
                        }

                        specializationdatatable.draw();

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
            url: base_url+"ajax/backend/specialization-edit/"+id,
            data: { id : id},
            dataType: "json",
            success: function(response){
                console.log(response);
                let id 			= response[0].id;
                let name 	= response[0].name;


                // let specializationArray = id.split(", ");
                //
                // $('#updateOptions').val(specializationArray); // Select the option with a value of '1'
                // $('#updateOptions').trigger('change'); // Notify any JS components that the value changed

                if(response !== '')
                {
                    $('#id').val(id);
                    $('#editName').val(name);
                }
            }
        });
    });


    //
    // jQuery('body').on( "click", '#formUpdate', function(ev) {
    //
    //     jQuery('#updatePlane').submit();
    //
    // });


    jQuery('#updatespecialization').submit(function (){

        jQuery.ajax({
            type: "post",
            url: cortiamajax.specializationupdateajaxurl,
            data: $(this).serialize(),
            dataType: "text",
            success: function(response){


                if(response=="success"){
                    swal.fire({
                        title: "Specialization",
                        text: "Specialization updated successfully",
                        type: "success",
                        confirmButtonClass: "btn btn-secondary"
                    });
                }
                if(response == "fail"){
                    swal.fire({
                        title: "Specialization",
                        text: "Specialization cannot updated",
                        type: "error",
                        confirmButtonClass: "btn btn-secondary"
                    });
                }

                jQuery("#editSpecializationsModal").modal('hide');
                specializationdatatable.draw();
                document.getElementById("addspecialization").reset();
            }
        });


        return false;
    });


});