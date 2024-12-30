<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Frontend Process controller
 *
 * The base controller which process page actions of the Cortiam Web Application Frontend Panel
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

class Frontendprocess extends CRTM_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('frontend_model');
		$this->load->helper(array('backend'));
		$this->load->library('session');

	}

	/**
	 * Add new seller account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function signup_seller(){

		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email Address";}
		if (!$this->input->post("phone")) {$response["errorfields"]['phone'] = "Phone Number";}
		if (!$this->input->post("state")) {$response["errorfields"]['statecontainer'] = "State";}
		if (!$this->input->post("city")) {$response["errorfields"]['citycontainer'] = "City";}
		if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
		if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Confirmation";}

			//$this->mailer->regular_email('New Property Owner Account Created', 'test email', 'abaig4325@hotmail.com'); for testing perpose...

		try {
			//code...
		if ( isset($response["errorfields"]) && count($response["errorfields"]) > 0) {
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Required/Missing Fields</h4>'.implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.</div>';

		}elseif (!preg_match($this->config->item('email_pattern'), $this->input->post("email"))) {
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Invalid Email Address</h4>Your email address format is invalid, please use a valid email address and try again.</div>';
		}elseif (!preg_match($this->config->item('phone_pattern'), $this->input->post("phone"))) {
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Invalid Phone Number</h4>Your phone number format is invalid, please use a valid phone number and try again.</div>';
		}elseif ($this->input->post("password") != $this->input->post("passwordagain")) {
			$response["errorfields"]['password'] = "Password";
			$response["errorfields"]['passwordagain'] = "Password Confirmation";
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Password Doesnt Match</h4>The password and password confirmation fields does not match. Please check out password fields and try again.</div>';
		}else{

			if ($this->frontend_model->check_state($this->input->post("state"))) {
				$additional_data = array(
					'first_name' => $this->input->post("first_name"),
					'last_name' => $this->input->post("last_name"),
					'phone' => $this->input->post("phone"),
					'avatar_string' => 'images/avatar/'.uniqid('usr_',true).'.jpg',
				);
                $email_verification_token = md5(uniqid());

				if ($hesapid = $this->ion_auth->register($this->input->post("email"), $this->input->post("password"), $this->input->post("email"), array('user_type' => 'Seller','approval' => 'Completed', 'approval_date' => time(), 'email_verification_token' => $email_verification_token))) {
	
					$details = array(
					'first_name' => $this->input->post("first_name"),
					'last_name' => $this->input->post("last_name"),
					'phone' => $this->input->post("phone"),
					'email' => $this->input->post("email"),
					'source' => 'Web Seller Account',
					);
					if ($ztoken = $this->zoho_access_token()) {
						$this->zoho_add_lead($ztoken,$details);
					}

					$additional_data['seller_id'] = $hesapid;
					$this->frontend_model->add_seller($additional_data);
					$this->create_avatar($additional_data['avatar_string'],$additional_data['first_name'],$additional_data['last_name']);
					$response["success"] = true;

					// $this->ion_auth->dologin($this->input->post("email"));

					$response["redirect_to"] = base_url('signup-successfully');
					
					$admin_email_text = '<h3 style="color:#4c525e;">NEW PROPERTY OWNER ACCOUNT</h3><p style="color:#848994;">'.$additional_data['first_name'].' '.$additional_data['last_name'].' created new property owner account on Cortiam.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
					$admin_emails = $this->frontend_model->get_notified(70);
					//$this->frontend_model->add_notification($admin_emails, 'New Property Owner Account Created', $additional_data['first_name'].' '.$additional_data['last_name'].' created new property owner account on Cortiam.', 'seller_edit', $hesapid);
					//$this->mailer->regular_email('New Property Owner Account Created', $admin_email_text, 'accounts@cortiam.com');
				}else{
					$response["fail"] = true;
					$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Error!</h4>'.(($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.').'</div>';
				}
			}else{
				$response["askfor"] = true;
				$response["askfor_title"] = 'Be The First To Be Notified!';
				$response["askfor_message"] = 'We are sorry, Cortiam is currently not available in your location. If you would like us to contact you when we are available in your area, please click the below "<b>Accept</b>" button to share your information with us.';
				$response["cancelty_title"] = 'Thank You For Interest in Cortiam!';
				$response["cancelty_message"] = 'As your requests, your details not shared with us. Please check back with us soon if we are available in your area.';
			}
		}

		} catch (\Throwable $th) {
			echo '<pre>';
			print_r($th);
			exit;
		
		}
		$this->session->unset_userdata('Seller');
		echo json_encode($response);die();
	}


	/**
	 * Add new agent account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function signup_agent(){

    	if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email Address";}
		if (!$this->input->post("phone")) {$response["errorfields"]['phone'] = "Phone Number";}
		if (!$this->input->post("state")) {$response["errorfields"]['statecontainer'] = "State";}
		if (!$this->input->post("city")) {$response["errorfields"]['citycontainer'] = "City";}
		if (!$this->input->post("password")) {$response["errorfields"]['password'] = "Password";}
		if (!$this->input->post("passwordagain")) {$response["errorfields"]['passwordagain'] = "Password Confirmation";}

		if (isset($response["errorfields"]) && is_array($response["errorfields"]) && count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Required/Missing Fields</h4>'.implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.</div>';
		}elseif (!preg_match($this->config->item('email_pattern'), $this->input->post("email"))) {
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Invalid Email Address</h4>Your email address format is invalid, please use a valid email address and try again.</div>';
		} elseif (!preg_match($this->config->item('phone_pattern'), $this->input->post("phone"))) {
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Invalid Phone Number</h4>Your phone number format is invalid, please use a valid phone number and try again.</div>';
		}
        elseif ($this->input->post("password") != $this->input->post("passwordagain")) {
			$response["errorfields"]['password'] = "Password";
			$response["errorfields"]['passwordagain'] = "Password Confirmation";
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Password Doesnt Match</h4>The password and password confirmation fields does not match. Please check out password fields and try again.</div>';
		}else{
			
			if ($this->frontend_model->check_state($this->input->post("state"))) {
				$additional_data = array(
					'first_name' => $this->input->post("first_name"),
					'last_name' => $this->input->post("last_name"),
					'phone' => $this->input->post("phone"),
				);
                $email_verification_token = md5(uniqid());

				if ($hesapid = $this->ion_auth->register($this->input->post("email"), $this->input->post("password"), $this->input->post("email"), array('user_type' => 'Agent', 'approval_date' => time(), 'previously_approved' => 'No', 'email_verification_token' => $email_verification_token))) 
				{
					$details = array(
					'first_name' => $this->input->post("first_name"),
					'last_name' => $this->input->post("last_name"),
					'phone' => $this->input->post("phone"),
					'email' => $this->input->post("email"),
					'source' => 'Web Agent Account',
					);
					if ($ztoken = $this->zoho_access_token()) {
						$this->zoho_add_lead($ztoken,$details);
					}

                    // Disable login
					$additional_data['agent_id'] = $hesapid;
					$this->frontend_model->add_agent($additional_data);
					$response["success"] = true;
					$response["redirect_to"] = base_url('signup-successfully');
//					$this->ion_auth->dologin($this->input->post("email"));
//					$response["redirect_to"] = base_url('agent/edit-account');

                    // $user_email_text = '<h3 style="color:#4c525e;">WELCOME TO CORTIAM</h3><h4 style="color:#848994;">Thank You for Joining Cortiam!</h4><p>Please verify your email by clicking verification link.</p><p style="text-align:center;"><a href="'.base_url('verify/email').'/' . $email_verification_token. '" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;font-weight:bold;text-transform:uppercase;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Verify Email</a></p>';
                    // $this->mailer->regular_email('Verify Your Email Cortiam!', $user_email_text, $this->input->post("email"));

//					$user_email_text = '<h3 style="color:#4c525e;">WELCOME TO CORTIAM</h3><h4 style="color:#848994;">Thank You for Joining Cortiam!</h4><p>Your registration has been submitted successfully. Your account will be activated shortly after the validation process. While waiting for the validation process you can login to your account with the email and password you selected and check your validation status or complete setting up your profile.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;font-weight:bold;text-transform:uppercase;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
//					$this->mailer->regular_email('Thank You for Joining Cortiam!', $user_email_text, $this->input->post("email"));
//
//					$admin_email_text = '<h3 style="color:#4c525e;">NEW REAL ESTATE AGENT ACCOUNT</h3><p style="color:#848994;">'.$additional_data['first_name'].' '.$additional_data['last_name'].' has created new real estate agent account on Cortiam. Please login to Cortiam to validate this account as soon as possible.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
//					$admin_emails = $this->frontend_model->get_notified(40);
//					$this->frontend_model->add_notification($admin_emails, 'New Real Estate Agent Account Created', $additional_data['first_name'].' '.$additional_data['last_name'].' has created new real estate agent account on Cortiam.', 'agent_review', $hesapid);
//					$this->mailer->regular_email('New Real Estate Agent Account Created', $admin_email_text, 'accounts@cortiam.com');

					log_message('error', 'success_full_Actions');


				}else{
					$response["fail"] = true;
					$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Error!</h4>'.(($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.').'</div>';
				}
			}else{
				$response["askfor"] = true;
				$response["askfor_title"] = 'Be The First To Be Notified!';
				$response["askfor_message"] = 'We are sorry, Cortiam is currently not available in your location. If you would like us to contact you when we are available in your area, please click to "<b>Accept</b>" button to share your information with us.';
				$response["cancelty_title"] = 'Thank You For Interest in Cortiam!';
				$response["cancelty_message"] = 'As your requests, your details not shared with us. Please check back with us soon if we are available in your area.';
			}
		}
	
		log_message('error', 'before_json');
		echo json_encode($response);die();
	}


	public function signup_email()
	{
		$findEmail    = $this->frontend_model->find_email($_REQUEST);
		if($findEmail == "true")
		{
			$response["success"]  = "success";
			$response["messsage"] = 'Email already in use please enter another one';
			echo json_encode($response);die();
		}


	}

	/**
	 * Add new agent account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function notify_seller(){
		$details = array(
		'first_name' => $this->input->post("first_name"),
		'last_name' => $this->input->post("last_name"),
		'phone' => $this->input->post("phone"),
		'email' => $this->input->post("email"),
		'state' => $this->input->post("state"),
		'city' => $this->input->post("city"),
		'user_type' => 'Property Owner',
		'signup_time' => time(),
		);
		if ($hesapid = $this->frontend_model->waiting_user($details)) {
			$admin_email_text = '<h3 style="color:#4c525e;">NEW PROPERTY OWNER ADDED TO WAITING LIST</h3><p style="color:#848994;">'.$details['first_name'].' '.$details['last_name'].' requested notification when Cortiam will be available in '.$details['state'].' - '.$details['city'].'.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
			$admin_emails = $this->frontend_model->get_notified(10);
			$this->frontend_model->add_notification($admin_emails, 'New Property Owner Added To Waiting List', $details['first_name'].' '.$details['last_name'].' added to waiting list.', 'seller_edit', $hesapid);
			$this->mailer->regular_email('New Property Owner Added To Waiting List', $admin_email_text, $admin_emails);
			$response["success"] = true;
			$response["redirect_to"] = base_url('notification-successfully');
		}else{
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Error!</h4>'.(($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.').'</div>';
		}
		echo json_encode($response);die();
	}

	/**
	 * Add new agent account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function notify_agent(){
		$details = array(
		'first_name' => $this->input->post("first_name"),
		'last_name' => $this->input->post("last_name"),
		'phone' => $this->input->post("phone"),
		'email' => $this->input->post("email"),
		'state' => $this->input->post("state"),
		'city' => $this->input->post("city"),
		'user_type' => 'Real Estate Agent',
		'signup_time' => time(),
		);
		if ($hesapid = $this->frontend_model->waiting_user($details)) {
			$admin_email_text = '<h3 style="color:#4c525e;">NEW AGENT ADDED TO WAITING LIST</h3><p style="color:#848994;">'.$details['first_name'].' '.$details['last_name'].' requested notification when Cortiam will be available in '.$details['state'].' - '.$details['city'].'.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
			$admin_emails = $this->frontend_model->get_notified(10);
			$this->frontend_model->add_notification($admin_emails, 'New Agent Added To Waiting List', $details['first_name'].' '.$details['last_name'].' added to waiting list.', 'seller_edit', $hesapid);
			$this->mailer->regular_email('New Agent Added To Waiting List', $admin_email_text, $admin_emails);
			$response["success"] = true;
			$response["redirect_to"] = base_url('notification-successfully');
		}else{
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Error!</h4>'.(($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.').'</div>';
		}
		echo json_encode($response);die();
	}


	/**
	 * Add new agent account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function locate_agent(){
		if ((!$this->input->post("zipcode")) && (!$this->input->post("city")) && (!$this->input->post("state"))) {
			$response["fail"] = true;
			$response["fail_title"] = 'Missing Search Parameter!';
			$response["fail_message"] = 'Please enter at least one of the Zip Code, City or State fields to define your search.';
		}else{
			$response["success"] = true;
			if ($this->input->post("zipcode")) {
				if ($latlong = geolocate_address($this->input->post("city"),$this->input->post("state"),$this->input->post("zipcode"),null,null)) {
//					$response["latlong"] = $latlong;
					$agents = $this->frontend_model->locate_agent($latlong['latitude'],$latlong['longitude']);
				}else{
					$response['html'] = '<div class="col-md-7"><div class="agentsnoresult">Sorry, we are unable to find an agent that matches with your search criterias</div></div>';
				}
			}else{
				$filter['city'] = $this->input->post("city");
				$filter['state'] = $this->input->post("state");
				$agents = $this->frontend_model->find_agent_by_names($filter);
			}
			if ($agents) {
				foreach ($agents as $agent) {
			  	$purl = base_url('agent-profile/').$agent['agent_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $agent['agent'])), 'underscore', true);
					$response['html'] .= '<a target="_blank" href="'.$purl.'" class="col-md-3"><div class="agentbox"><div class="agentimage"><img class="card-img-top" src="'.(($agent['agent_image'])? base_url($agent['agent_image']):base_url('images/userphoto.jpg')).'" alt="Listing Image"><div class="agenttext"><div class="placer"><h3>'.$agent['agent'].'</h3><p>'.$agent['brokerage_name'].'</p></div></div></div></div></a>';
				}
			}else{
				$response['html'] = '<div class="col-md-7"><div class="agentsnoresult">Sorry, we are unable to find an agent that matches with your search criterias</div></div>';
			}
		}
		echo json_encode($response);die();
	}


	/**
	 * Add new agent account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function join_our_team(){
		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email Address";}
		if (!$this->input->post("phone")) {$response["errorfields"]['phone'] = "Phone Number";}


		if (count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Required/Missing Fields</h4>'.implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.</div>';
		}else{
			$data = array(
				'first_name' => $this->security->xss_clean($this->input->post("first_name")),
				'last_name' => $this->security->xss_clean($this->input->post("last_name")),
				'email' => $this->security->xss_clean($this->input->post("email")),
				'phone' => $this->security->xss_clean($this->input->post("phone")),
				'added_on' => time(),
			);
			if ($join_id = $this->frontend_model->join_our_team($data)) {
				$response["success"] = true;
				$response["redirect_to"] = base_url('joinus-successfully');

				$user_email_text = '<h4 style="color:#4c525e;">Thank you for your interest in joining our team!</h4><p>Your information has been submitted successfully. We will contact you as future opportunities become available.</p>';
				$this->mailer->regular_email('Thank you for Your Interest in Joining Our Team', $user_email_text, $this->input->post("email"));
				$admin_email_text = '<h4 style="color:#4c525e;">JOIN OUR TEAM</h4><p>There is a new application sent from the Join Our Team form on the Cortiam website. Details displayed below;</p>
				<p style="color:#848994;">
				<b>First Name: </b>'.$data['first_name'].'<br>
				<b>Last Name: </b>'.$data['last_name'].'<br>
				<b>Email Adress: </b>'.$data['email'].'<br>
				<b>Phone Number: </b>'.preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $data['phone']).'</p>';
//				$admin_emails = $this->frontend_model->get_notified(160);
//				if ($admin_emails) {$this->mailer->regular_email('We Are Hiring Application', $admin_email_text, $admin_emails);}
				$this->mailer->regular_email('We Are Hiring Application', $admin_email_text, "careers@cortiam.com");
			}else{
				$response["fail"] = true;
				$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Error!</h4>'.(($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.').'</div>';
			}
		}
		echo json_encode($response);die();
	}


	/**
	 * Add new agent account
	 * @uses system_model::add_seller To add details of seller account
	 *
	 * @return json true or false
	 */
	public function contact_us(){
		if (!$this->input->post("first_name")) {$response["errorfields"]['first_name'] = "First Name";}
		if (!$this->input->post("last_name")) {$response["errorfields"]['last_name'] = "Last Name";}
		if (!$this->input->post("email")) {$response["errorfields"]['email'] = "Email Address";}
		if (!$this->input->post("phone")) {$response["errorfields"]['phone'] = "Phone Number";}
		if (!$this->input->post("comments")) {$response["errorfields"]['comments'] = "Comments";}

		$admin_emails = $this->frontend_model->get_notified(150);
		$response['emails'] = $admin_emails;
		if (count($response["errorfields"])) {
			$response["fail"] = true;
			$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Required/Missing Fields</h4>'.implode(', ',$response["errorfields"]). ' field(s) are required. Please fill out all the required/missing fields and try again.</div>';
		}else{
			$data = array(
				'first_name' => $this->security->xss_clean($this->input->post("first_name")),
				'last_name' => $this->security->xss_clean($this->input->post("last_name")),
				'email' => $this->security->xss_clean($this->input->post("email")),
				'phone' => $this->security->xss_clean($this->input->post("phone")),
				'comments' => $this->security->xss_clean($this->input->post("comments")),
				'added_on' => time(),
			);
			if ($join_id = $this->frontend_model->contact_request($data)) {
				$response["success"] = true;
				$response["html"] = '<h3>THANK YOU</h3><p>Your message was sent successfully! Thank you for contacting us and for visiting Cortiam.com. A member of the team will be in touch with you shortly to discuss your request.</p>';

				$user_email_text = '<h4 style="color:#4c525e;">THANK YOU</h4><h5 style="color:#848994;">Your message send successfully!</h5><p>Thank you for contacting us and for visiting Cortiam.com. A member of the team will be in touch with you shortly to discuss your request.</p>';
				$this->mailer->regular_email('Thanks for Contacting Cortiam', $user_email_text, $this->input->post("email"));
				$admin_email_text = '<h4 style="color:#4c525e;">CONTACT REQUEST</h4><p>There is a new contact request made from the Cortiam website. Details displayed below;</p>
				<p style="color:#848994;">
				<b>First Name: </b>'.$data['first_name'].'<br>
				<b>Last Name: </b>'.$data['last_name'].'<br>
				<b>Email Adress: </b>'.$data['email'].'<br>
				<b>Phone Number: </b>'.preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '$1-$2-$3', $data['phone']).'<br>
				<b>Comments: </b>'.$data['comments'].'</p>';
//				$admin_emails = $this->frontend_model->get_notified(160);
//				if ($admin_emails) {$this->mailer->regular_email('Contact Request', $admin_email_text, $admin_emails);}
				$this->mailer->regular_email('Contact Request', $admin_email_text, "customerservice@cortiam.com");
			}else{
				$response["fail"] = true;
				$response["fail_message"] = '<div class="cortiam-alert" role="alert"><h4>Error!</h4>'.(($this->ion_auth->errors())? $this->ion_auth->errors():'There is an unexpected error occured, please refresh the page and try again.').'</div>';
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
	public function zoho_access_token(){
		if ($dbtoken = $this->frontend_model->get_token(time())) {
		  return $dbtoken['token'];
		}else{
		  $curl_pointer = curl_init();

		  $curl_options = array();
		  $refresh_token = "1000.29eab2ad64692d22691199b10077e6b8.502095d3d263c8774e00763ed75c6845";
		  $client_id = "1000.POKL5UPMAVIPGZCRL0D4EM9KJL2Q2O";
		  $client_secret = "a68bb60349c1e1c8a877a5d07c4628993cd73cf0e0";
		  $grant_type = "refresh_token";
		  $url = "https://accounts.zoho.com/oauth/v2/token?refresh_token=$refresh_token&client_id=$client_id&client_secret=$client_secret&grant_type=$grant_type";

		  $curl_options[CURLOPT_URL] =$url;
		  $curl_options[CURLOPT_RETURNTRANSFER] = true;
		  $curl_options[CURLOPT_HEADER] = false;
		  $curl_options[CURLOPT_CUSTOMREQUEST] = "POST";

		  curl_setopt_array($curl_pointer, $curl_options);

		  $result = json_decode(curl_exec($curl_pointer), true);
		  curl_close($curl_pointer);
		  if ($result['access_token']) {
		  	$tokendata['token'] = $result['access_token'];
		  	$tokendata['token_time'] = time()+3400;
		  	$this->frontend_model->add_token($tokendata);
		  	return $result['access_token'];
		  }else{
		  	return false;
		  }
		}
	}

	/**
	 * Deletes selected client
	 * @uses system_model::update_account Updates selected client details
	 *
	 * @return json Details of actions response success/fail, error, message, redirection, etc..
	 */
	public function zoho_add_lead($token, $account_details){
	  $curl_pointer = curl_init();

	  $curl_options = array();
	  $url = "https://www.zohoapis.com/crm/v2/Leads";

	  $curl_options[CURLOPT_URL] =$url;
	  $curl_options[CURLOPT_RETURNTRANSFER] = true;
	  $curl_options[CURLOPT_HEADER] = false;
	  $curl_options[CURLOPT_CUSTOMREQUEST] = "POST";
	  $requestBody = array();
	  $recordArray = array();
	  $recordObject = array();
	  $recordObject["First_Name"] = $account_details["first_name"];
	  $recordObject["Last_Name"] = $account_details["last_name"];
	  $recordObject["Phone"] = $account_details["phone"];
	  $recordObject["Email"] = $account_details["email"];
	  $recordObject["Lead_Source"] = $account_details["source"];

	  $recordArray[] = $recordObject;
	  $requestBody["data"] =$recordArray;
	  $curl_options[CURLOPT_POSTFIELDS]= json_encode($requestBody);
	  $headersArray = array();

	  $headersArray[] = "Authorization". ":" . "Zoho-oauthtoken " . $token;

	  $curl_options[CURLOPT_HTTPHEADER]=$headersArray;

	  curl_setopt_array($curl_pointer, $curl_options);

	  $result = curl_exec($curl_pointer);
	  curl_close($curl_pointer);
	}



	public function payment()
	{

		require_once('vendor/autoload.php');
		// require_once('vendor/stripe-php/init.php');  
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
		$token = $_REQUEST['token'];

		log_message("error", $token);
		log_message("error", $this->config->item('stripe_secret'));


		$this->session->set_userdata('payment', 'completed'); 

		// $charge = \Stripe\Charge::create([
		// 	'amount' => 999,
		// 	'currency' => 'usd',
		// 	'description' => 'Example charge',
		// 	'source' => $token,
		//   ]);

		echo json_encode(array('success' =>  "Your Information save successfully!"));
		 
		// log_message("error", $token);

		// \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
	  
		// \Stripe\Charge::create ([
		// 		"amount" => 100 * 120,
		// 		"currency" => "inr",
		// 		"source" => $this->input->post('stripeToken'),
		// 		"description" => "Dummy stripe payment." 
		// ]);

	}


	public function resend_email()
	{
		$email = $this->session->userdata('email');

		$email_verification_token = md5(uniqid());
		$success = $this->frontend_model->set_token_token($email,  $email_verification_token);

		if($success)
		{
			$user_email_text  = '<h3 style="color:#4c525e;">WELCOME TO CORTIAM</h3><h4 style="color:#848994;">Thank You for Joining Cortiam!</h4><p>Please verify your email by clicking verification link.</p><p style="text-align:center;">';
			$user_email_text .= '<a href="'.base_url('verify/email').'/' . $email_verification_token. '" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;font-weight:bold;text-transform:uppercase;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Verify Email</a></p>';
			$this->mailer->regular_email('Resend Your Email Cortiam!', $user_email_text, $email);
			echo "true";
			exit;
		}

		echo "false";
		exit;

	}



}
?>