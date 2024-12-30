<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Frontend model
 *
 * The system model with a series of CRUD functions (powered by CI's query builder), validation-in-model support, event callbacks and more for frontend pages.
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
class Frontend_model extends CI_Model {

		public function __construct(){
    		$this->load->database();
		}

	/**
	 * Add new seller account
	 *
	 * @param  array 	 $data Details of seller account
	 * @return boolean true|false
	 */
		public function add_token($data){
			$this->db->insert('zoho_tokens', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new seller account
	 *
	 * @param  array 	 $data Details of seller account
	 * @return boolean true|false
	 */
		public function get_token($time){
			$this->db->select('*');
			$this->db->from('zoho_tokens');
			$this->db->where('token_time >', $time);
			if ($token = $this->db->get()->row_array()) {
				return $token;
			}else{
				$this->db->delete('zoho_tokens', array('token_time <' => $time));
				return false;
			}
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
		public function locate_agent($latitude, $longitude){
			$this->db->select('agents.agent_id, CONCAT(agents.first_name, " ", agents.last_name) AS agent, agents.avatar_string AS agent_image, agents.brokerage_name, ( 3959 * acos( cos( radians('.$latitude.') ) * cos( radians( agents.latitude ) ) * cos( radians( agents.longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin(radians(agents.latitude)) ) ) AS distance, accounts.active AS elligible, accounts.approval AS isapproved');
			$this->db->from('agents');
			$this->db->join('accounts', 'agents.agent_id = accounts.id', 'left');
			$this->db->having('elligible =', 1);
			$this->db->having('isapproved =', 'Completed');
			$this->db->having('distance <',30);
			$this->db->order_by('agents.agent_id ASC');

			$agents = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $agents;
		}

	/**
	 * Add new property account
	 *
	 * @param  array 	 $data Details of property account
	 * @return boolean true|false
	 */
		public function find_agent_by_names($filter){
			$this->db->select('accounts.*, agents.agent_id, CONCAT(agents.first_name, " ", agents.last_name) AS agent, agents.avatar_string AS agent_image, agents.brokerage_name, accounts.active AS elligible, accounts.approval AS isapproved');
			$this->db->from('accounts');
			$this->db->join('agents', 'agents.agent_id = accounts.id', 'left');
			$this->db->join('licenses', 'licenses.agent_id = agents.agent_id', 'left');
			$this->db->where('accounts.active =', 1);
			$this->db->where('accounts.approval =', 'Completed');
			if ($filter['state']) {
				$this->db->where('licenses.license_state =', $filter['state']);
			}
			if ($filter['city']) {
				$this->db->where('agents.city =', $filter['city']);
			}
			$this->db->where('accounts.user_type =', 'Agent');
			$this->db->order_by('accounts.id ASC');
			$agents = $this->db->get()->result_array();
//  		echo $this->db->last_query();exit();
	    return $agents;
		}

	/**
	 * Add new agent account
	 *
	 * @param  array 	 $data Details of agent account
	 * @return boolean true|false
	 */
		public function join_our_team($data){
			$this->db->insert('join_our_team', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	/**
	 * Add new agent account
	 *
	 * @param  array 	 $data Details of agent account
	 * @return boolean true|false
	 */
		public function contact_request($data){
			$this->db->insert('contact_requests', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
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
	 * Lists of clients with details
	 *
	 * @return array List of clients with details
	 */
		public function check_state($state){
			$this->db->from('state_costs');
			$this->db->where('state_costs.signup =', 'Enabled');
			$this->db->where("state_costs.state = ", $state);

			if ($record = $this->db->get()->row_array()) {
				return true;
			}else{
				return false;
			}
		}


	/**
	 * Add new agent account
	 *
	 * @param  array 	 $data Details of agent account
	 * @return boolean true|false
	 */
		public function waiting_user($data){
			$this->db->insert('waiting_users', $data);
      return ($this->db->affected_rows() != 1) ? false : $this->db->insert_id();
		}

	public function all_membership_plans()
	{	
		$this->db->from('member_ship_plans');
		return $this->db->get()->result_array();
	}

	public function find_email($request)
	{	
		$this->db->from('accounts');
		$this->db->where("email = ", $request['email']);
		if ($record = $this->db->get()->row_array()) {
			return "true";
		}else{
			return "false";
		}
	}

	public function set_token_token($email, $token)
	{
		// $this->db->query("UPDATE accounts SET  email_verification_token = ".$token." WHERE email = '".$email."'");

		$this->db->set('email_verification_token', $token);
		$this->db->where('email', $email);
		$this->db->update('accounts');
     	return ($this->db->affected_rows() >= 0 ) ? true : false;
	}


	
}
