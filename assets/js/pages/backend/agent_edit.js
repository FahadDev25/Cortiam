jQuery(document).ready(function() {
  var $image = jQuery("#avatar-cropper-image");
  var $filefield = jQuery("#avatarupload")[0];
  var $currentavatar = jQuery('#pageavatar').attr('src');

	jQuery('body').on( "change", '#avatarupload', function(ev) {
		jQuery('#avatarmodal').modal({show:true,backdrop:'static'}).on('shown.bs.modal', function (e) {
	  	jQuery('#avatarmodal .modal-dialog').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.9}});
			var UploadfileName = $filefield.value
			var UploadfileNameExt = UploadfileName.substr(UploadfileName.lastIndexOf('.') + 1);
	    var oFReader = new FileReader();
			if(UploadfileNameExt.toLowerCase() == "heic"){
	      heic2any({
	          blob: $filefield.files[0],
	          toType: "image/png",
	      }).then(function (resultBlob) {
	    		oFReader.readAsDataURL(resultBlob);
        });
			}else{
	    	oFReader.readAsDataURL($filefield.files[0]);
			}
	    oFReader.onload = function (oFREvent) {
		    $image.attr('src', this.result);
		    $image.cropper({
		      aspectRatio: 1,
		      autoCropArea: 1
		    });
	    };
			$image.on('ready', function () {
				jQuery('#avatarmodal .modal-dialog').unblock();
			});
		}).on('hidden.bs.modal', function () {
			$image.attr('src', '');
			$image.cropper('destroy');
			jQuery('#pageavatar').attr('src', $currentavatar);
		});
	});

  jQuery('body').on('click', '#getmydata', function () {
    canvas = $image.cropper('getCroppedCanvas',{width:250,height:250});
    canvas.toBlob(function(blob) {
      url = URL.createObjectURL(blob);
      var reader = new FileReader();
			reader.readAsDataURL(blob);
			reader.onloadend = function() {
				var base64data = reader.result;
				$.ajax({
				  type: "POST",
				  dataType: "json",
				  url: cortiamajax.avataruploadurl,
				  data: {image: base64data, type: 'agent', recordID: jQuery('input[name="recordID"]').val()},
				  success: function(data){
				  	$currentavatar = data.avatarurl;
				  	jQuery('.deleteprofileimg').removeClass('d-none');
						jQuery('#avatarmodal').modal('hide');
				  }
				});
			}
    });
  });

  jQuery('.avatar-cropper-toolbar').on('click', '[data-method]', function () {
    var $this = jQuery(this),
        data = $this.data(),
        $target,
        result;

    if ($image.data('cropper') && data.method) {
      data = $.extend({}, data);
      if (typeof data.target !== 'undefined') {
        $target = jQuery(data.target);
        if (typeof data.option === 'undefined') {
        	data.option = JSON.parse($target.val());
        }
      }

      result = $image.cropper(data.method, data.option, data.secondOption);

      switch (data.method) {
          case 'scaleX':
          case 'scaleY':
              jQuery(this).data('option', -data.option);
          break;
      }
    }
  });

  jQuery('body').on('click', '.deleteprofileimg', function (ev) {
		ev.preventDefault();
  	selected_button = jQuery(this);
  	profile_id = jQuery(this).data('profile');
		swal.fire({
	    title: "Delete Profile Photo",
	    text: "Selected photo will be removed from profile and you won't be able to revert this action! Are you sure want to continue?",
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: '<b><i class="icon-cross2"></i></b> No',
			cancelButtonClass: "btn bg-danger btn-labeled btn-labeled-left rounded-round float-left",
	    confirmButtonText: '<b><i class="icon-checkmark3"></i></b> Yes',
			confirmButtonClass: "btn bg-teal-400 btn-labeled btn-labeled-left rounded-round float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
					type: "post",
					url: cortiamajax.deleteprofileimgurl,
		  		data: {'profile_id' : profile_id, 'type' : 'agent'},
					dataType: "json",
					beforeSend: function() {
						jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
					},
					success: function(response){
						if(response.success){
							swal.fire({
								title: response.success_title,
								text: response.success_message,
								type: "success",
								confirmButtonClass: "btn btn-secondary"
							});
							jQuery(selected_button).addClass('d-none');
							jQuery('#pageavatar').attr('src',cortiamajax.emptyphoto);
						}
				  	if(response.fail){
							swal.fire({
								background: "#fff",
								title: response.fail_title,
								text: response.fail_message,
								type: "error",
								confirmButtonClass: "btn btn-secondary"
							});
				  	}
						jQuery.unblockUI();
					}
				});
			}
		});
  });

  jQuery('.select').select2({
  	minimumResultsForSearch: Infinity,
  });

  jQuery('#bio').trumbowyg({
      btns: [
          // ['formatting'],
          ['strong', 'em'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['unorderedList', 'orderedList'],
          ['undo', 'redo'], // Only supported in Blink browsers
          ['insertImage', 'link'],
          ['viewHTML'],
          ['fullscreen']
      ]
  });

  jQuery('#estate_specialization').trumbowyg({
      btns: [
          // ['formatting'],
          ['strong', 'em'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['unorderedList', 'orderedList'],
          ['undo', 'redo'], // Only supported in Blink browsers
          ['insertImage', 'link'],
          ['viewHTML'],
          ['fullscreen']
      ]
  });

  jQuery('#state').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });

	jQuery('#state').on('select2:select', function (e) {
	  var selected_state = e.params.data;
		jQuery('#city').select2({
			data: _cities_[selected_state.id],
			placeholder: 'Select a City',
			allowClear: true
		});
	});

	jQuery('#city').select2({
		data:  _cities_[''+jQuery('#state').val()+''],
		placeholder: 'Select a City',
		allowClear: true
	});

  jQuery('#brokerage_state').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });

	jQuery('#brokerage_state').on('select2:select', function (e) {
	  var selected_state = e.params.data;
		jQuery('#brokerage_city').select2({
			data: _cities_[selected_state.id],
			placeholder: 'Select a City',
			allowClear: true
		});
	});

  jQuery('#brokerage_city').select2({
		data:  _cities_[''+jQuery('#state').val()+''],
		placeholder: 'Select a City',
		allowClear: true
	});


	jQuery("#experience").datepicker({startView: 2, format: 'yyyy', autoHide: true});

  jQuery('#password').passy(function(strength) {
	  jQuery('#password_indicator').text(pw_feedback[strength].text);
	  jQuery('#password_indicator').css({'background-color': pw_feedback[strength].color, 'border-color': pw_feedback[strength].color, 'color': pw_feedback[strength].textColor});
  });

  jQuery('#passwordagain').blur(function() {
    if(jQuery('#passwordagain').val().length == 0){
      jQuery('#passwordagain_indicator').text('No Password').css({'background-color': '', 'border-color': '', 'color': ''});
    }else if (jQuery('#password').val() != jQuery('#passwordagain').val()) {
      jQuery('#passwordagain_indicator').text('Not Match').css({'background-color': '#D55757', 'border-color': '#D55757', 'color': '#ffffff'});
    }else {
      jQuery('#passwordagain_indicator').text('Match').css({'background-color': '#40B381', 'border-color': '#40B381', 'color': '#ffffff'});
    }
  });

	var switchelems = Array.prototype.slice.call(document.querySelectorAll('.form-check-input-switchery'));

	switchelems.forEach(function(html) {
	  var switchery = new Switchery(html);
	});

	$.fn.dataTable.moment( 'YYYY/MM/DD HH:mm A' );
  messagedatatable = jQuery('#messagetable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 1, "asc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"language": {
	      "zeroRecords": "No message at this moment.",
	      "loadingRecords": '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>'
	    },
	    "rowId":function(a) {
		    return 'message-' + a.record_id;
		  },
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
	      jQuery(nRow).attr("data-record", aData.record_id);
	      jQuery(nRow).addClass("clickmetrigger");
	      return nRow;
      },
			"columnDefs": [
			  { "type": "string", "targets": 0, "data": "from", "title": "Message From", "width": "120px", "className": "text-left"},
			  { "type": "string", "targets": 1, "data": "to", "title": "Message To", "width": "120px", "className": "text-left"},
			  { "type": "string", "targets": 2, "data": "title", "title": "Title", "width": "250px"},
			  { "type": "date",  	"targets": 3, "data": "date", "title": "Date", "width": "120px"},
			  { "type": "html", "targets": 4, "data": "status", "title": "Status", "width": "100px", "className": "text-center"},
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.messagetableajaxurl,
        'data': {agent_id: cortiamajax.agent_id}
	    },
  });


	jQuery('body').on( "click", '#messagetable .clickmetrigger', function(ev) {
		ev.preventDefault();
  	record_id = jQuery(this).data('record');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.viewmessageurl,
  		data: {'record_id' : record_id},
			dataType: "json",
			beforeSend: function() {
				jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
			},
			success: function(response){
				if(response.success){
					swal.fire({
						html: response.html,
						confirmButtonText : 'Close',
						customClass: {
					    confirmButton: 'btn btn-secondary',
					    popup: 'longerpop'
					  }
					});
				}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
				jQuery.unblockUI();
			}
		});
	});


  propertiesdatatable = jQuery('#propstable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 1, "asc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"language": {
	      "zeroRecords": "No property at this moment.",
	      "loadingRecords": '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>'
	    },
	    "rowId":function(a) {
		    return 'prop-' + a.property_id;
		  },
			"columnDefs": [
			  { "type": "string", "targets": 0, "data": "image", "title": "", "orderable": false, "searchable": false, "width": "80px"},
			  { "type": "string", "targets": 1, "data": "location", "title": "Location"},
			  { "type": "string",  	"targets": 2, "data": "type", "title": "Property", "width": "100px"},
			  { "type": "string",  	"targets": 3, "data": "sub_type", "title": "Type", "width": "150px" },
			  { "type": "string",  	"targets": 4, "data": "building_size", "title": "Building Size", "width": "150px" },
			  { "type": "date", "targets": 5, "data": "created_on", "title": "Created On", "width": "200px" },
			  { "type": "html",   "targets": 6, "data": "status", "orderable": false, "searchable": false, "className": "text-center", "width": "100px" },
			  { "type": "html",   "targets": 7, "data": "link", "orderable": false, "searchable": false, "width": "150px" },
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.propertiestableajaxurl,
        'data': {agent_id: cortiamajax.agent_id}
	    },
  });


  offersdatatable = jQuery('#offertable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 6, "desc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"language": {
	      "zeroRecords": "No offer at this moment.",
	      "loadingRecords": '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>'
	    },
	    "rowId":function(a) {
		    return 'offer-' + a.record_id;
		  },
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
	      jQuery(nRow).attr("data-record", aData.record_id);
	      jQuery(nRow).addClass("clickmetrigger");
	      return nRow;
      },
			"columnDefs": [
			  { "type": "html", "targets": 0, "data": "image", "title": "", "orderable": false, "searchable": false, "width": "80px"},
			  { "type": "string", "targets": 1, "data": "location", "title": "Location", "width": "100px"},
			  { "type": "string",  	"targets": 2, "data": "from", "title": "From", "width": "150px"},
			  { "type": "string",  	"targets": 3, "data": "to", "title": "To", "width": "150px"},
			  { "type": "num-fmt",  	"targets": 4, "data": "commission", "title": "Commission Rate", "width": "70px", "render": $.fn.dataTable.render.number( ',', '.', 1, '%' )},
			  { "type": "string",  	"targets": 5, "data": "contract", "title": "Contract Length", "width": "100px", "render":function ( data, type, row, meta ) {return data + ' Months';}},
			  { "type": "date", "targets": 6, "data": "created_on", "title": "Send On", "width": "140px" },
			  { "type": "html",   "targets": 7, "data": "status", "title": "Status", "orderable": false, "searchable": false, "className": "text-center", "width": "80px" },
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.offertableajaxurl,
        'data': {agent_id: cortiamajax.agent_id}
	    },
  });

	jQuery('body').on( "click", '#offertable .clickmetrigger', function(ev) {
		ev.preventDefault();
  	record_id = jQuery(this).data('record');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.viewofferurl,
  		data: {'record_id' : record_id},
			dataType: "json",
			beforeSend: function() {
				jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
			},
			success: function(response){
				if(response.success){
					swal.fire({
						html: response.html,
						confirmButtonText : 'Close',
						customClass: {
					    confirmButton: 'btn btn-secondary',
					    popup: 'longerpop'
					  }
					});
				}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
				jQuery.unblockUI();
			}
		});
	});

  contractdatatable = jQuery('#contracttable').DataTable({
      dom: '<"datatable-header"lf><"datatable-scroll-wrap"t><"datatable-footer"ip>',
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 1, "asc" ]],
      "paging": true,
      "pageLength": 25,
      "lengthMenu": [ 10, 25, 50, 75, 100 ],
  		"language": {
	      "zeroRecords": "No message at this moment.",
	      "loadingRecords": '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>'
	    },
	    "rowId":function(a) {
		    return 'contract-' + a.record_id;
		  },
      "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
	      jQuery(nRow).attr("data-record", aData.record_id);
	      jQuery(nRow).addClass("clickmetrigger");
	      return nRow;
      },
			"columnDefs": [
			  { "type": "html", "targets": 0, "data": "image", "title": "", "orderable": false, "searchable": false, "width": "80px"},
			  { "type": "string", "targets": 1, "data": "location", "title": "Location", "width": "100px"},
			  { "type": "string",  	"targets": 2, "data": "agent", "title": "Agent", "width": "150px"},
			  { "type": "string",  	"targets": 3, "data": "seller", "title": "Seller", "width": "150px"},
			  { "type": "num-fmt",  	"targets": 4, "data": "commission", "title": "Commission Rate", "width": "70px", "render": $.fn.dataTable.render.number( ',', '.', 1, '%' )},
			  { "type": "string",  	"targets": 5, "data": "contract", "title": "Contract Length", "width": "100px", "render":function ( data, type, row, meta ) {return data + ' Months';}},
			  { "type": "html",   "targets": 6, "data": "signed", "title": "Signed", "orderable": false, "searchable": false, "className": "text-center", "width": "80px" },
			  { "type": "html",   "targets": 7, "data": "status", "title": "Status", "orderable": false, "searchable": false, "className": "text-center", "width": "80px" },
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.contracttableajaxurl,
        'data': {agent_id: cortiamajax.agent_id}
	    },
  });

	jQuery('body').on( "click", '#contracttable .clickmetrigger', function(ev) {
		ev.preventDefault();
  	record_id = jQuery(this).data('record');
		jQuery.ajax({
			type: "post",
			url: cortiamajax.viewcontracturl,
  		data: {'record_id' : record_id},
			dataType: "json",
			beforeSend: function() {
				jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
			},
			success: function(response){
				if(response.success){
					swal.fire({
						html: response.html,
						confirmButtonText : 'Close',
						customClass: {
					    confirmButton: 'btn btn-secondary',
					    popup: 'longerpop'
					  }
					});
				}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-secondary"
					});
		  	}
				jQuery.unblockUI();
			}
		});
	});
  jQuery('body').on( "click", '.buymepackage', function(ev) {
		ev.preventDefault();
  	package_id = jQuery(this).data('package');
  	package_title = jQuery(this).data('title');
  	package_cost = jQuery(this).data('cost');
  	package_row = jQuery(this).parents('tr');
  	jQuery(package_row).addClass('selected');
		swal.fire({
			title: 'Add Free Extra Limit Package',
			html: 'Are you sure you want to add <b class="orange">' + package_title + '</b> extra limit package to current agent for  <b class="orange">FREE</b>?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "btn btn-danger float-left",
	    confirmButtonText: 'Add',
			confirmButtonClass: "btn btn-success float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
				  url: cortiamajax.buypackageurl,
				  type: "POST",
				  data: {'package_id' : package_id, 'agent_id' : cortiamajax.agent_id},
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.success){
							swal.fire({
								title: i.success_title,
								text: i.success_message,
								type: "success",
								confirmButtonClass: "btn btn-secondary"
							});
							jQuery.ajax({
							  url: cortiamajax.listinvoicesurl,
							  type: "POST",
							  dataType: "json",
							  success: function(response) {
							  	if(response.success){
							  		jQuery('#invoicelistingpart').html(response.html);
							  	}
							  }
							});
							jQuery.ajax({
							  url: cortiamajax.listmypackagesurl,
							  type: "POST",
							  dataType: "json",
							  success: function(response) {
							  	if(response.success){
							  		jQuery('#packagelistingpart').html(response.html);
							  	}
							  }
							});
  						jQuery(package_row).removeClass('selected');
							jQuery.unblockUI();
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "btn btn-secondary"
							});
				  	}
				  }
				});
			}else{
  			jQuery(package_row).removeClass('selected');
			}
		});
  });

  jQuery('body').on( "click", '#LimitPackagesAdd', function(ev) {
		ev.preventDefault();
		jQuery.ajax({
			type: "post",
			url: cortiamajax.listpackagesurl,
			dataType: "json",
			beforeSend: function() {
				jQuery.blockUI({
	        message: '<div class="processing single">' + cortiamajax.loadingimage  + '</div>',
	        overlayCSS:  {
		        backgroundColor: '#000000',
		        opacity:         0.8,
		        cursor:          'pointer'
	    		},
	    		css: {
		        top:      (jQuery(window).scrollTop() + 20),
	        	width:    '100%',
		        left:     '0%',
		        border:   '0px solid #aaa',
		        position: 'absolute',
		        cursor:          'default',
		        backgroundColor:'transparent',
		    	}
	    	});
			},
			success: function(response){
				if(response.html){
					jQuery('.blockMsg ').html(response.html);
					jQuery('table.packages [data-toggle="tooltip"]').tooltip();
				}else{
					jQuery.unblockUI();
				}
			}
		});
	});

	jQuery(document).on('keyup', function(e) {
	  if (e.which === 27) {
	    jQuery.unblockUI();
	  }
	});

	jQuery('body').on('click touchstart', '.blockOverlay', function(ev) {
    jQuery.unblockUI();
	});

	jQuery('body').on( "click", '#thistory .refundmoney', function(ev) {
		ev.preventDefault();
  	record_id = jQuery(this).data('refund');
  	refund_amount = jQuery(this).data('amount');
		swal.fire({
			title: 'Refund Payment',
			html: 'Are you sure you want to refund <b class="orange">$' + refund_amount + ' USD</b> payment amount back to real estate agents account?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "btn btn-danger float-left",
	    confirmButtonText: 'Yes',
			confirmButtonClass: "btn btn-success float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
					type: "post",
					url: cortiamajax.refundurl,
		  		data: {'record_id' : record_id},
					dataType: "json",
					beforeSend: function() {
						jQuery.blockUI({message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',css: {border:'0px',width:'100%',top:'10%',left:'0%',background:'transparent', cursor:'context-menu'},overlayCSS: {backgroundColor:'#000000',opacity:.7}});
					},
					success: function(response){
						if(response.success){
							swal.fire({
								title: response.success_title,
								text: response.success_message,
								type: "success",
								confirmButtonClass: "btn btn-secondary"
							});
						}
				  	if(response.fail){
							swal.fire({
								title: response.fail_title,
								text: response.fail_message,
								type: "error",
								confirmButtonClass: "btn btn-secondary"
							});
				  	}
						jQuery.unblockUI();
					}
				});
			}
		});
	});


  jQuery('body').on( "click", '#addlicense', function(ev) {
  	jQuery(this).hide();
		ev.preventDefault();
		jQuery('#addlicense').hide();
		jQuery('#licenselistingpart').slideUp();
		jQuery('#tlicenses').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.getlicenseformurl,
		  type: "POST",
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
		  		jQuery('#addnewlicense').html(i.form);
					jQuery('#addnewlicense').slideDown('slow');
			    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);

				  jQuery('#interested').select2({
				  	minimumResultsForSearch: Infinity,
				  });
				  jQuery('#license_state').select2({
						data: _states_,
					  placeholder: 'Select a State',
					  allowClear: true
				  });
				  jQuery('#license_expire').datepicker({format: 'mm/dd/yyyy', startDate: new Date(), autoHide: true});
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
		  	jQuery('#tlicenses').unblock();
		  }
		});
  });


  jQuery('body').on( "click", '#license-add-button', function(ev) {
		ev.preventDefault();
		var form_data = jQuery('#addnewlicense :input').serializeArray();
		form_data.push({name: "agent_id", value: cortiamajax.agent_id});
		jQuery('#addnewlicense').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.addlicenseurl,
		  type: "POST",
		  data: form_data,
		  dataType: "json",
		  success: function(response) {
		  	if(response.success){
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "btn btn-success"
					});

					jQuery.ajax({
					  url: cortiamajax.listlicenseurl,
					  type: "POST",
					  data: {agent_id: cortiamajax.agent_id},
					  dataType: "json",
					  success: function(i, s, r, a) {
					  	if(i.success){
					  		jQuery('#licenselistingpart .profile-list').html(i.form);
								jQuery('#licenselistingpart').slideDown('slow');
								jQuery('#addnewlicense').html('').slideUp();
						    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);
								jQuery('#addlicense').show();
					  	}
					  }
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
				if(response.errorfields){
					jQuery.each(response.errorfields, function(index, value) {
						if(jQuery("#"+index).hasClass('select2-hidden-accessible')){
							jQuery("#"+index).next('span.select2-container').find('.select2-selection--single').addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}else{
							jQuery("#"+index).addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}
			    });
				}
		  	jQuery('#addnewlicense').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '.editmylicense', function(ev) {
		ev.preventDefault();
  	license_id = jQuery(this).data('id');
		jQuery('#addlicense').hide();
		jQuery('#licenselistingpart').slideUp();
		jQuery('#tlicenses').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.getlicenseformurl,
		  type: "POST",
		  data: {'licenseid' : license_id},
		  dataType: "json",
		  success: function(i, s, r, a) {
		  	if(i.success){
		  		jQuery('#addnewlicense').html(i.form);
					jQuery('#addnewlicense').slideDown('slow');
			    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);

				  jQuery('#interested').select2({
				  	minimumResultsForSearch: Infinity,
				  });
				  jQuery('#license_state').select2({
						data: _states_,
					  placeholder: 'Select a State',
					  allowClear: true
				  });
				  jQuery('#license_expire').datepicker({format: 'mm/dd/yyyy', startDate: new Date(), autoHide: true});
		  	}
		  	if(i.fail){
					swal.fire({
						title: i.fail_title,
						text: i.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
		  	jQuery('#tlicenses').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '#license-update-button', function(ev) {
		ev.preventDefault();
		var form_data = jQuery('#addnewlicense :input').serializeArray();
		form_data.push({name: "agent_id", value: cortiamajax.agent_id});
		jQuery('#addnewlicense').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		jQuery.ajax({
		  url: cortiamajax.editlicenseurl,
		  type: "POST",
		  data: form_data,
		  dataType: "json",
		  success: function(response) {
		  	if(response.success){
					swal.fire({
						title: response.success_title,
						text: response.success_message,
						type: "success",
						confirmButtonClass: "btn btn-success"
					});

					jQuery.ajax({
					  url: cortiamajax.listlicenseurl,
					  type: "POST",
					  data: {agent_id: cortiamajax.agent_id},
					  dataType: "json",
					  success: function(i, s, r, a) {
					  	if(i.success){
					  		jQuery('#licenselistingpart .profile-list').html(i.form);
								jQuery('#licenselistingpart').slideDown('slow');
								jQuery('#addnewlicense').html('').slideUp();
						    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);
								jQuery('#addlicense').show();
					  	}
					  }
					});
		  	}
		  	if(response.fail){
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "btn btn-success"
					});
		  	}
				if(response.errorfields){
					jQuery.each(response.errorfields, function(index, value) {
						if(jQuery("#"+index).hasClass('select2-hidden-accessible')){
							jQuery("#"+index).next('span.select2-container').find('.select2-selection--single').addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}else{
							jQuery("#"+index).addClass("border-danger").one("focus", function() {
								jQuery(this).removeClass("border-danger");
							});
						}
			    });
				}
		  	jQuery('#addnewlicense').unblock();
		  }
		});
  });

  jQuery('body').on( "click", '#license-cancel-button', function(ev) {
		ev.preventDefault();
		jQuery('#addnewlicense').slideUp().html('');
		jQuery('#addlicense').show();
 		jQuery('#licenselistingpart').slideDown();
   	jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);
  });

  jQuery('body').on( "click", '.deletemylicense', function(ev) {
		ev.preventDefault();
  	license_id = jQuery(this).data('id');
  	payment_row = jQuery(this).parents('tr');
		swal.fire({
			title: 'Agent License Removal',
			text: 'Are you sure you want to delete selected agent license?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "btn btn-danger float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "btn btn-success float-right"
		}).then(function(e) {
			if(e.value){
				jQuery('#paymentpart').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
				jQuery.ajax({
				  url: cortiamajax.deletelicenseurl,
				  type: "POST",
				  data: {'license_id' : license_id},
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.success){
							swal.fire({
								title: i.success_title,
								text: i.success_message,
								type: "success",
								confirmButtonClass: "btn btn-success"
							});
							jQuery(payment_row).remove();
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "btn btn-success"
							});
				  	}
				  	jQuery('#paymentpart').unblock();
				  }
				});
			}
		});
  });

  jQuery('body').on( "click", '.approvemylicense', function(ev) {
		ev.preventDefault();
  	license_id = jQuery(this).data('id');
  	approval = jQuery(this).data('type');
		jQuery('#tlicenses').block({ message: '<img src="' + cortiamajax.loadingimage + '">', css: {border:'0px',background:'transparent',}, overlayCSS: {backgroundColor:'#fff',opacity:0.7}});
		swal.fire({
			title: approval + ' Agent License',
			text: 'Are you sure you want to ' + approval.toLowerCase() + ' selected agent license?',
	    type: "question",
	    showCancelButton: !0,
	    cancelButtonText: 'Cancel',
			cancelButtonClass: "btn btn-danger float-left",
	    confirmButtonText: 'Proceed',
			confirmButtonClass: "btn btn-success float-right"
		}).then(function(e) {
			if(e.value){
				jQuery.ajax({
				  url: cortiamajax.approvelicenseurl,
				  type: "POST",
				  data: {'license_id' : license_id, 'type' : approval},
				  dataType: "json",
				  success: function(i, s, r, a) {
				  	if(i.success){
							swal.fire({
								title: i.success_title,
								text: i.success_message,
								type: "success",
								confirmButtonClass: "btn btn-success"
							});
							jQuery.ajax({
							  url: cortiamajax.listlicenseurl,
							  type: "POST",
							  data: {agent_id: cortiamajax.agent_id},
							  dataType: "json",
							  success: function(i, s, r, a) {
							  	if(i.success){
							  		jQuery('#licenselistingpart .profile-list').html(i.form);
								    jQuery('html, body').animate({scrollTop: jQuery("#tlicenses").offset().top}, 1000);
							  	}
							  }
							});
				  	}
				  	if(i.fail){
							swal.fire({
								title: i.fail_title,
								text: i.fail_message,
								type: "error",
								confirmButtonClass: "btn btn-success"
							});
				  	}
				  }
				});
			}
	  	jQuery('#tlicenses').unblock();
		});
  });
});

