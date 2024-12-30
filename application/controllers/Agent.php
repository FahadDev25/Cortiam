<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Agent Display controller
 *
 * The base controller which displays the pages of the Cortiam Web Applications Agent Panel
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

class Agent extends CRTM_Controller {

	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->model('agent_model');
		$this->load->helper(array('frontend'));

		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/animate.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/select2.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/izitoast.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/cropper.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/icons/icomoon/styles.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/swal.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/datepicker.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/slick.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/trumbowyg.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/trumbowyg.giphy.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/trumbowyg.colors.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/ekko-lightbox.css');

		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/izitoast.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/validation/validate.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/media/heic2any.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/media/cropper.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/media/ekko-lightbox.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/sweet_alert.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/styling/uniform.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/sweet_alert.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/formatter.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/title.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/mousewheel.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/maxlength.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/globalize/globalize.js"');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/pickers/datepicker.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/selects/select2.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/sliders/slick.min.js');
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


		if ($this->ion_auth->logged_in() && ($this->ion_auth->get_user_type() == 'Agent'))	{
			$this->page_data["account"] =  $this->account = $this->agent_model->get_agent($this->ion_auth->get_user_id());
			$this->page_data["specializations"] =  $this->specializations = $this->agent_model->get_specializations();
			$this->page_data["agentspecializations"] =  $this->agentspecializations = $this->agent_model->get_specializations_for_agent($this->ion_auth->get_user_id());
			$this->page_data["pms"] = $this->agent_model->get_new_messages($this->ion_auth->get_user_id());
			$this->page_data["usnos"] = $this->agent_model->get_new_offer_news($this->ion_auth->get_user_id());
			$this->page_data["usnots"] = $this->agent_model->get_new_notifications($this->ion_auth->get_user_id());
			$this->page_data["uswapp"] = $this->agent_model->get_aggrements($this->ion_auth->get_user_id(), array('status' => array('Open')));
			$this->page_data["account"]['licenses'] =  $this->account['licenses'] = $this->agent_model->get_my_licenses($this->ion_auth->get_user_id());
		}else{
			redirect('/login', 'refresh');
		}
		if ($this->router->fetch_method() != 'edit_account') {
			if ($this->account['licenses']['no_license'] || $this->account['licenses']['no_active_license']){
				redirect('/agent/edit-account', 'refresh');
			}
		}
//		print_r($this->account['licenses']);
		if ($this->account['licenses']['no_active_license']){
			$this->_addjson('popmeup',array( 'messagetitle' => 'Your Real Estate Agent License(s) Has Expired.', 'messagetext' => 'Please update your '.implode(", ",$this->account['licenses']['expired_states']).' license information with your new license details before you continue using our system. After you update your license information, the details will need to be approved by the Cortiam administrators and your account will be enabled shortly after.'));
		}
		if ($this->account['licenses']['no_license']){
			$this->_addjson('popmeup',array( 'messagetitle' => 'Please Add Your Real Estate Agent License', 'messagetext' => 'Please add your real estate agent license information before you continue using our system. After you update your license information, the details will need to be approved by the Cortiam administrators and your account will be enabled shortly after.'));
		}
		if ($this->session->flashdata('notify')) {
			$this->_addjson('notify',array( 'position' => 'topCenter', 'transitionIn' => 'bounceInUp', 'transitionOut' => 'fadeOutUp', 'layout' => 2, 'theme' => $this->session->flashdata('notify'), 'message' => $this->session->flashdata('notify_message'), 'title' => $this->session->flashdata('notify_title'), 'maxWidth' => 1100, 'timeout' => 9000, 'drag' => false, 'imageWidth' => 150, 'image' => (($this->session->flashdata('notify_image'))? $this->session->flashdata('notify_image'):null)));
		}else{
			$this->_addjson('notify',array());
		}
		$this->_addjson('cortiamphotoajax',array("avataruploadurl" => cortiam_base_url('ajax/upload-avatar'),"loadingimage" => base_url('/images/loading.gif')));
	}

	/**
	 * Displays the homepage/dashboard for Agent account
	 * @uses agent_model::get_properties Gets properties and its details by given parameters
	 * @uses agent_model::get_express_properties Gets list of expressed properties
	 * @uses agent_model::get_saved_properties Gets list of saved properties
	 * @uses agent_model::get_proposed_properties Gets list of proposed properties
	 * @uses agent_model::get_win_properties Gets list of winned properties
	 * @uses agent_model::get_message_list Gets agent messages list and details
	 * @uses agent_model::get_licenses Gets agent licenses and details
	 *
	 * @return void
	 */
	public function index(){
		
  	    $this->page_data['header_data']['meta_title'] .= ' - Dashboard';
		$this->page_data['header_data']['page_title'] = 'Dashboard';
		$this->page_data['header_data']['current_menu'] = 'dashboard';
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/circle.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/datatables_bootstrap.css');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/datatables.min.js');

