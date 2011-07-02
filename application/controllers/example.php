<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller {


      
    public function __construct()
    {
      $this->load->library('mixpanel');
    }
			

     
      public function email_tracking()
     {

       $this->load->library('email');
       $subject = "Hello World";
       $to = "someone@example.com";
       $message = "Hello World I'm Testing Mixpanel Library";

$this->email->from('your@example.com', 'Your Name');
$this->email->to($to); 
/*This is campaign name */
$this->mixpanel->campaign($subject);
/* This is distict id used to identify each and every email */
$this->mixpanel->distinct_id($to);
/* Put your email message here */
$this->mixpanel->body($message);
/* New email message with added tags */
$message = $this->mixpanel->add_tracking();
$this->email->subject($subject);
$this->email->message($message);	

$this->email->send();

echo $this->email->print_debugger();


     }


      public function event_tracking()
     {
        /* If it returns 0 then failure and 1 then success */          
  	echo $this->mixpanel->track('purchase',array('item'=>'candy', 'type'=>'snack', 'ip'=> $this->input->ip_address()));


     }


}

/* End of file example.php */
/* Location: ./application/controllers/example.php */
