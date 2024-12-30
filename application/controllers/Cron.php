<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * Cron Process controller
 *
 * The base controller which process cron actions of the Cortiam Web Application
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

class Cron extends CRTM_Controller {

	function __construct(){
		parent::__construct();
		set_time_limit(0);
		$this->load->database();
		$this->load->model('cron_model');
		$logdata = array('cron' => $this->router->fetch_method(), 'log_time' => date('F j Y g:i a'));
		$this->cron_model->add_log($logdata);
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
	public function check_expired_agreements(){
		$expireds = $this->cron_model->check_expired_agreements();
		if ($expireds) {
			foreach ($expireds as $expired) {
				$agr_data = array(
					'agr_status' => 'Expired'
				);
				$this->cron_model->edit_agreement($expired['agr_id'],$agr_data);
				$prop_data = array(
					'status' => 'Withdrawn'
				);
				$this->cron_model->edit_proposal($expired['prop_id'],$prop_data);
				$email_text_agent = '<h3 style="color:#4c525e;">Agreement Canceled</h3><p>The agreement you have for '.$expired['type'].' Property at '.$expired['city'].', '.$expired['state'].' address was canceled automatically by the system because both sides did not confirm within the 48 hour time period.</p>';
				$email_text_seller = '<h3 style="color:#4c525e;">Agreement Canceled</h3><p>The agreement you have for '.$expired['type'].' Property at '.$expired['city'].', '.$expired['state'].' address was canceled automatically by the system because your agent will not be moving forward with your property. Your property is now available for other agents to introduce themselves.</p>';
				$this->mailer->regular_email('Your Agreement Canceled', $email_text_seller, $expired['seller_email']);
				$this->mailer->regular_email('Your Agreement Canceled', $email_text_agent, $expired['agent_email']);
				$this->cron_model->add_notification($expired['seller_id'], 'Agreement Canceled', 'This agent will not be moving forward with your property. Your property at '.$expired['city'].', '.$expired['state'].' address is now available for other agents to introduce themselves.');
			}
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
	public function check_expired_invoices(){
		$invoices = $this->cron_model->check_expired_invoices();
		if ($invoices) {
			require_once(APPPATH.'/third_party/stripe/init.php');
			\Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
			foreach ($invoices as $invoice) {
				if ($invoice['stripe_id'] && $invoice['payment_id']) {
						if ($coupon = $this->cron_model->get_first_coupon($invoice['agent_id'])) {
							if ($coupon['coupon_type'] == 'Amount') {
								$discount = $coupon['coupon_amount'];
								$final_amount = $invoice['final_amount'] = ($invoice['real_amount'] - $discount);
							}else{
								$discount = ($invoice['final_amount']/100) * $coupon['coupon_amount'];
								$final_amount = $invoice['final_amount'] = ($invoice['real_amount'] - $discount);
							}
							if ($final_amount < 0) { $final_amount = $invoice['final_amount'] =  0.01;}
							$coupon_id = $coupon['use_id'];
						}else{
							$final_amount = $invoice['final_amount'] = $invoice['real_amount'];
						}
						$process_time = time();
						try {
						  $payment = \Stripe\PaymentIntent::create([
						    'amount' => ($final_amount*100),
						    'currency' => 'usd',
						    'customer' => $invoice['stripe_id'],
						    'payment_method' => $invoice['payment_id'],
						    'description' => $invoice['payment_desc'],
						    'off_session' => true,
						    'confirm' => true,
						  ]);
						 	$payment_data = array(
							 	'invoice_id' => $invoice['invoice_id'],
							 	'log_time' => $process_time,
							 	'log_status' => 'Success',
							 	'log_response' => serialize($payment),
						 	);
						 	$invoice_data = array(
							 	'payment_time' => $process_time,
							 	'try_time' => $process_time,
							 	'final_amount' => $final_amount,
							 	'pay_id' => $payment->id,
							 	'invoice_status' => 'Completed',
						 	);
						 	if($coupon){
						 		$invoice_data['coupon_id'] = $coupon_id;
						 		$invoice_data['discount_amount'] = $discount;
						 		$coupon_data = array(
						 			'coupon_used' => 'Yes',
						 			'used_on' => $process_time,
						 		);
						 		$this->cron_model->edit_coupon($coupon_id, $coupon_data);
						 	}
						 	$agent_details = $this->cron_model->get_agent($invoice['agent_id']);
					 		$update_date_to = (($agent_details['membership_due'])? strtotime("+1 month", $agent_details['membership_due']):strtotime("+1 month", $process_time));
							$used_expressions = $this->cron_model->get_offers_used($invoice['agent_id']);
						 	$additional_data = array(
						 	 'win_remain' => $agent_details['win_limit'],
							 'offer_remain' => ($agent_details['offer_limit'] - $used_expressions),
						 	 'membership_due' => $update_date_to,
						 	);
							$this->cron_model->edit_agent($invoice['agent_id'], $additional_data);
							$membership_fee = $this->cron_model->get_settings('membership_fee');

							$new_invoice['agent_id'] = $invoice['agent_id'];
							$new_invoice['try_time'] = ($update_date_to - 86400);
							$new_invoice['payment_desc'] = 'Cortiam Agent Monthly Subscription Price';
							$new_invoice['real_amount'] = (($agent_details['membership_fee'])? $agent_details['membership_fee']:$membership_fee['setting_value']);
							$this->cron_model->add_invoice($new_invoice);
						} catch (Exception $e) {
						 	$payment_data = array(
							 	'invoice_id' => $invoice['invoice_id'],
							 	'log_time' => $process_time,
							 	'log_status' => 'Failed',
							 	'log_response' => $e->getError()->message,
						 	);
						 	$invoice_data = array(
							 	'try_time' => strtotime("+2 HOUR", $process_time),
							 	'try_amount' => ($invoice['try_amount']+1),
							 	'invoice_status' => 'Failed',
						 	);
						}
					 	$this->cron_model->edit_invoice($invoice['invoice_id'], $invoice_data);
						$this->cron_model->add_payment($payment_data);
				}
			}
		}
	}

	public function check_expired_licences(){
//		30 days
		$search['start_day'] = strtotime('+15 days');
		$search['end_day'] = strtotime('+30 days');
		$search['timeline'] = '30 Days';
		$expireds = $this->cron_model->check_expired_licences($search);
		if ($expireds) {
			foreach ($expireds as $expired) {
				$agent_data = array(
					'license_expire_email' => '30 Days'
				);
				$this->cron_model->edit_agent($expired['agent_id'],$agent_data);
				$email_text = '<h3 style="color:#4c525e;">License Expiring Warning</h3><h4>Dear '.$expired['first_name'].' '.$expired['last_name'].',</h4><p>Your Real Estate Agent License will expire in a month ('.(date("m/d/Y",$expired['license_expire'])).'), please do not forget to renew your license details before it expires. Otherwise your account will be inactivated.</p>';
				$this->mailer->regular_email('License Expire Warning', $email_text, $expired['email']);
				$this->cron_model->add_notification($expired['agent_id'], 'License Expire Warning', 'Your Real Estate Agent License will expire in a month ('.(date("m/d/Y",$expired['license_expire'])).'), please do not forget to renew your license details before it expires.');
			}
		}
//		15 days
		$search = array();
		$search['start_day'] = strtotime('+1 days');
		$search['end_day'] = strtotime('+15 days');
		$search['timeline'] = '15 Days';
		$expireds = $this->cron_model->check_expired_licences($search);
		if ($expireds) {
			foreach ($expireds as $expired) {
				$agent_data = array(
					'license_expire_email' => '15 Days'
				);
				$this->cron_model->edit_agent($expired['agent_id'],$agent_data);
				$email_text = '<h3 style="color:#4c525e;">License Expiring Warning</h3><h4>Dear '.$expired['first_name'].' '.$expired['last_name'].',</h4><p>Your Real Estate Agent License will expire in 15 days ('.(date("m/d/Y",$expired['license_expire'])).'), please do not forget to renew your license details before it expires. Otherwise your account will be inactivated.</p>';
				$this->mailer->regular_email('License Expire Warning', $email_text, $expired['email']);
				$this->cron_model->add_notification($expired['agent_id'], 'License Expire Warning', 'Your Real Estate Agent License will expire in 15 days ('.(date("m/d/Y",$expired['license_expire'])).'), please do not forget to renew your license details before it expires.');
			}
		}
//		15 days
		$search = array();
		$search['start_day'] = time();
		$search['end_day'] = strtotime('+1 days');
		$search['timeline'] = '1 Day';
		$expireds = $this->cron_model->check_expired_licences($search);
		if ($expireds) {
			foreach ($expireds as $expired) {
				$agent_data = array(
					'license_expire_email' => '1 Day'
				);
				$this->cron_model->edit_agent($expired['agent_id'],$agent_data);
				$email_text = '<h3 style="color:#4c525e;">License Expiring Warning</h3><h4>Dear '.$expired['first_name'].' '.$expired['last_name'].',</h4><p>Your Real Estate Agent License will expire tomorrow ('.(date("m/d/Y",$expired['license_expire'])).'), please do not forget to renew your license details before it expires. Otherwise your account will be inactivated.</p>';
				$this->mailer->regular_email('License Expire Warning', $email_text, $expired['email']);
				$this->cron_model->add_notification($expired['agent_id'], 'License Expire Warning', 'Your Real Estate Agent License will expire tomorrow ('.(date("m/d/Y",$expired['license_expire'])).'), please do not forget to renew your license details before it expires.');
			}
		}
//		Already expired
		$search = array();
		$search['end_day'] = time();
		$search['approval'] = array('Completed','Pending');
		$expireds = $this->cron_model->check_expired_licences($search);
				print_r($expireds);
		if ($expireds) {
			$admin_emails = $this->cron_model->get_notified(50);
			foreach ($expireds as $expired) {
				$licence_data = array(
					'license_status' => 'Expired'
				);
				$this->cron_model->edit_license($expired['license_id'], $licence_data);
				if ($this->cron_model->check_active_license($expired['agent_id'])) {
					$this->ion_auth->update($expired['agent_id'], array('approval' => 'Denied'));
					$msg_data = array(
						'admin_id' => 1,
						'agent_id' => $expired['agent_id'],
						'type' => 'Admin',
						'message_text' => 'Your Real Estate Agent License expired ('.(date("m/d/Y",$expired['license_expire'])).') and your account has been inactivated. Please renew and update your license information. Your account will be put in a que to be reviewed and approved by our team so you can begin using your account again.',
						'message_date' => time(),
					);
				}else{
					$msg_data = array(
						'admin_id' => 1,
						'agent_id' => $expired['agent_id'],
						'type' => 'Admin',
						'message_text' => 'Your real estate agent license for '.$expired['license_state'].' has expired on ('.(date("m/d/Y",$expired['license_expire'])).'). Please update your license information with your new license details before you continue using our system. After you update your license information, the details will need to be approved by the Cortiam administrators and your account will be enabled shortly after.',
						'message_date' => time(),
					);
				}
				$this->cron_model->add_approval($msg_data);
				$clear_proposals = $this->cron_model->get_agent_proposals($expired['agent_id']);
				if ($clear_proposals) {
					foreach ($clear_proposals as $clear_proposal) {
						if ($clear_proposal['prop_from'] == 'Seller') {
							$update_prop = array('status' => 'Widthdrawn');
						}else{
							$update_prop = array('status' => 'Declined');
						}
						$this->cron_model->edit_proposal($clear_proposal['prop_id'], $update_prop);
						if ($clear_proposal['prop_from'] == 'Agent') {
							$this->cron_model->set_extra_winexp($clear_proposal['agent_id'], 1, 'off');
						}

						$user_email_text = '<h3 style="color:#4c525e;">PROPOSAL WIDTHDRAWN BY SYSTEM</h3><h4 style="color:#848994;">Dear '.$clear_proposal['seller'].'</h4><p>We are sorry to tell you that proposal between you and real estate agent '.$clear_proposal['agent'].' for '.$clear_proposal['type'].' property at '.$clear_proposal['city'].', '.$clear_proposal['state'].' automatically widthdrawn, because real estate agents license expired and not renewed in time.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p>';
						$this->cron_model->add_notification($clear_proposal['seller_id'], 'Proposal Widthdrawn By System', 'We are sorry to tell you that proposal between you and real estate agent '.$clear_proposal['agent'].' for '.$clear_proposal['type'].' property at '.$clear_proposal['city'].', '.$clear_proposal['state'].' automatically widthdrawn, because real estate agents license expired and not renewed in time.');
					}
				}
				$email_text = '<h3 style="color:#4c525e;">YOUR LICENSE EXPIRED!</h3><h4>Dear '.$expired['first_name'].' '.$expired['last_name'].',</h4><p>Your Real Estate Agent License expired ('.(date("m/d/Y",$expired['license_expire'])).') Please renew and update your license information. Your account will be put in a que to be reviewed and approved by our team so you can begin using your account again.</p>';
				$this->mailer->regular_email('Your License Expired', $email_text, $expired['email']);
				$this->cron_model->add_notification($admin_emails, 'Real Estate Agent License Expired', 'Real Estate Agent '.$expired['first_name'].' '.$expired['last_name'].'\'s license expired.', 'agent_review', $expired['agent_id']);
			}
		}
	}

	public function check_uninterested_properties(){
		$properties = $this->cron_model->check_uninterested_properties();
		if ($properties) {
			foreach ($properties as $property) {
				$prop_data = array(
					'no_interest_email' => 'Yes'
				);
				$this->cron_model->edit_property($property['property_id'],$prop_data);
				$email_text = '<h3 style="color:#4c525e;">SUGGESTIONS FOR YOUR LISTING</h3><h4 style="color:#848994;">Dear '.$property['seller'].'</h4><p>We are sorry that your '.$property['type'].' Property at '.(($property['unit'])? $property['unit'].' ':'').$property['address'].' '.$property['city'].', '.$property['state'].', '.$property['zipcode'].' address did not get any new proposals for the last 10 days. We have some suggestions for you.</p>';
				$this->mailer->regular_email('About Your Property', $email_text, $property['seller_email']);
			}
		}
	}

	public function check_new_properties(){
		$agents = $this->cron_model->get_active_agents();
		if ($agents) {
			foreach ($agents as $agent) {
				if ($agent['license_states']) {
					$properties = $this->cron_model->check_new_properties(array('state' => explode("|",$agent['license_states'])));
					if ($properties) {
						$count = count($properties);
						if ($count == 1) {
							$email_text = '<h3 style="color:#4c525e;">NEW PROPERTY IN YOUR AREA</h3><h4 style="color:#848994;">Dear '.$agent['first_name'].' '.$agent['last_name'].'</h4><p>There is a new property in your licensed area. For more information please login to Cortiam to check out the new property.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p></p>';
							$this->mailer->regular_email('New Property In Your Area', $email_text, $agent['email']);
						}else{
							$email_text = '<h3 style="color:#4c525e;">NEW PROPERTIES IN YOUR AREA</h3><h4 style="color:#848994;">Dear '.$agent['first_name'].' '.$agent['last_name'].'</h4><p>There are '.$count.' new properties in your licensed area. For more information please login to Cortiam to check out the new properties.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p></p>';
							$this->mailer->regular_email('New Properties In Your Area', $email_text, $agent['email']);
						}
					}
				}
			}
		}
	}

	public function check_expired_credit_cards(){
		$today_cards = $this->cron_model->get_expired_credit_cards();
		if ($today_cards) {
			foreach ($today_cards as $today_card) {
				$email_text = '<h3 style="color:#4c525e;">CREDIT CARD EXPIRED</h3><h4 style="color:#848994;">Dear '.$today_card['first_name'].' '.$today_card['last_name'].',</h4><p>Your credit card will be expired and removed today. Please be sure that you are updated payment information with your new credit card details. Otherwise your account will be deactivated once the payment period is over.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p></p>';
				$this->cron_model->delete_credit_card($today_card['card_id']);
				$this->mailer->regular_email('Credit Card Expired', $email_text, $today_card['email']);
			}
		}

		$future_cards = $this->cron_model->get_expired_credit_cards(array('start' => 15, 'end' => 16));
		if ($future_cards) {
			foreach ($future_cards as $future_card) {
				$email_text = '<h3 style="color:#4c525e;">CREDIT CARD EXPIRES SOON</h3><h4 style="color:#848994;">Dear '.$future_card['first_name'].' '.$future_card['last_name'].',</h4><p>Your credit card will be expired on '.(date("m/d/Y",$future_card['expire_date'])).'. Please renew and update your payment information, otherwise your account will be deactivated once the payment period is over.</p><p style="text-align:center;"><a href="'.base_url('login').'" style="border-radius:5px;padding:10px 30px;background:#f17221;color:#ffffff;text-align:center;text-transform:uppercase;font-weight:bold;margin:10px 0px;display:inline-block;text-decoration:none;" target="_blank" class="loginlink">Login to Cortiam</a></p></p>';
				$this->mailer->regular_email('Credit Card Expires Soon', $email_text, $future_card['email']);
			}
		}
	}


}