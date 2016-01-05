<?php
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('postcards_model');
    }
    
    public function index($error=NULL)
    {
        $data['error'] = NULL;
        switch ($error) {
            case 1: $data['error'] = "Email already used in an account"; break;
            case 2: $data['error'] = "Username already in use"; break;
            case 3: $data['error'] = "Email and username already used in an account"; break;
            case 4: $data['error'] = "Username/password does not match!"; break;
        }
        $data['title'] = 'Login/Signup';
        $data['countries'] = $this->postcards_model->get_countries();
        
        $logged = $this->session->userdata("logged");

        if ($logged != 1){
            $this->load->view('templates/head', $data);
            $this->load->view('templates/modal-login');
            $this->load->view('login', $data);
        }
    }      
    
    public function signup()
    {   
        $data = array(
            'fname' => $this->input->post('fname'), 
            'lname' => $this->input->post('lname'),
            'username' => $this->input->post('username'),
            'email' => $this->input->post('email'),
            'country' => $this->input->post('country'),
            'password' => sha1($this->input->post('password')),
            'join_date' => date('Y-m-d'),
            'photo' => 'user.png'
        );
        
        $email = $this->login_model->validate_email($data);
        $username_valid = $this->login_model->validate_username($data);
        $username = $this->input->post('username');
        
        if ($email && $username_valid) { 
            $query = $this->login_model->new_user($data);
            $data = array(
                'username' => $this->input->post('username'),
                'user_id' => $this->postcards_model->get_element('id', array('username' => $username), 'user')['id'],
                'logged' => true
            );
            
            $this->session->set_userdata($data);
            redirect(base_url());
            
        } else{
            $error = 0;
            if (!$email)
                $error = 1;
            if (!$username_valid)
                $error = 2;
            if (!$username_valid && !$email)
                $error = 3;
        }
        redirect('login/index/' . $error);
    } 
    
    public function login()
    {   
        $data = array(
            'username' => $this->input->post('username'), 
            'password' => sha1($this->input->post('password'))
        );
        $valid = $this->login_model->validate_login($data);
        
        if ($valid) { 
            $data = array(
                'username' => $this->input->post('username'),
                'user_id' => $this->postcards_model->get_element('id', array('username' => $data['username']), 'user')['id'],
                'logged' => true
            );
            
            $this->session->set_userdata($data);
            redirect(base_url());
        } else {
			$error = 4;
		}
        redirect('login/' . $error);
    }
    
	public function logout()
    {   
        $this->session->sess_destroy();
        redirect(base_url());		
	}
}