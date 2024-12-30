<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Authentication controller
 *
 * The authorization controller which controls login and logout of the Cortiam Web Application
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

class Gate extends CRTM_Controller {

	function __construct()	{
	
		parent::__construct();
		$this->load->database();
		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		$this->load->model('ion_auth_model');


		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/fonts.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/icons/icomoon/styles.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/bootstrap_limitless.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/layout.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/components.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/colors.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/animate.min.css');

		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/loaders/blockui.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/pnotify.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/datatables.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/buttons.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/styling/uniform.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/sweet_alert.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/formatter.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/styling/switchery.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/styling/switch.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/passy.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/validation/validate.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/maxlength.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/media/cropper.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/form.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/interactions.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/widgets.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/effects.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/mousewheel.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/globalize/globalize.js"');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/pickers/daterangepicker.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/selects/select2.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/trumbowyg.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/base64/trumbowyg.base64.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/cleanpaste/trumbowyg.cleanpaste.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/colors/trumbowyg.colors.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/insertaudio/trumbowyg.insertaudio.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/noembed/trumbowyg.noembed.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/preformatted/trumbowyg.preformatted.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/template/trumbowyg.template.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/upload/trumbowyg.upload.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/app.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/backend.js');

	}
	/**
	 * Displays user login page
	 *
	 * @return void
	 */
	public function login(){
		
		$sessionChecked = $this->session->get_userdata('Agent');
		if(isset($sessionChecked['user_type']) && $sessionChecked['user_type'] !== '' )
		{	
			if(isset($sessionChecked['user_type']) && $sessionChecked['user_type'] == 'Agent')
			{
				redirect('/agent', 'refresh');
			}
			if($sessionChecked['user_type'] == 'Seller')
			{
  			 	redirect('/seller', 'refresh');
			}
		}	

		$this->page_data['header_data']['meta_title'] .= ' - Login';
		$this->form_validation->set_rules('identity', 'Identity', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->_addjson('login',array("loginurl" => base_url('/logmein'), "forgeturl" => base_url('/forgot-password')));

		if ($this->form_validation->run() == true){

			$remember = (bool) $this->input->post('remember');
			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)){
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				log_message("error", "fresh");

				redirect('/', 'refresh');
			}else{
				$this->session->set_flashdata('message','Incorrect Username or Password');
				$this->page_data['message'] = (validation_errors()) ? 'Incorrect Username or Password' : $this->session->flashdata('message');
				log_message("error", "fresh login");
				
				log_message("error", "msg1");
				$this->_displaytemplate('login', 'login');
			}
		}else{
			$this->page_data['message'] = (validation_errors()) ? 'Incorrect Username or Password' : $this->session->flashdata('message')."aaa";


			$this->_frontend('login', 'frontend');
		}
	}


	/**
	 * Checks and process login after user credentials submission and redirects dashboard if success
	 * @uses ion_auth::login To check user credentials and login user
	 *
	 * @return json Success|Fail details
	 */
	public function user_login(){

		$this->form_validation->set_rules('lindentity', 'Email', 'required');
		$this->form_validation->set_rules('lpassword', 'Password', 'required');	

		if ($this->form_validation->run() == true)
		{
		    $remember = (bool) $this->input->post('remember');
			if ($this->ion_auth->login($this->input->post('lindentity'), $this->input->post('lpassword'), $remember)){

				$user_type = $this->ion_auth_model->getUserType($this->input->post('lindentity'));			

				switch ($user_type) {		
					    case 'Administrator':
						 $response["redirect_to"] = base_url('ct-admin');
						break;
					case 'Agent':
						$response["redirect_to"] = base_url('agent');
						break;
					case 'Seller':
						$response["redirect_to"] = base_url('seller');
						break;						
					default:
						$response["fail_message"] =  'User account is not available or actived';
						break;
				}

			}else{
				$response["fail"] = true;
				$response["fail_message"] = $this->ion_auth->errors();
			}
		}else{
			$response["fail"] = true;
			$response["fail_message"] = 'Please enter your email and password and try again.';
		}

		echo json_encode($response);
		die();
	}


	/**
	 * Process and sends forgot password email
	 *
	 * @param string $email User email
	 *
	 * @return json Success|Fail details
	 */
	public function forgot_password(){
		$this->form_validation->set_rules('remail', 'Email Address', 'required|valid_email');
		if ($this->form_validation->run() === FALSE){
			$response["fail"] = true;
			$response["fail_message"] = validation_errors() ;
		}else{
			$identity = $this->ion_auth->where('email', $this->input->post('remail'))->where('active', 1)->users()->row();
			if (empty($identity))	{
				$response["fail"] = true;
				$response["fail_title"] = 'Password Reset Failed';
				$response["fail_message"] = 'We are sorry but we cannot found a record of that email address.';
			}else{
				$code = $this->ion_auth_model->forgotten_password($identity->{'email'});
				if ($code){
					$user_email_text = '<h3 style="color:#4c525e;">PASSWORD CHANGE REQUEST</h3><h4 style="color:#848994;">We have received your request to change your Cortiam Password.</h4><p>Just so you know: You have 30 minutes to reset your password via this link below. After that, you will have to ask for a new reset request.</p><p>Didn\'t ask for a new password? You can ignore this email.<p><p style="text-align:center;"><a href="'.base_url('reset-password/'.$code).'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;font-weight:bold;text-align:center;text-transform:uppercase;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank">RESET YOUR PASSWORD</a></p>';
					$this->mailer->regular_email('Password Change Request', $user_email_text, $identity->{'email'});
					$response["success"] = true;
					$response["link"] = base_url('reset-password/'.$code);
					$response["success_title"] = 'Password Reset Successfully';
					$response["success_message"] = 'A password reset link was sent. Click the link in the email to create a new password. If you do not receive an email within 5 minutes, please click the re-send email link below.';
				}else{
					$response["fail"] = true;
					$response["fail_title"] = 'Password Reset Failed';
					$response["fail_message"] = 'We are sorry but we cannot found a record of that email address.';
				}
			}
		}
		echo json_encode($response);die();
	}

	public function reset_password($code = NULL){
		if (!$code){
			$this->page_data['header_data']['meta_title'] .= ' - Page Not Found';
			$this->page_data['header_data']['page_title'] = 'Page Not Found';
			$this->page_data['header_data']['current_menu'] = '';

			$this->_frontend('error404');
			return false;
		}

		if ($user = $this->ion_auth->forgotten_password_check($code)){
			$this->page_data['header_data']['meta_title'] .= ' - Password Reset Successfully';
			$this->page_data['header_data']['page_title'] = 'Password Reset Successfully';
			$this->page_data['header_data']['current_menu'] = '';

			$identity = $user->{$this->config->item('identity', 'ion_auth')};
			$new_password = substr(uniqid(),0,7);
			$this->ion_auth->reset_password($identity, $new_password);
			$user_email_text = '<h3 style="color:#4c525e;">PASSWORD RESET SUCCESSFULLY</h3><h4 style="color:#848994;">You reset your password successfully.</h4><p>You have successfully reset your password for your Cortiam account. Here is your new password: <strong>'.$new_password.'</strong>. After you login with your new password we suggest you to update this password with a new one which you can remember easily. <p><p style="text-align:center;"><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
			$this->mailer->regular_email('Password Change Request', $user_email_text, $identity);

			$this->ion_auth->clear_forgotten_password_code($identity);
			$this->_frontend('password_send');
			return false;
		}else{
			$this->page_data['header_data']['meta_title'] .= ' - Password Reset Failure';
			$this->page_data['header_data']['page_title'] = 'Password Reset Failure';
			$this->page_data['header_data']['current_menu'] = '';
			$this->_frontend('password_not_match');
			return false;
		}
	}


	/**
	 * Logouts user and redirects to login page after
	 * @uses ion_auth::logout To logout user from system
	 *
	 * @return void
	 */
	function logout()	{
		$this->page_data['header_data']['meta_title'] = 'Lead Distribution Application - Logout';
		$logout = $this->ion_auth->logout();
		$this->session->set_flashdata('message', $this->ion_auth->messages());
		redirect('/login', 'refresh');
	}

    public function verify_email($token) {

        if ($this->ion_auth->verify_email($token)) {
            echo "Your email has been verified successfully. Redirecting you to login page.";
            header('Location: '. base_url('login'));
        } else {
			redirect('/404_override', 'refresh');          
        }
    }
}