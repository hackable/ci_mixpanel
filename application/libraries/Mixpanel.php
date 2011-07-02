<?php

    /**
     * @author Hackable https://github.com/hackable/
     * @link https://github.com/hackable/ci_mixpanel
     * @package CodeIgniter Amazon MTurk Library
     * @version 1.0
     *
     * Creative Commons Attribution-ShareAlike 3.0 Unported License
     * http://creativecommons.org/licenses/by-sa/3.0/
     */
class Mixpanel
{
    private $endpoint = 'http://api.mixpanel.com/';
    private $_ci;
	private $token; 
	private $campaign;
	private $distinct_id;
	private $body;
	private $type = 'html';
	private $redirect_host;
	private $shorten_urls = FALSE;
	private $click_tracking = TRUE;
	private $tracking_pixel = TRUE;


    public function __construct()
    {
    	
      log_message('debug', 'Mixpanel Email Anlytics Class Initialized');

	  $this->_ci =& get_instance();
	  $this->_ci->load->library('rest');
	  $this->_ci->load->config('mixpanel');
      $this->_ci->rest->initialize(array('server' => $this->endpoint));
    }
	


   	/**
	 * Sets the campaign
	 * @param 	string 	campaign
	 * @return 	mixed 
	 */
	public function campaign($campaign)
	{	
		$this->campaign = $campaign;
		return $this;
	}
	
   	/**
	 * Sets the distinct_id
	 * @param 	string 	distinct_id
	 * @return 	mixed 
	 */
	public function distinct_id($distinct_id)
	{	
		$this->distinct_id = $distinct_id;
		return $this;
	}	
   	/**
	 * Sets the body
	 * @param 	string 	body
	 * @return 	mixed 
	 */
	public function body($body)
	{	
		$this->body = $body;
		return $this;
	}	
		
	
   	/**
	 * Sets the type
	 * @param 	string  type
	 * @return 	mixed 
	 */
	public function type($type)
	{
			
		$this->type = $type;
		return $this;
	}	
	
   	/**
	 * Sets the redirect_host
	 * @param 	string 	redirect_host
	 * @return 	boolean
	 */
	public function redirect_host($redirect_host)
	{
			
		$this->redirect_host = $redirect_host;
		return $this;
	}	
						
		
   	/**
	 * Sets the shorten_urls
	 * @param 	string 	shorten_urls
	 * @return 	boolean 
	 */
	public function shorten_urls($shorten_urls)
	{
			
		$this->shorten_urls = $shorten_urls;
		return $this;
	}	
	
	
   	/**
	 * Sets the click_tracking
	 * @param 	string 	click_tracking
	 * @return 	boolean 
	 */
	public function click_tracking($click_tracking)
	{
			
		$this->click_tracking = $click_tracking;
		return $this;
	}	
		
	
	
	
	
	
	
	
	
	
	
    public function add_tracking()
    {
    	$this->token = $this->_ci->config->item('mixpanel_token');

        $response =  $this->_ci->rest->post('email',
        array(
        'token'          => $this->token,
        'campaign'       => $this->campaign,
        'distinct_id'    => $this->distinct_id,
		'body'           => $this->body,
		'type'           => $this->type,
		'redirect_host'  => $this->redirect_host,
		'shorten_urls'   => $this->shorten_urls,
		'click_tracking' => $this->click_tracking,
		'tracking_pixel' => $this->tracking_pixel,
		)
		);
		
        return $response;
    }
	
	
public function track($event, $properties=array()) {
		
$params = array(
'event' => $event,
'properties' => $properties
);
$this->token = $this->_ci->config->item('mixpanel_token');

$params['properties']['token'] = $this->token;


//$url = $this->host . 'track/?data=' . base64_encode(json_encode($params));
//you still need to run as a background process


$response = $this->_ci->rest->get('track/',
array(
'data' => base64_encode(json_encode($params)),
'ip' => '1'	
)
);

$this->_ci->rest->debug();


return $response;

}
	
	
	
	
	
}



/*
$api = new MixpanelEmail(
    'YOUR TOKEN HERE',
    'YOUR CAMPAIGN HERE'
);

$example = <<<END
<p>Hi User,</p>
<p>This is a sample email from <a href="http://example.com/">example.com</a>.</p>
<p>Each anchor link will be replaced with a tracking redirect when filtered with
<a href="http://mixpanel.com/">Mixpanel's</a> email tracking service.</p>
--<br>
Signature<br>
END;

$rewritten = $api->add_tracking('test_user@example.com', $example);
print($rewritten);
*/

?>
