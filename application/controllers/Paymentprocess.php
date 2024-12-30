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

class Paymentprocess extends CRTM_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->library("session");
		$this->load->helper('url');

		log_message('error', "Payment contructor");
	 }
	

	 public function payment()
	 {
		log_message('error', "payment func");
		 require_once('vendor/stripe/init.php');

		 echo '<pre>';
		 	print_r($this->config->item('stripe_secret'));
		exit;

	 
		 \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
	  
		 \Stripe\Charge::create ([
				 "amount" => 100 * 120,
				 "currency" => "inr",
				 "source" => $this->input->post('stripeToken'),
				 "description" => "Dummy stripe payment." 
		 ]);
			 
		 $this->session->set_flashdata('success', 'Payment has been successful.');
			  
		 redirect('/make-stripe-payment', 'refresh');
	 }
}
?>