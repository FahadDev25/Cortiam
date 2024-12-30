<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Frontend Display controller
 *
 * The base controller which displays the pages of the Cortiam Web Applications Frontend Panel
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

class Frontend extends CRTM_Controller {

	function __construct(){
		parent::__construct();

		$this->load->database();
		$this->load->model('frontend_model');
		$this->load->helper(array('frontend'));	
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/swal.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/select2.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/animate.min.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/sweet_alert.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/selects/select2.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/formatter.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/cortiam.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/pages/frontend/member-ship.js');



	

		
		

	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function error_404(){
		$this->page_data['header_data']['meta_title'] .= ' - Page Not Found';
		$this->page_data['header_data']['page_title'] = 'Page Not Found';
		$this->page_data['header_data']['current_menu'] = '';
		$this->_frontend('error404');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function index(){

		$this->page_data['header_data']['meta_title'] .= ' - Homepage';
		$this->page_data['header_data']['page_title'] = 'Homepage';
		$this->page_data['header_data']['current_menu'] = 'home';
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/plyr.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/plyr/plyr.polyfilled.js');
		$this->_frontend('homepage');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function about_us(){
		$this->page_data['header_data']['meta_title'] .= ' - About Us';
		$this->page_data['header_data']['page_title'] = 'About Us';
		$this->page_data['header_data']['current_menu'] = 'about';
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/plyr.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/plyr/plyr.polyfilled.js');
		$this->_frontend('aboutus');
	}


	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function set_your_terms(){
		$this->page_data['header_data']['meta_title'] .= ' - Set Your Terms';
		$this->page_data['header_data']['page_title'] = 'Set Your Terms';
		$this->page_data['header_data']['current_menu'] = 'setterms';
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/plyr.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/plyr/plyr.polyfilled.js');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/aos.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/dist/aos.js');

		$this->_frontend('setyourterms');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function agents(){
		$this->page_data['header_data']['meta_title'] .= ' - Agent Center';
		$this->page_data['header_data']['page_title'] = 'Agent Center';
		$this->page_data['header_data']['current_menu'] = 'agentcenter';

		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/plyr.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/plyr/plyr.polyfilled.js');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/aos.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/dist/aos.js');

		$this->_frontend('agents');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function agents_on_cortiam(){
		$this->page_data['header_data']['meta_title'] .= ' - Find Your Agent';
		$this->page_data['header_data']['page_title'] = 'Find Your Agent';
		$this->page_data['header_data']['current_menu'] = 'findagent';
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/select2.min.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/selects/select2.min.js');

//		$loc_data = geolocate_address(null,'Rochester',null,null,null);
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/locate-agent')));
		$this->_frontend('agentsoncortiam');
	}

	public function agent_profile($agent_string = null){
		if ($agent_string) {
			$url = explode('-',$agent_string);
			$agent_id = (int) $url[0];
			if ($this->page_data['agent_account'] = $this->frontend_model->get_agent($agent_id)) {
				$this->page_data['header_data']['meta_title'] .= ' - Agent Profile';
				$this->page_data['header_data']['page_title'] = 'Agent Profile';
				$this->page_data['header_data']['current_menu'] = 'findagent';

				$this->page_data['agent_licenses'] = $this->frontend_model->get_agent_licenses($agent_id);

				$this->_frontend('agent_profile');
			}else{
				$this->session->set_flashdata('notify', 'error');
				$this->session->set_flashdata('notify_message', 'Requested agent profile cannot be found. Please check your URL and try again.');
				$this->session->set_flashdata('notify_title', 'Requested Agent Profile Cannot Found');
				redirect('agents-on-cortiam', 'refresh');
				exit();
			}
		}else{
			$this->session->set_flashdata('notify', 'error');
			$this->session->set_flashdata('notify_message', 'Requested agent profile cannot be found. Please check your URL and try again.');
			$this->session->set_flashdata('notify_title', 'Requested Agent Profile Cannot Found');
			redirect('agents-on-cortiam', 'refresh');
			exit();
		}
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function community(){
		$this->page_data['header_data']['meta_title'] .= ' - Community';
		$this->page_data['header_data']['page_title'] = 'Community';
		$this->page_data['header_data']['current_menu'] = 'community';
		$this->_frontend('community');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function privacy_policy(){
		$this->page_data['header_data']['meta_title'] .= ' - Privacy Policy';
		$this->page_data['header_data']['page_title'] = 'Privacy Policy';
		$this->page_data['header_data']['current_menu'] = 'privacy';
		$this->_frontend('privacy');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function terms_of_use(){
		$this->page_data['header_data']['meta_title'] .= ' - Terms and Conditions';
		$this->page_data['header_data']['page_title'] = 'Terms of Use';
		$this->page_data['header_data']['current_menu'] = 'termsofuse';
		$this->_frontend('termsofuse');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function contact_us(){
		$this->page_data['header_data']['meta_title'] .= ' - Contact Us';
		$this->page_data['header_data']['page_title'] = 'Contact Us';
		$this->page_data['header_data']['current_menu'] = 'contactus';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/contact-us')));
		$this->_frontend('contactus');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function sign_up(){

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


		$this->page_data['header_data']['meta_title'] .= ' - Sign Up Process';
		$this->page_data['header_data']['page_title'] = 'Sign Up Process';
		$this->page_data['header_data']['current_menu'] = 'signup';
		$this->_frontend('signup');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function sign_up_agent(){

		
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


		$this->page_data['header_data']['meta_title']  .= ' - Agent Sign Up';
		$this->page_data['header_data']['page_title']   = 'Agent Sign Up';
		$this->page_data['header_data']['current_menu'] = 'signupagent';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/signup-agent'), "emailajaxurl" => base_url('/ajax/signup-email'), "paymentajaxurl" => base_url('/ajax/payment') ,"notifyajaxurl" => base_url('/ajax/notify-agent')));
	    $this->page_data['memberShipPlans'] =  $this->frontend_model->all_membership_plans();

	
    	$this->_frontend('signupagent');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function sign_up_seller(){


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
		
		$this->page_data['header_data']['meta_title'] .= ' - Seller Sign Up';
		$this->page_data['header_data']['page_title'] = 'Seller Sign Up';
		$this->page_data['header_data']['current_menu'] = 'signupseller';
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/signup-seller'), "emailajaxurl" => base_url('/ajax/signup-email'), "notifyajaxurl" => base_url('/ajax/notify-seller')));
		$this->_frontend('signupseller');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function signup_successfully(){
		$this->page_data['header_data']['meta_title'] .= ' - Sign Up Completed Successfully';
		$this->page_data['header_data']['page_title'] = 'Sign Up Completed Successfully';
		$this->page_data['header_data']['current_menu'] = 'signupsuccess';

		$this->_frontend('signupsuccess');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function notification_successfully(){
		$this->page_data['header_data']['meta_title'] .= ' - Notification Added Successfully';
		$this->page_data['header_data']['page_title'] = 'Notification Added Successfully';
		$this->page_data['header_data']['current_menu'] = 'signupsuccess';

		$this->_frontend('notificationsuccess');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function join_our_team(){
		$this->page_data['header_data']['meta_title'] .= ' - Join Our Team';
		$this->page_data['header_data']['page_title'] = 'Join Our Team';
		$this->page_data['header_data']['current_menu'] = 'joinourteam';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/join-our-team')));
		$this->_frontend('joinourteam');
	}

	/**
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function joinus_successfully(){
		$this->page_data['header_data']['meta_title'] .= ' - Submitted Successfully';
		$this->page_data['header_data']['page_title'] = 'Submitted Successfully';
		$this->page_data['header_data']['current_menu'] = 'joinsuccess';

		$this->_frontend('joinsuccesfully');
	}
}
?>