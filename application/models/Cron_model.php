<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Cron model
 *
 * The system model with a series of CRUD functions (powered by CI's query builder), validation-in-model support, event callbacks and more for crons.
 *
 * @package    Cortiam Web Application
 * @subpackage Models
 * @category   Models
 * @copyright  Copyright (c) 2021, The Webb Enterprises Inc.
 * @author     The Webb Enterprises Dev Team
 * @link       http://www.thewebbenterprises.com
 * @since      Version 1.0
 *
 */
class Cron_model extends CI_Model {

		public function __construct(){
    		$this->load->database();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function check_expired_agreements(){
			$this->db->select('agreements.*, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state, tb1.email AS seller_email, tb2.email AS agent_email');
			$this->db->from('agreements');
			$this->db->join('accounts AS tb1', 'agreements.seller_id = tb1.id', 'left');
			$this->db->join('accounts AS tb2', 'agreements.agent_id = tb2.id', 'left');
			$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('agreements.expire_time <', time());
			$this->db->where('agreements.agr_status =', 'Open');

			$agreements = $this->db->get()->result_array();
		  return $agreements;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function check_expired_invoices(){
			$this->db->select('invoices.*, agents.stripe_id, agents.payment_id');
			$this->db->from('invoices');
			$this->db->join('accounts', 'invoices.agent_id = accounts.id', 'left');
	    $this->db->join('agents', 'invoices.agent_id = agents.agent_id', 'left');
			$this->db->where('invoices.try_time <', time());
			$this->db->where('invoices.try_amount <=', 3);
			$this->db->where('invoices.payment_type =', 'Membership');
			$this->db->where('accounts.active =', 1);
			$this->db->where_in('invoices.invoice_status', array('Open','Failed'));

			$invoices = $this->db->get()->result_array();
	    return $invoices;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function check_expired_licences($search_array){
			$this->db->select('accounts.email, agents.*, licenses.*');
			$this->db->from('accounts');
			$this->db->join('agents', 'agents.agent_id = accounts.id', 'left');
			$this->db->join('licenses', "licenses.agent_id = accounts.id AND (license_status = 'Active')", 'left');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.user_type =', 'Agent');
			if ($search_array['timeline']) {
				$this->db->where('licenses.license_expire_email !=', $search_array['timeline']);
			}
			if ($search_array['approval']) {
				$this->db->where_in('accounts.approval', $search_array['approval']);
			}
			if ($search_array['start_day'] && $search_array['end_day']) {
				$this->db->where("licenses.license_expire BETWEEN ".$search_array['start_day']." AND ".$search_array['end_day']);
			}elseif ($search_array['end_day']) {
				$this->db->where("licenses.license_expire < ".$search_array['end_day']);
			}
			$this->db->order_by('accounts.id ASC');
			$licences = $this->db->get()->result_array();
	    return $licences;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function check_uninterested_properties(){
			$difference = strtotime('-10 days');
			$this->db->select('properties.property_id, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state, COUNT(proposals.prop_id) AS interest, CONCAT(sellers.first_name, " ", sellers.last_name) AS seller, accounts.email AS seller_email');
			$this->db->from('properties');
			$this->db->join('sellers', 'properties.seller_id = sellers.seller_id', 'left');
			$this->db->join('accounts', 'properties.seller_id = accounts.id', 'left');
			$this->db->join('proposals', 'properties.property_id = proposals.property_id', 'left');
			$this->db->where('properties.approval_date <=', $difference);
			$this->db->where('properties.no_interest_email =', 'No');
			$this->db->where('properties.status =', 'Active');
			$this->db->group_by("properties.property_id");
			$this->db->having('interest <', 1);

			$properties = $this->db->get()->result_array();
	    return $properties;
		}
	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_active_agents($filter = null){
			$this->db->select("accounts.*, agents.*, GROUP_CONCAT(licenses.license_state separator '|') AS license_states");
			$this->db->from('accounts');
			$this->db->join('agents', 'agents.agent_id = accounts.id', 'left');
			$this->db->join('licenses', "licenses.agent_id = accounts.id AND (license_status = 'Active')", 'left');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.user_type =', 'Agent');
			$this->db->where('agents.membership_due >', time());
			$this->db->group_by('accounts.id');
			$this->db->order_by('accounts.id ASC');

			$agents = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $agents;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function check_new_properties($filter = null){
			$difference = strtotime('-1 days');
			$this->db->select('properties.*');
			$this->db->from('properties');


			$this->db->where('properties.status =', 'Active');
			$this->db->where('properties.approval_date >', $difference);
			$this->db->where_in('properties.state', $filter['state']);

			if ($filter['city']) {
				$this->db->where('properties.city =', $filter['city']);
			}
			$this->db->order_by('properties.approval_date ASC');
			$properties = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $properties;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_expired_credit_cards($filter = null){
			$difference = strtotime('-1 days');
			$this->db->select('credit_cards.*, agents.first_name, agents.last_name, agents.notifications, accounts.email');
			$this->db->from('credit_cards');
			$this->db->join('agents', 'credit_cards.agent_id = agents.agent_id', 'left');
			$this->db->join('accounts', 'credit_cards.agent_id = accounts.id', 'left');

			if ($filter['start'] && $filter['end']) {
				$start_day = strtotime('+'.$filter['start'].' days');
				$end_day = strtotime('+'.$filter['end'].' days');
			}else{
				$start_day = time();
				$end_day = strtotime('+1 days');
			}
			$this->db->where("credit_cards.expire_date BETWEEN ".$start_day." AND ".$end_day);

			$this->db->where('accounts.active =', 1);
			$cards = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $cards;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_first_coupon($agent_id){
	    $this->db->select('*');
	    $this->db->from('agent_coupons');
	    $this->db->where("agent_coupons.agent_id =", $agent_id);
	    $this->db->where("agent_coupons.coupon_used =", 'No');
			$this->db->order_by('agent_coupons.use_order ASC');
			$this->db->order_by('agent_coupons.added_on DESC');
			$this->db->limit(1);
	    $coupon = $this->db->get()->row_array();
   		return $coupon;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function edit_coupon($use_id, $data){
			$this->db->update('agent_coupons', $data, "use_id = '".$use_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_agent($agent_id){
	    $agent = $this->db->select('accounts.*, agents.*')->from('accounts')->where("accounts.id =", $agent_id)->where("accounts.user_type =", 'Agent')->join('agents', 'agents.agent_id = accounts.id', 'left')->get()->row_array();
    	return $agent;
		}

	/**
	 * Add new agent account
	 *
	 * @param  array 	 $data Details of agent account
	 * @return boolean true|false
	 */
		public function edit_agent($account_id, $data){
			$this->db->update('agents', $data, "agent_id = '".$account_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Add new agent account
	 *
	 * @param  array 	 $data Details of agent account
	 * @return boolean true|false
	 */
		public function get_settings($setting_name){
	    $setting = $this->db->from('settings')->where("setting_name =", $setting_name)->get()->row_array();
	    return $setting;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_invoice($data){
			$this->db->insert('invoices', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function edit_invoice($invoice_id, $data){
			$this->db->update('invoices', $data, "invoice_id = '".$invoice_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_payment($data){
			$this->db->insert('payments', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_approval($data){
			$this->db->insert('approvals', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_support($data){
			$this->db->insert('tickets', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function delete_credit_card($id){
			if ($id) {
				$this->db->delete('credit_cards', array('card_id' => $id));
			}
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function edit_agreement($agreement_id, $data){
			$this->db->update('agreements', $data, "agr_id = '".$agreement_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function get_notified($notification_id = null){
			$this->db->select('accounts.id, accounts.email');
			$this->db->from('administrators');
			$this->db->join('accounts', 'administrators.admin_id = accounts.id', 'left');
			$this->db->like('administrators.notifications', 'i:'.$notification_id.';s:3:"Yes";', 'both');
			if ($emails = $this->db->get()->result_array()) {
				$email_array = array_column($emails,"email","id");
				return $email_array;
			}else{
				return false;
			}

		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_notification($user_ids, $title, $message, $action = null, $action_id = null){
			if (is_array($user_ids)) {
				foreach ($user_ids as $user_id => $email) {
					$data = array(
					'user_id' => $user_id,
					'message' => $message,
					'title' => $title,
					'action' => $action,
					'action_id' => $action_id,
					'added_on' => time()
					);
					$this->db->insert('notifications', $data);
				}
			}else{
				$data = array(
				'user_id' => $user_ids,
				'message' => $message,
				'title' => $title,
				'action' => $action,
				'action_id' => $action_id,
				'added_on' => time()
				);
				$this->db->insert('notifications', $data);
			}
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_log($data){
			$this->db->insert('cronlog', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}


	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function edit_property($property_id, $data){
			$this->db->update('properties', $data, "property_id = '".$property_id."'");
     return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_offers_used($agent_id){
	    $proposals = $this->db->select('COUNT(prop_id) AS amount')->from('proposals')->where('proposals.agent_id', $agent_id)->where_in('proposals.status', array('Read','Unread'))->group_by('proposals.agent_id')->get()->row_array();
			return $proposals['amount'];
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_agent_proposals($agent_id){
			$this->db->select('proposals.*, CONCAT(agents.first_name, " ", agents.last_name) AS agent, CONCAT(sellers.first_name, " ", sellers.last_name) AS seller, accounts.email AS seller_email, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('proposals');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->join('sellers', 'proposals.seller_id = sellers.seller_id', 'left');
			$this->db->join('accounts', 'proposals.seller_id = accounts.id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('proposals.agent_id =', $agent_id);
			$this->db->where('proposals.commission_rate IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
			$this->db->where_in('proposals.status', array('Read','Unread'));
			$this->db->where_in('properties.status', array('Active','Contracted','Inactivated'));
			$this->db->order_by('proposals.property_id DESC');
			$this->db->order_by('proposals.prop_date DESC');

			$messages = $this->db->get()->result_array();
	    return $messages;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function edit_proposal($proposal_id, $data){
			$this->db->update('proposals', $data, "prop_id = '".$proposal_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}


	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function set_extra_winexp($agent_id, $amount , $type='win'){
			if ($type == 'win') {
				$this->db->set('win_remain', 'win_remain+'.number_format($amount), FALSE);
			}elseif ($type == 'off') {
				$this->db->set('offer_remain', 'offer_remain+'.number_format($amount), FALSE);
			}else{
				$this->db->set('offer_remain', 'offer_remain+'.number_format($amount), FALSE);
			}
			$this->db->where('agents.agent_id =', $agent_id);
			$this->db->update('agents');
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function edit_license($license_id, $data){
			$this->db->update('licenses', $data, "license_id = '".$license_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function check_active_license($agent_id){
			$this->db->select('*');
			$this->db->from('licenses');
			$this->db->where('licenses.license_status =', 'Active');
			$this->db->where('licenses.agent_id =', $agent_id);
			if ($licenses = $this->db->get()->result_array()) {
				return false;
			}else{
				return true;
			}
		}
}