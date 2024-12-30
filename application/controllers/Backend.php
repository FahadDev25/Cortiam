<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Backend Display controller
 *
 * The base controller which displays the pages of the Cortiam Web Applications Backend Panel
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

class Backend extends CRTM_Controller {

	function __construct(){

		log_message("error", "print msg..admin");
		
		parent::__construct();
		$this->load->database();
		$this->load->model('backend_model');
		$this->load->helper(array('backend'));

		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/fonts.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/icons/icomoon/styles.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/bootstrap_limitless.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/layout.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/components.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/colors.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/animate.min.css');
		$this->page_data['header_data']['css_files'][] = base_url('assets/css/dist/datepicker.css');

		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/ui/moment/moment.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/pnotify.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/datatables.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/pdfmake/pdfmake.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/pdfmake/vfs_fonts.min.js"');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/buttons.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/tables/datatables/extensions/datetime-moment.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/styling/uniform.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/notifications/sweet_alert.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/formatter.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/jquery.alphanum.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/styling/switchery.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/styling/switch.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/passy.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/maxlength.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/forms/inputs/maskmoney.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/media/heic2any.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/media/cropper.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/interactions.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/widgets.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/effects.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/mousewheel.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/extensions/jquery_ui/globalize/globalize.js"');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/pickers/daterangepicker.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/pickers/datepicker.js');
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


		if ($this->ion_auth->logged_in() && ($this->ion_auth->get_user_type() == 'Administrator'))	{
			$this->page_data["account"] =  $this->account = $this->backend_model->get_administrator($this->ion_auth->get_user_id());
		}else{
			redirect('/login', 'refresh');
		}
		$this->page_data["waiting_approvals"] =  $this->backend_model->waiting_approvals();
		$this->page_data["waiting_supports"] =  $this->backend_model->waiting_support();
		$this->page_data["waiting_notifications"] =  $this->backend_model->waiting_notifications($this->ion_auth->get_user_id());
		$this->_addjson('mainfunc',array( 'clearnotification_url' => base_url('/ajax/backend/clear-all-notifications'), 'notify_id' => $this->account['id']));
		
