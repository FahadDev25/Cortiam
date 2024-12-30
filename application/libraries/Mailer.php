<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Mailer {
	private $CI;

	public function __construct(){
    $this->CI =& get_instance();
//    $this->CI->load->library('email');
	}

	public function regular_email($title, $html_body, $emails){
		require_once(APPPATH.'/third_party/sendgrid/sendgrid-php.php');
		$email = new \SendGrid\Mail\Mail();
		$email->setFrom("noreply@cortiam.com", "Cortiam");
		$email->setSubject($title);
		$html_wrapped = $this->CI->load->view('email/simple', array('htmlbody' => $html_body), true);
		if (is_array($emails)) {
			foreach ($emails as $key => $value) {
				$new_mails[$value] = '';
			}
			$email->addTos($new_mails);
		}else{
			$email->addTo($emails, "");
		}
		$email->addContent("text/plain", "Your mail client does not support html email. Please use a different mail client which support html email to see content.");
		$email->addContent(
		    "text/html", $html_wrapped
		);
		$sendgrid = new \SendGrid($this->CI->config->item('sendgrid_key'));
		try{
    	$response = $sendgrid->send($email);
		}catch (Exception $e) {
			log_message('error', 'Caught email exception: '. $e->getMessage());
		}
	}


	public function old_regular_email($title, $html_body, $emails){
//		$this->CI->email->from('cortiam@webbteam.ca', 'Cortiam');
//		$this->CI->email->to($emails);
//		$this->CI->email->subject($title);
//		$this->CI->email->message($html_wrapped);
//		echo $html_wrapped;
//		$this->CI->email->set_alt_message(strip_tags($html_body));
//		$this->CI->email->send();
//		$this->CI->email->print_debugger(array('headers'));
	}
}