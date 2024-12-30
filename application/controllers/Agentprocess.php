<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Agent Process controller
 *
 * The base controller which process page actions of the Cortiam Web Application Agent Panel
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

class Agentprocess extends CRTM_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('agent_model');
		$this->load->helper(array('frontend'));

		if ($this->ion_auth->logged_in() && ($this->ion_auth->get_user_type() == 'Agent'))	{
			$this->account = $this->agent_model->get_agent($this->ion_auth->get_user_id());
			$this->account['licenses'] = $this->agent_model->get_my_licenses($this->ion_auth->get_user_id());
		}else{
			die('No permission');
		}
	}

	/**
	 * Updates agent account details with submitted values
	 * @uses agent_model::get_terms_of_service Gets terms of service popup details
	 * @uses ion_auth::update Updates simple account details
	 * @uses agent_model::edit_agent Updates general agent details
	 *
	 * @return json Success|Fail details of agent account update action
	 */
	public function update_account(){

        try {
            $this->agent_model->delete_specializations_for_agent($this->ion_auth->get_user_id());
            $this->agent_model->add_specializations_for_agent($this->ion_auth->get_user_id(),$this->input->post("specializations"));
        } catch (Exception $e) {
        }


		if (!$this->account['avatar_string']) {$response["errorfields"]['editavatarstring'] = "Profile Photo";}
		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email";}
		if (!$this->input->post("phone")) {$response["errorfields"]['phone'] = "Phone Number";}
		if (!$this->input->post("address")) {$response["errorfields"]['address'] = "Address";}
		if (!$this->input->post("city")) {$response["errorfields"]['city'] = "City";}
		if (!$this->input->post("state")) {$response["errorfields"]['state'] = "State";}
		if (!$this->input->post("zipcode")) {$response["errorfields"]['zipcode'] = "ZIP Code";}
		if (!$this->input->post("experience")) {$response["errorfields"]['experience'] = "Business Start Date";}
		if (!$this->input->post("brokerage_name")) {$response["errorfields"]['brokerage_name'] = "Brokerage Name";}
		if (!$this->input->post("brokerage_address")) {$response["errorfields"]['brokerage_address'] = "Brokerage Address";}
		if (!$this->input->post("brokerage_city")) {$response["errorfields"]['brokerage_city'] = "Brokerage City";}
		if (!$this->input->post("brokerage_state")) {$response["errorfields"]['brokerage_state'] = "Brokerage State";}
		if (!$this->input->post("brokerage_zipcode")) {$response["errorfields"]['brokerage_zipcode'] = "Brokerage ZIP Code";}
		if (!$this->input->post("brokerage_phone")) {$response["errorfields"]['brokerage_phone'] = "Brokerage Phone Number";}

		if(!$this->account['accept_tos']) {
			$response["tos"] = true;
			$tos_content = $this->agent_model->get_terms_of_service();
			$response["tos_content"] = '<div id="tos_popup"><div id="tos_content"><h2>TERMS OF SERVICE</h2>'.$tos_content.'</div></div><div id="tos_action" class="disabled"><button type="submit" class="float-left button-danger"><b><i class="icon-cross2"></i></b> Decline</button><button type="submit" class="float-right button-success"><b><i class="icon-checkmark3"></i></b> Accept</button><div class="disablefornow" data-display="tooltip" data-placement="top" title="Please read the document to enable buttons"><span>Please read the document to enable buttons</span></div></div>';
		}elseif(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid ZIP Code';
			$response["fail_message"] = 'Your ZIP code format is invalid, please use a valid ZIP code and try again.';
		}elseif (!preg_match($this->config->item('zipcode_pattern'), $this->input->post("brokerage_zipcode"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid Brokerage ZIP Code';
			$response["fail_message"] = 'Your Brokerage ZIP code format is invalid, please use a valid ZIP code and try again.';
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
				'experience' => (($this->input->post("experience"))? $this->input->post("experience"):null),
				'bio' => (($this->input->post("bio"))? $this->input->post("bio"):null),
				'facebook' => (($this->input->post("facebook"))? add_link_scheme($this->input->post("facebook")):null),
				'linkedin' => (($this->input->post("linkedin"))? add_link_scheme($this->input->post("linkedin")):null),
				'twitter' => (($this->input->post("twitter"))? add_link_scheme($this->input->post("twitter")):null),
				'google' => (($this->input->post("google"))? add_link_scheme($this->input->post("google")):null),
				'instagram' => (($this->input->post("instagram"))? add_link_scheme($this->input->post("instagram")):null),
				'notifications' => (($this->input->post("notifications"))? ($this->input->post("notifications")):'No'),
				'estate_specialization' => (($this->input->post("estate_specialization"))? $this->input->post("estate_specialization"):null),
				'brokerage_name' => (($this->input->post("brokerage_name"))? $this->input->post("brokerage_name"):null),
				'brokerage_address' => (($this->input->post("brokerage_address"))? $this->input->post("brokerage_address"):null),
				'brokerage_unit' => (($this->input->post("brokerage_unit"))? $this->input->post("brokerage_unit"):null),
				'brokerage_city' => (($this->input->post("brokerage_city"))? $this->input->post("brokerage_city"):null),
				'brokerage_state' => (($this->input->post("brokerage_state"))? $this->input->post("brokerage_state"):null),
				'brokerage_zipcode' => (($this->input->post("brokerage_zipcode"))? $this->input->post("brokerage_zipcode"):null),
				'brokerage_phone' => (($this->input->post("brokerage_phone"))? $this->input->post("brokerage_phone"):null),
				'youtube_video' => (($this->input->post("youtube_video"))? $this->input->post("youtube_video"):null),
				'brokage_latitude' => (($brokage_loc_data['latitude'])? $brokage_loc_data['latitude']:null),
				'brokage_longitude' => (($brokage_loc_data['longitude'])? $brokage_loc_data['longitude']:null),
			);
			if ($hesapid = $this->ion_auth->update($this->account['id'], array('email' => $this->input->post("email")))) {
				$this->agent_model->edit_agent($this->account['id'], $additional_data);
				$response["success"] = true;
				$response["success_title"] = 'Your Account Details Updated';
				$response["success_message"] = 'Your account details were updated successfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Error!';
				$response["fail_message"] = (($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Changes agent account password
	 * @uses ion_auth::change_password Changes account password
	 *
	 * @return json Success|Fail details of password change action
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
	 * Uploads agent avatar
	 * @uses agent_model::edit_agent Updates general agent details
	 *
	 * @return json Success|Fail details of upload avatar action
	 */
	public function upload_avatar(){
	  $folderPath = FCPATH.'images/avatar/';
	  $imagename = uniqid('avatar_',true);
	  $return['avatarurl'] = base_url('images/avatar/') . $imagename . ".jpg?ver=".rand(0,1000);
	  $update['avatar_string'] = $return['avatar_string'] = 'images/avatar/'.$imagename . ".jpg";

	  $base64_string = str_replace(array('data:image/png;base64,',' '),array('','+'),$_POST['image']);
	 	$decoded = base64_decode($base64_string);

		$image = imagecreatefromstring($decoded);
		$bg = imagecreatetruecolor(250, 250);
		imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
		imagealphablending($bg, TRUE);
		imagecopy($bg, $image, 0, 0, 0, 0, 250, 250);
		imagedestroy($image);
		$thubnail = imagecreatetruecolor(100, 100);
		imagejpeg($bg, $folderPath . $imagename . ".jpg", 80);
		imagecopyresampled($thubnail, $bg, 0, 0, 0, 0, 100, 100, 250, 250);
		imagedestroy($bg);
		imagejpeg($thubnail, $folderPath . $imagename . "_mini.jpg", 80);
		imagedestroy($thubnail);

		if($this->account['avatar_string']){
			@unlink(FCPATH.$this->account['avatar_string']);
			@unlink(FCPATH.str_replace(".jpg","_mini.jpg",$this->account['avatar_string']));
		}

		$this->agent_model->edit_agent($this->account['id'], $update);

	  echo json_encode($return,true);
	}

	/**
	 * Requests approval for agent account
	 * @uses ion_auth::update Updates simple account details
	 * @uses agent_model::add_approval Adds approval request details
	 *
	 * @return json Success|Fail details of requesting approval action
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
					'agent_id' => $this->ion_auth->get_user_id(),
					'message_date' => $timestamp,
					'message_text' => $this->security->xss_clean($this->input->post("message_text")),
					'type' => 'User',
				);
				if ($this->ion_auth->update($this->ion_auth->get_user_id(), array('approval' => 'Waiting', 'approval_date' => $timestamp))) {
				$this->agent_model->add_approval($approval_data);

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
	 * Changes automatic payment details of agent account
	 * @uses agent_model::edit_agent Updates general agent details
	 *
	 * @return json Success|Fail details of change automatic payment action
	 */
	public function change_payment(){
		if (!$this->input->post("auto_payment")) {$response["errorfields"]['auto_payment'] = "Payment Type";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}else{
			$data['auto_payment'] = $this->input->post("auto_payment");
			if ($this->agent_model->edit_agent($this->account['id'], $data)) {
				$response["success"] = true;
				$response["success_title"] = 'Payment Method Changed';
				$response["success_message"] = 'Your account payment method updated succesfully.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Changes default payment details of agent account
	 * @uses agent_model::get_credit_card Gets credit card details
	 * @uses agent_model::edit_agent Updates general agent details
	 *
	 * @return json Success|Fail details of change default payment action
	 */
	public function set_payment(){
		if (!$this->input->post("payment_id")) {$response["errorfields"]['payment_id'] = "Payment ID";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}else{
			if ($card = $this->agent_model->get_credit_card($this->input->post("payment_id"))) {
				$data['payment_id'] = $card["payment_id"];
				if ($this->agent_model->edit_agent($this->account['id'], $data)) {
					if ($this->account['auto_payment'] == 'Yes') {$this->process_payments();}
					$response["success"] = true;
					$response["success_title"] = 'Default Payment Method Changed';
					$response["success_message"] = 'Your accounts default payment method updated succesfully.';
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
		}
		echo json_encode($response);die();
	}

	/**
	 * Adds new credit card to agent account
	 * @uses agent_model::add_credit_card Adds new credit card
	 * @uses agent_model::edit_agent Updates general agent details
	 *
	 * @return json Success|Fail details of adding new credit card action
	 */
	public function new_credit_card(){
		if (!$this->input->post("payment_id")) {$response["errorfields"]['payment_id'] = "Payment ID";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}else{
			require_once(APPPATH.'/third_party/stripe/init.php');
			\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
			try {
		  	$payment_method_details = \Stripe\PaymentMethod::retrieve($this->input->post("payment_id"));
				$card_data = array(
					'agent_id' => $this->account['id'],
					'payment_id' => $payment_method_details['id'],
					'brand' => card_names($payment_method_details['card']['brand']),
					'last_digit' => $payment_method_details['card']['last4'],
					'expire_date' => mktime(1,1,1,$payment_method_details['card']['exp_month'],1,$payment_method_details['card']['exp_year']),
					'added_on' => time()
				);
				$this->agent_model->add_credit_card($card_data);

				if (!$this->account['payment_id']) {
					$data['payment_id'] = $payment_method_details['id'];
					if ($this->agent_model->edit_agent($this->account['id'], $data)) {
						if ($this->account['auto_payment'] == 'Yes') {$this->process_payments();}
					}
				}
				$response["success"] = true;
				$response["success_title"] = 'Credit Card Added';
				$response["success_message"] = 'Your credit card with the last 4 digits ****'.$payment_method_details['card']['last4'].' was added as new payment method successfully.';
			} catch (Exception $e) {
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Deletes selected credit card to agent account
	 * @uses agent_model::get_credit_card Gets credit card details
	 * @uses agent_model::delete_credit_card Deletes selected credit card
	 *
	 * @return json Success|Fail details of deleting selected credit card action
	 */
	public function delete_card(){
		if (!$this->input->post("payment_id")) {$response["errorfields"]['payment_id'] = "Payment ID";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}else{
			if ($card = $this->agent_model->get_credit_card($this->input->post("payment_id"))) {
				$this->agent_model->delete_credit_card($card["card_id"]);
				require_once(APPPATH.'/third_party/stripe/init.php');
				$stripe = new \Stripe\StripeClient($this->config->item('stripe_secret'));
				try {
					$stripe->paymentMethods->detach($card["payment_id"],[]);
					$response["success"] = true;
					$response["success_title"] = 'Payment Method Removed';
					$response["success_message"] = 'Selected payment method removed from your account succesfully.';
				} catch (Exception $e) {
					$response["fail"] = true;
					$response["fail_title"] = 'Unexpected Error!';
					$response["fail_message"] = $e->getError()->message;
				}
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Returns generated new credit card form over stripe payment gateway
	 *
	 * @return json Success|Fail details of add new credit card form
	 */
	public function get_paymentform(){
		if ($this->account['stripe_id']) {
			require_once(APPPATH.'/third_party/stripe/init.php');
			\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
			$intent = \Stripe\SetupIntent::create(['customer' => $this->account['stripe_id']]);
			$response["success"] = true;
			$response["form"] = '<form id="setup-form">
							<h3 class="col-sm-12 text-center">Add New Credit Card</h3>
						  <div class="outcome"><div class="error" role="alert"></div></div>
						  <label>
						    <input type="text" id="cardholder-name" name="cardholder-name" class="field is-empty" placeholder="Jane Doe" />
						    <span><span>Name</span></span>
						  </label>
						  <label>
						    <input type="tel" id="cardholder-phone" name="cardholder-phone" class="field is-empty" placeholder="(123) 456-7890" />
						    <span><span>Phone number</span></span>
						  </label>
						  <label>
						    <div id="card-element" class="field is-empty"></div>
						    <span><span>Credit card number</span></span>
						  </label>
						  <button id="card-button" class="button-orange float-right" data-secret="'.$intent->client_secret.'">Save Card</button>
						  <button id="card-cancel-button" class="button-dark left" data-secret="'.$intent->client_secret.'">Cancel</button>
						</form>';
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Gets credit cards list of agent account
	 * @uses agent_model::get_credit_cards Gets list of credit card and details
	 *
	 * @return json Success|Fail details of getting credit cards list action
	 */
	public function get_my_cards(){
		$response["success"] = true;
		if ($credit_cards = $this->agent_model->get_credit_cards($this->account['id'])) {
			foreach ($credit_cards as $credit_card) {
			  $response["html"] .= '<li class="profile-list-item">
				  <div class="row no-gutters">
					  <div class="col-sm-9">
					  	<div class="float-left mr-2">'.card_icons($credit_card['brand']).'</div>
					  	<p class="titlepart"><strong>'.ucfirst($credit_card['brand']).' **** '.$credit_card['last_digit'].'</strong></p>
					  	<p class="subtitlepart">Expires on '.date('M Y', $credit_card['expire_date']).'</p>
				  	</div>
					  <div class="col-sm-3 align-middle text-right">
							<div class="btn-group dropleft '.(($credit_card['payment_id'] == $this->account['payment_id'])? 'invisible':'').'" data-toggle="tooltip" data-placement="left" title="Click for options">
								<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="cardopenmenu"><i class="icon-menu"></i></span>
								<div class="dropdown-menu">
									<button class="dropdown-item" type="button" id="deletemycard" data-id="'.$credit_card['card_id'].'">Delete</button>
									<button class="dropdown-item" type="button" id="setmycard" data-id="'.$credit_card['card_id'].'">Set As Default</button>
								</div>
							</div>
				  	</div>
				  	</div>
			  </li>';
			}
		}else{
			$response["html"] .= '<li class="list-group-item text-center">Please add your credit card to activate your payment system.</li>';
		}
		echo json_encode($response);die();
	}

	/**
	 * Gets favorited properties list of agent account
	 * @uses agent_model::get_saved_properties Gets list of saved properties by agent
	 * @uses agent_model::get_properties Gets list and details of properties by given criteria
	 *
	 * @return json Success|Fail details of getting list of favorired properties action
	 */
	public function get_favorite_properties(){
		if($saved_property_ids = $this->agent_model->get_saved_properties($this->account['id'],true)){
			$saved_properties  =	$this->agent_model->get_properties(array('list' => $saved_property_ids, 'limit' => 15));
			$response["html"] .= '<div class="row carousel justify-content-center">';
			foreach ($saved_properties as $saved_property) {
				$response["html"] .= generate_property_card($saved_property);
			}
			$response["html"] .= '</div>';
		}else{
			$response["html"] .= '<h4 class="p-5 text-center">Currently there is no property added to your saved listing.</h4>';
		}
		echo json_encode($response);die();
	}

	/**
	 * Process payment for selected invoice
	 * @uses agent_model::get_invoice Gets details of invoice
	 * @uses agent_model::get_first_coupon Gets first available agent coupon if any
	 * @uses agent_model::edit_coupon Updates agent coupon details
	 * @uses agent_model::edit_invoice Updates invoice details
	 * @uses agent_model::add_payment Adds details of new payment
	 *
	 * @param  integer $payment_id ID of selected invoice
	 * @return json Success|Fail details of processing payment action
	 */
	public function process_win_payment($payment_id){
		if ($invoice = $this->agent_model->get_invoice($payment_id)) {
			require_once(APPPATH.'/third_party/stripe/init.php');
			\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
				if ($this->account['auto_payment'] == 'Yes') {
					if ($coupon = $this->agent_model->get_first_coupon($invoice['agent_id'])) {
						if ($coupon['coupon_type'] == 'Amount') {
							$discount = $coupon['coupon_amount'];
							$final_amount = $invoice['final_amount'] = ($invoice['real_amount'] - $discount);
						}else{
							$discount = ($invoice['final_amount']/100) * $coupon['coupon_amount'];
							$final_amount = $invoice['final_amount'] = ($invoice['real_amount'] - $discount);
						}
						if ($final_amount < 0) { $final_amount = $invoice['final_amount'] =  0.01;}
						$coupon_id = $coupon['use_id'];
					}else{
						$final_amount = $invoice['final_amount'] = $invoice['real_amount'];
					}
				}
				$process_time = time();
				try {
				  $payment = \Stripe\PaymentIntent::create([
				    'amount' => ($invoice['final_amount']*100),
				    'currency' => 'usd',
				    'customer' => $invoice['stripe_id'],
				    'payment_method' => $invoice['payment_id'],
				    'description' => $invoice['payment_desc'],
				    'off_session' => true,
				    'confirm' => true,
				  ]);
				 	$payment_data = array(
				 	'invoice_id' => $invoice['invoice_id'],
				 	'log_time' => $process_time,
				 	'log_status' => 'Success',
				 	'log_response' => serialize($payment),
				 	);
				 	$invoice_data = array(
				 	'payment_time' => $process_time,
				 	'try_time' => $process_time,
				 	'final_amount' => $final_amount,
				 	'pay_id' => $payment->id,
				 	'invoice_status' => 'Completed',
				 	);
				 	if($coupon){
				 		$invoice_data['coupon_id'] = $coupon_id;
				 		$invoice_data['discount_amount'] = $discount;
				 		$coupon_data = array(
				 			'coupon_used' => 'Yes',
				 			'used_on' => $process_time,
				 		);
				 		$this->agent_model->edit_coupon($coupon_id, $coupon_data);
				 	}
				 	$return['success'] = true;
				} catch (Exception $e) {
				 	$payment_data = array(
				 	'invoice_id' => $invoice['invoice_id'],
				 	'log_time' => $process_time,
				 	'log_status' => 'Failed',
				 	'log_response' => $e->getError()->message,
				 	);
				 	$invoice_data = array(
				 	'try_time' => strtotime("+3 HOUR", $process_time),
				 	'try_amount' => 3,
				 	'invoice_status' => 'Failed',
				 	);
				 	$return['fail'] = true;
				 	$return['error'] = $e->getError()->message;
				}
			 	$this->agent_model->edit_invoice($invoice['invoice_id'], $invoice_data);
				$this->agent_model->add_payment($payment_data);
		}else{
		 	$return['fail'] = true;
		 	$return['error'] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		return $return;
	}


	/**
	 * Process payment for selected or all available open invoices
	 * @uses agent_model::get_invoices Gets list of open invoices
	 * @uses agent_model::get_invoice Gets details of invoice
	 * @uses agent_model::get_first_coupon Gets first available agent coupon if any
	 * @uses agent_model::edit_coupon Updates agent coupon details
	 * @uses agent_model::edit_invoice Updates invoice details
	 * @uses agent_model::add_invoice Adds details of new invoice
	 * @uses agent_model::add_payment Adds details of new payment
	 *
	 * @param  integer $payment_id ID of selected invoice
	 * @return void
	 */
	public function process_payments($payment_id = null){
		if (!$payment_id) {
			if ($invoices = $this->agent_model->get_invoices($this->account['id'])) {
				require_once(APPPATH.'/third_party/stripe/init.php');
				\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
				foreach ($invoices as $invoice) {
					if ($invoice['stripe_id'] && $invoice['payment_id']) {
							if ($coupon = $this->agent_model->get_first_coupon($invoice['agent_id'])) {
								if ($coupon['coupon_type'] == 'Amount') {
									$discount = $coupon['coupon_amount'];
									$final_amount = $invoice['final_amount'] = ($invoice['real_amount'] - $discount);
								}else{
									$discount = ($invoice['final_amount']/100) * $coupon['coupon_amount'];
									$final_amount = $invoice['final_amount'] = ($invoice['real_amount'] - $discount);
								}
								if ($final_amount < 0) { $final_amount = $invoice['final_amount'] =  0.01;}
								$coupon_id = $coupon['use_id'];
							}else{
								$final_amount = $invoice['final_amount'] = $invoice['real_amount'];
							}
							$process_time = time();
							try {
							  $payment = \Stripe\PaymentIntent::create([
							    'amount' => ($final_amount*100),
							    'currency' => 'usd',
							    'customer' => $invoice['stripe_id'],
							    'payment_method' => $invoice['payment_id'],
							    'description' => $invoice['payment_desc'],
							    'off_session' => true,
							    'confirm' => true,
							  ]);
							 	$payment_data = array(
								 	'invoice_id' => $invoice['invoice_id'],
								 	'log_time' => $process_time,
								 	'log_status' => 'Success',
								 	'log_response' => serialize($payment),
							 	);
							 	$invoice_data = array(
								 	'payment_time' => $process_time,
								 	'try_time' => $process_time,
							 		'final_amount' => $final_amount,
							 		'pay_id' => $payment->id,
								 	'invoice_status' => 'Completed',
							 	);
							 	if($coupon){
							 		$invoice_data['coupon_id'] = $coupon_id;
							 		$invoice_data['discount_amount'] = $discount;
							 		$coupon_data = array(
							 			'coupon_used' => 'Yes',
							 			'used_on' => $process_time,
							 		);
							 		$this->agent_model->edit_coupon($coupon_id, $coupon_data);
							 	}
							 	if ($invoice['payment_type'] == 'Membership') {
							 		$agent_details = $this->agent_model->get_agent($invoice['agent_id']);
							 		$update_date_to = (($agent_details['membership_due'])? strtotime("+1 month", $agent_details['membership_due']):strtotime("+1 month", $process_time));
							 		$used_expressions = $this->agent_model->get_offers_used($invoice['agent_id']);
								 	$additional_data = array(
								 	 'win_remain' => $agent_details['win_limit'],
								 	 'offer_remain' => ($agent_details['offer_limit'] - $used_expressions),
								 	 'membership_due' => $update_date_to,
								 	);
									$this->agent_model->edit_agent($invoice['agent_id'], $additional_data);
									$membership_fee = $this->agent_model->get_settings('membership_fee');

									$new_invoice['agent_id'] = $invoice['agent_id'];
									$new_invoice['try_time'] = ($update_date_to - 86400);
									$new_invoice['payment_desc'] = 'Cortiam Agent Monthly Subscription Price';
									$new_invoice['real_amount'] = (($agent_details['membership_fee'])? $agent_details['membership_fee']:$membership_fee['setting_value']);
									$this->agent_model->add_invoice($new_invoice);
							 	}
							} catch (Exception $e) {
							 	$payment_data = array(
								 	'invoice_id' => $invoice['invoice_id'],
								 	'log_time' => $process_time,
								 	'log_status' => 'Failed',
								 	'log_response' => $e->getError()->message,
							 	);
							 	$invoice_data = array(
								 	'try_time' => strtotime("+2 HOUR", $process_time),
								 	'try_amount' => ($invoice['try_amount']+1),
								 	'invoice_status' => 'Failed',
							 	);
							}
						 	$this->agent_model->edit_invoice($invoice['invoice_id'], $invoice_data);
							$this->agent_model->add_payment($payment_data);
					}
				}
			}
		}else{
			if ($invoice = $this->agent_model->get_invoice($payment_id)) {
				if ($invoice['stripe_id'] && $invoice['payment_id']) {
					require_once(APPPATH.'/third_party/stripe/init.php');
					\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
						if ($this->account['auto_payment'] == 'Yes') {
							if ($coupon = $this->agent_model->get_first_coupon($invoice['agent_id'])) {
								if ($coupon['coupon_type'] == 'Amount') {
									$discount = $coupon['coupon_amount'];
									$final_amount = $invoice['final_amount'] = ($invoice['real_amount'] - $discount);
								}else{
									$discount = ($invoice['final_amount']/100) * $coupon['coupon_amount'];
									$final_amount = $invoice['final_amount'] = ($invoice['real_amount'] - $discount);
								}
								if ($final_amount < 0) { $final_amount = $invoice['final_amount'] =  0.01;}
								$coupon_id = $coupon['use_id'];
							}else{
								$final_amount = $invoice['final_amount'] = $invoice['real_amount'];
							}
						}
						$process_time = time();
						try {
						  $payment = \Stripe\PaymentIntent::create([
						    'amount' => ($invoice['final_amount']*100),
						    'currency' => 'usd',
						    'customer' => $invoice['stripe_id'],
						    'payment_method' => $invoice['payment_id'],
						    'description' => $invoice['payment_desc'],
						    'off_session' => true,
						    'confirm' => true,
						  ]);
						 	$payment_data = array(
						 	'invoice_id' => $invoice['invoice_id'],
						 	'log_time' => $process_time,
						 	'log_status' => 'Success',
						 	'log_response' => serialize($payment),
						 	);
						 	$invoice_data = array(
						 	'payment_time' => $process_time,
						 	'try_time' => $process_time,
						 	'final_amount' => $final_amount,
						 	'pay_id' => $payment->id,
						 	'invoice_status' => 'Completed',
						 	);
						 	if($coupon){
						 		$invoice_data['coupon_id'] = $coupon_id;
						 		$invoice_data['discount_amount'] = $discount;
						 		$coupon_data = array(
						 			'coupon_used' => 'Yes',
						 			'used_on' => $process_time,
						 		);
						 		$this->agent_model->edit_coupon($coupon_id, $coupon_data);
						 	}
						 	if ($invoice['payment_type'] == 'Membership') {
						 		$agent_details = $this->agent_model->get_agent($invoice['agent_id']);
						 		$update_date_to = (($agent_details['membership_due'])? strtotime("+1 month", $agent_details['membership_due']):strtotime("+1 month", $process_time));
							 	$used_expressions = $this->agent_model->get_offers_used($invoice['agent_id']);
							 	$additional_data = array(
							 	 'win_remain' => $agent_details['win_limit'],
								 'offer_remain' => ($agent_details['offer_limit'] - $used_expressions),
							 	 'membership_due' => $update_date_to,
							 	);
								$this->agent_model->edit_agent($invoice['agent_id'], $additional_data);
								$membership_fee = $this->agent_model->get_settings('membership_fee');

								$new_invoice['agent_id'] = $invoice['agent_id'];
								$new_invoice['try_time'] = ($update_date_to - 86400);
								$new_invoice['payment_desc'] = 'Cortiam Agent Monthly Subscription Price';
								$new_invoice['real_amount'] = (($agent_details['membership_fee'])? $agent_details['membership_fee']:$membership_fee['setting_value']);
								$this->agent_model->add_invoice($new_invoice);
						 	}
						} catch (Exception $e) {
						 	$payment_data = array(
						 	'invoice_id' => $invoice['invoice_id'],
						 	'log_time' => $process_time,
						 	'log_status' => 'Failed',
						 	'log_response' => $e->getError()->message,
						 	);
						 	$invoice_data = array(
						 	'try_time' => strtotime("+3 HOUR", $process_time),
						 	'try_amount' => ($invoice['try_amount']+1),
						 	'invoice_status' => 'Failed',
						 	);
						}
					 	$this->agent_model->edit_invoice($invoice['invoice_id'], $invoice_data);
						$this->agent_model->add_payment($payment_data);
				}
			}
		}
	}

	/**
	 * Add new coupon to agent account
	 * @uses agent_model::process_coupon Add new coupon to agents account
	 *
	 * @return json Success|Fail details of adding new coupon action
	 */
	public function add_coupon(){
		if (!$this->input->post("coupon_code")) {$response["errorfields"]['coupon_code'] = "Coupon Code";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Field!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field is required. Please fill out all the required field and try again.';
		}else{
			$response = $this->agent_model->process_coupon($this->account['id'],$this->input->post("coupon_code"));
			if ($response["success"]) {
				$response['redirect_to'] = cortiam_base_url('my-coupons/');
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Updates automatic usage order of agent coupons
	 * @uses agent_model::process_coupon Add new coupon to agents account
	 *
	 * @return json Success|Fail details of automatic usage order action
	 */
	public function change_coupon_order(){
		if (!$_POST['coupon']) {
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}else{
			$counter=1;
			foreach ($_POST['coupon'] as $coupon_id) {
				$this->agent_model->edit_coupon($coupon_id, array('use_order' => $counter));
				$counter++;
			}
			$response["success"] = true;
		}
		echo json_encode($response);die();
	}

	/**
	 * Gets list of agent coupons
	 * @uses agent_model::get_coupons List of agent coupons
	 *
	 * @return json Success|Fail details of getting agent coupons action
	 */
	public function get_my_coupons(){
		$response["success"] = true;
		if ($coupons = $this->agent_model->get_coupons($this->account['id'])) {
			foreach ($coupons as $coupon) {
			  $response["html"] .= '<li class="profile-list-item" id="coupon-'.$coupon['use_id'].'">
							  <div class="row no-gutters">
								  <div class="col-sm-8">
								  	<p class="titlepart"><strong>'.$coupon['coupon_code'].'</strong></p>
								  	<p class="subtitlepart">'.(($coupon['coupon_used'] == 'Yes')? 'Coupon used on '.date('F j, Y', $coupon['used_on']):'Coupon will expire on '.date('F j, Y', $coupon['end_date'])).'</p>
							  	</div>
								  <div class="col-sm-2">';
								  	switch ($coupon['coupon_type']) {
								  		case 'Percentage':
								  			$response["html"] .= '-'.$coupon['coupon_amount'].'%';
								  			break;
								  		case 'Win Limit':
								  			$response["html"] .= '+'.number_format($coupon['coupon_amount']).' Wins';
								  			break;
								  		case 'Interest Limit':
								  			$response["html"] .= '+'.number_format($coupon['coupon_amount']).' Expressions';
								  			break;
								  		default:
								  			$response["html"] .= '-'.$coupon['coupon_amount'].' USD';
								  			break;
								  	}
				$response["html"] .= '</div>
								  <div class="col-sm-2 align-middle text-right">
								  	<span class="badge badge-pill '.(($coupon['coupon_used'] == 'Yes')? 'badge-secondary">Used':'orange-bg">Active').'</span>
							  	</div>
						  	</div>
						  </li>';
			}
		}else{
			$response["html"] .= '<li class="list-group-item text-center">You dont have any coupon or discount at this moment.</li>';
		}
		echo json_encode($response);die();
	}

	/**
	 * Gets list of agent payments
	 * @uses agent_model::get_invoices List of agent invoices and details
	 *
	 * @return json Success|Fail details of getting list of agent invoices action
	 */
	public function list_payments(){
		$response["success"] = true;
		if ($invoices = $this->agent_model->get_invoices($this->account['id'], array('Completed','Open','Failed'))) {
			foreach ($invoices as $invoice) {
				$response["html"] .= '<li class="profile-list-item">
							  <div class="row pl-3 cursor-pointer collapsed" data-toggle="collapse" href="#invoice-'.$invoice['invoice_id'].'" role="button" aria-expanded="false" aria-controls="invoice-'.$invoice['invoice_id'].'">
								  <div class="col-sm-9 align-middle">
							  		<p class="titlepart">'.$invoice['payment_desc'].'</p>
							  	</div>
								  <div class="col-sm-1 align-middle">
								  	<p class="mb-0">$'.$invoice['final_amount'].'</p>
							  	</div>
								  <div class="col-sm-2 align-middle text-right">
								  	<span class="badge orange-bg badge-pill">'.strtoupper($invoice['invoice_status']).'</span>
							  	</div>
						  	</div>
						  	<div class="col-sm-12 multi-collapse collapse invoiceexplain" id="invoice-'.$invoice['invoice_id'].'">
							  	'.(($invoice['invoice_status'] == 'Completed')? 'Payment completed on '.date('Y/m/d h:i:s A',$invoice['payment_time']):'Payment due date is '.date('Y/m/d h:i:s A',$invoice['try_time'])).'
							  	'.(($invoice['discount_amount'])? '<br><b>'.$invoice['coupon_code'].'</b> coupon used for this payment and saved $'.$invoice['discount_amount'].'. Payment amount dropped from $'.$invoice['real_amount'].' to $'.$invoice['final_amount'].'.':'').'
						  	</div>
						  </li>';
			}
		}else{
			$response["html"] .= '<li class="list-group-item text-center">You dont have any payment at this moment.</li>';
		}
		echo json_encode($response);die();
	}

	/**
	 * Adds or removes selected property to agent saved list of properties
	 * @uses agent_model::get_save_value Gets list of saved properties
	 * @uses agent_model::save_property Adds property to saved listing
	 * @uses agent_model::unsave_property Removes property from saved listing
	 *
	 * @return json Success|Fail details of saving|unsaving property action
	 */
	public function save_property(){
		if ($this->input->post("property_id") && $this->input->post("value")) {
			$save_status = $this->agent_model->get_save_value($this->account['id'],$this->input->post("property_id"));
			if ($this->input->post("value") == 'save') {
				if ($save_status) {
					$response["fail"] = true;
					$response["fail_title"] = 'Already Saved!';
					$response["fail_message"] = 'Selected property already saved on your list at '.date('Y/m/d h:i:s A', $save_status['save_time']).'.';
				}else{
					$this->agent_model->save_property($this->account['id'],$this->input->post("property_id"));
					$response["success"] = true;
				}
			}else{
				$this->agent_model->unsave_property($this->account['id'],$this->input->post("property_id"));
				$response["success"] = true;
			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Express property for selected property
	 * @uses agent_model::get_proposal_value Checks&gets proposal for selected property
	 * @uses agent_model::get_property Gets details of selected property
	 * @uses agent_model::add_proposal Adds proposal for selected property
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_notification Adds notification for selected account
	 *
	 * @return json Success|Fail details of express property action
	 */
	public function express_property(){
		if ($this->input->post("property_id")) {
			$save_status = $this->agent_model->get_proposal_value($this->account['id'],$this->input->post("property_id"));
			if ($save_status) {
				$response["fail"] = true;
				$response["fail_title"] = 'Already Have Introduction!';
				$response["fail_message"] = 'Selected property already have your introduction at '.date('Y/m/d h:i:s A', $save_status['express_time']).'.';
			}elseif($this->account['offer_remain'] < 1){
				$response["fail"] = true;
				$response["fail_title"] = 'Out Of Limit!';
				$response["fail_message"] = 'Your account met the max counter offer/introduction limit, please wait the end one of your current counter offers/introductions and try again.';
			}elseif($this->account['win_remain'] < 1){
				$response["fail"] = true;
				$response["fail_title"] = 'Out Of Limit!';
				$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				$response["fail_message"] = 'Congratulations, you’ve won your '.$spellout->format($this->account['win_limit']).' properties for the moth and your win limits will update on '.date('m/d/Y h:i A',$this->account['membership_due']).'. For more information click on the Wins tutorial video in the tutorial tab.';
			}else{
				$property = $this->agent_model->get_property($this->input->post("property_id"));
				if ($this->account['licenses']['license_states'][$property['state']]) {
					if ($this->account['licenses']['interested'][$property['state']][$property['type']]) {
						if ($this->account['membership_due'] > time()) {
							$express_details = array(
								'property_id' => $property['property_id'],
								'seller_id' => $property['seller_id'],
								'agent_id' => $this->account['id'],
								'prop_from' => 'Agent',
								'prop_to' => 'Seller',
								'prop_date' => time(),
								'commission_rate' => $property['commission_rate'],
								'contract_length' => $property['contract_length'],
							);
							if($this->agent_model->add_proposal($express_details)){

								$seller_account = $this->agent_model->get_seller($property['seller_id']);
								$user_email_text = '<h3 style="color:#4c525e;">NEW INTRODUCTION</h3><h4 style="color:#848994;">Dear '.$seller_account['first_name'].' '.$seller_account['last_name'].',</h4><p>Congratulations! A Real Estate Agent has viewed your '.(($property['unit'])? $property['unit'].' ':'').$property['address'].' '.$property['city'].', '.$property['state'].', '.$property['zipcode'].' property and agreed to your terms!  Please login to your Cortiam Account to view the agent\'s profile. From there, you will be able to view the agent\'s credentials and ensure they meet your needs.  If they meet your needs, simply accept them as your agent, and they will handle the rest!</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
								$this->agent_model->add_notification($seller_account['seller_id'], 'New Introduction For Your Property', 'We are happy to tell you that a Real Estate Agent sent you an introduction for your property  at '.(($property['unit'])? $property['unit'].' ':'').$property['address'].' '.$property['city'].', '.$property['state'].', '.$property['zipcode'].' address.');
								if ($seller_account['notifications'] == 'Yes') {
									$this->mailer->regular_email('Congratulations! A Real Estate Agent has made an Introduction!', $user_email_text, $seller_account['email']);
								}
								$response["success"] = true;
								$response["success_title"] = 'Sent Successfully!';
								$response["success_message"] = 'Your introduction was sent successfully to the property owner. You will be notified when the owner responds to your introduction.';
							}else{
								$response["fail"] = true;
								$response["fail_title"] = 'Unexpected Error!';
								$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
							}
						}else{
							if ($this->account['payment_id']) {
								$response["fail"] = true;
								$response["fail_title"] = 'Membership Period';
								$response["fail_message"] = 'Your accounts membership period not started yet. Please add a payment method to your account first to start your membership period.';
							}else{
								$response["fail"] = true;
								$response["fail_title"] = 'Membership Payment Missing';
								$response["fail_message"] = 'Your accounts membership payment is not completed. Please control&update your payment to process your account membership payment.';
							}
						}
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'License Type Problem!';
						$response["fail_message"] = 'The property type you are trying to introduce does not match with your license type.';
					}
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Out Of License Area!';
					$response["fail_message"] = 'The property you are trying to introduce is out of your license area.';
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
	 * Creates counter offer form for selected property
	 * @uses agent_model::get_property Gets details of selected property
	 * @uses agent_model::get_proposal Gets details for selected proposal
	 *
	 * @return json Success|Fail details of creating counter offer form action
	 */
	public function counter_offer_form(){
		if ($this->input->post("property_id"))
		{
	
			
     		if ($property = $this->agent_model->get_property($this->input->post("property_id")))
			{
				$response["success"] = true;
				$response["form"] = '<h3 class="text-center">COUNTERED OFFER 1</h3><div class="card">
							<div class="card-body p-2 border-bottom">
									<div class="row">
										<div class="col-md-6 font-weight-bold text-center border-right"><span class="text-secondary">Commission Rate</span><br>'.$property['commission_rate'].' %</div>
										<div class="col-md-6 font-weight-bold text-center"><span class="text-secondary">Length of Contract</span><br>'.$property['contract_length'].' months</div>
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
							<a class="button-orange text-center" id="send-counter-offer">SEND YOUR OFFER</a>
						</div>
						</div></form>';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}elseif ($this->input->post("proposal_id")) {
			if ($proposal = $this->agent_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))) {
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
	 * Add proposal for selected property
	 * @uses agent_model::get_property Gets details of selected property
	 * @uses agent_model::add_proposal Adds proposal for selected property
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_notification Adds notification for selected account
	 *
	 * @return json Success|Fail details of adding proposal action
	 */
	public function send_proposal(){

		if ($this->input->post("property_id")) {

			if (!$this->input->post("commission_rate")) {$response["errorfields"]['commission_rate'] = "Commission Rate";}
			if (!$this->input->post("contract_length")) {$response["errorfields"]['contract_length'] = "Length of Contract";}
			if (!$this->input->post("message")) {$response["errorfields"]['message'] = "Your Message";}

			if( isset($response["errorfields"]) &&  count($response["errorfields"]) > 0 ) {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}elseif(!$property = $this->agent_model->get_property($this->input->post("property_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Property Cannot Found!';
				$response["fail_message"] = 'The property you counter offer is currently not active or cannot be found, please refresh the page and try again.';
			}elseif($this->account['offer_remain'] < 1){
				$response["fail"] = true;
				$response["fail_title"] = 'Out Of Limit!';
				$response["fail_message"] = 'Your account met the max counter offer/introduction limit, please wait the end one of your current counter offers/introductions and try again.';
			}else{

				log_message("error", "license_states...");

				if ($this->account['licenses']['license_states'][$property['state']]) {
					if ($this->account['licenses']['interested'][$property['state']][$property['type']]) {
						log_message("error", "interested...");

						if ($this->account['membership_due'] > time()) {

							log_message("error", "membership_due...");

							
							$msg_data = array(
								'property_id' => $property['property_id'],
								'seller_id' => $property['seller_id'],
								'agent_id' => $this->account['id'],
								'prop_from' => 'Agent',
								'prop_to' => 'Seller',
								'prop_text' => $this->input->post("message"),
								'prop_date' => time(),
								'commission_rate' => $this->input->post("commission_rate"),
								'contract_length' => $this->input->post("contract_length"),
								'first_counter' => 'Yes',
							);
							if($this->agent_model->add_proposal($msg_data)){

								log_message("error", "add_proposal...");


								$seller_account = $this->agent_model->get_seller($property['seller_id']);
								$user_email_text = '<h3 style="color:#4c525e;">NEW COUNTER-OFFER</h3><h4 style="color:#848994;">Dear '.$seller_account['first_name'].' '.$seller_account['last_name'].'</h4><p>Congratulations! '.$this->account['first_name'].' '.$this->account['last_name'].' has sent you a counteroffer for your '.(($property['unit'])? $property['unit'].' ':'').$property['address'].' '.$property['city'].', '.$property['state'].', '.$property['zipcode'].' property. Please login to your Cortiam Account to view the details of this counteroffer. You will have the choice to decline or submit a re-counter offer. As a reminder, the national average for commissions paid to realtors is approx—6% due to the split between the seller and buyer agents. In addition the national average of contract lengths is 6 months. You may experience a higher volume of Counter Offers if your terms are set substantially lower than the national average.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
								$this->agent_model->add_notification($seller_account['seller_id'], 'New Counter-Offer For Your Property', 'Congratulations! '.$this->account['first_name'].' '.$this->account['last_name'].' has sent you a counteroffer for your '.(($property['unit'])? $property['unit'].' ':'').$property['address'].' '.$property['city'].', '.$property['state'].', '.$property['zipcode'].' property.');
								if ($seller_account['notifications'] == 'Yes') {
									$this->mailer->regular_email('Congratulations! A Real Estate Agent has Submitted a Counter-Offer for Your Property', $user_email_text, $seller_account['email']);
								}
								$response["success"] = true;
								$response["success_title"] = 'Send Successfully!';
								$response["success_message"] = 'Your counter offer send successfully to the property owner. You will be notified when owner response for your offer.';
							}else{

								log_message("error", "Unexpected Error!...");

								$response["fail"] = true;
								$response["fail_title"] = 'Unexpected Error!';
								$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
							}
						}else{

							log_message("error", "payment_id...");

							if ($this->account['payment_id']) {

								log_message("error", "true...");

								$response["fail"] = true;
								$response["fail_title"] = 'Membership Period';
								$response["fail_message"] = 'Your accounts membership period not started yet. Please add a payment method to your account first to start your membership period.';
							}else{
								log_message("error", "false...");

								$response["fail"] = true;
								$response["fail_title"] = 'Membership Payment Missing';
								$response["fail_message"] = 'Your accounts membership payment is not completed. Please control&update your payment to process your account membership payment.';
							}
						}
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'License Type Problem!';
						$response["fail_message"] = 'The property type you are trying to counter offer does not match with your license type.';
					}
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Out Of License Area!';
					$response["fail_message"] = 'The property you are trying to counter offer is out of your license area.';
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
	 * Adds counter offer for selected proposal
	 * @uses agent_model::get_proposal Gets details of selected proposal
	 * @uses agent_model::get_property Gets details of selected property
	 * @uses agent_model::add_proposal Adds proposal for selected property
	 * @uses agent_model::edit_proposal Updates details of selected proposal
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_notification Adds notification for selected account
	 *
	 * @return json Success|Fail details of counter offer action
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
			}elseif(!$proposal = $this->agent_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Proposal Cannot Found!';
				$response["fail_message"] = 'The proposal you counter offer is currently not active or cannot be found, please refresh the page and try again.';
			}elseif($this->account['offer_remain'] < 1){
				$response["fail"] = true;
				$response["fail_title"] = 'Out Of Limit!';
				$response["fail_message"] = 'Your account met the max counter offer/introduction limit, please wait the end one of your current counter offers/introductions and try again.';
			}elseif($this->account['win_remain'] < 1){
				$response["fail"] = true;
				$response["fail_title"] = 'Out Of Limit!';
				$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				$response["fail_message"] = 'Congratulations, you’ve won your '.$spellout->format($this->account['win_limit']).' properties for the moth and your win limits will update on '.date('m/d/Y h:i A',$this->account['membership_due']).'. For more information click on the Wins tutorial video in the tutorial tab.';
			}else{
				$property = $this->agent_model->get_property($proposal['property_id']);
				if ($this->account['licenses']['license_states'][$property['state']]) {
					if ($this->account['licenses']['interested'][$property['state']][$property['type']]) {
						if ($this->account['membership_due'] > time()) {
								$msg_data = array(
									'base_id' => (($proposal['base_id'])? $proposal['base_id']:(($proposal['main_id'])? $proposal['main_id']:null)),
									'main_id' => $proposal['prop_id'],
									'property_id' => $proposal['property_id'],
									'seller_id' => $proposal['seller_id'],
									'agent_id' => $proposal['agent_id'],
									'prop_from' => 'Agent',
									'prop_to' => 'Seller',
									'prop_text' => $this->input->post("message"),
									'prop_date' => time(),
									'commission_rate' => $this->input->post("commission_rate"),
									'contract_length' => $this->input->post("contract_length"),
								);
								if($new_proposal_id = $this->agent_model->add_proposal($msg_data)){
									$this->agent_model->edit_proposal($proposal['prop_id'], array('status' => 'Countered'));

									$seller_account = $this->agent_model->get_seller($proposal['seller_id']);
									$user_email_text = '<h3 style="color:#4c525e;">NEW RECOUNTER OFFER</h3><h4 style="color:#848994;">Dear '.$seller_account['first_name'].' '.$seller_account['last_name'].',</h4><p> We are happy to tell you that '.$this->account['first_name'].' '.$this->account['last_name'].' sent you a counter offer for your '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' property. Please login to your Cortiam Account to view the details of this counter offer. You will have the choice to decline or submit a re-counter offer. As a reminder, the national average for commissions paid to realtors is approx—6% due to the split between the seller and buyer agents. In addition the national average of contract lengths is 6 months. You may experience a higher volume of Counter Offers if your terms are set substantially lower than the national average.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
									$this->agent_model->add_notification($seller_account['seller_id'], 'New Recounter Offer For Your Property', 'We are happy to tell you that '.$this->account['first_name'].' '.$this->account['last_name'].' sent you a counter offer for your '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' property.');
									if ($seller_account['notifications'] == 'Yes') {
										$this->mailer->regular_email('Recounter Offer Received', $user_email_text, $seller_account['email']);
									}
									$new_proposal = $this->agent_model->get_proposal($this->ion_auth->get_user_id(), $new_proposal_id);

									$response["success"] = true;
									$response["success_title"] = 'Sent Successfully!';
									$response["success_message"] = 'Your counter offer was sent successfully to the property owner. You will be notified when the owner responds to your offer.';
									$response["newcard"] = '<div class="col-md-4 proplistingwrap">
										<a href="'.cortiam_base_url('view-proposal/').$new_proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $new_proposal['city'].' '.$new_proposal['state'])), 'underscore', true).'" class="card proplisting mb-2">
											'.generate_agent_proposal_ribbon($new_proposal['prop_from'], 'Countered').'
										  <img class="card-img-top" src="'.base_url($new_proposal['default_image']).'" alt="Listing Image">
										  <div class="card-body orange-bg px-2">
										    <span class="float-left"><b>'.$new_proposal['type'].'</b></span>
										    <small class="float-right">'.$new_proposal['building_size'].' sqft.</small>
										  </div>
										  <div class="card-footer addresspart p-2">
								  			<strong>Commission Rate:</strong><p>'.$new_proposal['commission_rate'].'%</p>
								  			<strong>Contract Length:</strong><p>'.$new_proposal['contract_length'].' Months</p>
										  </div>
							  			<small class="winfee">Fee: $'. number_format($new_proposal['win_fee'],2).'</small>
										</a>
											<div class="px-2">
											  <button class="button-orange smallerbutton text-center float-left button-disabled">ACCEPT</button>
											  <button class="button-gray smallerbutton text-center float-right button-disabled">DECLINE</button>
											  <button class="button-dark w-100 smallerbutton text-center float-right mt-2 withdrawproposal" data-prop="'.$new_proposal['prop_id'].'">WITHDRAW</button>
											  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="'.cortiam_base_url('view-property/').$new_proposal['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $new_proposal['city'].' '.$new_proposal['state'])), 'underscore', true).'">View Property Page</a>
											</div>
								  </div>';
							}else{
								$response["fail"] = true;
								$response["fail_title"] = 'Unexpected Error!';
								$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
							}
						}else{
							if ($this->account['payment_id']) {
								$response["fail"] = true;
								$response["fail_title"] = 'Membership Period';
								$response["fail_message"] = 'Your accounts membership period not started yet. Please add a payment method to your account first to start your membership period.';
							}else{
								$response["fail"] = true;
								$response["fail_title"] = 'Membership Payment Missing';
								$response["fail_message"] = 'Your accounts membership payment is not completed. Please control&update your payment to process your account membership payment.';
							}
						}
					}else{
						$response["fail"] = true;
						$response["fail_title"] = 'License Type Problem!';
						$response["fail_message"] = 'The property type you are trying to introduce does not match with your license type.';
					}
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Out Of License Area!';
					$response["fail_message"] = 'The property you are trying to introduce is out of your license area.';
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
	 * Accepts selected proposal
	 * @uses agent_model::get_proposal Gets details of selected proposal
	 * @uses agent_model::check_for_agreement Checks&gets details of agreement of selected property if any
	 * @uses agent_model::edit_proposal Updates details of selected proposal
	 * @uses agent_model::get_state_cost Gets cost of properties state
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_agreement Adds agreement for selected property
	 * @uses agent_model::add_notification Adds notification for selected account
	 *
	 * @return json Success|Fail details of accepting selected proposal action
	 */
	public function accept_proposal(){
		if ($this->input->post("proposal_id")) {
			if(!$proposal = $this->agent_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Proposal Cannot Found!';
				$response["fail_message"] = 'The proposal you counter offer is currently not active or cannot be found, please refresh the page and try again.';
			}else{
				if($agreement_check = $this->agent_model->check_for_agreement($proposal['property_id'])){
					$response["fail"] = true;
					$response["fail_title"] = 'Currently Not Available';
					$response["fail_message"] = 'This property owner currently negotiating contract with another real estate agent. If they cannot agree on contract before negotation time ends ( '.date('Y/m/d h:i:s A',$agreement_check['expire_time']).'), you will be able to accept this offer. Otherwise this proposal will terminated automatically.';
				}else{
					$msg_data = array(
						'status' => 'Accepted',
					);
					if($this->agent_model->edit_proposal($proposal['prop_id'],$msg_data)){
						if ($proposal['winning_fee']) {
							 $fee_amount = $proposal['winning_fee'];
						}elseif ($this->account['winning_fee']) {
							 $fee_amount = $this->account['winning_fee'];
						}else{
							$fee = $this->agent_model->get_state_cost($proposal['property_id']);
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
						$this->agent_model->add_agreement($aggreement_data);
						$seller_account = $this->agent_model->get_seller($proposal['seller_id']);
						$user_email_text = '<h3 style="color:#4c525e;">AGENT AGREED YOUR TERMS</h3><h4 style="color:#848994;">Dear '.$seller_account['first_name'].' '.$seller_account['last_name'].',</h4><p>Congratulations! '.$this->account['first_name'].' '.$this->account['last_name'].' accepted your terms for your '.(($proposal['unit'])? $proposal['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' property. '.$this->account['first_name'].' '.$this->account['last_name'].' will have 48 hours to finish the process on their end and will be in contact with you in typically 2-3 business days! If '.$this->account['first_name'].' '.$this->account['last_name'].' does not complete the process after 48 hours, your property will become available to other agents again. No action is needed on your part. Your real estate agent will handle the heavy lifting of selling your home from here! Please login into your Cortiam Account for any further updates on your property.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
						$this->agent_model->add_notification($seller_account['seller_id'], 'Agent Agreed Your Terms', 'Congratulations! '.$this->account['first_name'].' '.$this->account['last_name'].' accepted your terms for your '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' property.');
						if ($seller_account['notifications'] == 'Yes') {
							$this->mailer->regular_email('Congratulations! Your Agent has agreed to Sell Your Home on Your Terms!', $user_email_text, $seller_account['email']);
						}

						$response["redirect_to"] = cortiam_base_url('agreements');
						$response["success"] = true;
						$this->session->set_flashdata('notify', 'success');
						$this->session->set_flashdata('notify_message', 'Your accepted the proposal successfully. System automatically converted this proposal to agreement. Now you need review, accept details and complete the required payment to finalize agreement. After this you will be able to access property owner details for contact.');
						$this->session->set_flashdata('notify_title', 'Accepted Succesfully');
						$response["newcard"] = '<div class="col-md-4 proplistingwrap">
							<a href="'.cortiam_base_url('view-proposal/').$proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true).'" class="card proplisting mb-2">
								'.generate_agent_proposal_ribbon($proposal['prop_from'], 'Accepted').'
							  <img class="card-img-top" src="'.base_url($proposal['default_image']).'" alt="Listing Image">
							  <div class="card-body orange-bg px-2">
							    <span class="float-left"><b>'.$proposal['type'].'</b></span>
							    <small class="float-right">'.$proposal['building_size'].' sqft.</small>
							  </div>
							  <div class="card-footer addresspart p-2">
								  <strong>Address:</strong><p>'.$proposal['city'].', '.$proposal['state'].'</p>
							  </div>
							</a>
								<div class="grayout px-2">
								  <button class="button-orange smallerbutton text-center float-left">ACCEPT</button>
								  <button class="button-gray smallerbutton text-center float-right">DECLINE</button>
								  <button class="button-border-gray w-100 smallerbutton text-center float-right mt-2">COUNTER OFFER</button>
								  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="'.cortiam_base_url('view-property/').$proposal['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true).'">View Property Page</a>
							  <div class="prevent"></div>
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
	 * Decline selected proposal
	 * @uses agent_model::get_proposal Gets details of selected proposal
	 * @uses agent_model::edit_proposal Updates details of selected proposal
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_agreement Adds agreement for selected property
	 *
	 * @return json Success|Fail details of declining selected proposal action
	 */
	public function decline_proposal(){
		if ($this->input->post("proposal_id")) {
			if(!$proposal = $this->agent_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Proposal Cannot Found!';
				$response["fail_message"] = 'The proposal you counter offer is currently not active or cannot be found, please refresh the page and try again.';
			}else{
				$msg_data = array(
					'status' => 'Declined',
				);
				if($this->agent_model->edit_proposal($proposal['prop_id'],$msg_data)){
					$seller_account = $this->agent_model->get_seller($proposal['seller_id']);
					$user_email_text = '<h3 style="color:#4c525e;">YOUR COUNTER-OFFER DECLINED</h3><h4 style="color:#848994;">Dear '.$seller_account['first_name'].' '.$seller_account['last_name'].'</h4><p>Hello! '.$this->account['first_name'].' '.$this->account['last_name'].' declined your counteroffer for your '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' property, but don’t sweat! There are many local real estate agents using Cortiam that are eager for the opportunity to sell your home on your terms! Tip: If you are not seeing a lot of interest for your property, consider adjusting your terms.  The average commission paid to realtors in is approx—6% while the average contract lengths is 6 months.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$this->agent_model->add_notification($seller_account['seller_id'], 'Your Counter-Offer Was Declined', $this->account['first_name'].' '.$this->account['last_name'].' declined your counteroffer for your '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' property.');
					if ($seller_account['notifications'] == 'Yes') {
						$this->mailer->regular_email('Your Counter-Offer Was Declined', $user_email_text, $seller_account['email']);
					}
					$response["success"] = true;
					$response["success_title"] = 'Completed Successfully!';
					$response["success_message"] = 'You have successfully declined property owners offer.';
					$response["newcard"] = '<div class="col-md-4 proplistingwrap grayout">
						<a href="'.cortiam_base_url('view-proposal/').$proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ", $proposal['city'].' '.$proposal['state'])), 'underscore', true).'" class="card proplisting mb-2">
							'.generate_agent_proposal_ribbon($proposal['prop_from'], 'Declined').'
						  <img class="card-img-top" src="'.base_url($proposal['default_image']).'" alt="Listing Image">
						  <div class="card-body orange-bg px-2">
						    <span class="float-left"><b>'.$proposal['type'].'</b></span>
						    <small class="float-right">'.$proposal['building_size'].' sqft.</small>
						  </div>
						  <div class="card-footer addresspart p-2">
							  <strong>Address:</strong><p>'.$proposal['city'].', '.$proposal['state'].'</p>
						  </div>
						</a>
							<div class="grayout px-2">
							  <button class="button-orange smallerbutton text-center float-left">ACCEPT</button>
							  <button class="button-gray smallerbutton text-center float-right">DECLINE</button>
							  <button class="button-border-gray w-100 smallerbutton text-center float-right mt-2">COUNTER OFFER</button>
							  <a class="button-underline-gray w-100 smallerbutton text-center mt-2" href="'.cortiam_base_url('view-property/').$proposal['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $proposal['city'].' '.$proposal['state'])), 'underscore', true).'">View Property Page</a>
						  <div class="prevent"></div>
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
	 * Withdraw selected proposal
	 * @uses agent_model::get_proposal Gets details of selected proposal
	 * @uses agent_model::set_extra_winexp Add/Removes win point for agent
	 * @uses agent_model::edit_proposal Updates details of selected proposal
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_notification Adds notification for selected account
	 *
	 * @return json Success|Fail details of withdrawing selected proposal action
	 */
	public function withdraw_proposal(){
		if ($this->input->post("proposal_id")) {
			if(!$proposal = $this->agent_model->get_proposal($this->ion_auth->get_user_id(), $this->input->post("proposal_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Proposal Cannot Found!';
				$response["fail_message"] = 'The proposal you want to widthdraw is currently not active or cannot be found, please refresh the page and try again.';
			}else{
				if ($proposal['prop_from'] == 'Agent') {
					$msg_data = array(
						'status' => 'Withdrawn',
					);
					if($this->agent_model->edit_proposal($proposal['prop_id'],$msg_data)){
						$this->agent_model->set_extra_winexp($this->ion_auth->get_user_id(), 1, 'off');
						$seller_account = $this->agent_model->get_seller($proposal['seller_id']);
						$user_email_text = '<h3 style="color:#4c525e;">INTRODUCTION WITHDRAWN</h3><h4 style="color:#848994;">Dear '.$seller_account['first_name'].' '.$seller_account['last_name'].'</h4><p>We are sorry to tell you that '.$this->account['first_name'].' '.$this->account['last_name'].' rescinded the offer for your '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' property. There is no additional action required from you at this time. Please login to your Cortiam Account for any new updates about your property. </p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
						$this->agent_model->add_notification($seller_account['seller_id'], 'Introduction Withdrawn', 'We are sorry to tell you that '.$this->account['first_name'].' '.$this->account['last_name'].' rescinded the offer for your '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' property.');
						if ($seller_account['notifications'] == 'Yes') {
							$this->mailer->regular_email('Introduction Withdrawn', $user_email_text, $seller_account['email']);
						}
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
	 * Send message to selected user
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_message Adds message for selected account
	 *
	 * @param  integer $seller_id ID of selected user
	 * @return json Success|Fail details of sending message action
	 */
	public function send_message($seller_id){
		if ($seller = $this->agent_model->get_seller($seller_id)){
			if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Your Message";}

			if(count($response["errorfields"])) {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}else{
				$msg_data = array(
					'seller_id' => $seller['seller_id'],
					'agent_id' => $this->ion_auth->get_user_id(),
					'msg_from' => 'Agent',
					'msg_to' => 'Seller',
					'message_text' => $this->input->post("message_text"),
					'message_date' => time(),
				);
				if($this->agent_model->add_message($msg_data)){
					$response["success"] = true;
					$response["success_title"] = 'Sent Successfully!';
					$response["success_message"] = 'Your message was sent successfully. You will be notified when the property owner responds to your message.';
					$response["redirect_to"] = cortiam_base_url('view-messages/').$seller['seller_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $seller['first_name'].' '.$seller['last_name'])), 'underscore', true);
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
	 * Accept selected agreement
	 * @uses agent_model::get_aggrement Gets details of selected agrement
	 * @uses agent_model::edit_agreement Update details of selected agrement
	 * @uses agent_model::edit_proposal Update details of selected proposal
	 * @uses agent_model::get_invoice Get details of selected invoice
	 * @uses agent_model::add_invoice Add new invoice details
	 * @uses agent_model::edit_invoice Update details of selected invoice
	 * @uses agent_model::process_win_payment Process selected payment
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_notification Adds notification for selected account
	 * @uses agent_model::get_clear_favorites Clears favorite records of selected properties
	 * @uses agent_model::get_clear_proposals Clears proposal records of selected properties
	 * @uses agent_model::set_extra_winexp Add/Removes win point for agent
	 *
	 * @return json Success|Fail details of accepting selected agreement action
	 */
	public function accept_agreement(){
		if ($this->input->post("agree_id")) {
			if(!$agreement = $this->agent_model->get_aggrement($this->ion_auth->get_user_id(), $this->input->post("agree_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Agreement Cannot Found!';
				$response["fail_message"] = 'The agreement you want to accept is currently not active or cannot be found, please refresh the page and try again.';
			}elseif($this->account['win_remain'] < 1){
				$response["fail"] = true;
				$response["fail_title"] = 'Out Of Limit!';
				$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				$response["fail_message"] = 'Congratulations, you’ve won your '.$spellout->format($this->account['win_limit']).' properties for the moth and your win limits will update on '.date('m/d/Y h:i A',$this->account['membership_due']).'. For more information click on the Wins tutorial video in the tutorial tab.';
			}else{
				$current_time = time();
				$invoice_data = array(
				'agent_id' => $this->account['id'],
				'property_id' => $agreement['property_id'],
				'payment_time' => $current_time,
				'payment_type' => 'Commission',
				'payment_desc' => 'Property Agreement Completion Fee',
				'real_amount' => $agreement['agr_fee'],
				'final_amount' => $agreement['agr_fee'],
				);
				$payment_id = $this->agent_model->add_invoice($invoice_data);
				$payment_response = $this->process_win_payment($payment_id);
				if ($payment_response['fail']) {
					 	$invoice_data = array(
						 	'try_amount' => 4,
						 	'invoice_status' => 'Failed',
					 	);
				 	$this->agent_model->edit_invoice($payment_id, $invoice_data);
					$response["fail"] = true;
					$response["fail_title"] = 'Payment Failed!';
					$response["fail_message"] = 'There is an error occured while processing your property agreement completion fee payment "'.$payment_response['error'].'".';
				}else{
					$invoice = $this->agent_model->get_invoice($payment_id);
					if ($invoice['invoice_status'] = 'Completed') {
						$agr_data = array(
							'payment_status' => 'Completed',
							'agr_status' => 'Completed',
							'agr_time' => $current_time,
						);
						$this->agent_model->edit_agreement($agreement['agr_id'],$agr_data);
						$this->agent_model->set_extra_winexp($this->ion_auth->get_user_id(), -1, 'win');
						$property_data = array(
							'status' => 'Contracted',
						);
						$this->agent_model->edit_property($agreement['property_id'],$property_data);
						$seller_account = $this->agent_model->get_seller($proposal['seller_id']);
						$user_email_text = '<h3 style="color:#4c525e;">AGENT IS READY TO WORK WITH YOU</h3><h4 style="color:#848994;">Dear '.$seller_account['first_name'].' '.$seller_account['last_name'].'</h4><p>Congratulations its time to sell your home on your terms! If they haven\'t already '.$this->account['first_name'].' '.$this->account['last_name'].' has received your contact information and will be calling you shortly. We hope you enjoyed finding the agent that was right for you and your family utilizing Cortiam’s Innovative Platform. From this point forward you should expect to work directly with your Agent. Your Agent and their Brokerage should be able to assist you with any questions or concerns with selling your property.</p><p>We are incredibly thankful for you using Cortiam to find your right agent. Although the process with Cortiam is now over, we hope to help find agents for you, your friends, and family in the future. Cortiam Team.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
						$this->agent_model->add_notification($seller_account['seller_id'], 'Agent Is Ready To Work With You', 'Congratulations its time to sell your home on your terms! If they haven\'t already '.$this->account['first_name'].' '.$this->account['last_name'].' has received your contact information and will be calling you shortly.');
						if ($seller_account['notifications'] == 'Yes') {
							$this->mailer->regular_email('Your Agent is Ready to work with you! We hope you enjoyed using Cortiam.', $user_email_text, $seller_account['email']);
						}
						$this->agent_model->get_clear_favorites($agreement['property_id']);
						if ($clear_proposals = $this->agent_model->get_clear_proposals($agreement['property_id'])) {
							foreach ($clear_proposals as $clear_proposal) {
								if ($clear_proposal['prop_from'] == 'Seller') {
									$update_prop = array('status' => 'Widthdrawn');
								}else{
									$update_prop = array('status' => 'Declined');
								}
								$this->agent_model->edit_proposal($clear_proposal['prop_id'], $update_prop);
								if ($clear_proposal['prop_from'] == 'Agent') {
									$this->agent_model->set_extra_winexp($clear_proposal['agent_id'], 1, 'off');
								}
								$user_email_text = '<h3 style="color:#4c525e;">PROPOSAL DECLINED AUTOMATICALLY</h3><h4 style="color:#848994;">Dear '.$clear_proposal['first_name'].' '.$clear_proposal['last_name'].'</h4><p>Oh No! We are sorry to inform you that your introduction for '.$clear_proposal['city'].', '.$clear_proposal['state'].' was automatically declined because the property owner has an agreement with another real estate agent. While this one got away, remember to login to your Cortiam Account and view your Agent Dashboard daily for new leads!</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
								$this->agent_model->add_notification($clear_proposal['agent_id'], 'Oops! Something Went Wrong...', 'Oh No! We are sorry to inform you that your introduction for '.$clear_proposal['city'].', '.$clear_proposal['state'].' was automatically declined because the property owner has an agreement with another real estate agent. While this one got away, remember to login to your Cortiam Account and view your Agent Dashboard daily for new leads!');
								if ($clear_proposal['notifications'] == 'Yes') {
									$this->mailer->regular_email('Oops! Something Went Wrong...', $user_email_text, $clear_proposal['email']);
								}
							}
						}

						$response["success"] = true;
						$response["success_title"] = 'Completed Successfully!';
						$response["success_message"] = 'You have successfully accepted the selected agreement. The $'.$agreement['agr_fee'].'USD property agreement completion fee for this property was automatically deducted from your account.';
						$response["newcard"] = '<div class="col-md-4" id="props-'.$agreement['agr_id'].'">
						<div class="card proplisting mb-2">
							'.generate_agreement_ribbon('Completed', $agreement['expire_time']).'
						  <img class="card-img-top" src="'.base_url($agreement['default_image']).'" alt="Listing Image">
						  <div class="card-body orange-bg px-2">
						    <span class="float-left">Fee</span>
						    <span class="float-right"><b>$'.$agreement['agr_fee'].' USD</b></span>
						  </div>
						  <div class="card-footer addresspart p-2">
							  <strong>Address:</strong><p>'.$agreement['city'].', '.$agreement['state'].'</p>
						  </div>
						</div>
						<div class="px-2 text-center"><a href="'.cortiam_base_url('view-proposal/').$agreement['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agreement['city'].', '.$agreement['state'])), 'underscore', true).'" class="button-orange float-right smallerbutton text-center">VIEW SELLERS CONTACT INFO</a></div></div>';

					}else{
						$agr_data = array(
							'payment_status' => 'Failed',
						);
						$this->agent_model->edit_agreement($agreement['agr_id'],$agr_data);
						$response["newcard"] = '<div class="col-md-4" id="props-'.$agreement['agr_id'].'">
						<div class="card proplisting mb-2">
							'.generate_agreement_ribbon('Open', $agreement['expire_time']).'
						  <img class="card-img-top" src="'.base_url($agreement['default_image']).'" alt="Listing Image">
						  <div class="card-body orange-bg px-2">
						    <span class="float-left">Fee</span>
						    <span class="float-right"><b>$'.$agreement['agr_fee'].' USD</b></span>
						  </div>
						  <div class="card-footer addresspart p-2">
							  <strong>Address:</strong><p>'.$agreement['city'].', '.$agreement['state'].'</p>
						  </div>
						</div><div class="px-2"><button class="button-orange smallerbutton text-center float-left acceptagreement" data-agree="'.$agreement['agr_id'].'" data-price="'.$agreement['agr_fee'].'">ACCEPT</button><button class="button-gray smallerbutton text-center float-right declineagreement" data-agree="'.$agreement['agr_id'].'>">DECLINE</button></div>';
						$response["fail"] = true;
						$response["fail_title"] = 'Payment Failed!';
						$response["fail_message"] = 'There is an error occured while processing your agreement completion fee payment, please refresh the page and try again.';
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
	 * Declines selected agreement
	 * @uses agent_model::get_aggrement Gets details of selected agrement
	 * @uses agent_model::edit_agreement Update details of selected agrement
	 * @uses agent_model::edit_proposal Update details of selected proposal
	 * @uses agent_model::get_seller Gets details of seller account
	 * @uses agent_model::add_notification Adds notification for selected account
	 *
	 * @return json Success|Fail details of declining selected agreement action
	 */
	public function decline_agreement(){
		if ($this->input->post("agree_id")) {
			if(!$agreement = $this->agent_model->get_aggrement($this->ion_auth->get_user_id(), $this->input->post("agree_id"))){
				$response["fail"] = true;
				$response["fail_title"] = 'Agreement Cannot Found!';
				$response["fail_message"] = 'The agreement you want to accept is currently not active or cannot be found, please refresh the page and try again.';
			}elseif($this->account['win_remain'] < 1){
				$response["fail"] = true;
				$response["fail_title"] = 'Out Of Limit!';
				$spellout = new NumberFormatter("en", NumberFormatter::SPELLOUT);
				$response["fail_message"] = 'Congratulations, you’ve won your '.$spellout->format($this->account['win_limit']).' properties for the moth and your win limits will update on '.date('m/d/Y h:i A',$this->account['membership_due']).'. For more information click on the Wins tutorial video in the tutorial tab.';
			}else{
				$current_time = time();
				$proposal = $this->agent_model->get_proposal($this->ion_auth->get_user_id(), $agreement['prop_id']);

				$update_prop = array('status' => 'Declined');
				$this->agent_model->edit_proposal($agreement['prop_id'], $update_prop);

				$agr_data = array(
					'payment_status' => 'Failed',
					'agr_status' => 'Canceled',
					'agr_time' => $current_time,
				);
				$this->agent_model->edit_agreement($agreement['agr_id'],$agr_data);
				$seller_account = $this->agent_model->get_seller($agreement['seller_id']);
				$user_email_text = '<h3 style="color:#4c525e;">AGREEMENT DECLINED</h3><h4 style="color:#848994;">Dear '.$seller_account['first_name'].' '.$seller_account['last_name'].'</h4><p>We are sorry to tell you that the Real Estate Agent declined agreement for your property at  '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' address. For more information please login to Cortiam to check the agreement details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$this->agent_model->add_notification($seller_account['seller_id'], 'Agreement Declined', 'We are sorry to tell you that the Real Estate Agent declined agreement for your property at  '.(($property['unit'])? $property['unit'].' ':'').$proposal['address'].' '.$proposal['city'].', '.$proposal['state'].', '.$proposal['zipcode'].' address.');
				if ($seller_account['notifications'] == 'Yes') {
					$this->mailer->regular_email('Agreement Declined', $user_email_text, $seller_account['email']);
				}
				$response["success"] = true;
				$response["success_title"] = 'Agreement Declined Successfully!';
				$response["success_message"] = 'You have successfully declined the selected agreement. We notified property owner that you have declined the agreement.';
				$response["newcard"] = '<div class="col-md-4" id="props-'.$agreement['agr_id'].'">
				<div class="card proplisting mb-2">
					'.generate_agreement_ribbon('Canceled', $agreement['expire_time']).'
				  <img class="card-img-top" src="'.base_url($agreement['default_image']).'" alt="Listing Image">
				  <div class="card-body orange-bg px-2">
				    <span class="float-left">Fee</span>
				    <span class="float-right"><b>$'.$agreement['agr_fee'].' USD</b></span>
				  </div>
				  <div class="card-footer addresspart p-2">
					  <strong>Address:</strong><p>'.$agreement['city'].', '.$agreement['state'].'</p>
				  </div>
				</div>
				<div class="px-2 text-center"></div></div>';

			}
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Gets list of properties by posted criterias
	 * @uses agent_model::get_licenses Gets list and details of agents licenses
	 * @uses agent_model::list_properties Gets list and details properties
	 *
	 * @return json Success|Fail details of declining selected agreement action
	 */
	public function list_properties(){
		$_POST['agent_id'] = $this->account['id'];
		if ($_POST['zipcode']) {
			if ($zipcode = geolocate_zipcode($_POST['zipcode'])) {
				$_POST['lat'] = $zipcode['latitude'];
				$_POST['long'] = $zipcode['longitude'];
			}
		}
		$alicenses = $this->agent_model->get_licenses($this->account['id'], 'Active');
		if ($alicenses) {
			foreach ($alicenses as $alicense) {
				$my_licenses[] = $alicense['license_state'];
			}
		}else{
			$my_licenses[] = 'No License';
		}
		if ($properties = $this->agent_model->list_properties($my_licenses, $_POST)) {
	    foreach ($properties as $key => $property) {
	    	$response['data'][$key]['property_id'] = $property["property_id"];
	    	$response['data'][$key]['image'] = '<img class="img-fluid" src="'.(($property['default_image'])? base_url(str_replace(".jpg","_mini.jpg",$property['default_image'])):base_url('assets/images/backend/propertyphoto_mini.jpg')).'" width="60" height="45" alt="">';
	    	$response['data'][$key]['location'] = $property["city"].'<br>'.$property["state"];
	    	$response['data'][$key]['type'] = (($property["type"] == 'Residential')? '<span class="prop_icons residential" data-toggle="tooltip" data-placement="left" title="Residential"></span>':'<span class="prop_icons commercial" data-toggle="tooltip" data-placement="left" title="Commercial"></span>');
	    	$response['data'][$key]['approx'] = '$'.number_format($property["approx_value"],0);
	    	$response['data'][$key]['rate'] = $property["commission_rate"].'%';
	    	$response['data'][$key]['length'] = $property["contract_length"].' Months';
	    	$response['data'][$key]['building_size'] = $property["building_size"].' sqft.';
	    	$response['data'][$key]['button'] = '<a href="#" class="button-orange smallerbutton float-left" id="saveproperty" data-propid="'.$property["property_id"].'" data-value="'.(($property["save_time"])? 'unsave':'save').'">'.(($property["save_time"])? 'Unsave':'Save').'</a> <a class="button-orange smallerbutton float-right" href="'.cortiam_base_url('view-property/').$property['property_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $property['city'].' '.$property['state'])), 'underscore', true).'">View</a>';
	    }
    }else{
    	$response['data'] = '';
    }
		echo json_encode($response);die();
	}

	/**
	 * Deactivates agent account
	 * @uses ion_auth::update Updates simple account details
	 * @uses ion_auth::logout Logouts user from system
	 * @uses agent_model::collect_trash Finds and clears unwanted agent data
	 *
	 * @return json Success|Fail details of deactivating agent account action
	 */
	public function deactivate_me(){
		if($this->input->post("recordID")) {
			$data = array(
				'active' => 0,
				'email' => uniqid('email_').uniqid().'@deleted.com',
				'deleted_email' => $this->account['email'],
			);
			if ($hesapid = $this->ion_auth->update($this->account['id'], $data)) {
				$this->agent_model->collect_trash($this->account['id']);
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
	 * Send support request for agent account
	 * @uses agent_model::add_support Adds support request to database
	 * @uses agent_model::get_notified Gets admin accounts to be notified by action id
	 * @uses agent_model::add_notification Add notification for selected user
	 *
	 * @return json Success|Fail details of sending support request action
	 */
	public function send_support(){
		if (!$this->input->post("message_text")) {$response["errorfields"]['message_text'] = "Your Message";}

		if(count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}else{
			$msg_data = array(
				'agent_id' => $this->account['id'],
				'msg_from' => 'Agent',
				'message_text' => $this->input->post("message_text"),
				'message_date' => time(),
			);
			if($this->agent_model->add_support($msg_data)){
				$admin_email_text = '<h3 style="color:#4c525e;">REAL ESTATE AGENT SUPPORT REQUEST</h3><p style="color:#848994;">'.$this->account['first_name'].' '.$this->account['last_name'].' created new support request on Cortiam. For more information please login to Cortiam to check this action details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->agent_model->get_notified(130);
				$this->agent_model->add_notification($admin_emails, 'Real Estate Agent New Support Request', $this->account['first_name'].' '.$this->account['last_name'].' created new support request on Cortiam.', 'agent_support', $this->account['id']);
				$this->mailer->regular_email('Real Estate Agent New Support Request', $admin_email_text, $admin_emails);

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
	 * Gets add o edit license form
	 * @uses agent_model::get_license Gets details of selected license
	 *
	 * @return json Success|Fail details of creating license form action
	 */
	public function get_licenseform(){
		$response["success"] = true;
		if ($license_details = $this->agent_model->get_license($this->ion_auth->get_user_id(), $this->input->post("licenseid"))) {
			$response["form"] = '<div class="outcome"><div class="error" role="alert"></div></div>
							<form id="new-license-form">
							<div class="row">
								<h5 class="col-sm-12">License Info</h5>
								<div class="col-md-7">
									<div class="form-group">
										<input type="text" name="license_number" id="license_number" class="form-control" placeholder="License Number" value="'.$license_details['license_number'].'">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<input type="text" name="license_expire" id="license_expire" class="form-control" placeholder="License Expiration Date" value="'.date('m/d/Y',$license_details['license_expire']).'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="license_state" id="license_state" class="form-control" placeholder="State Licensed" value="'.$license_details['license_state'].'">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select class="form-control select" name="interested" id="interested" placeholder="Real Estate Focus">
											<option value="">Real Estate Focus</option>
											<option value="Residential" '.(($license_details['interested'] == 'Residential')? 'selected':'').'>Residential</option>
											<option value="Commercial" '.(($license_details['interested'] == 'Commercial')? 'selected':'').'>Commercial</option>
											<option value="Both" '.(($license_details['interested'] == 'Both')? 'selected':'').'>Both</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<input type="hidden" name="license_id" value="'.$license_details['license_id'].'">
						  		<button id="license-update-button" class="button-orange float-right">Update License</button>
						  		<button id="license-cancel-button" class="button-dark left">Cancel</button>
						  	<div>
					  	<div>
							</form>';
		}else{
			$response["form"] = '<div class="outcome"><div class="error" role="alert"></div></div>
							<form id="new-license-form">
							<div class="row">
								<h5 class="col-sm-12">License Info</h5>
								<div class="col-md-7">
									<div class="form-group">
										<input type="text" name="license_number" id="license_number" class="form-control" placeholder="License Number">
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<input type="text" name="license_expire" id="license_expire" class="form-control" placeholder="License Expiration Date">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<input type="text" name="license_state" id="license_state" class="form-control" placeholder="State Licensed">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<select class="form-control select" name="interested" id="interested" placeholder="Real Estate Focus">
											<option value="">Real Estate Focus</option>
											<option value="Residential">Residential</option>
											<option value="Commercial">Commercial</option>
											<option value="Both">Both</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
						  		<button id="license-add-button" class="button-orange float-right">Save License</button>
						  		<button id="license-cancel-button" class="button-dark left">Cancel</button>
						  	<div>
					  	<div>
							</form>';
		}
		echo json_encode($response);die();
	}

	/**
	 * Adds new agent license
	 * @uses agent_model::add_license Add details of new license
	 * @uses agent_model::add_notification Add notification for selected user
	 * @uses agent_model::get_notified Gets admin accounts to be notified by action id
	 * @uses agent_model::add_approval Add approval details for new agent license
	 * @uses ion_auth::update Update basic account details
	 *
	 * @return json Success|Fail details of adding new agent license action
	 */
	public function add_license(){


		if (!$this->input->post("license_number")) {$response["errorfields"]['license_number'] = "License Number";}
		if (!$this->input->post("license_expire")) {$response["errorfields"]['license_expire'] = "License Expiration Date";}
		if (!$this->input->post("license_state")) {$response["errorfields"]['license_state'] = "State Licensed";}
		if (!$this->input->post("interested")) {$response["errorfields"]['interested'] = "Real Estate Focus";}

		if(isset($response["errorfields"]) && count($response["errorfields"]) > 0) {
			$response["fail"] = true;
			$response["fail_title"] = 'Required/Missing Fields!';
			$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
		}elseif(strtotime($this->input->post("license_expire")." 12:00:00 AM") < time()){
			$response["errorfields"]['license_expire'] = "License Expiration Date";
			$response["fail"] = true;
			$response["fail_title"] = 'Invalid Expiration Date!';
			$response["fail_message"] = 'License expiration date cannot be earlier than today. Please check&fix your license expiration date and try again.';
		}else{
			$record_data = array(
				'agent_id' => $this->ion_auth->get_user_id(),
				'license_number' => $this->input->post("license_number"),
				'license_expire' => (($this->input->post("license_expire"))? strtotime($this->input->post("license_expire")." 12:00:00 AM"):null),
				'license_state' => $this->input->post("license_state"),
				'interested' => $this->input->post("interested"),
				'added_date' => time(),
			);
			if($this->agent_model->add_license($record_data)){
				$this->ion_auth->update($this->account['id'], array('approval' => 'Waiting'));

				$changed_text_array[] = 'added License Number "'.$this->input->post("license_number").'"';
				$changed_text_array[] = 'added License Expiration Date "'.$this->input->post("license_expire").'"';
				$changed_text_array[] = 'added Real Estate Focus "'.$this->input->post("interested").'"';
				$changed_text_array[] = 'added State Licensed "'.$this->input->post("license_state").'"';
				$approval_data = array(
					'agent_id' => $this->account['agent_id'],
					'message_date' => time(),
					'message_text' => 'I '.implode(', ',$changed_text_array).'. Please review and approve my new details.',
					'type' => 'User',
				);
				$this->agent_model->add_approval($approval_data);

				$admin_email_text = '<h3 style="color:#4c525e;">NEW LICENSE</h3><p style="color:#848994;">Real Estate Agent '.$this->account['first_name'].' '.$this->account['last_name'].' added new license. New license details will need to be approved. For more information please login to Cortiam to check approval details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
				$admin_emails = $this->agent_model->get_notified(50);
				$this->agent_model->add_notification($admin_emails, 'Real Estate Agent License Needs Approval', 'Real Estate Agent '.$this->account['first_name'].' '.$this->account['last_name'].' added new license. New license details will need to be approved.', 'agent_review', $this->account['id']);
				$this->mailer->regular_email('Real Estate Agent License Needs Approval', $admin_email_text, $admin_emails);
				$response["success"] = true;
				$response["success_title"] = 'License Added Successfully!';
				$response["success_message"] = 'New license added successfully. Because new license added, we need to validate your license details. In meantime your account status will be remain in approval status.';
			}else{
				$response["fail"] = true;
				$response["fail_title"] = 'Unexpected Error!';
				$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
			}
		}
		echo json_encode($response);die();
	}

	/**
	 * Edit selected agent license
	 * @uses agent_model::get_license Gets details of selected license
	 * @uses agent_model::edit_license Update details of selected license
	 * @uses agent_model::add_notification Add notification for selected user
	 * @uses agent_model::get_notified Gets admin accounts to be notified by action id
	 * @uses agent_model::add_approval Add approval details for new agent license
	 * @uses ion_auth::update Update basic account details
	 *
	 * @return json Success|Fail details of updating selected agent license action
	 */
	public function edit_license(){
		if ($this->input->post("license_id")) {
			if (!$this->input->post("license_number")) {$response["errorfields"]['license_number'] = "License Number";}
			if (!$this->input->post("license_expire")) {$response["errorfields"]['license_expire'] = "License Expiration Date";}
			if (!$this->input->post("license_state")) {$response["errorfields"]['license_state'] = "State Licensed";}
			if (!$this->input->post("interested")) {$response["errorfields"]['interested'] = "Real Estate Focus";}

			if(count($response["errorfields"])) {
				$response["fail"] = true;
				$response["fail_title"] = 'Required/Missing Fields!';
				$response["fail_message"] = implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.';
			}elseif(strtotime($this->input->post("license_expire")." 12:00:00 AM") < time()){
				$response["errorfields"]['license_expire'] = "License Expiration Date";
				$response["fail"] = true;
				$response["fail_title"] = 'Invalid Expiration Date!';
				$response["fail_message"] = 'License expiration date cannot be earlier than today. Please check&fix your license expiration date and try again.';
			}else{
				$record_data = array(
					'license_number' => $this->input->post("license_number"),
					'license_expire' => (($this->input->post("license_expire"))? strtotime($this->input->post("license_expire")." 12:00:00 AM"):null),
					'license_state' => $this->input->post("license_state"),
					'interested' => $this->input->post("interested"),
					'license_status' => 'Pending',
					'added_date' => time(),
				);
				$license_details = $this->agent_model->get_license($this->ion_auth->get_user_id(), $this->input->post("license_id"));
				if($this->agent_model->edit_license($this->input->post("license_id"), $record_data)){
					$this->ion_auth->update($this->account['id'], array('approval' => 'Waiting'));
					if ($license_details['license_number'] != $this->input->post("license_number")) {
						$changed_text_array[] = 'updated my License Number from "'.$license_details['license_number'].'" to "'.$this->input->post("license_number").'"';
					}
					if ($license_details['license_expire'] != strtotime($this->input->post("license_expire")." 12:00:00 AM")) {
						$changed_text_array[] = 'updated my License Expiration Date from "'.date("m-d-Y",$license_details['license_expire']).'" to "'.$this->input->post("license_expire").'"';
					}
					if ($license_details['interested'] != strtotime($this->input->post("interested"))) {
						$changed_text_array[] = 'updated my Real Estate Focus from "'.date("m-d-Y",$license_details['interested']).'" to "'.$this->input->post("interested").'"';
					}
					if ($license_details['license_state'] != $this->input->post("license_state")) {
						$changed_text_array[] = 'updated my State Licensed from "'.date("m-d-Y",$license_details['license_state']).'" to "'.$this->input->post("license_state").'"';
					}
					$approval_data = array(
						'agent_id' => $this->account['agent_id'],
						'message_date' => time(),
						'message_text' => 'I '.implode(', ',$changed_text_array).'. Please review and approve my new details.',
						'type' => 'User',
					);
					$this->agent_model->add_approval($approval_data);

					$admin_email_text = '<h3 style="color:#4c525e;">LICENSE UPDATED</h3><p style="color:#848994;">Real Estate Agent '.$this->account['first_name'].' '.$this->account['last_name'].' updated agent license details. New license details will need to be approved. For more information please login to Cortiam to check approval details.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$admin_emails = $this->agent_model->get_notified(50);
					$this->agent_model->add_notification($admin_emails, 'Real Estate Agent License Needs Approval', 'Real Estate Agent '.$this->account['first_name'].' '.$this->account['last_name'].' updated agent license details. New license details will need to be approved.', 'agent_review', $this->account['id']);
					$this->mailer->regular_email('Real Estate Agent License Needs Approval', $admin_email_text, $admin_emails);
					$response["success"] = true;
					$response["success_title"] = 'License Updated Successfully!';
					$response["success_message"] = 'Your license updated successfully. Because your license details updated, we need to validate your license details. In meantime your account status will be remain in approval status.';
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
	 * Delete selected agent license
	 * @uses agent_model::get_license Gets details of selected license
	 * @uses agent_model::edit_license Update details of selected license
	 * @uses agent_model::get_licenses Get licences of current agents
	 * @uses agent_model::add_approval Add approval details for new agent license
	 * @uses ion_auth::update Update basic account details
	 *
	 * @return json Success|Fail details of deleting selected agent license action
	 */
	public function delete_license(){
		if ($this->input->post("license_id")) {
			if($license = $this->agent_model->get_license($this->ion_auth->get_user_id(), $this->input->post("license_id"))) {
				$record_data = array(
					'license_status' => 'Removed',
				);
				if($this->agent_model->edit_license($this->input->post("license_id"), $record_data)){
					$licenses = $this->agent_model->get_licenses($this->ion_auth->get_user_id(), 'Active');
					if (!$licenses) {
						$this->ion_auth->update($this->account['id'], array('approval' => 'Waiting'));
						$response["success"] = true;
						$response["success_title"] = 'License Deleted Successfully!';
						$approval_data = array(
							'agent_id' => $this->account['agent_id'],
							'message_date' => time(),
							'message_text' => 'Account out in approval status because no active agent license left.',
							'type' => 'User',
						);
						$this->agent_model->add_approval($approval_data);
						$response["success_message"] = 'Your '.(($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']).' License for '.$license['license_state'].' deleted successfully. Because you have no active license left, your account status will be remain in approval status until you add a new agent license.';
					}else{
						$response["success"] = true;
						$response["success_title"] = 'License Deleted Successfully!';
						$response["success_message"] = 'Your '.(($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']).' License for '.$license['license_state'].' deleted successfully.';
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
		}else{
			$response["fail"] = true;
			$response["fail_title"] = 'Unexpected Error!';
			$response["fail_message"] = 'There is an unexpected error occured, please refresh the page and try again.';
		}
		echo json_encode($response);die();
	}

	/**
	 * Get licenses of current agent
	 * @uses agent_model::get_licenses Get licences of current agents
	 *
	 * @return json Success|Fail details of getting current agents licenses action
	 */
	public function list_licenses(){
		if ($licenses = $this->agent_model->get_licenses($this->ion_auth->get_user_id())) {
			foreach ($licenses as $license) {
				$response["form"] .= '<li class="profile-list-item">
							  <div class="row no-gutters">
								  <div class="col-sm-8">
								  	<p class="titlepart"><strong>'.(($license['interested'] == 'Both')? 'Residential & Commercial':$license['interested']).' License for '.$license['license_state'].'</strong></p>
								  	<p class="subtitlepart">Expires on '.date('m-d-Y', $license['license_expire']).'</p>
							  	</div>
								  <div class="col-sm-2 align-middle text-center">'.generate_license_status_pill($license['license_status']).'</div>
								  <div class="col-sm-2 align-middle text-right">
										<div class="btn-group mt-2 dropleft" data-toggle="tooltip" data-placement="left" title="Click for options">
											<span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="cardopenmenu"><i class="icon-menu"></i></span>
											<div class="dropdown-menu">
												<button class="dropdown-item" type="button" id="editmylicense" data-id="'.$license['license_id'].'">Edit Details</button>
												<button class="dropdown-item" type="button" id="deletemylicense" data-id="'.$license['license_id'].'">Delete</button>
											</div>
										</div>
							  	</div>
							  	</div>
						  </li>';
			}
		}else{
			$response["form"] = '<li class="list-group-item text-center">Please add your agent license for your account.</li>';
		}
		$response["success"] = true;
		echo json_encode($response);die();
	}

	/**
	 * Accept terms of service for current agent
	 * @uses agent_model::edit_agent Update details of current agent account
	 *
	 * @return json Success|Fail details of accepting terms of service action
	 */
	public function accept_tos(){
		if($this->input->post("tos_accepted")) {
			$additional_data = array(
				'accept_tos' => time(),
			);
			$this->agent_model->edit_agent($this->account['id'], $additional_data);
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

	public function update_plan()
	{	
	
		$plan_id = $_REQUEST['plan_id'];		
		$user_id = $this->ion_auth->get_user_id();
		$success = $this->agent_model->set_member_plan($plan_id, $user_id);
		if($success)
		{
			echo "true";
			exit;

		}else{
			echo "false";
			exit;
	
		}

	}
}
?>