//$this->page_data['open_properties']  =	$this->agent_model->get_properties(array('state' => $this->account['licenses']['active_states'], 'limit' => 15));
		if($expressed_properties = $this->agent_model->get_express_properties($this->ion_auth->get_user_id(),true))
		{
			$this->page_data['express_properties']  =	$this->agent_model->get_properties(array('list' => $expressed_properties, 'limit' => 15));
		}
		if($saved_properties = $this->agent_model->get_saved_properties($this->ion_auth->get_user_id(),true)){
			$this->page_data['saved_properties']  =	$this->agent_model->get_properties(array('list' => $saved_properties, 'limit' => 15));
		}
		if($pending_properties = $this->agent_model->get_proposed_properties($this->ion_auth->get_user_id(),true)){
			$this->page_data['pending_properties']  =	$this->agent_model->get_properties(array('list' => $pending_properties, 'limit' => 15));
		}
		if($win_properties = $this->agent_model->get_win_properties($this->ion_auth->get_user_id(),true)){
			$this->page_data['win_properties']  =	$this->agent_model->get_properties(array('list' => $win_properties, 'limit' => 15));
		}

		$this->page_data['messages'] = $this->agent_model->get_message_list($this->ion_auth->get_user_id());
		$this->page_data['licenses'] = $this->agent_model->get_licenses($this->ion_auth->get_user_id());

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "savepropertyurl" => cortiam_base_url('ajax/save-property'), "favoriteupdateurl" => cortiam_base_url('ajax/get-favorite-properties'), "datatableajaxurl" => cortiam_base_url('ajax/list-properties')));
		$this->_frontend('dashboard', 'agent');
	}

	/**
	 * Displays the profile page of Agent account
	 * @uses agent_model::get_licenses Gets agent licenses and details
	 *
	 * @return void
	 */
	public function my_profile(){
		$this->page_data['header_data']['meta_title'] .= ' - My Profile';
		$this->page_data['header_data']['page_title'] = 'My Profile';
		$this->page_data['header_data']['current_menu'] = 'profile';

		$this->page_data['licenses']  =	$this->agent_model->get_licenses($this->ion_auth->get_user_id());

        $this->page_data['agent_specializations'] = $this->agent_specializations = $this->agent_model->get_agent_specializations($this->ion_auth->get_user_id());
        $this->_frontend('myprofile', 'agent');
	}

	/**
	 * Displays the edit account page of Agent account
	 * @uses agent_model::get_credit_cards Gets agent saved credit cards and details
	 * @uses agent_model::get_licenses Gets agent licenses and details
	 * @uses agent_model::get_invoices Gets agent invoices and details
	 *
	 * @return void
	 */
	public function edit_account()
	{
		$this->page_data['header_data']['meta_title'] .= ' - Edit My Account';
		$this->page_data['header_data']['page_title'] = 'Edit My Account';
		$this->page_data['header_data']['current_menu'] = 'editaccount';
		$this->page_data['footer_data']['js_files'][] = 'https://js.stripe.com/v2/';
	
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "paymentajaxurl" => base_url('/ajax/payment') , "formajaxurl" => cortiam_base_url('ajax/update-account'), "planajaxurl" => cortiam_base_url('ajax/update-plan')  ,"passwordajaxurl" => cortiam_base_url('ajax/change-password'), "changepaymenturl" => cortiam_base_url('ajax/change-payment'), "getlicenseformurl" => cortiam_base_url('ajax/get-licenseform'), "addlicenseurl" => cortiam_base_url('ajax/add-license'), "editlicenseurl" => cortiam_base_url('ajax/edit-license'), "deletelicenseurl" => cortiam_base_url('ajax/delete-license'), "listlicenseurl" => cortiam_base_url('ajax/list-licenses'), "getformurl" => cortiam_base_url('ajax/get-paymentform'), "deletecardurl" => cortiam_base_url('ajax/delete-card'), "updatecardurl" => cortiam_base_url('ajax/get-my-cards'), "newcardurl" => cortiam_base_url('ajax/new-credit-card'), "setpaymenturl" => cortiam_base_url('ajax/set-payment'), "listpackagesurl" => cortiam_base_url('ajax/list-packages'), "buypackageurl" => cortiam_base_url('ajax/buy-package'), "listinvoicesurl" => cortiam_base_url('ajax/list-payments'), "listmypackagesurl" => cortiam_base_url('ajax/list-mypackages'), "stripekey" => $this->config->item('stripe_public'), "deactivateurl" => cortiam_base_url('ajax/deactivate-me'), "accepttosurl" => cortiam_base_url('ajax/accept-tos')));
		if ($this->account['payment_id']) {
			$this->page_data['credit_cards']  = $this->agent_model->get_credit_cards($this->ion_auth->get_user_id());
		}
		$this->page_data['licenses']  =	$this->agent_model->get_licenses($this->ion_auth->get_user_id());
		$this->page_data['invoices']  =	$this->agent_model->get_invoices($this->account['id'], array('Completed','Failed','Refund'));
		$plan_id					  =	$this->agent_model->get_plan($this->ion_auth->get_user_id());

	
		if(isset($plan_id['plan_id']) && $plan_id['plan_id'] !== '')
		{	
			$this->_frontend('editaccount', 'agent');

		}else{

    		$this->page_data['plans'] = $this->agent_model->membership_plans();	
			$this->_frontend('agentplans', 'agent_without_plan');
		}	
	}


	public function my_plan()
	{
		$this->page_data['header_data']['meta_title'] .= ' - My Plan';
		$this->page_data['header_data']['page_title'] = 'My Plan';
		$this->page_data['header_data']['current_menu'] = 'myplan';
		$this->page_data['licenses']  =	$this->agent_model->get_licenses($this->ion_auth->get_user_id());
	

	
		if(isset($plan_id['plan_id']) && $plan_id['plan_id'] !== '')
		{	
			$this->_frontend('editaccount', 'agent');

		}else{

    		$this->page_data['plans'] = $this->agent_model->membership_plans();	
			$this->_frontend('agentplans', 'agent_without_plan');
		}	
	}

	/**
	 * Displays the approval process page of Agent account
	 * @uses agent_model::list_approval_text Gets agent approval history and details
	 *
	 * @return void
	 */
	public function approval_process(){
		$this->page_data['header_data']['meta_title'] .= ' - My Approval Process';
		$this->page_data['header_data']['page_title'] = 'My Approval Process';
		$this->page_data['header_data']['current_menu'] = 'messagecenter';
		if ($this->account['approval'] == 'Completed') {
			redirect(cortiam_base_url(''), 'refresh');
		}

		$this->agent_model->set_notification_type_read($this->ion_auth->get_user_id(),'account_declined');
		$this->page_data['history'] = $this->agent_model->list_approval_text(array('agent_id' => $this->ion_auth->get_user_id()));
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/request-approval/')));
		$this->_frontend('approvalpage', 'seller');
	}

	/**
	 * Displays the coupons page of Agent account
	 * @uses agent_model::get_coupons Gets list of agent coupons and details
	 *
	 * @return void
	 */
	public function my_coupons(){
		$this->page_data['header_data']['meta_title'] .= ' - My Coupons';
		$this->page_data['header_data']['page_title'] = 'My Coupons';
		$this->page_data['header_data']['current_menu'] = 'discount';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/add-coupon'), "updateurl" => cortiam_base_url('ajax/get-my-coupons'), "orderurl" => cortiam_base_url('ajax/change-coupon-order')));
		$this->page_data['coupons']  =	$this->agent_model->get_coupons($this->account['id']);

		$this->_frontend('coupons', 'agent');
	}

	/**
	 * Adds the coupon to the Agent account
	 * @uses agent_model::process_coupon Adds agent coupons and details
	 *
	 * @param  string $coupon_code Coupon Code
	 * @return void
	 */
	public function add_coupon($coupon_code = null){
		if ($coupon_code) {
			$response = $this->agent_model->process_coupon($this->account['id'],$coupon_code);
			if ($response['success']) {
				$this->session->set_flashdata('notify', 'success');
				$this->session->set_flashdata('notify_message', $response["success_message"]);
				$this->session->set_flashdata('notify_title', $response["success_title"]);
			}else{
				$this->session->set_flashdata('notify', 'error');
				$this->session->set_flashdata('notify_message', $response["fail_message"]);
				$this->session->set_flashdata('notify_title', $response["fail_title"]);
			}
			redirect(cortiam_base_url('my-coupons'), 'refresh');
		}else{
			redirect(cortiam_base_url('my-coupons'), 'refresh');
			exit();
		}
	}

	/**
	 * Displays the Property page
	 * @uses agent_model::get_property Gets details of selected property
	 * @uses agent_model::get_save_value Gets list of saved properties
	 * @uses agent_model::get_proposal_value Gets list of proposals of property by this agent
	 * @uses agent_model::get_counter_offer_value Gets list of counter offers of property by this agent
	 * @uses agent_model::get_win_properties Gets list of properties agent wins
	 *
	 * @param  string $property_string Property URL String
	 * @return void
	 */
	public function view_property($property_string = null)
	{
		$agent_info = $this->agent_model->get_agent($this->ion_auth->get_user_id());

		
		if ($property_string) {
			$url = explode('-',$property_string);
			$property_id = (int) $url[0];
			if ($this->page_data['property'] = $this->agent_model->get_property($property_id)) {
				$this->page_data['header_data']['meta_title'] .= ' - View Listing';
				$this->page_data['header_data']['page_title'] = 'View Listing';
				$this->page_data['header_data']['current_menu'] = 'listing';

				$this->page_data['save_status'] 	= $this->agent_model->get_save_value($this->account['id'],$property_id);
				$this->page_data['proposal_status']	= $this->agent_model->get_proposal_value($this->account['id'],$property_id);
				$this->page_data['cof_status'] 	   	= $this->agent_model->get_counter_offer_value($this->account['id'],$property_id);
				$this->page_data['win_properties'] 	= $this->agent_model->get_win_properties($this->account['id'],true);
				$this->page_data['amount_limit']   	=  $agent_info['amount_limit'];

				$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "property_id" => $property_id, "savepropertyurl" => cortiam_base_url('ajax/save-property'), "expresspropertyurl" => cortiam_base_url('ajax/express-property'), "counterofferform" => cortiam_base_url('ajax/counter-offer-form'), "counterofferurl" => cortiam_base_url('ajax/send-proposal'), "withdrawproposalurl" => cortiam_base_url('ajax/withdraw-proposal')));
				$this->_frontend('property', 'agent');
			}else{
				$this->session->set_flashdata('notify', 'error');
				$this->session->set_flashdata('notify_message', 'Requested property cannot be found. Please check your URL and try again.');
				$this->session->set_flashdata('notify_title', 'Requested Property Cannot Found');
				redirect(cortiam_base_url(''), 'refresh');
				exit();
			}
		}else{
			$this->session->set_flashdata('notify', 'error');
			$this->session->set_flashdata('notify_message', 'Requested property cannot be found. Please check your URL and try again.');
			$this->session->set_flashdata('notify_title', 'Requested Property Cannot Found');
			redirect(cortiam_base_url(''), 'refresh');
			exit();
		}
	}

	/**
	 * Displays the proposals page
	 * @uses agent_model::get_proposals Gets list of proposals by this agent by selected criterias
	 * @uses agent_model::get_win_properties Gets list of properties agent wins
	 *
	 * @return void
	 */
	public function proposals(){

		$this->page_data['header_data']['meta_title'] .= ' - Proposals';
		$this->page_data['header_data']['page_title'] = 'Proposals';
		$this->page_data['header_data']['current_menu'] = 'proposals';

		$this->page_data['waiting_proposals'] = $this->agent_model->get_proposals($this->ion_auth->get_user_id(),array('status' => array('Read','Unread')));
		$this->page_data['accepted_proposals'] = $this->agent_model->get_proposals($this->ion_auth->get_user_id(),array('status' => array('Accepted')));
		$this->page_data['declined_proposals'] = $this->agent_model->get_proposals($this->ion_auth->get_user_id(),array('status' => array('Declined')));
		$this->page_data['win_properties'] = $this->agent_model->get_win_properties($this->account['id'],true);

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "counterofferform" => cortiam_base_url('ajax/counter-offer-form'), "counterofferurl" => cortiam_base_url('ajax/send-counter-offer'), "acceptproposalurl" => cortiam_base_url('ajax/accept-proposal'), "declineproposalurl" => cortiam_base_url('ajax/decline-proposal'), "withdrawproposalurl" => cortiam_base_url('ajax/withdraw-proposal')));

		$this->_frontend('proposals', 'agent');
	}

	/**
	 * Displays the proposal page itself
	 * @uses agent_model::get_proposal Gets details of selected proposal
	 * @uses agent_model::check_newer_proposal Checks and gets details of newer proposal if any
	 * @uses agent_model::get_related_proposal Gets list and details proposals which related with selected proposal
	 * @uses agent_model::get_property Gets details of selected property
	 * @uses agent_model::get_save_value Gets list of saved properties
	 * @uses agent_model::get_proposal_value Gets list of proposals of property by this agent
	 * @uses agent_model::get_counter_offer_value Gets list of counter offers of property by this agent
	 * @uses agent_model::get_win_properties Gets list of properties agent wins
	 * @uses agent_model::mark_proposal_read Marks current proposal as read
	 *
	 * @param  string $proposal_string Proposals URL String
	 * @return void
	 */
	public function view_proposal($proposal_string = null){
		if ($proposal_string) {
			$url = explode('-',$proposal_string);
			$proposal_id = (int) $url[0];
			if ($this->page_data['proposal'] = $this->agent_model->get_proposal($this->ion_auth->get_user_id(), $proposal_id)) {
				if ($newer_proposal = $this->agent_model->check_newer_proposal($this->ion_auth->get_user_id(), $proposal_id)) {
					redirect(cortiam_base_url('view-proposal/').$newer_proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $newer_proposal['city'].' '.$newer_proposal['state'])), 'underscore', true), 'refresh');
					exit();
				}else{
					if ($this->page_data['proposal']['base_id'] || $this->page_data['proposal']['main_id']) {
						$this->page_data['related_proposals'] = $this->agent_model->get_related_proposal((($this->page_data['proposal']['base_id'])? $this->page_data['proposal']['base_id']:$this->page_data['proposal']['main_id']));
					}
					$this->page_data['property'] = $this->agent_model->get_property($this->page_data['proposal']['property_id']);
					$this->page_data['save_status'] = $this->agent_model->get_save_value($this->account['id'],$property_id);
					$this->page_data['proposal_status'] = $this->agent_model->get_proposal_value($this->account['id'],$property_id);
					$this->page_data['header_data']['meta_title'] .= ' - View Proposal';
					$this->page_data['header_data']['page_title'] = 'View Proposal';
					$this->page_data['header_data']['current_menu'] = 'proposals';
					$this->page_data['win_properties'] = $this->agent_model->get_win_properties($this->account['id'],true);

					$this->agent_model->mark_proposal_read($this->ion_auth->get_user_id(), $proposal_id);
					$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "proposal_id" => $proposal_id, "acceptproposalurl" => cortiam_base_url('ajax/accept-proposal'), "declineproposalurl" => cortiam_base_url('ajax/decline-proposal'), "counterofferform" => cortiam_base_url('ajax/counter-offer-form'), "counterofferurl" => cortiam_base_url('ajax/send-counter-offer'), "withdrawproposalurl" => cortiam_base_url('ajax/withdraw-proposal')));

					$this->_frontend('proposal_view', 'agent');
				}
			}else{
				$this->session->set_flashdata('notify', 'error');
				$this->session->set_flashdata('notify_message', 'Requested proposal cannot be found. Please check your URL and try again.');
				$this->session->set_flashdata('notify_title', 'Requested Proposal Cannot Found');
				redirect(cortiam_base_url(''), 'refresh');
				exit();
			}
		}else{
			$this->session->set_flashdata('notify', 'error');
			$this->session->set_flashdata('notify_message', 'Requested proposal cannot be found. Please check your URL and try again.');
			$this->session->set_flashdata('notify_title', 'Requested Proposal Cannot Found');
			redirect(cortiam_base_url(''), 'refresh');
			exit();
		}
	}

	/**
	 * Displays the Messages page
	 * @uses agent_model::get_message_list Gets list and details of messages grouped by user
	 *
	 * @return void
	 */
	public function message_center(){
		$this->page_data['header_data']['meta_title'] .= ' - Message Center';
		$this->page_data['header_data']['page_title'] = 'Message Center';
		$this->page_data['header_data']['current_menu'] = 'messagecenter';

		$this->page_data['messages'] = $this->agent_model->get_message_list($this->ion_auth->get_user_id());

		$this->_frontend('message_center', 'agent');
	}

	/**
	 * Displays the Message page of user
	 * @uses agent_model::get_messages_of Gets list and details of messages by selected user
	 * @uses agent_model::mark_messages_read Marks messages by selected user as read
	 *
	 * @param  string $seller_string Sellers URL String
	 * @return void
	 */
	public function view_messages($seller_string = null){
		$this->page_data['header_data']['meta_title'] .= ' - Message Box';
		$this->page_data['header_data']['page_title'] = 'Message Box';
		$this->page_data['header_data']['current_menu'] = 'messagecenter';
		if ($seller_string) {
			$url = explode('-',$seller_string);
			$seller_id = (int) $url[0];
			if ($this->page_data['messages'] = $this->agent_model->get_messages_of($this->ion_auth->get_user_id(),$seller_id)) {
				$this->agent_model->mark_messages_read($this->ion_auth->get_user_id(),$seller_id);
			}
			$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/send-message/'.$seller_id)));
			$this->_frontend('messages', 'agent');
		}else{
			$this->session->set_flashdata('notify', 'error');
			$this->session->set_flashdata('notify_message', 'Requested message history cannot be found. Please check your URL and try again.');
			$this->session->set_flashdata('notify_title', 'Requested Message History Cannot Found');
			redirect(cortiam_base_url(''), 'refresh');
			exit();
		}
	}

	/**
	 * Displays the Agreements page
	 * @uses agent_model::get_aggrements Gets list and details of agents agreements
	 *
	 * @return void
	 */
	public function agreements(){
		$this->page_data['header_data']['meta_title'] .= ' - Agreements';
		$this->page_data['header_data']['page_title'] = 'Agreements';
		$this->page_data['header_data']['current_menu'] = 'agreements';

		$this->page_data['agreements'] = $this->agent_model->get_aggrements($this->ion_auth->get_user_id());
	
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "accepturl" => cortiam_base_url('ajax/accept-agreement'), "declineurl" => cortiam_base_url('ajax/decline-agreement')));

		$this->_frontend('agreements', 'agent');
	}

	/**
	 * Displays the Tutorial page
	 * @uses agent_model::get_tutorial Gets tutorials page content
	 *
	 * @return void
	 */
	public function tutorials(){
		$this->page_data['header_data']['meta_title'] .= ' - Tutorials';
		$this->page_data['header_data']['page_title'] = 'Tutorials';
		$this->page_data['header_data']['current_menu'] = 'tutorial';

		$this->page_data['content'] = $this->agent_model->get_tutorial();
		$this->_frontend('tutorial', 'agent');
	}

	public function video()
	{
		$this->page_data['header_data']['meta_title'] .= ' - Introduction video';
		$this->page_data['header_data']['page_title'] = 'Introduction video';
		$this->page_data['header_data']['current_menu'] = 'introduction video';

		$this->page_data['content'] = $this->agent_model->get_tutorial();
		$this->_frontend('video', 'agent');
	}

	/**
	 * Displays the support center page
	 * @uses agent_model::get_support_messages Gets support messages history
	 *
	 * @return void
	 */
	public function support_center(){
		$this->page_data['header_data']['meta_title'] .= ' - Support Request';
		$this->page_data['header_data']['page_title'] = 'Support Request';
		$this->page_data['header_data']['current_menu'] = 'support';

		$this->page_data['messages'] = $this->agent_model->get_support_messages($this->ion_auth->get_user_id());
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/send-support/')));

		$this->_frontend('support_center', 'agent');
	}


	/**
	 * Displays the notifications page
	 * @uses agent_model::get_notifications Gets list of agents notifications
	 *
	 * @return void
	 */
	public function notifications(){
		$this->page_data['header_data']['meta_title'] .= ' - System Notifications';
		$this->page_data['header_data']['page_title'] = 'System Notifications';
		$this->page_data['header_data']['current_menu'] = 'notifications';

		$this->page_data['notifications'] = $this->agent_model->get_notifications($this->ion_auth->get_user_id());
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif')));

		$this->_frontend('notifications', 'agent');
	}
}
?>