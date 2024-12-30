<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Agent model
 *
 * The system model with a series of CRUD functions (powered by CI's query builder), validation-in-model support, event callbacks and more for agents.
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
class Agent_model extends CI_Model {

		public function __construct(){
    		$this->load->database();
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_administrators($status = 'Active'){
			$this->db->select('accounts.*, administrators.*');
			$this->db->from('accounts');
			$this->db->join('administrators', 'administrators.admin_id = accounts.id', 'left');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.user_type =', 'Administrator');
			$this->db->order_by('accounts.id ASC');

			$admins = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $admins;
		}

	/**
	 * Get details of selected administrator account
	 *
	 * @param  integer $admin_id ID of system administrator to return
	 * @return array Administrator details
	 */
		public function get_administrator($admin_id){
	    $admin = $this->db->select('accounts.*, administrators.*')->from('accounts')->where("accounts.id =", $admin_id)->where("accounts.user_type =", 'Administrator')->join('administrators', 'administrators.admin_id = accounts.id', 'left')->get()->row_array();
    	return $admin;
		}


	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function add_administrator($data){
			$this->db->insert('administrators', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function edit_administrator($account_id, $data){
			$this->db->update('administrators', $data, "admin_id = '".$account_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}


	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_sellers($status = 'Active'){
			$this->db->select('accounts.*, sellers.*');
			$this->db->from('accounts');
			$this->db->join('sellers', 'sellers.seller_id = accounts.id', 'left');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.user_type =', 'Seller');
			$this->db->order_by('accounts.id ASC');

			$sellers = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $sellers;
		}

	/**
	 * Get details of selected seller account
	 *
	 * @param  integer $seller_id ID of system seller to return
	 * @return array Seller details
	 */
		public function get_seller($seller_id){
	    $seller = $this->db->select('accounts.*, sellers.*')->from('accounts')->where("accounts.id =", $seller_id)->where("accounts.user_type =", 'Seller')->join('sellers', 'sellers.seller_id = accounts.id', 'left')->get()->row_array();
    	return $seller;
		}

	/**
	 * Add new seller account
	 *
	 * @param  array 	 $data Details of seller account
	 * @return boolean true|false
	 */
		public function add_seller($data){
			$this->db->insert('sellers', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new seller account
	 *
	 * @param  array 	 $data Details of seller account
	 * @return boolean true|false
	 */
		public function edit_seller($account_id, $data){
			$this->db->update('sellers', $data, "seller_id = '".$account_id."'");
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_agents($status = 'Active'){
			$this->db->select('accounts.*, agents.*');
			$this->db->from('accounts');
			$this->db->join('agents', 'agents.agent_id = accounts.id', 'left');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.user_type =', 'Agent');
			$this->db->order_by('accounts.id ASC');

			$agents = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $agents;
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
		public function add_agent($data){
			$this->db->insert('agents', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
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
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_property($property_id){
	    $property = $this->db->select('properties.*, properties.winning_fee, state_costs.cost AS win_fee, accounts.email, sellers.first_name, sellers.last_name, sellers.phone')->from('properties')->where("properties.property_id =", $property_id)->join('state_costs', 'state_costs.state = properties.state', 'left')->join('sellers', 'properties.seller_id = sellers.seller_id', 'left')->join('accounts', 'properties.seller_id = accounts.id', 'left')->get()->row_array();
    	return $property;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_property($data){
			$this->db->insert('properties', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function edit_property($account_id, $data){
			$this->db->update('properties', $data, "property_id = '".$account_id."'");
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
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_approval($data){
			$this->db->insert('approvals', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function list_approval_text($filter){
			$this->db->select('approvals.*, CONCAT(administrators.first_name, " ", administrators.first_name) AS admin, administrators.avatar_string AS admin_image');
			$this->db->join('administrators', 'administrators.admin_id = approvals.admin_id', 'left');
			$this->db->from('approvals');
			if ($filter['seller_id']) {
				$this->db->select('CONCAT(sellers.first_name, " ", sellers.first_name) AS seller, sellers.avatar_string AS seller_image');
				$this->db->join('sellers', 'sellers.seller_id = approvals.seller_id', 'left');
				$this->db->where('approvals.seller_id =', $filter['seller_id']);
			}
			if ($filter['property_id']) {
				$this->db->where('approvals.property_id =', $filter['property_id']);
			}
			if ($filter['agent_id']) {
				$this->db->select('CONCAT(agents.first_name, " ", agents.first_name) AS agent, agents.avatar_string AS agent_image');
				$this->db->join('agents', 'agents.agent_id = approvals.agent_id', 'left');
				$this->db->where('approvals.agent_id =', $filter['agent_id']);
			}
			$this->db->order_by('approvals.app_id ASC');

			$sellers = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $sellers;
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
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_invoices($user_id, $status = null){
	    $this->db->select('invoices.*, agents.stripe_id, agents.payment_id, agent_coupons.coupon_code');
	    $this->db->from('invoices');
	    $this->db->where("invoices.agent_id =", $user_id);
	    $this->db->where("invoices.try_time <=", time());
	    if ($status) {
	    	$this->db->where_in("invoices.invoice_status", $status);
	    }else{
	    	$this->db->where_in("invoices.invoice_status", array('Open','Failed'));
	    	$this->db->where("invoices.try_amount <=", 3);
	    }
	    $this->db->join('agents', 'invoices.agent_id = agents.agent_id', 'left');
	    $this->db->join('agent_coupons', 'invoices.coupon_id = agent_coupons.use_id', 'left');
	    $invoices = $this->db->get()->result_array();
   		return $invoices;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_invoice($invoice_id){
	    $this->db->select('invoices.*, agents.stripe_id, agents.payment_id');
	    $this->db->from('invoices');
	    $this->db->where("invoices.invoice_id =", $invoice_id);
	    $this->db->join('agents', 'invoices.agent_id = agents.agent_id', 'left');
	    $invoice = $this->db->get()->row_array();
    	return $invoice;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_credit_cards($agent_id){
	    $this->db->select('*');
	    $this->db->from('credit_cards');
	    $this->db->where("credit_cards.agent_id =", $agent_id);
			$this->db->order_by('credit_cards.card_id DESC');
	    $cards = $this->db->get()->result_array();
   		return $cards;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_credit_card($card_id){
	    $this->db->select('*');
	    $this->db->from('credit_cards');
	    $this->db->where("credit_cards.card_id =", $card_id);
	    $card = $this->db->get()->row_array();
   		return $card;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_credit_card($data){
			$this->db->insert('credit_cards', $data);
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
		public function get_coupons($agent_id){
	    $this->db->select('*');
	    $this->db->from('agent_coupons');
	    $this->db->where("agent_coupons.agent_id =", $agent_id);
			$this->db->order_by('agent_coupons.use_order ASC');
			$this->db->order_by('agent_coupons.added_on DESC');
	    $coupons = $this->db->get()->result_array();
   		return $coupons;
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
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function check_coupon_code($code){
	    $this->db->select('*');
	    $this->db->from('coupons');
	    $this->db->where("coupons.coupon_code =", $code);
	    $coupon = $this->db->get()->row_array();
   		return $coupon;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function check_coupon_used($coupon_id, $agent_id){
	    $this->db->select('*');
	    $this->db->from('agent_coupons');
	    $this->db->where("agent_coupons.coupon_id =", $coupon_id);
	    $this->db->where("agent_coupons.agent_id =", $agent_id);
	    $coupon = $this->db->get()->row_array();
   		return $coupon;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function add_coupon($data){
			$this->db->insert('agent_coupons', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
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
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function process_coupon($agent_id, $coupon_code){
			if ($coupon = $this->check_coupon_code($this->security->xss_clean($coupon_code))) {
				if ($coupon['coupon_status'] != 'Active') {
					$response["fail"] = true;
					$response["fail_title"] = 'Coupon Not Exist!';
					$response["fail_message"] = 'This coupon code does not exist. Please try another coupon code to continue.';
				}elseif ($coupon['begin_date'] > time()) {
					$response["fail"] = true;
					$response["fail_title"] = 'Coupon Not Active!';
					$response["fail_message"] = 'This coupon cannot be used at this moment. Coupon will be activated on '.date('F j, Y', $coupon['begin_date']).'. Please try again after activation date.';
				}elseif($coupon['end_date'] < time()){
					$response["fail"] = true;
					$response["fail_title"] = 'Coupon Expired!';
					$response["fail_message"] = 'This coupon cannot be used, because its expired on '.date('F j, Y', $coupon['end_date']).'. Please try another coupon code to continue.';
				}elseif($used = $this->check_coupon_used($coupon['coupon_id'],$agent_id)){
					$response["fail"] = true;
					$response["fail_title"] = 'Coupon Already Used!';
					$response["fail_message"] = 'This coupon already used by you on '.date('F j, Y', $used['added_on']).'. Please try another coupon code to continue.';
				}else{
					$coupon_data = array(
						'agent_id' => $agent_id,
						'coupon_id' => $coupon['coupon_id'],
						'coupon_code' => $coupon['coupon_code'],
						'coupon_desc' => $coupon['coupon_desc'],
						'coupon_type' => $coupon['coupon_type'],
						'coupon_amount' => $coupon['coupon_amount'],
						'begin_date' => $coupon['begin_date'],
						'end_date' => $coupon['end_date'],
						'end_date' => $coupon['end_date'],
						'added_on' => time()
					);
					if ($use_id = $this->add_coupon($coupon_data)) {
						if ($coupon['coupon_type'] == 'Win Limit') {
							$this->set_extra_winexp($agent_id, number_format($coupon['coupon_amount']), 'win');
							$use_data = array(
								'used_on' => time(),
								'coupon_used' => 'Yes'
							);
							$this->edit_coupon($use_id, $use_data);
							$response["use_id"] = $use_id;
							$response["success"] = true;
							$response["success_title"] = 'Coupon Added & Used';
							$response["success_message"] = $coupon['coupon_code'].' coupon added to your collection successfully. Because this coupon gives extra '.number_format($coupon['coupon_amount']).' points to your win limit, its automatically used and added to your account.';
						}elseif ($coupon['coupon_type'] == 'Interest Limit') {
							$this->set_extra_winexp($agent_id, number_format($coupon['coupon_amount']), 'off');
							$use_data = array(
								'used_on' => time(),
								'coupon_used' => 'Yes'
							);
							$this->edit_coupon($use_id, $use_data);
							$response["success"] = true;
							$response["success_title"] = 'Coupon Added & Used';
							$response["success_message"] = $coupon['coupon_code'].' coupon added to your collection successfully. Because this coupon gives extra '.number_format($coupon['coupon_amount']).' points to your interest limit, its automatically used and added to your account.';
						}else{
							$response["success"] = true;
							$response["success_title"] = 'Coupon Added';
							$response["success_message"] = $coupon['coupon_code'].' coupon added to your collection successfully. Please do not forget to use your coupon before it expires on '.date('F j, Y', $coupon['end_date']);
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
			return $response;
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
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_properties($filter = null){
			$this->db->select('properties.*, state_costs.cost AS win_fee');
			$this->db->from('properties');

			if (!$filter['status']) {
				$this->db->where('properties.status =', 'Active');
			}else{
				$this->db->where_in('properties.status =', $filter['status']);
			}
			if ($filter['city']) {
				$this->db->where('properties.city =', $filter['city']);
			}
			if ($filter['type']) {
				if ($filter['type'] != 'Both') {
					$this->db->where('properties.type =', $filter['type']);
				}
			}
			if ($filter['list']) {
				$this->db->where_in('properties.property_id', $filter['list']);
			}

			if ($filter['state']) {
				if ($filter['state']['Commercial']) {
					foreach ($filter['state']['Commercial'] as $state) {
						$state_keyword[] = "(properties.state = '".$state."' AND properties.type = 'Commercial')";
					}
				}
				if ($filter['state']['Residential']) {
					foreach ($filter['state']['Residential'] as $state) {
						$state_keyword[] = "(properties.state = '".$state."' AND properties.type = 'Residential')";
					}
				}
				$this->db->where("(".implode(" OR ",$state_keyword).")");
			}

			$this->db->order_by('properties.approval_date DESC');
			if ($filter['limit']) {
				$this->db->limit($filter['limit']);
			}
			$this->db->join('state_costs', 'state_costs.state = properties.state', 'left');
			$properties = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $properties;
//	    $property = $this->db->select('properties.*, state_costs.cost AS win_fee, accounts.email, sellers.first_name, sellers.last_name')->from('properties')->where("properties.property_id =", $property_id)->join('state_costs', 'state_costs.state = properties.state', 'left')->join('sellers', 'properties.seller_id = sellers.seller_id', 'left')->join('accounts', 'properties.seller_id = accounts.id', 'left')->get()->row_array();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_save_value($agent_id, $property_id){
	    $save = $this->db->from('saved_properties')->where('agent_id', $agent_id)->where('property_id', $property_id)->get()->row_array();
    	return $save;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_saved_properties($agent_id, $array = false){
	    $saves = $this->db->from('saved_properties')->where('agent_id', $agent_id)->get()->result_array();
	    if ($array) {
	    	if ($saves) {
		    	foreach ($saves as $save) {
		    		$save_array[] = $save['property_id'];
		    	}
	    	}else{
    			return array();
	    	}
    		return $save_array;
	    }else{
    		return $saves;
	    }
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function save_property($agent_id, $property_id){
			$data['agent_id'] = $agent_id;
			$data['property_id'] = $property_id;
			$data['save_time'] = time();
			$this->db->insert('saved_properties', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function unsave_property($agent_id, $property_id){
			if ($agent_id && $property_id) {
				$this->db->delete('saved_properties', array('agent_id' => $agent_id, 'property_id' => $property_id));
			}
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function drop_count($agent_id, $field_name, $calculation){
			$this->db->set($field_name, $field_name.$calculation, FALSE);
			$this->db->where('agents.agent_id =', $agent_id);
			$this->db->update('agents');
     	return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_proposal_value($agent_id, $property_id){
	    $save = $this->db->select('proposals.*, properties.state, properties.city')->from('proposals')->join('properties', 'proposals.property_id = properties.property_id', 'left')->where('proposals.agent_id', $agent_id)->where('proposals.property_id', $property_id)->where_in('proposals.status', array('Unread','Read','Accepted'))->get()->row_array();
    	return $save;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_express_properties($agent_id, $array = false)
		{
			$saves = $this->db->select('proposals.property_id')->from('proposals')->where('proposals.agent_id', $agent_id)->where_in('proposals.status', array('Read','Unread'))->get()->result_array();
			if ($array) {
				foreach ($saves as $save) {
					$save_array[] = $save['property_id'];
				}
				return $save_array;
			}else{
				return $saves;
			}
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
		public function get_new_messages($agent_id){
			$messages = $this->db->query('SELECT `messages`.message_date AS message_date, `messages`.message_text AS message_text, `messages`.seller_id AS seller_id, "message" AS msg_type, `sellers`.`first_name`, `sellers`.`last_name` FROM `messages` LEFT JOIN `sellers` ON `messages`.`seller_id` = `sellers`.`seller_id` WHERE `messages`.`msg_to` = "Agent" AND `messages`.`agent_id` = "'.$agent_id.'" AND `messages`.`status` = "Unread" UNION SELECT `tickets`.message_date AS message_date,`tickets`.message_text AS message_text,`tickets`.seller_id AS seller_id, "support" AS msg_type, `administrators`.`first_name`, `administrators`.`last_name` FROM `tickets` LEFT JOIN `administrators` ON `tickets`.`admin_id` = `administrators`.`admin_id` WHERE `tickets`.`msg_from` = "Admin" AND `tickets`.`agent_id` = "'.$agent_id.'" AND `tickets`.`status` = "Unread" ORDER BY `message_date` DESC')->result_array();
	    return $messages;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_new_offer_news($agent_id){
			$this->db->select('proposals.*, sellers.first_name, sellers.last_name');
			$this->db->from('proposals');
			$this->db->join('sellers', 'proposals.seller_id = sellers.seller_id', 'left');
			$this->db->where('proposals.prop_to =', 'Agent');
			$this->db->where('proposals.agent_id =', $agent_id);
			$this->db->where('proposals.status =', 'Unread');
			$this->db->where('proposals.commission_rate IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
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
		public function get_new_notifications($agent_id){
			$this->db->from('notifications');
			$this->db->where('notifications.user_id =', $agent_id);
			$this->db->where('notifications.status =', 'Unread');
			$this->db->order_by('notifications.added_on DESC');

			$messages = $this->db->get()->result_array();
	    return $messages;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_proposals($agent_id, $filter = null)
		{
			$this->db->select('proposals.*, properties.winning_fee, state_costs.cost AS win_fee, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('proposals');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->join('state_costs', 'state_costs.state = properties.state', 'left');
			$this->db->where('proposals.agent_id =', $agent_id);
			$this->db->where('proposals.commission_rate IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
			if ($filter['status'])
			{
				$this->db->where_in('proposals.status', $filter['status']);
			}
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
		public function get_proposed_properties($agent_id, $array = false){
	    $saves = $this->db->select('proposals.property_id')->from('agreements')->join('proposals', 'proposals.prop_id = agreements.prop_id', 'left')->where('agreements.agent_id', $agent_id)->where('agreements.agr_status', 'Open')->get()->result_array();
	    if ($array) {
	    	foreach ($saves as $save) {
	    		$save_array[] = $save['property_id'];
	    	}
    		return $save_array;
	    }else{
    		return $saves;
	    }
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_win_properties($agent_id, $array = false){
	    $saves = $this->db->select('proposals.property_id')->from('agreements')->join('proposals', 'proposals.prop_id = agreements.prop_id', 'left')->where('agreements.agent_id', $agent_id)->where('agreements.agr_status', 'Completed')->get()->result_array();
	    if ($array) {
	    	foreach ($saves as $save) {
	    		$save_array[] = $save['property_id'];
	    	}
    		return $save_array;
	    }else{
    		return $saves;
	    }
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_proposal($agent_id, $proposal_id){
			$this->db->select('proposals.*, properties.winning_fee, state_costs.cost AS win_fee, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('proposals');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->join('state_costs', 'state_costs.state = properties.state', 'left');
			$this->db->where('proposals.agent_id =', $agent_id);
			$this->db->where('proposals.prop_id =', $proposal_id);
			$this->db->where('proposals.commission_rate IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
			$this->db->where_in('properties.status', array('Active','Contracted','Inactivated'));

			$messages = $this->db->get()->row_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function check_newer_proposal($agent_id, $proposal_id){
			$this->db->select('proposals.*, properties.city, properties.state');
			$this->db->from('proposals');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('proposals.main_id =', $proposal_id);
			$this->db->where('proposals.agent_id =', $agent_id);
			$this->db->where('proposals.commission_rate IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);

			$messages = $this->db->get()->row_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_related_proposal($proposal_id){
			$this->db->select('*');
			$this->db->from('proposals');
			$this->db->group_start();
			$this->db->where('base_id =', $proposal_id);
			$this->db->or_where('main_id =', $proposal_id);
			$this->db->or_where('prop_id =', $proposal_id);
			$this->db->group_end();
			$this->db->where('commission_rate IS NOT NULL', NULL);
			$this->db->where('contract_length IS NOT NULL', NULL);
			$this->db->where('status', 'Countered');

			$messages = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_proposal($data){
			$this->drop_count($data['agent_id'], 'offer_remain', '-1');

			$this->db->insert('proposals', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function mark_proposal_read($agent_id, $proposal_id){
			$this->db->set('status','Read');
			$this->db->set('seen_date', time());
			$this->db->where('proposals.prop_to =', 'Agent');
			$this->db->where('proposals.agent_id =', $agent_id);
			$this->db->where('proposals.status =', 'Unread');
			$this->db->where('proposals.prop_id =', $proposal_id);
			$this->db->update('proposals');
      return ($this->db->affected_rows() >= 0 ) ? true : false;
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
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_clear_favorites($property_id){
			$this->db->delete('saved_properties', array('property_id' => $property_id));
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_clear_proposals($property_id){
			$this->db->select('proposals.*, agents.first_name, agents.last_name, agents.notifications, accounts.email, properties.city, properties.state');
			$this->db->from('proposals');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->join('accounts', 'proposals.agent_id = accounts.id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('proposals.property_id =', $property_id);
			$this->db->where('proposals.commission_rate IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
			$this->db->where_in('proposals.status', array('Unread','Read'));
			$this->db->order_by('proposals.property_id DESC');
			$this->db->order_by('proposals.prop_date DESC');
			$proposals = $this->db->get()->result_array();
	    return $proposals;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_counter_offer_value($agent_id, $property_id){
	    $offer = $this->db->from('proposals')->where('agent_id', $agent_id)->where('proposals.prop_from =', 'Agent')->where('property_id', $property_id)->where('commission_rate IS NOT NULL', NULL)->where('contract_length IS NOT NULL', NULL)->where_in('status', array('Read','Unread'))->get()->row_array();
    	return $offer;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_message($data){
			$this->db->insert('messages', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function mark_messages_read($agent_id,$seller_id){
			$this->db->set('status','Read');
			$this->db->set('seen_date', time());
			$this->db->where('messages.seller_id',$seller_id);
			$this->db->where('messages.agent_id',$agent_id);
			$this->db->where('messages.msg_from', 'Seller');
			$this->db->update('messages');
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_message_list($agent_id){
			$this->db->select('MAX(`message_id`) AS `latestmsg`');
			$this->db->from('messages');
			$this->db->where('messages.agent_id =', $agent_id);
			$this->db->where('messages.msg_from =', 'Seller');
			$this->db->where_in('messages.status', array('Read','Unread'));
			$this->db->group_by("messages.seller_id");
			$max_values = $this->db->get_compiled_select();
			$this->db->reset_query();

			$this->db->select('messages.*, sellers.first_name, sellers.last_name');
			$this->db->from('messages');
			$this->db->join('sellers', 'messages.seller_id = sellers.seller_id', 'left');
			$this->db->where("messages.message_id IN ($max_values)", NULL, FALSE);
			$this->db->group_by("messages.seller_id");
			$this->db->order_by('messages.message_date DESC');

			$messages = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_messages_of($agent_id,$seller_id){
			$this->db->select('messages.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS seller, sellers.avatar_string AS seller_image, agents.avatar_string AS agent_image');
			$this->db->from('messages');
			$this->db->join('sellers', 'messages.seller_id = sellers.seller_id', 'left');
			$this->db->join('agents', 'messages.agent_id = agents.agent_id', 'left');
			$this->db->where('messages.seller_id =', $seller_id);
			$this->db->where('messages.agent_id =', $agent_id);
			$this->db->where_in('messages.status', array('Read','Unread'));
			$this->db->order_by('messages.message_date DESC');

			$messages = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
		}

	/**
	 * Get details of selected administrator account
	 *
	 * @param  integer $admin_id ID of system administrator to return
	 * @return array Administrator details
	 */
		public function get_state_cost($property_id){
			$property = $this->get_property($property_id);
	    $state_cost = $this->db->from('state_costs')->where("state =", $property['state'])->get()->row_array();
    	return $state_cost;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_aggrements($agent_id, $filter = null){
			$this->db->select('agreements.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS seller, properties.property_id, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state, proposals.commission_rate, proposals.contract_length');
			$this->db->from('agreements');
			$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->join('sellers', 'agreements.seller_id = sellers.seller_id', 'left');
			$this->db->where('agreements.agent_id =', $agent_id);
			if ($filter['status']) {
				$this->db->where_in('agreements.agr_status', $filter['status']);
			}
			$this->db->order_by('agreements.agr_id DESC');

			$aggrements = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $aggrements;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_aggrement($agent_id, $agree_id){
			$this->db->select('agreements.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS seller, properties.property_id, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('agreements');
			$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->join('sellers', 'agreements.seller_id = sellers.seller_id', 'left');
			$this->db->where('agreements.agent_id =', $agent_id);
			$this->db->where('agreements.agr_id =', $agree_id);
			$this->db->order_by('agreements.agr_id DESC');

			$aggrement = $this->db->get()->row_array();
//  		echo $this->db->last_query();exit();
	    return $aggrement;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function check_for_agreement($property_id){
			$this->db->select('agreements.*, CONCAT(sellers.first_name, " ", sellers.last_name) AS seller, properties.property_id, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('agreements');
			$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->join('sellers', 'agreements.seller_id = sellers.seller_id', 'left');
			$this->db->where('(agreements.agr_status !=', 'Canceled');
			$this->db->or_where("agreements.agr_status != 'Expired')");
			$this->db->where('properties.property_id =', $property_id);
			$this->db->order_by('agreements.agr_id DESC');

			$aggrement = $this->db->get()->row_array();
//  		echo $this->db->last_query();exit();
	    return $aggrement;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function add_agreement($data){
			$this->drop_count($data['agent_id'], 'win_remain', '-1');


			$this->db->insert('agreements', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
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
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function list_properties($license_states, $filter = null){
			$this->db->select('properties.*, saved_properties.save_time');
			$this->db->from('properties');
			$this->db->join('saved_properties', 'saved_properties.property_id = properties.property_id AND (saved_properties.agent_id = '.$filter['agent_id'].')', 'left');

			$this->db->where('properties.status =', 'Active');
			if ($license_states != 'No License') {
				$this->db->where_in('properties.state', $license_states);
			}
			if ($filter['state']) {
				$this->db->where('properties.state =', $filter['state']);
			}
			if ($filter['city']) {
				$this->db->where('properties.city =', $filter['city']);
			}
			if ($filter['lat'] && $filter['long']) {
				$this->db->select('( ACOS( COS( RADIANS( '.$filter['lat'].' ) ) * COS( RADIANS( properties.latitude ) ) * COS( RADIANS( properties.longitude ) - RADIANS( '.$filter['long'].' ) ) + SIN( RADIANS( '.$filter['lat'].' ) ) * SIN( RADIANS( properties.latitude ) )) * 6371) AS distance');
				$this->db->having('distance <', 20);
			}
			if ($filter['type']) {
				if ($filter['type'] != 'Both') {
					$this->db->where('properties.type =', $filter['type']);
				}
			}
			if ($filter['rate']) {
				$this->db->where('properties.commission_rate <=', $filter['rate']);
			}
			if ($filter['length']) {
				$this->db->where('properties.contract_length <=', $filter['length']);
			}

			$this->db->order_by("FIELD(properties.status,'Active','Inactivated','Contracted','Deleted'), properties.approval_date DESC");
			$properties = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $properties;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_tutorial(){
	    $record = $this->db->from('tutorial_pages')->where("page_id =", 'agent')->get()->row_array();
    	return $record;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function collect_trash($seller_id){
			$this->db->set('properties.status','Deleted');
			$this->db->where('properties.seller_id =', $seller_id);
			$this->db->where('properties.status !=', 'Contracted');
			$this->db->update('properties');
			$this->db->reset_query();

			$this->db->set('proposals.status','Declined');
			$this->db->where('proposals.seller_id =', $seller_id);
			$this->db->where('proposals.status !=', 'Accepted');
			$this->db->update('proposals');
			$this->db->reset_query();

			$this->db->set('messages.status','Deleted');
			$this->db->where('messages.seller_id =', $seller_id);
			$this->db->where('messages.status !=', 'Read');
			$this->db->update('messages');
    	return $record;
		}


	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_support_messages($agent_id){
			$this->db->set('tickets.status','Read');
			$this->db->set('tickets.seen_date',time());
			$this->db->where('tickets.agent_id =', $agent_id);
			$this->db->where('tickets.status =', 'Unread');
			$this->db->where('tickets.msg_from =', 'Admin');
			$this->db->update('tickets');
			$this->db->reset_query();

			$this->db->select('tickets.*, CONCAT(administrators.first_name, " ", administrators.last_name) AS admin, administrators.avatar_string AS admin_image, agents.avatar_string AS agent_image');
			$this->db->from('tickets');
			$this->db->join('administrators', 'tickets.admin_id = administrators.admin_id', 'left');
			$this->db->join('agents', 'tickets.agent_id = agents.agent_id', 'left');
			$this->db->where('tickets.agent_id =', $agent_id);
			$this->db->where_in('tickets.status', array('Read','Unread'));
			$this->db->order_by('tickets.message_date DESC');

			$messages = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $messages;
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

		public function get_settings($setting_name){
	    $setting = $this->db->from('settings')->where("setting_name =", $setting_name)->get()->row_array();
	    return $setting;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_notifications($user_id){
			$this->db->from('notifications');
			$this->db->where('notifications.user_id =', $user_id);
			$this->db->where_in('notifications.status', array('Read','Unread'));
			$this->db->order_by('notifications.added_on DESC');
			$messages = $this->db->get()->result_array();
			$this->db->reset_query();

			$this->db->set('notifications.status','Read');
			$this->db->where('notifications.user_id =', $user_id);
			$this->db->where('notifications.status =', 'Unread');
			$this->db->update('notifications');
	    return $messages;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function set_notification_type_read($user_id,$notification_type){
			$this->db->set('notifications.status','Read');
			$this->db->where('notifications.user_id =', $user_id);
			$this->db->where('notifications.action =', $notification_type);
			$this->db->where('notifications.status =', 'Unread');
			$this->db->update('notifications');
	    return $messages;
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
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_licenses($agent_id, $status = null){
			$this->db->from('licenses');
			if ($status) {
				$this->db->where('licenses.license_status =', $status);
			}else{
				$this->db->where('licenses.license_status !=', 'Removed');
			}
			$this->db->where("agent_id =", $agent_id);
			$this->db->order_by('licenses.license_id DESC');

			$records = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $records;
		}

	/**
	 * Get details of selected administrator account
	 *
	 * @param  integer $admin_id ID of system administrator to return
	 * @return array Administrator details
	 */
		public function get_license($agent_id, $license_id){
	    $record = $this->db->from('licenses')->where("agent_id =", $agent_id)->where("license_id =", $license_id)->get()->row_array();
    	return $record;
		}


	/**
	 * Add new admin account
	 *
	 * @param  array 	 $data Details of admin account
	 * @return boolean true|false
	 */
		public function add_license($data){
			$this->db->insert('licenses', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
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
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_my_licenses($agent_id){
			$this->db->from('licenses');
			$this->db->where('licenses.license_status !=', 'Removed');
			$this->db->where("agent_id =", $agent_id);
			$this->db->order_by('licenses.license_id DESC');

			$records = $this->db->get()->result_array();
			if ($records) {
				$return['no_active_license'] = true;
				foreach ($records as $record) {
					if ($record['license_status'] == 'Active') {
						$return['no_active_license'] = false;
						if ($record['license_expire'] > time()) {
							if ($record['interested'] == 'Both') {
								$return['license_states'][$record['license_state']] = true;
								$return['active_states']['Residential'][] = $record['license_state'];
								$return['active_states']['Commercial'][] = $record['license_state'];
								$return['interested'][$record['license_state']]['Residential'] = true;
								$return['interested'][$record['license_state']]['Commercial'] = true;
							}else{
								$return['license_states'][$record['license_state']] = true;
								$return['active_states'][$record['interested']][] = $record['license_state'];
								$return['interested'][$record['license_state']][$record['interested']] = true;
							}
						}else{
							$return['expired_license'] = true;
							$return['expired_states'][] = $record['license_state'];
						}
					}elseif ($record['license_status'] == 'Pending'){
						$return['no_active_license'] = false;
						$return['pending_license'] = true;
						$return['pending_states'][] = $record['license_state'];

					}elseif ($record['license_status'] == 'Declined'){
						$return['no_active_license'] = false;
						$return['declined_license'] = true;
						$return['declined_states'][] = $record['license_state'];
					}else{
						$return['expired_license'] = true;
						$return['expired_states'][] = $record['license_state'];
					}
				}
			}else{
				$return['no_license'] = true;
			}
			if ($return['expired_states']) {
				$expired_states = array_merge(array_flip(array_flip($return['expired_states'])));
				$return['expired_states'] = $expired_states;
			}
	    return $return;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_terms_of_service(){
	    $record = $this->db->from('tos_pages')->where("user_type =", 'Agent')->get()->row_array();
    	return $record['page_content'];
		}


		public function get_plan($anget_Id)
		{		
			$record = $this->db->select('plan_id')->from('agents')->where("agent_id =", $anget_Id)->get()->row_array();
     		return $record;
		}

		public function membership_plans()
		{
			$record = $this->db->from('member_ship_plans')->get()->result_array();			
			return $record;
		}

		public function getAllFeatures($id)
		{
			$record = $this->db->from('plan_features')->where("plan_id =", $id)->get()->result_array();			
			return $record;
		}


	public function set_member_plan($plan_id, $user_id)
	{
		$this->db->set('plan_id', $plan_id);
		$this->db->where('agent_id ', $user_id);
		$this->db->update('agents');
		return ($this->db->affected_rows() >= 0 ) ? true : false;
	}

    public function get_specializations()
    {
        $record = $this->db->from('specializations')->get()->result_array();
        return $record;
    }
    public function get_specializations_for_agent($agent_id)
    {
        $record = $this->db->from('agent_specializations')->where('agent_id =', $agent_id)->get()->result_array();
        return $record;
    }
    public function delete_specializations_for_agent($agent_id){
        $this->db->delete('agent_specializations', array('agent_id' => $agent_id));
    }
    public function add_specializations_for_agent($agent_id, $specializations){
            foreach ($specializations as $special){
                $this->db->insert('agent_specializations', ['agent_id' => $agent_id,'specialization_id' =>  $special]);
            }
    }
    public function get_agent_specializations($agent_id){
        $this->db->select('specializations.*');
        $this->db->from('specializations');
        $this->db->join('agent_specializations', 'agent_specializations.specialization_id = specializations.id');
        $this->db->where('agent_specializations.agent_id =', $agent_id);
        $records = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
        return $records;
    }
}