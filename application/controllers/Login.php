<?php
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('login_model');
        $this->load->model('postcards_model');
    }
    
    public function index()
    {
        $data['title'] = 'Login/Signup';
        $data['error'] = '';
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
            'password' => $this->input->post('password'),
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
            $data['error'] = '';
            if (!$email){
                $data['error'] = "Email already used in an account";
            }
            if (!$username_valid){
                $data['error'] = $data['error'] . ' ' . "Username already in use";
            }
        }
        $this->load->view("login", $data);
    } 
    
    public function login()
    {   
        $data = array(
            'username' => $this->input->post('username'), 
            'password' => $this->input->post('password')
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
			$data['error'] = "Username/password combination does not match!";
			$this->load->view("login", $data);
		}
    }
    
	public function logout()
    {   
        $this->session->sess_destroy();
        redirect(base_url());		
	}
}