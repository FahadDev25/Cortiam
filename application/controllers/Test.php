<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use GuzzleHttp;
class Test extends CRTM_Controller {

	function __construct(){
		parent::__construct();
    }

    public function testing()
    {
        require_once('vendor/autoload.php');

        $CLIENT_ID     = $this->config->item("zoom_sdk");
        $CLIENT_SECRET = $this->config->item("zoom_secret");
        $REDIRECT_URI  = $this->config->item("REDIRECT_URI");

        try {
                $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
                $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode($CLIENT_ID.':'.$CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "authorization_code",
                    "code" => $_GET['code'],
                    "redirect_uri" => $REDIRECT_URI
                ],
            ]);
          
            $token = json_decode($response->getBody()->getContents(), true);
          
            // $db = new DB();
            // $db->update_access_token(json_encode($token));
            echo "Access token inserted successfully.";
        } catch(Exception $e) {
            echo $e->getMessage();
        }


    }

    public function zoom()
    {
        return "Data";
    }
 }
?>