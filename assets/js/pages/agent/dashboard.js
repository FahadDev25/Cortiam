jQuery(document).ready(function() {
  jQuery('#bio').trumbowyg({
      btns: [
          // ['formatting'],
          ['strong', 'em'],
          ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
          ['unorderedList', 'orderedList'],
          ['undo', 'redo'], // Only supported in Blink browsers
          ['insertImage', 'link'],
      ]
  });

  jQuery('.select').select2({
  	minimumResultsForSearch: Infinity,
  });

  jQuery('#s_state').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });

	jQuery('#s_state').on('select2:select', function (e) {
	  var selected_state = e.params.data;
		jQuery('#s_city').select2({
			data: _cities_[selected_state.id],
			placeholder: 'Select a City',
			allowClear: true
		});
	});

	jQuery('#s_city').select2({
		data:  _cities_[''+jQuery('#state').val()+''],
		placeholder: 'Select a City',
		allowClear: true
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
		data:  _cities_[''+jQuery('#brokerage_state').val()+''],
		placeholder: 'Select a City',
		allowClear: true
	});

  jQuery('#license_states').select2({
		data: _states_,
	  placeholder: 'Select a State',
	  allowClear: true
  });


  jQuery('.carousel').each(function(key, carousel) {
  	if(jQuery(carousel).find('.proplisting').length >= 3){
			jQuery(carousel).slick({
			  dots: false,
			  infinite: false,
			  speed: 300,
			  slidesToShow: 3,
			  slidesToScroll: 1,
			  responsive: [
			    {
			      breakpoint: 600,
			      settings: {
			        slidesToShow: 2,
			        slidesToScroll: 1
			      }
			    },
			    {
			      breakpoint: 480,
			      settings: {
			        slidesToShow: 1,
			        slidesToScroll: 1
			      }
			    }
			  ]
			});
  	}
  });

	jQuery('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		if(jQuery(jQuery(e.target).attr('href') + ' .carousel').length){
			jQuery(jQuery(e.target).attr('href') + ' .carousel').slick('refresh');
		}
	})


	jQuery('#tabviamenu').on( 'click', 'a', function (ev) {
		ev.preventDefault();
  	tab_id = jQuery(this).data('open');
  	active_id = jQuery(this).data('active');
  	jQuery('#nav-tab .active').removeClass('active');
		jQuery('#'+ active_id).addClass('active');
  	jQuery('#nav-tabContent .show.active').removeClass('show active');
		jQuery('#'+ tab_id).tab('show');
		if(jQuery('#'+ tab_id + ' .carousel').length){
			jQuery('#'+ tab_id + ' .carousel').slick('refresh');
		}
	});

	jQuery('#tablesearch').on( 'click', function (ev) {
		ev.preventDefault();
		block = jQuery('#propertytable').closest('.card');
		jQuery(block).block({
		  message: '<div class="emptyloader"><img src="' + cortiamajax.loadingimage + '"></div>',
		  overlayCSS: {
		      backgroundColor: '#fff',
		      opacity: 0.8,
		      cursor: 'wait',
		      'box-shadow': '0 0 0 1px #ddd'
		  },
		  css: {
		      border: 0,
		      padding: 0,
		      backgroundColor: 'none'
		  }
		});
		propertydatatable.ajax.url( cortiamajax.datatableajaxurl ).load(function( data ) {
			jQuery(block).unblock();
		});
  });

	function buildTableData(){
		var obj = {
			city: jQuery("input[name='s_city']" ).val(),
			state: jQuery("input[name='s_state']" ).val(),
			zipcode: jQuery("input[name='s_zipcode']" ).val(),
			type: jQuery("select[name='s_type']" ).val(),
			rate: jQuery("select[name='s_commission_rate']" ).val(),
			length: jQuery("select[name='s_contract_length']" ).val(),
			radius: jQuery("input[name='s_ziprange']" ).val(),
		};
		return obj;
	}

  propertydatatable = jQuery('#propertytable').DataTable({
      "dom": '<"datatable-scroll-wrap"t><"datatable-footer"p>',
      "scrollY": 680,
      "responsive": true,
      "autoWidth": false,
      "bAutoWidth": false,
      "colReorder": true,
      "order": [[ 1, "asc" ]],
      "paging": true,
      "pageLength": 10,
  		"language": {
	      "zeroRecords": "No property available at this moment.",
	      "loadingRecords": '<div style="display:inline-block;width:100%;text-align:center;height:30px;"><div class="spinner-border text-dark" role="status"><span class="sr-only">Loading...</span></div></div>'
	    },
	    "rowId":function(a) {
		    return 'record-' + a.property_id;
		  },
			"columnDefs": [
			  { "type": "string", "targets": 0, "data": "image", "orderable": false, "searchable": false, "title": "Photo", "width": "80px"},
			  { "type": "string", "targets": 1, "data": "location", "title": "Location", "width": "140px"},
			  { "type": "html",  	"targets": 2, "data": "type", "title": "Type", "width": "40px"},
			  { "type": "string", "targets": 3, "data": "approx", "title": "Approx<br>Value", "width": "80px" },
			  { "type": "string", "targets": 4, "data": "rate", "title": "Terms", "width": "50px" },
			  { "type": "string", "targets": 5, "data": "length", "title": "Period", "width": "80px" },
			  { "type": "string", "targets": 6, "data": "button", "title": "", "width": "170px", "orderable": false, "searchable": false },
			],
			"ajax": {
        'type': 'POST',
        'url': cortiamajax.datatableajaxurl,
        'data': buildTableData
	    },
		  "drawCallback": function(settings) {
		    jQuery('[data-toggle="tooltip"]').tooltip();
		  }
  });

	jQuery('body').on( "click", '#saveproperty', function(ev) {
		ev.preventDefault();
  	button = jQuery(this);
  	property_id = jQuery(this).data('propid');
  	property_value = jQuery(this).data('value');
  	if(property_value == 'save'){
  		next_property_value = 'unsave';
  		next_button_text = 'Unsave';
  	}else{
  		next_property_value = 'save';
  		next_button_text = 'Save';
  	}
		jQuery.ajax({
			type: "post",
			url: cortiamajax.savepropertyurl,
		  data: {'property_id' : property_id, 'value' : property_value},
			dataType: "json",
			beforeSend: function() {
				jQuery('.buttonsrow').block({message: '<img src="' + cortiamajax.loadingimage + '">',css: {border:'0px',width:'100%',top:'0px' , background:'transparent'},overlayCSS: {backgroundColor:'#ffffff',opacity:.8}});
			},
			success: function(response){
				if(response.success){
					jQuery(button).html(next_button_text).data('value', next_property_value);
					jQuery.ajax({
						type: "post",
						url: cortiamajax.favoriteupdateurl,
						dataType: "json",
						beforeSend: function() {
							jQuery('#nav-sa .carousel').block({message: '<img src="' + cortiamajax.loadingimage + '">',css: {border:'0px',width:'100%',top:'0px' , background:'transparent'},overlayCSS: {backgroundColor:'#ffffff',opacity:.8}});
						},
						success: function(response){
							if(response.html){
								jQuery('#nav-sa').html(response.html);
							}
					  	if(jQuery('#nav-sa .carousel .proplisting').length >= 3){
								jQuery('#nav-sa .carousel').slick({
								  dots: false,
								  infinite: false,
								  speed: 300,
								  slidesToShow: 3,
								  slidesToScroll: 1,
								  responsive: [
								    {
								      breakpoint: 600,
								      settings: {
								        slidesToShow: 2,
								        slidesToScroll: 1
								      }
								    },
								    {
								      breakpoint: 480,
								      settings: {
								        slidesToShow: 1,
								        slidesToScroll: 1
								      }
								    }
								  ]
								});
					  	}
							jQuery('#nav-sa .carousel').unblock();
						}
					});

				}else{
					swal.fire({
						title: response.fail_title,
						text: response.fail_message,
						type: "error",
						confirmButtonClass: "button-orange"
					});
				}
				jQuery('.buttonsrow').unblock();
			}
		});
	});

	jQuery('#s_zipcode').on('keyup paste', function (ev) {
	  var optionsInputHavevalue = jQuery("[id^='s_zipcode']").filter(function() {
	    return jQuery(this).val().trim().length > 0 ;
	  }).length > 0;
	 jQuery("#s_ziprange").prop('disabled', !optionsInputHavevalue);
	 if(optionsInputHavevalue){jQuery( ".rangesliderwrap" ).tooltip( "disable");}else{jQuery( ".rangesliderwrap" ).tooltip( "enable");}
	}).change();

	var range_element = document.getElementById("s_ziprange");
	var range_display = document.getElementById("rangeshow");
	range_display.innerHTML = range_element.value;
	range_element.oninput = function() {
	  range_display.innerHTML = this.value;
	}
});