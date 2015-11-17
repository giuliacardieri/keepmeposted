<?php 
 
class MY_Controller extends CI_Controller {
 
 	public function __construct()
   {
        parent::__construct();

        $logged = $this->session->userdata("logged");

        if ($logged != 1) 
            redirect(base_url('index.php/login'));				
   }
}