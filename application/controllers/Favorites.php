<?php
class Favorites extends CI_Controller {
    
    public function index()
    {
        $data['title'] = 'Favorites';
        
        $this->load->view('templates/head', $data);
        $this->load->view('templates/header');
        $this->load->view('templates/nav');
        $this->load->view('favorites');
        $this->load->view('templates/footer');
    }

}