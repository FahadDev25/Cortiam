		   	</div>
			</div>
		</div>
	</main>

		<!--begin Page Scripts -->
    <?php if (isset($footer_data['js_files'])) { echo "\n\t<script src=\"".implode("\"></script>\n\t<script src=\"",$footer_data['js_files'])."\"></script>\n";}?>
		<!--end Page Scripts -->
	</body>

	<!-- end Body -->
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCywz554GE2hipurlh2Yoc0XRhh7Ut3_3k&libraries=places"></script>

	<script>


	var input = document.getElementById('address');
	var brokerage_address = document.getElementById('brokerage_address');
	//console.log(_cities_['Florida']);
	var statesArray = [];
	var cityArray   = [];
	var zipCode     = '';
    var oldStates   = _states_;

	if(input !== '')
	{
    	google.maps.event.addDomListener(window, 'load', initialize);
	}

	if(brokerage_address !== '')
	{
		google.maps.event.addDomListener(window, 'load', brokerage);

	}



	
	function brokerage()
	{

		var autocomplete = new google.maps.places.Autocomplete(brokerage_address);
  
  		autocomplete.addListener('place_changed', function () {
  			var place = autocomplete.getPlace();
            let placesLength = place.address_components;


			
			$('#brokerage_state').select2("destroy").select2();
			$('#brokerage_city').select2("destroy").select2();

			$('#brokerage_state').empty();
			$('#brokerage_city').empty();

			$('#brokerage_zipcode').val('');


			statesArray = [];
			cityArray   = [];
			zipCode     = '';
			city        = '';
			jQuery('#brokerage_state').select2({
		 		 	data:  oldStates,
		  			placeholder: 'Select a City',
		  			allowClear: true
	  			});

			for (let index = 0; index < placesLength.length; index++) {
				let element = placesLength[index]['long_name'];

				if( $.isNumeric(element))
				{
					zipCode    = element;
				}

				for (var i = 0; i < oldStates.length; i++) {
					if (oldStates[i] == element) {
						statesArray.push(oldStates[i]);
					}
				}

				
				let arrayOfCities = _cities_[statesArray[0]];

				if(arrayOfCities)
				{	
					for (var i = 0; i < arrayOfCities.length; i++)
					{

						console.log(element);
						findstring = element.split(" ");
						if (arrayOfCities[i].match(findstring[0]))
						{							
							city = arrayOfCities[i];
						}
					}
				}
			}

			if(zipCode !== '')
			{
				$('#brokerage_zipcode').val(zipCode);
			}

			if(statesArray.length > 0)
			{
				$('#brokerage_state').val(statesArray).trigger('change');

				$("#brokerage_city").select2("destroy").select2();


				
				getCity = _cities_[statesArray[0]];

				if(city !== '')
				{
					getCity.unshift(city);
				}


				jQuery('#brokerage_city').select2({
					data: getCity,
					placeholder: 'Select a State',
					allowClear: true
				});
			}

				if(city !== '')
				{	
					
					$('#brokerage_city').val(getCity[0]).trigger('change');

				}else{
					jQuery('#brokerage_city').select2({
							data:  _cities_[statesArray[0]],
							placeholder: 'Select a City',
							allowClear: true
						});
				}

  		});
	}

  
function initialize() { 
	

		var autocomplete = new google.maps.places.Autocomplete(input);  
       autocomplete.addListener('place_changed', function () { 
	  var place = autocomplete.getPlace();
	  //json = JSON.stringify(place, true);
	  let placesLength = place.address_components;


	  
	  		$('#state').select2("destroy").select2();
			$('#city').select2("destroy").select2();

			$('#state').empty();
			$('#city').empty();

			$('#zipcode').val('');


			jQuery('#state').select2({
		 		 	data:  oldStates,
		  			placeholder: 'Select a City',
		  			allowClear: true
	  			});

		statesArray = [];
		cityArray   = [];
		zipCode     = '';
		city        = '';
	  for (let index = 0; index < placesLength.length; index++) {
		  let element = placesLength[index]['long_name'];

		  if( $.isNumeric(element))
		  {
			  zipCode    = element;
		  }

		  for (var i = 0; i < oldStates.length; i++) {
			  if (oldStates[i] == element) {
				  statesArray.push(oldStates[i]);
			  }
		  }

		  let arrayOfCities = _cities_[statesArray[0]];

			if(arrayOfCities)
			{	
				for (var i = 0; i < arrayOfCities.length; i++)
				{

					console.log(element);
					findstring = element.split(" ");
					if (arrayOfCities[i].match(findstring[0]))
					{							
						city = arrayOfCities[i];
					}
				}
			}
	  
		  //return results;				
	  
	  }



	  if(zipCode !== '')
	  {
		  $('#zipcode').val(zipCode);
	  }

	  if(statesArray.length > 0)
	  {
		  $('#state').val(statesArray).trigger('change');

		  $("#city").select2("destroy").select2();

		  getCity = _cities_[statesArray[0]];

			if(city !== '')
			{
				getCity.unshift(city);
			}


		  jQuery('#city').select2({
			data: getCity,

			  placeholder: 'Select a State',
			  allowClear: true
		  });
	  }

	  if(city !== '')
	  {	
		  
		  $('#city').val(getCity[0]).trigger('change');

	  }else{
		  jQuery('#city').select2({
				data:  _cities_[statesArray[0]],
				placeholder: 'Select a City',
				allowClear: true
			});
	  }



  });

}



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
	  //   selected:"Florida",
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
	  //   selected:"Florida",
		allowClear: true
  });
});

jQuery('#brokerage_city').select2({
	data:  _cities_[''+jQuery('#state').val()+''],
	placeholder: 'Select a City',
	allowClear: true
});

</script>



<div id="avatarmodal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center">Edit Your Photo</h3>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="image-cropper-container mb-3 photocropwrap">
					<img src="<?php echo base_url('assets/images/backend/placeholder.png');?>" alt="" class="cropper" id="avatar-cropper-image">
				</div>
				<div class="form-group avatar-cropper-toolbar mb-0">
					<div class="btn-group btn-group-justified d-flex rounded orange-bg">
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="setDragMode" data-option="move" title="Move">
								<span class="icon-co-big white move"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="setDragMode" data-option="crop" title="Crop">
								<span class="icon-co-big white crop"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="zoom" data-option="0.1" title="Zoom In">
								<span class="icon-co-big white zoomin"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="zoom" data-option="-0.1" title="Zoom Out">
								<span class="icon-co-big white zoomout"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="rotate" data-option="-45" title="Rotate Left">
								<span class="icon-co-big white rotateleft"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="rotate" data-option="45" title="Rotate Right">
								<span class="icon-co-big white rotateright"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="scaleX" data-option="-1" title="Flip Horizontal">
								<span class="icon-co-big white fliph"></span>
							</button>
							<button type="button" class="btn bg-orange-700 btn-icon" data-method="scaleY" data-option="-1" title="Flip Vertical">
								<span class="icon-co-big white flipv"></span>
							</button>
					</div>
				</div>
			</div>
			<div class="modal-footer justify-content-between">
				<button type="button" class="button-danger" data-dismiss="modal">Cancel</button>
				<button type="button" class="button-success" id="dophotocrop">Change</button>
			</div>
		</div>
	</div>
</div>

</html>