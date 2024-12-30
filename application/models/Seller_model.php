<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Seller model
 *
 * The system model with a series of CRUD functions (powered by CI's query builder), validation-in-model support, event callbacks and more for sellers.
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
class Seller_model extends CI_Model {

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
		public function list_agents($filter = null){
			$this->db->select('accounts.*, agents.*, favorite_agents.save_time AS favorited');
			$this->db->from('accounts');
			$this->db->join('agents', 'agents.agent_id = accounts.id', 'left');
			$this->db->join('favorite_agents', 'favorite_agents.agent_id = agents.agent_id AND favorite_agents.seller_id ="'.$filter['seller_id'].'"', 'left');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.user_type =', 'Agent');
			if ($filter['list']) {
				$this->db->where_in('accounts.id', $filter['list']);
			}

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
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_my_properties($user_id,$limit = null){
			$this->db->select('properties.*');
			$this->db->from('properties');
			$this->db->where_in('properties.status', array('Pending','Declined','Active','Contracted','Inactivated'));
			$this->db->where('properties.seller_id =', $user_id);
			if ($limit) {
				$this->db->limit($limit);
			}
			$this->db->order_by('properties.property_id ASC');

			$properties = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $properties;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_my_property($seller_id, $property_id){
	    $property = $this->db->select('*')->from('properties')->where("properties.seller_id =", $seller_id)->where("properties.property_id =", $property_id)->get()->row_array();
    	return $property;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_properties($status = 'Active'){
			$this->db->select('properties.*, sellers.first_name, sellers.last_name');
			$this->db->from('properties');
			$this->db->join('sellers', 'properties.seller_id = sellers.seller_id', 'left');
			$this->db->where('properties.status =', 'Active');
			$this->db->order_by('properties.property_id ASC');

			$properties = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $properties;
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


		public function get_new_messages($seller_id){
			$messages = $this->db->query('SELECT `messages`.message_date AS message_date, `messages`.message_text AS message_text, `messages`.agent_id AS agent_id, "message" AS msg_type, `agents`.`first_name`, `agents`.`last_name` FROM `messages` LEFT JOIN `agents` ON `messages`.`agent_id` = `agents`.`agent_id` WHERE `messages`.`msg_to` = "Seller" AND `messages`.`seller_id` = "'.$seller_id.'" AND `messages`.`status` = "Unread" UNION SELECT `tickets`.message_date AS message_date,`tickets`.message_text AS message_text,`tickets`.agent_id AS agent_id, "support" AS msg_type, `administrators`.`first_name`, `administrators`.`last_name` FROM `tickets` LEFT JOIN `administrators` ON `tickets`.`admin_id` = `administrators`.`admin_id` WHERE `tickets`.`msg_from` = "Admin" AND `tickets`.`seller_id` = "'.$seller_id.'" AND `tickets`.`status` = "Unread" ORDER BY `message_date` DESC')->result_array();

	    return $messages;
		}

		public function get_new_offer_news($seller_id){
			$this->db->select('proposals.*, agents.first_name, agents.last_name');
			$this->db->from('proposals');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->where('proposals.prop_to =', 'Seller');
			$this->db->where('proposals.seller_id =', $seller_id);
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
		public function get_proposals($seller_id){
			$this->db->select('proposals.*, agents.first_name, agents.last_name, agents.brokerage_address AS agent_address, agents.brokerage_unit AS agent_unit, agents.brokerage_city AS agent_city, agents.brokerage_state AS agent_state, agents.brokerage_zipcode AS agent_zipcode, agents.brokerage_phone AS agent_phone, agents.experience, agents.avatar_string, properties.type, properties.address, properties.unit, properties.city, properties.state, properties.zipcode, properties.status AS prop_status');
			$this->db->from('proposals');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('proposals.seller_id =', $seller_id);
			$this->db->where('proposals.commission_rate IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
			$this->db->where("proposals.prop_id NOT IN (SELECT main_id FROM proposals WHERE seller_id ='".$seller_id."' AND main_id IS NOT NULL)");
			$this->db->where_in('properties.status', array('Active','Contracted','Inactivated'));
			$this->db->order_by('proposals.property_id DESC');
			$this->db->order_by('proposals.prop_date DESC');

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
		public function get_proposal($seller_id, $proposal_id){
			$this->db->select('proposals.*, agents.first_name, agents.last_name, agents.brokerage_address AS agent_address, agents.brokerage_unit AS agent_unit, agents.brokerage_city AS agent_city, agents.brokerage_state AS agent_state, agents.brokerage_zipcode AS agent_zipcode, agents.brokerage_phone AS agent_phone, agents.experience, agents.avatar_string, properties.winning_fee, properties.type, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('proposals');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('proposals.seller_id =', $seller_id);
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
		public function check_newer_proposal($seller_id, $proposal_id){
			$this->db->select('proposals.*, agents.first_name, agents.last_name');
			$this->db->from('proposals');
			$this->db->join('agents', 'proposals.agent_id = agents.agent_id', 'left');
			$this->db->where('proposals.main_id =', $proposal_id);
			$this->db->where('proposals.seller_id =', $seller_id);
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
		public function get_agent_proposals($seller_id, $agent_id){
			$this->db->select('proposals.*, properties.default_image, properties.type, properties.address, properties.unit, properties.city, properties.state, properties.zipcode');
			$this->db->from('proposals');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->where('proposals.seller_id =', $seller_id);
			$this->db->where('proposals.agent_id =', $agent_id);
			$this->db->where('proposals.prop_from =', 'Agent');
			$this->db->where('proposals.commission_rate IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
			$this->db->where('proposals.contract_length IS NOT NULL', NULL);
			$this->db->where_in('properties.status', array('Active','Contracted','Inactivated'));

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
			$this->db->insert('proposals', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function mark_proposal_read($seller_id, $proposal_id){
			$this->db->set('status','Read');
			$this->db->set('seen_date', time());
			$this->db->where('proposals.prop_to =', 'Seller');
			$this->db->where('proposals.seller_id =', $seller_id);
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
		public function mark_messages_read($seller_id,$agent_id){
			$this->db->set('status','Read');
			$this->db->set('seen_date', time());
			$this->db->where('messages.seller_id',$seller_id);
			$this->db->where('messages.agent_id',$agent_id);
			$this->db->where('messages.msg_from', 'Agent');
			$this->db->update('messages');
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_message_list($seller_id){
			$this->db->select('MAX(`message_id`) AS `latestmsg`');
			$this->db->from('messages');
			$this->db->where('messages.seller_id =', $seller_id);
			$this->db->where('messages.msg_from =', 'Agent');
			$this->db->where_in('messages.status', array('Read','Unread'));
			$this->db->group_by("messages.agent_id");
			$max_values = $this->db->get_compiled_select();
			$this->db->reset_query();

			$this->db->select('messages.*, agents.first_name, agents.last_name');
			$this->db->from('messages');
			$this->db->join('agents', 'messages.agent_id = agents.agent_id', 'left');
			$this->db->where("messages.message_id IN ($max_values)", NULL, FALSE);
			$this->db->group_by("messages.agent_id");
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
		public function get_messages_of($seller_id, $agent_id){
			$this->db->select('messages.*, CONCAT(agents.first_name, " ", agents.last_name) AS agent, agents.avatar_string AS agent_image, sellers.avatar_string AS seller_image');
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
		public function get_state_cost($seller_id,$property_id){
			$property = $this->get_my_property($seller_id,$property_id);
	    $state_cost = $this->db->from('state_costs')->where("state =", $property['state'])->get()->row_array();
    	return $state_cost;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_aggrements($seller_id){
			$this->db->select('agreements.*, CONCAT(agents.first_name, " ", agents.last_name) AS agent, agents.avatar_string AS avatar_string, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state, proposals.commission_rate, proposals.contract_length');
			$this->db->from('agreements');
			$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->join('agents', 'agreements.agent_id = agents.agent_id', 'left');
			$this->db->where('agreements.seller_id =', $seller_id);
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
		public function get_aggrement($seller_id, $agree_id){
			$this->db->select('agreements.*, CONCAT(agents.first_name, " ", agents.last_name) AS agent, properties.property_id, properties.default_image, properties.type, properties.building_size, properties.address, properties.unit, properties.city, properties.state');
			$this->db->from('agreements');
			$this->db->join('proposals', 'agreements.prop_id = proposals.prop_id', 'left');
			$this->db->join('properties', 'proposals.property_id = properties.property_id', 'left');
			$this->db->join('agents', 'agreements.agent_id = agents.agent_id', 'left');
			$this->db->where('agreements.seller_id =', $seller_id);
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
			$this->db->where_not_in('agreements.agr_status', array('Canceled','Withdrawn','Expired'));
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
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_favorite_value($seller_id, $agent_id){
	    $save = $this->db->from('favorite_agents')->where('seller_id', $seller_id)->where('agent_id', $agent_id)->get()->row_array();
    	return $save;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_favorite_list($seller_id, $array = false){
	    $saves = $this->db->from('favorite_agents')->where('seller_id', $seller_id)->get()->result_array();
	    if ($array) {
	    	if ($saves) {
		    	foreach ($saves as $save) {
		    		$save_array[] = $save['agent_id'];
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
		public function favorite_agent($seller_id, $agent_id){
			$data['seller_id'] = $seller_id;
			$data['agent_id'] = $agent_id;
			$data['save_time'] = time();
			$this->db->insert('favorite_agents', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function unfavorite_agent($seller_id, $agent_id){
			if ($seller_id && $agent_id) {
				$this->db->delete('favorite_agents', array('seller_id' => $seller_id, 'agent_id' => $agent_id));
			}
      return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Get details of selected property account
	 *
	 * @param  integer $property_id ID of system property to return
	 * @return array Property details
	 */
		public function get_express_list($seller_id, $array = false){
	    $saves = $this->db->select('proposals.*')->from('proposals')->where('proposals.seller_id', $seller_id)->where_in('proposals.status', array('Read','Unread'))->get()->result_array();
	    if ($array) {
	    	if ($saves) {
		    	foreach ($saves as $save) {
		    		$save_array[] = $save['agent_id'];
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
		public function get_dealed_list($seller_id, $array = false){
	    $saves = $this->db->select('agreements.*')->from('agreements')->where('agreements.seller_id', $seller_id)->where('agreements.agr_status', 'Completed')->get()->result_array();
	    if ($array) {
	    	if ($saves) {
		    	foreach ($saves as $save) {
		    		$save_array[] = $save['agent_id'];
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
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_tutorial(){
	    $record = $this->db->from('tutorial_pages')->where("page_id =", 'seller')->get()->row_array();
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
		public function get_support_messages($seller_id){
			$this->db->set('tickets.status','Read');
			$this->db->set('tickets.seen_date',time());
			$this->db->where('tickets.seller_id =', $seller_id);
			$this->db->where('tickets.status =', 'Unread');
			$this->db->where('tickets.msg_from =', 'Admin');
			$this->db->update('tickets');
			$this->db->reset_query();

			$this->db->select('tickets.*, CONCAT(administrators.first_name, " ", administrators.last_name) AS admin, administrators.avatar_string AS admin_image, sellers.avatar_string AS seller_image');
			$this->db->from('tickets');
			$this->db->join('administrators', 'tickets.admin_id = administrators.admin_id', 'left');
			$this->db->join('sellers', 'tickets.seller_id = sellers.seller_id', 'left');
			$this->db->where('tickets.seller_id =', $seller_id);
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
		public function add_count($agent_id, $field_name, $calculation){
			$this->db->set($field_name, $field_name.$calculation, FALSE);
			$this->db->where('agents.agent_id =', $agent_id);
			$this->db->update('agents');
     	return ($this->db->affected_rows() >= 0 ) ? true : false;
		}

	/**
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function get_agent_licenses($agent_id){
			$this->db->from('licenses');
			$this->db->where('licenses.license_status =', 'Active');
			$this->db->where("agent_id =", $agent_id);
			$this->db->order_by('licenses.license_id DESC');

			$records = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $records;
		}

	/**
	 * Get details of selected agent account
	 *
	 * @param  integer $agent_id ID of system agent to return
	 * @return array Agent details
	 */
		public function get_terms_of_service(){
	    $record = $this->db->from('tos_pages')->where("user_type =", 'Seller')->get()->row_array();
    	return $record['page_content'];
		}
}
