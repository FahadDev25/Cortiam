<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Seller Process controller
 *
 * The base controller which process page actions of the Cortiam Web Application Seller Panel
 *
 * @package    Cortiam Web Application
 * @subpackage Controllers
 * @category   Controllers
 * @copyright  Copyright (c) 2021, The Webb Enterprises Inc.
 * @author     The Webb Enterprises Dev Team
 * @link       http://www.thewebbenterprises.com
 * @since      Version 1.0
 *
 */

class Sellerprocess extends CRTM_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('seller_model');
		$this->load->helper(array('frontend'));

		if ($this->ion_auth->logged_in() && ($this->ion_auth->get_user_type() == 'Seller'))	{
			$this->account = $this->seller_model->get_seller($this->ion_auth->get_user_id());
		}else{
			die('No permission');
		}
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function update_account(){
		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email";}
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}elseif(($this->input->post("password")) && ($this->input->post("password") != $this->input->post("passwordagain"))){
			if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
			if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Again";}
			$response["fail"] = true;
			$response["fail_title"] = 'Password Doesnt Match!';
			$response["fail_message"] = 'Password confirmation and password must match. Please check out password fields and try again.';
		}else{
			$additional_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'first_name' => $this->input->post("first_name"),
				'last_name' => $this->input->post("last_name"),
				'phone' => (($this->input->post("phone"))? $this->input->post("phone"):null),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
				'notifications' => (($this->input->post("notifications"))? ($this->input->post("notifications")):'No'),
			);
			if ($hesapid = $this->ion_auth->update($this->account['id'], array('email' => $this->input->post("email")))) {
				$this->seller_model->edit_seller($this->account['id'], $additional_data);
				$this->create_avatar($this->account['avatar_string'],$this->input->post("first_name"),$this->input->post("last_name"));
				$response["success"] = true;
				$response["success_title"] = 'Your Account Details';
				$response["success_message"] = 'Your account details updated succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function change_password(){
		if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
		if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Confirmation";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif(($this->input->post("password")) && ($this->input->post("password") != $this->input->post("passwordagain"))){
			if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
			if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Again";}
			$response["fail"] = true;
			$response["fail_title"] = 'Password Doesnt Match!';
			$response["fail_message"] = 'Password confirmation and password must match. Please check out password fields and try again.';
		}else{
			if ($this->ion_auth->change_password($this->account['email'],$this->input->post('password'))) {
				$response["success"] = true;
				$response["success_title"] = 'Change Password';
				$response["success_message"] = 'Your account password updated succesfully. Please use your new password from now.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new property account
	 * @uses system_model::add_property To add details of property
	 *
	 * @return json true or false
	 */
	public function add_property(){
		$response["tabid"] = 'nav-tabContent';
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";$response["returntab"] = 'steps-second';}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";$response["returntab"] = 'steps-second';}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";$response["returntab"] = 'steps-second';}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";$response["returntab"] = 'steps-second';}
		if (!$this->input->post("land_size")) {$response["errorfields"]['land_size'] = "Land Size";$response["returntab"] = 'steps-second';}
		if (!$this->input->post("building_size")) {$response["errorfields"]['building_size'] = "Building Size";$response["returntab"] = 'steps-second';}
		if (!$this->input->post("built_date")) {$response["errorfields"]['built_date'] = "Build Date";$response["returntab"] = 'steps-second';}
		if (!$this->input->post("type")) {$response["errorfields"]['type'] = "Property Type";$response["returntab"] = 'steps-second';}
		if (!$this->input->post("sub_type")) {$response["errorfields"]['sub_type'] = "Property Type";$response["returntab"] = 'steps-second';}
		if ($this->input->post("type") == "Residential") {
			if (!$this->input->post("bedroom")) {$response["errorfields"]['bedroom'] = "Bedroom Amount";$response["returntab"] = 'steps-second';}
			if (!$this->input->post("bathroom")) {$response["errorfields"]['bathroom'] = "Bathroom Amount";$response["returntab"] = 'steps-second';}
		}

		if (!$this->input->post("commission_rate")) {$response["errorfields"]['commission_rate'] = "Commission Rate";$response["returntab"] = 'steps-first';}
		if (!$this->input->post("contract_length")) {$response["errorfields"]['contract_length'] = "Contract Length";$response["returntab"] = 'steps-first';}

		if (!$this->input->post("front_image")) {$response["errorfields"]['front_image'] = "Outdoor Photo 1";$response["returntab"] = 'steps-fourth';}
		if (!$this->input->post("rear_image")) {$response["errorfields"]['rear_image'] = "Outdoor Photo 2";$response["returntab"] = 'steps-fourth';}
		if (!$this->input->post("left_image")) {$response["errorfields"]['left_image'] = "Indoor Photo 1";$response["returntab"] = 'steps-fourth';}
		if (!$this->input->post("right_image")) {$response["errorfields"]['right_image'] = "Indoor Photo 2";$response["returntab"] = 'steps-fourth';}

		log_message("error", "before accept_top");

		if(!$this->account['accept_tos']) {
			$response["tos"] = true;
			$tos_content = $this->seller_model->get_terms_of_service();
			$response["tos_content"] = '<div id="tos_popup"><div id="tos_content"><h2>TERMS OF SERVICE</h2>'.$tos_content.'</div></div><div id="tos_action" class="disabled"><button type="submit" class="float-left button-danger"><b><i class="icon-cross2"></i></b> Decline</button><button type="submit" class="float-right button-success"><b><i class="icon-checkmark3"></i></b> Accept</button><div class="disablefornow" data-display="tooltip" data-placement="top" title="Please read the document to enable buttons"><span>Please read the document to enable buttons</span></div></div>';
		}elseif (isset($response["errorfields"]) && (count($response["errorfields"]) > 0 )) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = 'System cannot locate the given address. Please check your address details and try again.';
		}else{
			$timestamp = time();
			$property_data = array(
				'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
				'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
				'seller_id' => $this->account['id'],
				'type' => (($this->input->post("type") == 'Residential')? $this->input->post("type"):'Commercial'),
				'sub_type' => $this->input->post("sub_type"),
				'address' => (($this->input->post("address"))? $this->input->post("address"):null),
				'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
				'city' => (($this->input->post("city"))? $this->input->post("city"):null),
				'state' => (($this->input->post("state"))? $this->input->post("state"):null),
				'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
				'land_size' => (($this->input->post("land_size"))? $this->input->post("land_size"):null),
				'building_size' => (($this->input->post("building_size"))? $this->input->post("building_size"):null),
				'built_date' => (($this->input->post("built_date"))? $this->input->post("built_date"):null),
				'bedroom' => (($this->input->post("bedroom"))? $this->input->post("bedroom"):null),
				'bathroom' => (($this->input->post("bathroom"))? $this->input->post("bathroom"):null),
				'created_on' => $timestamp,
				'approval_date' => $timestamp,
				'commission_rate' => (($this->input->post("commission_rate"))? $this->input->post("commission_rate"):null),
				'contract_length' => (($this->input->post("contract_length"))? $this->input->post("contract_length"):null),
				'status' => 'Pending',
			);
			if ($property_id = $this->seller_model->add_property($property_data)) {
				$folderPath = FCPATH.'images/property/'.$property_id.'/';
				if (!file_exists($folderPath)) {
			    mkdir($folderPath, 0755, true);
				}
				if ($this->input->post("left_image")) {
					$update_data['default_image'] = $update_data['left_image'] = str_replace('images/property/','images/property/'.$property_id.'/',$this->input->post("left_image"));
					rename(FCPATH.$this->input->post("left_image"),FCPATH.$update_data['left_image']);
					rename(str_replace(".jpg","_mini.jpg",FCPATH.$this->input->post("left_image")),str_replace(".jpg","_mini.jpg",FCPATH.$update_data['left_image']));
				}
				if ($this->input->post("right_image")) {
					$update_data['default_image'] = $update_data['right_image'] = str_replace('images/property/','images/property/'.$property_id.'/',$this->input->post("right_image"));
					rename(FCPATH.$this->input->post("right_image"),FCPATH.$update_data['right_image']);
					rename(str_replace(".jpg","_mini.jpg",FCPATH.$this->input->post("right_image")),str_replace(".jpg","_mini.jpg",FCPATH.$update_data['right_image']));
				}
				if ($this->input->post("rear_image")) {
					$update_data['default_image'] = $update_data['rear_image'] = str_replace('images/property/','images/property/'.$property_id.'/',$this->input->post("rear_image"));
					rename(FCPATH.$this->input->post("rear_image"),FCPATH.$update_data['rear_image']);
					rename(str_replace(".jpg","_mini.jpg",FCPATH.$this->input->post("rear_image")),str_replace(".jpg","_mini.jpg",FCPATH.$update_data['rear_image']));
				}
				if ($this->input->post("front_image")) {
					$update_data['default_image'] = $update_data['front_image'] = str_replace('images/property/','images/property/'.$property_id.'/',$this->input->post("front_image"));
					rename(FCPATH.$this->input->post("front_image"),FCPATH.$update_data['front_image']);
					rename(str_replace(".jpg","_mini.jpg",FCPATH.$this->input->post("front_image")),str_replace(".jpg","_mini.jpg",FCPATH.$update_data['front_image']));
				}
				if ($update_data) {
					$this->seller_model->edit_property($property_id, $update_data);
					$admin_email_text = '<h3 style="color:#4c525e;">PROPERTY NEEDS APPROVAL</h3><p style="color:#848994;">'.$this->account['first_name'].' '.$this->account['last_name'].' added a new property. New property details will need to be approved. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					// $admin_emails = $this->seller_model->get_notified(110);
					$admin_emails = 'abaig4325@hotmail.com';
					$this->mailer->regular_email('Property Needs Approval', $admin_email_text, $admin_emails);
					$this->seller_model->add_notification($admin_emails, 'Property Needs Approval', $this->account['first_name'].' '.$this->account['last_name'].' added a new property. New property details will need to be approved.', 'property_review', $property_id);
					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', 'New  '.$this->input->post("type").' property added succesfully. Your listing will be activated shortly after our validation process.');
					$this->session->set_flashdata('notify_title', 'New Listing Property');
					if ($this->input->post("front_image")) {
						$this->session->set_flashdata('notify_image', base_url($update_data['front_image']));
					}
					$response["success"] = true;
					$response["redirect_to"] = cortiam_base_url('');
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Error!';
					$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}

		log_message("error", "End of response");

		log_message("error", "Error :" . $response);
		echo json_encode($response);die();
	}

	/**
	 * Add new property account
	 * @uses system_model::add_property To add details of agent account
	 *
	 * @return json true or false
	 */
	public function edit_property($property_id = null){
		if (!$property_id) {
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}else{
			if (!$current_prop_data = $this->seller_model->get_my_property($this->ion_auth->get_user_id(), $property_id)) {
				$response["fail"] = true;
				$response["fail_title"] = ' Permission Denied!';
				$response["fail_message"] = 'Selected property details cannot be edited because of permission issues, please refresh the page and try again.';
			}else{
				if (!$this->input->post("type")) {$response["errorfields"]['type'] = "Property Type";}
				if (!$this->input->post("sub_type")) {$response["errorfields"]['sub_type'] = "Property Type";}
				if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
				if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
				if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
				if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}
				if (!$this->input->post("land_size")) {$response["errorfields"]['land_size'] = "Land Size";}
				if (!$this->input->post("building_size")) {$response["errorfields"]['building_size'] = "Building Size";}
				if (!$this->input->post("built_date")) {$response["errorfields"]['built_date'] = "Build Date";}
				if (!$this->input->post("commission_rate")) {$response["errorfields"]['commission_rate'] = "Commission Rate";}
				if (!$this->input->post("contract_length")) {$response["errorfields"]['contract_length'] = "Contract Length";}
				if ($this->input->post("type") == "Residential") {
					if (!$this->input->post("bedroom")) {$response["errorfields"]['bedroom'] = "Bedroom Amount";}
					if (!$this->input->post("bathroom")) {$response["errorfields"]['bathroom'] = "Bathroom Amount";}
				}

				if(count($response["errorfields"])) {
					$response["fail"] = true;
					$response["fail_title"] = 'Required/Missing Fields!';
					$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
				}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
					if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
					if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
					if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
					if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
					$response["fail"] = true;
					$response["fail_title"] = 'Location Problem!';
					$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
				}else{
					$property_data = array(
						'latitude' => (($loc_data['latitude'])? $loc_data['latitude']:null),
						'longitude' => (($loc_data['longitude'])? $loc_data['longitude']:null),
						'seller_id' => $this->account['id'],
						'type' => (($this->input->post("type") == 'Residential')? $this->input->post("type"):'Commercial'),
						'sub_type' => $this->input->post("sub_type"),
						'address' => (($this->input->post("address"))? $this->input->post("address"):null),
						'unit' => (($this->input->post("unit"))? $this->input->post("unit"):null),
						'city' => (($this->input->post("city"))? $this->input->post("city"):null),
						'state' => (($this->input->post("state"))? $this->input->post("state"):null),
						'zipcode' => (($this->input->post("zipcode"))? $this->input->post("zipcode"):null),
						'land_size' => (($this->input->post("land_size"))? $this->input->post("land_size"):null),
						'building_size' => (($this->input->post("building_size"))? $this->input->post("building_size"):null),
						'built_date' => (($this->input->post("built_date"))? $this->input->post("built_date"):null),
						'bedroom' => (($this->input->post("bedroom"))? $this->input->post("bedroom"):null),
						'bathroom' => (($this->input->post("bathroom"))? $this->input->post("bathroom"):null),
						'commission_rate' => (($this->input->post("commission_rate"))? $this->input->post("commission_rate"):null),
						'contract_length' => (($this->input->post("contract_length"))? $this->input->post("contract_length"):null),
					);
					if ($current_prop_data['status'] == 'Inactivated') {
						$changed_array[] = '<strong>Withdrawed</strong> property re-activated';
					}
					if ($this->seller_model->edit_property($property_id, $property_data)) {
						unset($property_data['latitude']);
						unset($property_data['longitude']);
						unset($property_data['commission_rate']);
						unset($property_data['contract_length']);
						unset($property_data['seller_id']);
						$real_field_names = array(
							'type' => 'Main Property Type',
							'sub_type' => 'Property Type',
							'address' => 'Address',
							'unit' => 'Unit',
							'city' => 'City',
							'state' => 'State',
							'zipcode' => 'Zip Code',
							'land_size' => 'Land Size',
							'building_size' => 'Building Size',
							'built_date' => 'Build Year',
							'bedroom' => 'Bedroom Amount',
							'bathroom' => 'Bathroom Amount'
						);
						foreach ($property_data as $check_key => $check_value) {
							if ($current_prop_data[$check_key] != $check_value) {$changed_array[] = '<strong>'.$real_field_names[$check_key].'</strong> changed from '.$current_prop_data[$check_key].' to '.$check_value;}
						}
						if (count($changed_array)) {
							$this->seller_model->edit_property($property_id, array('status' => 'Pending'));
							$admin_email_text = '<h3 style="color:#4c525e;">PROPERTY NEEDS APPROVAL</h3><p style="color:#848994;">'.$this->account['first_name'].' '.$this->account['last_name'].' updated property details. New property details which needs to be approved are displayed below;<br>'.implode('<br>',$changed_array).'.</p><p>For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
							$admin_emails = $this->seller_model->get_notified(110);
							$this->mailer->regular_email('Property Needs Approval', $admin_email_text, $admin_emails);
							$this->seller_model->add_notification($admin_emails, 'Property Needs Approval', $this->account['first_name'].' '.$this->account['last_name'].' updated property details. New property details will need to be approved.', 'property_review', $property_id);
						}
						$this->session->set_flashdata('notify', 'success');
						$this->session->set_flashdata('notify_message', 'New  '.$this->input->post("type").' property details updated succesfully. Your listing will be activated shortly after our validation process.');
						$this->session->set_flashdata('notify_title', 'Listing Details Updated Successfully');
						if ($this->input->post("front_image")) {
							$this->session->set_flashdata('notify_image', base_url($this->input->post("front_image")));
						}
						$response["success"] = true;
						$response["redirect_to"] = cortiam_base_url('');
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'Error!';
						$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
					}
				}
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function get_map_location(){
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif(!$loc_data = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),$this->input->post("address"),$this->input->post("unit"))){
			if ($this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
			if ($this->input->post("city")) {$response["errorfields"]['city'] = "City";}
			if ($this->input->post("state")) {$response["errorfields"]['state'] = "State";}
			if ($this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "Zip Code";}
			$response["fail"] = true;
			$response["fail_title"] = 'Location Problem!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). 'System cannot locate the given address. Please check your address details and try again.';
		}else{
			$response["latitude"] = $loc_data['latitude'];
			$response["longitude"] = $loc_data['longitude'];
			$response["success"] = true;
		}
		echo json_encode($response);die();
	}


	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function create_avatar($avatar_string, $first_name, $last_name){
		$source_image = FCPATH.'images/avatar_base.jpg';
	  $folderPath = FCPATH.'images/avatar/';
	  $imagename = substr(basename($avatar_string),0,-4);

		$image = imagecreatefromjpeg($source_image);
		$white_color = imagecolorallocate($image, 255, 255, 255);

		$font_path = FCPATH.'assets/fonts/robotomono-bold.ttf';
		$size=80;
		$angle=0;
		$left=60;
		$top=165;

		@imagettftext($image, $size,$angle,$left,$top, $white_color, $font_path, $first_name[0].$last_name[0]);
		imagejpeg($image, $folderPath . $imagename . ".jpg", 80);
		$thubnail = imagecreatetruecolor(100, 100);
		imagecopyresampled($thubnail, $image, 0, 0, 0, 0, 100, 100, 250, 250);
		imagedestroy($image);
		imagejpeg($thubnail, $folderPath . $imagename . "_mini.jpg", 80);
		imagedestroy($thubnail);
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function upload_property_image($property_id = null){
		if ($property_id) {
		  $folderPath = FCPATH.'images/property/'.$property_id.'/';
		  $imagename = uniqid('prop_',true);
		  $return['avatarurl'] = base_url('images/property/').$property_id.'/'.$imagename.".jpg?ver=".rand(0,1000);
		  $return['avatar_string'] = 'images/property/'.$property_id.'/'.$imagename . ".jpg";
		}else{
		  $folderPath = FCPATH.'images/property/';
		  $imagename = uniqid('prop_',true);
		  $return['avatarurl'] = base_url('images/property/') . $imagename . ".jpg?ver=".rand(0,1000);
		  $return['avatar_string'] = 'images/property/'.$imagename . ".jpg";
		}
		if (!file_exists($folderPath)) {
	    mkdir($folderPath, 0755, true);
		}

	  $base64_string = str_replace(array('data:image/png;base64,',' '),array('','+'),$_POST['image']);
	 	$decoded = base64_decode($base64_string);

		$image = imagecreatefromstring($decoded);
		$bg = imagecreatetruecolor(1200, 900);
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		imagealphablending($bg, TRUE);
		imagecopy($bg, $image, 0, 0, 0, 0, 1200, 900);
		imagedestroy($image);
		$thubnail = imagecreatetruecolor(400, 300);
		imagejpeg($bg, $folderPath . $imagename . ".jpg", 80);
		imagecopyresampled($thubnail, $bg, 0, 0, 0, 0, 400, 300, 1200, 900);
		imagedestroy($bg);
		imagejpeg($thubnail, $folderPath . $imagename . "_mini.jpg", 80);
		imagedestroy($thubnail);

		switch ($this->input->post("current_image")) {
			case 'show_front_image':
				$return['next_image'] = 'show_rear_image';
				$uploaded_image_title = 'Outdoor Photo 1';
				break;
			case 'show_rear_image':
				$return['next_image'] = 'show_left_image';
				$uploaded_image_title = 'Outdoor Photo 2';
				break;
			case 'show_left_image':
				$return['next_image'] = 'show_right_image';
				$uploaded_image_title = 'Indoor Photo 1';
				break;
			default:
				$return['next_image'] = false;
				$uploaded_image_title = 'Indoor Photo 2';
				break;
		}


		if ($property_id && $this->input->post("type")) {
			$update[$this->input->post("type")] = $return['avatar_string'];
			$this->seller_model->edit_property($this->input->post("recordID"), $update);
			$is_updated = true;
		}

		$return["success"] = true;
		$return["success_title"] = 'Photo Uploaded Successfully';
		$return["success_message"] = $uploaded_image_title.' uploaded successfully. '.(($is_updated)? 'Please select and upload other images before adding your property.':'Please select and upload other images before adding your property.');

	  echo json_encode($return,true);
	}

	/**
	 * Add new property account
	 * @uses system_model::add_property To add details of agent account
	 *
	 * @return json true or false
	 */
	public function withdraw_form(){
		if (!$this->input->post("propertyID")) {
			$response["form"] = '<div class="modalform"><div class="card">
			  <div class="card-header header-elements-inline">
					<h3 class="card-title"><span class="icon-co-big white denied"></span> Processing Error</h3>
			  </div>
			  <div class="card-body"><p class="bigtext">System cannot locate selected listing. Please check your address details and try again.</p></div>
			  <div class="card-footer text-center">
					<button class="button-dark closemodal">Close</button>
			  </div>
			</div></div>';
		}else{
			if (!$property_details = $this->seller_model->get_my_property($this->ion_auth->get_user_id(), $this->input->post("propertyID"))) {
				$response["form"] = '<div class="modalform"><div class="card">
				  <div class="card-header header-elements-inline">
						<h3 class="card-title"><span class="icon-co-big white denied"></span> Permission Denied</h3>
				  </div>
				  <div class="card-body"><p class="bigtext">Selected property details cannot be edited because of permission issues, please refresh the page and try again.</p></div>
				  <div class="card-footer text-center">
						<button class="button-dark closemodal">Close</button>
				  </div>
				</div></div>';
			}else{
				$response["form"] = '<div class="modalform"><div class="card">
				  <div class="card-header header-elements-inline">
						<h3 class="card-title"><span class="icon-co-big white write"></span> Withdrawal Reason</h3>
				  </div>
				  <div class="card-body pb-0">
				  <form method="POST" class="withdrawform w-100" data-source="withdrawurl">
						<div class="row">
							<div class="col-md-12">
								<fieldset>
									<div class="form-group mb-0">
										<label>Please help us improving our system and enter your reason to withdraw your listing at '.(($property_details['unit'])? $property_details['unit'].' ':'').$property_details['address'].' '.$property_details['city'].', '.$property_details['state'].', '.$property_details['zipcode'].'.</label>
										<textarea rows="2" cols="3" maxlength="225"  name="withdrawal_reason" id="withdrawal_reason" class="form-control maxlength-textarea" placeholder="Enter your reason"></textarea>
										<input type="hidden" name="propertyID" value="'.$property_details['property_id'].'">
										<input type="hidden" name="redirect" value="'.$this->input->post("redirect").'">
									</div>
								</fieldset>
							</div>
						</div>
				  </form>
				  </div>
				  <div class="card-footer text-left">
						<button class="button-dark closemodal">Close</button>
						<input type="submit" class="button-orange float-right submitwithdraw" value="Submit">
				  </div>
				</div></div>';
			}
		}
	  echo json_encode($response,true);
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function withdraw_listing(){
		if (!$this->input->post("withdrawal_reason")) {$response["errorfields"]['withdrawal_reason'] = "Withdrawal Reason";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = 'Please fill out the reason field and try again.';
		}elseif(!$property_details = $this->seller_model->get_my_property($this->ion_auth->get_user_id(), $this->input->post("propertyID"))){
			$response["fail"] = true;
			$response["fail_title"] = 'Permission Denied';
			$response["fail_message"] = 'Selected property details cannot be edited because of permission issues, please refresh the page and try again.';
		}else{
			$property_data = array(
				'withdrawal_reason' => (($this->input->post("withdrawal_reason"))? $this->input->post("withdrawal_reason"):null),
				'status' => 'Inactivated',
			);
			$this->seller_model->edit_property($this->input->post("propertyID"), $property_data);
			if ($clear_proposals = $this->seller_model->get_clear_proposals($this->input->post("propertyID"))) {
				foreach ($clear_proposals as $clear_proposal) {
					if ($clear_proposal['prop_from'] == 'Seller') {
						$update_prop = array('status' => 'Widthdrawn');
					}else{
						$update_prop = array('status' => 'Declined');
					}
					$this->seller_model->edit_proposal($clear_proposal['prop_id'], $update_prop);
					$user_email_text = '<h3 style="color:#4c525e;">PROPERTY IS WITHDRAWN</h3><h4 style="color:#848994;">Dear '.$clear_proposal['first_name'].' '.$clear_proposal['last_name'].'</h4><p>We are sorry to tell you that property owner of property at '.$clear_proposal['city'].', '.$clear_proposal['state'].' has removed property from listing. For more information please login Cortiam to check your offer details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					if ($clear_proposal['notifications'] == 'Yes') {
						$this->mailer->regular_email('Property Is Withdrawn', $user_email_text, $clear_proposal['email']);
					}
					$this->seller_model->add_notification($clear_proposal['agent_id'], 'Property Is Withdrawn', 'We are sorry to tell you that property owner of property at '.$clear_proposal['city'].', '.$clear_proposal['state'].' has removed property from listing.');
				}
			}
			$response["success"] = true;
			if ($this->input->post("redirect") == 'Yes') {
				$response["redirect_to"] = cortiam_base_url('');
			}
			$response["success_title"] = 'Withdrawal Successfully Completed';
			$response["success_message"] = 'Thank you for your interest. Your listing at '.(($property_details['unit'])? $property_details['unit'].' ':'').$property_details['address'].' '.$property_details['city'].', '.$property_details['state'].', '.$property_details['zipcode'].' inactivated succesfully.';
		}
		echo json_encode($response);die();
	}


	/**
	 * Add new property account
	 * @uses system_model::add_property To add details of agent account
	 *
	 * @return json true or false
	 */
	public function request_approval(){
		if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Request Approval Reason";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Field!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field is required. Please fill out all the required field and try again.';
		}else{
				$timestamp = time();
				$approval_data = array(
					'seller_id' => $this->ion_auth->get_user_id(),
					'message_date' => $timestamp,
					'message_text' => $this->security->xss_clean($this->input->post("message_text")),
					'type' => 'User',
				);
				if ($this->ion_auth->update($this->ion_auth->get_user_id(), array('approval' => 'Waiting', 'approval_date' => $timestamp))) {
				$this->seller_model->add_approval($approval_data);

				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', 'Your approval request submitted succesfully. Please check back your profile soon for further information about your approval process.');
				$this->session->set_flashdata('notify_title', 'Approval Request Submitted Successfully');
				$response["success"] = true;
				$response["redirect_to"] = cortiam_base_url('');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}


	/**
	 * Add new property account
	 * @uses system_model::add_property To add details of agent account
	 *
	 * @return json true or false
	 */
	public function request_property_approval($property_id){
		if (!$property_id) {
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}else{
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Request Approval Reason";}

			if(count($response["errorfields"])) {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Field!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field is required. Please fill out all the required field and try again.';
			}else{
					$timestamp = time();
					$approval_data = array(
						'seller_id' => $this->ion_auth->get_user_id(),
						'property_id' => $property_id,
						'message_date' => $timestamp,
						'message_text' => $this->security->xss_clean($this->input->post("message_text")),
						'type' => 'User',
					);
					if ($this->seller_model->edit_property($property_id, array('status' => 'Pending', 'approval_date' => $timestamp))) {
					$this->seller_model->add_approval($approval_data);

					$this->session->set_flashdata('notify', 'success');
					$this->session->set_flashdata('notify_message', 'Your approval request submitted succesfully. Please check back your listing soon for further information about your approval process.');
					$this->session->set_flashdata('notify_title', 'Approval Request Submitted Successfully');
					$response["success"] = true;
					$response["redirect_to"] = cortiam_base_url('');
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Error!';
					$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
				}
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function counter_offer_form(){
		if ($this->input->post("proposal_id")) {
			if ($proposal = $this->seller_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))) {
				if($agreement_check = $this->seller_model->check_for_agreement($proposal['property_id'])){
					$response["fail"] = true;
					$response["fail_title"] = 'Currently Not Available';
					$response["fail_message"] = 'Another real estate agent accepted your offer for this property. If this agent agree on contract before negotation time ends ( '.date('Y/m/d h:i:s A',$agreement_check['expire_time']).'), you will be able to accept this offer. Otherwise this proposal will terminated automatically.';
				}else{
					$response["success"] = true;
					$response["form"] = '<h3 class="text-center">COUNTERED OFFER</h3><div class="card">
					  <div class="card-body p-2 border-bottom">
							<div class="row">
								<div class="col-md-6 font-weight-bold text-center border-right"><span class="text-secondary">Commission Rate</span><br>'.$proposal['commission_rate'].' %</div>
								<div class="col-md-6 font-weight-bold text-center"><span class="text-secondary">Length of Contract</span><br>'.$proposal['contract_length'].' months</div>
							</div>
						</div>
					</div>
					<h3 class="text-center mt-2">SEND COUNTER OFFER</h3><form id="offer-form"><div class="card">
				  <div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<select name="commission_rate" id="commission_rate" required>
									<option value="" disabled selected>Commission Rate %</option>';
									$comm_rate = 3;
									while($comm_rate <= 6) {
										$response["form"] .= '<option value="'.$comm_rate.'">'.$comm_rate.' %</option>';
										$comm_rate += 0.5;
									}
								$response["form"] .= '</select>
							</div>
							<div class="col-md-6">
								<select name="contract_length" id="contract_length" required>
									<option value="" disabled selected>Length of Contract</option>';
									$months = 1;
									while($months <= 12) {
										$response["form"] .= '<option value="'.$months.'">'.$months.' Months</option>';
										$months++;
									}
								$response["form"] .= '</select>
							</div>
						</div>
						<hr>
						<div class="row">
							<div class="col-md-12">
								<textarea rows="2" cols="3" maxlength="225"  name="message" id="message" class="form-control maxlength-textarea" placeholder="Your Message"></textarea>
							</div>
						</div>
				  </div>
				  <div class="card-footer text-right">
			  		<a class="button-dark float-left text-center" id="cancel-counter-offer">CANCEL</a>
				  	<a class="button-orange text-center" id="send-counter-offer" data-prop="'.$proposal['prop_id'].'">SEND YOUR OFFER</a>
				  </div>
					</div></form>';
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function send_counter_offer(){
		if ($this->input->post("proposal_id")) {
			if (!$this->input->post("commission_rate")) {$response["errorfields"]['commission_rate'] = "Commission Rate";}
			if (!$this->input->post("contract_length")) {$response["errorfields"]['contract_length'] = "Length of Contract";}
			if (!$this->input->post("message")) {$response["errorfields"]['message'] = "Your Message";}

			if(count($response["errorfields"])) {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}elseif(!$proposal = $this->seller_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Proposal Cannot Found!';
				$response["fail_message"] = 'The proposal you counter offer is currently not active or cannot be found, please refresh the page and try again.';
			}else{
				$msg_data = array(
					'base_id' => (($proposal['base_id'])? $proposal['base_id']:(($proposal['main_id'])? $proposal['main_id']:null)),
					'main_id' => $proposal['prop_id'],
					'property_id' => $proposal['property_id'],
					'seller_id' => $proposal['seller_id'],
					'agent_id' => $proposal['agent_id'],
					'prop_from' => 'Seller',
					'prop_to' => 'Agent',
					'prop_text' => $this->input->post("message"),
					'prop_date' => time(),
					'commission_rate' => $this->input->post("commission_rate"),
					'contract_length' => $this->input->post("contract_length"),
				);
				if($new_proposal_id = $this->seller_model->add_proposal($msg_data)){
					$this->seller_model->edit_proposal($proposal['prop_id'], array('status' => 'Countered'));
					if (in_array($proposal['status'], array('Read','Unread','Counter Offer'))){
						$this->seller_model->add_count($proposal['agent_id'], 'offer_remain', '+1');
					}

					$agent_account = $this->seller_model->get_agent($proposal['agent_id']);
					$user_email_text = '<h3 style="color:#4c525e;">NEW COUNTER OFFER</h3><h4 style="color:#848994;">Dear '.$agent_account['first_name'].' '.$agent_account['last_name'].'</h4><p>We are happy to tell you that the property owner at '.$proposal['city'].' '.$proposal['state'].' sent you a new counter offer. For more information please login to Cortiam to check this offer details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					if ($agent_account['notifications'] == 'Yes') {
						$this->mailer->regular_email('New Counter Offer For You', $user_email_text, $agent_account['email']);
					}
					$this->seller_model->add_notification($proposal['agent_id'], 'New Counter Offer For You', 'We are happy to tell that property owner of property at '.$proposal['city'].' '.$proposal['state'].' sent you a new counter offer.');

					$new_proposal = $this->seller_model->get_proposal($this->ion_auth->get_user_id(), $new_proposal_id);

					$response["success"] = true;
					$response["success_title"] = 'Counter Offer Sent Successfully!';
					$response["success_message"] = 'Your counter offer was sent successfully to the real estate agent. You will be notified when the  real estate agent responds to your offer.';

					$agent_experience = (date("Y") - $new_proposal['experience']);
					$response["newcard"] = '<div class="col-md-4 proplistingwrap">
						<a href="'.cortiam_base_url('view-interest/').$new_proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $new_proposal['first_name'].' '.$new_proposal['last_name'])), 'underscore', true).'" class="card proplisting mb-2">
							'.generate_seller_proposal_ribbon($new_proposal['prop_from'], 'Countered').'
						  <img class="card-img-top" src="'.(($new_proposal['avatar_string'])? base_url($new_proposal['avatar_string']):base_url('images/userphoto.jpg')).'" alt="Listing Image">
						  <div class="card-body orange-bg px-2">
						    <span class="float-left"><b>'.$new_proposal['first_name'].' '.$new_proposal['last_name'].'</b></span>
						    <small class="float-right">'.(($agent_experience > 1)? $agent_experience.' Years':$agent_experience.' Year').'</small>
						  </div>
						  <div class="card-footer addresspart p-2">
							  <strong>Address:</strong><p>'.$new_proposal['agent_address'].' '.$new_proposal['agent_city'].', '.$new_proposal['agent_state'].' '.$new_proposal['agent_zipcode'].'</p>
							  <strong>Phone:</strong><p>'.$new_proposal['agent_phone'].'</p>
						  </div>
						</a>
							<div class="px-2">
							  <button class="button-orange smallerbutton button-disabled text-center float-left">ACCEPT</button>
							  <button class="button-gray smallerbutton button-disabled text-center float-right">DECLINE</button>
							  <button class="button-dark w-100 smallerbutton text-center float-right mt-2 withdrawproposal" data-prop="'.$new_proposal['prop_id'].'">WITHDRAW</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="'.cortiam_base_url('agent-profile/').$new_proposal['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $new_proposal['first_name'].' '.$new_proposal['last_name'])), 'underscore', true).'">View Agent Profile</a>
							</div>
				  </div>';

				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function accept_proposal(){
		if ($this->input->post("proposal_id")) {
			if(!$proposal = $this->seller_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Proposal Cannot Found!';
				$response["fail_message"] = 'The proposal you counter offer is currently not active or cannot be found, please refresh the page and try again.';
			}else{
				if($agreement_check = $this->seller_model->check_for_agreement($proposal['property_id'])){
					$response["fail"] = true;
					$response["fail_title"] = 'Currently Not Available';
					$response["fail_message"] = 'Another real estate agent accepted your offer for this property. If this agent agree on contract before negotation time ends ( '.date('Y/m/d h:i:s A',$agreement_check['expire_time']).'), you will be able to accept this offer. Otherwise this proposal will terminated automatically.';
				}else{
					$msg_data = array(
						'status' => 'Accepted',
					);
					if($this->seller_model->edit_proposal($proposal['prop_id'],$msg_data)){
						$agent_account = $this->seller_model->get_agent($proposal['agent_id']);
						if ($proposal['winning_fee']) {
					 		$fee_amount = $proposal['winning_fee'];
						}elseif ($agent_account['win_cost']) {
					 		$fee_amount = $agent_account['win_cost'];
						}else{
							$fee = $this->seller_model->get_state_cost($this->ion_auth->get_user_id(),$proposal['property_id']);
							$fee_amount = $fee['cost'];
						}
						$aggreement_data = array(
							'prop_id' => $proposal['prop_id'],
							'agent_id' => $proposal['agent_id'],
							'seller_id' => $proposal['seller_id'],
							'agr_fee' => $fee_amount,
							'expire_time' => ((86400*2) + time()),
							'payment_status' => 'Waiting',
							'agr_status' => 'Open',
						);
						$this->seller_model->add_agreement($aggreement_data);
						$this->seller_model->add_count($proposal['agent_id'], 'offer_remain', '+1');
						$user_email_text = '<h3 style="color:#4c525e;">YOUR OFFER ACCEPTED</h3><h4 style="color:#848994;">Dear '.$agent_account['first_name'].' '.$agent_account['last_name'].',</h4><p>Congratulations! The property owner of '.$proposal['city'].', '.$proposal['state'].' has accepted you as their Agent! In just a few steps, you will be able to contact your customer and start selling their home! All that\'s left is for you to log in to your Cortiam Account and purchase the Agreement. To make sure we provide an excellent experience for our property owners, you will have 48 hours to pay for the Agreement. If the Agreement is not purchased in 48 hours, we will inform the seller that their property has been returned to the available listing section.  We have created an agreement for your final review. Please login to complete and process the payment.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
						if ($agent_account['notifications'] == 'Yes') {
							$this->mailer->regular_email('Congratulations! A Seller Has ACCEPTED YOU as their Agent!', $user_email_text, $agent_account['email']);
						}
						$this->seller_model->add_notification($proposal['agent_id'], 'Your Offer Accepted', 'We are happy to tell you that property owner of property at '.$proposal['city'].', '.$proposal['state'].' accepted your offer. We have created an agreement for your final review and complete the payment.');
						$seller_email_text = '<h3 style="color:#4c525e;">Congratulations!</h3><p>Congratulations on finding your Agent! Please allow up to 48 hours for your Agent to contact you and begin the selling process.</p><p>Because selling your home on your terms, feels right!<br>Cortiam Team</p><p>If your agent does not contact you within 48 hours please email <a href="mailto:customerservice@cortiam.com">customerservice@cortiam.com</a></p>';
						$this->mailer->regular_email('Congratulations on finding your Agent!', $seller_email_text, $this->account['email']);
						$this->seller_model->add_notification($proposal['seller_id'], 'Congratulations! Next steps.', 'Congratulations on finding your Agent! Please allow up to 48 hours for your Agent to contact you and begin the selling process.');


						$response["redirect_to"] = cortiam_base_url('agreements');
						$response["success"] = true;
						$response["success_title"] = 'Congratulations!';
						$response["success_message"] = 'You have successfully accepted offer. You will be notified when the agent completes the agreement period.';
						$agent_experience = (date("Y") - $proposal['experience']);
						$response["newcard"] = '<div class="col-md-4 proplistingwrap" id="props-'.$proposal['prop_id'].'">
								<a href="'.cortiam_base_url('view-interest/').$proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true).'" class="card proplisting mb-2">
									'.generate_seller_proposal_ribbon($proposal['prop_from'], 'Accepted').'
								  <img class="card-img-top" src="'.base_url($proposal['avatar_string']).'" alt="Listing Image">
								  <div class="card-body orange-bg px-2">
								    <span class="float-left"><b>'.$proposal['first_name'].' '.$proposal['last_name'].'</b></span>
						    		<small class="float-right">'.(($agent_experience > 1)? $agent_experience.' Years':$agent_experience.' Year').'</small>
								  </div>
								  <div class="card-footer addresspart p-2">
									  <strong>Address:</strong><p>'.$proposal['agent_address'].' '.$proposal['agent_city'].', '.$proposal['agent_state'].' '.$proposal['agent_zipcode'].'</p>
									  <strong>Phone:</strong><p>'.$proposal['agent_phone'].'</p>
								  </div>
								</a>
								<div class="px-2">
								  <button class="button-orange smallerbutton button-disabled text-center float-left">ACCEPT</button>
								  <button class="button-gray smallerbutton button-disabled text-center float-right">DECLINE</button>
								  <button class="button-border-gray w-100 smallerbutton button-disabled text-center float-right mt-2">COUNTER OFFER</button>
								  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="'.cortiam_base_url('agent-profile/').$proposal['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true).'">View Agent Profile</a>
								</div>
					  </div>';
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'Unexpected Error!';
						$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
					}
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function decline_proposal(){
		if ($this->input->post("proposal_id")) {
			if(!$proposal = $this->seller_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Proposal Cannot Found!';
				$response["fail_message"] = 'The proposal you counter offer is currently not active or cannot be found, please refresh the page and try again.';
			}else{
				$msg_data = array(
					'status' => 'Declined',
				);
				if($this->seller_model->edit_proposal($proposal['prop_id'],$msg_data)){
					$this->seller_model->add_count($proposal['agent_id'], 'offer_remain', '+1');
					$agent_account = $this->seller_model->get_agent($proposal['agent_id']);
					$user_email_text = '<h3 style="color:#4c525e;">YOUR OFFER DECLINED</h3><h4 style="color:#848994;">Dear '.$agent_account['first_name'].' '.$agent_account['last_name'].'</h4><p>We are sorry to tell you that property owner of property at '.$proposal['city'].', '.$proposal['state'].' declined your offer. For more information please login Cortiam to check your offer details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					if ($agent_account['notifications'] == 'Yes') {
						$this->mailer->regular_email('Your Offer Declined', $user_email_text, $agent_account['email']);
					}
					$this->seller_model->add_notification($proposal['agent_id'], 'Your Offer Declined', 'We are sorry to tell you that property owner of property at '.$proposal['city'].', '.$proposal['state'].' has declined your offer.');

					$response["success"] = true;
					$response["success_title"] = 'Completed Successfully!';
					$response["success_message"] = 'You have successfully declined real estate agents offer.';
					$agent_experience = (date("Y") - $proposal['experience']);
					$response["newcard"] = '<div class="col-md-6 col-lg-4 proplistingwrap" id="props-'.$proposal['prop_id'].'">
						<a href="'.cortiam_base_url('view-interest/').$proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true).'" class="card proplisting mb-2 '.((in_array($proposal['status'], array('Countered','Declined','Withdrawn')))? 'grayout':'').'">
							'.generate_seller_proposal_ribbon($proposal['prop_from'], 'Declined').'
						  <img class="card-img-top" src="'.base_url($proposal['avatar_string']).'" alt="Listing Image">
						  <div class="card-body orange-bg px-2">
						    <span class="float-left"><b>'.$proposal['first_name'].' '.$proposal['last_name'].'</b></span>
						    <small class="float-right">'.(($agent_experience > 1)? $agent_experience.' Years':$agent_experience.' Year').'</small>
						  </div>
						  <div class="card-footer addresspart p-2">
							  <strong>Address:</strong><p>'.$proposal['agent_address'].' '.$proposal['agent_city'].', '.$proposal['agent_state'].' '.$proposal['agent_zipcode'].'</p>
							  <strong>Phone:</strong><p>'.$proposal['agent_phone'].'</p>
						  </div>
						</a>
							<div class="px-2">
							  <button class="button-orange smallerbutton button-disabled text-center float-left">ACCEPT</button>
							  <button class="button-gray smallerbutton button-disabled text-center float-right">DECLINE</button>
							  <button class="button-border-gray w-100 smallerbutton text-center float-right mt-2 counterofferproposal" data-prop="'.$proposal['prop_id'].'">COUNTER OFFER</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="'.cortiam_base_url('agent-profile/').$proposal['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['first_name'].' '.$proposal['last_name'])), 'underscore', true).'">View Agent Profile</a>
							</div>
				  </div>';
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function withdraw_proposal(){
		if ($this->input->post("proposal_id")) {
			if(!$proposal = $this->seller_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Proposal Cannot Found!';
				$response["fail_message"] = 'The proposal you want to widthdraw is currently not active or cannot be found, please refresh the page and try again.';
			}else{
				if ($proposal['prop_from'] == 'Seller') {
					$msg_data = array(
						'status' => 'Withdrawn',
					);
					if($this->seller_model->edit_proposal($proposal['prop_id'],$msg_data)){
						$agent_account = $this->seller_model->get_agent($proposal['agent_id']);
						$user_email_text = '<h3 style="color:#4c525e;">OFFER IS WITHDRAWN</h3><h4 style="color:#848994;">Dear '.$agent_account['first_name'].' '.$agent_account['last_name'].'</h4><p>We are sorry to tell you that property owner of property at '.$proposal['city'].', '.$proposal['state'].' withdraw offer for this property. For more information please login Cortiam to check your offer details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
						if ($agent_account['notifications'] == 'Yes') {
							$this->mailer->regular_email('Offer Is Withdrawn', $user_email_text, $agent_account['email']);
						}
						$this->seller_model->add_notification($proposal['agent_id'], 'Offer Is Withdrawn', 'We are sorry to tell you that property owner of property at '.$proposal['city'].', '.$proposal['state'].' has withdrawn the offer for this property.');

						$response["success"] = true;
						$response["success_title"] = 'Completed Successfully!';
						$response["success_message"] = 'You have successfully withdrawn your offer for this property.';
						$response["newcard"] = '';
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'Unexpected Error!';
						$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
					}
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Requested Proposal Cannot Found';
					$response["fail_message"] = 'Requested proposal cannot be found. Please check your URL and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function message_form(){
		if ($this->input->post("agent_id")) {
			if ($proposal = $this->seller_model->get_agent($this->input->post("agent_id"))) {
				$response["success"] = true;
				$response["form"] = '<h3 class="text-center">SEND MESSAGE</h3><form id="offer-form"><div class="card">
			  <div class="card-body">
					<div class="row">
						<div class="col-md-12">
							<textarea rows="2" cols="3" maxlength="225"  name="message_text" id="message_text" class="form-control maxlength-textarea" placeholder="Enter your message..."></textarea>
						</div>
					</div>
			  </div>
			  <div class="card-footer text-right">
		  		<a class="button-dark float-left text-center" id="cancel-message-now">CANCEL</a>
			  	<a class="button-orange text-center" id="send-message-now">SEND MESSAGE</a>
			  </div>
				</div></form>';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function favorite_agent(){
		if ($this->input->post("agent_id") && $this->input->post("value")) {
			$save_status = $this->seller_model->get_favorite_value($this->account['id'],$this->input->post("agent_id"));
			if ($this->input->post("value") == 'add') {
				if ($save_status) {
					$response["fail"] = true;
					$response["fail_title"] = 'Already Favorited!';
					$response["fail_message"] = 'Selected agent already added to your favorite list at '.date('Y/m/d h:i:s A', $save_status['save_time']).'.';
					$response["buttonvalue"] = 'remove';
					$response["buttonicon"] = '<i class="icon-heart-broken2 '.(($this->input->post("bigger"))? 'icon-2x':'').'"></i>';
				}else{
					$this->seller_model->favorite_agent($this->account['id'],$this->input->post("agent_id"));
					$agent = $this->seller_model->get_agent($this->input->post("agent_id"));
					$response["success"] = true;
					$response["success_title"] = 'Agent Favorited';
					$response["success_message"] = 'Selected agent added to your favorite agents list succesfully.';
					$response["buttonvalue"] = 'remove';
					$agent['favorited'] = true;
					$response["addagent"] = generate_agent_card($agent);
					$response["buttonicon"] = '<i class="icon-heart-broken2 '.(($this->input->post("bigger"))? 'icon-2x':'').'"></i>';

					$this->seller_model->add_notification($this->input->post("agent_id"), 'Added To Favorites', ' One of the property owners you are interested in  favorited your real estate agent profile.');
				}
			}else{
				$this->seller_model->unfavorite_agent($this->account['id'],$this->input->post("agent_id"));
				$response["success"] = true;
				$response["success_title"] = 'Agent Removed From Favorites';
				$response["success_message"] = 'Selected agent removed from your favorite agents list succesfully.';
				$response["buttonvalue"] = 'add';
				$response["removeagent"] = 'favagent-'.$this->input->post("agent_id");
				$response["buttonicon"] = '<i class="icon-heart5 '.(($this->input->post("bigger"))? 'icon-2x':'').'"></i>';
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function send_message(){
		if ($this->input->post("agent_id")) {
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Your Message";}

			if(count($response["errorfields"])) {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}else{
				$msg_data = array(
					'seller_id' => $this->ion_auth->get_user_id(),
					'agent_id' => $this->input->post("agent_id"),
					'msg_from' => 'Seller',
					'msg_to' => 'Agent',
					'message_text' => $this->input->post("message_text"),
					'message_date' => time(),
				);
				if($this->seller_model->add_message($msg_data)){
					$response["success"] = true;
					$response["success_title"] = 'Sent Successfully!';
					$response["success_message"] = 'Your message was sent successfully. You will be notified when the agent responds to your message.';
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function send_message_to($agent_id = null){
		if ($agent = $this->seller_model->get_agent($agent_id)){
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Your Message";}

			if(count($response["errorfields"])) {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}else{
				$msg_data = array(
					'seller_id' => $this->ion_auth->get_user_id(),
					'agent_id' => $agent['agent_id'],
					'msg_from' => 'Seller',
					'msg_to' => 'Agent',
					'message_text' => $this->input->post("message_text"),
					'message_date' => time(),
				);
				if($this->seller_model->add_message($msg_data)){
					$response["success"] = true;
					$response["success_title"] = 'Send Successfully!';
					$response["success_message"] = 'Your message send successfully. You will be notified when property owner response for your message.';
					$response["redirect_to"] = cortiam_base_url('view-messages/').$agent['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agent['first_name'].' '.$agent['last_name'])), 'underscore', true);
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function accept_agreement(){
		if ($this->input->post("agree_id")) {
			if(!$agreement = $this->seller_model->get_aggrement($this->ion_auth->get_user_id(), $this->input->post("agree_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Agreement Cannot Found!';
				$response["fail_message"] = 'The agreement you want to accept is currently not active or cannot be found, please refresh the page and try again.';
			}else{
				$current_time = time();
				$agr_data = array(
					'seller_response' => 'Accepted',
					'seller_date' => $current_time,
				);
				if(($agreement['agent_response'] == 'Accepted') && ($agreement['payment_status'] == 'Completed')){
					$agr_data[''] = 'Completed';
				}
				if($this->seller_model->edit_agreement($agreement['agr_id'],$agr_data)){
					$agent_account = $this->seller_model->get_agent($agreement['agent_id']);
					$user_email_text = '<h3 style="color:#4c525e;">AGREEMENT ACCEPTED</h3><h4 style="color:#848994;">Dear '.$agent_account['first_name'].' '.$agent_account['last_name'].'</h4><p>We are happy to tell you that the property owner accepted the agreement. For more information please login to Cortiam to check the agreement details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					if ($agent_account['notifications'] == 'Yes') {
						$this->mailer->regular_email('Agreement Accepted', $user_email_text, $agent_account['email']);
					}
					$this->seller_model->add_notification($agreement['agent_id'], 'Agreement Accepted', ' We are happy to tell you that the property owner accepted the agreement.');

					$response["success"] = true;
					$response["success_title"] = 'Completed Successfully!';
					$response["success_message"] = 'You have successfully accepted selected agreement.';
					$response["newcard"] = '<div class="col-md-4" id="props-'.$agreement['agr_id'].'">
					<div class="card proplisting mb-2">
						'.generate_agreement_ribbon('Accepted', $agreement['expire_time']).'
					  <img class="card-img-top" src="'.base_url($agreement['default_image']).'" alt="Listing Image">
					  <div class="card-body orange-bg px-2">
					    <span class="float-left">'.$agreement['state'].'</span>
					    <span class="float-right">'.$agreement['city'].'</span>
					  </div>
					  <div class="card-footer addresspart p-2">
						  <strong>Commission Rate:</strong><p>'.$agreement['commission_rate'].'</p>
						  <strong>Contract Length:</strong><p>'.$agreement['contract_length'].' Months</p>
					  </div>
					</div>';
					if($agreement['seller_response'] == 'Accepted'){
						$response["newcard"] .= '<div class="px-2 text-center"><a href="'.cortiam_base_url('view-messages/').$agreement['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agreement['agent'])), 'underscore', true).'" class="button-orange smallerbutton text-center">CHAT</a></div></div>';
					}else{
						$response["newcard"] .= '<div class="px-2 text-center"></div></div>';
					}
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
				}
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	public function deactivate_me(){
		if($this->input->post("recordID")) {
			$data = array(
				'active' => 0,
				'email' => uniqid('email_').uniqid().'@deleted.com',
				'deleted_email' => $this->account['email'],
			);
			if ($hesapid = $this->ion_auth->update($this->account['id'], $data)) {
				$this->seller_model->collect_trash($this->account['id']);
				$response["success"] = true;
				$logout = $this->ion_auth->logout();
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				$response["redirect_to"] =  base_url('login');
				$response["success_title"] = 'Deactivated Succesfully';
				$response["success_message"] = 'Your account deactivated succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function send_support(){
		if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Your Message";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}else{
			$msg_data = array(
				'seller_id' => $this->account['id'],
				'msg_from' => 'Seller',
				'message_text' => $this->input->post("message_text"),
				'message_date' => time(),
			);
			if($this->seller_model->add_support($msg_data)){
				$admin_email_text = '<h3 style="color:#4c525e;">PROPERTY OWNER SUPPORT REQUEST</h3><p style="color:#848994;">'.$this->account['first_name'].' '.$this->account['last_name'].' created new support request on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->seller_model->get_notified(140);
				$this->mailer->regular_email('Property Owner New Support Request', $admin_email_text, $admin_emails);
				$this->seller_model->add_notification($admin_emails, 'Property Owner New Support Request', $this->account['first_name'].' '.$this->account['last_name'].' created a new support request on Cortiam.', 'seller_support', $this->account['id']);
				$response["success"] = true;
				$response["success_title"] = 'Send Successfully!';
				$response["success_message"] = 'Your message send successfully. You will be notified when our support response for your message.';
				$response["redirect_to"] = cortiam_base_url('support-center/');
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function accept_tos(){
		if($this->input->post("tos_accepted")) {
			$additional_data = array(
				'accept_tos' => time(),
			);
			$this->seller_model->edit_seller($this->account['id'], $additional_data);
			$response["success"] = true;
			$response["success_title"] = 'Term Of Service';
			$response["success_message"] = 'Thank you for accepting our terms of service.';
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Error!';
			$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
		}
		echo json_encode($response);die();
	}
}
?>