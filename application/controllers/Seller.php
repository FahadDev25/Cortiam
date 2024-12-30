<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Seller Display controller
 *
 * The base controller which displays the pages of the Cortiam Web Applications Seller Panel
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

class Seller extends CRTM_Controller {

	function __construct(){
		parent::__construct();
		log_message("error", "Seller message...");

		$this->load->database();
		$this->load->model('seller_model');
		$this->load->helper(array('frontend'));

		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/animate.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/izitoast.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/select2.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/icons/icomoon/styles.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/cropper.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/swal.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/slick.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/bootstrap-datepicker.standalone.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/trumbowyg.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/trumbowyg.giphy.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/trumbowyg.colors.min.css');

		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/izitoast.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/validation/validate.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/media/heic2any.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/media/cropper.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/list.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/sweet_alert.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/sliders/slick.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/styling/uniform.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/sweet_alert.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/formatter.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/maskmoney.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/title.min.js');
//		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/interactions.min.js');
//		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/widgets.min.js');
//		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/effects.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/maxlength.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/mousewheel.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/globalize/globalize.js"');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/pickers/bootstrap-datepicker.min.js');
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

		if ($this->ion_auth->logged_in() && ($this->ion_auth->get_user_type() == 'Seller'))
		{
			$this->page_data["account"] =  $this->account = $this->seller_model->get_seller($this->ion_auth->get_user_id());
			$this->page_data["pms"] 	= $this->seller_model->get_new_messages($this->ion_auth->get_user_id());
			$this->page_data["usnos"] 	= $this->seller_model->get_new_offer_news($this->ion_auth->get_user_id());
			$this->page_data["usnots"] 	= $this->seller_model->get_new_notifications($this->ion_auth->get_user_id());

		}else{

			log_message("error", "before redirect...");

			redirect('/login', 'refresh');
		}
		if ($this->session->flashdata('notify')) {
			$this->_addjson('notify',array( 'position' => 'topCenter', 'transitionIn' => 'bounceInUp', 'transitionOut' => 'fadeOutUp', 'layout' => 2, 'theme' => $this->session->flashdata('notify'), 'message' => $this->session->flashdata('notify_message'), 'title' => $this->session->flashdata('notify_title'), 'maxWidth' => 1100, 'timeout' => 9000, 'drag' => false, 'imageWidth' => 150, 'image' => (($this->session->flashdata('notify_image'))? $this->session->flashdata('notify_image'):null)));
		}else{
			$this->_addjson('notify',array());
		}
		$this->_addjson('cortiamgeneralajax',array( "withdrawform" => cortiam_base_url('ajax/withdraw-form'), "withdrawurl" => cortiam_base_url('ajax/withdraw-listing'), "loadingimage" => base_url('/images/loading.gif')));
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


		$this->page_data['header_data']['meta_title'] .= ' - Dashboard';
		$this->page_data['header_data']['page_title'] = 'Dashboard';
		$this->page_data['header_data']['current_menu'] = 'dashboard';

		$this->page_data['my_properties'] = $this->seller_model->get_my_properties($this->ion_auth->get_user_id(),12);

		if($expressed_agents = $this->seller_model->get_express_list($this->ion_auth->get_user_id(),true)){
			$this->page_data['express_agents']  =	$this->seller_model->list_agents(array('seller_id' => $this->ion_auth->get_user_id(),'list' => $expressed_agents, 'limit' => 15));
		}
		if($dealed_agents = $this->seller_model->get_dealed_list($this->ion_auth->get_user_id(),true)){
			$this->page_data['dealed_agents']  =	$this->seller_model->list_agents(array('seller_id' => $this->ion_auth->get_user_id(),'list' => $dealed_agents, 'limit' => 15));
		}
		if($saved_agents = $this->seller_model->get_favorite_list($this->ion_auth->get_user_id(),true)){
			$this->page_data['saved_agents']  =	$this->seller_model->list_agents(array('seller_id' => $this->ion_auth->get_user_id(),'list' => $saved_agents, 'limit' => 15));
		}

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "favoriteurl" => cortiam_base_url('ajax/favorite-agent')));

		$this->_frontend('dashboard', 'seller');
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
	public function edit_account(){
		$this->page_data['header_data']['meta_title'] .= ' - Edit Your Account';
		$this->page_data['header_data']['page_title'] = 'Edit Your Account';
		$this->page_data['header_data']['current_menu'] = 'editaccount';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/update-account'), "deactivateurl" => cortiam_base_url('ajax/deactivate-me'), "passwordajaxurl" => cortiam_base_url('ajax/change-password')));

		$this->_frontend('editaccount', 'seller');
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
	public function add_property(){
		$this->page_data['header_data']['meta_title'] .= ' - Add Property';
		$this->page_data['header_data']['page_title'] = 'Add Property';
		$this->page_data['header_data']['current_menu'] = 'addproperty';

		$this->page_data['my_properties'] = $this->seller_model->get_my_properties($this->ion_auth->get_user_id(),12);

		$this->_addjson('property_types',array("residental" => $this->config->item('residental_types'), "commercial" => $this->config->item('commercial_types')));
		$this->_addjson('cortiamajax',array("emptyimage" => base_url('/images/empty.png'), "loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/add-property'), "propimageuploadurl" => cortiam_base_url('ajax/upload-property-image') ,"getlocationajaxurl" => cortiam_base_url('ajax/get-map-location'), "map_key" => $this->config->item('bing_token'), "latitude" => $this->page_data['property']['latitude'], "longitude" => $this->page_data['property']['longitude'], "accepttosurl" => cortiam_base_url('ajax/accept-tos')));

		$this->_frontend('addproperty', 'seller');
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
	public function list_properties(){
		$this->page_data['header_data']['meta_title'] .= ' - List of All Your Properties';
		$this->page_data['header_data']['page_title'] = 'List of All Your Properties';
		$this->page_data['header_data']['current_menu'] = 'allproperty';

		$this->page_data['my_properties'] = $this->seller_model->get_my_properties($this->ion_auth->get_user_id());

		$this->_frontend('listproperties', 'seller');
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
	public function edit_property($property_id = null){
		if (!$property_id) {
			redirect('/seller', 'refresh');
		}
		if (!$this->page_data['property'] = $this->seller_model->get_my_property($this->ion_auth->get_user_id(), $property_id)) {
			redirect('/seller', 'refresh');
		}

		$this->page_data['header_data']['meta_title'] .= ' - Edit Property';
		$this->page_data['header_data']['page_title'] = 'Edit Property';
		$this->page_data['header_data']['current_menu'] = 'addproperty';

		$this->_addjson('property_types',array("residental" => $this->config->item('residental_types'), "commercial" => $this->config->item('commercial_types'), "current" => $this->page_data['property']['type'], "sub_type" => $this->page_data['property']['sub_type']));
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/edit-property/'.$property_id), "propimageuploadurl" => cortiam_base_url('ajax/upload-property-image/'.$property_id) ,"getlocationajaxurl" => cortiam_base_url('ajax/get-map-location'), "map_key" => $this->config->item('bing_token'), "latitude" => $this->page_data['property']['latitude'], "longitude" => $this->page_data['property']['longitude']));

		$this->_frontend('editproperty', 'seller');
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
	public function approval_process(){

		$this->page_data['header_data']['meta_title'] .= ' - My Approval Process';
		$this->page_data['header_data']['page_title'] = 'My Approval Process';
		$this->page_data['header_data']['current_menu'] = 'messagecenter';
		if ($this->account['approval'] == 'Completed') {
			redirect(cortiam_base_url(''), 'refresh');
		}

		$this->page_data['history'] = $this->seller_model->list_approval_text(array('seller_id' => $this->ion_auth->get_user_id()));
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/request-approval/')));
		$this->_frontend('approvalpage', 'seller');
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
	public function review_property($property_id){
		if (!$property_id) {
			redirect(cortiam_base_url(''), 'refresh');
		}
		if (!$this->page_data['property'] = $this->seller_model->get_my_property($this->ion_auth->get_user_id(), $property_id)) {
			redirect('/seller', 'refresh');
		}
		$this->page_data['header_data']['meta_title'] .= ' - My Property Approval Process';
		$this->page_data['header_data']['page_title'] = 'My Property Approval Process';
		$this->page_data['header_data']['current_menu'] = 'messagecenter';
		if ($this->page_data['property']['status'] != 'Declined') {
			redirect(cortiam_base_url(''), 'refresh');
		}

		$this->page_data['history'] = $this->seller_model->list_approval_text(array('seller_id' => $this->ion_auth->get_user_id(),'property_id' => $property_id));
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/request-property-approval/'.$property_id)));
		$this->_frontend('reviewproperty', 'seller');
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
		$this->page_data['header_data']['meta_title'] .= ' - Agents & Interests';
		$this->page_data['header_data']['page_title'] = 'Agents';
		$this->page_data['header_data']['current_menu'] = 'agents';
//		$this->page_data['header_data']['auto_refresh'] = 30;

		$this->page_data['proposals'] = $this->seller_model->get_proposals($this->ion_auth->get_user_id());
		$this->page_data['agreements'] = $this->seller_model->get_aggrements($this->ion_auth->get_user_id());

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "counterofferform" => cortiam_base_url('ajax/counter-offer-form'), "counterofferurl" => cortiam_base_url('ajax/send-counter-offer'), "acceptproposalurl" => cortiam_base_url('ajax/accept-proposal'), "declineproposalurl" => cortiam_base_url('ajax/decline-proposal'), "accepturl" => cortiam_base_url('ajax/accept-agreement'), "declineurl" => cortiam_base_url('ajax/decline-agreement'), "withdrawproposalurl" => cortiam_base_url('ajax/withdraw-proposal')));

		$this->_frontend('agents', 'seller');
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
	public function view_interest($proposal_string = null){
		if ($proposal_string) {
			$url = explode('-',$proposal_string);
			$proposal_id = (int) $url[0];
			if ($this->page_data['proposal'] = $this->seller_model->get_proposal($this->ion_auth->get_user_id(), $proposal_id)) {
				if ($newer_proposal = $this->seller_model->check_newer_proposal($this->ion_auth->get_user_id(), $proposal_id)) {
					redirect(cortiam_base_url('view-interest/').$newer_proposal['prop_id'].'-'.url_title( trim( preg_replace( "/[^0-9a-z]+/i", " ",  $newer_proposal['first_name'].' '.$newer_proposal['last_name'])), 'underscore', true), 'refresh');
					exit();
				}else{
					$this->page_data['property'] = $this->seller_model->get_my_property($this->ion_auth->get_user_id(), $this->page_data['proposal']['property_id']);
					if ($this->page_data['proposal']['base_id'] || $this->page_data['proposal']['main_id']) {
						$this->page_data['related_proposals'] = $this->seller_model->get_related_proposal((($this->page_data['proposal']['base_id'])? $this->page_data['proposal']['base_id']:$this->page_data['proposal']['main_id']));
					}
					$this->page_data['agent_account'] = $this->seller_model->get_agent($this->page_data['proposal']['agent_id']);
					$this->page_data['header_data']['meta_title'] .= ' - View Agents Interest';
					$this->page_data['header_data']['page_title'] = 'View Interest';
					$this->page_data['header_data']['current_menu'] = 'agents';

					$this->seller_model->mark_proposal_read($this->ion_auth->get_user_id(), $proposal_id);
					$this->page_data['agent_licenses'] = $this->seller_model->get_agent_licenses($this->page_data['proposal']['agent_id']);

					$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "proposal_id" => $proposal_id, "acceptproposalurl" => cortiam_base_url('ajax/accept-proposal'), "declineproposalurl" => cortiam_base_url('ajax/decline-proposal'), "counterofferform" => cortiam_base_url('ajax/counter-offer-form'), "counterofferurl" => cortiam_base_url('ajax/send-counter-offer'), "withdrawproposalurl" => cortiam_base_url('ajax/withdraw-proposal')));

					$this->_frontend('interest_view', 'seller');
				}
			}else{
				$this->session->set_flashdata('notify', 'error');
				$this->session->set_flashdata('notify_message', 'Requested proposal cannot be found. Please check your URL and try again.');
				$this->session->set_flashdata('notify_title', 'Requested Proposal Cannot Found');
				redirect(cortiam_base_url('agents'), 'refresh');
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
	 * Displays the homepage/dashboard of the Lead Distribution Application
	 * @uses system_model::lead_graphic_stats To get latest weeks active, send and removed lead stats
	 * @uses system_model::system_report To get latest system actions
	 * @uses system_model::get_campaigns To get active system campaigns
	 * @uses system_model::next_week_graphic_stats To get next weeks lead distribution details
	 *
	 * @return void
	 */
	public function agent_profile($agent_string = null){
		if ($agent_string) {
			$url = explode('-',$agent_string);
			$agent_id = (int) $url[0];
			if ($this->page_data['agent_account'] = $this->seller_model->get_agent($agent_id)) {
				if($this->page_data['agent_account']['approval'] == 'Completed'){
					$this->page_data['header_data']['meta_title'] .= ' - View Agent Profile';
					$this->page_data['header_data']['page_title'] = 'View Agent Profile';
					$this->page_data['header_data']['current_menu'] = 'proposals';

					$this->page_data['favorite_status'] = $this->seller_model->get_favorite_value($this->account['id'],$agent_id);
					$this->page_data['agent_proposals'] = $this->seller_model->get_agent_proposals($this->account['id'],$agent_id);
					$this->page_data['agent_licenses'] = $this->seller_model->get_agent_licenses($agent_id);

					$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "agent_id" => $agent_id, "favoriteurl" => cortiam_base_url('ajax/favorite-agent'), "messageformurl" => cortiam_base_url('ajax/message-form'), "messagesendurl" => cortiam_base_url('ajax/send-message'), "acceptproposalurl" => cortiam_base_url('ajax/accept-proposal'), "declineproposalurl" => cortiam_base_url('ajax/decline-proposal'), "counterofferform" => cortiam_base_url('ajax/counter-offer-form'), "counterofferurl" => cortiam_base_url('ajax/send-counter-offer'), "withdrawproposalurl" => cortiam_base_url('ajax/withdraw-proposal')));
					$this->_frontend('agent_profile', 'seller');
				}else{
					$this->session->set_flashdata('notify', 'error');
					$this->session->set_flashdata('notify_message', 'Requested agent is currently inactive, because of this agent profile not available.');
					$this->session->set_flashdata('notify_title', 'Requested Agent Profile Currently Not Available');
					redirect(cortiam_base_url(''), 'refresh');
					exit();
				}
			}else{
				$this->session->set_flashdata('notify', 'error');
				$this->session->set_flashdata('notify_message', 'Requested agent profile cannot be found. Please check your URL and try again.');
				$this->session->set_flashdata('notify_title', 'Requested Agent Profile Cannot Found');
				redirect(cortiam_base_url(''), 'refresh');
				exit();
			}
		}else{
			$this->session->set_flashdata('notify', 'error');
			$this->session->set_flashdata('notify_message', 'Requested agent profile cannot be found. Please check your URL and try again.');
			$this->session->set_flashdata('notify_title', 'Requested Agent Profile Cannot Found');
			redirect(cortiam_base_url(''), 'refresh');
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
	public function message_center(){
		$this->page_data['header_data']['meta_title'] .= ' - Message Center';
		$this->page_data['header_data']['page_title'] = 'Message Center';
		$this->page_data['header_data']['current_menu'] = 'messagecenter';

		$this->page_data['messages'] = $this->seller_model->get_message_list($this->ion_auth->get_user_id());

		$this->_frontend('message_center', 'seller');
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
	public function view_messages($agent_string = null){
		$this->page_data['header_data']['meta_title'] .= ' - Message Box';
		$this->page_data['header_data']['page_title'] = 'Message Box';
		$this->page_data['header_data']['current_menu'] = 'messagecenter';
		if ($agent_string) {
			$url = explode('-',$agent_string);
			$agent_id = (int) $url[0];
			if ($this->page_data['messages'] = $this->seller_model->get_messages_of($this->ion_auth->get_user_id(),$agent_id)) {
				$this->seller_model->mark_messages_read($this->ion_auth->get_user_id(),$agent_id);
			}
			$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/send-message-to/'.$agent_id)));
			$this->_frontend('messages', 'seller');
		}else{
			$this->session->set_flashdata('notify', 'error');
			$this->session->set_flashdata('notify_message', 'Requested message history cannot be found. Please check your URL and try again.');
			$this->session->set_flashdata('notify_title', 'Requested Message History Cannot Found');
			redirect(cortiam_base_url(''), 'refresh');
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
	public function agreements(){
		$this->page_data['header_data']['meta_title'] .= ' - Agreements';
		$this->page_data['header_data']['page_title'] = 'Agreements';
		$this->page_data['header_data']['current_menu'] = 'agreements';

		$this->page_data['agreements'] = $this->seller_model->get_aggrements($this->ion_auth->get_user_id());
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "accepturl" => cortiam_base_url('ajax/accept-agreement'), "declineurl" => cortiam_base_url('ajax/decline-agreement')));

		$this->_frontend('agreements', 'seller');
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
	public function tutorials(){
		$this->page_data['header_data']['meta_title'] .= ' - Tutorials';
		$this->page_data['header_data']['page_title'] = 'Tutorials';
		$this->page_data['header_data']['current_menu'] = 'tutorial';

		$this->page_data['content'] = $this->seller_model->get_tutorial();
		$this->_frontend('tutorial', 'seller');
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
	public function support_center(){
		$this->page_data['header_data']['meta_title'] .= ' - Support Request';
		$this->page_data['header_data']['page_title'] = 'Support Request';
		$this->page_data['header_data']['current_menu'] = 'support';

		$this->page_data['messages'] = $this->seller_model->get_support_messages($this->ion_auth->get_user_id());
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => cortiam_base_url('ajax/send-support/')));

		$this->_frontend('support_center', 'seller');
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
	public function notifications(){
		$this->page_data['header_data']['meta_title'] .= ' - System Notifications';
		$this->page_data['header_data']['page_title'] = 'System Notifications';
		$this->page_data['header_data']['current_menu'] = 'notifications';

		$this->page_data['notifications'] = $this->seller_model->get_notifications($this->ion_auth->get_user_id());
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif')));

		$this->_frontend('notifications', 'seller');
	}
}
?>