		if ($this->session->flashdata('notify')) {
			$this->_addjson('notify',array( 'type' => $this->session->flashdata('notify'), 'text' => $this->session->flashdata('notify_message'), 'title' => $this->session->flashdata('notify_title'), 'addclass' => 'alert  alert-styled-left'));
		}else{
			$this->_addjson('notify',array());
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
	public function index(){
		$this->page_data['header_data']['meta_title']         .= ' - Dashboard';
		$this->page_data['header_data']['page_title'] 		  .= 'Dashboard';
		$this->page_data['header_data']['breadcrumb'][0] 	   = 'Dashboard';
		$this->page_data['header_data']['breadcrumb_links'][0] = base_url('');
		$this->page_data['header_data']['menusection'] 		   = 'dashboard';
		$this->page_data['header_data']['menuitem']            = 'dashboard';
		$this->page_data['footer_data']['js_files'][]          = base_url('assets/js/plugins/visualization/d3/d3.min.js');
		$this->page_data['footer_data']['js_files'][]          = base_url('assets/js/plugins/visualization/d3/d3_tooltip.js');

		$rep_agents 				         = $this->backend_model->dashboard_last_agents();
		$rep_sellers 				         = $this->backend_model->dashboard_last_sellers();
		$rep_properties			 	         = $this->backend_model->dashboard_last_properties();
		$rep_invoices 				         = $this->backend_model->dashboard_last_earnings();
		$this->page_data['agent_count'] 	 = $rep_agents['total'];
		$this->page_data['seller_count'] 	 = $rep_sellers['total'];
		$this->page_data['properties_count'] = $rep_properties['total'];
		$this->page_data['invoice_count'] 	 = $rep_invoices['total'];
		$this->page_data['coupon_count'] 	 = $this->backend_model->dashboard_coupon_count();
		$this->page_data['proposal_count'] 	 = $this->backend_model->dashboard_proposals_count();
		$this->page_data['contract_count'] 	 = $this->backend_model->dashboard_contract_count();
		$this->page_data['last_agents'] 	 = $this->backend_model->get_agents(array('limit'=>5));
		$this->page_data['last_sellers']	 = $this->backend_model->get_sellers(array('limit'=>5));

		$this->page_data['last_properties']  = $this->backend_model->get_properties(array('limit'=>5,'order'=>"FIELD(properties.status,'Active','Inactivated','Contracted','Deleted'), properties.approval_date DESC"));


	    $this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "agent_chart" => $rep_agents['list'], "seller_chart" => $rep_sellers['list'], "properties_chart" => array_values($rep_properties['list']), "invoice_chart" => array_values($rep_invoices['list'])));
		$this->_backend('dashboard');
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
	public function settings(){
		check_permission(560,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Site Settings';
		$this->page_data['header_data']['page_title'] .= 'Site Settings';
		$this->page_data['header_data']['breadcrumb'][0] = 'Site Settings';
		$this->page_data['header_data']['breadcrumb_links'][0] = base_url('ct-admin/settings');
		$this->page_data['header_data']['menusection'] = 'settings';
		$this->page_data['header_data']['menuitem'] = 'settings';

		$this->page_data['settings'] = $this->backend_model->get_settings();
		$this->page_data['state_costs'] = $this->backend_model->get_state_costs();
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/save-settings')));
		$this->_backend('settings');
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
	public function free_period(){
		check_permission(560,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Free Payment Periods';
		$this->page_data['header_data']['page_title'] .= 'Free Payment Periods';
		$this->page_data['header_data']['breadcrumb'][0] = 'Free Payment Periods';
		$this->page_data['header_data']['breadcrumb_links'][0] = base_url('ct-admin/free-period');
		$this->page_data['header_data']['menusection'] = 'settings';
		$this->page_data['header_data']['menuitem'] = 'freepayment';

		$this->page_data['free_periods'] = $this->backend_model->get_state_costs();
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/save-free-payment-periods')));
		$this->_backend('free_period');
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
	public function state_signup(){
		check_permission(576,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Signup Settings';
		$this->page_data['header_data']['page_title'] .= 'Signup Settings';
		$this->page_data['header_data']['breadcrumb'][0] = 'Signup Settings';
		$this->page_data['header_data']['breadcrumb_links'][0] = base_url('ct-admin/state-signup');
		$this->page_data['header_data']['menusection'] = 'settings';
		$this->page_data['header_data']['menuitem'] = 'signup';

		$this->page_data['states'] = $this->backend_model->get_state_costs();
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/save-state-signups')));
		$this->_backend('state_signup');
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
	public function list_administrator(){
		check_permission(10,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of administrator accounts';
		$this->page_data['header_data']['main_title'] = 'Administrators';
		$this->page_data['header_data']['page_title'] = 'Administrator List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Administrators';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'admins';
		$this->page_data['header_data']['menuitem'] = 'listadmin';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-admins'), "deleteajaxurl" => base_url('/ajax/backend/delete-administrator'), "acenableajaxurl" => base_url('/ajax/backend/enable-administrator'), "acdisableeajaxurl" => base_url('/ajax/backend/disable-administrator')));
		$this->_backend('admin_list');
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
	public function add_administrator(){
		check_permission(20,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Add new administrator account';
		$this->page_data['header_data']['main_title'] = 'Administrators';
		$this->page_data['header_data']['page_title'] = 'Add New Administrator';
		$this->page_data['header_data']['breadcrumb'][1] = 'Administrators';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-administrator');
		$this->page_data['header_data']['breadcrumb'][2] = 'Add New Administrator';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'admins';
		$this->page_data['header_data']['menuitem'] = 'addadmin';

		$this->page_data['admin_permissions'] = $this->config->item('admin_permissions');
		$this->page_data['admin_notifications'] = $this->config->item('admin_notifications');
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/add-administrator')));
		$this->_backend('admin_add');
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
	public function edit_administrator($user_id){
		check_permission(30,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Edit administrator account';
		$this->page_data['header_data']['main_title'] = 'Administrators';
		$this->page_data['header_data']['page_title'] = 'Edit Administrator';
		$this->page_data['header_data']['breadcrumb'][1] = 'Administrators';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-administrator');
		$this->page_data['header_data']['breadcrumb'][2] = 'Edit Administrator';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'admins';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'admin_review',$user_id);
		$this->page_data['admin_permissions'] = $this->config->item('admin_permissions');
		$this->page_data['admin_notifications'] = $this->config->item('admin_notifications');
		$this->page_data['administrator'] = $this->backend_model->get_administrator($user_id);
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-administrator'), "emptyphoto" => base_url('assets/images/backend/userphoto.jpg'),"deleteprofileimgurl" => base_url('/ajax/backend/delete-profile-image')));
		$this->_backend('admin_edit');
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
	public function list_seller(){
		check_permission(190,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of property owner accounts';
		$this->page_data['header_data']['main_title'] = 'Property Owners';
		$this->page_data['header_data']['page_title'] = 'Property Owner List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Property Owners';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'sellers';
		$this->page_data['header_data']['menuitem'] = 'listseller';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-sellers'), "deleteajaxurl" => base_url('/ajax/backend/delete-seller'), "acenableajaxurl" => base_url('/ajax/backend/enable-seller'), "acdisableeajaxurl" => base_url('/ajax/backend/disable-seller')));
		$this->_backend('seller_list');
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
	public function add_seller(){
		check_permission(200,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Add new property owner account';
		$this->page_data['header_data']['main_title'] = 'Property Owners';
		$this->page_data['header_data']['page_title'] = 'Add New Property Owner';
		$this->page_data['header_data']['breadcrumb'][1] = 'Property Owners';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-seller');
		$this->page_data['header_data']['breadcrumb'][2] = 'Add New Property Owner';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'sellers';
		$this->page_data['header_data']['menuitem'] = 'addseller';

		$this->page_data['seller_notifications'] = $this->config->item('seller_notifications');
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/add-seller')));
		$this->_backend('seller_add');
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
	public function edit_seller($user_id){
		check_permission(210,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Edit property owner account';
		$this->page_data['header_data']['main_title'] = 'Property Owners';
		$this->page_data['header_data']['page_title'] = 'Edit Property Owner';
		$this->page_data['header_data']['breadcrumb'][1] = 'Property Owners';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-seller');
		$this->page_data['header_data']['breadcrumb'][2] = 'Edit Property Owner';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'sellers';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'seller_edit',$user_id);
		$this->page_data['seller_notifications'] = $this->config->item('seller_notifications');
		$this->page_data['seller'] = $this->backend_model->get_seller($user_id);
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-seller'), "propertiestableajaxurl" => base_url('/ajax/backend/list-properties'), "offertableajaxurl" => base_url('/ajax/backend/list-offers'), "viewofferurl" => base_url('/ajax/backend/view-offer'), "contracttableajaxurl" => base_url('/ajax/backend/list-contracts'), "viewcontracturl" => base_url('/ajax/backend/view-contract'), "messagetableajaxurl" => base_url('/ajax/backend/list-messages'), "viewmessageurl" => base_url('/ajax/backend/view-message'), "seller_id" => $user_id, "emptyphoto" => base_url('assets/images/backend/userphoto.jpg'),"deleteprofileimgurl" => base_url('/ajax/backend/delete-profile-image')));
		$this->_backend('seller_edit');
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
	public function list_agent(){
		check_permission(60,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of real estate agent accounts';
		$this->page_data['header_data']['main_title'] = 'Real Estate Agents';
		$this->page_data['header_data']['page_title'] = 'Real Estate Agent List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Real Estate Agents';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'agents';
		$this->page_data['header_data']['menuitem'] = 'listagent';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-agents'), "deleteajaxurl" => base_url('/ajax/backend/delete-agent'), "acenableajaxurl" => base_url('/ajax/backend/enable-agent'), "acdisableeajaxurl" => base_url('/ajax/backend/disable-agent')));
		$this->_backend('agent_list');
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
	public function add_agent(){
		check_permission(70,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Add new real estate agent account';
		$this->page_data['header_data']['main_title'] = 'Real Estate Agents';
		$this->page_data['header_data']['page_title'] = 'Add New Real Estate Agent';
		$this->page_data['header_data']['breadcrumb'][1] = 'Real Estate Agents';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-agent');
		$this->page_data['header_data']['breadcrumb'][2] = 'Add New Real Estate Agent';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'agents';
		$this->page_data['header_data']['menuitem'] = 'addagent';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/add-agent'), "avataruploadurl" => base_url('/ajax/backend/upload-avatar')));
		$this->_backend('agent_add');
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
	public function edit_agent($user_id){
		check_permission(80,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] 	.= ' - Edit real estate agent account';
		$this->page_data['header_data']['main_title']  	= 'Real Estate Agents';
		$this->page_data['header_data']['page_title']    = 'Edit Real Estate Agent';
		$this->page_data['header_data']['breadcrumb'][1] = 'Real Estate Agents';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-agent');
		$this->page_data['header_data']['breadcrumb'][2] = 'Edit Real Estate Agent';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'agents';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'agent_edit',$user_id);
		$this->page_data['agent'] = $this->backend_model->get_agent($user_id);
		$this->page_data['invoices'] = $this->backend_model->get_user_invoices($user_id, array('Completed','Open','Failed','Refund'));
		$this->page_data['licenses']  =	$this->backend_model->get_licenses($user_id);

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-agent'), "avataruploadurl" => base_url('/ajax/backend/upload-avatar'), "propertiestableajaxurl" => base_url('/ajax/backend/list-properties'), "offertableajaxurl" => base_url('/ajax/backend/list-offers'), "viewofferurl" => base_url('/ajax/backend/view-offer'), "contracttableajaxurl" => base_url('/ajax/backend/list-contracts'), "viewcontracturl" => base_url('/ajax/backend/view-contract'), "messagetableajaxurl" => base_url('/ajax/backend/list-messages'), "viewmessageurl" => base_url('/ajax/backend/view-message'), "listpackagesurl" => base_url('ajax/backend/list-available-packages'), "buypackageurl" => base_url('ajax/backend/add-package-to-user'), "refundurl" => base_url('ajax/backend/refund-payment'), "agent_id" => $user_id, "emptyphoto" => base_url('assets/images/backend/userphoto.jpg'),"deleteprofileimgurl" => base_url('/ajax/backend/delete-profile-image'), "getlicenseformurl" => base_url('ajax/backend/get-licenseform'), "addlicenseurl" => base_url('ajax/backend/add-license'), "editlicenseurl" => base_url('ajax/backend/edit-license'), "deletelicenseurl" => base_url('ajax/backend/delete-license'), "approvelicenseurl" => base_url('ajax/backend/approve-license'), "listlicenseurl" => base_url('ajax/backend/list-licenses')));
		$this->_backend('agent_edit');
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
	public function awaiting_users(){
		check_permission(261,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of waiting users';
		$this->page_data['header_data']['main_title'] = 'Waitlist';
		$this->page_data['header_data']['page_title'] = 'Waiting User List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Waitlist';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'awaiting';
		$this->page_data['header_data']['menuitem'] = 'awaiting';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-awaitings'), "deleteajaxurl" => base_url('/ajax/backend/delete-awaiting')));
		$this->_backend('awaiting_list');
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
		check_permission(270,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Property Listing';
		$this->page_data['header_data']['main_title'] = 'Properties';
		$this->page_data['header_data']['page_title'] = 'Property Listing';
		$this->page_data['header_data']['breadcrumb'][1] = 'Properties';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'properties';
		$this->page_data['header_data']['menuitem'] = 'listproperty';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-properties'), "deleteajaxurl" => base_url('/ajax/backend/delete-property')));
		$this->_backend('property_list');
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
		check_permission(280,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Add new property';
		$this->page_data['header_data']['main_title'] = 'Properties';
		$this->page_data['header_data']['page_title'] = 'Add New Property';
		$this->page_data['header_data']['breadcrumb'][1] = 'Properties';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-properties');
		$this->page_data['header_data']['breadcrumb'][2] = 'Add New Property';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'properties';
		$this->page_data['header_data']['menuitem'] = 'addproperty';

		$this->page_data['sellers'] = $this->backend_model->get_sellers();
		$this->_addjson('property_types',array("residental" => $this->config->item('residental_types'), "commercial" => $this->config->item('commercial_types')));
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/add-property'), "propimageuploadurl" => base_url('/ajax/backend/upload-property-image') ,"getlocationajaxurl" => base_url('/ajax/backend/get-map-location'), "map_key" => $this->config->item('bing_token'), "latitude" => $this->page_data['property']['latitude'], "longitude" => $this->page_data['property']['longitude']));
		$this->_backend('property_add');
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
	public function edit_property($property_id){
		check_permission(290,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Edit property';
		$this->page_data['header_data']['main_title'] = 'Properties';
		$this->page_data['header_data']['page_title'] = 'Edit Property';
		$this->page_data['header_data']['breadcrumb'][1] = 'Properties';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-properties');
		$this->page_data['header_data']['breadcrumb'][2] = 'Edit Property';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'properties';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'property_edit',$property_id);
		$this->page_data['property'] = $this->backend_model->get_property($property_id);
		$this->page_data['sellers'] = $this->backend_model->get_sellers();
		$this->page_data['seller'] = $this->backend_model->get_seller($this->page_data['property']['seller_id']);
		$this->_addjson('property_types',array("residental" => $this->config->item('residental_types'), "commercial" => $this->config->item('commercial_types'), "current" => $this->page_data['property']['type'], "sub_type" => $this->page_data['property']['sub_type']));
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-property'), "propimageuploadurl" => base_url('/ajax/backend/upload-property-image') ,"defaultimageurl" => base_url('/ajax/backend/set-default-image'),"emptyphoto" => base_url('assets/images/backend/propertyphoto.jpg'),"deleteimageurl" => base_url('/ajax/backend/delete-property-image'), "getlocationajaxurl" => base_url('/ajax/backend/get-map-location'), "map_key" => $this->config->item('bing_token'), "latitude" => $this->page_data['property']['latitude'], "longitude" => $this->page_data['property']['longitude']));
		$this->_backend('property_edit');
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
	public function approval_sellers(){
		check_permission(330,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Seller Approvals';
		$this->page_data['header_data']['main_title'] = 'Seller Approvals';
		$this->page_data['header_data']['page_title'] = 'Seller Approvals';
		$this->page_data['header_data']['breadcrumb'][1] = 'Seller Approvals';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'approvals';
		$this->page_data['header_data']['menuitem'] = 'sellerapproval';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-sellerapp'), "deleteajaxurl" => base_url('/ajax/backend/delete-property')));
		$this->_backend('approval_sellers');
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
	public function approval_agents(){
		check_permission(350,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Agent Approvals';
		$this->page_data['header_data']['main_title'] = 'Agent Approvals';
		$this->page_data['header_data']['page_title'] = 'Agent Approvals';
		$this->page_data['header_data']['breadcrumb'][1] = 'Agent Approvals';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'approvals';
		$this->page_data['header_data']['menuitem'] = 'agentapproval';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-agentapp'), "deleteajaxurl" => base_url('/ajax/backend/delete-property')));
		$this->_backend('approval_agents');
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
	public function approval_properties(){
		check_permission(370,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Property Approvals';
		$this->page_data['header_data']['main_title'] = 'Property Approvals';
		$this->page_data['header_data']['page_title'] = 'Property Approvals';
		$this->page_data['header_data']['breadcrumb'][1] = 'Property Approvals';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'approvals';
		$this->page_data['header_data']['menuitem'] = 'propertyapproval';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-propertiesapp'), "deleteajaxurl" => base_url('/ajax/backend/delete-property')));
		$this->_backend('approval_properties');
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
	public function review_seller($user_id){
		check_permission(340,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Review Seller Account';
		$this->page_data['header_data']['main_title'] = 'Sellers';
		$this->page_data['header_data']['page_title'] = 'Review Seller';
		$this->page_data['header_data']['breadcrumb'][1] = 'Seller Approvals';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/approval-sellers');
		$this->page_data['header_data']['breadcrumb'][2] = 'Review Seller';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'approvals';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'seller_review',$user_id);
		$this->page_data['seller'] = $this->backend_model->get_seller($user_id);
		$this->page_data['history'] = $this->backend_model->list_approval_text(array('seller_id' => $user_id));

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-seller'), "avataruploadurl" => base_url('/ajax/backend/upload-avatar'), "seller_id" => $user_id, "approveajaxurl" => base_url('/ajax/backend/approve-seller/'.$user_id), "declineajaxurl" => base_url('/ajax/backend/decline-seller/'.$user_id)));
		$this->_backend('seller_review');
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
	public function review_agent($user_id){
		check_permission(360,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Review Agent Account';
		$this->page_data['header_data']['main_title'] = 'Agents';
		$this->page_data['header_data']['page_title'] = 'Review Agent';
		$this->page_data['header_data']['breadcrumb'][1] = 'Agent Approvals';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/approval-agents');
		$this->page_data['header_data']['breadcrumb'][2] = 'Review Agent';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'approvals';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'agent_review',$user_id);
		$this->page_data['agent'] = $this->backend_model->get_agent($user_id);
		$this->page_data['history'] = $this->backend_model->list_approval_text(array('agent_id' => $user_id));
		$this->page_data['licenses']  =	$this->backend_model->get_licenses($user_id);

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-agent'), "avataruploadurl" => base_url('/ajax/backend/upload-avatar'), "agent_id" => $user_id, "approveajaxurl" => base_url('/ajax/backend/approve-agent/'.$user_id), "declineajaxurl" => base_url('/ajax/backend/decline-agent/'.$user_id), "agent_id" => $user_id, "emptyphoto" => base_url('assets/images/backend/userphoto.jpg'),"deleteprofileimgurl" => base_url('/ajax/backend/delete-profile-image'), "getlicenseformurl" => base_url('ajax/backend/get-licenseform'), "addlicenseurl" => base_url('ajax/backend/add-license'), "editlicenseurl" => base_url('ajax/backend/edit-license'), "deletelicenseurl" => base_url('ajax/backend/delete-license'), "approvelicenseurl" => base_url('ajax/backend/approve-license'), "listlicenseurl" => base_url('ajax/backend/list-licenses'), "deleteajaxurl" => base_url('/ajax/backend/delete-agent')));
		$this->_backend('agent_review');
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
		check_permission(380,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Review Property';
		$this->page_data['header_data']['main_title'] = 'Property Details';
		$this->page_data['header_data']['page_title'] = 'Review Property';
		$this->page_data['header_data']['breadcrumb'][1] = 'Property Approvals';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/approval-properties');
		$this->page_data['header_data']['breadcrumb'][2] = 'Review Property';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'approvals';
		$this->page_data['header_data']['menuitem'] = '';


		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'property_review',$property_id);
		$this->page_data['property'] = $this->backend_model->get_property($property_id);
		$this->page_data['sellers'] = $this->backend_model->get_sellers(array('approval' => 'All'));
		$this->page_data['seller'] = $this->backend_model->get_seller($this->page_data['property']['seller_id']);
		$this->page_data['history'] = $this->backend_model->list_approval_text(array('seller_id' => $this->page_data['property']['seller_id'], 'property_id' => $property_id));
		$this->_addjson('property_types',array("residental" => $this->config->item('residental_types'), "commercial" => $this->config->item('commercial_types'), "current" => $this->page_data['property']['type'], "sub_type" => $this->page_data['property']['sub_type']));
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-property'), "propimageuploadurl" => base_url('/ajax/backend/upload-property-image') ,"defaultimageurl" => base_url('/ajax/backend/set-default-image'),"emptyphoto" => base_url('assets/images/backend/propertyphoto.jpg'),"deleteimageurl" => base_url('/ajax/backend/delete-property-image'), "getlocationajaxurl" => base_url('/ajax/backend/get-map-location'), "map_key" => $this->config->item('bing_token'), "latitude" => $this->page_data['property']['latitude'], "longitude" => $this->page_data['property']['longitude'], "approveajaxurl" => base_url('/ajax/backend/approve-property/'.$property_id), "declineajaxurl" => base_url('/ajax/backend/decline-property/'.$property_id)));
		$this->_backend('property_review');
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
	public function list_coupons(){
		check_permission(400,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of coupons';
		$this->page_data['header_data']['main_title'] = 'Coupons';
		$this->page_data['header_data']['page_title'] = 'Coupons List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Coupons';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'coupons';
		$this->page_data['header_data']['menuitem'] = 'listcoupon';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-coupons'), "deleteajaxurl" => base_url('/ajax/backend/delete-coupon')));
		$this->_backend('coupon_list');
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
	public function add_coupon(){
		check_permission(410,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Add new coupon';
		$this->page_data['header_data']['main_title'] = 'Coupons';
		$this->page_data['header_data']['page_title'] = 'Add New Coupon';
		$this->page_data['header_data']['breadcrumb'][1] = 'Coupons';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-coupons');
		$this->page_data['header_data']['breadcrumb'][2] = 'Add New Coupon';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'coupons';
		$this->page_data['header_data']['menuitem'] = 'addcoupon';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/add-coupon')));
		$this->_backend('coupon_add');
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
	public function edit_coupon($coupon_id){
		check_permission(420,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Edit coupon account';
		$this->page_data['header_data']['main_title'] = 'Coupons';
		$this->page_data['header_data']['page_title'] = 'Edit Coupon';
		$this->page_data['header_data']['breadcrumb'][1] = 'Coupons';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-coupons');
		$this->page_data['header_data']['breadcrumb'][2] = 'Edit Coupon';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'coupons';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data['coupon'] = $this->backend_model->get_coupon($coupon_id);
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-coupon')));
		$this->_backend('coupon_edit');
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
	public function user_reporting(){
		check_permission(520,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - User Reporting';
		$this->page_data['header_data']['main_title'] = 'Reportings';
		$this->page_data['header_data']['page_title'] = 'User Report';
		$this->page_data['header_data']['breadcrumb'][1] = 'User Reporting';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/user-reporting');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/visualization/echarts/echarts.min.js');
		$this->page_data['header_data']['menusection'] = 'reportings';
		$this->page_data['header_data']['menuitem'] = 'userreporting';

		$this->page_data['reportdatas'] = $this->backend_model->get_user_graph();
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "userdataurl" => base_url('/ajax/backend/get-user-graph'), "reportdata" => $this->page_data['reportdatas']['formatted'], "tabledata" => $this->page_data['reportdatas']['datatable']));
		$this->_backend('user_reporting');
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
	public function property_reporting(){
		check_permission(530,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Property Reporting';
		$this->page_data['header_data']['main_title'] = 'Reportings';
		$this->page_data['header_data']['page_title'] = 'Property Report';
		$this->page_data['header_data']['breadcrumb'][1] = 'Property Reporting';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/property-reporting');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/visualization/echarts/echarts.min.js');
		$this->page_data['header_data']['menusection'] = 'reportings';
		$this->page_data['header_data']['menuitem'] = 'propertyreporting';

		$this->page_data['reportdatas'] = $this->backend_model->get_properties_graph();
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "propertydataurl" => base_url('/ajax/backend/get-property-graph'), "reportdata" => $this->page_data['reportdatas']['formatted'], "tabledata" => $this->page_data['reportdatas']['datatable']));
		$this->_backend('property_reporting');
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
	public function financial_reporting(){
		check_permission(540,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Financial Reporting';
		$this->page_data['header_data']['main_title'] = 'Reportings';
		$this->page_data['header_data']['page_title'] = 'Financial Report';
		$this->page_data['header_data']['breadcrumb'][1] = 'Financial Reporting';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/financial-reporting');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/visualization/echarts/echarts.min.js');
		$this->page_data['header_data']['menusection'] = 'reportings';
		$this->page_data['header_data']['menuitem'] = 'financialreporting';

		$this->page_data['reportdatas'] = $this->backend_model->get_financial_graph();
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "financialdataurl" => base_url('/ajax/backend/get-financial-graph'), "reportdata" => $this->page_data['reportdatas']['formatted'], "tabledata" => $this->page_data['reportdatas']['datatable']));
		$this->_backend('financial_reporting');
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
	public function tutorial_agent(){
		check_permission(550,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Edit Real Estate Agent Tutorial Page';
		$this->page_data['header_data']['main_title'] = 'Real Estate Agent Tutorial Page';
		$this->page_data['header_data']['page_title'] = 'Edit Real Estate Agent Tutorial Page';
		$this->page_data['header_data']['breadcrumb'][1] = 'Edit Real Estate Agent Tutorial Page';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/summernote/summernote.min.js');
		$this->page_data['header_data']['menusection'] = 'tutorials';
		$this->page_data['header_data']['menuitem'] = 'agenttutorial';

		$this->page_data['content'] = $this->backend_model->get_tutorial('agent');
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/tutorial-agent')));
		$this->_backend('tutorial_agent');
	}


	public function tutorial_video(){
		check_permission(550,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Edit Real Estate Agent Tutorial Page';
		$this->page_data['header_data']['main_title'] = 'Real Estate Agent Tutorial Page';
		$this->page_data['header_data']['page_title'] = 'Edit Real Estate Agent Tutorial Page';
		$this->page_data['header_data']['breadcrumb'][1] = 'Edit Real Estate Agent Tutorial Page';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/summernote/summernote.min.js');
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/pages/backend/agent-video.js');

		$this->page_data['header_data']['menusection'] = 'tutorials';
		$this->page_data['header_data']['menuitem'] = 'agentvideo';

		$this->page_data['content'] = $this->backend_model->get_tutorial('agent-video');
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/agent-video')));
		$this->_backend('agent_video');
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
	public function tutorial_seller()
	{
		check_permission(550,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Edit Property Owner Tutorial Page';
		$this->page_data['header_data']['main_title'] = 'Property Owner Tutorial Page';
		$this->page_data['header_data']['page_title'] = 'Edit Property Owner Tutorial Page';
		$this->page_data['header_data']['breadcrumb'][1] = 'Edit Property Owner Tutorial Page';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['footer_data']['js_files'][] = base_url('assets/js/plugins/editors/summernote/summernote.min.js');
		$this->page_data['header_data']['menusection'] = 'tutorials';
		$this->page_data['header_data']['menuitem'] = 'sellertutorial';

		$this->page_data['content'] = $this->backend_model->get_tutorial('seller');
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/tutorial-seller')));
		$this->_backend('tutorial_seller');
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
	public function list_messages(){
		check_permission(480,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of messages';
		$this->page_data['header_data']['main_title'] = 'Messages';
		$this->page_data['header_data']['page_title'] = 'Messages List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Messages';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'messages';
		$this->page_data['header_data']['menuitem'] = 'messages';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "messagetableajaxurl" => base_url('/ajax/backend/list-messages'), "viewmessageurl" => base_url('/ajax/backend/view-message')));
		$this->_backend('message_list');
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
		$this->page_data['header_data']['meta_title'] .= ' - Notifications';
		$this->page_data['header_data']['main_title'] = 'Notifications';
		$this->page_data['header_data']['page_title'] = 'Notification List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Notifications';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'notifications';
		$this->page_data['header_data']['menuitem'] = 'notifications';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "notificationtableajaxurl" => base_url('/ajax/backend/list-notifications'), "viewnotificationurl" => base_url('/ajax/backend/view-notification')));
		$this->_backend('notifications');
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
	public function list_introductions(){
		check_permission(500,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of introductions';
		$this->page_data['header_data']['main_title'] = 'Introductions';
		$this->page_data['header_data']['page_title'] = 'Introduction List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Introductions';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'introductions';
		$this->page_data['header_data']['menuitem'] = 'introductions';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "offertableajaxurl" => base_url('/ajax/backend/list-offers'), "viewofferurl" => base_url('/ajax/backend/view-offer')));
		$this->_backend('proposal_list');
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
	public function list_agreements(){
		check_permission(510,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of agreements';
		$this->page_data['header_data']['main_title'] = 'Agreements ';
		$this->page_data['header_data']['page_title'] = 'Agreement List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Agreements';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'agreements';
		$this->page_data['header_data']['menuitem'] = 'agreements';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "contracttableajaxurl" => base_url('/ajax/backend/list-contracts'), "viewcontracturl" => base_url('/ajax/backend/view-contract')));
		$this->_backend('contracts_list');
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
	public function no_permission(){
		$this->page_data['header_data']['meta_title'] .= ' - Forbidden';
		$this->page_data['header_data']['main_title'] = 'Forbidden';
		$this->page_data['header_data']['page_title'] = 'Forbidden';
		$this->page_data['header_data']['breadcrumb'][1] = 'Forbidden';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;

		$this->_backend('no_permission');
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
	public function list_agent_support(){
		check_permission(600,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Agent Support Requests';
		$this->page_data['header_data']['main_title'] = 'Agent Support Requests';
		$this->page_data['header_data']['page_title'] = 'Agent Support Requests';
		$this->page_data['header_data']['breadcrumb'][1] = 'Agent Support Requests';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'supports';
		$this->page_data['header_data']['menuitem'] = 'agentsupport';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-agentsupport')));
		$this->_backend('agent_support');
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
	public function view_agent_support($user_id){
		check_permission(600,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Agent Support Request';
		$this->page_data['header_data']['main_title'] = 'Agent';
		$this->page_data['header_data']['page_title'] = 'Support Request';
		$this->page_data['header_data']['breadcrumb'][1] = 'Support Requests';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-agent-support');
		$this->page_data['header_data']['breadcrumb'][2] = 'Agent';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'supports';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'agent_support',$user_id);
		$this->page_data['agent'] = $this->backend_model->get_agent($user_id);
		$this->page_data['history'] = $this->backend_model->agent_support_history($user_id);
		$this->page_data['licenses']  =	$this->backend_model->get_licenses($user_id);

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-agent'), "avataruploadurl" => base_url('/ajax/backend/upload-avatar'), "agent_id" => $user_id, "sendsupporturl" => base_url('/ajax/backend/send-agent-support/'.$user_id),"deleteprofileimgurl" => base_url('/ajax/backend/delete-profile-image'), "getlicenseformurl" => base_url('ajax/backend/get-licenseform'), "addlicenseurl" => base_url('ajax/backend/add-license'), "editlicenseurl" => base_url('ajax/backend/edit-license'), "deletelicenseurl" => base_url('ajax/backend/delete-license'), "approvelicenseurl" => base_url('ajax/backend/approve-license'), "listlicenseurl" => base_url('ajax/backend/list-licenses')));
		$this->_backend('agent_support_view');
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
	public function list_seller_support(){
		check_permission(580,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Property Owners Support Requests';
		$this->page_data['header_data']['main_title'] = 'Property Owners Support Requests';
		$this->page_data['header_data']['page_title'] = 'Property Owners Support Requests';
		$this->page_data['header_data']['breadcrumb'][1] = 'Property Owners Support Requests';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'supports';
		$this->page_data['header_data']['menuitem'] = 'sellersupport';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-sellersupport')));
		$this->_backend('seller_support');
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
	public function view_seller_support($user_id){
		check_permission(580,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Property Owners Support Request';
		$this->page_data['header_data']['main_title'] = 'Property Owner';
		$this->page_data['header_data']['page_title'] = 'Support Request';
		$this->page_data['header_data']['breadcrumb'][1] = 'Support Requests';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-seller-support');
		$this->page_data['header_data']['breadcrumb'][2] = 'Property Owner';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'supports';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data["waiting_notifications"] = $this->backend_model->clear_notifications($this->account['id'],'seller_support',$user_id);
		$this->page_data['seller'] = $this->backend_model->get_seller($user_id);
		$this->page_data['history'] = $this->backend_model->seller_support_history($user_id);

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-seller'), "avataruploadurl" => base_url('/ajax/backend/upload-avatar'), "seller_id" => $user_id, "sendsupporturl" => base_url('/ajax/backend/send-seller-support/'.$user_id)));
		$this->_backend('seller_support_view');
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
	public function list_state(){
		check_permission(440,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - List of States';
		$this->page_data['header_data']['main_title'] = 'States';
		$this->page_data['header_data']['page_title'] = 'States List';
		$this->page_data['header_data']['breadcrumb'][1] = 'States List';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'location';
		$this->page_data['header_data']['menuitem'] = 'liststates';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-states'), "deleteajaxurl" => base_url('/ajax/backend/delete-state')));
		$this->_backend('state_list');
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
	public function add_state(){
		check_permission(441,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Add new state';
		$this->page_data['header_data']['main_title'] = 'States';
		$this->page_data['header_data']['page_title'] = 'Add New State';
		$this->page_data['header_data']['breadcrumb'][1] = 'States';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-state');
		$this->page_data['header_data']['breadcrumb'][2] = 'Add New State';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'location';
		$this->page_data['header_data']['menuitem'] = 'addstate';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/add-state')));
		$this->_backend('state_add');
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
	public function edit_state($state_id){
		check_permission(442,$this->account['permissions']);
		$this->page_data['header_data']['meta_title'] .= ' - Edit state';
		$this->page_data['header_data']['main_title'] = 'States';
		$this->page_data['header_data']['page_title'] = 'Edit State';
		$this->page_data['header_data']['breadcrumb'][1] = 'States';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-state');
		$this->page_data['header_data']['breadcrumb'][2] = 'Edit State';
		$this->page_data['header_data']['breadcrumb_links'][2] = null;
		$this->page_data['header_data']['menusection'] = 'location';
		$this->page_data['header_data']['menuitem'] = '';

		$this->page_data['state'] = $this->backend_model->get_state_cost($state_id);
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-state')));
		$this->_backend('state_edit');
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
	public function list_city($state_id){
		check_permission(450,$this->account['permissions']);
		if (!$state_id) {redirect('/ct-admin/list-state', 'refresh');}
		$this->page_data['state'] = $state = $this->backend_model->get_state_cost($state_id);
		$this->page_data['header_data']['meta_title'] .= ' - List of Cities';
		$this->page_data['header_data']['main_title'] = $state['state'].' Cities';
		$this->page_data['header_data']['page_title'] = 'City List';
		$this->page_data['header_data']['breadcrumb'][1] = 'States List';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-state');
		$this->page_data['header_data']['breadcrumb'][2] = $state['state'].' Cities';
		$this->page_data['header_data']['breadcrumb_links'][2] = base_url('ct-admin/list-city/'.$state['state_id']);
		$this->page_data['header_data']['menusection'] = 'location';
		$this->page_data['header_data']['menuitem'] = '';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "datatableajaxurl" => base_url('/ajax/backend/get-cities/'.$state_id), "deleteajaxurl" => base_url('/ajax/backend/delete-city')));
		$this->_backend('city_list');
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
	public function add_city($state_id){
		check_permission(451,$this->account['permissions']);
		if (!$state_id) {redirect('/ct-admin/list-state', 'refresh');}
		$this->page_data['state'] = $state = $this->backend_model->get_state_cost($state_id);
		$this->page_data['header_data']['meta_title'] .= ' - Add new city';
		$this->page_data['header_data']['main_title'] = $state['state'].' Cities';
		$this->page_data['header_data']['page_title'] = 'Add New City';
		$this->page_data['header_data']['breadcrumb'][1] = 'States';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-state');
		$this->page_data['header_data']['breadcrumb'][2] = $state['state'].' Cities';
		$this->page_data['header_data']['breadcrumb_links'][2] = base_url('ct-admin/list-city/'.$state['state_id']);
		$this->page_data['header_data']['breadcrumb'][3] = 'Add New City';
		$this->page_data['header_data']['breadcrumb_links'][3] = null;
		$this->page_data['header_data']['menusection'] = 'location';
		$this->page_data['header_data']['menuitem'] = '';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/add-city')));
		$this->_backend('city_add');
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
	public function edit_city($city_id){
		check_permission(452,$this->account['permissions']);
		$this->page_data['city'] = $this->backend_model->get_city($city_id);
		$this->page_data['state'] = $state = $this->backend_model->get_state_cost($this->page_data['city']['state_id']);

		$this->page_data['header_data']['meta_title'] .= ' - Edit city';
		$this->page_data['header_data']['main_title'] = $state['state'].' Cities';
		$this->page_data['header_data']['page_title'] = 'Edit City';
		$this->page_data['header_data']['breadcrumb'][1] = 'States';
		$this->page_data['header_data']['breadcrumb_links'][1] = base_url('ct-admin/list-state');
		$this->page_data['header_data']['breadcrumb'][2] = $state['state'].' Cities';
		$this->page_data['header_data']['breadcrumb_links'][2] = base_url('ct-admin/list-city/'.$state['state_id']);
		$this->page_data['header_data']['breadcrumb'][3] = 'Edit City';
		$this->page_data['header_data']['breadcrumb_links'][3] = null;
		$this->page_data['header_data']['menusection'] = 'location';
		$this->page_data['header_data']['menuitem'] = '';

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "formajaxurl" => base_url('/ajax/backend/edit-city')));
		$this->_backend('city_edit');
	}


	public function memberships()
	{	
		$this->page_data['header_data']['meta_title'] .= ' - Memberships';
		$this->page_data['header_data']['main_title'] = 'Memberships';
		$this->page_data['header_data']['page_title'] = 'Memberships List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Memberships';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'memberships';
		$this->page_data['header_data']['menuitem'] = 'memberships';


		$this->page_data['features'] =  $this->backend_model->get_all_features();

		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "membershiptableajaxurl" => base_url('/ajax/backend/list-memberships'), "membershipaddajaxurl" => base_url('/ajax/backend/add-membership') ,"membershipupdateajaxurl" => base_url('/ajax/backend/update-membership')));
		$this->_backend('memberships');
	}


	public function features()
	{	
		$this->page_data['header_data']['meta_title'] .= ' - Features';
		$this->page_data['header_data']['main_title'] = 'Features';
		$this->page_data['header_data']['page_title'] = 'Features List';
		$this->page_data['header_data']['breadcrumb'][1] = 'Features';
		$this->page_data['header_data']['breadcrumb_links'][1] = null;
		$this->page_data['header_data']['menusection'] = 'features';
		$this->page_data['header_data']['menuitem'] = 'features';

    	$this->page_data['plans'] 					= $this->backend_model->get_plans();
		$this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "featuretableajaxurl" => base_url('/ajax/backend/list-feattures'), "addplanajaxurl" => base_url('/ajax/backend/add-plans') ,"planupdateajaxurl" => base_url('/ajax/backend/update-plan'), 'addoption' =>base_url('/ajax/backend/add-option'), 'getoptions' =>base_url('/ajax/backend/get-options'), 'updateoption' =>base_url('/ajax/backend/update-options') ,'deleteoptions' =>base_url('/ajax/backend/delete-options') ));
		$this->_backend('features');
	}

    public function specializations()
    {

//        echo 'Nadeem';
        $this->page_data['header_data']['meta_title'] .= ' - Specializations';
        $this->page_data['header_data']['main_title'] = 'Specializations';
        $this->page_data['header_data']['page_title'] = 'Specializations List';
        $this->page_data['header_data']['breadcrumb'][1] = 'Specializations';
        $this->page_data['header_data']['breadcrumb_links'][1] = null;
        $this->page_data['header_data']['menusection'] = 'specializations';
        $this->page_data['header_data']['menuitem'] = 'specializations';
//        $this->page_data['footer_data']['js_files'][] = base_url('assets/js/pages/backend/specializations.js');

        $this->_addjson('cortiamajax',array("loadingimage" => base_url('/images/loading.gif'), "specializationtableajaxurl" => base_url('/ajax/backend/list-specializations'), "addspecializationajaxurl" => base_url('/ajax/backend/add-specializations') ,"specializationupdateajaxurl" => base_url('/ajax/backend/update-specializations')));
        $this->_backend('specializations');
    }
}
?>