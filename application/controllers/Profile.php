<?php
class Profile extends CI_Controller {
    
    public function index()
    {
        $this->load->view('templates/head');
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('profile');
        $this->load->view('templates/footer');
    }
    
    public function edit()
    {
        $this->load->view('templates/head');
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('edit_profile');
        $this->load->view('templates/footer');
    }
}